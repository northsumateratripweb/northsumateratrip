<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $categories = [
            [
                'name' => '1 Hari',
                'slug' => '1-hari',
                'icon' => 'fa-sun',
                'description' => 'Paket wisata singkat 1 hari tanpa menginap, cocok untuk day trip.',
                'meta_title' => 'Paket Wisata 1 Hari - NorthSumateraTrip',
                'meta_description' => 'Paket wisata 1 hari tanpa menginap. Day trip ke destinasi terbaik Sumatera Utara.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => '2 Hari 1 Malam',
                'slug' => '2-hari-1-malam',
                'icon' => 'fa-moon',
                'description' => 'Paket wisata 2 hari 1 malam, perjalanan singkat dengan 1 malam menginap.',
                'meta_title' => 'Paket Wisata 2 Hari 1 Malam - NorthSumateraTrip',
                'meta_description' => 'Paket wisata 2 hari 1 malam ke destinasi terbaik Sumatera Utara dengan akomodasi.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => '3 Hari 2 Malam',
                'slug' => '3-hari-2-malam',
                'icon' => 'fa-calendar-day',
                'description' => 'Paket wisata 3 hari 2 malam, durasi ideal untuk menikmati destinasi utama.',
                'meta_title' => 'Paket Wisata 3 Hari 2 Malam - NorthSumateraTrip',
                'meta_description' => 'Paket wisata 3 hari 2 malam. Jelajahi Sumatera Utara dengan waktu yang cukup.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => '4 Hari 3 Malam',
                'slug' => '4-hari-3-malam',
                'icon' => 'fa-calendar-week',
                'description' => 'Paket wisata 4 hari 3 malam untuk pengalaman wisata yang lebih lengkap.',
                'meta_title' => 'Paket Wisata 4 Hari 3 Malam - NorthSumateraTrip',
                'meta_description' => 'Paket wisata 4 hari 3 malam ke Sumatera Utara. Danau Toba, Berastagi dan sekitarnya.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => '5 Hari 4 Malam',
                'slug' => '5-hari-4-malam',
                'icon' => 'fa-calendar-alt',
                'description' => 'Paket wisata 5 hari 4 malam untuk menjelajahi lebih banyak destinasi.',
                'meta_title' => 'Paket Wisata 5 Hari 4 Malam - NorthSumateraTrip',
                'meta_description' => 'Paket wisata 5 hari 4 malam. Eksplorasi lengkap Sumatera Utara.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => '6 Hari 5 Malam',
                'slug' => '6-hari-5-malam',
                'icon' => 'fa-calendar',
                'description' => 'Paket wisata 6 hari 5 malam, perjalanan panjang untuk pengalaman maksimal.',
                'meta_title' => 'Paket Wisata 6 Hari 5 Malam - NorthSumateraTrip',
                'meta_description' => 'Paket wisata 6 hari 5 malam. Nikmati seluruh keindahan Sumatera Utara.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Kategori Request',
                'slug' => 'kategori-request',
                'icon' => 'fa-clipboard-list',
                'description' => 'Paket wisata custom sesuai permintaan dan kebutuhan khusus Anda.',
                'meta_title' => 'Paket Wisata Custom Request - NorthSumateraTrip',
                'meta_description' => 'Buat paket wisata custom sesuai keinginan Anda. Durasi, destinasi, dan akomodasi fleksibel.',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        $now = now();

        foreach ($categories as $category) {
            $exists = DB::table('categories')->where('slug', $category['slug'])->exists();

            if (!$exists) {
                DB::table('categories')->insert(array_merge($category, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('categories')->whereIn('slug', [
            '1-hari',
            '2-hari-1-malam',
            '3-hari-2-malam',
            '4-hari-3-malam',
            '5-hari-4-malam',
            '6-hari-5-malam',
            'kategori-request',
        ])->delete();
    }
};
