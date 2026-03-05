<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $category_id
 * @property string $name
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $location_tag
 * @property string|null $duration
 * @property float $price_min
 * @property float|null $child_price
 * @property float|null $price_max
 * @property float|null $drone_price
 * @property string|null $drone_location
 * @property string|null $price_display
 * @property float $rating
 * @property int $review_count
 * @property string|null $pre_order_info
 * @property string|null $featured_image
 * @property array|null $gallery_images
 * @property array|null $trip_options
 * @property array|null $pricing_details
 * @property array|null $includes
 * @property array|null $excludes
 * @property array|null $itinerary
 * @property string|null $notes
 * @property string|null $itinerary_text
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property int $sort_order
 * @property bool $is_featured
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Review> $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Review> $approvedReviews
 */
class Product extends Model
{
    use HasFactory, ResolvesImagePath;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'location_tag',
        'duration',
        'price_min',
        'child_price',
        'price_max',
        'drone_price',
        'drone_location',
        'price_display',
        'rating',
        'review_count',
        'pre_order_info',
        'featured_image',
        'gallery_images',
        'trip_options',
        'pricing_details',
        'includes',
        'excludes',
        'itinerary',
        'notes',
        'itinerary_text',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'child_price' => 'decimal:2',
        'drone_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'gallery_images' => 'array',
        'trip_options' => 'array',
        'pricing_details' => 'array',
        'includes' => 'array',
        'excludes' => 'array',
        'itinerary' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_min === $this->price_max) {
            return 'Rp '.number_format($this->price_min, 0, ',', '.');
        }

        return 'Rp '.number_format($this->price_min, 0, ',', '.').' - '.number_format($this->price_max, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->featured_image, 'images/products');
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery_images)) {
            return [];
        }
        return array_map(fn ($img) => self::resolveImagePath($img, 'images/products'), $this->gallery_images);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
