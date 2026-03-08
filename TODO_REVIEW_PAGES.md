# TODO: Review Semua Halaman Website

## Halaman yang perlu dicek:

### 1. Halaman Utama & Publik
- [ ] Home (`/`) - HomeController@index
- [ ] Packages (`/packages`) - Anonymous closure
- [ ] Products Index (`/product`) - ProductController@index
- [ ] Products Category (`/product/category/{slug}`) - ProductController@category
- [ ] Products Show (`/product/{category}/{product}`) - ProductController@show
- [ ] Product Search (`/product/search`) - ProductController@search

### 2. Car Rental
- [ ] Car Rental Index (`/car-rental`) - VehicleController@index
- [ ] Car Detail (`/car/{slug}`) - VehicleController@show
- [ ] Car Order (`/car/{slug}/order`) - VehicleController@storeOrder

### 3. Rental Package
- [ ] Rental Package Index (`/rental-package`) - Anonymous closure
- [ ] Rental Package Detail (`/rental-package/{slug}`) - RentalPackageController@show
- [ ] Rental Package Order (`/rental-package/{slug}/order`) - RentalPackageController@storeOrder

### 4. Blog & Gallery
- [ ] Blog Index (`/blog`) - BlogController@index
- [ ] Blog Show (`/blog/{slug}`) - BlogController@show
- [ ] Gallery (`/gallery`) - GalleryController@index
- [ ] Hotels (`/hotels`) - HotelController@index

### 5. Contact & Custom Request
- [ ] Contact (`/contact`) - ContactController@index
- [ ] Contact Submit (`/contact`) - ContactController@submit
- [ ] Custom Request (`/custom-trip`) - CustomRequestController@create
- [ ] Custom Request Store (`/custom-trip`) - CustomRequestController@store

### 6. Booking & Status
- [ ] Booking Status (`/booking-status`) - BookingStatusController@index
- [ ] Booking Check (`/booking-status`) - BookingStatusController@check
- [ ] API Order Status (`/api/order/{order}/status`) - BookingStatusController@getStatus

### 7. Dashboard & User
- [ ] User Dashboard (`/dashboard`) - UserDashboardController@index (requires auth)

### 8. Static Pages
- [ ] Terms (`/terms`) - Anonymous closure
- [ ] Privacy (`/privacy`) - Anonymous closure
- [ ] Static Page (`/page/{slug}`) - StaticPageController@show
- [ ] Legacy Static (`/{page}`) - PageController@show

### 9. Reports (Admin/Auth required)
- [ ] Laporan Dashboard (`/laporan/dashboard`)
- [ ] Laporan Pesanan (`/laporan/pesanan`)
- [ ] Export CSV
- [ ] Export Excel
- [ ] Trip Import

### 10. Invoice & Documents
- [ ] Order Invoice (`/order/{order}/invoice`)
- [ ] Product Itinerary (`/product/{product}/itinerary`)
- [ ] Product Brochure (`/product/{product}/brochure`)

### 11. SEO & System
- [ ] Sitemap (`/sitemap.xml`)
- [ ] Robots.txt (`/robots.txt`)
- [ ] Language Switcher (`/lang/{locale}`)

## Masalah yang perlu diperbaiki:
- [ ] Error handling untuk missing data
- [ ] Null checks untuk relasi yang mungkin kosong
- [ ] Validasi input yang lebih robust
- [ ] Error pages yang user-friendly

## Prioritas:
1. High: Halaman yang sering dikunjungi (Home, Packages, Product Detail, Car Rental)
2. Medium: Formulir pemesanan dan kontak
3. Low: Halaman admin dan laporan

