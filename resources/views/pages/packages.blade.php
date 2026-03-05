@extends('layouts.main')

@section('title', 'Daftar Paket Wisata Sumatera - NorthSumateraTrip')
@section('meta_description', 'Jelajahi berbagai pilihan paket wisata Sumatera Utara terbaik. Mulai dari paket trip harian, family gathering, hingga study tour.')
@section('canonical', route('packages'))

@section('content')
    <div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header Section -->
        <div class="max-w-3xl mb-16">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-0.5 bg-blue-600"></div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Explore Experiences</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
                Paket Trip <span class="text-blue-600">Sumatera</span>
            </h1>
            <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
                Petualangan seru menanti Anda di setiap sudut Sumatera Utara. Pilih paket yang sesuai dengan keinginan Anda.
            </p>
        </div>

        <!-- Custom Trip CTA -->
        <div class="mb-14">
            <a href="{{ route('custom-request.create') }}"
               class="group flex flex-col sm:flex-row items-center justify-between gap-6 bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl px-7 py-6 shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/25 transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/15 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-magic text-white text-xl"></i>
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="text-white font-extrabold text-lg leading-tight">{{ __('ui.custom_trip') }}</p>
                        <p class="text-blue-100 text-sm mt-0.5">{{ __('ui.custom_trip_sub') }}</p>
                    </div>
                </div>
                <span class="flex items-center gap-2 px-6 py-3 bg-white text-blue-600 rounded-xl font-bold text-sm flex-shrink-0 group-hover:bg-blue-50 transition-colors">
                    {{ __('ui.custom_trip_badge') }}
                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </span>
            </a>
        </div>

        <!-- Categories Filter -->
        @if(isset($categories) && $categories->count() > 0)
            <div class="flex flex-wrap gap-3 mb-14">
                <a href="{{ route('packages') }}" class="px-6 py-2.5 {{ !request()->routeIs('products.category') ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-white dark:bg-slate-900 text-slate-500 border-slate-100 dark:border-slate-800 hover:border-blue-200 hover:text-blue-600' }} rounded-2xl text-xs font-bold uppercase tracking-wider border transition-all duration-300">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.category', $cat->slug) }}" class="px-6 py-2.5 {{ request()->is('product/category/'.$cat->slug) ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-white dark:bg-slate-900 text-slate-500 border-slate-100 dark:border-slate-800 hover:border-blue-200 hover:text-blue-600' }} rounded-2xl text-xs font-bold uppercase tracking-wider border transition-all duration-300">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($products->isEmpty())
            <div class="py-24 text-center bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fas fa-suitcase-rolling text-2xl"></i>
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">{{ __('ui.no_packages') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <a href="{{ route('products.show', [$product->category->slug, $product->slug]) }}" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 overflow-hidden block cursor-pointer">
                        <!-- Image Container -->
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="px-3.5 py-1.5 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 border border-white/20 dark:border-slate-800 shadow-sm">
                                    {{ $product->category->name }}
                                </span>
                            </div>


                        </div>

                        <!-- Content -->
                        <div class="flex-1 flex flex-col p-5">
                            <h3 class="font-bold text-slate-900 dark:text-white text-base leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="flex items-center gap-2 mb-4">
                                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-medium text-slate-400 border border-slate-100 dark:border-slate-700">
                                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $product->duration ?? '-' }}
                                </span>
                            </div>

                            <!-- Bottom Info -->
                            <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                                <div>
                                    <p class="text-xs text-slate-400 font-medium mb-0.5">{{ __('ui.starting_from') }}</p>
                                    <p class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">{{ currency($product->price_min) }}</p>
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
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
