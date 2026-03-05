@extends('layouts.main')

@section('title', __('ui.hotels_title') . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))
@section('meta_description', __('ui.hotels_desc'))

@section('content')
<div class="pt-32 md:pt-40 pb-20 max-w-7xl mx-auto px-6 lg:px-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-xl text-xs font-semibold uppercase tracking-widest mb-5 border border-blue-100 dark:border-blue-800">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                {{ __('ui.hotels_badge') }}
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight mb-4">
                {{ __('ui.hotels_title') }}
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed max-w-xl">
                {{ __('ui.hotels_desc') }}
            </p>
        </div>

        <div class="flex-shrink-0">
            <div class="px-6 py-4 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">{{ __('ui.total_hotels') }}</p>
                <p class="text-2xl font-bold text-blue-600 leading-none">
                    {{ $hotels->total() }}
                    <span class="text-xs text-slate-400 font-medium ml-1">{{ __('ui.properties') }}</span>
                </p>
            </div>
        </div>
    </div>

    @if($hotels->isEmpty())
        <div class="py-32 text-center bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
            <i class="fas fa-building text-4xl text-slate-300 mb-4 block"></i>
            <p class="text-slate-400 font-medium">{{ __('ui.no_hotels') }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($hotels as $hotel)
            <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:shadow-xl hover:shadow-slate-900/5 transition-all duration-500 overflow-hidden">

                <!-- Image -->
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    @if($hotel->rating)
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-yellow-400 rounded-xl text-xs font-bold text-yellow-900 flex items-center gap-1">
                            <i class="fas fa-star text-xs"></i>
                            {{ number_format($hotel->rating, 1) }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="flex-1 flex flex-col p-6">
                    @if($hotel->city)
                    <div class="flex items-center gap-1.5 mb-3">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xs"></i>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ $hotel->city }}</span>
                    </div>
                    @endif

                    <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $hotel->name }}
                    </h3>

                    @if($hotel->address)
                    <p class="text-sm text-slate-400 line-clamp-1 mb-3">{{ $hotel->address }}</p>
                    @endif

                    @if($hotel->description)
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2 mb-4 flex-1">
                        {{ strip_tags($hotel->description) }}
                    </p>
                    @endif

                    <!-- Footer -->
                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                        <div>
                            @if($hotel->phone)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $hotel->phone) }}" target="_blank"
                               class="flex items-center gap-1.5 text-xs font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                                {{ $hotel->phone }}
                            </a>
                            @endif
                        </div>
                        @if($hotel->phone || $hotel->address)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '628123456789')) }}?text={{ urlencode('Halo, saya ingin info hotel ' . $hotel->name) }}"
                           target="_blank"
                           class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all duration-300"
                           title="{{ __('ui.contact_hotel') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $hotels->links() }}
        </div>
    @endif
</div>
@endsection
