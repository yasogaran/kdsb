<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Filter by time period
        if ($request->filled('period')) {
            if ($request->period === 'upcoming') {
                $query->upcoming();
            } elseif ($request->period === 'past') {
                $query->past();
            }
        } else {
            $query->latest('start_datetime');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by location type
        if ($request->filled('location_type')) {
            $query->where('location_type', $request->location_type);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'registration_deadline' => 'nullable|date|before:start_datetime',
            'location_type' => 'required|in:physical,virtual,hybrid',
            'venue_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'map_link' => 'nullable|url',
            'meeting_url' => 'nullable|url',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organized_by' => 'nullable|string|max:255',
            'organization_link' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle image uploads
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $this->uploadImage($request->file('banner_image'), 'events/banners', 1200, 600);
        }

        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = $this->uploadImage($request->file('thumbnail_image'), 'events/thumbnails', 600, 400);
        }

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $this->uploadImage($request->file('og_image'), 'events/og', 1200, 630);
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug,' . $event->id,
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'registration_deadline' => 'nullable|date|before:start_datetime',
            'location_type' => 'required|in:physical,virtual,hybrid',
            'venue_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'map_link' => 'nullable|url',
            'meeting_url' => 'nullable|url',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organized_by' => 'nullable|string|max:255',
            'organization_link' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $this->uploadImage($request->file('banner_image'), 'events/banners', 1200, 600);
        }

        // Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            if ($event->thumbnail_image && Storage::disk('public')->exists($event->thumbnail_image)) {
                Storage::disk('public')->delete($event->thumbnail_image);
            }
            $validated['thumbnail_image'] = $this->uploadImage($request->file('thumbnail_image'), 'events/thumbnails', 600, 400);
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            if ($event->og_image && Storage::disk('public')->exists($event->og_image)) {
                Storage::disk('public')->delete($event->og_image);
            }
            $validated['og_image'] = $this->uploadImage($request->file('og_image'), 'events/og', 1200, 630);
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Delete images if they exist
        if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
            Storage::disk('public')->delete($event->banner_image);
        }

        if ($event->thumbnail_image && Storage::disk('public')->exists($event->thumbnail_image)) {
            Storage::disk('public')->delete($event->thumbnail_image);
        }

        if ($event->og_image && Storage::disk('public')->exists($event->og_image)) {
            Storage::disk('public')->delete($event->og_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Upload and optimize image
     */
    private function uploadImage($file, $directory, $width, $height)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = $file->storeAs($directory, $filename, 'public');

        // Resize and optimize image
        $fullPath = storage_path('app/public/' . $path);
        Image::read($fullPath)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($fullPath, 85);

        return $path;
    }
}
