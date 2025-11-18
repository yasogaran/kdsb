<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('published', true);

        // Filter by type (upcoming/past)
        if ($request->has('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('start_date', '>=', now());
            } elseif ($request->filter === 'past') {
                $query->where('end_date', '<', now());
            }
        } else {
            // Default to upcoming
            $query->where('start_date', '>=', now());
        }

        // Filter by location type
        if ($request->has('location_type')) {
            $query->where('location_type', $request->location_type);
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(12);

        return view('events.index', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('published', true)
            ->where('slug', $slug)
            ->with('gallery.images')
            ->firstOrFail();

        // Get related events
        $relatedEvents = Event::where('published', true)
            ->where('id', '!=', $event->id)
            ->where('start_date', '>=', now())
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}
