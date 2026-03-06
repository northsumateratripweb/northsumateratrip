@extends('layouts.main')

@section('title', ($settings['site_name'] ?? 'NorthSumateraTrip') . ' - ' . ($settings['site_slogan'] ?? 'Premium Tour & Travel'))

@push('schema')
    {!! \App\Helpers\SchemaHelper::organization($settings) !!}
@endpush

@section('header_hero')
@php 
    $heroRaw = \App\Models\Setting::get('default_hero_image');
    
    // Tentukan apakah admin pernah set hero images
    // Jika key ada di DB (sudah pernah disimpan), hormati nilainya
    $heroSettingExists = \App\Models\Setting::where('key', 'default_hero_image')->exists();
    
    $heroImages = $heroRaw;
    if (!is_array($heroImages)) {
        $heroImages = $heroImages ? [$heroImages] : [];
    }
    
    // Filter out HEIC files and validate existence
    $uploadedUrls = array_values(array_filter(array_map(function($path) {
        if (empty($path)) return null;
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, ['heic', 'heif'])) return null;
        if (!str_starts_with($path, 'http') && !file_exists(storage_path('app/public/' . $path))) return null;
        return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
    }, $heroImages)));

    if (!empty($uploadedUrls)) {
        $heroUrls = $uploadedUrls;
    } else {
        // Belum ada hero image — gunakan placeholder gradient
        $heroUrls = ['https://placehold.co/1920x1080/1E3A5F/white?text=Upload+Hero+Image+di+Admin+Panel'];
    }
    $slideCount = count($heroUrls);
