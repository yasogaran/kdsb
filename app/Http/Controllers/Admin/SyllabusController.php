<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    public function index(Request $request)
    {
        $query = Syllabus::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by resource type
        if ($request->filled('resource_type')) {
            $query->where('resource_type', $request->resource_type);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $syllabi = $query->latest('published_date')->paginate(15);

        return view('admin.syllabi.index', compact('syllabi'));
    }

    public function create()
    {
        return view('admin.syllabi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Singithi,Cubs,Junior Scouts,Senior Scouts,Rovers,Masters,General',
            'resource_type' => 'required|in:pdf_upload,drive_link,video_link,doc_upload',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'external_url' => 'nullable|url',
            'description' => 'nullable|string',
            'published_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $validated['file_path'] = $file->storeAs('syllabi', $filename, 'public');
        }

        Syllabus::create($validated);

        return redirect()->route('admin.syllabi.index')
            ->with('success', 'Syllabus created successfully.');
    }

    public function show(Syllabus $syllabus)
    {
        return view('admin.syllabi.show', compact('syllabus'));
    }

    public function edit(Syllabus $syllabus)
    {
        return view('admin.syllabi.edit', compact('syllabus'));
    }

    public function update(Request $request, Syllabus $syllabus)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Singithi,Cubs,Junior Scouts,Senior Scouts,Rovers,Masters,General',
            'resource_type' => 'required|in:pdf_upload,drive_link,video_link,doc_upload',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'external_url' => 'nullable|url',
            'description' => 'nullable|string',
            'published_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($syllabus->file_path && Storage::disk('public')->exists($syllabus->file_path)) {
                Storage::disk('public')->delete($syllabus->file_path);
            }

            $file = $request->file('file_path');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $validated['file_path'] = $file->storeAs('syllabi', $filename, 'public');
        }

        $syllabus->update($validated);

        return redirect()->route('admin.syllabi.index')
            ->with('success', 'Syllabus updated successfully.');
    }

    public function destroy(Syllabus $syllabus)
    {
        // Delete file if exists
        if ($syllabus->file_path && Storage::disk('public')->exists($syllabus->file_path)) {
            Storage::disk('public')->delete($syllabus->file_path);
        }

        $syllabus->delete();

        return redirect()->route('admin.syllabi.index')
            ->with('success', 'Syllabus deleted successfully.');
    }
}
