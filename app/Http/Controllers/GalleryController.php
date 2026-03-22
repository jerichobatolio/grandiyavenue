<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Stream a gallery file from the public disk (same pattern as payment proofs / profile photos).
     * Avoids relying on the public/storage symlink, which often breaks on Railway and other hosts.
     */
    public function serveImage(string $filename)
    {
        if (str_contains($filename, '..') || str_contains($filename, '/')) {
            abort(404);
        }

        $path = 'gallery_images/'.$filename;

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::ordered()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('gallery_images', 'public');
        $imagePath = str_replace('\\', '/', $imagePath);

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'description' => $request->description,
            'is_active' => true,
            'sort_order' => Gallery::count() + 1,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gallery item added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image_path) {
                Storage::disk('public')->delete(str_replace('\\', '/', $gallery->image_path));
            }
            $data['image_path'] = str_replace('\\', '/', $request->file('image')->store('gallery_images', 'public'));
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Gallery item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Delete image file
        if ($gallery->image_path) {
            Storage::disk('public')->delete(str_replace('\\', '/', $gallery->image_path));
        }
        
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery item deleted successfully!');
    }

    /**
     * Get gallery items for public display
     */
    public function publicGallery()
    {
        $galleries = Gallery::ordered()->get();
        return $galleries;
    }
}