@endphp
<section class="overflow-hidden" id="header-hero">
    <div class="relative w-full h-[85vh] min-h-[480px] max-h-[720px] overflow-hidden group"
         x-data="heroSlider({{ $slideCount }})" x-init="init()"
         @mouseenter="pauseAuto()" @mouseleave="resumeAuto()"
         @if($slideCount > 1)
         @touchstart.passive="touchStart($event)"
         @touchend.passive="touchEnd($event)"
         @endif>

        {{-- Slide track — all images side-by-side --}}
        <div class="hero-track flex h-full transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] will-change-transform"
             :style="'width:{{ $slideCount * 100 }}%; transform:translateX(-' + (current * (100 / {{ $slideCount }})) + '%)'">
            @foreach($heroUrls as $i => $url)
            <div class="relative h-full flex-shrink-0" style="width:{{ 100 / $slideCount }}%">
                <img src="{{ $url }}"
                     alt="Hero {{ $i + 1 }}"
                     class="block w-full h-full object-cover animate-[kenburns_25s_ease-in-out_infinite_alternate]"
                     width="1920" height="1080"
                     @if($i === 0) fetchpriority="high" @else loading="lazy" @endif
                     decoding="async" />
            </div>
            @endforeach
        </div>

        {{-- Gradient overlays --}}
        <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-black/30 to-transparent pointer-events-none z-[5]"></div>
        <div class="absolute inset-x-0 bottom-0 h-3/5 bg-gradient-to-t from-slate-950/80 via-slate-950/40 to-transparent pointer-events-none z-[5]"></div>

        {{-- Hero Content --}}
        <div class="absolute inset-x-0 bottom-0 z-10 px-6 pb-10 md:pb-14" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-end md:justify-between gap-5 md:gap-10">
                <div class="flex-1 min-w-0" x-show="shown"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 translate-y-6"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.08] tracking-tight">
                        {{ \App\Models\Setting::get('hero_title', 'Jelajahi Keindahan Sumatera Utara') }}
                    </h1>
                    <p class="mt-3 text-sm sm:text-base md:text-lg text-white/75 font-medium max-w-xl leading-relaxed">
                        {{ \App\Models\Setting::get('hero_subtitle', 'Nikmati pengalaman wisata terbaik dengan layanan private trip eksklusif kami.') }}
                    </p>
                </div>

                <div class="flex flex-row items-center gap-3 shrink-0" x-show="shown"
                     x-transition:enter="transition ease-out duration-1000 delay-300"
                     x-transition:enter-start="opacity-0 translate-y-6"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <a href="{{ route('products.index') }}" 
                       class="px-7 py-3.5 bg-white text-slate-900 font-bold text-sm rounded-2xl hover:bg-blue-50 transition-all duration-300 hover:scale-[1.03] shadow-xl shadow-black/10 whitespace-nowrap">
                        {{ __('ui.view_all_packages') }}
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '628123456789')) }}"
                       target="_blank"
                       class="px-7 py-3.5 bg-emerald-500 text-white font-bold text-sm rounded-2xl hover:bg-emerald-600 transition-all duration-300 hover:scale-[1.03] shadow-xl shadow-emerald-900/20 flex items-center gap-2 whitespace-nowrap">
                        <i class="fab fa-whatsapp text-lg"></i>
                        {{ __('ui.nav_contact') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Arrow navigation — only when multiple slides --}}
        @if($slideCount > 1)
        <button type="button" @click="prev()" aria-label="Previous slide"
                class="absolute left-4 md:left-6 top-1/2 -translate-y-1/2 z-20
                       w-11 h-11 rounded-2xl flex items-center justify-center
                       bg-white/10 hover:bg-white/90 backdrop-blur-md
                       text-white hover:text-slate-900
                       border border-white/15 shadow-2xl
                       transition-all duration-300
                       opacity-0 group-hover:opacity-100
                       -translate-x-4 group-hover:translate-x-0
                       active:scale-90">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>
        <button type="button" @click="next()" aria-label="Next slide"
                class="absolute right-4 md:right-6 top-1/2 -translate-y-1/2 z-20
                       w-11 h-11 rounded-2xl flex items-center justify-center
                       bg-white/10 hover:bg-white/90 backdrop-blur-md
                       text-white hover:text-slate-900
                       border border-white/15 shadow-2xl
                       transition-all duration-300
                       opacity-0 group-hover:opacity-100
                       translate-x-4 group-hover:translate-x-0
                       active:scale-90">
            <i class="fas fa-chevron-right text-sm"></i>
        </button>

        {{-- Dot indicators --}}
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-20">
            @foreach($heroUrls as $i => $url)
            <button @click="goTo({{ $i }})" aria-label="Slide {{ $i + 1 }}"
                    class="h-2 rounded-full transition-all duration-500 cursor-pointer"
                    :class="current === {{ $i }}
                        ? 'bg-white w-7 shadow-lg'
                        : 'bg-white/35 w-2 hover:bg-white/60'">
            </button>
            @endforeach
        </div>
        @endif

    </div>
</section>
@endsection

@section('content')

