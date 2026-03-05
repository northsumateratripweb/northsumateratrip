<?php

namespace Database\Seeders;

use App\Services\TripImportService;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{

    public function run(): void
    {
        $service = new TripImportService();
        $results = $service->importAll(truncate: true);

        $total = 0;

        foreach ($results as $result) {
            if (isset($result['error'])) {
                $this->command->warn($result['error']);
            } else {
                $this->command->info("[{$result['bulan']}] {$result['inserted']} data dimasukkan.");
                $total += $result['inserted'];
            }
        }

        $this->command->info("Total: {$total} data berhasil dimasukkan.");
    }
}
