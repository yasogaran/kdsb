<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        $posts = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at if status is published and date not set
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Set current user as author
        $validated['user_id'] = auth()->id();

        // Set is_featured to false if not checked
        $validated['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'posts');
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $this->uploadImage($request->file('og_image'), 'posts/og');
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at if status is published and date not set
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Set is_featured to false if not checked
        $validated['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $this->uploadImage($request->file('image'), 'posts');
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            // Delete old OG image
            if ($post->og_image && Storage::disk('public')->exists($post->og_image)) {
                Storage::disk('public')->delete($post->og_image);
            }
            $validated['og_image'] = $this->uploadImage($request->file('og_image'), 'posts/og');
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Delete images if they exist
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        if ($post->og_image && Storage::disk('public')->exists($post->og_image)) {
            Storage::disk('public')->delete($post->og_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    /**
     * Upload and optimize image
     */
    private function uploadImage($file, $directory)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = $file->storeAs($directory, $filename, 'public');

        // Resize and optimize image
        $fullPath = storage_path('app/public/' . $path);
        Image::read($fullPath)
            ->resize(1200, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($fullPath, 85);

        return $path;
    }
}
