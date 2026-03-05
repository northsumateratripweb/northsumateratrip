<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Model;

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
    use ResolvesImagePath;

    protected $fillable = [
        'name',
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
    ];

    protected $casts = [
        'includes' => 'array',
        'excludes' => 'array',
        'is_active' => 'boolean',
        'price_per_day' => 'integer',
        'min_rental_days' => 'integer',
        'max_rental_days' => 'integer',
        'sort_order' => 'integer',
    ];
    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->featured_image, 'images/rental-packages');
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
