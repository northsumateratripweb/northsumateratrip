@php
    $navItems = [
        ['route' => 'home',           'label' => __('ui.nav_home')],
        ['route' => 'packages',        'label' => __('ui.nav_packages')],
        ['route' => 'car-rental',      'label' => __('ui.nav_car_rental')],
        ['route' => 'rental-package',  'label' => __('ui.nav_rental_package')],
        ['route' => 'gallery',         'label' => __('ui.nav_gallery')],
        ['route' => 'blog.index',      'label' => __('ui.nav_blog')],
        ['route' => 'contact',         'label' => __('ui.nav_contact')],
    ];
@endphp

<header class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- Navbar Container -->
    <div class="max-w-7xl mx-auto px-4">
        <!-- Main Row: Content Centered & Balanced -->
        <div class="flex items-center justify-between h-14 md:h-16 gap-2">
            
            <!-- Left: Language & Currency Switcher (Desktop) -->
            <div class="flex-1 hidden md:flex items-center gap-2">
                {{-- Language Switcher --}}
                <div class="flex items-center bg-gray-50 rounded-full p-0.5 border border-gray-100">
                    @php
                        $langs = ['id' => ['flag' => '🇮🇩', 'label' => 'ID'], 'en' => ['flag' => '🇺🇸', 'label' => 'EN'], 'ms' => ['flag' => '🇲🇾', 'label' => 'MY']];
                        $currentLang = app()->getLocale();
                    @endphp
                    @foreach($langs as $loc => $info)
                        <a href="{{ route('lang.switch', $loc) }}" 
                           title="{{ match($loc) { 'id' => 'Bahasa Indonesia', 'en' => 'English', 'ms' => 'Bahasa Melayu' } }}"
                           class="px-2.5 py-1 rounded-full text-[10px] font-black tracking-wider transition-all whitespace-nowrap {{ $currentLang == $loc ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-400 hover:text-gray-700' }}">
                            {{ $info['flag'] }} {{ $info['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Currency Info --}}
                @php
                    $currCode   = \App\Services\CurrencyService::code();
                    $currSymbol = \App\Services\CurrencyService::symbol();
                    $currRate   = \App\Services\CurrencyService::rate();
                    $locale     = app()->getLocale();
                @endphp
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-1.5 px-2.5 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-100 hover:bg-blue-100 transition-colors cursor-pointer">
                        <span>{{ $currCode }}</span>
                        <span class="text-blue-400">({{ $currSymbol }})</span>
                        <svg class="w-2.5 h-2.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" x-transition
                         class="absolute top-full left-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl z-50 p-3">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">💱 Kurs Harga</p>
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between p-2 rounded-lg {{ $locale == 'id' ? 'bg-blue-50 border border-blue-100' : 'bg-gray-50' }}">
                                <span class="text-xs font-bold text-gray-700">🇮🇩 IDR (Rp)</span>
                                <span class="text-[10px] text-gray-500">Rupiah Indonesia</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-lg {{ $locale == 'en' ? 'bg-blue-50 border border-blue-100' : 'bg-gray-50' }}">
                                <span class="text-xs font-bold text-gray-700">🇺🇸 SGD (S$)</span>
                                <span class="text-[10px] text-gray-500">≈ Rp {{ number_format(1 / \App\Services\CurrencyService::rate('en'), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-lg {{ $locale == 'ms' ? 'bg-blue-50 border border-blue-100' : 'bg-gray-50' }}">
                                <span class="text-xs font-bold text-gray-700">🇲🇾 MYR (RM)</span>
                                <span class="text-[10px] text-gray-500">≈ Rp {{ number_format(1 / \App\Services\CurrencyService::rate('ms'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <p class="text-[9px] text-gray-400 mt-2 text-center">Ganti bahasa untuk mengubah mata uang</p>
                    </div>
                </div>
            </div>

            <!-- Left: Mobile Lang Toggle -->
            <div class="md:hidden flex items-center">
                <div class="flex items-center bg-gray-50 rounded-lg p-0.5 border border-gray-100 gap-0.5">
                    @foreach(['id' => '🇮🇩', 'en' => '🇺🇸', 'ms' => '🇲🇾'] as $loc => $flag)
                        <a href="{{ route('lang.switch', $loc) }}" 
                           class="px-1.5 py-1 rounded text-sm transition-all {{ app()->getLocale() == $loc ? 'bg-white shadow-sm' : 'opacity-50 hover:opacity-80' }}">
                            {{ $flag }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Center: Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0 px-2">
                @if(!empty($settings['site_logo']))
                    @php
                        $logoUrl = $settings['site_logo'];
                        if (!str_starts_with($logoUrl, 'http')) {
                            $logoUrl = asset('storage/' . $logoUrl);
                        }
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ $settings['site_name'] ?? 'NorthSumateraTrip' }}" class="h-9 md:h-12 w-auto object-contain">
                @else
                    <span class="text-xl font-black tracking-tighter text-gray-900 uppercase">
                        {{ $settings['site_name'] ?? 'NST' }}
                    </span>
                @endif
            </a>

            <!-- Right: Actions -->
            <div class="flex-1 flex justify-end items-center gap-4">
                <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '' }}" class="hidden md:flex items-center gap-1.5 px-4 py-2 bg-green-50 text-green-600 rounded-full border border-green-100 text-[10px] font-bold uppercase tracking-widest hover:bg-green-100 transition-colors">
                    <i class="fab fa-whatsapp"></i> Chat CS
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Scroller (Strategic & Space-efficient) -->
    <div class="border-t border-gray-50 bg-white/50 backdrop-blur-sm overflow-x-auto no-scrollbar">
        <div class="max-w-7xl mx-auto">
            <ul class="flex items-center whitespace-nowrap px-4 py-2 md:py-3 gap-6 md:gap-10 justify-start md:justify-center">
                @foreach($navItems as $item)
                    @if($item['route'] !== 'contact')
                    <li>
                        <a href="{{ route($item['route']) }}" class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500 hover:text-blue-600 transition-all {{ request()->routeIs($item['route']) ? 'text-blue-600' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Mobile Full Menu Drawer -->
    <div id="mobile-navigation" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full z-[60]">
        <ul class="py-2">
            @foreach($navItems as $item)
                <li>
                    <a href="{{ route($item['route']) }}" class="block px-8 py-4 text-xs font-bold uppercase tracking-widest text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
            <li class="px-8 py-4 border-t border-gray-50">
                <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '' }}" class="flex items-center gap-3 text-green-600 font-bold text-xs uppercase tracking-widest">
                    <i class="fab fa-whatsapp text-lg"></i> Hubungi via WhatsApp
                </a>
            </li>
        </ul>
    </div>
</header>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-navigation');
        menu.classList.toggle('hidden');
    });
</script>
