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
        $events = Event::where('published', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        // Get latest news/posts (1 featured + 4 recent)
        $featuredPost = Post::where('published', true)
            ->where('featured', true)
            ->latest('published_at')
            ->first();

        $recentPosts = Post::where('published', true)
            ->where('id', '!=', $featuredPost?->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        // Get recent gallery images
        $galleries = Gallery::where('published', true)
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
