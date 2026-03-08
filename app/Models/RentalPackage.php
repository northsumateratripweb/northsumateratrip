<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $price_per_day
 * @property int $min_rental_days
 * @property int $max_rental_days
 * @property array|null $includes
 * @property array|null $excludes
 * @property string|null $featured_image
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class RentalPackage extends Model
{
    use ResolvesImagePath, HasTranslations;

    protected $fillable = [
        'name',
        'category',
        'slug',
        'description',
        'price_per_day',
        'min_rental_days',
        'max_rental_days',
        'includes',
        'excludes',
        'featured_image',
        'is_active',
        'sort_order',
        'translations',
    ];

    protected $casts = [
        'includes' => 'array',
        'excludes' => 'array',
        'featured_image' => 'array',
        'is_active' => 'boolean',
        'price_per_day' => 'integer',
        'min_rental_days' => 'integer',
        'max_rental_days' => 'integer',
        'sort_order' => 'integer',
        'translations' => 'array',
    ];
    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->featured_image, 'images/rental-packages');
    }

    public function getAllImageUrlsAttribute(): array
    {
        $images = [];
        if (is_array($this->featured_image)) {
            foreach ($this->featured_image as $img) $images[] = self::resolveImagePath($img, 'images/rental-packages');
        } elseif ($this->featured_image) {
            $images[] = self::resolveImagePath($this->featured_image, 'images/rental-packages');
        }
        return array_values(array_unique($images));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function packageRentalSchedules()
    {
        return $this->hasMany(PackageRentalSchedule::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
