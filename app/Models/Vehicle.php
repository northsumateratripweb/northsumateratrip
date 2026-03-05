<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
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
        if (!$this->thumbnail) {
            return asset('images/default-car.jpg');
        }
        return str_starts_with($this->thumbnail, 'http') 
            ? $this->thumbnail 
            : asset('storage/' . $this->thumbnail);
    }
}
