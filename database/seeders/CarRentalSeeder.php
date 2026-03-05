<?php

namespace Database\Seeders;

use App\Models\CarRental;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarRentalSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [

            // ── City Cars ──────────────────────────────────────────────────
            [
                'name'              => 'Toyota Avanza',
                'description'       => '<p>Toyota Avanza adalah pilihan terpopuler untuk road trip keluarga di Sumatera Utara. Nyaman untuk perjalanan dalam kota maupun luar kota seperti Berastagi, Parapat, hingga Danau Toba.</p><ul><li>Kapasitas 6 penumpang</li><li>AC Double Blower</li><li>Koneksi audio Bluetooth</li></ul>',
                'capacity'          => 6,
                'transmission'      => 'Manual',
                'fuel_type'         => 'Bensin',
                'year'              => 2022,
                'price_per_day'     => 300000,
                'price_per_12_hours'=> 200000,
                'price_with_driver' => 450000,
                'features'          => ['AC', 'Audio Bluetooth', 'Power Window', 'GPS Tracker'],
                'includes'          => ['Mobil dengan BBM (khusus dalam kota)', 'Supir berpengalaman (opsional)'],
                'terms'             => 'Minimal sewa 12 jam. BBM ditanggung penyewa untuk perjalanan luar kota. Dilarang membawa hewan peliharaan.',
                'is_available'      => true,
                'is_featured'       => true,
                'sort_order'        => 1,
            ],
            [
                'name'              => 'Toyota Avanza Veloz',
                'description'       => '<p>Versi premium Toyota Avanza dengan tampilan sporty dan fitur yang lebih lengkap. Cocok untuk wisatawan yang menginginkan kenyamanan lebih dengan budget terjangkau.</p>',
                'capacity'          => 7,
                'transmission'      => 'Manual',
                'fuel_type'         => 'Bensin',
                'year'              => 2023,
                'price_per_day'     => 350000,
                'price_per_12_hours'=> 230000,
                'price_with_driver' => 500000,
                'features'          => ['AC Double Blower', 'Audio Bluetooth', 'Power Window', 'Roof Rail', 'Keyless Entry'],
                'includes'          => ['Mobil + BBM (dalam kota)'],
                'terms'             => 'Minimal sewa 12 jam. BBM ditanggung penyewa untuk perjalanan luar kota.',
                'is_available'      => true,
                'is_featured'       => false,
                'sort_order'        => 2,
            ],
            [
                'name'              => 'Daihatsu Xenia',
                'description'       => '<p>Alternatif hemat yang tidak kalah nyaman. Daihatsu Xenia cocok untuk perjalanan keluarga kecil atau pasangan yang ingin berwisata ke Sumatera Utara.</p>',
                'capacity'          => 6,
                'transmission'      => 'Manual',
                'fuel_type'         => 'Bensin',
                'year'              => 2021,
                'price_per_day'     => 280000,
                'price_per_12_hours'=> 185000,
                'price_with_driver' => 420000,
                'features'          => ['AC', 'Audio', 'Power Window'],
                'includes'          => ['Mobil + BBM (dalam kota)'],
                'terms'             => 'Minimal sewa 12 jam. BBM ditanggung penyewa untuk perjalanan luar kota.',
                'is_available'      => true,
                'is_featured'       => false,
                'sort_order'        => 3,
            ],

            // ── Premium / SUV ──────────────────────────────────────────────
            [
                'name'              => 'Toyota Kijang Innova',
                'description'       => '<p>Toyota Innova adalah pilihan premium untuk road trip ke Sumatera Utara. Dengan suspensi yang nyaman dan ruang kabin luas, sangat ideal untuk perjalanan jauh seperti Medan–Samosir atau Medan–Nias.</p><ul><li>Kapasitas 7 penumpang + bagasi besar</li><li>Suspensi independently untuk kenyamanan di jalan pegunungan</li><li>Dashboard premium dengan layar sentuh</li></ul>',
                'capacity'          => 7,
                'transmission'      => 'Manual',
                'fuel_type'         => 'Solar',
                'year'              => 2022,
                'price_per_day'     => 500000,
                'price_per_12_hours'=> 330000,
                'price_with_driver' => 650000,
                'features'          => ['AC Double Blower', 'Audio Touchscreen', 'Kamera Parkir', 'Suspensi Comfort', 'Bagasi Besar'],
                'includes'          => ['Mobil + BBM (dalam kota)'],
                'terms'             => 'Minimal sewa 1 hari (24 jam). BBM ditanggung penyewa untuk perjalanan luar kota.',
                'is_available'      => true,
                'is_featured'       => true,
                'sort_order'        => 4,
            ],
            [
                'name'              => 'Toyota Innova Reborn',
                'description'       => '<p>Generasi terbaru Innova dengan performa mesin yang lebih bertenaga dan desain interior premium. Pilihan terbaik untuk rombongan wisatawan yang menginginkan kenyamanan maksimal.</p>',
                'capacity'          => 7,
                'transmission'      => 'Automatic',
                'fuel_type'         => 'Solar',
                'year'              => 2024,
                'price_per_day'     => 650000,
                'price_per_12_hours'=> 430000,
                'price_with_driver' => 800000,
                'features'          => ['AC Triple Zone', 'Touchscreen 9"', 'Kamera 360°', 'Blind Spot Monitor', 'Cruise Control', 'Keyless Engine Start'],
                'includes'          => ['Mobil + BBM (dalam kota)'],
                'terms'             => 'Minimal sewa 1 hari (24 jam). BBM ditanggung penyewa untuk perjalanan luar kota.',
                'is_available'      => true,
                'is_featured'       => true,
                'sort_order'        => 5,
            ],
            [
                'name'              => 'Mitsubishi Pajero Sport',
                'description'       => '<p>SUV tangguh untuk medan berat pegunungan Sumatera Utara. Sangat direkomendasikan untuk perjalanan ke Gunung Sinabung, Gunung Sibayak, atau jalur off-road Brastagi.</p>',
                'capacity'          => 7,
                'transmission'      => 'Automatic',
                'fuel_type'         => 'Solar',
                'year'              => 2023,
                'price_per_day'     => 750000,
                'price_per_12_hours'=> 500000,
                'price_with_driver' => 900000,
                'features'          => ['4WD', 'AC Triple Zone', 'Sunroof', 'Kamera 360°', 'Hill Start Assist', 'Cruise Control'],
                'includes'          => ['Mobil + BBM (dalam kota)'],
                'terms'             => 'Minimal sewa 1 hari. BBM dan tol ditanggung penyewa.',
                'is_available'      => true,
                'is_featured'       => true,
                'sort_order'        => 6,
            ],

            // ── Minibus ────────────────────────────────────────────────────
            [
                'name'              => 'Isuzu Elf (12 Seat)',
                'description'       => '<p>Minibus Isuzu Elf kapasitas 12 kursi, solusi ideal untuk rombongan besar. Biasa digunakan untuk paket wisata grup ke Danau Toba, Berastagi, atau city tour Medan.</p><ul><li>12 kursi + 1 supir</li><li>AC full kabin</li><li>Bagasi atas yang luas</li></ul>',
                'capacity'          => 12,
                'transmission'      => 'Manual',
                'fuel_type'         => 'Solar',
                'year'              => 2021,
                'price_per_day'     => 700000,
                'price_per_12_hours'=> 490000,
                'price_with_driver' => 850000,
                'features'          => ['AC Full Kabin', 'Bagasi Atas', 'Sound System', 'Mikrofon'],
                'includes'          => ['Mobil + BBM (dalam kota)', 'Supir berpengalaman'],
                'terms'             => 'Minimal sewa 1 hari. BBM dan tol ditanggung penyewa. Wajib didampingi supir.',
                'is_available'      => true,
                'is_featured'       => false,
                'sort_order'        => 7,
            ],
            [
                'name'              => 'Toyota HiAce Premio (15 Seat)',
                'description'       => '<p>Toyota HiAce Premio adalah minibus premium berkapasitas besar untuk rombongan. Interior luas dengan kursi reclining dan AC yang dingin, cocok untuk perjalanan jarak jauh ke Nias atau Samosir.</p>',
                'capacity'          => 15,
                'transmission'      => 'Manual',
                'fuel_type'         => 'Solar',
                'year'              => 2022,
                'price_per_day'     => 850000,
                'price_per_12_hours'=> 600000,
                'price_with_driver' => 1000000,
                'features'          => ['AC Full Kabin', 'Kursi Reclining', 'Mikrofon', 'USB Charger', 'Bagasi Bawah'],
                'includes'          => ['Mobil + BBM (dalam kota)', 'Supir berpengalaman'],
                'terms'             => 'Minimal sewa 1 hari. BBM, tol, dan parkir ditanggung penyewa. Wajib didampingi supir.',
                'is_available'      => true,
                'is_featured'       => true,
                'sort_order'        => 8,
            ],

        ];

        foreach ($cars as $car) {
            $car['slug'] = Str::slug($car['name']);
            CarRental::firstOrCreate(['slug' => $car['slug']], $car);
        }

        $this->command->info(count($cars) . ' data mobil rental berhasil disimpan.');
    }
}
