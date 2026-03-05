@extends('layouts.main')

@section('title', 'Paket Trip Sumatera - NorthSumateraTrip')

@section('content')
<div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-3xl mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Explore Packages</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
            Paket Trip <span class="text-blue-600">Sumatera</span>
        </h1>
        <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
            Petualangan seru menanti Anda di setiap sudut Sumatera Utara. Pilih paket yang sesuai dengan keinginan Anda.
        </p>
    </div>

    <!-- Category Filter -->
    <div class="flex flex-wrap gap-3 mb-14">
        <a href="{{ route('products.index') }}" 
           class="px-6 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-300 border {{ !$category ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-white text-slate-500 border-slate-100 hover:border-blue-200 hover:text-blue-600' }}">
            Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('products.category', $cat->slug) }}" 
           class="px-6 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-300 border {{ $category && $category->id == $cat->id ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-white text-slate-500 border-slate-100 hover:border-blue-200 hover:text-blue-600' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
    
    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($products as $product)
        <a href="{{ route('products.show', ['category' => $product->category->slug, 'product' => $product->slug]) }}" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 block cursor-pointer">
            <!-- Image -->
            <div class="relative h-52 overflow-hidden">
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                @if($product->duration)
                <div class="absolute top-4 left-4">
                    <span class="px-3.5 py-1.5 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 border border-white/20 shadow-sm flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $product->duration }}
                    </span>
                </div>
                @endif
                
                @if($product->pre_order_info)
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1.5 bg-orange-500 text-white text-xs font-bold rounded-xl shadow-sm">
                        {{ $product->pre_order_info }}
                    </span>
                </div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="flex-1 flex flex-col p-5">
                <h3 class="font-bold text-slate-900 dark:text-white text-base mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                    {{ $product->name }}
                </h3>
                
                <!-- Rating -->
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $product->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star text-slate-200"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-slate-400 text-xs font-medium">({{ $product->review_count }})</span>
                </div>
                
                <!-- Bottom -->
                <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Mulai dari</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $product->formatted_price }}</p>
                    </div>
                    <span class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-16">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-center py-24 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i class="fas fa-search text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-700 mb-2">Tidak ada produk ditemukan</h3>
        <p class="text-slate-400 text-sm">Silakan pilih kategori lain atau hubungi kami untuk informasi lebih lanjut.</p>
    </div>
    @endif
</div>
@endsection
