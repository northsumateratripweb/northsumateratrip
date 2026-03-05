@extends('layouts.main')

@section('title', 'Rental Package - NorthSumateraTrip')

@section('content')
<div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-3xl mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Rental Packages</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
            Paket <span class="text-blue-600">Rental</span>
        </h1>
        <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
            Pilihan paket rental mobil terbaik untuk berbagai kebutuhan perjalanan Anda di Sumatera Utara.
        </p>
    </div>

    @if($packages->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($packages as $package)
        <a href="{{ route('rental-package.show', $package->slug) }}" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 block cursor-pointer">
            <div class="relative h-52 overflow-hidden">
                <img src="{{ $package->image_url }}"
                     alt="{{ $package->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
            <div class="flex-1 flex flex-col p-5">
                <h3 class="font-bold text-slate-900 dark:text-white text-base mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                    {{ $package->name }}
                </h3>
                
                @if($package->min_rental_days)
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-medium text-slate-400 border border-slate-100 dark:border-slate-700">
                        Min {{ $package->min_rental_days }} Hari
                    </span>
                </div>
                @endif
                
                <!-- Bottom -->
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Mulai dari</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">{{ currency($package->price_per_day) }}<span class="text-xs text-slate-400 font-medium ml-1">/hari</span></p>
                    </div>
                    <span class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-16">
        {{ $packages->links() }}
    </div>
    @else
    <div class="text-center py-24 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i class="fas fa-suitcase-rolling text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-700 dark:text-white mb-2">Belum ada paket</h3>
        <p class="text-slate-400 text-sm">Silakan kembali lagi nanti atau hubungi kami via WhatsApp.</p>
    </div>
    @endif
</div>
@endsection
