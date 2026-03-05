@extends('layouts.main')

@section('title', 'Wishlist Saya - NorthSumateraTrip')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 mb-6">
                <div class="w-8 h-0.5 bg-blue-600"></div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">My Collections</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight mb-6">
                Wishlist <span class="text-blue-600">Saya</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                Simpan paket wisata impian Anda dan pesan kapan saja.
            </p>
        </div>

        @if($wishlists->isEmpty())
            <div class="py-32 text-center bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 relative overflow-hidden group">
                <div class="w-20 h-20 bg-blue-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-8 text-blue-600 dark:text-blue-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-4">Wishlist Kosong</h2>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-10 max-w-md mx-auto">Anda belum menyimpan paket wisata atau sewa mobil apapun.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('packages') }}" class="px-8 py-4 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-blue-500/20 active:scale-95 transition-all">
                        Lihat Paket Wisata
                    </a>
                    <a href="{{ route('car-rental') }}" class="px-8 py-4 bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-100 dark:border-slate-700 rounded-xl text-xs font-bold uppercase tracking-wider hover:border-blue-600 transition-all">
                        Sewa Mobil
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @foreach($wishlists as $wishlist)
                    @if($wishlist->product)
                        @php $product = $wishlist->product; @endphp
                        <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-lg hover:shadow-blue-900/[0.06] p-4">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-2xl mb-6">
                                <img src="{{ $product->image_url }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
                                
                                <!-- Category -->
                                <div class="absolute top-5 left-5 px-4 py-1.5 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-xl shadow-lg border border-white/20 dark:border-slate-800">
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                        {{ $product->category->name ?? 'Wisata' }}
                                    </span>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-6 right-6 z-10">
                                    @csrf
                                    <button type="submit" class="w-12 h-12 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-rose-500 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-xl border border-white/20 dark:border-slate-800 transform active:scale-90 group/heart">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="flex-1 flex flex-col px-6 pb-6 text-center md:text-left">
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Paket Wisata</p>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white leading-tight mb-6 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="mt-auto flex items-center justify-between pt-6 border-t border-slate-50 dark:border-slate-800/50">
                                    <div>
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Mulai Dari</p>
                                        <p class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $product->formatted_price }}</p>
                                    </div>
                                    <a href="{{ route('products.show', [$product->category->slug ?? 'trip', $product->slug]) }}" class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif($wishlist->vehicle)
                        @php $vehicle = $wishlist->vehicle; @endphp
                        <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-lg hover:shadow-blue-900/[0.06] p-4">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-2xl mb-6">
                                <img src="{{ $vehicle->image_url }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
                                
                                <!-- Brand -->
                                <div class="absolute top-5 left-5 px-4 py-1.5 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-xl shadow-lg border border-white/20 dark:border-slate-800">
                                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">{{ $vehicle->brand }}</span>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.toggle-vehicle', $vehicle->id) }}" method="POST" class="absolute top-6 right-6 z-10">
                                    @csrf
                                    <button type="submit" class="w-12 h-12 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-rose-500 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-xl border border-white/20 dark:border-slate-800 transform active:scale-90 group/heart">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="flex-1 flex flex-col px-6 pb-6 text-center md:text-left">
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Sewa Mobil</p>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white leading-tight mb-6 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                    {{ $vehicle->name }}
                                </h3>
                                
                                <div class="mt-auto flex items-center justify-between pt-6 border-t border-slate-100 dark:border-slate-800/50">
                                    <div>
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Mulai Dari</p>
                                        <p class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ currency($vehicle->price_per_day) }} <span class="text-xs text-slate-400">/ {{ __('ui.days') }}</span></p>
                                    </div>
                                    <a href="{{ route('car.detail', $vehicle->slug) }}" class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
