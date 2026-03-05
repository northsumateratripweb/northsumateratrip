<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $product_id
 * @property int|null $vehicle_id
 * @property int|null $rental_package_id
 * @property int|null $user_id
 * @property string $customer_name
 * @property string|null $customer_email
 * @property string $customer_phone
 * @property string|null $customer_whatsapp
 * @property string|null $trip_date
 * @property string|null $trip_end_date
 * @property string|null $trip_type
 * @property int $pax_adult
 * @property int $pax_child
 * @property int $quantity
 * @property int $total_price
 * @property string $status
 * @property string|null $notes
 * @property string|null $hotel_1
 * @property string|null $hotel_2
 * @property string|null $hotel_3
 * @property string|null $hotel_4
 * @property string|null $hotel_category
 * @property string|null $flight_info
 * @property bool $use_drone
 * @property string|null $payment_status
 * @property string|null $transaction_id
 * @property string|null $payment_proof
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Product|null $product
 * @property-read Vehicle|null $vehicle
 * @property-read RentalPackage|null $rentalPackage
 * @property-read TripSchedule|null $tripSchedule
 */
class Order extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->transaction_id) {
                $prefix = $model->vehicle_id ? 'CAR-' : 'TRIP-';
                $model->transaction_id = $prefix . strtoupper(substr(uniqid(), -8));
            }
        });
    }

    protected $fillable = [
        'product_id',
        'vehicle_id',
        'rental_package_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_whatsapp',
        'trip_date',
        'trip_end_date',
        'trip_type',
        'pax_adult',
        'pax_child',
        'quantity',
        'total_price',
        'status',
        'notes',
        'hotel_1',
        'hotel_2',
        'hotel_3',
        'hotel_4',
        'hotel_category',
        'flight_info',
        'use_drone',
        'payment_status',
        'transaction_id',
        'payment_proof',
    ];

    protected $casts = [
        'trip_date' => 'date',
        'trip_end_date' => 'date',
        'pax_adult' => 'integer',
        'pax_child' => 'integer',
        'quantity' => 'integer',
        'total_price' => 'integer',
        'use_drone' => 'boolean',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function rentalPackage()
    {
        return $this->belongsTo(RentalPackage::class);
    }

    public function packageRentalSchedule()
    {
        return $this->hasOne(PackageRentalSchedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tripSchedule()
    {
        return $this->hasOne(TripSchedule::class);
    }

    public function rentalSchedule()
    {
        return $this->hasOne(RentalSchedule::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Menunggu',
            'confirmed'  => 'Dikonfirmasi',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'yellow',
            'confirmed'  => 'blue',
            'completed'  => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }
}
