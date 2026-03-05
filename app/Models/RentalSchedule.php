<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSchedule extends Model
{
    protected $fillable = [
        'car_rental_id',
        'order_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'start_date',
        'end_date',
        'rental_days',
        'pickup_location',
        'dropoff_location',
        'with_driver',
        'notes',
        'total_price',
        'payment_status',
        'rental_status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'with_driver' => 'boolean',
        'rental_days' => 'integer',
        'total_price' => 'integer',
    ];

    public function carRental(): BelongsTo
    {
        return $this->belongsTo(CarRental::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->rental_status) {
            'booked'    => 'Dipesan',
            'ongoing'   => 'Dalam Perjalanan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default     => ucfirst($this->rental_status),
        };
    }
}
