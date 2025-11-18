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
        // Validate individual file sizes (max 12MB per image)
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:12288', // 12MB max per image
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        // Validate total upload size (max 100MB)
        $totalSize = 0;
        foreach ($request->file('images') as $image) {
            $totalSize += $image->getSize();
        }

        // Convert to MB and check limit
        $totalSizeMB = $totalSize / 1024 / 1024;
        if ($totalSizeMB > 100) {
            return response()->json([
                'success' => false,
                'message' => sprintf('Total upload size (%.2f MB) exceeds the maximum limit of 100 MB. Please reduce the number of images or compress them before uploading.', $totalSizeMB)
            ], 422);
        }

        $uploadedImages = [];
        $currentMaxOrder = $gallery->images()->max('sort_order') ?? 0;
        $tempFiles = [];

        try {
            foreach ($request->file('images') as $index => $image) {
                // Store temporary file path for cleanup
                $tempFiles[] = $image->getRealPath();

                // Upload and process image (reduces to max 3MB)
                $imagePath = $this->uploadAndOptimizeImage($image, 'galleries/images');

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

                // Clear memory after each image processing
                $this->clearImageMemory();
            }

            // Update gallery image count
            $gallery->update([
                'image_count' => $gallery->images()->count()
            ]);

            // Clean up temporary files
            $this->cleanupTempFiles($tempFiles);

            return response()->json([
                'success' => true,
                'message' => count($uploadedImages) . ' image(s) uploaded successfully.',
                'images' => $uploadedImages
            ]);
        } catch (\Exception $e) {
            // Clean up on error
            $this->cleanupTempFiles($tempFiles);

            // Delete any uploaded images if error occurs
            foreach ($uploadedImages as $uploadedImage) {
                if (Storage::disk('public')->exists($uploadedImage->image_path)) {
                    Storage::disk('public')->delete($uploadedImage->image_path);
                }
                $uploadedImage->delete();
            }

            return response()->json([
                'success' => false,
                'message' => 'Error uploading images: ' . $e->getMessage()
            ], 500);
        }
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
     * Upload and optimize image with size reduction to max 3MB
     */
    private function uploadAndOptimizeImage($file, $directory)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Ensure directory exists
        $dirPath = dirname($fullPath);
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        // Read and process image
        $image = Image::read($file->getRealPath());

        // Resize image to max 1920x1920 while maintaining aspect ratio
        $image->scale(width: 1920, height: 1920);

        // Start with quality 85 and reduce if needed to meet 3MB limit
        $quality = 85;
        $maxFileSize = 3 * 1024 * 1024; // 3MB in bytes

        do {
            // Save image with current quality
            $image->save($fullPath, $quality);

            // Check file size
            $fileSize = filesize($fullPath);

            // If size is acceptable, break
            if ($fileSize <= $maxFileSize) {
                break;
            }

            // Reduce quality for next iteration
            $quality -= 5;

            // Prevent infinite loop - stop at quality 20
            if ($quality < 20) {
                // If still too large at quality 20, resize further
                $image->scale(width: 1600, height: 1600);
                $image->save($fullPath, 20);
                break;
            }
        } while ($fileSize > $maxFileSize && $quality >= 20);

        return $path;
    }

    /**
     * Clear image memory cache for better performance
     */
    private function clearImageMemory()
    {
        // Force garbage collection
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }

        // Clear stat cache
        clearstatcache();
    }

    /**
     * Clean up temporary uploaded files
     */
    private function cleanupTempFiles(array $tempFiles)
    {
        foreach ($tempFiles as $tempFile) {
            if (file_exists($tempFile)) {
                try {
                    @unlink($tempFile);
                } catch (\Exception $e) {
                    // Silently fail - temp files will be cleaned by system eventually
                }
            }
        }
    }
}
