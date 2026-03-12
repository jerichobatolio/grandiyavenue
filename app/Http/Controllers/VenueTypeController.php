<?php

namespace App\Http\Controllers;

use App\Models\VenueType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VenueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venueTypes = VenueType::orderBy('name')->get();
        return response()->json($venueTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:venue_types,name',
            'description' => 'nullable|string|max:1000',
            'capacity' => 'nullable|integer|min:1|max:10000',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Venue type name is required.',
            'name.unique' => 'A venue type with this name already exists.',
            'name.max' => 'Venue type name cannot exceed 255 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'capacity.min' => 'Capacity must be at least 1 guest.',
            'capacity.max' => 'Capacity cannot exceed 10,000 guests.',
            'capacity.integer' => 'Capacity must be a valid number.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        try {
            $venueType = VenueType::create([
                'name' => trim($request->name),
                'description' => trim($request->description),
                'capacity' => $request->capacity ? (int)$request->capacity : null,
                'is_active' => $request->has('is_active') ? (bool)$request->is_active : true // Default to true if not provided
            ]);

            return redirect()->back()->with('success', 'Venue type "' . $venueType->name . '" created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating venue type: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create venue type. Please try again.')
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VenueType $venueType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:venue_types,name,' . $venueType->id,
            'description' => 'nullable|string|max:1000',
            'capacity' => 'nullable|integer|min:1|max:10000',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Venue type name is required.',
            'name.unique' => 'A venue type with this name already exists.',
            'name.max' => 'Venue type name cannot exceed 255 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'capacity.min' => 'Capacity must be at least 1 guest.',
            'capacity.max' => 'Capacity cannot exceed 10,000 guests.',
            'capacity.integer' => 'Capacity must be a valid number.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        try {
            $venueType->update([
                'name' => trim($request->name),
                'description' => trim($request->description),
                'capacity' => $request->capacity ? (int)$request->capacity : null,
                'is_active' => $request->has('is_active') ? (bool)$request->is_active : $venueType->is_active // Keep existing value if not provided
            ]);

            return redirect()->back()->with('success', 'Venue type "' . $venueType->name . '" updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating venue type: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update venue type. Please try again.')
                ->withInput();
        }
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(VenueType $venueType)
    {
        $venueType->update(['is_active' => !$venueType->is_active]);
        
        $status = $venueType->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Venue type {$status} successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VenueType $venueType)
    {
        $venueType->delete();
        return redirect()->back()->with('success', 'Venue type deleted successfully!');
    }
}
