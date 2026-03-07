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
            
            <!-- Left: Language & Currency Switcher -->
            <div class="flex-1 hidden md:flex items-center gap-3">
                <div class="flex items-center bg-gray-50 rounded-full p-1 border border-gray-100">
                    @foreach(['id' => '🇮🇩', 'en' => '🇺🇸', 'ms' => '🇲🇾'] as $loc => $flag)
                        <a href="{{ route('lang.switch', $loc) }}" 
                           class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all {{ app()->getLocale() == $loc ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">
                            {{ $flag }} {{ strtoupper($loc) }}
                        </a>
                    @endforeach
                </div>
                <div class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-100">
                    {{ \App\Services\CurrencyService::code() }} ({{ \App\Services\CurrencyService::symbol() }})
                </div>
            </div>

            <!-- Left: Mobile Lang Toggle (Small) -->
            <div class="md:hidden flex items-center">
                <div class="flex items-center bg-gray-50 rounded-lg p-0.5 border border-gray-100">
                    @foreach(['id' => '🇮🇩', 'en' => '🇺🇸'] as $loc => $flag)
                        @if(app()->getLocale() != $loc)
                        <a href="{{ route('lang.switch', $loc) }}" class="p-1.5 text-[10px] grayscale hover:grayscale-0 transition-all">
                            {{ $flag }}
                        </a>
                        @endif
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
