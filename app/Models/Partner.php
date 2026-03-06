<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory, ResolvesImagePath, \App\Traits\OptimizesImages;
    
    public $optimizableImages = ['logo'];

    protected $fillable = [
        'name',
        'logo',
        'website',
        'description',
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

    public function getLogoUrlAttribute(): string
    {
        return self::resolveImagePath($this->logo, 'images/partners');
    }
}
