<nav class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500" x-data="{ scrolled: false, langOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" @click.outside="langOpen = false">
    <!-- Sticky Glass Background -->
    <div class="absolute inset-0 bg-white/90 dark:bg-slate-950/90 backdrop-blur-xl border-b border-slate-100 dark:border-slate-800 transition-all duration-500" :class="scrolled ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-full'"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="flex justify-between items-center h-16 md:h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    @if(isset($settings['site_logo']))
                        @php
                            $logoUrl = $settings['site_logo'];
                            if (!str_starts_with($logoUrl, 'http')) {
                                $logoUrl = asset('storage/' . $logoUrl);
                            }
                        @endphp
                        <img src="{{ $logoUrl }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" class="h-10 md:h-12 w-auto object-contain transition-all duration-300" :class="scrolled ? '' : 'brightness-0 invert drop-shadow-[0_1px_2px_rgba(0,0,0,0.3)]'">
                    @else
                        <div class="w-9 h-9 bg-blue-700 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-route text-base"></i>
                        </div>
                    @endif
                    <div>
                        <span class="text-lg font-black tracking-tight uppercase transition-colors duration-300" :class="scrolled ? 'text-slate-900 dark:text-white' : 'text-white drop-shadow-[0_1px_3px_rgba(0,0,0,0.5)]'">{{ $settings['site_name'] ?? 'NorthSumateraTrip' }}</span>
                        <p class="text-[0.5rem] font-semibold uppercase tracking-wider leading-none mt-0.5 transition-colors duration-300" :class="scrolled ? 'text-slate-400' : 'text-white/70'">{{ __('ui.site_premium') }}</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                @php
                    $navItems = [
                        ['route' => 'home',           'label' => __('ui.nav_home')],
                        ['route' => 'packages',        'label' => __('ui.nav_packages')],
                        ['route' => 'car-rental',      'label' => __('ui.nav_car_rental')],
                        ['route' => 'rental-package',  'label' => __('ui.nav_rental_package')],
                        ['route' => 'gallery',         'label' => __('ui.nav_gallery')],
                        ['route' => 'blog.index',      'label' => __('ui.nav_blog')],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="relative px-4 py-2 text-xs font-bold uppercase tracking-wider transition-all duration-300 group"
                       :class="scrolled
                           ? '{{ request()->routeIs($item['route']) ? 'text-blue-700' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}'
                           : '{{ request()->routeIs($item['route']) ? 'text-white font-bold' : 'text-white/80 hover:text-white' }} drop-shadow-[0_1px_2px_rgba(0,0,0,0.4)]'">
                        {{ $item['label'] }}
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 transform origin-left transition-transform duration-300 {{ request()->routeIs($item['route']) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}" :class="scrolled ? 'bg-blue-700' : 'bg-white'"></span>
                    </a>
                @endforeach
            </div>

            <!-- Right Side: Lang Switcher + Wishlist + CTA -->
            <div class="flex items-center gap-2">

                <!-- Language / Currency Switcher -->
                <div class="relative">
                    @php
                        $currentLocale = app()->getLocale();
                        $langMap = [
                            'id' => ['flag' => '🇮🇩', 'label' => 'ID', 'currency' => 'IDR', 'full' => __('ui.lang_id')],
                            'ms' => ['flag' => '🇲🇾', 'label' => 'MY', 'currency' => 'MYR', 'full' => __('ui.lang_ms')],
                            'en' => ['flag' => '🇸🇬', 'label' => 'EN', 'currency' => 'SGD', 'full' => __('ui.lang_en')],
                        ];
                        $current = $langMap[$currentLocale] ?? $langMap['id'];
                    @endphp
                    <button @click="langOpen = !langOpen"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl transition-all duration-300 text-xs font-bold"
                            :class="scrolled ? 'bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:border-blue-200 hover:bg-blue-50 dark:hover:bg-slate-800' : 'bg-white/15 backdrop-blur-sm border border-white/20 text-white hover:bg-white/25'"
                            type="button">
                        <span class="text-base leading-none">{{ $current['flag'] }}</span>
                        <span class="hidden sm:inline text-xs">{{ $current['label'] }}</span>
                        <span class="hidden sm:inline" :class="scrolled ? 'text-slate-300' : 'text-white/50'">·</span>
                        <span class="hidden sm:inline text-xs font-black" :class="scrolled ? 'text-blue-600' : 'text-white'">{{ $current['currency'] }}</span>
                        <svg class="w-3 h-3 transition-all duration-200" :class="[langOpen ? 'rotate-180' : '', scrolled ? 'text-slate-400' : 'text-white/60']" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="langOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 top-full mt-2 w-52 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-900/10 overflow-hidden z-50"
                         style="display: none;">
                        <div class="p-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 py-2">{{ __('ui.language') }} & {{ __('ui.currency') }}</p>
                            @foreach($langMap as $locale => $info)
                            <a href="{{ route('lang.switch', $locale) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ $locale === $currentLocale ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                                <span class="text-xl leading-none">{{ $info['flag'] }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold leading-tight">{{ $info['full'] }}</p>
                                    <p class="text-xs text-slate-400 font-medium">{{ $info['currency'] }}</p>
                                </div>
                                @if($locale === $currentLocale)
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>



                <!-- Contact CTA -->
                <a href="{{ route('contact') }}" class="hidden sm:flex px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-300 active:scale-95" :class="scrolled ? 'bg-slate-900 border border-slate-900 dark:bg-white dark:border-white text-white dark:text-slate-900 hover:bg-blue-700 hover:border-blue-700 hover:text-white' : 'bg-white text-slate-900 border border-white hover:bg-blue-600 hover:border-blue-600 hover:text-white shadow-lg shadow-black/10'">
                    {{ __('ui.nav_contact') }}
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center shadow-lg active:scale-90 transition-all duration-300" :class="scrolled ? 'bg-slate-900 text-white shadow-slate-900/10' : 'bg-white text-slate-900 shadow-black/10'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden fixed inset-0 z-[110] bg-white dark:bg-slate-950 translate-x-full transition-transform duration-500 ease-in-out py-16 px-8 overflow-y-auto">
        <button id="close-menu-btn" class="absolute top-8 right-8 w-10 h-10 bg-slate-50 dark:bg-slate-900 rounded-xl flex items-center justify-center text-slate-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="space-y-5 mt-4">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" class="block text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight hover:text-blue-600 transition-colors">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <hr class="border-slate-100 dark:border-slate-800 my-4">
            <a href="{{ route('contact') }}" class="block text-lg font-bold text-slate-400 uppercase tracking-wider">{{ __('ui.nav_contact') }}</a>

            <!-- Mobile Language Switcher -->
            <hr class="border-slate-100 dark:border-slate-800">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.language') }} & {{ __('ui.currency') }}</p>
                <div class="flex flex-col gap-2">
                    @foreach($langMap as $locale => $info)
                    <a href="{{ route('lang.switch', $locale) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl border text-sm font-semibold transition-all {{ $locale === $currentLocale ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-slate-50 border-slate-100 text-slate-600 hover:border-blue-200' }}">
                        <span class="text-xl">{{ $info['flag'] }}</span>
                        <div class="flex-1">
                            <p class="font-bold text-sm leading-tight">{{ $info['full'] }}</p>
                            <p class="text-xs text-slate-400">{{ $info['currency'] }}</p>
                        </div>
                        @if($locale === $currentLocale)
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav');
        if (window.scrollY > 50) {
            nav.classList.add('py-0');
        } else {
            nav.classList.remove('py-0');
        }
    });

    const mobileMenu    = document.getElementById('mobile-menu');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const closeMenuBtn  = document.getElementById('close-menu-btn');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    });

    closeMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.add('translate-x-full');
        document.body.style.overflow = '';
    });
</script>
