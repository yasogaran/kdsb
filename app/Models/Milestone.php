<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'year',
        'title',
        'description',
        'image',
        'display_order',
    ];

    protected $casts = [
        'year' => 'integer',
        'display_order' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('year', 'desc');
    }
}
