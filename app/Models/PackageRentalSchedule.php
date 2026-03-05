<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageRentalSchedule extends Model
{
    protected $fillable = [
        'rental_package_id',
        'order_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'start_date',
        'end_date',
        'rental_days',
        'pickup_location',
        'destination',
        'number_of_people',
        'special_requests',
        'total_price',
        'payment_status',
        'booking_status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'rental_days' => 'integer',
        'number_of_people' => 'integer',
        'total_price' => 'integer',
    ];

    public function rentalPackage(): BelongsTo
    {
        return $this->belongsTo(RentalPackage::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->booking_status) {
            'confirmed' => 'Dikonfirmasi',
            'ongoing'   => 'Dalam Perjalanan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default     => ucfirst($this->booking_status),
        };
    }
}
