<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'name'          => 'Toyota Avanza',
                'plate_number'  => 'BK 1234 AB',
                'capacity'      => 7,
                'type'          => 'MPV',
                'brand'         => 'Toyota',
                'thumbnail'     => 'https://picsum.photos/seed/avanza/400/300',
                'price_per_day' => 500000,
                'transmission'  => 'Automatic',
                'description'   => 'Mobil keluarga yang nyaman dan irit bahan bakar. Cocok untuk trip 2-6 orang.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Toyota Innova Reborn',
                'plate_number'  => 'BK 2345 CD',
                'capacity'      => 7,
                'type'          => 'MPV',
                'brand'         => 'Toyota',
                'thumbnail'     => 'https://picsum.photos/seed/innova/400/300',
                'price_per_day' => 700000,
                'transmission'  => 'Automatic',
                'description'   => 'MPV premium Toyota dengan kabin luas dan mesin diesel bertenaga. Nyaman untuk perjalanan jauh.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Toyota HiAce Commuter',
                'plate_number'  => 'BK 3456 EF',
                'capacity'      => 15,
                'type'          => 'Minibus',
                'brand'         => 'Toyota',
                'thumbnail'     => 'https://picsum.photos/seed/hiace/400/300',
                'price_per_day' => 1200000,
                'transmission'  => 'Manual',
                'description'   => 'Mini bus kapasitas besar untuk rombongan. AC double blower, suspensi nyaman.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Toyota Fortuner',
                'plate_number'  => 'BK 4567 GH',
                'capacity'      => 7,
                'type'          => 'SUV',
                'brand'         => 'Toyota',
                'thumbnail'     => 'https://picsum.photos/seed/fortuner/400/300',
                'price_per_day' => 1000000,
                'transmission'  => 'Automatic',
                'description'   => 'SUV tangguh cocok untuk medan pegunungan dan jalan menantang. 4WD tersedia.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Mitsubishi Xpander',
                'plate_number'  => 'BK 5678 IJ',
                'capacity'      => 7,
                'type'          => 'MPV',
                'brand'         => 'Mitsubishi',
                'thumbnail'     => 'https://picsum.photos/seed/xpander/400/300',
                'price_per_day' => 550000,
                'transmission'  => 'Automatic',
                'description'   => 'MPV modern dengan ground clearance tinggi, cocok untuk wisata pegunungan dan pantai.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Daihatsu Xenia',
                'plate_number'  => 'BK 6789 KL',
                'capacity'      => 7,
                'type'          => 'MPV',
                'brand'         => 'Daihatsu',
                'thumbnail'     => 'https://picsum.photos/seed/xenia/400/300',
                'price_per_day' => 450000,
                'transmission'  => 'Manual',
                'description'   => 'Mobil dengan biaya sewa ekonomis, cocok untuk budget trip.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Isuzu Elf Long',
                'plate_number'  => 'BK 7890 MN',
                'capacity'      => 19,
                'type'          => 'Bus Kecil',
                'brand'         => 'Isuzu',
                'thumbnail'     => 'https://picsum.photos/seed/elf/400/300',
                'price_per_day' => 1500000,
                'transmission'  => 'Manual',
                'description'   => 'Elf long chassis untuk rombongan besar. Kursi recline, AC, dan audio system.',
                'is_active'     => true,
            ],
            [
                'name'          => 'Toyota Alphard',
                'plate_number'  => 'BK 8901 OP',
                'capacity'      => 7,
                'type'          => 'Van Premium',
                'brand'         => 'Toyota',
                'thumbnail'     => 'https://picsum.photos/seed/alphard/400/300',
                'price_per_day' => 2500000,
                'transmission'  => 'Automatic',
                'description'   => 'Kendaraan mewah untuk trip eksklusif. Captain seat, entertainment system, dan kabin ultra-nyaman.',
                'is_active'     => true,
            ],
        ];

        foreach ($vehicles as $v) {
            Vehicle::updateOrCreate(
                ['plate_number' => $v['plate_number']],
                $v
            );
        }
    }
}
