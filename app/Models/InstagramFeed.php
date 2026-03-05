<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramFeed extends Model
{
    protected $fillable = ['post_id', 'image_url', 'caption', 'permalink', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
