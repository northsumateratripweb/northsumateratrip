<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Syarat & Ketentuan',
                'slug' => 'terms',
                'content_type' => 'text',
                'content' => '<h2>1. Reservasi & Pemesanan</h2>
<p>Pemesanan dianggap sah setelah customer melakukan konfirmasi booking melalui WhatsApp dan menyetujui detail perjalanan yang telah disepakati.</p>

<h2>2. Pembayaran</h2>
<p>Pembayaran dilakukan melalui transfer bank sesuai instruksi yang diberikan. DP minimal 50% dari total biaya diperlukan untuk mengonfirmasi booking.</p>

<h2>3. Pembatalan</h2>
<ul>
    <li>Pembatalan H-7 sebelum keberangkatan: refund 75%</li>
    <li>Pembatalan H-3 sebelum keberangkatan: refund 50%</li>
    <li>Pembatalan H-1 atau hari H: tidak ada refund</li>
</ul>

<h2>4. Perubahan Jadwal</h2>
<p>Perubahan jadwal perjalanan dapat dilakukan dengan menghubungi tim kami minimal 3 hari sebelum keberangkatan (tergantung ketersediaan).</p>

<h2>5. Force Majeure</h2>
<p>Dalam keadaan bencana alam, kerusuhan sosial, atau force majeure lainnya, perjalanan dapat dijadwalkan ulang tanpa biaya tambahan.</p>

<h2>6. Tanggung Jawab</h2>
<p>Kami tidak bertanggung jawab atas kehilangan barang pribadi selama perjalanan. Customer diharapkan menjaga barang bawaan masing-masing.</p>',
                'is_published' => true,
                'meta_title' => 'Syarat & Ketentuan Layanan NST',
                'meta_description' => 'Syarat dan ketentuan pemesanan trip, penyewaan mobil, kebijakan pembatalan, dan pengembalian dana (refund) di NorthSumateraTrip.',
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'privacy',
                'content_type' => 'text',
                'content' => '<h2>1. Informasi yang Kami Kumpulkan</h2>
<p>Kami mengumpulkan informasi yang Anda berikan secara langsung saat melakukan pemesanan, menghubungi kami, atau mengisi formulir di website, termasuk nama, email, nomor telepon, dan tanggal perjalanan.</p>

<h2>2. Penggunaan Informasi</h2>
<p>Informasi yang dikumpulkan digunakan untuk:</p>
<ul>
    <li>Memproses dan mengelola pemesanan Anda</li>
    <li>Berkomunikasi terkait layanan kami</li>
    <li>Mengirimkan informasi promosi (jika disetujui)</li>
    <li>Meningkatkan layanan kami</li>
</ul>

<h2>3. Keamanan Data</h2>
<p>Kami menerapkan langkah-langkah keamanan yang wajar untuk melindungi data pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah.</p>

<h2>4. Berbagi Data</h2>
<p>Kami tidak menjual, memperdagangkan, atau mentransfer informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali jika diperlukan oleh hukum.</p>

<h2>5. Cookie</h2>
<p>Website kami menggunakan cookie untuk meningkatkan pengalaman pengguna. Anda dapat menonaktifkan cookie melalui pengaturan browser Anda.</p>

<h2>6. Kontak</h2>
<p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami melalui halaman kontak.</p>',
                'is_published' => true,
                'meta_title' => 'Kebijakan Privasi Pengguna NST',
                'meta_description' => 'Bagaimana NorthSumateraTrip mengumpulkan, menyimpan, menggunakan, dan melindungi data pribadi serta privasi pengunjung website kami.',
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
