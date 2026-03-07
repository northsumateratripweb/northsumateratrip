<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripImport extends Model
{
    protected $table = 'trip_imports';

    protected $fillable = [
        'tanggal', 'nama_pelanggan', 'status', 'nomor_hp', 'nama_driver',
        'layanan', 'plat_mobil', 'jenis_mobil', 'drone', 'jumlah_hari',
        'penumpang', 'hotel_1', 'hotel_2', 'hotel_3', 'hotel_4',
        'harga', 'deposit', 'pelunasan', 'tiba', 'flight_balik',
        'source_file', 'bulan', 'tahun',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'drone' => 'boolean',
        'harga' => 'decimal:2',
        'deposit' => 'decimal:2',
        'pelunasan' => 'decimal:2',
        'jumlah_hari' => 'integer',
        'penumpang' => 'integer',
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    /**
     * Scope for a specific month & year
     */
    public function scopeForMonth($query, int $year, int $month)
    {
        return $query->where('tahun', $year)->where('bulan', $month);
    }

    public function scopeForYear($query, int $year)
    {
        return $query->where('tahun', $year);
    }
}
