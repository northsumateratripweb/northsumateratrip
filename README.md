# NorthSumateraTrip - Premium Tour & Travel platform

[![Laravel 11](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Filament 4](https://img.shields.io/badge/Filament-4.0%20(Alpha)-FFA500?style=flat-square&logo=filament)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)

**NorthSumateraTrip** adalah platform website tour and travel premium yang dirancang khusus untuk layanan wisata di Sumatera Utara. Dibangun dengan teknologi terbaru dari ekosistem Laravel, website ini menawarkan pengalaman pengguna yang modern, performa tinggi, dan kemudahan pengelolaan konten bagi admin.

## 🌟 Fitur Utama

### 🏞️ Manajemen Produk Wisata
- **Katalog Trip**: Daftar paket wisata dengan filter kategori yang dinamis.
- **Detail Itinerary**: Informasi lengkap per hari, galeri foto, dan rincian harga.
- **Sistem Booking**: Pemesanan langsung yang terintegrasi dengan WhatsApp dan database.
- **Download Dokumen**: Fitur cetak Itinerary dan Brosur dalam format PDF.

### 🚗 Sewa Kendaraan (Car Rental)
- **Manajemen Armada**: Daftar kendaraan yang tersedia untuk disewa.
- **Paket Rental**: Opsi paket sewa dengan durasi dan layanan berbeda.
- **Booking Jadwal**: Pengecekan status ketersediaan dan pemesanan kendaraan.

### 📝 Konten & CMS
- **Blog / Travel Guide**: Artikel panduan wisata untuk meningkatkan SEO.
- **Galeri Foto**: Media showcase untuk destinasi wisata.
- **Halaman Statis**: Pengelolaan halaman 'About', 'Terms', dan 'Privacy' via Admin Panel.
- **Testimoni/Review**: Sistem ulasan dari pelanggan untuk setiap produk.

### 📊 Admin Panel (Filament)
- **Dashboard Statistik**: Ringkasan pesanan dan performa website.
- **Laporan Pesanan**: Ekspor data pesanan ke format CSV dan Excel.
- **Trip Import**: Kemudahan input data trip dalam jumlah banyak via upload file.
- **SEO Manager**: Pengaturan Meta Tag, Open Graph, dan Keywords per halaman.

### 🌍 Fitur Lanjutan
- **Multi-currency & Language**: Sistem siap untuk lokalisasi (IDR, USD, dll).
- **Booking Status**: Pelanggan dapat mengecek status pesanan mereka secara real-time.
- **Custom Trip Request**: Form khusus bagi pelanggan yang menginginkan rencana perjalanan kustom.

## 🛠️ Teknologi

- **Backend**: Laravel 11 & PHP 8.2+
- **Admin Panel**: Filament 4.0 (Alpha)
- **Frontend**: Tailwind CSS, Alpine.js, Swiper.js
- **Database**: MySQL / SQLite
- **PDF Engine**: Laravel DomPDF
- **Excel/CSV**: Maatwebsite Excel
- **Real-time**: Laravel Reverb (Opsional)
- **Error Tracking**: Sentry

## 🚀 Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/northsumateratrip.git
   cd northsumateratrip
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Sesuaikan `.env` untuk database (MySQL atau SQLite). Jika menggunakan SQLite:
   ```bash
   touch database/database.sqlite
   ```

5. **Migrate & Seed**
   ```bash
   php artisan migrate --seed
   ```

6. **Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Run Server**
   ```bash
   php artisan serve
   ```

## 📁 Struktur Proyek Utama

- `app/Http/Controllers`: Logika bisnis website.
- `app/Models`: Definisi skema database dan relasi.
- `app/Filament/Resources`: Konfigurasi Admin Panel.
- `resources/views`: Template tampilan menggunakan Blade.
- `routes/web.php`: Definisi semua rute URL.
- `database/migrations`: Skema tabel database.

## 📄 Lisensi

Proyek ini berada di bawah lisensi MIT.

---
**NorthSumateraTrip** - *Eksplorasi Sumatera Utara dengan layanan premium.*
