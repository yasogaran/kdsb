<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Circular extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'circular_number',
        'circular_code',
        'title',
        'slug',
        'category',
        'description',
        'file_type',
        'file_path',
        'external_link',
        'published_date',
        'is_pinned',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_pinned' => 'boolean',
    ];

    /**
     * Boot the model and auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($circular) {
            if (empty($circular->slug)) {
                $circular->slug = static::generateUniqueSlug($circular->title);
            }
        });

        static::updating(function ($circular) {
            if ($circular->isDirty('title') && empty($circular->slug)) {
                $circular->slug = static::generateUniqueSlug($circular->title);
            }
        });
    }

    /**
     * Generate a unique slug from the title
     */
    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists and append number if needed
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_date', 'desc');
    }
}
