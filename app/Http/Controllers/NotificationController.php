<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Fetch the latest notifications for the logged-in user
    public function getNotifications()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([]);
        }

        $notifications = Notification::where('user_id', $user->id)
            ->with(['order', 'eventBooking.packageInclusion'])
            ->latest()
            ->take(10)
            ->get();

        // Normalize event booking notification data so the frontend
        // always sees package inclusion and amount based on the
        // selected package, even for older notifications.
        $notifications->transform(function ($notification) {
            if ($notification->type === 'event_booking' && $notification->eventBooking) {
                $booking = $notification->eventBooking;
                $package = optional($booking->packageInclusion);

                $timeInFormatted = $booking->time_in instanceof \Carbon\Carbon
                    ? $booking->time_in->format('g:i A')
                    : $booking->time_in;

                $timeOutFormatted = $booking->time_out instanceof \Carbon\Carbon
                    ? $booking->time_out->format('g:i A')
                    : $booking->time_out;

                $timeSlot = null;
                if ($timeInFormatted && $timeOutFormatted) {
                    $timeSlot = $timeInFormatted . ' – ' . $timeOutFormatted;
                } elseif ($timeInFormatted) {
                    $timeSlot = $timeInFormatted;
                }

                $data = $notification->data ?? [];
                $data['booking_id'] = $booking->id;
                $data['status'] = $booking->status;
                $data['event_date'] = $booking->event_date
                    ? $booking->event_date->format('Y-m-d')
                    : null;
                // Build package display with pax (e.g. "Gold Package (50 pax)" or "Gold Package (30–50 pax)")
                $packageName = $package->name;
                $paxLabel = null;
                if (!is_null($package->pax_min) || !is_null($package->pax_max)) {
                    if (!is_null($package->pax_min) && !is_null($package->pax_max) && $package->pax_min != $package->pax_max) {
                        $paxLabel = $package->pax_min . '–' . $package->pax_max . ' pax';
                    } else {
                        $paxValue = $package->pax_min ?? $package->pax_max;
                        if (!is_null($paxValue)) {
                            $paxLabel = $paxValue . ' pax';
                        }
                    }
                }
                $packageDisplayName = $packageName;
                if ($packageDisplayName && $paxLabel) {
                    $packageDisplayName .= ' (' . $paxLabel . ')';
                }

                $data['package_inclusion'] = $packageDisplayName ?? ($data['package_inclusion'] ?? null);
                $data['time_slot'] = $timeSlot ?? ($data['time_slot'] ?? null);
                $data['amount'] = $package->price
                    ?? ($data['amount'] ?? $booking->down_payment_amount);

                $notification->data = $data;
            }

            return $notification;
        });

        return response()->json($notifications);
    }

    // Mark notification as read
    public function markAsRead($id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        
        if ($notification) {
            // Use update() method to persist to database
            $affected = Notification::where('id', $notification->id)
                ->where('user_id', $user->id)
                ->update(['is_read' => 1]);
            
            \Log::info("Marked notification {$id} as read. Affected rows: {$affected}");
            
            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        }
        
        \Log::info("Notification {$id} not found for user {$user->id}");

        return response()->json(['error' => 'Notification not found', 'id' => $id, 'user_id' => $user->id], 404);
    }

    // Delete notification
    public function deleteNotification($id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification deleted successfully']);
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }
}
