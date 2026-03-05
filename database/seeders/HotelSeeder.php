<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [

            // ── Medan ──────────────────────────────────────────────────────
            [
                'name'        => 'Grand Aston City Hall Medan',
                'address'     => 'Jl. Balai Kota No.1, Kesawan, Medan Barat',
                'city'        => 'Medan',
                'phone'       => '061-4510000',
                'rating'      => 4.80,
                'is_active'   => true,
                'description' => 'Hotel bintang 5 di pusat kota Medan, bersebelahan dengan Kesawan Square. Fasilitas lengkap termasuk kolam renang, spa, dan restoran premium.',
            ],
            [
                'name'        => 'JW Marriott Hotel Medan',
                'address'     => 'Jl. Putri Hijau No.10, Medan',
                'city'        => 'Medan',
                'phone'       => '061-4501234',
                'rating'      => 4.85,
                'is_active'   => true,
                'description' => 'Hotel bintang 5 mewah di kawasan bisnis Medan. Kamar premium dengan pemandangan kota, kolam renang rooftop, dan pusat kebugaran modern.',
            ],
            [
                'name'        => 'Hotel Aryaduta Medan',
                'address'     => 'Jl. Kapten Maulana Lubis No.8, Medan',
                'city'        => 'Medan',
                'phone'       => '061-4557888',
                'rating'      => 4.60,
                'is_active'   => true,
                'description' => 'Hotel bintang 5 ikonik di Medan dengan sejarah panjang. Lokasi strategis dekat pusat perbelanjaan dan destinasi wisata kota Medan.',
            ],
            [
                'name'        => 'Santika Premiere Dyandra Hotel Medan',
                'address'     => 'Jl. Kapten Maulana Lubis No.7, Medan',
                'city'        => 'Medan',
                'phone'       => '061-4512345',
                'rating'      => 4.40,
                'is_active'   => true,
                'description' => 'Hotel bintang 4 dengan fasilitas convention hall terbesar di Sumatera Utara. Cocok untuk perjalanan bisnis maupun liburan keluarga.',
            ],
            [
                'name'        => 'Hotel Emerald Garden Medan',
                'address'     => 'Jl. Kolonel Laut Yos Sudarso No.1, Medan',
                'city'        => 'Medan',
                'phone'       => '061-6613999',
                'rating'      => 4.20,
                'is_active'   => true,
                'description' => 'Hotel bintang 4 di kawasan Sunggal Medan dengan taman luas dan kolam renang. Cocok untuk keluarga yang mencari suasana asri di tengah kota.',
            ],
            [
                'name'        => 'Ibis Styles Medan City Center',
                'address'     => 'Jl. Brigjend Katamso No.6, Medan',
                'city'        => 'Medan',
                'phone'       => '061-4528888',
                'rating'      => 4.10,
                'is_active'   => true,
                'description' => 'Hotel bintang 3 modern dengan desain kontemporer di pusat kota Medan. Nilai terbaik untuk wisatawan dengan budget menengah.',
            ],

            // ── Parapat / Danau Toba ────────────────────────────────────────
            [
                'name'        => 'Niagara Hotel Parapat',
                'address'     => 'Jl. Marihat No.1, Parapat, Simalungun',
                'city'        => 'Parapat',
                'phone'       => '0625-41012',
                'rating'      => 4.30,
                'is_active'   => true,
                'description' => 'Hotel tua yang ikonik di tepi Danau Toba dengan pemandangan danau yang sangat indah. Tempat bersejarah favorit wisatawan sejak era kolonial.',
            ],
            [
                'name'        => 'Inna Parapat Hotel',
                'address'     => 'Jl. Nelson Purba No.1, Parapat, Simalungun',
                'city'        => 'Parapat',
                'phone'       => '0625-41012',
                'rating'      => 4.00,
                'is_active'   => true,
                'description' => 'Hotel tepi danau dengan pemandangan Danau Toba yang memukau. Tersedia kamar standar hingga cottage langsung di pinggir danau.',
            ],
            [
                'name'        => 'Tabo Cottages Danau Toba',
                'address'     => 'Jl. Raya Tuk-Tuk, Samosir',
                'city'        => 'Samosir',
                'phone'       => '0625-451318',
                'rating'      => 4.50,
                'is_active'   => true,
                'description' => 'Cottage romantis di Pulau Samosir langsung menghadap Danau Toba. Arsitektur tradisional Batak yang mempertahankan keaslian budaya lokal.',
            ],
            [
                'name'        => 'Samosir Villa Resort',
                'address'     => 'Jl. Tuk-Tuk Siadong, Samosir',
                'city'        => 'Samosir',
                'phone'       => '0625-451351',
                'rating'      => 4.60,
                'is_active'   => true,
                'description' => 'Resort eksklusif di Pulau Samosir dengan villa private bertepi danau. Fasilitas lengkap termasuk restoran, spa, dan area olahraga air.',
            ],
            [
                'name'        => 'Toledo Inn Parapat',
                'address'     => 'Jl. Pembangunan No.37, Parapat',
                'city'        => 'Parapat',
                'phone'       => '0625-41144',
                'rating'      => 3.90,
                'is_active'   => true,
                'description' => 'Hotel tepi danau yang terjangkau dengan pemandangan langsung ke Danau Toba. Pilihan populer untuk wisatawan backpacker.',
            ],

            // ── Berastagi / Karo Highlands ──────────────────────────────────
            [
                'name'        => 'Grand Mutiara Hotel Berastagi',
                'address'     => 'Jl. Veteran No.97, Berastagi, Karo',
                'city'        => 'Berastagi',
                'phone'       => '0628-91111',
                'rating'      => 4.40,
                'is_active'   => true,
                'description' => 'Hotel bintang 3 terbaik di Berastagi dengan pemandangan Gunung Sinabung. Dekat pasar buah Berastagi dan jalur pendakian Gunung Sibayak.',
            ],
            [
                'name'        => 'Hotel Rudang International Berastagi',
                'address'     => 'Jl. Veteran No.1, Berastagi, Karo',
                'city'        => 'Berastagi',
                'phone'       => '0628-91301',
                'rating'      => 3.80,
                'is_active'   => true,
                'description' => 'Hotel di pusat kota Berastagi dengan udara sejuk khas pegunungan. Lokasi strategis dekat pasar wisata dan objek wisata Berastagi.',
            ],
            [
                'name'        => 'Sibayak Multinational Guesthouse',
                'address'     => 'Jl. Udara No.1, Berastagi, Karo',
                'city'        => 'Berastagi',
                'phone'       => '0628-91301',
                'rating'      => 4.00,
                'is_active'   => true,
                'description' => 'Guesthouse nyaman dekat jalur pendakian Gunung Sibayak. Favorit para pecinta alam yang ingin menginap sebelum mendaki.',
            ],

            // ── Nias ────────────────────────────────────────────────────────
            [
                'name'        => 'Bambowo Inn Nias',
                'address'     => 'Jl. Yos Sudarso, Gunungsitoli, Nias',
                'city'        => 'Gunungsitoli',
                'phone'       => '0639-21755',
                'rating'      => 3.80,
                'is_active'   => true,
                'description' => 'Hotel yang nyaman di kota Gunungsitoli, Nias. Titik awal yang ideal untuk menjelajahi Desa Bawömataluo dan pantai-pantai eksotis Nias.',
            ],
            [
                'name'        => 'Sorake Beach Resort Nias',
                'address'     => 'Jl. Pantai Sorake, Lagundri, Nias Selatan',
                'city'        => 'Nias Selatan',
                'phone'       => '0639-22100',
                'rating'      => 4.20,
                'is_active'   => true,
                'description' => 'Resort tepi pantai di kawasan Sorake, destinasi surfing dunia. Pemandangan laut yang menakjubkan dan ombak legendaris untuk para peselancar.',
            ],

            // ── Sibolga / Tapteng ───────────────────────────────────────────
            [
                'name'        => 'Hotel Wisata Sibolga',
                'address'     => 'Jl. Sudirman No.98, Sibolga',
                'city'        => 'Sibolga',
                'phone'       => '0631-21500',
                'rating'      => 3.70,
                'is_active'   => true,
                'description' => 'Hotel di pusat kota Sibolga, pintu gerbang menuju Nias dan Pulau Mursala. Fasilitas lengkap dengan restoran seafood khas Sibolga.',
            ],

        ];

        foreach ($hotels as $hotel) {
            Hotel::firstOrCreate(['name' => $hotel['name']], $hotel);
        }

        $this->command->info(count($hotels) . ' hotel berhasil disimpan.');
    }
}
