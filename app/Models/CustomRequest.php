<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'trip_date',
        'trip_duration',
        'num_persons',
        'destinations',
        'budget_range',
        'accommodation_type',
        'transport_type',
        'special_requests',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'trip_date' => 'date',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new'       => 'Baru',
            'reviewed'  => 'Ditinjau',
            'responded' => 'Ditanggapi',
            'closed'    => 'Selesai',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'new'       => 'blue',
            'reviewed'  => 'yellow',
            'responded' => 'green',
            'closed'    => 'gray',
            default     => 'gray',
        };
    }

    public static function budgetOptions(): array
    {
        return [
            'dibawah-500rb'  => 'Di bawah Rp 500.000/pax',
            '500rb-1jt'      => 'Rp 500.000 – Rp 1.000.000/pax',
            '1jt-2jt'        => 'Rp 1.000.000 – Rp 2.000.000/pax',
            '2jt-5jt'        => 'Rp 2.000.000 – Rp 5.000.000/pax',
            'diatas-5jt'     => 'Di atas Rp 5.000.000/pax',
            'fleksibel'      => 'Fleksibel / Terbuka',
        ];
    }

    public static function accommodationOptions(): array
    {
        return [
            'tidak-perlu'   => 'Tidak perlu akomodasi',
            'guesthouse'    => 'Guesthouse / homestay',
            'hotel-bintang-2-3' => 'Hotel bintang 2–3',
            'hotel-bintang-4-5' => 'Hotel bintang 4–5',
            'resort'        => 'Resort / villa',
        ];
    }

    public static function transportOptions(): array
    {
        return [
            'mobil-private'  => 'Mobil private (sedan/MPV)',
            'hiace'          => 'Hiace / minibus',
            'minibus'        => 'Minibus (10–15 pax)',
            'bus'            => 'Bus',
            'tanpa-transport' => 'Tanpa transportasi',
        ];
    }
}