{{-- Promotion Banners --}}
@if(isset($promotionBanners) && $promotionBanners->isNotEmpty())
<section class="py-6 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-{{ $promotionBanners->count() >= 2 ? '2' : '1' }} gap-4">
            @foreach($promotionBanners as $banner)
            <div class="relative overflow-hidden rounded-2xl group shadow-sm hover:shadow-lg transition-shadow duration-500">
                @if($banner->link_url)
                <a href="{{ $banner->link_url }}" @if(str_starts_with($banner->link_url, 'http')) target="_blank" @endif>
                @endif
                    <img src="{{ $banner->resolved_image_url }}"
                         alt="{{ $banner->title }}"
                         class="w-full h-40 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-700 ease-out rounded-2xl">
                    @if($banner->title)
                    <div class="absolute bottom-0 left-0 right-0 px-5 py-4 bg-gradient-to-t from-black/60 to-transparent rounded-b-2xl">
                        <p class="text-white font-bold text-sm">{{ $banner->title }}</p>
                    </div>
                    @endif
                @if($banner->link_url)
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Populer</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('ui.popular_trips') }}</h2>
                <p class="text-slate-400 text-sm mt-1.5">{{ __('ui.popular_trips_sub') }}</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="flex items-center gap-1 mr-3">
                    <button type="button" class="scroll-prev w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200 opacity-30 pointer-events-none">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button type="button" class="scroll-next w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 group">
                    {{ __('ui.view_all_packages') }}
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
                </a>
            </div>
        </div>

        <div class="horizontal-scroll-container -mx-5 px-5 flex overflow-x-auto gap-5 pb-8 snap-x no-scrollbar">
            @foreach($featuredProducts as $product)
            <a href="{{ route('products.show', ['category' => $product->category->slug, 'product' => $product->slug]) }}" class="w-[280px] sm:w-[300px] flex-shrink-0 bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 group snap-start block cursor-pointer">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    @if($product->duration)
                    <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-slate-700 text-xs font-semibold px-3 py-1.5 rounded-xl flex items-center gap-1.5 shadow-sm">
                        <i class="fas fa-calendar-day text-blue-500 text-[10px]"></i>
                        {{ $product->duration }}
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 text-[15px] mb-2.5 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                        {{ $product->name }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <p class="text-blue-600 font-extrabold text-base">
                            @php
                                $priceMin = $product->price_min ?? 0;
                                $priceMax = $product->price_max ?? $priceMin;
                            @endphp
                            {{ currency($priceMin) }}@if($priceMin != $priceMax)<span class="text-slate-300 font-normal"> – </span>{{ currency($priceMax) }}@endif
                        </p>
                        <div class="flex items-center gap-1">
                            <div class="flex text-amber-400 text-[11px] gap-px">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $product->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-slate-300 text-[11px] font-medium">({{ $product->review_count ?? 0 }})</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Car Rental --}}
@if($carRentalProducts->count() > 0)
<section class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Armada</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('ui.car_rental_title') }}</h2>
                <p class="text-slate-400 text-sm mt-1.5">{{ __('ui.car_rental_sub') }}</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="flex items-center gap-1 mr-3">
                    <button type="button" class="scroll-prev w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200 opacity-30 pointer-events-none">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button type="button" class="scroll-next w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <a href="{{ route('car-rental') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 group">
                    {{ __('ui.view_all_cars') }}
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
                </a>
            </div>
        </div>
        <div class="horizontal-scroll-container -mx-5 px-5 flex overflow-x-auto gap-5 pb-8 snap-x no-scrollbar">
            @foreach($carRentalProducts as $product)
            <a href="{{ route('car.detail', $product->slug) }}" class="w-[280px] sm:w-[300px] flex-shrink-0 bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 group snap-start block cursor-pointer">
                <div class="relative h-48 overflow-hidden bg-slate-50">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 text-[15px] mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                        {{ $product->name }}
                    </h3>
                    <p class="text-blue-600 font-extrabold text-base">
                        {{ currency($product->price_per_day) }}
                        <span class="text-slate-400 font-normal text-xs">/hari</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Rental Package --}}
@if($rentalPackageProducts->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Rental</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('ui.rental_pkg_title') }}</h2>
                <p class="text-slate-400 text-sm mt-1.5">{{ __('ui.rental_pkg_sub') }}</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="flex items-center gap-1 mr-3">
                    <button type="button" class="scroll-prev w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200 opacity-30 pointer-events-none">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button type="button" class="scroll-next w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-300 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <a href="{{ route('rental-package') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 group">
                    {{ __('ui.view_all_rental') }}
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
                </a>
            </div>
        </div>
        <div class="horizontal-scroll-container -mx-5 px-5 flex overflow-x-auto gap-5 pb-8 snap-x no-scrollbar">
            @foreach($rentalPackageProducts as $product)
            <a href="{{ route('rental-package.show', $product->slug) }}" class="w-[280px] sm:w-[300px] flex-shrink-0 bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 group snap-start block cursor-pointer">
                <div class="relative h-48 overflow-hidden bg-slate-50">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 text-[15px] mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                        {{ $product->name }}
                    </h3>
                    <p class="text-blue-600 font-extrabold text-base">
                        {{ currency($product->price_per_day) }}
                        <span class="text-slate-400 font-normal text-xs">/hari</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Gallery --}}
