<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category_id',
        'user_id',
        'published_at',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the post
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
