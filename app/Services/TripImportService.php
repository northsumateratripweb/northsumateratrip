<?php

namespace App\Services;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Menangani import data trip dari file CSV.
 *
 * Konvensi nama file: "TRIP - <NamaBulan>.csv" (contoh: "TRIP - JANUARI.csv")
 * File diletakkan di root project (base_path()).
 */
class TripImportService
{
    /** Bulan Indo → slug untuk normalise nama dari filename */
    protected const MONTH_MAP = [
        'januari'   => 'Januari',
        'februari'  => 'Februari',
        'maret'     => 'Maret',
        'april'     => 'April',
        'mei'       => 'Mei',
        'juni'      => 'Juni',
        'juli'      => 'Juli',
        'agustus'   => 'Agustus',
        'september' => 'September',
        'oktober'   => 'Oktober',
        'november'  => 'November',
        'desember'  => 'Desember',
    ];

    /**
     * Import semua file TRIP - *.csv dari root project.
     *
     * @param  bool  $truncate  Hapus seluruh data lama sebelum import
     * @return array<int, array{bulan: string, inserted: int}|array{error: string}>
     */
    public function importAll(bool $truncate = false): array
    {
        // Auto-discover semua file CSV sesuai pola
        $files = glob(base_path('TRIP - *.csv'));
        $files = $files ?: [];

        // Urutkan berdasar nama bulan agar konsisten
        sort($files);

        if (empty($files)) {
            return [['error' => 'Tidak ada file "TRIP - *.csv" di root project.']];
        }

        if ($truncate) {
            DB::table('trips')->truncate();
        }

        $results = [];

        foreach ($files as $filePath) {
            $bulan   = $this->extractMonth($filePath);
            $results[] = $this->importFile($filePath, $bulan);
        }

        return $results;
    }

    /**
     * Import satu file CSV.
     *
     * @return array{bulan: string, inserted: int}|array{error: string}
     */
    public function importFile(string $filePath, string $bulan): array
    {
        if (! file_exists($filePath)) {
            return ['error' => "File tidak ditemukan: {$filePath}"];
        }

        $handle = fopen($filePath, 'r');

        if (! $handle) {
            return ['error' => "Gagal membuka: {$filePath}"];
        }

        // Baca & normalise header
        $rawHeader = fgetcsv($handle);
        $header    = array_map(fn ($h) => mb_strtolower(trim($h)), $rawHeader);

        $inserted = 0;

        while (($row = fgetcsv($handle)) !== false) {
            // Pad agar jumlah kolom data = header (file kadang ada kolom kosong di akhir)
            while (count($row) < count($header)) {
                $row[] = '';
            }

            $data = array_combine($header, array_slice($row, 0, count($header)));

            // Lewati baris yang tidak punya tanggal DAN nama pelanggan
            $hasDate     = trim($data['tanggal'] ?? '') !== '';
            $hasCustomer = trim($data['nama pelanggan'] ?? '') !== '';

            if (! $hasDate && ! $hasCustomer) {
                continue;
            }

            Trip::create($this->mapRow($data, $bulan));
            $inserted++;
        }

        fclose($handle);

        return ['bulan' => $bulan, 'inserted' => $inserted];
    }

    // -----------------------------------------------------------------
    //  Private helpers
    // -----------------------------------------------------------------

    /** Ambil nama bulan dari nama file, misal "TRIP - JANUARI.csv" → "Januari" */
    protected function extractMonth(string $filePath): string
    {
        $filename = pathinfo($filePath, PATHINFO_FILENAME);       // "TRIP - JANUARI"
        $parts    = explode(' - ', $filename, 2);                  // ["TRIP", "JANUARI"]
        $raw      = isset($parts[1]) ? mb_strtolower(trim($parts[1])) : '';

        return self::MONTH_MAP[$raw] ?? ucfirst(mb_strtolower($raw)) ?: 'Tidak Diketahui';
    }

    /** Petakan 1 baris CSV ke array yang siap disimpan */
    protected function mapRow(array $data, string $bulan): array
    {
        $nullable = fn (string $key) =>
            trim($data[$key] ?? '') !== '' ? trim($data[$key]) : null;

        $integer = function (string $key) use ($data): ?int {
            $val = preg_replace('/[^0-9]/', '', $data[$key] ?? '');
            return $val !== '' ? (int) $val : null;
        };

        // Parse tanggal format DD/MM/YYYY
        $tanggal = null;
        $rawDate = trim($data['tanggal'] ?? '');
        if ($rawDate !== '') {
            try {
                $tanggal = Carbon::createFromFormat('d/m/Y', $rawDate)->toDateString();
            } catch (\Exception) {
                $tanggal = null;
            }
        }

        return [
            'bulan'          => $bulan,
            'tanggal'        => $tanggal,
            'nama_pelanggan' => $nullable('nama pelanggan'),
            'status'         => $this->mapStatus($nullable('status')),
            'nomor_hp'       => $nullable('nomor hp'),
            'nama_driver'    => $nullable('nama driver'),
            'layanan'        => $nullable('layanan'),
            'plat_mobil'     => $nullable('plat mobil'),
            'jenis_mobil'    => $nullable('jenis mobil'),
            'drone'          => strtolower(trim($data['drone'] ?? 'false')) === 'true',
            'jumlah_hari'    => $integer('jumlah hari'),
            'penumpang'      => $nullable('penumpang'),
            'hotel_1'        => $nullable('hotel 1'),
            'hotel_2'        => $nullable('hotel 2'),
            'hotel_3'        => $nullable('hotel 3'),
            'hotel_4'        => $nullable('hotel 4'),
            'harga'          => $integer('harga'),
            'deposit'        => $integer('deposit'),
            'pelunasan'      => $integer('pelunasan'),
            'tiba'           => $nullable('tiba'),
            'flight_balik'   => $nullable('flight balik'),
        ];
    }

    protected function mapStatus(?string $raw): string
    {
        if ($raw === null) return 'pending';

        return match (Str::lower($raw)) {
            'confirmed', 'dikonfirmasi', 'terkonfirmasi' => 'confirmed',
            'ongoing', 'berlangsung'                     => 'ongoing',
            'completed', 'selesai'                       => 'completed',
            'cancelled', 'dibatalkan', 'batal'           => 'cancelled',
            default                                      => 'pending',
        };
    }
}
