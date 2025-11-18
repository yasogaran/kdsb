<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class PublicGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::where('published', true);

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $galleries = $query->withCount('images')
            ->latest('created_at')
            ->paginate(12);

        return view('gallery.index', compact('galleries'));
    }

    public function show($slug)
    {
        $gallery = Gallery::where('published', true)
            ->where('slug', $slug)
            ->with('images')
            ->firstOrFail();

        return view('gallery.show', compact('gallery'));
    }
}
