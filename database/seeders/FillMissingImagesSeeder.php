<?php

namespace Database\Seeders;

use App\Models\CarRental;
use App\Models\RentalPackage;
use Illuminate\Database\Seeder;

class FillMissingImagesSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Car Rental featured_image & gallery_images ───────────────
        $carImages = [
            'Toyota Avanza'                   => ['featured' => 'https://picsum.photos/seed/cr-avanza/800/600',       'gallery' => ['https://picsum.photos/seed/cr-avanza-2/800/600','https://picsum.photos/seed/cr-avanza-3/800/600']],
            'Toyota Avanza Veloz'              => ['featured' => 'https://picsum.photos/seed/cr-veloz/800/600',        'gallery' => ['https://picsum.photos/seed/cr-veloz-2/800/600','https://picsum.photos/seed/cr-veloz-3/800/600']],
            'Daihatsu Xenia'                   => ['featured' => 'https://picsum.photos/seed/cr-xenia/800/600',       'gallery' => ['https://picsum.photos/seed/cr-xenia-2/800/600']],
            'Toyota Kijang Innova'             => ['featured' => 'https://picsum.photos/seed/cr-kijang/800/600',      'gallery' => ['https://picsum.photos/seed/cr-kijang-2/800/600','https://picsum.photos/seed/cr-kijang-3/800/600']],
            'Toyota Innova Reborn'             => ['featured' => 'https://picsum.photos/seed/cr-innova-reborn/800/600','gallery' => ['https://picsum.photos/seed/cr-innova-rb-2/800/600','https://picsum.photos/seed/cr-innova-rb-3/800/600']],
            'Mitsubishi Pajero Sport'          => ['featured' => 'https://picsum.photos/seed/cr-pajero/800/600',      'gallery' => ['https://picsum.photos/seed/cr-pajero-2/800/600','https://picsum.photos/seed/cr-pajero-3/800/600']],
            'Isuzu Elf (12 Seat)'              => ['featured' => 'https://picsum.photos/seed/cr-elf/800/600',         'gallery' => ['https://picsum.photos/seed/cr-elf-2/800/600']],
            'Toyota HiAce Premio (15 Seat)'    => ['featured' => 'https://picsum.photos/seed/cr-hiace/800/600',       'gallery' => ['https://picsum.photos/seed/cr-hiace-2/800/600','https://picsum.photos/seed/cr-hiace-3/800/600']],
        ];

        foreach ($carImages as $name => $imgs) {
            CarRental::where('name', $name)
                ->whereNull('featured_image')
                ->update([
                    'featured_image' => $imgs['featured'],
                    'gallery_images' => json_encode($imgs['gallery']),
                ]);
        }

        // ─── Rental Package featured_image ────────────────────────────
        $rpImages = [
            'Paket Sewa Mobil Harian (Dalam Kota)'               => 'https://picsum.photos/seed/rp-harian/800/600',
            'Paket Sewa Mobil + Supir Harian'                     => 'https://picsum.photos/seed/rp-supir/800/600',
            'Paket Trip Danau Toba 2 Hari 1 Malam'               => 'https://picsum.photos/seed/rp-toba2h/800/600',
            'Paket Trip Danau Toba 3 Hari 2 Malam'               => 'https://picsum.photos/seed/rp-toba3h/800/600',
            'Paket Trip Danau Toba 4 Hari 3 Malam'               => 'https://picsum.photos/seed/rp-toba4h/800/600',
            'Paket Wisata Berastagi 1 Hari'                       => 'https://picsum.photos/seed/rp-berastagi/800/600',
            'Paket Berastagi + Sibayak 2 Hari 1 Malam'           => 'https://picsum.photos/seed/rp-sibayak/800/600',
            'Paket Trip Nias 3 Hari 2 Malam'                     => 'https://picsum.photos/seed/rp-nias/800/600',
            'Paket Honeymoon Sumatera Utara 4 Hari 3 Malam'      => 'https://picsum.photos/seed/rp-honeymoon/800/600',
            'Paket Wisata Keluarga Sumatera Utara 5 Hari 4 Malam'=> 'https://picsum.photos/seed/rp-keluarga/800/600',
        ];

        foreach ($rpImages as $name => $img) {
            RentalPackage::where('name', $name)
                ->whereNull('featured_image')
                ->update(['featured_image' => $img]);
        }
    }
}
