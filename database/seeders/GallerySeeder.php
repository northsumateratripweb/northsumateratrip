<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            // Danau Toba
            ['title' => 'Panorama Danau Toba dari Bukit Cinta',   'image_url' => 'https://picsum.photos/seed/gallery-toba1/800/600',     'caption' => 'Pemandangan menakjubkan Danau Toba dari Bukit Cinta, Samosir',       'category' => 'Danau Toba',   'sort_order' => 1],
            ['title' => 'Sunset Danau Toba',                      'image_url' => 'https://picsum.photos/seed/gallery-toba2/800/600',     'caption' => 'Golden sunset di tepi Danau Toba, Parapat',                          'category' => 'Danau Toba',   'sort_order' => 2],
            ['title' => 'Pulau Samosir dari Udara',                'image_url' => 'https://picsum.photos/seed/gallery-toba3/800/600',     'caption' => 'Aerial view Pulau Samosir – pulau di dalam danau di dalam pulau',    'category' => 'Danau Toba',   'sort_order' => 3],
            ['title' => 'Desa Tomok Samosir',                      'image_url' => 'https://picsum.photos/seed/gallery-tomok/800/600',     'caption' => 'Desa wisata Tomok dengan patung dan arsitektur Batak',               'category' => 'Danau Toba',   'sort_order' => 4],
            ['title' => 'Pantai Parbaba',                          'image_url' => 'https://picsum.photos/seed/gallery-parbaba/800/600',   'caption' => 'Pantai pasir putih di tepi Danau Toba',                              'category' => 'Danau Toba',   'sort_order' => 5],

            // Berastagi & Karo
            ['title' => 'Gunung Sibayak Sunrise',                  'image_url' => 'https://picsum.photos/seed/gallery-sibayak/800/600',   'caption' => 'Sunrise dari puncak Gunung Sibayak, Berastagi',                      'category' => 'Berastagi',    'sort_order' => 6],
            ['title' => 'Air Terjun Sipiso-piso',                  'image_url' => 'https://picsum.photos/seed/gallery-sipiso/800/600',    'caption' => 'Air terjun setinggi 120 meter di tepi Danau Toba',                   'category' => 'Berastagi',    'sort_order' => 7],
            ['title' => 'Pasar Buah Berastagi',                    'image_url' => 'https://picsum.photos/seed/gallery-pasar-buah/800/600','caption' => 'Aneka buah segar dan markisa khas Berastagi',                        'category' => 'Berastagi',    'sort_order' => 8],
            ['title' => 'Kebun Teh Sidamanik',                     'image_url' => 'https://picsum.photos/seed/gallery-kebun-teh/800/600', 'caption' => 'Hamparan hijau kebun teh di dataran tinggi Simalungun',              'category' => 'Berastagi',    'sort_order' => 9],

            // Medan
            ['title' => 'Istana Maimun',                           'image_url' => 'https://picsum.photos/seed/gallery-maimun/800/600',    'caption' => 'Istana Kerajaan Deli yang ikonik, dibangun tahun 1888',              'category' => 'Medan',        'sort_order' => 10],
            ['title' => 'Masjid Raya Al-Mashun',                   'image_url' => 'https://picsum.photos/seed/gallery-masjid/800/600',    'caption' => 'Masjid bersejarah Medan dengan arsitektur megah',                    'category' => 'Medan',        'sort_order' => 11],
            ['title' => 'Kuliner Medan',                           'image_url' => 'https://picsum.photos/seed/gallery-kuliner/800/600',   'caption' => 'Soto Medan, Bika Ambon, dan aneka kuliner khas',                     'category' => 'Medan',        'sort_order' => 12],

            // Bukit Lawang
            ['title' => 'Orangutan Bukit Lawang',                   'image_url' => 'https://picsum.photos/seed/gallery-orangutan/800/600', 'caption' => 'Orangutan Sumatera di habitat aslinya, Bukit Lawang',                'category' => 'Bukit Lawang', 'sort_order' => 13],
            ['title' => 'Jungle Trekking Bukit Lawang',             'image_url' => 'https://picsum.photos/seed/gallery-jungle/800/600',   'caption' => 'Trekking di hutan hujan tropis Taman Nasional Gunung Leuser',        'category' => 'Bukit Lawang', 'sort_order' => 14],

            // Tangkahan
            ['title' => 'Gajah Sumatera di Tangkahan',              'image_url' => 'https://picsum.photos/seed/gallery-elephant/800/600', 'caption' => 'Memandikan gajah di sungai Tangkahan',                               'category' => 'Tangkahan',    'sort_order' => 15],
            ['title' => 'Sungai Tangkahan',                         'image_url' => 'https://picsum.photos/seed/gallery-tangkahan/800/600','caption' => 'Air jernih sungai Tangkahan dengan latar hutan lebat',               'category' => 'Tangkahan',    'sort_order' => 16],

            // Pulau Nias
            ['title' => 'Lompat Batu Nias',                         'image_url' => 'https://picsum.photos/seed/gallery-hombo/800/600',   'caption' => 'Tradisi Hombo Batu (Lompat Batu) khas Nias Selatan',                 'category' => 'Nias',         'sort_order' => 17],
            ['title' => 'Pantai Sorake Nias',                       'image_url' => 'https://picsum.photos/seed/gallery-sorake/800/600',  'caption' => 'Surga surfing kelas dunia di pantai Sorake',                         'category' => 'Nias',         'sort_order' => 18],

            // Armada
            ['title' => 'Armada Toyota Innova Reborn',              'image_url' => 'https://picsum.photos/seed/gallery-innova/800/600',  'caption' => 'Armada terawat dan nyaman untuk perjalanan Anda',                    'category' => 'Armada',       'sort_order' => 19],
            ['title' => 'Armada HiAce untuk Group',                 'image_url' => 'https://picsum.photos/seed/gallery-hiace/800/600',   'caption' => 'Minibus HiAce AC untuk rombongan besar',                             'category' => 'Armada',       'sort_order' => 20],
        ];

        foreach ($galleries as $g) {
            Gallery::updateOrCreate(
                ['image_url' => $g['image_url']],
                array_merge($g, ['is_active' => true])
            );
        }
    }
}
