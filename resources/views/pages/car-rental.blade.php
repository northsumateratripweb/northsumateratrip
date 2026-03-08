@extends('layouts.main')

@section('title', 'Sewa Mobil Sumatera - NorthSumateraTrip')
@section('meta_description', 'Sewa mobil murah di Sumatera dengan supir profesional. Pilihan armada lengkap mulai dari Avanza, Innova, hingga Hiace.')

@section('content')
    <div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-16">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-0.5 bg-blue-600"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">{{ __('ui.hero_badge') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
                    {{ __('ui.nav_car_rental') }} <span class="text-blue-600">Sumatera</span>
                </h1>
                <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
                    {{ $category?->description ?? __('ui.car_fleet_sub') }}
                </p>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <div class="px-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl">
                    <p class="text-xs text-slate-400 font-medium mb-0.5">{{ __('ui.starting_from') }}</p>
                    <p class="text-lg font-extrabold text-blue-600 leading-none">{{ currency(450000) }}<span class="text-xs text-slate-400 font-medium ml-1">{{ __('ui.per_day') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="mb-14 p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-lg shadow-slate-900/[0.03]">
            <form action="{{ route('car-rental') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">{{ __('ui.capacity') }}</label>
                    <select name="capacity" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="">{{ __('ui.all_categories') }}</option>
                        <option value="4" {{ request('capacity') == '4' ? 'selected' : '' }}>4 {{ __('ui.person') }}</option>
                        <option value="6" {{ request('capacity') == '6' ? 'selected' : '' }}>6-7 {{ __('ui.person') }}</option>
                        <option value="12+" {{ request('capacity') == '12+' ? 'selected' : '' }}>12+ {{ __('ui.person') }} (Hiace/Elf)</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">{{ __('ui.transmission') }}</label>
                    <select name="transmission" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="">{{ __('ui.all_categories') }}</option>
                        <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                        <option value="matic" {{ request('transmission') == 'matic' ? 'selected' : '' }}>Automatic</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Brand</label>
                    <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Contoh: Toyota, Honda..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                        Filter
                    </button>
                    @if(request()->anyFilled(['capacity', 'transmission', 'brand']))
                    <a href="{{ route('car-rental') }}" class="px-5 py-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-all">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        @if($carRentals->isEmpty())
            <div class="relative overflow-hidden rounded-[2.5rem] border-2 border-dashed border-slate-200 dark:border-slate-800 p-12 md:p-24 text-center bg-white dark:bg-slate-900 shadow-sm mt-10">
                {{-- Decorative element --}}
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-blue-50/50 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-slate-800 to-slate-900 dark:from-blue-600 dark:to-indigo-700 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-slate-500/10 -rotate-3">
                        <i class="fas fa-car-side text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-3">Tidak ada unit tersedia</h3>
                    <p class="text-slate-400 font-medium max-w-sm mx-auto mb-10">Semua armada kami saat ini sedang dalam perjalanan atau sedang diproses. Silakan ubah filter pencarian Anda atau hubungi kami langsung.</p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('car-rental') }}" class="w-full sm:w-auto px-8 py-3.5 bg-blue-600 text-white rounded-full text-xs font-black uppercase tracking-widest transition-all hover:scale-105 hover:bg-blue-700 shadow-lg shadow-blue-500/25">
                            Lihat Semua Armada
                        </a>
                        <a href="{{ route('contact') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 rounded-full text-xs font-black uppercase tracking-widest transition-all hover:bg-slate-50">
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($carRentals as $carRental)
                    <a href="{{ route('car.detail', $carRental->slug) }}" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 overflow-hidden block cursor-pointer">
                        <!-- Image Container -->
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $carRental->image_url }}" alt="{{ $carRental->name }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="px-3.5 py-1.5 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 border border-white/20 dark:border-slate-800 shadow-sm">
                                    {{ $carRental->brand }}
                                </span>
                            </div>


                        </div>

                        <!-- Content -->
                        <div class="flex-1 flex flex-col p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-medium text-slate-400 border border-slate-100 dark:border-slate-700">
                                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $carRental->capacity }} Kursi
                                </span>
                                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-medium text-slate-400 border border-slate-100 dark:border-slate-700 capitalize">
                                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                    {{ $carRental->transmission ?? 'Manual' }}
                                </span>
                            </div>

                            <h3 class="font-bold text-slate-900 dark:text-white text-base leading-snug mb-3 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                {{ $carRental->name }}
                            </h3>
                            
                            <!-- Bottom Info -->
                            <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                                <div>
                                    <p class="text-xs text-slate-400 font-medium mb-0.5">{{ __('ui.starting_from') }}</p>
                                    <p class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">{{ currency($carRental->price_per_day) }}<span class="text-xs text-slate-400 font-medium ml-1">{{ __('ui.per_day') }}</span></p>
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
                {{ $carRentals->links() }}
            </div>
        @endif
    </div>
@endsection
