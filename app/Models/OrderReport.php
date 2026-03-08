<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReport extends Model
{
    protected $table = 'order_reports';

    protected $fillable = [
        'order_id',
        'report_type',
        'title',
        'description',
        'report_data',
        'generated_at',
    ];

    protected $casts = [
        'report_data' => 'array',
        'generated_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
