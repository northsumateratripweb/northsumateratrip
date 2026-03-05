<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'bulan',
        'tanggal',
        'nama_pelanggan',
        'status',
        'nomor_hp',
        'nama_driver',
        'layanan',
        'plat_mobil',
        'jenis_mobil',
        'drone',
        'jumlah_hari',
        'penumpang',
        'hotel_1',
        'hotel_2',
        'hotel_3',
        'hotel_4',
        'harga',
        'deposit',
        'pelunasan',
        'tiba',
        'flight_balik',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'drone'   => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Belum Konfirmasi',
            'confirmed' => 'Terkonfirmasi',
            'ongoing'   => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default     => $this->status ?? '-',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'yellow',
            'confirmed' => 'blue',
            'ongoing'   => 'warning',
            'completed' => 'green',
            'cancelled' => 'red',
            default     => 'gray',
        };
    }

    /** Total yang sudah dibayar (deposit + pelunasan) */
    public function getTotalBayarAttribute(): int
    {
        return (int) $this->deposit + (int) $this->pelunasan;
    }

    /** Sisa yang belum dibayar */
    public function getSisaAttribute(): int
    {
        return max(0, (int) $this->harga - $this->total_bayar);
    }
}
