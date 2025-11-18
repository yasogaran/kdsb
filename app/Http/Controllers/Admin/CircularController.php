<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Circular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CircularController extends Controller
{
    public function index(Request $request)
    {
        $query = Circular::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by file type
        if ($request->filled('file_type')) {
            $query->where('file_type', $request->file_type);
        }

        // Filter by pinned
        if ($request->filled('is_pinned')) {
            $query->where('is_pinned', $request->is_pinned);
        }

        // Search by title or circular number
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('circular_number', 'like', '%' . $request->search . '%')
                  ->orWhere('circular_code', 'like', '%' . $request->search . '%');
            });
        }

        $circulars = $query->latest('published_date')->paginate(15);

        return view('admin.circulars.index', compact('circulars'));
    }

    public function create()
    {
        return view('admin.circulars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'circular_number' => 'required|string|max:255|unique:circulars,circular_number',
            'circular_code' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'file_type' => 'required|in:file,url',
            'file_path' => 'required_if:file_type,file|nullable|file|mimes:pdf,doc,docx|max:10240',
            'external_link' => 'required_if:file_type,url|nullable|url',
            'published_date' => 'required|date',
            'is_pinned' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $validated['file_path'] = $file->storeAs('circulars', $filename, 'public');
        } else {
            $validated['file_path'] = null;
        }

        // Clear external_link if file is uploaded
        if ($validated['file_type'] === 'file') {
            $validated['external_link'] = null;
        } else {
            $validated['file_path'] = null;
        }

        Circular::create($validated);

        return redirect()->route('admin.circulars.index')
            ->with('success', 'Circular created successfully.');
    }

    public function show(Circular $circular)
    {
        return view('admin.circulars.show', compact('circular'));
    }

    public function edit(Circular $circular)
    {
        return view('admin.circulars.edit', compact('circular'));
    }

    public function update(Request $request, Circular $circular)
    {
        $validated = $request->validate([
            'circular_number' => 'required|string|max:255|unique:circulars,circular_number,' . $circular->id,
            'circular_code' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'file_type' => 'required|in:file,url',
            'file_path' => 'required_if:file_type,file|nullable|file|mimes:pdf,doc,docx|max:10240',
            'external_link' => 'required_if:file_type,url|nullable|url',
            'published_date' => 'required|date',
            'is_pinned' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($circular->file_path && Storage::disk('public')->exists($circular->file_path)) {
                Storage::disk('public')->delete($circular->file_path);
            }

            $file = $request->file('file_path');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $validated['file_path'] = $file->storeAs('circulars', $filename, 'public');
        }

        // Clear external_link if file is uploaded
        if ($validated['file_type'] === 'file') {
            $validated['external_link'] = null;
        } elseif ($validated['file_type'] === 'url' && !$request->hasFile('file_path')) {
            $validated['file_path'] = null;
        }

        $circular->update($validated);

        return redirect()->route('admin.circulars.index')
            ->with('success', 'Circular updated successfully.');
    }

    public function destroy(Circular $circular)
    {
        // Delete file if exists
        if ($circular->file_path && Storage::disk('public')->exists($circular->file_path)) {
            Storage::disk('public')->delete($circular->file_path);
        }

        $circular->delete();

        return redirect()->route('admin.circulars.index')
            ->with('success', 'Circular deleted successfully.');
    }
}
