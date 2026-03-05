@extends('layouts.main')

@section('title', 'Gallery - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))

@section('content')
<div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-3xl mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Photo Gallery</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
            Gallery
        </h1>
        <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
            Kumpulan foto dari paket dan aktivitas trip kami
        </p>
    </div>

    @php
        $items = $galleries ?? collect();
    @endphp
    @if($items->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-5">
        @foreach($items as $gallery)
        <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 cursor-zoom-in transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-0.5" onclick="openLightbox('{{ $gallery->resolved_image_url }}', '{{ $gallery->title }}')">
            <div class="aspect-[4/3] overflow-hidden">
                <img src="{{ $gallery->resolved_image_url }}" 
                     alt="{{ $gallery->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
            </div>
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-4">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
                <h3 class="text-sm font-bold text-white line-clamp-1">{{ $gallery->title }}</h3>
                @if($gallery->caption)
                <p class="text-xs text-white/70 mt-0.5">{{ $gallery->caption }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $items->appends(request()->query())->links() }}
    </div>
    @else
    <div class="text-center py-24 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i class="fas fa-image text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-700 mb-2">Belum ada gambar</h3>
        <p class="text-slate-400 text-sm">Silakan kembali lagi nanti.</p>
    </div>
    @endif
</div>
@endsection
