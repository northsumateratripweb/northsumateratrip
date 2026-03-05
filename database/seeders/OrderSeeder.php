<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa product ID
        $productToba1   = Product::where('slug', 'private-trip-danau-toba-1-hari')->value('id');
        $productMedan   = Product::where('slug', 'city-tour-medan-1hari')->value('id');
        $productToba2H  = Product::where('slug', 'danau-toba-2hari-1malam')->value('id');
        $product3H      = Product::where('slug', 'danau-toba-lengkap-3h2m')->value('id');
        $product4H      = Product::where('slug', 'wisata-sumut-komplit-4h3m')->value('id');
        $productHoney   = Product::where('slug', 'honeymoon-danau-toba-4h3m')->value('id');
        $productGrand   = Product::where('slug', 'grand-tour-sumut-5h4m')->value('id');

        // Ambil vehicle
        $vehicleInnova  = Vehicle::where('plate_number', 'BK 2345 CD')->value('id');
        $vehicleAvanza  = Vehicle::where('plate_number', 'BK 1234 AB')->value('id');
        $vehicleHiAce   = Vehicle::where('plate_number', 'BK 3456 EF')->value('id');
        $vehicleFort    = Vehicle::where('plate_number', 'BK 4567 GH')->value('id');

        $orders = [
            [
                'product_id'       => $productToba1,
                'vehicle_id'       => $vehicleInnova,
                'customer_name'    => 'Ahmad Fauzi',
                'customer_email'   => 'ahmad.fauzi@gmail.com',
                'customer_phone'   => '081234567890',
                'customer_whatsapp'=> '081234567890',
                'trip_date'        => Carbon::now()->addDays(7)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(7)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 4,
                'pax_child'        => 1,
                'quantity'         => 5,
                'total_price'      => 2000000,
                'status'           => 'confirmed',
                'payment_status'   => 'Lunas',
                'hotel_category'   => 'bintang_3',
                'hotel_1'          => 'Hotel Parapat View',
                'notes'            => 'Mohon jemput di Bandara Kualanamu pagi hari',
                'use_drone'        => false,
            ],
            [
                'product_id'       => $productMedan,
                'vehicle_id'       => $vehicleAvanza,
                'customer_name'    => 'Siti Rahayu',
                'customer_email'   => 'siti.rahayu@yahoo.com',
                'customer_phone'   => '082345678901',
                'customer_whatsapp'=> '082345678901',
                'trip_date'        => Carbon::now()->addDays(3)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(3)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 2,
                'pax_child'        => 0,
                'quantity'         => 2,
                'total_price'      => 800000,
                'status'           => 'confirmed',
                'payment_status'   => 'DP',
                'hotel_category'   => 'non_hotel',
                'notes'            => 'Sudah tinggal di Medan, jemput di hotel',
                'use_drone'        => false,
            ],
            [
                'product_id'       => $productToba2H,
                'vehicle_id'       => $vehicleInnova,
                'customer_name'    => 'Budi Santoso',
                'customer_email'   => 'budi.santoso@gmail.com',
                'customer_phone'   => '083456789012',
                'customer_whatsapp'=> '083456789012',
                'trip_date'        => Carbon::now()->addDays(14)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(15)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 3,
                'pax_child'        => 2,
                'quantity'         => 5,
                'total_price'      => 5500000,
                'status'           => 'pending',
                'payment_status'   => 'Belum Lunas',
                'hotel_category'   => 'bintang_3',
                'hotel_1'          => 'Hotel Samosir Cottage',
                'notes'            => 'Request kamar connecting',
                'use_drone'        => true,
            ],
            [
                'product_id'       => $product3H,
                'vehicle_id'       => $vehicleFort,
                'customer_name'    => 'Dewi Kusuma',
                'customer_email'   => 'dewi.kusuma@hotmail.com',
                'customer_phone'   => '084567890123',
                'customer_whatsapp'=> '084567890123',
                'trip_date'        => Carbon::now()->addDays(21)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(23)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 6,
                'pax_child'        => 0,
                'quantity'         => 6,
                'total_price'      => 6300000,
                'status'           => 'confirmed',
                'payment_status'   => 'Lunas',
                'hotel_category'   => 'bintang_5',
                'hotel_1'          => 'Toba Village Inn',
                'hotel_2'          => 'Niagara Hotel Parapat',
                'notes'            => 'Rombongan kantor, mohon kendaraan yang luas',
                'use_drone'        => true,
                'flight_info'      => 'GA 180 Jakarta-Medan 06:00',
            ],
            [
                'product_id'       => $product4H,
                'vehicle_id'       => $vehicleHiAce,
                'customer_name'    => 'Hendra Gunawan',
                'customer_email'   => 'hendra@gmail.com',
                'customer_phone'   => '085678901234',
                'customer_whatsapp'=> '085678901234',
                'trip_date'        => Carbon::now()->addDays(10)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(13)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 8,
                'pax_child'        => 4,
                'quantity'         => 12,
                'total_price'      => 15600000,
                'status'           => 'confirmed',
                'payment_status'   => 'Lunas',
                'hotel_category'   => 'bintang_3',
                'hotel_1'          => 'Grand Aston Medan',
                'hotel_2'          => 'Hotel Berastagi',
                'hotel_3'          => 'Hotel Parapat View',
                'notes'            => 'Group keluarga besar, ada lansia mohon dijaga pace-nya',
                'use_drone'        => false,
            ],
            [
                'product_id'       => $productHoney,
                'vehicle_id'       => $vehicleFort,
                'customer_name'    => 'Rudi & Wulan',
                'customer_email'   => 'rudi.wulan@gmail.com',
                'customer_phone'   => '086789012345',
                'customer_whatsapp'=> '086789012345',
                'trip_date'        => Carbon::now()->addDays(30)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(33)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 2,
                'pax_child'        => 0,
                'quantity'         => 2,
                'total_price'      => 4500000,
                'status'           => 'pending',
                'payment_status'   => 'DP',
                'hotel_category'   => 'bintang_5',
                'hotel_1'          => 'Samosir Villa Resort',
                'notes'            => 'Honeymoon trip, tolong siapkan dekorasi di kamar',
                'use_drone'        => true,
                'flight_info'      => 'Lion JT 310 Surabaya-Medan 08:00',
            ],
            [
                'product_id'       => $productGrand,
                'vehicle_id'       => $vehicleInnova,
                'customer_name'    => 'Lisa Marlina',
                'customer_email'   => 'lisa.marlina@gmail.com',
                'customer_phone'   => '087890123456',
                'customer_whatsapp'=> '087890123456',
                'trip_date'        => Carbon::now()->addDays(45)->format('Y-m-d'),
                'trip_end_date'    => Carbon::now()->addDays(49)->format('Y-m-d'),
                'trip_type'        => 'private',
                'pax_adult'        => 4,
                'pax_child'        => 0,
                'quantity'         => 4,
                'total_price'      => 11200000,
                'status'           => 'pending',
                'payment_status'   => 'Belum Lunas',
                'hotel_category'   => 'bintang_3',
                'hotel_1'          => 'Hotel Medan',
                'hotel_2'          => 'Hotel Berastagi',
                'hotel_3'          => 'Hotel Parapat',
                'hotel_4'          => 'Bukit Lawang Eco Lodge',
                'notes'            => 'Ingin jungle trekking di Bukit Lawang minimal 3 jam',
                'use_drone'        => false,
                'flight_info'      => 'Batik ID 6280 Bali-Medan',
            ],
        ];

        foreach ($orders as $order) {
            if (! $order['product_id']) {
                continue;
            }

            Order::updateOrCreate(
                ['customer_email' => $order['customer_email'], 'product_id' => $order['product_id']],
                $order
            );
        }
    }
}
