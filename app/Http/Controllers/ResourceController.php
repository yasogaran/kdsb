<?php

namespace App\Http\Controllers;

use App\Models\Circular;
use App\Models\Syllabus;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function circulars(Request $request)
    {
        $query = Circular::query();

        // Filter by year
        if ($request->has('year')) {
            $query->whereYear('date', $request->year);
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('reference_number', 'like', '%' . $request->search . '%');
            });
        }

        $circulars = $query->latest('date')->paginate(20);

        // Get available years
        $years = Circular::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Get available categories
        $categories = Circular::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('resources.circulars', compact('circulars', 'years', 'categories'));
    }

    public function syllabus()
    {
        $syllabi = Syllabus::orderBy('category')->get();

        // Group by category
        $groupedSyllabi = $syllabi->groupBy('category');

        return view('resources.syllabus', compact('groupedSyllabi'));
    }
}
