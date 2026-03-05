<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory, ResolvesImagePath;

    protected $fillable = [
        'product_id',
        'customer_name',
        'customer_email',
        'rating',
        'comment',
        'gallery_images',
        'avatar',
        'is_approved',
        'ip_address',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_approved' => 'boolean',
        'gallery_images' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery_images)) {
            return [];
        }
        return array_map(fn ($img) => self::resolveImagePath($img, 'images/reviews'), $this->gallery_images);
    }
}
