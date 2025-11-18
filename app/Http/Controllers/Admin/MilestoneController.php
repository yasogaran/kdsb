<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class MilestoneController extends Controller
{
    public function index()
    {
        $milestones = Milestone::ordered()->paginate(15);
        return view('admin.milestones.index', compact('milestones'));
    }

    public function create()
    {
        return view('admin.milestones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->extension();
            $path = $image->storeAs('milestones', $filename, 'public');

            // Resize and optimize image
            $fullPath = storage_path('app/public/' . $path);
            Image::read($fullPath)
                ->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($fullPath, 85);

            $validated['image'] = $path;
        }

        Milestone::create($validated);

        return redirect()->route('admin.milestones.index')
            ->with('success', 'Milestone created successfully.');
    }

    public function show(Milestone $milestone)
    {
        return view('admin.milestones.show', compact('milestone'));
    }

    public function edit(Milestone $milestone)
    {
        return view('admin.milestones.edit', compact('milestone'));
    }

    public function update(Request $request, Milestone $milestone)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($milestone->image && Storage::disk('public')->exists($milestone->image)) {
                Storage::disk('public')->delete($milestone->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->extension();
            $path = $image->storeAs('milestones', $filename, 'public');

            // Resize and optimize image
            $fullPath = storage_path('app/public/' . $path);
            Image::read($fullPath)
                ->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($fullPath, 85);

            $validated['image'] = $path;
        }

        $milestone->update($validated);

        return redirect()->route('admin.milestones.index')
            ->with('success', 'Milestone updated successfully.');
    }

    public function destroy(Milestone $milestone)
    {
        // Delete image if exists
        if ($milestone->image && Storage::disk('public')->exists($milestone->image)) {
            Storage::disk('public')->delete($milestone->image);
        }

        $milestone->delete();

        return redirect()->route('admin.milestones.index')
            ->with('success', 'Milestone deleted successfully.');
    }
}
