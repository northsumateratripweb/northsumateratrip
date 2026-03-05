Upgrade ke Laravel 12 & PHP 8.4

1) Persiapan
- Buat branch kerja baru: git switch -c upgrade-l12-php84
- Pastikan PHP 8.4 terpasang: php -v
- Update Composer ke versi terbaru: composer self-update
- Backup composer.lock, .env, dan database (jika perlu)

2) Perbarui composer.json (contoh)
- Ubah requirement inti dan versi paket terkait:
sd
  {
    "require": {
      "php": "^8.4",
      "laravel/framework": "^12.0",
      "filament/filament": "^4.0"
    },
    "require-dev": {
      "phpunit/phpunit": "^11.4",
      "nunomaduro/collision": "^8.0",
      "laravel/pint": "^1.16"
    }
  }

- Jalankan pembaruan dependensi:
  - composer update --with-all-dependencies
- Jika ada konflik versi:
  - composer why-not laravel/framework 12.*
  - composer outdated
  - Sesuaikan constraint paket yang bertentangan (prioritaskan versi stabil kompatibel)

3) Eksekusi perintah pasca-upgrade
- php artisan package:discover
- php artisan optimize:clear
- php artisan about
- Validasi environment dan jalankan migrasi jika diperlukan:
  - php artisan migrate
- Setelah verifikasi berhasil, cache optimalisasi (opsional, untuk produksi):
  - php artisan config:cache
  - php artisan route:cache
  - php artisan event:cache
  - php artisan view:cache

4) Cek kompatibilitas & perubahan signifikan
- Periksa signature class pada Service Providers & Middleware bila ada perubahan kontrak
- Tinjau konfigurasi queue, broadcasting, cache (driver & opsi bawaan)
- Tinjau kompatibilitas Filament 4 terhadap Laravel 12:
  - Gunakan rilis stabil terbaru (^4.0)
  - Uji panel admin setelah update
- Periksa library pihak ketiga yang mengunci versi Symfony/PSR agar selaras dengan Laravel 12

5) Uji aplikasi
- Menjalankan aplikasi:
  - php artisan serve (atau gunakan web server/Octane)
- Uji panel admin (Filament) dan alur penting (login, CRUD utama)
- Jalankan gaya & test:
  - php vendor/bin/pint
  - php artisan test

6) CI/CD & Produksi
- Perbarui pipeline CI (mis. GitHub Actions) untuk menggunakan PHP 8.4
- Produksi:
  - composer install --no-dev --prefer-dist --optimize-autoloader
  - php artisan migrate --force
  - Jalankan cache: config/route/view/event sesuai kebutuhan
- Monitoring pasca-rilis dan siapkan rencana rollback

7) Rollback (jika diperlukan)
- Kembalikan composer.json & composer.lock dari backup/commit sebelumnya
- composer install
- Revert branch: git switch - ; git reset --hard <commit_sebelum_upgrade>

Catatan
- Lingkungan lokal saat ini PHP 8.2, sehingga upgrade belum dieksekusi otomatis.
- Setelah PHP 8.4 tersedia, jalankan langkah di atas pada branch terpisah, validasi penuh, lalu merge ke main.
