<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\Milestone;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured/upcoming events (limit 3)
        $events = Event::where('status', 'published')
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc')
            ->take(3)
            ->get();

        // Get latest news/posts (1 featured + 4 recent)
        $featuredPost = Post::published()
            ->featured()
            ->latest('published_at')
            ->first();

        $recentPosts = Post::published()
            ->when($featuredPost, function($query) use ($featuredPost) {
                return $query->where('id', '!=', $featuredPost->id);
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        // Get recent gallery images
        $galleries = Gallery::published()
            ->with('images')
            ->latest('created_at')
            ->take(10)
            ->get();

        // Get site settings
        $settings = Setting::getSettings();

        // Get statistics
        $stats = [
            'active_scouts' => 15000,
            'scout_groups' => 180,
            'years_service' => now()->year - 1912,
            'annual_events' => 500,
        ];

        return view('home', compact('events', 'featuredPost', 'recentPosts', 'galleries', 'settings', 'stats'));
    }
}
