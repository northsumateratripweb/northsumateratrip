@extends('layouts.main')

@section('title', 'Inside Sumatera: Travel Guide & Insights - NorthSumateraTrip')

@section('content')
<!-- Page Hero -->
<section class="relative pt-36 pb-20 overflow-hidden bg-slate-950">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-600/10 via-transparent to-slate-950"></div>
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-500/8 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-0.5 bg-blue-500"></div>
                <span class="text-xs font-bold text-blue-400 uppercase tracking-[0.2em]">Official Blog</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight tracking-tight mb-5">
                Inside Sumatera<br/>
                <span class="text-blue-400">Guide & Insights</span>
            </h1>
            <p class="text-lg text-slate-400 font-medium leading-relaxed max-w-xl">
                Temukan tips perjalanan, rekomendasi destinasi tersembunyi, dan wawasan mendalam untuk rencana petualangan Anda di Sumatera Utara.
            </p>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-24 bg-white dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-6">
        @if($blogs->count() > 0)
            @php $featured = $blogs->shift(); @endphp
            
            <!-- Featured Post -->
            <a href="{{ route('blog.show', $featured->slug) }}" class="relative group mb-20 rounded-2xl overflow-hidden bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-900/[0.04] block cursor-pointer">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="aspect-[16/10] overflow-hidden">
                        <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-5">
                            <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-bold uppercase tracking-wider">Featured</span>
                            <span class="text-xs font-medium text-slate-400">{{ $featured->read_time }}</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-5 leading-tight group-hover:text-blue-600 transition-colors">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 mb-8 line-clamp-3 text-base font-medium leading-relaxed">
                            {{ $featured->excerpt ?? strip_tags(Str::limit($featured->content, 200)) }}
                        </p>
                        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 group-hover:gap-3 transition-all">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right text-xs"></i>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Blog Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 block cursor-pointer">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <div class="flex-1 flex flex-col p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-xs font-medium text-blue-600">{{ $blog->formatted_date }}</span>
                            <div class="w-1 h-1 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            <span class="text-xs font-medium text-slate-400">{{ $blog->read_time }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mb-3 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $blog->title }}
                        </h3>
                        @if($blog->excerpt)
                        <p class="text-slate-400 mb-4 line-clamp-2 text-sm leading-relaxed">
                            {{ $blog->excerpt }}
                        </p>
                        @endif
                        <span class="mt-auto inline-flex items-center gap-2 text-xs font-bold text-slate-400 group-hover:text-blue-600 transition-all group-hover:gap-3">
                            Read Article
                            <i class="fas fa-chevron-right text-[0.5rem]"></i>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 pt-10 border-t border-slate-100 dark:border-slate-800 flex justify-center">
                {{ $blogs->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="text-center py-24">
                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Belum ada artikel</h3>
                <p class="text-slate-400 text-sm">Artikel dan panduan perjalanan akan segera hadir.</p>
            </div>
        @endif
    </div>
</section>

<!-- Newsletter / CTA -->
<section class="py-20 bg-slate-50 dark:bg-slate-900 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <div class="flex items-center gap-3 justify-center mb-5">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Follow Us</span>
            <div class="w-8 h-0.5 bg-blue-600"></div>
        </div>
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-5">Dapatkan Tips Visual Eksklusif</h2>
        <p class="text-base text-slate-400 font-medium max-w-2xl mx-auto mb-10">
            Ikuti Instagram kami untuk update terbaru mengenai destinasi wisata dan promo spesial.
        </p>
        <a href="https://instagram.com/{{ \App\Models\Setting::get('instagram_username', 'northsumateratrip') }}" 
           target="_blank"
           class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-2xl font-bold text-xs uppercase tracking-wider hover:scale-[1.03] transition-all duration-300 shadow-lg shadow-purple-500/20">
            <i class="fab fa-instagram text-lg"></i>
            Follow @northsumateratrip
        </a>
    </div>
</section>
@endsection
