<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    /**
     * Store newly uploaded images to gallery
     */
    public function store(Request $request, Gallery $gallery)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $uploadedImages = [];
        $currentMaxOrder = $gallery->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            // Upload and process image
            $imagePath = $this->uploadImage($image, 'galleries/images', 1200, 900);

            // Get caption if provided
            $caption = $request->captions[$index] ?? null;

            // Create gallery image record
            $galleryImage = GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image_path' => $imagePath,
                'caption' => $caption,
                'sort_order' => ++$currentMaxOrder,
            ]);

            $uploadedImages[] = $galleryImage;
        }

        // Update gallery image count
        $gallery->update([
            'image_count' => $gallery->images()->count()
        ]);

        return response()->json([
            'success' => true,
            'message' => count($uploadedImages) . ' image(s) uploaded successfully.',
            'images' => $uploadedImages->load('gallery')
        ]);
    }

    /**
     * Update sort order of images
     */
    public function updateOrder(Request $request, Gallery $gallery)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:gallery_images,id',
        ]);

        foreach ($request->order as $index => $imageId) {
            GalleryImage::where('id', $imageId)
                ->where('gallery_id', $gallery->id)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Image order updated successfully.'
        ]);
    }

    /**
     * Update image caption
     */
    public function updateCaption(Request $request, GalleryImage $image)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $image->update([
            'caption' => $request->caption
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Caption updated successfully.'
        ]);
    }

    /**
     * Delete an image from gallery
     */
    public function destroy(GalleryImage $image)
    {
        $gallery = $image->gallery;

        // Delete image file from storage
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        // Update gallery image count
        $gallery->update([
            'image_count' => $gallery->images()->count()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.'
        ]);
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
