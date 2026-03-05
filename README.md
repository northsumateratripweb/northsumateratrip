# NorthSumateraTrip - Laravel

Website tour and travel untuk wisata private di Yogyakarta, dikloning dari [northsumateratrip.com](https://northsumateratrip.com/).

## Fitur

- **Homepage** dengan hero section, produk unggulan, panduan ngetrip, dan partner
- **Katalog Produk** dengan filter kategori
- **Detail Produk** dengan galeri gambar, pilihan trip, pricing, dan tabs
- **Blog/Panduan Ngetrip** untuk artikel wisata
- **Halaman Kontak** dengan form dan peta
- **WhatsApp Integration** untuk booking

## Teknologi

- Laravel 11
- PHP 8.2+
- Tailwind CSS
- Font Awesome
- SQLite (default) / MySQL

## Instalasi

### 1. Clone Repository

```bash
cd northsumateratrip-laravel
```

### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

Untuk SQLite:
```bash
touch database/database.sqlite
```

Untuk MySQL, sesuaikan konfigurasi di `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=northsumateratrip
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrate dan Seed

```bash
php artisan migrate --seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Server

```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

## Struktur Folder

```
northsumateratrip-laravel/
├── app/
│   ├── Http/Controllers/    # Controller
│   ├── Models/              # Model Eloquent
│   └── Providers/           # Service Provider
├── config/                  # Konfigurasi
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── public/
│   ├── css/                 # Stylesheet
│   ├── js/                  # JavaScript
│   └── images/              # Gambar
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Web routes
└── .env                     # Environment variables
```

## Konfigurasi

### WhatsApp Number

Edit di `.env`:
```
WHATSAPP_NUMBER=6281298622143
```

### Upload Gambar

Upload gambar produk ke:
- `public/images/products/`

Upload gambar blog ke:
- `public/images/blogs/`

Upload logo partner ke:
- `public/images/partners/`

## Admin Panel (Opsional)

Untuk menambahkan admin panel, Anda bisa menginstall:
- [Filament](https://filamentphp.com/)
- [Laravel Nova](https://nova.laravel.com/)
- atau membuat custom admin panel

## Lisensi

MIT License

## Kontak

NorthSumateraTrip  
WhatsApp: +62 812-9862-2143  
Email: hello@northsumateratrip.com
