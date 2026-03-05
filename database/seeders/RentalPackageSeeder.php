<?php

namespace Database\Seeders;

use App\Models\RentalPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RentalPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [

            // ── Paket Harian ───────────────────────────────────────────────
            [
                'name'            => 'Paket Sewa Mobil Harian (Dalam Kota)',
                'description'     => '<p>Paket sewa mobil fleksibel per hari untuk kebutuhan transportasi dalam kota Medan dan sekitarnya. Tersedia berbagai pilihan armada dari City Car hingga MPV Premium.</p><ul><li>Berlaku untuk wilayah Kota Medan dan Kabupaten Deli Serdang</li><li>Supir tersedia dengan tambahan biaya</li><li>Bebas memilih armada sesuai kebutuhan</li></ul>',
                'price_per_day'   => 300000,
                'min_rental_days' => 1,
                'max_rental_days' => 30,
                'includes'        => ['Mobil AC', 'BBM dalam kota', 'Parkir', 'Asuransi kendaraan'],
                'excludes'        => ['Supir (opsional, tambahan Rp 150.000/hari)', 'Tol', 'BBM luar kota', 'Penginapan supir jika menginap'],
                'is_active'       => true,
                'sort_order'      => 1,
            ],
            [
                'name'            => 'Paket Sewa Mobil + Supir Harian',
                'description'     => '<p>Paket lengkap sewa mobil beserta supir berpengalaman untuk kemudahan perjalanan Anda. Supir kami menguasai rute-rute wisata populer di Sumatera Utara.</p>',
                'price_per_day'   => 450000,
                'min_rental_days' => 1,
                'max_rental_days' => 30,
                'includes'        => ['Mobil AC', 'Supir berpengalaman', 'BBM dalam kota', 'Parkir', 'Asuransi kendaraan'],
                'excludes'        => ['Tol', 'BBM luar kota', 'Tiket masuk wisata', 'Makan supir', 'Penginapan supir (jika menginap)'],
                'is_active'       => true,
                'sort_order'      => 2,
            ],

            // ── Paket Wisata Danau Toba ─────────────────────────────────────
            [
                'name'            => 'Paket Trip Danau Toba 2 Hari 1 Malam',
                'description'     => '<p>Paket wisata komplit ke Danau Toba dan Pulau Samosir selama 2 hari 1 malam. Meliputi transportasi PP dari Medan, penginapan tepi danau, dan kunjungan ke destinasi utama.</p><p><strong>Itinerari:</strong></p><ul><li>Hari 1: Medan → Parapat → Ferry ke Samosir → Desa Tomok → Check-in hotel</li><li>Hari 2: Pantai Parbaba → Simanindo → Museum Batak → Kembali ke Medan</li></ul>',
                'price_per_day'   => 550000,
                'min_rental_days' => 2,
                'max_rental_days' => 2,
                'includes'        => ['Mobil AC PP Medan–Parapat', 'Supir berpengalaman', 'BBM', 'Tiket ferry Parapat–Samosir', 'Penginapan 1 malam (twin share)', 'Air mineral'],
                'excludes'        => ['Tiket masuk destinasi wisata', 'Makan & minum', 'Pengeluaran pribadi', 'Naik kuda / wahana'],
                'is_active'       => true,
                'sort_order'      => 3,
            ],
            [
                'name'            => 'Paket Trip Danau Toba 3 Hari 2 Malam',
                'description'     => '<p>Eksplorasi Danau Toba dan Pulau Samosir secara mendalam selama 3 hari 2 malam. Waktu yang cukup untuk menikmati budaya Batak, wisata alam, dan kuliner khas Sumatera Utara.</p><p><strong>Itinerari:</strong></p><ul><li>Hari 1: Medan → Berastagi → Air Terjun Sipiso-piso → Parapat</li><li>Hari 2: Ferry ke Samosir → Tomok → Parbaba → Tuk-Tuk</li><li>Hari 3: Simanindo → Ambarita → Medan</li></ul>',
                'price_per_day'   => 600000,
                'min_rental_days' => 3,
                'max_rental_days' => 3,
                'includes'        => ['Mobil AC PP Medan–Samosir', 'Supir + Guide lokal', 'BBM', 'Tiket ferry 2x', 'Penginapan 2 malam (twin share)', 'Air mineral setiap hari'],
                'excludes'        => ['Tiket masuk wisata', 'Makan & minum', 'Drone photography', 'Pengeluaran pribadi'],
                'is_active'       => true,
                'sort_order'      => 4,
            ],
            [
                'name'            => 'Paket Trip Danau Toba 4 Hari 3 Malam',
                'description'     => '<p>Paket premium untuk menjelajahi seluruh penjuru Danau Toba dan budaya Batak secara lengkap. Termasuk kunjungan ke Bakkara (tanah leluhur Raja Sisingamangaraja) dan air terjun tersembunyi.</p>',
                'price_per_day'   => 625000,
                'min_rental_days' => 4,
                'max_rental_days' => 4,
                'includes'        => ['Mobil AC PP dari Medan', 'Supir + Guide bersertifikat', 'BBM', 'Tiket ferry', 'Penginapan 3 malam (twin share)', 'Sarapan', 'Air mineral'],
                'excludes'        => ['Tiket masuk destinasi', 'Makan siang & malam', 'Drone', 'Pengeluaran pribadi'],
                'is_active'       => true,
                'sort_order'      => 5,
            ],

            // ── Paket Berastagi ─────────────────────────────────────────────
            [
                'name'            => 'Paket Wisata Berastagi 1 Hari',
                'description'     => '<p>Day trip ke Berastagi dari Medan. Nikmati udara sejuk pegunungan, pasar buah segar, dan panorama Gunung Sinabung yang memukau.</p><p>Destinasi: Sipiso-piso Waterfall, Bukit Gundaling, Pasar Buah Berastagi, dan Desa Peceren.</p>',
                'price_per_day'   => 350000,
                'min_rental_days' => 1,
                'max_rental_days' => 1,
                'includes'        => ['Mobil AC PP Medan–Berastagi', 'Supir berpengalaman', 'BBM', 'Air mineral'],
                'excludes'        => ['Tiket masuk air terjun', 'Makan & minum', 'Pemandu lokal', 'Pengeluaran pribadi'],
                'is_active'       => true,
                'sort_order'      => 6,
            ],
            [
                'name'            => 'Paket Berastagi + Sibayak 2 Hari 1 Malam',
                'description'     => '<p>Paket 2 hari ke Berastagi dengan highlight pendakian Gunung Sibayak. Cocok untuk wisatawan aktif yang ingin menggabungkan hiking dengan wisata alam pegunungan.</p>',
                'price_per_day'   => 500000,
                'min_rental_days' => 2,
                'max_rental_days' => 2,
                'includes'        => ['Mobil AC PP dari Medan', 'Supir berpengalaman', 'BBM', 'Penginapan 1 malam', 'Pemandu pendakian', 'Air mineral'],
                'excludes'        => ['Tiket masuk wisata', 'Makan & minum', 'Perlengkapan hiking', 'Pengeluaran pribadi'],
                'is_active'       => true,
                'sort_order'      => 7,
            ],

            // ── Paket Nias ──────────────────────────────────────────────────
            [
                'name'            => 'Paket Trip Nias 3 Hari 2 Malam',
                'description'     => '<p>Jelajahi Pulau Nias yang eksotis – destinasi surfing kelas dunia dan warisan budaya megalitik yang unik. Termasuk kunjungan ke Desa Bawömataluo dan Pantai Sorake.</p>',
                'price_per_day'   => 700000,
                'min_rental_days' => 3,
                'max_rental_days' => 3,
                'includes'        => ['Tiket kapal Sibolga–Nias PP', 'Mobil lokal di Nias', 'Supir lokal', 'Penginapan 2 malam', 'Air mineral'],
                'excludes'        => ['Tiket masuk', 'Makan & minum', 'Tiket pesawat (jika ada)', 'Pengeluaran pribadi'],
                'is_active'       => true,
                'sort_order'      => 8,
            ],

            // ── Paket Custom ───────────────────────────────────────────────
            [
                'name'            => 'Paket Honeymoon Sumatera Utara 4 Hari 3 Malam',
                'description'     => '<p>Paket perjalanan romantis untuk pasangan baru menikah. Kombinasi Kota Medan, Berastagi, dan Danau Toba dengan akomodasi hotel bintang dan berbagai kejutan romantis.</p>',
                'price_per_day'   => 900000,
                'min_rental_days' => 4,
                'max_rental_days' => 4,
                'includes'        => ['Mobil AC premium', 'Supir + pemandu wisata', 'BBM', 'Penginapan 3 malam (double bed)', 'Sarapan setiap hari', 'Dekorasi kamar malam pertama', 'Bunga & welcome drink', 'Air mineral'],
                'excludes'        => ['Tiket masuk wisata', 'Makan siang & malam', 'Drone session', 'Pengeluaran pribadi'],
                'is_active'       => true,
                'sort_order'      => 9,
            ],
            [
                'name'            => 'Paket Wisata Keluarga Sumatera Utara 5 Hari 4 Malam',
                'description'     => '<p>Paket wisata lengkap untuk keluarga menjelajahi Sumatera Utara. Menelusuri keindahan Medan, Berastagi, Air Terjun Sipiso-piso, Danau Toba, dan Samosir.</p>',
                'price_per_day'   => 750000,
                'min_rental_days' => 5,
                'max_rental_days' => 5,
                'includes'        => ['Mobil AC (kapasitas sesuai rombongan)', 'Supir berpengalaman', 'BBM', 'Tiket ferry', 'Penginapan 4 malam', 'Air mineral setiap hari'],
                'excludes'        => ['Tiket masuk wisata', 'Makan & minum', 'Pengeluaran pribadi', 'Laundry'],
                'is_active'       => true,
                'sort_order'      => 10,
            ],

        ];

        foreach ($packages as $package) {
            $package['slug'] = Str::slug($package['name']);
            RentalPackage::firstOrCreate(['slug' => $package['slug']], $package);
        }

        $this->command->info(count($packages) . ' paket rental berhasil disimpan.');
    }
}