@if($galleryProducts->count() > 0)
<section class="py-20 bg-slate-50/70">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Galeri</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('ui.gallery_title') }}</h2>
                <p class="text-slate-400 text-sm mt-1.5">{{ __('ui.gallery_sub') }}</p>
            </div>
            <a href="{{ route('gallery') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 shrink-0 group">
                {{ __('ui.nav_gallery') }}
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($galleryProducts as $product)
            <div class="rounded-2xl overflow-hidden group aspect-square cursor-zoom-in relative" onclick="openLightbox('{{ $product->image_url }}', '{{ $product->name }}')">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-500 flex items-center justify-center">
                    <div class="w-12 h-12 bg-white/90 rounded-2xl flex items-center justify-center text-slate-700 opacity-0 group-hover:opacity-100 scale-50 group-hover:scale-100 transition-all duration-500">
                        <i class="fas fa-expand text-sm"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Blog --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Blog</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('ui.latest_blog') }}</h2>
                <p class="text-slate-400 text-sm mt-1.5">{{ __('ui.blog_sub') }}</p>
            </div>
            <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 shrink-0 group">
                {{ __('ui.view_all_blog') }}
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($latestBlogs as $blog)
            <a href="{{ route('blog.show', $blog->slug) }}" class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 group block cursor-pointer">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $blog->image_url }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">{{ $blog->formatted_date }}</span>
                        <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ $blog->read_time }}</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-[15px] line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                        {{ $blog->title }}
                    </h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Partners --}}
