<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripSchedule extends Model
{
    protected $fillable = [
        'order_id',
        'vehicle_id',
        'driver_name',
        'driver_phone',
        'trip_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'trip_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'scheduled'  => 'Terjadwal',
            'ongoing'    => 'Berlangsung',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'scheduled'  => 'blue',
            'ongoing'    => 'yellow',
            'completed'  => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }
}
