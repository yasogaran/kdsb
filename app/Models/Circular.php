<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circular extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'circular_number',
        'circular_code',
        'title',
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

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_date', 'desc');
    }
}
