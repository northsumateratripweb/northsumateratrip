@extends('layouts.main')

@section('title', ($blog->meta_title ?? $blog->translate('title')) . ' - NorthSumateraTrip')
@section('meta_description', $blog->meta_description ?? $blog->translate('excerpt'))
@section('og_image', $blog->image_url)
@section('canonical', route('blog.show', $blog->slug))

@push('schema')
    {{-- Article Schema --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ $blog->translate('title') }}",
      "image": "{{ $blog->image_url }}",
      "author": {
        "@type": "Organization",
        "name": "NorthSumateraTrip"
      },
      "publisher": {
        "@type": "Organization",
        "name": "NorthSumateraTrip",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('storage/' . ($settings['site_logo'] ?? '')) }}"
        }
      },
      "datePublished": "{{ $blog->created_at->toIso8601String() }}",
      "dateModified": "{{ $blog->updated_at->toIso8601String() }}"
    }
    </script>
@endpush

@push('styles')
    <style>
        .blog-content h2 { font-family: 'Outfit', system-ui, sans-serif; font-size: 1.5rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; margin-top: 2.5rem; margin-bottom: 1rem; line-height: 1.3; }
        .blog-content h3 { font-family: 'Outfit', system-ui, sans-serif; font-size: 1.25rem; font-weight: 600; color: #0f172a; letter-spacing: -0.01em; margin-top: 2rem; margin-bottom: 0.75rem; line-height: 1.3; }
        .blog-content p { font-family: 'Inter', system-ui, sans-serif; color: #475569; font-size: 1.0625rem; line-height: 1.8; margin-bottom: 1.5rem; font-weight: 400; }
        .blog-content ul { list-style-type: disc; list-style-position: outside; padding-left: 1.5rem; margin-bottom: 1.5rem; color: #475569; font-weight: 400; }
        .blog-content ul li { margin-bottom: 0.5rem; line-height: 1.7; }
        .blog-content ol { list-style-type: decimal; list-style-position: outside; padding-left: 1.5rem; margin-bottom: 1.5rem; color: #475569; font-weight: 400; }
        .blog-content ol li { margin-bottom: 0.5rem; line-height: 1.7; }
        .blog-content blockquote { border-left: 3px solid #3b82f6; padding: 1rem 1.25rem; margin: 2rem 0; font-style: italic; font-size: 1.125rem; color: #64748b; font-weight: 400; background-color: #f8fafc; border-radius: 0 0.75rem 0.75rem 0; }
        .blog-content img { border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,.08); margin: 2rem 0; width: 100%; object-fit: cover; }
        @media (min-width: 768px) {
            .blog-content h2 { font-size: 1.75rem; }
            .blog-content h3 { font-size: 1.375rem; }
        }
        @media (prefers-color-scheme: dark) {
            .blog-content h2, .blog-content h3 { color: #f1f5f9; }
            .blog-content p, .blog-content ul, .blog-content ol { color: #94a3b8; }
            .blog-content blockquote { color: #94a3b8; background-color: #0f172a; }
        }
    </style>
@endpush

@section('content')
<!-- Article Title & Hero -->
<section class="relative pt-36 pb-20 overflow-hidden bg-white dark:bg-slate-950">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- Breadcrumb & Category -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('blog.index') }}" class="text-xs font-bold text-blue-600 uppercase tracking-wider bg-blue-50 dark:bg-blue-900/30 px-3 py-1.5 rounded-lg border border-blue-100 dark:border-blue-800 transition-all hover:bg-blue-100">
                Guided Trips
            </a>
            <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $blog->read_time }}</span>
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight mb-6">
            {{ $blog->translate('title') }}
        </h1>

        <div class="flex flex-wrap items-center justify-between gap-6 pt-8 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-4 text-xs font-bold text-slate-500 uppercase tracking-widest">
                <i class="far fa-calendar-alt text-blue-600"></i>
                {{ $blog->formatted_date }}
            </div>
            
            <!-- Social Share Minimal -->
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-2">Share this:</span>
                <a href="{{ $blog->share_url['facebook'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center bg-slate-50 dark:bg-slate-900 text-slate-400 hover:text-blue-600 border border-slate-100 dark:border-slate-800 rounded-xl transition-all hover:scale-110 active:scale-90">
                    <i class="fab fa-facebook-f text-sm"></i>
                </a>
                <a href="{{ $blog->share_url['twitter'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center bg-slate-50 dark:bg-slate-900 text-slate-400 hover:text-sky-500 border border-slate-100 dark:border-slate-800 rounded-xl transition-all hover:scale-110 active:scale-90">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="{{ $blog->share_url['whatsapp'] }}" target="_blank" class="w-9 h-9 flex items-center justify-center bg-slate-50 dark:bg-slate-900 text-slate-400 hover:text-green-500 border border-slate-100 dark:border-slate-800 rounded-xl transition-all hover:scale-110 active:scale-90">
                    <i class="fab fa-whatsapp text-sm"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@php $allImages = $blog->all_image_urls; @endphp
<!-- Featured Image Full Width -->
<section class="max-w-7xl mx-auto px-6 mb-20">
    <div class="aspect-[21/9] rounded-2xl overflow-hidden shadow-xl shadow-blue-900/[0.06] border border-slate-100 dark:border-slate-800 cursor-zoom-in" onclick="openLightbox('{{ $allImages[0] ?? $blog->image_url }}', '{{ $blog->translate('title') }}')">
        <img src="{{ $allImages[0] ?? $blog->image_url }}" alt="{{ $blog->translate('title') }}" class="w-full h-full object-cover">
    </div>
</section>

<!-- Article Content -->
<section class="bg-white dark:bg-slate-950 pb-24">
    <div class="max-w-4xl mx-auto px-6">
        <div class="blog-content prose prose-lg prose-slate dark:prose-invert max-w-none">
            {!! $blog->translate('content') !!}
        </div>

        <!-- Gallery Section -->
        @if(count($allImages) > 1)
        <div class="mt-20 pt-20 border-t border-slate-100 dark:border-slate-800">
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-8">Visual Moments</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @foreach(array_slice($allImages, 1) as $galleryImageUrl)
                <div class="aspect-video rounded-2xl overflow-hidden border border-slate-100 hover:shadow-lg hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-500 cursor-zoom-in" onclick="openLightbox('{{ $galleryImageUrl }}', '{{ $blog->translate('title') }}')">
                    <img src="{{ $galleryImageUrl }}" alt="{{ $blog->translate('title') }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Author / Footer Meta -->
        <div class="mt-20 p-8 md:p-10 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl flex-shrink-0">
                <i class="fas fa-route"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2 block">Written by Travel Experts</span>
                <h4 class="text-lg font-extrabold text-slate-900 dark:text-white leading-tight mb-2">NorthSumateraTrip Editorial</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium leading-relaxed">
                    Kami berdedikasi untuk memberikan informasi termudah, terpercaya, dan paling inspiratif untuk setiap perjalanan Anda di Sumatera Utara.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles Bottom -->
@if($relatedBlogs->count() > 0)
<section class="py-24 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-end justify-between mb-12">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-0.5 bg-blue-600"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Keep Exploring</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">Artikel Menarik Lainnya</h2>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedBlogs as $related)
            <div class="group flex flex-col h-full">
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-5 border border-slate-100 group-hover:shadow-lg group-hover:shadow-blue-900/[0.06] transition-all duration-500">
                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                    <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                </h3>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $related->read_time }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Bottom CTA Banner -->
<section class="py-24 bg-white dark:bg-slate-950 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="relative bg-slate-900 rounded-2xl p-12 md:p-16 overflow-hidden shadow-xl flex flex-col items-center text-center">
            <div class="absolute inset-0 opacity-10 blur-3xl">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full"></div>
            </div>
            
            <div class="relative z-10 max-w-2xl">
                <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-6 leading-tight">Wujudkan Perjalanan Impian Anda</h2>
                <p class="text-base text-slate-400 font-medium mb-10">
                    Siap untuk mengeksplorasi destinasi yang Anda baca? Konsultasikan rencana perjalanan Anda gratis 24/7 dengan admin kami.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '6281298622143')) }}" 
                       target="_blank"
                       class="w-full sm:w-auto px-8 py-4 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-green-500/20 flex items-center justify-center gap-3">
                        <i class="fab fa-whatsapp text-xl"></i>
                        Chat Admin via WhatsApp
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all border border-white/10 flex items-center justify-center gap-3">
                        Lihat Paket Lainnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
