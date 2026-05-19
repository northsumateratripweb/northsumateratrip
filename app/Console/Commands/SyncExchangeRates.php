<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SyncExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronkan kurs konversi mata uang SGD dan MYR dari ExchangeRate-API secara otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi kurs mata uang...');

        $apiKey = '6b8dd2a09f5e5cdfbf15bd46';
        $url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/IDR";

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->failed()) {
                $this->error('Gagal mengambil data dari ExchangeRate-API. HTTP Status: ' . $response->status());
                return 1;
            }

            $data = $response->json();

            if (($data['result'] ?? '') !== 'success') {
                $this->error('API merespon dengan status gagal: ' . ($data['error-type'] ?? 'Unknown Error'));
                return 1;
            }

            $rates = $data['conversion_rates'] ?? [];
            $sgd = $rates['SGD'] ?? null;
            $myr = $rates['MYR'] ?? null;

            if (!$sgd || !$myr) {
                $this->error('Data kurs SGD atau MYR tidak ditemukan dalam respon API.');
                return 1;
            }

            // Simpan nilai ke Settings
            Setting::set('exchange_rate_sgd', (string) $sgd);
            Setting::set('exchange_rate_myr', (string) $myr);

            // Bersihkan cache settings
            Cache::forget('site_settings');
            Cache::forget('app_settings');

            $this->info("Kurs berhasil disinkronkan!");
            $this->line("SGD: 1 IDR = {$sgd} SGD (≈ Rp " . number_format(1 / $sgd, 2) . "/SGD)");
            $this->line("MYR: 1 IDR = {$myr} MYR (≈ Rp " . number_format(1 / $myr, 2) . "/MYR)");

            return 0;
        } catch (\Exception $e) {
            $this->error('Terjadi error saat sinkronisasi kurs: ' . $e->getMessage());
            return 1;
        }
    }
}
