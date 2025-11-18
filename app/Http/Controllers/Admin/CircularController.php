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
            'file_type' => 'required|in:pdf_upload,drive_link,doc_upload',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'external_link' => 'nullable|url',
            'published_date' => 'required|date',
            'is_pinned' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $validated['file_path'] = $file->storeAs('circulars', $filename, 'public');
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
            'file_type' => 'required|in:pdf_upload,drive_link,doc_upload',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'external_link' => 'nullable|url',
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
