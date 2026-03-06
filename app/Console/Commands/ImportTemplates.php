<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\CarRental;
use App\Models\RentalPackage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ImportTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import template data for Products, Vehicles, Car Rentals, and Rental Packages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Memulai pembuatan template data...");

        // 1. Kategori Template
        try {
            $category = Category::firstOrCreate(
                ['slug' => 'paket-wisata-danau-toba'],
                [
                    'name' => 'Paket Wisata Danau Toba',
                    'icon' => 'heroicon-o-map',
                    'description' => 'Berbagai pilihan paket wisata menarik di sekitar Danau Toba dan Sumatera Utara.',
                    'is_active' => true,
                    'sort_order' => 1
                ]
            );
            $this->info("Category OK");
        } catch (\Throwable $e) {
            $this->error("Category Error: " . $e->getMessage());
            return;
        }

        // 2. Paket Wisata (Product) Template
        $this->info("Membuat template Paket Wisata...");
        $productsData = [
            [
                'name' => '[TEMPLATE] Private Trip Samosir 2 Hari 1 Malam',
                'category_id' => $category->id,
                'short_description' => 'Jelajahi keindahan Pulau Samosir dengan perjalanan eksklusif selama 2 hari.',
                'description' => '<p>Paket wisata eksklusif ini cocok untuk Anda yang ingin liburan santai...</p>',
                'location_tag' => 'Samosir, Danau Toba',
                'duration' => '2 Hari 1 Malam',
                'price_min' => 1250000,
                'price_max' => 1500000,
                'rating' => 5.0,
                'review_count' => 12,
                'featured_image' => 'placeholder.webp',
                'is_active' => false,
                'pricing_details' => [
                    ['pax' => '2-3', 'price' => 1500000, 'note' => 'Per pax'],
                    ['pax' => '4-6', 'price' => 1350000, 'note' => 'Per pax'],
                    ['pax' => '7-10', 'price' => 1250000, 'note' => 'Per pax']
                ],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Tiba di Bandara & Menuju Parapat', 'description' => '<p>Penjemputan di Kualanamu, langsung menuju Parapat.</p>'],
                    ['day' => 2, 'title' => 'Eksplorasi Samosir & Pulang', 'description' => '<p>Keliling objek wisata di Samosir (Desa Tomok, dll).</p>']
                ],
                'includes' => ['Transportasi AC', 'Akomodasi 1 Malam', 'Makan 3x', 'Tiket Masuk'],
                'excludes' => ['Tiket Pesawat', 'Pengeluaran Pribadi', 'Tipping']
            ],
            [
                 'name' => '[TEMPLATE] One Day Tour Berastagi',
                 'category_id' => $category->id,
                 'short_description' => 'Tour sehari penuh menikmati udara sejuk dan pemandangan alam Berastagi.',
                 'description' => '<p>Nikmati perjalanan singkat tapi berkesan ke daerah pegunungan Berastagi...</p>',
                 'featured_image' => 'placeholder.webp',
                 'location_tag' => 'Berastagi, Karo',
                 'duration' => '1 Hari',
                 'price_min' => 450000,
                 'price_max' => 600000,
                 'rating' => 4.8,
                 'review_count' => 8,
                 'is_active' => false,
                 'itinerary' => [
                     ['day' => 1, 'title' => 'Eksplorasi Berastagi', 'description' => '<p>Penjemputan di hotel Medan, lalu menuju Pasar Buah Berastagi dan Air Terjun Sipiso-piso.</p>']
                 ],
                 'includes' => ['Transportasi PP', 'Tiket Wisata', 'Snack', 'Air Mineral'],
                 'excludes' => ['Makan Siang', 'Asuransi']
            ]
        ];

        try {
            foreach ($productsData as $data) {
                $data['slug'] = Str::slug($data['name']);
                Product::updateOrCreate(['slug' => $data['slug']], $data);
            }
            $this->info("Products OK");
        } catch (\Throwable $e) {
            $this->error("Product Error: " . $e->getMessage());
        }

        // 3. Armada/Vehicle Template
        $this->info("Membuat template Armada & Kendaraan...");
        $vehicleInfo = [
            ['name' => '[TEMPLATE] Toyota Innova Reborn', 'type' => 'MPV', 'capacity' => 7, 'brand' => 'Toyota', 'transmission' => 'Automatic / Manual', 'price_per_day' => 800000, 'plate_number' => 'T-REB-01'],
            ['name' => '[TEMPLATE] Toyota Hiace Commuter', 'type' => 'Minibus', 'capacity' => 15, 'brand' => 'Toyota', 'transmission' => 'Manual', 'price_per_day' => 1200000, 'plate_number' => 'T-HIA-01']
        ];
        
        try {
            $vehicles = [];
            foreach ($vehicleInfo as $v) {
                $vehicles[] = Vehicle::updateOrCreate(['name' => $v['name']], $v + ['is_active' => false]);
            }
            $this->info("Vehicles OK");
        } catch (\Throwable $e) {
            $this->error("Vehicle Error: " . $e->getMessage());
        }

        // 4. Car Rental Template
        if (!empty($vehicles)) {
            $this->info("Membuat template Rental Per Mobil...");
            $rentalData = [
                [
                    'vehicle_id' => $vehicles[0]->id ?? null,
                    'name' => '[TEMPLATE] Sewa Innova Reborn + Supir',
                    'category' => 'MPV',
                    'capacity' => 7,
                    'price_per_day' => 800000,
                    'price_per_12_hours' => 600000,
                    'price_with_driver' => 800000,
                    'transmission' => 'Automatic',
                    'fuel_type' => 'Bensin/Diesel',
                    'year' => 2022,
                    'is_active' => false,
                    'is_available' => false,
                    'features' => ['AC Dingin', 'Kabin Luas', 'Audio USB', 'Airbag'],
                    'includes' => ['Mobil', 'Supir Berpengalaman', 'Air Mineral'],
                    'terms' => 'Harga belum termasuk BBM, Tol, dan Parkir.'
                ],
                [
                     'vehicle_id' => $vehicles[1]->id ?? null,
                     'name' => '[TEMPLATE] Sewa Hiace Commuter Group',
                     'category' => 'Minibus',
                     'capacity' => 15,
                     'price_per_day' => 1200000,
                     'price_per_12_hours' => 900000,
                     'price_with_driver' => 1200000,
                     'transmission' => 'Manual',
                     'fuel_type' => 'Diesel',
                     'year' => 2021,
                     'is_active' => false,
                     'is_available' => false,
                     'features' => ['AC Per Kepala', 'Kapasitas 15 Orang', 'Reclining Seat'],
                     'includes' => ['Mobil', 'Supir Pariwisata', 'Microphone'],
                     'terms' => 'Pemesanan maksimal H-3.'
                 ]
            ];

            try {
                foreach ($rentalData as $data) {
                    $data['slug'] = Str::slug($data['name']);
                    CarRental::firstOrCreate(['slug' => $data['slug']], $data);
                }
                $this->info("Rentals OK");
            } catch (\Throwable $e) {
                $this->error("Rental Error: " . $e->getMessage());
            }
        }

        // 5. Rental Packages Template
        $this->info("Membuat template Paket Rental...");
        $packageData = [
            [
                'name' => '[TEMPLATE] Paket Liburan Medan-Danau Toba 3D2N (Innova)',
                'description' => '<p>Paket sewa mobil all-in (Mobil+Driver+BBM) untuk rute Medan - Danau Toba.</p>',
                'price_per_day' => 950000,
                'min_rental_days' => 3,
                'includes' => ['Toyota Innova Reborn', 'Driver Pariwisata', 'BBM (Pertamax)', 'Makan Driver'],
                'excludes' => ['Biaya Tol', 'Parkir', 'Tiket Masuk Wisata'],
                'is_active' => false
            ],
            [
                'name' => '[TEMPLATE] Paket Group Wisata Hiace 4D3N',
                'description' => '<p>Sewa Hiace untuk rombongan keluarga atau kantor dengan rute Sumatera Utara.</p>',
                'price_per_day' => 1400000,
                'min_rental_days' => 4,
                'includes' => ['Toyota Hiace', 'Driver Pariwisata', 'BBM'],
                'excludes' => ['Tips Driver', 'Tol & Parkir'],
                'is_active' => false
            ]
        ];

        try {
            foreach ($packageData as $data) {
                $data['slug'] = Str::slug($data['name']);
                RentalPackage::firstOrCreate(['slug' => $data['slug']], $data);
            }
            $this->info("Rental Packages OK");
        } catch (\Throwable $e) {
            $this->error("Rental Package Error: " . $e->getMessage());
        }

        $this->info("Selesai! Semua template draf telah berhasil diimpor.");
    }
}
