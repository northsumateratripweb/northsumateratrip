<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingStatusController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Hotels
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels');

// Packages (All products)
Route::get('/packages', function () {
    $products = \App\Models\Product::active()->orderBy('sort_order')->paginate(12);
    $categories = \App\Models\Category::active()->orderBy('sort_order')->get();

    return view('pages.packages', compact('products', 'categories'));
})->name('packages');

// Car Rental - uses CarRental model with slug
Route::get('/car-rental', [VehicleController::class, 'index'])->name('car-rental');
Route::get('/car/{slug}', [VehicleController::class, 'show'])->name('car.detail');
Route::post('/car/{slug}/order', [VehicleController::class, 'storeOrder'])->name('car.order')->middleware('throttle:5,1');

// Rental Package
Route::prefix('rental-package')->group(function () {
    Route::get('/', function () {
        $packages = \App\Models\RentalPackage::where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);
        return view('pages.rental-package', compact('packages'));
    })->name('rental-package');

    Route::get('/{slug}', [App\Http\Controllers\RentalPackageController::class, 'show'])->name('rental-package.show');
    Route::post('/{slug}/order', [App\Http\Controllers\RentalPackageController::class, 'storeOrder'])->name('rental-package.order')->middleware('throttle:5,1');
});

// Products
Route::prefix('product')->group(function () {
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/category/{category:slug}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/{category:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/{product:slug}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('products.review')->middleware('throttle:3,1');
    Route::post('/{product:slug}/order', [\App\Http\Controllers\OrderController::class, 'store'])->name('products.order')->middleware('throttle:5,1');
});

// Blog
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');
});

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit')->middleware('throttle:3,1');

// Custom Trip Request
Route::get('/custom-trip', [CustomRequestController::class, 'create'])->name('custom-request.create');
Route::post('/custom-trip', [CustomRequestController::class, 'store'])->name('custom-request.store')->middleware('throttle:5,1');

// Booking Status
Route::get('/booking-status', [BookingStatusController::class, 'index'])->name('booking.status');
Route::post('/booking-status', [BookingStatusController::class, 'check'])->name('booking.check')->middleware('throttle:3,1');
Route::get('/api/order/{order}/status', [BookingStatusController::class, 'getStatus'])->name('api.order.status');


// User Dashboard (authenticated)
Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Language switcher (handled by LocaleController below)

// Legal Pages
Route::get('/terms', function () {
    return view('pages.legal.terms');
})->name('legal.terms');

Route::get('/privacy', function () {
    return view('pages.legal.privacy');
})->name('legal.privacy');

// SEO
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots']);

// Static Pages (CMS)
Route::get('/page/{slug}', [StaticPageController::class, 'show'])->name('page.show');




// ─── URL Redirects / Aliases ────────────────────────────────────────────────
// Redirect common URL aliases to canonical URLs
Route::redirect('/products', '/product', 301);
Route::redirect('/wisata', '/product', 301);
Route::redirect('/paket-wisata', '/product', 301);
Route::redirect('/rental-packages', '/rental-package', 301);
Route::redirect('/paket-rental', '/rental-package', 301);
Route::redirect('/sewa-mobil', '/car-rental', 301);

// Invoices & Itineraries
Route::get('/order/{order}/invoice', [InvoiceController::class, 'orderPdf'])->name('order.invoice')->middleware(['auth', 'throttle:10,1']);
Route::get('/product/{product}/itinerary', [InvoiceController::class, 'itineraryPdf'])->name('product.itinerary')->middleware('throttle:20,1');
Route::get('/product/{product:slug}/brochure', [InvoiceController::class, 'brochurePdf'])->name('product.brochure')->middleware('throttle:20,1');

// Locale Switcher
Route::get('lang/{locale}', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('lang.switch');

// Catch-all route for static pages (legacy)
Route::get('/{page:slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.static');

// Laporan Pesanan (protected — admin only)
Route::middleware(['auth'])->prefix('laporan')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\LaporanPesananController::class, 'dashboard'])->name('dashboard.laporan');
    Route::get('/pesanan', [App\Http\Controllers\LaporanPesananController::class, 'laporan'])->name('laporan.pesanan');
    Route::get('/pesanan/export-csv', [App\Http\Controllers\LaporanPesananController::class, 'exportCsv'])->name('laporan.pesanan.csv');
    Route::get('/pesanan/export-excel', [App\Http\Controllers\LaporanPesananController::class, 'exportExcel'])->name('laporan.pesanan.excel');
    Route::post('/trip-import', [App\Http\Controllers\TripImportController::class, 'import'])->name('trip.import');
});
