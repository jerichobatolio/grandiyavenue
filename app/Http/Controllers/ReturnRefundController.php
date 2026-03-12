<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnRefund;
use App\Models\EventBooking;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReturnRefundController extends Controller
{
    /**
     * Show return/refund request form
     */
    public function create(Request $request)
    {
        $type = $request->type; // 'event_booking' or 'order'
        $id = $request->id;
        
        $refundable = null;
        $refundAmount = 0;
        
        if ($type === 'event_booking') {
            $refundable = EventBooking::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            // Calculate refund amount based on payment
            $refundAmount = $refundable->amount_paid ?? $refundable->down_payment_amount;
            
            // Check if booking is eligible for refund
            if (!in_array($refundable->status, ['Paid', 'Pending'])) {
                return redirect()->back()->with('error', 'This booking is not eligible for a refund.');
            }
            
            // Check if there's already an active return/refund request
            if ($refundable->hasActiveReturnRefund()) {
                return redirect()->back()->with('error', 'You already have a pending return/refund request for this booking.');
            }
        } elseif ($type === 'order') {
            $refundable = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            // Calculate refund amount
            $refundAmount = (float) $refundable->price * (int) $refundable->quantity;

            // Check if there's already an active return/refund request
            if ($refundable->hasActiveReturnRefund()) {
                return redirect()->back()->with('error', 'You already have a pending return/refund request for this order.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid request type.');
        }
        
        return view('home.request_return_refund', compact('refundable', 'type', 'refundAmount'));
    }

    /**
     * Store return/refund request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:event_booking,order',
            'refundable_id' => 'required|integer',
            'refund_type' => 'required|in:return,refund',
            'refund_amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Get the refundable model
            if ($request->type === 'event_booking') {
                $refundable = EventBooking::where('id', $request->refundable_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
            } else {
                $refundable = Order::where('id', $request->refundable_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
            }

            // Check if there's already an active return/refund request
            if ($refundable->hasActiveReturnRefund()) {
                return redirect()->back()->with('error', 'You already have a pending return/refund request for this item.');
            }

            // Create return/refund request
            $returnRefund = ReturnRefund::create([
                'user_id' => Auth::id(),
                'refundable_type' => get_class($refundable),
                'refundable_id' => $refundable->id,
                'type' => $request->refund_type,
                'status' => 'pending',
                'refund_amount' => $request->refund_amount,
                'reason' => $request->reason,
            ]);

            // Create notification for admin
            $adminUsers = \App\Models\User::where('id', '!=', Auth::id())->get();
            foreach ($adminUsers as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'return_refund_request',
                    'title' => 'New Return/Refund Request',
                    'message' => Auth::user()->name . ' has requested a ' . $request->refund_type . ' for ₱' . number_format($request->refund_amount, 2),
                    'is_read' => false,
                    'data' => [
                        'return_refund_id' => $returnRefund->id,
                        'type' => $request->type,
                        'refundable_id' => $refundable->id,
                        'amount' => $request->refund_amount,
                    ]
                ]);
            }

            // Create notification for customer
            Notification::create([
                'user_id' => Auth::id(),
                'type' => 'return_refund_request',
                'title' => 'Return/Refund Request Submitted',
                'message' => 'Your return/refund request has been submitted and is pending admin review.',
                'is_read' => false,
                'data' => [
                    'return_refund_id' => $returnRefund->id,
                ]
            ]);

            return redirect()->route('return_refunds.index')
                ->with('success', 'Return/refund request submitted successfully! We will review your request soon.');
        } catch (\Exception $e) {
            \Log::error('Error creating return/refund request: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while submitting your request. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display user's return/refund requests and eligible items
     */
    public function index()
    {
        try {
            $returnRefunds = ReturnRefund::where('user_id', Auth::id())
                ->with(['refundable'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Get eligible orders for return/refund
            $eligibleOrders = collect();
            try {
                $eligibleOrders = Order::where('user_id', Auth::id())
                    ->whereIn('delivery_status', ['In Progress', 'On The Way', 'Delivered'])
                    ->whereDoesntHave('returnRefunds', function($query) {
                        $query->whereIn('status', ['pending', 'approved']);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->filter(function($order) {
                        try {
                            return !$order->hasActiveReturnRefund();
                        } catch (\Exception $e) {
                            return true; // If check fails, include it
                        }
                    })
                    ->map(function($order) {
                        $order->refund_amount = (float) $order->price * (int) $order->quantity;
                        $order->item_type = 'order';
                        return $order;
                    });
            } catch (\Exception $e) {
                \Log::error('Error fetching eligible orders: ' . $e->getMessage());
                $eligibleOrders = collect();
            }

            // Get eligible event bookings for return/refund
            $eligibleEventBookings = collect();
            try {
                $eligibleEventBookings = EventBooking::where('user_id', Auth::id())
                    ->whereIn('status', ['Paid', 'Pending'])
                    ->whereDoesntHave('returnRefunds', function($query) {
                        $query->whereIn('status', ['pending', 'approved']);
                    })
                    ->with('eventType', 'venueType', 'packageInclusion')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->filter(function($booking) {
                        try {
                            return !$booking->hasActiveReturnRefund();
                        } catch (\Exception $e) {
                            return true; // If check fails, include it
                        }
                    })
                    ->map(function($booking) {
                        $booking->refund_amount = $booking->amount_paid ?? $booking->down_payment_amount ?? 0;
                        $booking->item_type = 'event_booking';
                        return $booking;
                    });
            } catch (\Exception $e) {
                \Log::error('Error fetching eligible event bookings: ' . $e->getMessage());
                $eligibleEventBookings = collect();
            }

            // Fetch notifications
            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $notifCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return view('home.my_return_refunds', compact(
                'returnRefunds', 
                'eligibleOrders', 
                'eligibleEventBookings', 
                'notifications', 
                'notifCount'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in ReturnRefundController@index: ' . $e->getMessage());
            
            // Return view with empty collections if there's an error
            return view('home.my_return_refunds', [
                'returnRefunds' => collect(),
                'eligibleOrders' => collect(),
                'eligibleEventBookings' => collect(),
                'notifications' => collect(),
                'notifCount' => 0,
            ])->with('error', 'An error occurred while loading the page. Please try again.');
        }
    }

    /**
     * Show return/refund request details
     */
    public function show($id)
    {
        $returnRefund = ReturnRefund::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['refundable'])
            ->firstOrFail();

        // Fetch notifications
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $notifCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('home.return_refund_details', compact('returnRefund', 'notifications', 'notifCount'));
    }

    /**
     * Cancel return/refund request (only if pending)
     */
    public function cancel($id)
    {
        $returnRefund = ReturnRefund::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($returnRefund->status !== 'pending') {
            return redirect()->back()->with('error', 'You can only cancel pending requests.');
        }

        $returnRefund->update(['status' => 'cancelled']);

        return redirect()->route('return_refunds.index')
            ->with('success', 'Return/refund request cancelled successfully.');
    }
}
