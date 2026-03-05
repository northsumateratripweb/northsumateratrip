<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
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
        if (!$this->featured_image) {
            return asset('images/default-hotel.jpg');
        }
        return str_starts_with($this->featured_image, 'http')
            ? $this->featured_image
            : asset('storage/' . $this->featured_image);
    }
}
