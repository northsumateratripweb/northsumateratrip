<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CreateAdminUserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            BlogSeeder::class,
            PartnerSeeder::class,
            ReviewSeeder::class,
            TripSeeder::class,
            HotelSeeder::class,
            CarRentalSeeder::class,
            RentalPackageSeeder::class,
            VehicleSeeder::class,
            GallerySeeder::class,
            SettingsSeeder::class,
            FillMissingImagesSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
