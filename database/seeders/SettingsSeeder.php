<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'facebook_url'      => 'https://facebook.com/northsumateratrip',
            'instagram_url'     => 'https://instagram.com/northsumateratrip',
            'tiktok_url'        => 'https://tiktok.com/@northsumateratrip',
            'youtube_url'       => 'https://youtube.com/@northsumateratrip',
            'twitter_url'       => 'https://x.com/nsumateratrip',
            'site_logo'         => 'https://picsum.photos/seed/logo-nst/200/60',
            'site_favicon'      => 'https://picsum.photos/seed/favicon-nst/32/32',
            'meta_description'  => 'NorthSumateraTrip.com - Jasa tour & travel terpercaya di Sumatera Utara. Paket wisata Danau Toba, Berastagi, Bukit Lawang, Nias, rental mobil, dan custom trip.',
            'meta_keywords'     => 'tour sumatera utara, wisata danau toba, paket trip medan, rental mobil medan, bukit lawang orangutan, berastagi, nias, honeymoon toba',
            'google_analytics_id'=> 'G-XXXXXXXXXX',
            'bank_name_1'       => 'BCA',
            'bank_account_1'    => '1234567890',
            'bank_holder_1'     => 'PT North Sumatera Trip',
            'bank_name_2'       => 'BNI',
            'bank_account_2'    => '0987654321',
            'bank_holder_2'     => 'PT North Sumatera Trip',
            'qris_image'        => 'https://picsum.photos/seed/qris-nst/300/300',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
