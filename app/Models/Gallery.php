<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use ResolvesImagePath;

    protected $fillable = [
        'title',
        'image_url',
        'caption',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getResolvedImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->image_url, 'images/galleries');
    }
}
