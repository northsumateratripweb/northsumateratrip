<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings['meta_title'] ?? ($settings['site_name'] ?? 'NorthSumateraTrip'))</title>
    <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? 'Eksplorasi Sumatera Utara dengan layanan premium.')">
    @if(isset($settings['meta_keywords']))
    <meta name="keywords" content="{{ $settings['meta_keywords'] }}">
    @endif

    {{-- SEO Advance Meta --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="robots" content="index, follow">

    {{-- Hreflang for International SEO --}}
    @foreach(\App\Services\CurrencyService::all() as $lang => $data)
    <link rel="alternate" hreflang="{{ $lang }}" href="{{ url('lang/'.$lang) }}">
    @endforeach

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $settings['meta_title'] ?? ($settings['site_name'] ?? 'NorthSumateraTrip'))">
    <meta property="og:description" content="@yield('meta_description', $settings['meta_description'] ?? 'Eksplorasi Sumatera Utara dengan layanan premium.')">
    <meta property="og:image" content="@yield('og_image', '')">

    {{-- Twitter Card --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', $settings['meta_title'] ?? ($settings['site_name'] ?? 'NorthSumateraTrip'))">
    <meta property="twitter:description" content="@yield('meta_description', $settings['meta_description'] ?? 'Eksplorasi Sumatera Utara dengan layanan premium.')">
    <meta property="twitter:image" content="@yield('og_image', '')">

    <link rel="icon" type="image/x-icon" href="{{ !empty($settings['site_favicon']) ? asset('storage/' . $settings['site_favicon']) : asset('favicon.ico') }}">

    {{-- Preload hero image for faster LCP --}}
    @hasSection('hero_preload')
        @yield('hero_preload')
    @endif

    <!-- Fonts: Inter for body text (readability), Outfit for display/headings -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary:   '{{ $settings['primary_color'] ?? '#3B82F6' }}',
                        secondary: '{{ $settings['secondary_color'] ?? '#10B981' }}',
                        accent:    '#F59E0B',
                    },
                    fontFamily: {
                        sans:    ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        display: ['Outfit', 'system-ui', 'sans-serif'],
                    },
                    fontSize: {
                        'xs':   ['0.75rem',  { lineHeight: '1.5',  letterSpacing: '0.01em' }],
                        'sm':   ['0.875rem', { lineHeight: '1.5',  letterSpacing: '0.005em' }],
                        'base': ['1rem',     { lineHeight: '1.65' }],
                        'lg':   ['1.125rem', { lineHeight: '1.6' }],
                        'xl':   ['1.25rem',  { lineHeight: '1.5' }],
                        '2xl':  ['1.5rem',   { lineHeight: '1.4',  letterSpacing: '-0.01em' }],
                        '3xl':  ['1.875rem', { lineHeight: '1.3',  letterSpacing: '-0.015em' }],
                        '4xl':  ['2.25rem',  { lineHeight: '1.2',  letterSpacing: '-0.02em' }],
                        '5xl':  ['3rem',     { lineHeight: '1.15', letterSpacing: '-0.025em' }],
                        '6xl':  ['3.75rem',  { lineHeight: '1.1',  letterSpacing: '-0.025em' }],
                        '7xl':  ['4.5rem',   { lineHeight: '1.05', letterSpacing: '-0.03em' }],
                    },
                }
            }
        }
    </script>

    <style>
        /* ── Minimalist Typography System ── */

        /* Headings: Outfit — clean geometric sans */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', system-ui, sans-serif;
            letter-spacing: -0.02em;
            font-feature-settings: 'ss01' on, 'cv01' on;
        }

        /* Body: Inter — optimised for screen readability */
        p, span, li, td, th, a, label, input, textarea, select, button, figcaption {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-feature-settings: 'cv05' on, 'cv08' on, 'ss03' on;
        }

        /* Smooth scrollbar */
        html { scroll-behavior: smooth; }

        /* Better text rendering */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* Prose / long-form content defaults */
        .prose { font-family: 'Inter', system-ui, sans-serif; }
        .prose h1, .prose h2, .prose h3, .prose h4 {
            font-family: 'Outfit', system-ui, sans-serif;
            letter-spacing: -0.02em;
        }
        .prose p, .prose li { line-height: 1.75; }

        /* Hide scrollbar utility */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Ken Burns animation for hero */
        @keyframes kenburns {
            0%   { transform: scale(1)    translate(0, 0); }
            100% { transform: scale(1.08) translate(-1%, -1%); }
        }

        /* Smooth card lift */
        .card-lift { transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.5s cubic-bezier(0.22, 1, 0.36, 1); }
        .card-lift:hover { transform: translateY(-4px); }
    </style>

    @stack('schema')
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white dark:bg-slate-950 text-slate-700 dark:text-slate-300 transition-colors duration-300">
    <!-- Navbar -->
    @include('partials.navbar')

    @hasSection('header_hero')
        @yield('header_hero')
    @endif

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Floating WhatsApp -->
    @php $waNumber = preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '628123456789')); @endphp
    <a href="https://wa.me/{{ $waNumber }}?text=Halo%20NorthSumateraTrip%20👋"
       target="_blank"
       class="fixed bottom-8 right-8 z-[150] group"
       title="Chat via WhatsApp">
        <div class="absolute inset-0 bg-emerald-500 blur-xl opacity-30 group-hover:opacity-50 transition-opacity rounded-3xl animate-pulse"></div>
        <div class="relative w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-900/30 transition-all duration-300 group-hover:scale-110 group-hover:shadow-emerald-500/40 active:scale-95">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.038 3.284l-.569 2.1c-.123.446.251.846.684.733l2.047-.524c.974.51 2.013.788 3.087.77h.003c3.181 0 5.766-2.587 5.767-5.766 0-3.18-2.585-5.763-5.767-5.763zm3.845 8.167c-.12.336-.595.617-.912.658-.27.035-.624.062-1.01-.061-.24-.077-.549-.196-1.571-.621-1.422-.593-2.339-2.035-2.41-2.127-.071-.092-.571-.759-.571-1.44s.355-1.016.483-1.152c.127-.136.279-.17.372-.17.093 0 .186.001.267.005.085.004.2.034.303.28.106.253.364.887.395.952.032.065.053.14.01.226-.042.086-.064.14-.127.213-.064.073-.134.163-.191.219-.064.063-.131.131-.057.258.074.127.329.544.706.88.485.433.896.567 1.023.63.127.063.2.053.274-.034.074-.087.316-.371.4-.499.085-.128.17-.107.286-.064.117.043.742.349.87.414.127.065.213.097.245.151.033.054.033.31-.087.646z"/></svg>
        </div>
    </a>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Image Lightbox / Zoom -->
    <div id="image-lightbox" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/80 backdrop-blur-sm cursor-zoom-out" onclick="closeLightbox()">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all z-10">
            <i class="fas fa-times text-xl"></i>
        </button>
        <img id="lightbox-img" src="" alt="" class="max-w-[92vw] max-h-[92vh] object-contain rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300" onclick="event.stopPropagation()">
    </div>
    <script>
        function openLightbox(src, alt) {
            const lb = document.getElementById('image-lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = src;
            img.alt = alt || '';
            lb.classList.remove('hidden');
            lb.classList.add('flex');
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                img.classList.remove('scale-95', 'opacity-0');
                img.classList.add('scale-100', 'opacity-100');
            });
        }
        function closeLightbox() {
            const lb = document.getElementById('image-lightbox');
            const img = document.getElementById('lightbox-img');
            img.classList.remove('scale-100', 'opacity-100');
            img.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                lb.classList.remove('flex');
                lb.classList.add('hidden');
                img.src = '';
                document.body.style.overflow = '';
            }, 300);
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>

    <!-- Main JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
