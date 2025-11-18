<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        // DEBUG: Check all posts and published posts
        if ($request->has('debug')) {
            $allPosts = Post::all();
            $publishedPosts = Post::published()->get();

            dd([
                'total_posts' => $allPosts->count(),
                'published_posts' => $publishedPosts->count(),
                'all_posts_detail' => $allPosts->map(function($p) {
                    return [
                        'id' => $p->id,
                        'title' => $p->title,
                        'status' => $p->status,
                        'published_at' => $p->published_at ? $p->published_at->format('Y-m-d H:i:s') : 'NULL',
                        'is_future' => $p->published_at && $p->published_at->isFuture(),
                        'now' => now()->format('Y-m-d H:i:s'),
                    ];
                }),
            ]);
        }

        $query = Post::published();

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->with('category')
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount(['posts' => function($query) {
            $query->where('status', 'published')
                  ->whereNotNull('published_at')
                  ->where('published_at', '<=', now());
        }])->get();

        return view('news.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Get recent posts
        $recentPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Get all categories
        $categories = Category::withCount(['posts' => function($query) {
            $query->where('status', 'published')
                  ->whereNotNull('published_at')
                  ->where('published_at', '<=', now());
        }])->get();

        return view('news.show', compact('post', 'recentPosts', 'categories'));
    }
}
