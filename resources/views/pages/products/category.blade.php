@extends('layouts.main')

@section('title', $category->name . ' - NorthSumateraTrip')
@section('meta_description', $category->meta_description ?? $category->description)

@section('content')
<div class="pt-32 md:pt-40 pb-20 max-w-7xl mx-auto px-6 lg:px-8">

    <!-- Header -->
    <div class="text-center mb-12 max-w-2xl mx-auto">
        <div class="inline-flex items-center gap-2 mb-5">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">{{ $category->name }}</span>
            <div class="w-8 h-0.5 bg-blue-600"></div>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight mb-4">
            {{ $category->name }}
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed max-w-xl mx-auto">
            {{ $category->description }}
        </p>
    </div>

    <!-- Category Filter -->
    <div class="mb-12">
        <div class="flex flex-wrap gap-2 justify-center">
            <a href="{{ route('products.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-blue-600 hover:text-blue-600">
                Semua
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('products.category', $cat->slug) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border {{ $category->id == $cat->id ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-blue-600 hover:text-blue-600' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
    
    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($products as $product)
        <a href="{{ route('products.show', ['category' => $product->category?->slug ?? 'uncategorized', 'product' => $product->slug]) }}" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 hover:shadow-lg hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 overflow-hidden">
            <!-- Image -->
            <div class="relative h-52 overflow-hidden">
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                @if($product->duration)
                <div class="absolute top-4 left-4 px-3 py-1.5 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-xl flex items-center gap-1.5">
                    <i class="fas fa-calendar-day text-[0.6rem]"></i>
                    {{ $product->duration }}
                </div>
                @endif
                
                @if($product->pre_order_info)
                <div class="absolute top-4 right-4 px-3 py-1.5 bg-amber-500/90 backdrop-blur-sm text-white text-xs font-bold rounded-xl">
                    {{ $product->pre_order_info }}
                </div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="flex-1 flex flex-col p-5">
                <div class="text-blue-600 font-extrabold text-lg mb-1.5">
                    {{ $product->formatted_price }}
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                    {{ $product->name }}
                </h3>
                
                <!-- Rating -->
                <div class="flex items-center mb-4 mt-auto">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $product->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star text-slate-200"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-slate-400 text-xs ml-2">({{ $product->review_count }})</span>
                </div>
                
                <!-- CTA -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider group-hover:text-blue-700 transition-colors">Lihat Detail</span>
                    <div class="w-8 h-8 bg-slate-50 dark:bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-14">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-center py-24 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
            <i class="fas fa-search text-2xl"></i>
        </div>
        <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-2">Belum ada produk</h3>
        <p class="text-slate-400 text-sm">Silakan pilih kategori lain atau hubungi kami untuk informasi lebih lanjut.</p>
    </div>
    @endif
</div>
@endsection
