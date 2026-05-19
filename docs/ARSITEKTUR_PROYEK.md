# 🏗️ Arsitektur Proyek: Frontend, Backend, & Hubungannya

Proyek **NorthSumateraTrip** dibangun menggunakan arsitektur **Monolitik** (Monolithic Architecture) yang modern dengan basis framework **Laravel 11**. Dalam arsitektur ini, seluruh komponen sistem (Frontend, Backend, dan Database layer) berada di dalam satu wadah (*codebase*) yang sama. 

Pendekatan monolitik ini dipilih karena memberikan kecepatan pengembangan (Rapid Application Development), performa tinggi via Server-Side Rendering (SSR), serta kemudahan pengelolaan (*maintenance*) tanpa harus memelihara banyak *repository* atau server secara terpisah.

Berikut adalah penjelasan rinci mengenai komponen sistem ini:

---

## 💻 1. Frontend (Sisi Pengunjung/Client)

Frontend pada proyek ini adalah segala hal yang dilihat dan diinteraksikan oleh pengunjung publik saat membuka website. Sistem antarmuka ini dirender langsung oleh server (Server-Side Rendering).

* **Teknologi Utama:** 
  * **Laravel Blade:** Mesin templating bawaan Laravel. Merubah data dari backend menjadi dokumen HTML dinamis.
  * **Tailwind CSS 3.x:** Framework CSS utilitas untuk mendesain tampilan website yang modern, responsif, dan elegan.
  * **Alpine.js:** Framework JavaScript minimalis yang menangani interaktivitas (seperti dropdown, modal, atau slider) tanpa perlu menulis kode JS yang rumit.
  * **Swiper.js:** Library untuk membuat carousel/slider gambar (contoh: galeri destinasi wisata).
* **Lokasi Kode:** Seluruh desain dan komponen tampilan ini berada di dalam folder `resources/views`.
* **Peran Utama:**
  * Menampilkan informasi paket wisata, rute (itinerary), rental mobil, dan artikel blog secara SEO-friendly karena HTML sudah dirender saat sampai di browser Google.
  * Menerima input pengunjung (misal: mengisi form booking) dan mengirimkannya kembali ke server.

---

## ⚙️ 2. Backend (Sisi Server & Admin)

Backend adalah mesin penggerak utama (*core engine*) di balik layar yang memproses logika bisnis, mengamankan data, berinteraksi dengan database, dan menyediakan panel manajemen konten (CMS).

* **Teknologi Utama:**
  * **Laravel 11 (PHP 8.2+):** Menangani *routing* (URL), validasi, interaksi ke database, dan mengamankan aplikasi dari celah keamanan.
  * **Eloquent ORM:** Sistem pemetaan database (ORM) yang mempermudah interaksi dan query ke database MySQL/SQLite.
  * **Filament PHP 4.0:** Framework canggih pembuat *Admin Panel* berbasis TALL stack (Tailwind, Alpine, Laravel, Livewire).
* **Lokasi Kode:** 
  * Logika kontroler di `app/Http/Controllers`.
  * Model database di `app/Models`.
  * Konfigurasi Admin (Filament) di `app/Filament/Resources`.
* **Peran Utama:**
  * **Manajemen Konten (CMS):** Melalui Filament Admin (`/admin`), pengelola website dapat dengan mudah menambah/mengedit paket Trip, Kendaraan, atau Postingan Blog tanpa perlu mengerti *coding*.
  * **Proses Booking:** Saat ada pelanggan yang memesan, Backend bertugas memvalidasi ketersediaan jadwal, menghitung harga total, menyimpan transaksi, dan (jika diaktifkan) mengirimkan notifikasi WhatsApp/Email.
  * **Keamanan:** Memastikan hanya Admin yang sah (autentikasi berlapis) yang bisa mengakses dashboard dan mengubah data krusial.

---

## 🔄 3. Hubungan Kedua Sistem (Alur Data)

Karena ini adalah aplikasi monolitik, interaksi antara Frontend dan Backend terjadi secara internal di dalam satu server, yang membuat proses perpindahan data menjadi sangat cepat dan efisien.

### A. Alur Membuka Halaman (Data Fetching)
1. **Pengunjung Membuka Halaman:** User mengetikkan URL (misalnya `northsumateratrip.com/trip`) di browser.
2. **Router Menerima Request:** Server Laravel (file `routes/web.php`) menerima request ini dan mengarahkannya ke **Controller** yang tepat (misal: `TripController`).
3. **Mengambil Data (Model):** Controller memerintahkan **Model** (`Trip.php`) untuk mengambil data dari Database (MySQL).
4. **Merender Tampilan (View):** Setelah data didapatkan, Controller mengirimkan data tersebut ke **Blade Template** (`resources/views/pages/trip/index.blade.php`).
5. **Mengirim ke Browser:** Server mengubah Blade menjadi file HTML utuh, merangkainya dengan Tailwind CSS, lalu mengirimkannya ke browser pengunjung. Halaman web tampil seketika!

### B. Alur Manajemen Admin (Data Mutation)
1. **Admin Mengelola Data:** Admin login ke halaman `/admin` (Sistem Filament). Panel ini sangat interaktif berkat integrasi **Livewire**.
2. **Mengubah Konten:** Admin menambahkan "Paket Trip Baru", menekan tombol *Save*.
3. **Database Ter-update:** Filament secara otomatis memvalidasi isian dan menyimpannya ke tabel *Trips* di Database.
4. **Efek ke Frontend:** Begitu data tersimpan, setiap pengunjung yang sedang membuka website publik akan langsung melihat "Paket Trip Baru" tersebut. Tidak perlu ada sinkronisasi eksternal, karena Frontend dan Backend membaca dari satu database yang sama.

---

## 🎯 Kesimpulan Arsitektur

Arsitektur Monolitik dengan Laravel + Filament + Blade ini adalah struktur ideal untuk platform Tour & Travel yang membutuhkan performa tinggi (khususnya performa SEO), keamanan kuat, dan kemudahan dalam pengembangan fitur baru di masa mendatang tanpa *overhead* pemeliharaan sistem *Headless/Decoupled*.
