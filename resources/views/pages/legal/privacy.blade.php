@extends('layouts.main')

@section('title', 'Kebijakan Privasi - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))

@section('content')
<section class="py-16 bg-white min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-8">Kebijakan Privasi</h1>
        <div class="prose prose-lg max-w-none text-slate-700">
            <h2>1. Informasi yang Kami Kumpulkan</h2>
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
            <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami melalui halaman kontak.</p>
        </div>
    </div>
</section>
@endsection
