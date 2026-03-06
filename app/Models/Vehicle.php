<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use ResolvesImagePath, \App\Traits\OptimizesImages;
    
    public $optimizableImages = ['thumbnail'];

    protected $fillable = [
        'name',
        'plate_number',
        'capacity',
        'type',
        'brand',
        'thumbnail',
        'price_per_day',
        'transmission',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->thumbnail, 'images/vehicles');
    }
}
