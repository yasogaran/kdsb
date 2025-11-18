<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Event;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\Circular;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),

            'upcoming_events' => Event::where('start_datetime', '>', now())->count(),
            'past_events' => Event::where('end_datetime', '<', now())->count(),

            'total_products' => Product::count(),
            'low_stock_products' => Product::lowStock()->count(),
            'out_of_stock' => Product::where('qty', 0)->count(),

            'total_galleries' => Gallery::count(),
            'published_galleries' => Gallery::where('status', 'published')->count(),

            'recent_circulars' => Circular::latest()->take(5)->get(),
        ];

        $recentPosts = Post::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::upcoming()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'upcomingEvents'));
    }
}
