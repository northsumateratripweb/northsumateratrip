# Dokumentasi Proyek NorthSumateraTrip

## 📖 Pendahuluan
NorthSumateraTrip adalah aplikasi berbasis web yang dirancang untuk penyedia jasa tour dan travel di Sumatera Utara. Fokus utama aplikasi ini adalah memberikan kemudahan bagi admin untuk mengelola paket wisata, armada rental, dan konten blog, serta memberikan pengalaman booking yang seamless bagi pelanggan.

---

## 🛠️ Arsitektur Teknis
Aplikasi ini dibangun dengan standar modern Laravel 11:
- **Framework**: Laravel 11 (Skeleton v11.x)
- **Admin**: Filament PHP v4 (untuk kemudahan pengelolaan resource)
- **Frontend**: Blade Template Engine dengan Tailwind CSS untuk styling.
- **Interaktivitas**: Alpine.js untuk komponen UI ringan dan Swiper.js untuk slider.
- **Data Export**: Maatwebsite Excel untuk laporan.
- **Dokumentasi PDF**: Barryvdh Laravel DomPDF untuk generate invoice dan itinerary.

---

## 📂 Struktur Modul Utama

### 1. Modul Produk & Paket Wisata (`Product`)
- **Kategori**: Mengelompokkan paket (misal: Danau Toba, Bukit Lawang).
- **Relasi**: Setiap produk memiliki banyak `Itinerary` (harian), `Gallery` (foto), dan `Review`.
- **Fitur PDF**: 
    - `Itinerary PDF`: Menghasilkan ringkasan perjalanan yang bisa diunduh tamu.
    - `Brochure PDF`: Brosur ringkas untuk promosi.

### 2. Modul Rental Kendaraan (`Car Rental`)
- **Vehicle**: Daftar mobil/motor yang disewakan.
- **Rental Package**: Paket sewa khusus (misal: Sewa 24 jam dengan driver).
- **Sistem Order**: Menyimpan pesanan rental ke database sebelum diarahkan ke WhatsApp.

### 3. Modul CMS & SEO
- **Blog**: Artikel yang mendukung optimasi kata kunci (SEO).
- **Settings**: Pengaturan global seperti logo, nama site, nomor WhatsApp, dan warna brand (Primary/Secondary).
- **SEO Fields**: Setiap halaman, produk, dan blog memiliki field khusus untuk Meta Title, Description, dan Keywords.

### 4. Modul Pemesanan (`Orders`)
- **Alur**: User mengisi form -> Data disimpan di database -> Redirect ke WhatsApp dengan teks otomatis yang rapi.
- **Booking Status**: Pelanggan bisa kembali ke web untuk mengecek status pesanan mereka menggunakan Order ID.

---

## 🛂 Admin Panel (Filament)
Akses panel admin biasanya berada di `/admin`. Resource yang tersedia:
- **ProductResource**: Kelola paket wisata.
- **CategoryResource**: Kelola kategori wisata.
- **VehicleResource**: Kelola unit kendaraan.
- **BlogResource**: Kelola artikel blog.
- **OrderResource**: Pantau dan update status pesanan (Pending, Confirmed, Cancelled).
- **SettingResource**: Atur konfigurasi website tanpa menyentuh kode.

---

## 📄 Pengaturan PDF & Laporan
Aplikasi ini memiliki endpoint khusus untuk laporan:
- `/laporan/dashboard`: Statistik visual pesanan.
- `/laporan/pesanan`: Daftar pesanan yang bisa difilter.
- `/laporan/pesanan/export-csv`: Unduh data dalam format CSV.
- `/laporan/pesanan/export-excel`: Unduh data dalam format Excel.

---

## ⚙️ Variabel Environment (.env)
Beberapa variabel kunci yang perlu diperhatikan:
- `WHATSAPP_NUMBER`: Nomor tujuan booking (format: 628...).
- `PRIMARY_COLOR`: Warna utama brand (Hex code).
- `SECONDARY_COLOR`: Warna sekunder brand (Hex code).
- `DB_CONNECTION`: Disarankan `mysql` untuk produksi atau `sqlite` untuk dev cepat.

---

## 🧪 Panduan Pengembangan
1. **Tambah Fitur Baru**:
   - Jika butuh CRUD admin baru, gunakan: `php artisan make:filament-resource NamaModel`
   - Pastikan menambahkan policy jika menggunakan otentikasi ketat.
2. **Ubah Tampilan**:
   - Tampilan utama ada di `resources/views/pages/`.
   - Layout global ada di `resources/views/layouts/main.blade.php`.
3. **Optimasi Asset**:
   - Jalankan `npm run build` setelah mengubah file CSS atau JS.

---
*Dibuat untuk mempermudah pemahaman struktur dan operasional proyek NorthSumateraTrip.*
