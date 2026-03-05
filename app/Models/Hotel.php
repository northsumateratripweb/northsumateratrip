<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use ResolvesImagePath;

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'rating',
        'featured_image',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->featured_image, 'images/hotels');
    }
}
