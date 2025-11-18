<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('published', true);

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

        $categories = Category::withCount('posts')->get();

        return view('news.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('published', true)
            ->where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Get recent posts
        $recentPosts = Post::where('published', true)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Get all categories
        $categories = Category::withCount('posts')->get();

        return view('news.show', compact('post', 'recentPosts', 'categories'));
    }
}
