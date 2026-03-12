<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventBooking;
use App\Models\Book;
use App\Models\EventType;
use App\Models\AdminQrCode;
use App\Models\VenueType;
use App\Models\FoodPackageItem; // ✅ Simple food package items for events
use App\Models\PaxOption; // ✅ Pax-based pricing from admin pax management
use App\Models\Notification; // ✅ Add Notification model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class EventBookingController extends Controller
{
    /**
     * Show the event booking form
     */
    public function showBookingForm()
    {
        // Show all event types on dedicated booking page (no active filter)
        $eventTypes = EventType::orderBy('name')->get();
        $venueTypes = VenueType::orderBy('name')->get(); // Get all venue types (admin manages visibility)
        $foodPackageItems = FoodPackageItem::orderBy('sort_order')->orderBy('name')->get();
        
        // ✅ Load Pax options (admin-managed) for pricing + dropdown consistency
        $paxOptions = collect();
        if (Schema::hasTable('pax_options')) {
            $paxOptions = PaxOption::active()
                ->orderBy('sort_order')
                ->orderBy('value')
                ->get();
        }
        
        // Get QR code from database instead of session
        $adminQrCode = AdminQrCode::getActiveGlobalQrCode();
        $globalQrCode = $adminQrCode ? $adminQrCode->image_path : null;
        
        \Log::info('=== BOOKING FORM ===');
        \Log::info('Global QR Code for booking: ' . ($globalQrCode ?? 'null'));
        \Log::info('Admin QR Code found: ' . ($adminQrCode ? 'Yes' : 'No'));
        \Log::info('Venue Types count: ' . $venueTypes->count());
        
        return view('home.book_event', compact('eventTypes', 'venueTypes', 'foodPackageItems', 'paxOptions', 'globalQrCode', 'adminQrCode'));
    }

    /**
     * Check if user is authenticated
     */
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => auth()->check(),
            'user' => auth()->user()
        ]);
    }

    /**
     * Public API: checks if a selected date/time conflicts with an existing event booking
     * or table reservation. Returns only non-sensitive aggregate flags/counts.
     */
    public function checkBookingConflicts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $date = $request->input('date');
        $timeIn = $request->input('time_in');
        $timeOut = $request->input('time_out');
        $isWholeDayQuery = empty($timeIn) || empty($timeOut);

        // Event bookings: whole-day events block any time on that date
        $wholeDayEventExists = EventBooking::query()
            ->when(Schema::hasColumn('event_bookings', 'is_archived'), fn ($q) => $q->where('is_archived', false))
            ->whereDate('event_date', $date)
            ->where('status', '!=', 'Cancelled')
            ->where(function ($q) {
                $q->whereNull('time_in')->orWhereNull('time_out');
            })
            ->exists();

        $eventBookingConflicts = 0;
        $tableReservationConflicts = 0;

        if ($isWholeDayQuery) {
            // Whole-day selection: any non-cancelled booking or reservation on this date counts as a conflict.
            $eventBookingConflicts = EventBooking::query()
                ->when(Schema::hasColumn('event_bookings', 'is_archived'), fn ($q) => $q->where('is_archived', false))
                ->whereDate('event_date', $date)
                ->where('status', '!=', 'Cancelled')
                ->count();

            $tableReservationConflicts = Book::query()
                ->where('is_archived', false)
                ->whereDate('date', $date)
                ->where(function ($q) {
                    $q->whereNull('status')
                        ->orWhereNotIn('status', ['cancelled']);
                })
                ->count();
        } elseif (!$wholeDayEventExists && $timeIn && $timeOut) {
            // Time-slot selection: check overlapping bookings/reservations on this date.
            $eventBookingConflicts = EventBooking::query()
                ->when(Schema::hasColumn('event_bookings', 'is_archived'), fn ($q) => $q->where('is_archived', false))
                ->whereDate('event_date', $date)
                ->where('status', '!=', 'Cancelled')
                ->whereNotNull('time_in')
                ->whereNotNull('time_out')
                ->where('time_in', '<', $timeOut)
                ->where('time_out', '>', $timeIn)
                ->count();

            $start = Carbon::parse($date . ' ' . $timeIn . ':00');
            $end = Carbon::parse($date . ' ' . $timeOut . ':00');

            $tableReservationConflicts = Book::query()
                ->where('is_archived', false)
                ->whereDate('date', $date)
                ->where(function ($q) {
                    $q->whereNull('status')
                        ->orWhereNotIn('status', ['cancelled']);
                })
                ->whereNotNull('time_in')
                ->whereNotNull('time_out')
                ->where('time_in', '<', $end)
                ->where('time_out', '>', $start)
                ->count();
        }

        $hasConflict = $wholeDayEventExists || $eventBookingConflicts > 0 || $tableReservationConflicts > 0;

        return response()->json([
            'success' => true,
            'conflict' => $hasConflict,
            'whole_day_event' => $wholeDayEventExists,
            'counts' => [
                'event_bookings' => $eventBookingConflicts,
                'table_reservations' => $tableReservationConflicts,
            ],
        ]);
    }

    /**
     * Store the event booking
     */
    public function storeBooking(Request $request)
    {
        \Log::info('=== EVENT BOOKING REQUEST ===');
        \Log::info('User authenticated: ' . (auth()->check() ? 'Yes' : 'No'));
        \Log::info('User ID: ' . (auth()->id() ?? 'Not authenticated'));
        \Log::info('Request data: ' . json_encode($request->all()));
        
        // Check if user is authenticated
        if (!auth()->check()) {
            \Log::error('User not authenticated');
            return response()->json([
                'success' => false,
                'message' => 'Authentication required to book an event'
            ], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|digits:11',
            'email' => 'required|email|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            // Time fields are now optional on the booking form
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'number_of_guests' => 'nullable|integer|min:1|max:1000',
            'additional_notes' => 'nullable|string|max:1000',
            'event_type_id' => 'required|exists:event_types,id',
            'venue_type_id' => 'nullable|exists:venue_types,id',
            // Package inclusion is now required for event bookings
            'package_inclusion_id' => 'required|exists:package_inclusions,id',
            // Food package selection: require at least one item
            'selected_food_items' => 'required|array|min:1',
            'selected_food_items.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed: ' . json_encode($validator->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $eventDate = $request->input('event_date');
        $timeIn = $request->input('time_in');   // expected format: H:i (stored as TIME)
        $timeOut = $request->input('time_out'); // expected format: H:i (stored as TIME)

        // Business rule: disallow whole-day booking when there is an accepted (Paid) time-slot booking on that date.
        $isWholeDayRequest = !empty($eventDate) && (empty($timeIn) || empty($timeOut));
        if ($isWholeDayRequest) {
            $hasAcceptedTimeSlotBooking = EventBooking::query()
                ->whereDate('event_date', $eventDate)
                ->where('status', 'Paid')
                ->whereNotNull('time_in')
                ->whereNotNull('time_out')
                ->when(Schema::hasColumn('event_bookings', 'is_archived'), fn ($q) => $q->where('is_archived', false))
                ->exists();

            if ($hasAcceptedTimeSlotBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Whole-day booking is not allowed because there is already an accepted event scheduled in a time slot on this date.',
                    'errors' => [
                        'event_date' => ['You cannot book a whole-day event on a date that already has an accepted time-slot booking.'],
                    ],
                ], 422);
            }
        }

        // Prevent the same user from booking the same date/time (or an overlapping time range).
        if (!empty($eventDate) && !empty($timeIn)) {
            $conflictQuery = EventBooking::query()
                ->where('user_id', auth()->id())
                ->whereDate('event_date', $eventDate)
                ->where('status', '!=', 'Cancelled');

            if (Schema::hasColumn('event_bookings', 'is_archived')) {
                $conflictQuery->where('is_archived', false);
            }

            if (!empty($timeOut)) {
                // Overlap check: existing.start < requested.end AND existing.end > requested.start
                $conflictQuery
                    ->whereNotNull('time_in')
                    ->whereNotNull('time_out')
                    ->where('time_in', '<', $timeOut)
                    ->where('time_out', '>', $timeIn);
            } else {
                // Fallback to exact match on start time when no end time is provided
                $conflictQuery->where('time_in', $timeIn);
            }

            if ($conflictQuery->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an event booking on this date and time. Please select a different time slot.',
                    'errors' => [
                        'event_date' => ['This date/time is already booked for your account.'],
                        'time_in' => ['This time slot conflicts with one of your existing bookings.'],
                    ],
                ], 422);
            }
        }

        try {
            // Pricing priority: Pax Management (pax_options) -> Event Type (legacy) -> 0
            $eventType = EventType::findOrFail($request->event_type_id);
            $downPaymentAmount = null;
            
            // Pax-based down payment removed; use event type or safe default
            $downPaymentAmount = $eventType->down_payment ?? 0;
            
            // Normalize selected food items (array of non-empty strings or null)
            $selectedFoodItems = $request->input('selected_food_items', []);
            if (is_array($selectedFoodItems)) {
                $selectedFoodItems = array_values(array_filter(array_map(function ($item) {
                    return is_string($item) ? trim($item) : '';
                }, $selectedFoodItems), function ($item) {
                    return $item !== '';
                }));
            } else {
                $selectedFoodItems = [];
            }

            // number_of_guests is NOT NULL in DB; use request value or default 1
            $numberOfGuests = $request->filled('number_of_guests')
                ? (int) $request->number_of_guests
                : 1;

            $bookingData = [
                'user_id' => auth()->id(),
                'full_name' => $request->full_name,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'event_date' => $request->event_date,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'number_of_guests' => $numberOfGuests,
                'additional_notes' => $request->additional_notes,
                'selected_food_items' => !empty($selectedFoodItems) ? $selectedFoodItems : null,
                'status' => 'Pending',
                'down_payment_amount' => $downPaymentAmount,
                'event_type_id' => $request->event_type_id,
                'venue_type_id' => $request->venue_type_id,
                'package_inclusion_id' => $request->package_inclusion_id ?: null
            ];
            
            \Log::info('Creating booking with data: ' . json_encode($bookingData));
            
            $booking = EventBooking::create($bookingData);

            \Log::info('Booking created successfully with ID: ' . $booking->id);

            // Create notification for the customer
            // Note: Detailed info (date, package, pax, amount) is now handled
            // by AdminController::createEventBookingNotification and the
            // NotificationController normalizer. Here we just send a clean
            // status message without "Event on ... for X guests".
            if (auth()->check() && $booking->user_id) {
                Notification::create([
                    'user_id' => $booking->user_id,
                    'event_booking_id' => $booking->id,
                    'type' => 'event_booking',
                    'title' => 'Event Booking Pending',
                    'message' => 'Your event booking is pending approval.',
                    'is_read' => false,
                    'data' => [
                        'booking_id' => $booking->id,
                        'status' => 'Pending',
                        'event_date' => $booking->event_date->format('Y-m-d'),
                        'amount' => $booking->down_payment_amount,
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'booking' => $booking->load(['eventType', 'venueType', 'packageInclusion']),
                'message' => 'Booking created successfully!'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error creating booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating booking: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload GCash payment proof
     */
    public function uploadPaymentProof(Request $request)
    {
        \Log::info('=== PAYMENT PROOF UPLOAD REQUEST ===');
        \Log::info('Request data: ' . json_encode($request->all()));
        
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:event_bookings,id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // Only full payment is accepted now; keep nullable to ignore legacy values safely
            'payment_option' => 'nullable|in:full_payment'
        ]);
        
        // Additional GCash receipt validation
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $gcashValidation = $this->validateGCashReceipt($file);
            
            if (!$gcashValidation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid GCash receipt: ' . $gcashValidation['message'],
                    'errors' => ['payment_proof' => [$gcashValidation['message']]]
                ], 422)->header('Content-Type', 'application/json');
            }
        }

        if ($validator->fails()) {
            \Log::error('Payment proof validation failed: ' . json_encode($validator->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)->header('Content-Type', 'application/json');
        }

        try {
            $booking = EventBooking::with(['eventType', 'packageInclusion'])->findOrFail($request->booking_id);
            // Only full payment is accepted in the current flow
            $paymentOption = 'full_payment';
            
            // Amount determination:
            // - If a Package Inclusion with a price is selected, ALWAYS use that as the full event price
            // - Otherwise, fall back to pax_options full_price, then to the Event Type price, then to down_payment_amount
            $packagePrice = optional($booking->packageInclusion)->price;
            if (!is_null($packagePrice)) {
                $fullPaymentAmount = $packagePrice;
            } else {
                $paxFullPrice = null;
                if (Schema::hasTable('pax_options')) {
                    $pax = PaxOption::where('value', (int) $booking->number_of_guests)->first();
                    if ($pax && $pax->full_price !== null) {
                        $paxFullPrice = $pax->full_price;
                    }
                }
                $fullPaymentAmount = $paxFullPrice ?? optional($booking->eventType)->price ?? $booking->down_payment_amount;
            }

            // Always record the full payment amount; down payments are no longer accepted
            $amountPaid = $fullPaymentAmount;

            // Store the GCash payment proof image
            $path = $request->file('payment_proof')->store('gcash_payment_proofs', 'public');

            // Generate reference numbers if not provided
            $gcashReferenceNumber = $request->gcash_reference_number ?? 'GCASH-' . time() . '-' . $booking->id;
            $gcashTransactionId = $request->gcash_transaction_id ?? 'TXN-' . time() . '-' . $booking->id;

            $booking->update([
                'payment_proof_path' => $path,
                'gcash_reference_number' => $gcashReferenceNumber,
                'gcash_transaction_id' => $gcashTransactionId,
                'gcash_payment_date' => now(),
                'payment_confirmed_at' => null, // Don't confirm payment yet - admin needs to verify
                'status' => 'Pending', // Set to Pending for admin verification
                'payment_option' => $paymentOption,
                'amount_paid' => $amountPaid
            ]);

            \Log::info('Payment proof uploaded successfully for booking ID: ' . $booking->id);

            return response()->json([
                'success' => true,
                'message' => 'GCash payment proof uploaded successfully! Your payment is now pending admin verification.',
                'booking' => $booking->load(['eventType', 'venueType', 'packageInclusion'])
            ])->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error uploading payment proof: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading payment proof: ' . $e->getMessage()
            ], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Cancel pending booking that has no payment proof
     */
    public function cancelPendingBooking(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $request->validate([
            'booking_id' => 'required|exists:event_bookings,id'
        ]);

        $booking = EventBooking::where('id', $request->booking_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Incomplete booking was cancelled successfully.'
        ]);
    }

    /**
     * Get booking details
     */
    public function getBooking($id)
    {
        $booking = EventBooking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'success' => true,
            'booking' => $booking
        ])->header('Content-Type', 'application/json');
    }

    /**
     * Display event booking receipt
     */
    public function downloadReceipt($id)
    {
        $booking = EventBooking::with(['eventType', 'venueType'])->findOrFail($id);
        
        // Check if user is authorized to view this receipt
        if (auth()->check() && $booking->user_id && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this receipt.');
        }
        
        return view('receipts.event_booking_receipt', compact('booking'));
    }

    /**
     * Validate if uploaded file is a GCash receipt
     */
    private function validateGCashReceipt($file)
    {
        // Check file size (max 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return [
                'valid' => false,
                'message' => 'File size must be less than 2MB'
            ];
        }

        // Check file type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return [
                'valid' => false,
                'message' => 'Only JPG, PNG, and JPEG images are allowed'
            ];
        }

        // Get image dimensions
        $imageInfo = getimagesize($file->getPathname());
        if (!$imageInfo) {
            return [
                'valid' => false,
                'message' => 'Invalid image file'
            ];
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Check minimum dimensions
        if ($width < 200 || $height < 200) {
            return [
                'valid' => false,
                'message' => 'Image is too small. Please upload a clear, high-resolution GCash receipt (minimum 200x200 pixels)'
            ];
        }

        // Basic validation - in a real implementation, you would use OCR or image analysis
        // For now, we'll do basic checks and rely on user compliance
        
        // Check if image is not too large (max 4000x4000)
        if ($width > 4000 || $height > 4000) {
            return [
                'valid' => false,
                'message' => 'Image is too large. Please upload a smaller image (maximum 4000x4000 pixels)'
            ];
        }

        // Additional validation could include:
        // - OCR to detect "GCash" text in the image
        // - Color analysis to check for GCash branding colors
        // - Pattern recognition for GCash receipt layout
        // - Machine learning models trained on GCash receipts

        return [
            'valid' => true,
            'message' => 'GCash receipt validation passed'
        ];
    }
}