@if($partners->count() > 0)
<section class="py-16 bg-slate-50/50 border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <p class="text-[11px] font-bold text-slate-300 uppercase tracking-[0.2em] text-center mb-10">{{ __('ui.partners') }}</p>
        <div class="flex items-center justify-center flex-wrap gap-10 md:gap-14">
            @foreach($partners as $partner)
            <div class="group">
                @if($partner->website)
                <a href="{{ $partner->website }}" target="_blank">
                @endif
                    <img src="{{ $partner->logo_url }}"
                         alt="{{ $partner->name }}"
                         class="h-10 md:h-12 w-auto object-contain grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                @if($partner->website)
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Testimonials --}}
@if($testimonials->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <div class="flex items-center gap-2 justify-center mb-3">
                <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Testimoni</span>
                <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">{{ __('ui.what_they_say') }}</h2>
            <p class="text-slate-400 text-sm max-w-xl mx-auto">{{ __('ui.testimonials') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:shadow-xl hover:shadow-blue-900/[0.04] hover:-translate-y-0.5 transition-all duration-500 relative">
                <div class="absolute top-5 right-6 text-blue-100 text-4xl leading-none font-serif pointer-events-none">”</div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm shadow-blue-500/20">
                        {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $testimonial->customer_name }}</h4>
                        <div class="flex text-amber-400 text-[11px] mt-0.5 gap-px">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $testimonial->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">“{{ $testimonial->comment }}”</p>
                @if($testimonial->product)
                <div class="mt-5 pt-4 border-t border-slate-50">
                    <a href="{{ route('products.show', ['category' => $testimonial->product->category->slug, 'product' => $testimonial->product->slug]) }}"
                       class="text-xs text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1 group">
                        <i class="fas fa-route text-[10px] text-blue-400"></i>
                        {{ $testimonial->product->name }}
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Hotels --}}
@if(isset($featuredHotels) && $featuredHotels->isNotEmpty())
<section class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Hotel</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('ui.recommended_hotels') }}</h2>
                <p class="text-slate-400 text-sm mt-1.5">{{ __('ui.hotels_sub') }}</p>
            </div>
            <a href="{{ route('hotels') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 shrink-0 group">
                {{ __('ui.view_all_hotels') }}
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($featuredHotels as $hotel)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 group">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $hotel->image_url }}"
                         alt="{{ $hotel->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    @if($hotel->rating)
                    <div class="absolute top-3 left-3 bg-amber-400 text-amber-900 text-[11px] font-bold px-2.5 py-1 rounded-xl flex items-center gap-1 shadow-sm">
                        <i class="fas fa-star text-[10px]"></i>
                        {{ number_format($hotel->rating, 1) }}
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 text-[15px] mb-1.5 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $hotel->name }}</h3>
                    @if($hotel->city || $hotel->address)
                    <p class="text-xs text-slate-400 flex items-center gap-1.5">
                        <i class="fas fa-map-marker-alt text-blue-400 text-[10px]"></i>
                        {{ $hotel->city ?? $hotel->address }}
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Instagram --}}
@if($instagramFeeds->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 mb-3">
                <div class="w-8 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"></div>
                <span class="text-xs font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent uppercase tracking-widest">Instagram</span>
                <div class="w-8 h-0.5 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">@northsumateratrip</h2>
            <p class="text-slate-400 text-sm mt-1.5">Follow us on Instagram</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($instagramFeeds as $feed)
            <div class="aspect-square rounded-2xl overflow-hidden group">
                <a href="{{ $feed->permalink }}" target="_blank" class="block w-full h-full relative">
                    <img src="{{ $feed->resolved_image_url }}" alt="{{ $feed->caption }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                        <div class="w-12 h-12 bg-white/90 rounded-2xl flex items-center justify-center scale-50 group-hover:scale-100 transition-all duration-500">
                            <i class="fab fa-instagram text-lg bg-gradient-to-br from-purple-600 to-pink-500 bg-clip-text text-transparent"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="https://instagram.com/{{ $settings['instagram_username'] ?? 'northsumateratrip' }}" target="_blank"
               class="inline-flex items-center gap-2.5 px-7 py-3.5 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold text-sm rounded-2xl hover:shadow-xl hover:shadow-purple-500/20 hover:scale-[1.03] transition-all duration-300">
                <i class="fab fa-instagram text-lg"></i>
                Follow @northsumateratrip
            </a>
        </div>
    </div>
</section>
@endif

{{-- Features strip --}}
<section class="py-16 bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-white/5 rounded-full blur-2xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-6 text-center">
            @foreach([
                ['icon' => 'fa-car',      'title' => __('ui.feature_fleet'),   'desc' => __('ui.feature_fleet_desc')],
                ['icon' => 'fa-user-tie', 'title' => __('ui.feature_driver'),  'desc' => __('ui.feature_driver_desc')],
                ['icon' => 'fa-tags',     'title' => __('ui.feature_price'),   'desc' => __('ui.feature_price_desc')],
                ['icon' => 'fa-headset',  'title' => __('ui.feature_support'), 'desc' => __('ui.feature_support_desc')],
            ] as $feature)
            <div class="text-white group">
                <div class="w-14 h-14 bg-white/10 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/20 group-hover:scale-110 transition-all duration-500">
                    <i class="fas {{ $feature['icon'] }} text-lg"></i>
                </div>
                <h3 class="font-bold text-sm mb-1.5">{{ $feature['title'] }}</h3>
                <p class="text-blue-200/80 text-xs leading-relaxed max-w-[180px] mx-auto">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Custom Trip CTA Banner --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <a href="{{ route('custom-request.create') }}"
           class="group flex flex-col md:flex-row items-center justify-between gap-8 bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 rounded-3xl px-8 md:px-12 py-10 shadow-2xl shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
            </div>
            <div class="relative text-center md:text-left">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/15 text-white/80 rounded-full text-xs font-bold uppercase tracking-widest mb-3 border border-white/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-white/80 animate-pulse"></span>
                    {{ __('ui.custom_trip_badge') }}
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight mb-2">{{ __('ui.custom_trip') }}</h2>
                <p class="text-blue-100 text-sm max-w-lg">{{ __('ui.custom_trip_sub') }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-5">
                    @foreach([__('ui.why_flexible'), __('ui.why_budget'), __('ui.why_personal')] as $tag)
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/10 border border-white/20 rounded-xl text-white text-xs font-semibold">
                        <i class="fas fa-check text-xs"></i>{{ $tag }}
                    </span>
                    @endforeach
                </div>
            </div>
            <div class="relative flex-shrink-0">
                <span class="flex items-center gap-3 px-8 py-4 bg-white text-blue-600 rounded-2xl font-bold text-sm group-hover:bg-blue-50 transition-colors shadow-xl">
                    <i class="fas fa-magic"></i>
                    {{ __('ui.custom_trip_badge') }}
                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </span>
            </div>
        </a>
    </div>
</section>

{{-- FAQ Section --}}
<section class="py-20 bg-white">
    <div class="max-w-3xl mx-auto px-6 overflow-hidden">
        <div class="text-center mb-14">
            <div class="flex items-center gap-2 justify-center mb-3">
                <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">FAQ</span>
                <div class="w-8 h-0.5 bg-blue-600 rounded-full"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">{{ __('ui.faq_title') }}</h2>
            <p class="text-slate-400 text-sm">{{ __('ui.faq_sub') }}</p>
        </div>
        
        <div class="space-y-3" x-data="{ active: null }">
            @foreach([
                ['q' => __('ui.faq_1_q'), 'a' => __('ui.faq_1_a')],
                ['q' => __('ui.faq_2_q'), 'a' => __('ui.faq_2_a')],
                ['q' => __('ui.faq_3_q'), 'a' => __('ui.faq_3_a')],
                ['q' => __('ui.faq_4_q'), 'a' => __('ui.faq_4_a')],
                ['q' => __('ui.faq_5_q'), 'a' => __('ui.faq_5_a')],
            ] as $index => $faq)
            <div class="border border-slate-100 rounded-2xl overflow-hidden transition-all duration-500" :class="active === {{ $index }} ? 'shadow-lg shadow-blue-900/[0.04] border-blue-100' : 'hover:border-slate-200'">
                <button @click="active = (active === {{ $index }} ? null : {{ $index }})" 
                        class="w-full flex items-center justify-between p-5 md:p-6 text-left transition-colors duration-300" :class="active === {{ $index }} ? 'bg-blue-50/50' : 'bg-white hover:bg-slate-50/50'">
                    <span class="font-bold text-sm pr-4 transition-colors duration-300" :class="active === {{ $index }} ? 'text-blue-700' : 'text-slate-900'">{{ $faq['q'] }}</span>
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300" :class="active === {{ $index }} ? 'bg-blue-100 text-blue-600 rotate-180' : 'bg-slate-100 text-slate-400'">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </button>
                <div x-show="active === {{ $index }}" 
                     x-collapse 
                     class="px-5 md:px-6 pb-5 md:pb-6 text-sm text-slate-500 bg-white leading-relaxed"
                     style="display: none;">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-blue-600/10 rounded-full -translate-y-1/2 blur-[100px]"></div>
        <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-blue-500/10 rounded-full translate-y-1/2 blur-[80px]"></div>
    </div>
    <div class="max-w-2xl mx-auto px-5 sm:px-6 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/5 border border-white/10 rounded-full mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="text-[11px] font-bold text-white/60 uppercase tracking-widest">Siap Berangkat</span>
        </div>
        <h2 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight mb-4">
            {{ \App\Models\Setting::get('cta_title', 'Siap Memulai Petualangan?') }}
        </h2>
        <p class="text-slate-400 text-sm mb-10 leading-relaxed max-w-lg mx-auto">
            {{ \App\Models\Setting::get('cta_subtitle', 'Hubungi kami sekarang untuk konsultasi perjalanan gratis.') }}
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-3">
            <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '6281298622143')) }}"
               target="_blank"
               class="inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-2xl transition-all duration-300 hover:scale-[1.03] shadow-xl shadow-emerald-900/30">
                <i class="fab fa-whatsapp text-lg"></i>
                {{ \App\Models\Setting::get('cta_button_text', 'Hubungi Kami') }}
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 border border-slate-700 text-white hover:bg-white/5 hover:border-slate-600 font-bold text-sm rounded-2xl transition-all duration-300">
                <i class="fas fa-envelope text-sm"></i>
                {{ __('ui.nav_contact') }}
            </a>
        </div>
    </div>
</section>

@endsection
