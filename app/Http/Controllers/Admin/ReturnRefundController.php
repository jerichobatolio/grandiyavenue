<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnRefund;
use App\Models\EventBooking;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class ReturnRefundController extends Controller
{
    /**
     * Display all return/refund requests
     */
    public function index()
    {
        $returnRefunds = ReturnRefund::with(['user', 'refundable'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by status for stats
        $stats = [
            'total' => $returnRefunds->count(),
            'pending' => $returnRefunds->where('status', 'pending')->count(),
            'approved' => $returnRefunds->where('status', 'approved')->count(),
            'rejected' => $returnRefunds->where('status', 'rejected')->count(),
            'refunded' => $returnRefunds->where('status', 'refunded')->count(),
            'total_amount' => $returnRefunds->where('status', '!=', 'rejected')->where('status', '!=', 'cancelled')->sum('refund_amount'),
        ];

        return view('admin.return_refunds', compact('returnRefunds', 'stats'));
    }

    /**
     * Show return/refund request details
     */
    public function show($id)
    {
        $returnRefund = ReturnRefund::with(['user', 'refundable'])
            ->findOrFail($id);

        return view('admin.return_refund_details', compact('returnRefund'));
    }

    /**
     * Approve return/refund request
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'nullable|string|max:1000',
            'approval_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('return_refund_modal', 'approve');
        }

        $returnRefund = ReturnRefund::with(['user', 'refundable'])->findOrFail($id);

        if ($returnRefund->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending requests can be approved.');
        }

        $approvalImagePath = $returnRefund->approval_image_path;

        if ($request->hasFile('approval_image')) {
            $approvalImagePath = $request->file('approval_image')->store('return_refunds/approvals', 'public');
        }

        $returnRefund->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'approval_image_path' => $approvalImagePath,
        ]);

        // Create notification for customer
        Notification::create([
            'user_id' => $returnRefund->user_id,
            'type' => 'return_refund_approved',
            'title' => 'Return/Refund Request Approved',
            'message' => 'Your return/refund request for ₱' . number_format($returnRefund->refund_amount, 2) . ' has been approved.',
            'is_read' => false,
            'data' => [
                'return_refund_id' => $returnRefund->id,
                'amount' => $returnRefund->refund_amount,
            ]
        ]);

        return redirect()->back()->with('success', 'Return/refund request approved successfully.');
    }

    /**
     * Reject return/refund request
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'required|string|max:1000',
        ], [
            'admin_notes.required' => 'Please provide a reason for rejection.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('return_refund_modal', 'reject');
        }

        $returnRefund = ReturnRefund::with(['user', 'refundable'])->findOrFail($id);

        if ($returnRefund->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending requests can be rejected.');
        }

        $returnRefund->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        // Create notification for customer
        Notification::create([
            'user_id' => $returnRefund->user_id,
            'type' => 'return_refund_rejected',
            'title' => 'Return/Refund Request Rejected',
            'message' => 'Your return/refund request has been rejected. Reason: ' . $request->admin_notes,
            'is_read' => false,
            'data' => [
                'return_refund_id' => $returnRefund->id,
                'reason' => $request->admin_notes,
            ]
        ]);

        return redirect()->back()->with('success', 'Return/refund request rejected.');
    }

    /**
     * Mark refund as processed/refunded
     */
    public function markRefunded(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'refund_method' => 'required|string|max:255',
            'refund_reference' => 'required|string|max:255',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('return_refund_modal', 'refunded');
        }

        $returnRefund = ReturnRefund::with(['user', 'refundable'])->findOrFail($id);

        if ($returnRefund->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved requests can be marked as refunded.');
        }

        $returnRefund->update([
            'status' => 'refunded',
            'refund_method' => $request->refund_method,
            'refund_reference' => $request->refund_reference,
            'processed_at' => now(),
            'admin_notes' => $request->admin_notes ?? $returnRefund->admin_notes,
        ]);

        // Create notification for customer
        Notification::create([
            'user_id' => $returnRefund->user_id,
            'type' => 'return_refund_processed',
            'title' => 'Refund Processed',
            'message' => 'Your refund of ₱' . number_format($returnRefund->refund_amount, 2) . ' has been processed via ' . $request->refund_method . '. Reference: ' . $request->refund_reference,
            'is_read' => false,
            'data' => [
                'return_refund_id' => $returnRefund->id,
                'amount' => $returnRefund->refund_amount,
                'method' => $request->refund_method,
                'reference' => $request->refund_reference,
            ]
        ]);

        return redirect()->back()->with('success', 'Refund marked as processed successfully.');
    }

    /**
     * Filter return/refunds by status
     */
    public function filter(Request $request)
    {
        $status = $request->status;
        
        $query = ReturnRefund::with(['user', 'refundable'])
            ->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $returnRefunds = $query->get();

        $stats = [
            'total' => ReturnRefund::count(),
            'pending' => ReturnRefund::where('status', 'pending')->count(),
            'approved' => ReturnRefund::where('status', 'approved')->count(),
            'rejected' => ReturnRefund::where('status', 'rejected')->count(),
            'refunded' => ReturnRefund::where('status', 'refunded')->count(),
            'total_amount' => ReturnRefund::where('status', '!=', 'rejected')->where('status', '!=', 'cancelled')->sum('refund_amount'),
        ];

        return view('admin.return_refunds', compact('returnRefunds', 'stats', 'status'));
    }
}
