<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $vehicle_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $capacity
 * @property int $price_per_day
 * @property int|null $price_per_12_hours
 * @property int|null $price_with_driver
 * @property string|null $transmission
 * @property string|null $fuel_type
 * @property int|null $year
 * @property array|null $features
 * @property array|null $includes
 * @property string|null $terms
 * @property string|null $featured_image
 * @property array|null $gallery_images
 * @property array|null $pricing_details
 * @property bool $is_available
 * @property bool $is_featured
 * @property int $sort_order
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Vehicle|null $vehicle
 */
class CarRental extends Model
{
    use ResolvesImagePath;

    protected $fillable = [
        'vehicle_id',
        'name',
        'category',
        'slug',
        'description',
        'capacity',
        'price_per_day',
        'price_per_12_hours',
        'price_with_driver',
        'transmission',
        'fuel_type',
        'year',
        'features',
        'includes',
        'terms',
        'featured_image',
        'gallery_images',
        'is_available',
        'is_featured',
        'sort_order',
        'meta_title',
        'meta_description',
        'pricing_details',
    ];

    protected $casts = [
        'features' => 'array',
        'includes' => 'array',
        'gallery_images' => 'array',
        'pricing_details' => 'array',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'price_per_day' => 'integer',
        'price_per_12_hours' => 'integer',
        'price_with_driver' => 'integer',
        'capacity' => 'integer',
        'year' => 'integer',
        'sort_order' => 'integer',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->featured_image, 'images/car-rentals');
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery_images)) {
            return [];
        }
        return array_map(fn ($img) => self::resolveImagePath($img, 'images/car-rentals'), $this->gallery_images);
    }

    public function getBrandAttribute(): ?string
    {
        return $this->vehicle?->brand;
    }

    public function rentalSchedules()
    {
        return $this->hasMany(RentalSchedule::class);
    }
}
