<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'vehicle_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Alias for product (compatibility)
     */
    public function tour()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Alias for vehicle (compatibility)
     */
    public function car()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
