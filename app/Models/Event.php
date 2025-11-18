<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'start_datetime',
        'end_datetime',
        'registration_deadline',
        'location_type',
        'venue_name',
        'address',
        'map_link',
        'meeting_url',
        'summary',
        'content',
        'banner_image',
        'thumbnail_image',
        'organized_by',
        'organization_link',
        'status',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'registration_deadline' => 'datetime',
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>', now())
                     ->where('status', 'published')
                     ->orderBy('start_datetime', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('end_datetime', '<', now())
                     ->orderBy('start_datetime', 'desc');
    }
}
