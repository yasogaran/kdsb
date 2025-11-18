<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'brand',
        'gtin',
        'mpn',
        'condition',
        'category_id',
        'group',
        'primary_image',
        'about',
        'description',
        'price',
        'sale_price',
        'currency',
        'price_valid_until',
        'qty',
        'availability_date',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'qty' => 'integer',
        'price_valid_until' => 'date',
        'availability_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('qty', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('qty', '<', $threshold)->where('qty', '>', 0);
    }
}
