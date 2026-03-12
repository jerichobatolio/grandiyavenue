<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\EventTypeTimeSlot;
use App\Models\AdminQrCode;
use App\Models\VenueType;
use App\Models\FoodPackageItem;
use App\Models\PackageInclusion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\Facades\Image;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventTypes = EventType::with('timeSlots')->orderBy('created_at', 'desc')->get();
        $venueTypes = VenueType::orderBy('name')->get();
        $foodPackageItems = FoodPackageItem::orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $packageInclusions = PackageInclusion::orderBy('price')->orderBy('name')->get();
        $globalTimeSlots = EventTypeTimeSlot::whereNull('event_type_id')->orderBy('sort_order')->get();
        
        // Get QR code from database instead of session for persistence
        $adminQrCode = AdminQrCode::getActiveGlobalQrCode();
        $globalQrCode = $adminQrCode ? $adminQrCode->image_path : null;
        
        \Log::info('=== EVENT TYPES INDEX ===');
        \Log::info('Global QR Code from database: ' . ($globalQrCode ?? 'null'));
        \Log::info('Admin QR Code found: ' . ($adminQrCode ? 'Yes' : 'No'));
        
        return view('admin.event_types.index', compact(
            'eventTypes',
            'venueTypes',
            'foodPackageItems',
            'packageInclusions',
            'globalQrCode',
            'adminQrCode',
            'globalTimeSlots'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'venue_type' => 'nullable|string|max:255',
            'guest_number' => 'nullable|integer|min:1',
            'food_package' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'description', 'guest_number', 'food_package']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle venue type - use custom if provided, otherwise use selected
        if ($request->filled('custom_venue_type')) {
            $data['venue_type'] = $request->custom_venue_type;
        } else {
            $data['venue_type'] = $request->venue_type;
        }

        EventType::create($data);

        return redirect()->route('event_types.index')
            ->with('success', 'Event type created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventType $eventType)
    {
        return redirect()->route('event_types.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventType $eventType)
    {
        return redirect()->route('event_types.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventType $eventType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'guest_number' => 'nullable|integer|min:1',
            'food_package' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'description', 'guest_number', 'food_package']);
        $data['is_active'] = $request->has('is_active');

        $eventType->update($data);

        return redirect()->route('event_types.index')
            ->with('success', 'Event type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType)
    {
        // Check if this is a QR code deletion only
        if (request()->has('delete_qr_only')) {
            // Delete only QR code image
            if ($eventType->qr_code_image) {
                Storage::disk('public')->delete($eventType->qr_code_image);
                $eventType->update(['qr_code_image' => null]);
            }
            return redirect()->route('event_types.index')
                ->with('success', 'QR code removed successfully!');
        }

        // Delete associated images
        if ($eventType->qr_code_image) {
            Storage::disk('public')->delete($eventType->qr_code_image);
        }
        if ($eventType->admin_photo) {
            Storage::disk('public')->delete($eventType->admin_photo);
        }

        $eventType->delete();

        return redirect()->route('event_types.index')
            ->with('success', 'Event type deleted successfully!');
    }

    /**
     * Toggle the active status of an event type
     */
    public function toggleStatus(EventType $eventType)
    {
        $eventType->update(['is_active' => !$eventType->is_active]);
        
        $status = $eventType->is_active ? 'activated' : 'deactivated';
        return redirect()->route('event_types.index')
            ->with('success', "Event type {$status} successfully!");
    }

    /**
     * Validate if uploaded file is a QR code
     */
    private function validateQrCode($file)
    {
        try {
            // Check if file contains "QR" in filename or has QR-like characteristics
            $filename = $file->getClientOriginalName();
            $hasQrInName = stripos($filename, 'qr') !== false;
            
            // Basic file validation
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            $mimeType = $file->getMimeType();
            $isValidImage = in_array($mimeType, $allowedMimes);
            
            // File size validation (max 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB in bytes
            $isValidSize = $file->getSize() <= $maxSize;
            
            // For now, accept any image with "QR" in filename or any valid image
            $isValidQr = $hasQrInName || ($isValidImage && $isValidSize);
            
            return [
                'is_valid' => $isValidQr,
                'message' => $isValidQr ? 'Valid QR code' : 'Only QR code images are allowed. Please ensure the file contains a QR code or has "QR" in the filename.'
            ];
        } catch (\Exception $e) {
            return [
                'is_valid' => false,
                'message' => 'Invalid image file. Only QR code images are allowed.'
            ];
        }
    }

    /**
     * Update the global QR code
     */
    public function updateGlobalQrCode(Request $request)
    {
        \Log::info('=== GLOBAL QR CODE UPDATE REQUEST ===');
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('Has file: ' . ($request->hasFile('qr_code_image') ? 'Yes' : 'No'));
        
        $validator = Validator::make($request->all(), [
            'qr_code_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed: ' . json_encode($validator->errors()));
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Additional QR code validation
        if ($request->hasFile('qr_code_image')) {
            $qrValidation = $this->validateQrCode($request->file('qr_code_image'));
            if (!$qrValidation['is_valid']) {
                \Log::error('QR code validation failed: ' . $qrValidation['message']);
                return redirect()->back()
                    ->with('error', $qrValidation['message'])
                    ->withInput();
            }
        }

        try {
            // Store the global QR code in a specific location
            if ($request->hasFile('qr_code_image')) {
                $qrCodePath = $request->file('qr_code_image')->store('global/qr_codes', 'public');
                \Log::info('QR code stored at: ' . $qrCodePath);
                
                // Deactivate any existing QR codes
                AdminQrCode::where('is_active', true)->update(['is_active' => false]);
                
                // Create or update the QR code record
                $adminQrCode = AdminQrCode::updateOrCreate(
                    ['name' => 'Global GCash QR Code'],
                    [
                        'image_path' => $qrCodePath,
                        'description' => 'Global GCash QR Code for event bookings',
                        'is_active' => true
                    ]
                );
                
                \Log::info('QR code saved to database with ID: ' . $adminQrCode->id);
            }

            return redirect()->route('event_types.index')
                ->with('success', 'Global QR code updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating QR code: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating QR code: ' . $e->getMessage());
        }
    }

    /**
     * Delete QR code for a specific event type
     */
    public function deleteEventTypeQrCode(EventType $eventType)
    {
        try {
            if ($eventType->qr_code_image) {
                // Delete the file from storage
                if (Storage::disk('public')->exists($eventType->qr_code_image)) {
                    Storage::disk('public')->delete($eventType->qr_code_image);
                }
                
                // Remove the path from database
                $eventType->update(['qr_code_image' => null]);
                
                return redirect()->route('event_types.index')
                    ->with('success', 'QR code removed successfully!');
            } else {
                return redirect()->route('event_types.index')
                    ->with('error', 'No QR code found for this event type.');
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting QR code: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error deleting QR code: ' . $e->getMessage());
        }
    }

    /**
     * Store a global time slot (for all event types)
     */
    public function storeTimeSlot(Request $request)
    {
        $label = $request->label === '_custom_' ? ($request->label_custom ?? 'Other') : $request->label;
        $validator = Validator::make(array_merge($request->all(), ['label' => $label]), [
            'label' => 'required|string|max:100',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'details' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event_types.index', ['tab' => 'time-slots'])
                ->withErrors($validator)
                ->withInput();
        }

        $isWholeDay = strtolower($label) === 'whole day';
        $maxSort = EventTypeTimeSlot::whereNull('event_type_id')->max('sort_order') ?? 0;

        EventTypeTimeSlot::create([
            'event_type_id' => null,
            'label' => $label,
            'start_time' => $isWholeDay ? null : ($request->start_time ? $request->start_time . ':00' : null),
            'end_time' => $isWholeDay ? null : ($request->end_time ? $request->end_time . ':00' : null),
            'details' => $request->details,
            'sort_order' => $maxSort + 1,
        ]);

        return redirect()->route('event_types.index', ['tab' => 'time-slots'])
            ->with('success', 'Time slot added successfully!');
    }

    /**
     * Update a global time slot
     */
    public function updateTimeSlot(Request $request, EventTypeTimeSlot $timeSlot)
    {
        if ($timeSlot->event_type_id !== null) {
            abort(404);
        }

        $label = $request->label === '_custom_' ? ($request->label_custom ?? 'Other') : $request->label;
        $validator = Validator::make(array_merge($request->all(), ['label' => $label]), [
            'label' => 'required|string|max:100',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'details' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event_types.index', ['tab' => 'time-slots'])
                ->withErrors($validator)
                ->withInput();
        }

        $isWholeDay = strtolower($label) === 'whole day';

        $timeSlot->update([
            'label' => $label,
            'start_time' => $isWholeDay ? null : ($request->start_time ? $request->start_time . ':00' : null),
            'end_time' => $isWholeDay ? null : ($request->end_time ? $request->end_time . ':00' : null),
            'details' => $request->details,
        ]);

        return redirect()->route('event_types.index', ['tab' => 'time-slots'])
            ->with('success', 'Time slot updated successfully!');
    }

    /**
     * Delete a global time slot
     */
    public function destroyTimeSlot(EventTypeTimeSlot $timeSlot)
    {
        if ($timeSlot->event_type_id !== null) {
            abort(404);
        }
        $timeSlot->delete();
        return redirect()->route('event_types.index', ['tab' => 'time-slots'])
            ->with('success', 'Time slot deleted successfully!');
    }

    /**
     * Delete the global QR code
     */
    public function deleteGlobalQrCode(Request $request)
    {
        try {
            // Get the current active QR code from database
            $adminQrCode = AdminQrCode::where('is_active', true)->first();
            
            if ($adminQrCode) {
                // Delete the file from storage
                if ($adminQrCode->image_path && Storage::disk('public')->exists($adminQrCode->image_path)) {
                    Storage::disk('public')->delete($adminQrCode->image_path);
                }
                
                // Deactivate the QR code
                $adminQrCode->update(['is_active' => false]);
                \Log::info('QR code deactivated and file deleted');
            }
            
            // Clean up any remaining session data for backward compatibility
            session()->forget('global_qr_code');

            return redirect()->route('event_types.index')
                ->with('success', 'Global QR code removed successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting QR code: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error deleting QR code: ' . $e->getMessage());
        }
    }
}