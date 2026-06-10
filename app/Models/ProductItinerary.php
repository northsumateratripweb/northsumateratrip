<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItinerary extends Model
{
    protected $fillable = [
        'product_id',
        'day',
        'title',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
