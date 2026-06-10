<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarRentalPricing extends Model
{
    protected $fillable = [
        'car_rental_id',
        'days',
        'price',
    ];

    public function carRental()
    {
        return $this->belongsTo(CarRental::class);
    }
}
