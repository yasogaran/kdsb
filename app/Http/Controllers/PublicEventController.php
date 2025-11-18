<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status', 'published');

        // Filter by type (upcoming/past)
        if ($request->has('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('start_datetime', '>=', now());
            } elseif ($request->filter === 'past') {
                $query->where('end_datetime', '<', now());
            }
        } else {
            // Default to upcoming
            $query->where('start_datetime', '>=', now());
        }

        // Filter by location type
        if ($request->has('location_type')) {
            $query->where('location_type', $request->location_type);
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->orderBy('start_datetime', 'asc')->paginate(12);

        return view('events.index', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('status', 'published')
            ->where('slug', $slug)
            ->with('galleries.images')
            ->firstOrFail();

        // Get related events
        $relatedEvents = Event::where('status', 'published')
            ->where('id', '!=', $event->id)
            ->where('start_datetime', '>=', now())
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}
