<?php

namespace App\Console\Commands;

use App\Services\TripImportService;
use Illuminate\Console\Command;

class ImportTrips extends Command
{
    /**
     * Jalankan: php artisan trips:import
     *
     * Opsi:
     *   --fresh   Hapus seluruh data lama sebelum import (default: tidak hapus)
     *   --file=   Import satu file tertentu, misal: --file="TRIP - MARET.csv"
     */
    protected $signature = 'trips:import
                            {--fresh : Truncate tabel trips sebelum import}
                            {--file= : Import hanya satu file CSV tertentu (path relatif dari root)}';

    protected $description = 'Import data trip dari semua file "TRIP - *.csv" di root project';

    public function handle(): int
    {
        $service = new TripImportService();

        // Import satu file spesifik
        if ($file = $this->option('file')) {
            $filePath = base_path($file);
            $bulan    = $this->extractMonth($file);

            $this->info("Mengimport: {$file} (bulan: {$bulan})...");
            $result = $service->importFile($filePath, $bulan);

            if (isset($result['error'])) {
                $this->error($result['error']);
                return self::FAILURE;
            }

            $this->info("[{$result['bulan']}] {$result['inserted']} data berhasil dimasukkan.");
            return self::SUCCESS;
        }

        // Import semua file
        $truncate = $this->option('fresh');

        if ($truncate && ! $this->confirm('Ini akan menghapus SEMUA data trip yang ada. Lanjutkan?', true)) {
            $this->warn('Import dibatalkan.');
            return self::SUCCESS;
        }

        $this->info('Mencari file TRIP - *.csv di root project...');
        $results = $service->importAll(truncate: $truncate);

        $total = 0;

        foreach ($results as $result) {
            if (isset($result['error'])) {
                $this->warn($result['error']);
            } else {
                $this->info("[{$result['bulan']}] {$result['inserted']} data dimasukkan.");
                $total += $result['inserted'];
            }
        }

        $this->newLine();
        $this->info("Selesai! Total {$total} data berhasil dimasukkan ke database.");

        return self::SUCCESS;
    }

    private function extractMonth(string $filename): string
    {
        $base  = pathinfo($filename, PATHINFO_FILENAME);
        $parts = explode(' - ', $base, 2);
        return isset($parts[1]) ? ucfirst(mb_strtolower(trim($parts[1]))) : 'Tidak Diketahui';
    }
}
