@extends('layouts.main')

@section('title', 'Syarat & Ketentuan - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))

@section('content')
<section class="py-16 bg-white min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-8">Syarat & Ketentuan</h1>
        <div class="prose prose-lg max-w-none text-slate-700">
            <h2>1. Reservasi & Pemesanan</h2>
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
            <p>Kami tidak bertanggung jawab atas kehilangan barang pribadi selama perjalanan. Customer diharapkan menjaga barang bawaan masing-masing.</p>
        </div>
    </div>
</section>
@endsection
