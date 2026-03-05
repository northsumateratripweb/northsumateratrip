<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            // Private Trip Danau Toba 1 Hari
            [
                'product_slug'  => 'private-trip-danau-toba-1-hari',
                'customer_name' => 'Ahmad Fauzi',
                'customer_email'=> 'ahmad@example.com',
                'rating'        => 5.0,
                'comment'       => 'Pelayanan sangat baik, driver ramah dan menguasai tempat wisata. Mobil bersih dan nyaman. Recommended!',
                'is_approved'   => true,
            ],
            [
                'product_slug'  => 'private-trip-danau-toba-1-hari',
                'customer_name' => 'Siti Rahayu',
                'customer_email'=> 'siti@example.com',
                'rating'        => 5.0,
                'comment'       => 'Trip yang sangat menyenangkan bersama keluarga. Destinasi yang dikunjungi semuanya bagus. Terima kasih NorthSumateraTrip!',
                'is_approved'   => true,
            ],
            [
                'product_slug'  => 'private-trip-danau-toba-1-hari',
                'customer_name' => 'Budi Santoso',
                'customer_email'=> 'budi@example.com',
                'rating'        => 5.0,
                'comment'       => 'Harga terjangkau dengan pelayanan maksimal. Drivernya sabar menunggu kami di setiap destinasi.',
                'is_approved'   => true,
            ],

            // City Tour Medan 1 Hari
            [
                'product_slug'  => 'city-tour-medan-1hari',
                'customer_name' => 'Rina Wati',
                'customer_email'=> 'rina@example.com',
                'rating'        => 5.0,
                'comment'       => 'City tour Medan sangat informatif! Driver merangkap guide, jadi tahu banyak sejarah kota Medan. Top!',
                'is_approved'   => true,
            ],
            [
                'product_slug'  => 'city-tour-medan-1hari',
                'customer_name' => 'Hendra Gunawan',
                'customer_email'=> 'hendra@example.com',
                'rating'        => 4.8,
                'comment'       => 'Perjalanan lancar, mobil nyaman. Kuliner yang direkomendasikan driver juga enak semua. Puas!',
                'is_approved'   => true,
            ],

            // Danau Toba 2H1M
            [
                'product_slug'  => 'danau-toba-2hari-1malam',
                'customer_name' => 'Dewi Kusuma',
                'customer_email'=> 'dewi@example.com',
                'rating'        => 5.0,
                'comment'       => 'Pengalaman wisata 2 hari 1 malam yang tak terlupakan. Hotel tepi danau sangat cantik saat sunset.',
                'is_approved'   => true,
            ],
            [
                'product_slug'  => 'danau-toba-2hari-1malam',
                'customer_name' => 'Agus Wirawan',
                'customer_email'=> 'agus@example.com',
                'rating'        => 5.0,
                'comment'       => 'Liburan keluarga terbaik kami! Anak-anak senang sekali di Samosir. Pasti akan pesan lagi.',
                'is_approved'   => true,
            ],

            // 3H2M Danau Toba Lengkap
            [
                'product_slug'  => 'danau-toba-lengkap-3h2m',
                'customer_name' => 'Lisa Marlina',
                'customer_email'=> 'lisa@example.com',
                'rating'        => 5.0,
                'comment'       => 'Paket 3 hari sangat worth it! Bisa ke Sipiso-piso, Samosir, dan Berastagi. Semuanya terorganisir dengan baik.',
                'is_approved'   => true,
            ],
            [
                'product_slug'  => 'danau-toba-lengkap-3h2m',
                'customer_name' => 'Tommy Wibowo',
                'customer_email'=> 'tommy@example.com',
                'rating'        => 5.0,
                'comment'       => 'Tiga hari tidak cukup untuk keindahan Sumut! Tapi paket ini sudah mencakup semua yang penting. Highly recommended.',
                'is_approved'   => true,
            ],

            // Trip Nias
            [
                'product_slug'  => 'trip-pulau-nias-3hari',
                'customer_name' => 'Maya Indah',
                'customer_email'=> 'maya@example.com',
                'rating'        => 5.0,
                'comment'       => 'Nias luar biasa! Lompat batu dan pantai Sorake meninggalkan kesan mendalam. Terima kasih timnya sangat profesional.',
                'is_approved'   => true,
            ],

            // 4H3M Sumut Komplit
            [
                'product_slug'  => 'wisata-sumut-komplit-4h3m',
                'customer_name' => 'Dedi Prasetyo',
                'customer_email'=> 'dedi@example.com',
                'rating'        => 5.0,
                'comment'       => 'Paket 4 hari ini benar-benar komplit. Medan, Berastagi, Toba, Samosir — semuanya dicover. Terbaik!',
                'is_approved'   => true,
            ],
            [
                'product_slug'  => 'wisata-sumut-komplit-4h3m',
                'customer_name' => 'Fitri Handayani',
                'customer_email'=> 'fitri@example.com',
                'rating'        => 5.0,
                'comment'       => 'Kami rombongan 8 orang sangat puas. Harga per orang jadi sangat terjangkau. Next time mau coba paket 5 hari.',
                'is_approved'   => true,
            ],

            // Honeymoon
            [
                'product_slug'  => 'honeymoon-danau-toba-4h3m',
                'customer_name' => 'Rudi Hartono',
                'customer_email'=> 'rudi@example.com',
                'rating'        => 5.0,
                'comment'       => 'Paket honeymoon yang sangat romantis! Villa mewah, dinner candle light, semuanya sempurna. Istri sangat bahagia.',
                'is_approved'   => true,
            ],

            // Grand Tour 5H4M
            [
                'product_slug'  => 'grand-tour-sumut-5h4m',
                'customer_name' => 'Joko Susanto',
                'customer_email'=> 'joko@example.com',
                'rating'        => 5.0,
                'comment'       => 'Grand tour 5 hari pengalaman luar biasa. Highlights: orangutan di Bukit Lawang dan sunrise di Sibayak. MUST TRY!',
                'is_approved'   => true,
            ],

            // Ultimate Tour 6H5M
            [
                'product_slug'  => 'ultimate-sumut-tour-6h5m',
                'customer_name' => 'Anita Sari',
                'customer_email'=> 'anita@example.com',
                'rating'        => 5.0,
                'comment'       => '6 hari menjelajahi Sumut dari A-Z. Tangkahan (gajah) dan Bukit Lawang (orangutan) jadi favorit kami. Sempurna!',
                'is_approved'   => true,
            ],

            // Custom Trip
            [
                'product_slug'  => 'custom-trip-sumut-request',
                'customer_name' => 'Bambang Supriadi',
                'customer_email'=> 'bambang@example.com',
                'rating'        => 5.0,
                'comment'       => 'Kami request custom trip 7 hari untuk rombongan kantor. Tim NorthSumateraTrip sangat kooperatif dan fleksibel. Mantap!',
                'is_approved'   => true,
            ],
        ];

        foreach ($reviews as $review) {
            $productId = Product::query()
                ->where('slug', $review['product_slug'])
                ->value('id');

            if (! $productId) {
                continue;
            }

            $data = $review;
            unset($data['product_slug']);
            $data['product_id'] = $productId;

            Review::updateOrCreate(
                ['product_id' => $productId, 'customer_email' => $data['customer_email']],
                $data
            );
        }
    }
}
