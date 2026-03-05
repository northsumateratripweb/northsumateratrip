<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Panduan Lengkap Wisata ke Danau Toba',
                'slug' => 'panduan-wisata-danau-toba',
                'excerpt' => 'Semua yang perlu Anda ketahui sebelum berkunjung ke danau vulkanik terbesar di dunia.',
                'content' => '<p>Danau Toba adalah keajaiban alam yang menakjubkan di Sumatera Utara. Sebagai danau vulkanik terbesar di dunia, Toba menawarkan pemandangan yang tak tertandingi dan kekayaan budaya Batak yang kental.</p>
                <h2>Cara Menuju Danau Toba</h2>
                <p>Anda bisa terbang ke Bandara Internasional Silangit yang lebih dekat dengan danau, atau melalui Bandara Kualanamu di Medan dilanjutkan perjalanan darat selama 4-6 jam.</p>
                <h2>Spot Terbaik</h2>
                <ul>
                    <li><strong>Huta Ginjang:</strong> Menikmati pemandangan Danau Toba dari ketinggian.</li>
                    <li><strong>Pulau Samosir:</strong> Inti dari budaya Batak di tengah danau.</li>
                    <li><strong>Air Terjun Sipiso-piso:</strong> Salah satu air terjun tertinggi di Indonesia.</li>
                </ul>',
                'featured_image' => 'danau-toba.jpg',
                'gallery_images' => [],
                'meta_title' => 'Panduan Wisata Danau Toba 2024',
                'meta_description' => 'Tips perjalanan, transportasi, dan destinasi menarik di sekitar Danau Toba Sumatera Utara.',
                'published_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Eksplorasi Bukit Lawang: Bertemu Orangutan',
                'slug' => 'eksplorasi-bukit-lawang',
                'excerpt' => 'Pengalaman tak terlupakan melakukan jungle trekking dan melihat Orangutan di habitat aslinya.',
                'content' => '<p>Bukit Lawang adalah pintu gerbang menuju Taman Nasional Gunung Leuser. Tempat ini terkenal sebagai salah satu tempat terbaik di dunia untuk melihat Orangutan Sumatera yang terancam punah.</p>
                <h2>Aktivitas Utama</h2>
                <p>Trekking hutan adalah aktivitas wajib. Anda akan dipandu oleh guide berpengalaman masuk ke dalam hutan hujan tropis yang lebat.</p>',
                'featured_image' => 'bukit-lawang.jpg',
                'gallery_images' => [],
                'meta_title' => 'Wisata Bukit Lawang Sumatera Utara',
                'meta_description' => 'Panduan jungle trekking di Bukit Lawang untuk melihat Orangutan.',
                'published_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Kota Medan: Surga Kuliner di Sumatera Utara',
                'slug' => 'kuliner-medan-terbaik',
                'excerpt' => 'Daftar makanan wajib coba saat singgah di Kota Medan, dari Ucok Durian hingga Mie Aceh.',
                'content' => '<p>Medan dikenal sebagai salah satu pusat kuliner terbaik di Indonesia. Keberagaman etnis di kota ini menciptakan variasi makanan yang sangat kaya.</p>
                <ul>
                    <li><strong>Durian Ucok:</strong> Ikon kuliner Medan yang buka 24 jam.</li>
                    <li><strong>Bolu Meranti:</strong> Oleh-oleh wajib khas Medan.</li>
                    <li><strong>Mie Balap:</strong> Menu sarapan favorit warga lokal.</li>
                </ul>',
                'featured_image' => 'kuliner-medan.jpg',
                'gallery_images' => [],
                'meta_title' => 'Wisata Kuliner Medan Paling Enak',
                'meta_description' => 'Rekomendasi makanan khas Medan yang wajib dicoba saat berlibur.',
                'published_at' => now(),
                'is_published' => true,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => $blog['slug']],
                $blog
            );
        }
    }
}
