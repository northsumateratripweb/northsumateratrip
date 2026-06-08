<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'NorthSumateraTrip',
            'whatsapp_number' => '6281298622143',
            'whatsapp_display' => '+62 812-9862-2143',
            'site_email' => 'hello@northsumateratrip.com',
            'site_address' => 'Medan, Sumatera Utara, Indonesia',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254759.34723920093!2d98.5550337!3d3.5952472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303131db7687c6b7%3A0x74d7e7a9e1e0437a!2sMedan%2C%20Kota%20Medan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',
            'working_hours' => 'Senin - Minggu: 08:00 - 20:00 WIB',
            'facebook_url' => 'https://facebook.com/northsumateratrip',
            'instagram_url' => 'https://instagram.com/northsumateratrip',
            'tiktok_url' => 'https://tiktok.com/@northsumateratrip',
            'youtube_url' => 'https://youtube.com/@northsumateratrip',
            'twitter_url' => 'https://x.com/nsumateratrip',
            'site_logo' => 'https://picsum.photos/seed/logo-nst/200/60',
            'site_favicon' => 'https://picsum.photos/seed/favicon-nst/32/32',
            'meta_description' => 'NorthSumateraTrip.com - Jasa tour & travel terpercaya di Sumatera Utara. Paket wisata Danau Toba, Berastagi, Bukit Lawang, Nias, rental mobil, dan custom trip.',
            'meta_keywords' => 'tour sumatera utara, wisata danau toba, paket trip medan, rental mobil medan, bukit lawang orangutan, berastagi, nias, honeymoon toba',
            'google_analytics_id' => 'G-XXXXXXXXXX',
            'bank_name_1' => 'BCA',
            'bank_account_1' => '1234567890',
            'bank_holder_1' => 'PT North Sumatera Trip',
            'bank_name_2' => 'BNI',
            'bank_account_2' => '0987654321',
            'bank_holder_2' => 'PT North Sumatera Trip',
            'qris_image' => 'https://picsum.photos/seed/qris-nst/300/300',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
