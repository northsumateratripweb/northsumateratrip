<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    protected $fillable = [
        'product_id',
        'pax',
        'price_per_person',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
