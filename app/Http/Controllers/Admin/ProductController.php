<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by group
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        // Filter by stock level
        if ($request->filled('stock_level')) {
            if ($request->stock_level === 'in_stock') {
                $query->where('qty', '>', 0);
            } elseif ($request->stock_level === 'low_stock') {
                $query->where('qty', '<=', 10)->where('qty', '>', 0);
            } elseif ($request->stock_level === 'out_of_stock') {
                $query->where('qty', 0);
            }
        }

        // Search by title or SKU
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->paginate(15);
        $categories = ProductCategory::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:255|unique:products,sku',
            'category_id' => 'required|exists:product_categories,id',
            'group' => 'nullable|string|max:255',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'qty' => 'required|integer|min:0',
            'status' => 'required|in:available,pre_order,coming_soon,out_of_stock',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle primary image upload
        if ($request->hasFile('primary_image')) {
            $validated['primary_image'] = $this->uploadImage($request->file('primary_image'), 'products', 1200, 1200);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:product_categories,id',
            'group' => 'nullable|string|max:255',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'qty' => 'required|integer|min:0',
            'status' => 'required|in:available,pre_order,coming_soon,out_of_stock',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle primary image upload
        if ($request->hasFile('primary_image')) {
            if ($product->primary_image && Storage::disk('public')->exists($product->primary_image)) {
                Storage::disk('public')->delete($product->primary_image);
            }
            $validated['primary_image'] = $this->uploadImage($request->file('primary_image'), 'products', 1200, 1200);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete primary image if exists
        if ($product->primary_image && Storage::disk('public')->exists($product->primary_image)) {
            Storage::disk('public')->delete($product->primary_image);
        }

        // Delete all product images
        foreach ($product->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Upload and optimize image
     */
    private function uploadImage($file, $directory, $width, $height)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = $file->storeAs($directory, $filename, 'public');

        // Resize and optimize image
        $fullPath = storage_path('app/public/' . $path);
        Image::read($fullPath)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($fullPath, 85);

        return $path;
    }
}
