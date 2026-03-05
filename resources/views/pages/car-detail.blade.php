@extends('layouts.main')

@section('title', ($carRental->meta_title ?? $carRental->name) . ' - NorthSumateraTrip')
@section('meta_description', Str::limit(strip_tags($carRental->meta_description ?? $carRental->description ?? 'Sewa mobil ' . $carRental->name . ' di Sumatera harga murah dengan supir profesional.'), 160))

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            <!-- Left Content -->
            <div class="lg:col-span-8">
                <div class="mb-14">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-8 h-0.5 bg-blue-600"></div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Sewa Mobil</span>
                        <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Sumatera & Sekitarnya</span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight mb-8">{{ $carRental->name }}</h1>

                    <!-- Main Image -->
                    <div class="relative group rounded-2xl overflow-hidden bg-white border border-slate-100 cursor-zoom-in" onclick="openLightbox('{{ $carRental->image_url }}', '{{ $carRental->name }}')">
                        <div class="aspect-video overflow-hidden rounded-2xl">
                            <img src="{{ $carRental->image_url }}" alt="{{ $carRental->name }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                        </div>
                    </div>

                    {{-- Gallery Images --}}
                    @if(!empty($carRental->gallery_images) && count($carRental->gallery_images) > 0)
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        @foreach(array_slice($carRental->gallery_images, 0, 6) as $galleryImage)
                        @php $galleryUrl = str_starts_with($galleryImage, 'http') ? $galleryImage : asset('storage/' . $galleryImage); @endphp
                        <div class="aspect-video rounded-2xl overflow-hidden border border-slate-100 cursor-zoom-in" onclick="openLightbox('{{ $galleryUrl }}', '{{ $carRental->name }}')">
                            <img src="{{ $galleryUrl }}"
                                 alt="{{ $carRental->name }}"
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-700"
                                 loading="lazy">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Stats Row --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-16">
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.capacity') }}</p>
                        <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">{{ $carRental->capacity }} Kursi</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.price_per_day') }}</p>
                        <p class="text-xl font-extrabold text-blue-600 dark:text-white leading-none">{{ currency($carRental->price_per_day) }}</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.transmission') }}</p>
                        <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none capitalize">{{ $carRental->transmission ?? 'Manual' }}</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.status') }}</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $carRental->is_available ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                            <span class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">{{ $carRental->is_available ? __('ui.available') : __('ui.booked') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Additional Info: Fuel Type & Year --}}
                @if($carRental->fuel_type || $carRental->year)
                <div class="grid grid-cols-2 gap-4 mb-16">
                    @if($carRental->fuel_type)
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.fuel_type') }}</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white capitalize">{{ $carRental->fuel_type }}</p>
                    </div>
                    @endif
                    @if($carRental->year)
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.year') }}</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $carRental->year }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <div class="space-y-16">
                    {{-- Features (from DB) --}}
                    @if(!empty($carRental->features) && count($carRental->features) > 0)
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-blue-600"></span>
                            {{ __('ui.features') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($carRental->features as $feature)
                                <div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:border-blue-100">
                                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-medium text-slate-600 dark:text-slate-400">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @else
                    {{-- Default facilities if no features in DB --}}
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-blue-600"></span>
                            {{ __('ui.rental_facilities') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach([__('ui.driver_fuel_included'), __('ui.full_ac_audio'), __('ui.clean_fragrant_unit'), __('ui.travel_insurance'), __('ui.24_hour_service'), __('ui.airport_transfer')] as $service)
                                <div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:border-blue-100">
                                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-medium text-slate-600 dark:text-slate-400">{{ $service }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Includes --}}
                    @if(!empty($carRental->includes) && count($carRental->includes) > 0)
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-emerald-500"></span>
                            {{ __('ui.include') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($carRental->includes as $include)
                                <div class="flex items-center gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/40">
                                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="font-bold text-slate-700 dark:text-slate-300">{{ $include }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Description --}}
                    @if($carRental->description)
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-blue-600"></span>
                            {{ __('ui.description') }}
                        </h2>
                        <div class="prose prose-blue dark:prose-invert max-w-none font-medium text-slate-500 dark:text-slate-400 leading-relaxed">
                            {!! $carRental->description !!}
                        </div>
                    </section>
                    @endif

                    {{-- Terms --}}
                    @if($carRental->terms)
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-amber-500"></span>
                            {{ __('ui.terms') }}
                        </h2>
                        <div class="p-6 bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-100 dark:border-amber-800/40">
                            <div class="prose prose-amber dark:prose-invert max-w-none text-slate-600 dark:text-slate-400">
                                {!! nl2br(e($carRental->terms)) !!}
                            </div>
                        </div>
                    </section>
                    @endif
                </div>

                {{-- Related Cars --}}
                @if(isset($relatedCarRentals) && $relatedCarRentals->isNotEmpty())
                <div class="mt-20">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                        <span class="w-8 h-0.5 bg-blue-600"></span>
                        {{ __('ui.related_cars') }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($relatedCarRentals->take(4) as $related)
                        <a href="{{ route('car.detail', $related->slug) }}" class="group flex items-center gap-5 p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06] hover:border-blue-100">
                            <div class="w-20 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $related->capacity }} Kursi &bull; {{ $related->transmission ?? 'Manual' }}</p>
                                <h3 class="font-bold text-slate-900 dark:text-white line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $related->name }}</h3>
                                <p class="text-sm font-extrabold text-blue-600 mt-1">{{ currency($related->price_per_day) }}<span class="text-slate-400 text-xs font-medium">{{ __('ui.per_day') }}</span></p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-blue-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-44">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 border border-slate-100 dark:border-slate-800 shadow-lg shadow-blue-900/[0.06]">

                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">{{ __('ui.starting_from') }}</p>
                                <p class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ currency($carRental->price_per_day) }}<span class="text-sm text-slate-400 font-medium ml-1">{{ __('ui.per_day') }}</span></p>
                            </div>

                        </div>

                        {{-- Pricing Options --}}
                        @if($carRental->price_per_12_hours || $carRental->price_with_driver)
                        <div class="mb-8 space-y-3">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ __('ui.pricing_options') }}</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ __('ui.price_per_day_24h') }}</span>
                                    <span class="text-sm font-extrabold text-blue-600">{{ currency($carRental->price_per_day) }}</span>
                                </div>
                                @if($carRental->price_per_12_hours)
                                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ __('ui.price_12h') }}</span>
                                    <span class="text-sm font-extrabold text-blue-600">{{ currency($carRental->price_per_12_hours) }}</span>
                                </div>
                                @endif
                                @if($carRental->price_with_driver)
                                <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/30 rounded-2xl border border-blue-100 dark:border-blue-800">
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ __('ui.price_with_driver') }}</span>
                                    <span class="text-sm font-extrabold text-blue-600">{{ currency($carRental->price_with_driver) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('car.order', $carRental->slug) }}" method="POST" class="space-y-5" id="bookingForm" x-data="carBooking()" x-on:submit.prevent="submitForm($event)">
                            @csrf
                            <input type="text" name="customer_name" required placeholder="{{ __('ui.order_name') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" value="{{ auth()->user()->name ?? '' }}">
                            <input type="email" name="customer_email" required placeholder="Email" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" value="{{ auth()->user()->email ?? '' }}">
                            <input type="tel" name="customer_phone" required placeholder="{{ __('ui.order_phone') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" value="{{ auth()->user()->phone ?? '' }}">

                            <div class="grid grid-cols-2 gap-4">
                                <input type="date" name="trip_date" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-medium focus:border-blue-600 outline-none">
                                <select name="quantity" id="rental_days" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-medium focus:border-blue-600 outline-none appearance-none">
                                    @for($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ __('ui.days') }}</option>
                                    @endfor
                                </select>
                            </div>

                            <textarea name="notes" placeholder="{{ __('ui.order_notes') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all h-28"></textarea>

                            {{-- Real-time Calculator Display --}}
                            <div class="p-6 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-100 dark:border-blue-800">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('ui.total_price') }}</span>
                                    <span id="price_breakdown" class="text-xs font-bold text-blue-600"></span>
                                </div>
                                <div class="text-xl font-extrabold text-blue-600" id="total_price_display">
                                    {{ currency($carRental->price_per_day) }}
                                </div>
                            </div>

                            <button type="submit" x-bind:disabled="loading" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center gap-3">
                                <template x-if="loading">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                </template>
                                <span x-text="loading ? 'Memproses...' : '{{ __('ui.order_car') }}'"></span>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>

                            <!-- Success Modal -->
                            <div x-show="showSuccess" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
                                <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" x-on:click="showSuccess = false"></div>
                                <div class="relative bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-md w-full shadow-2xl border border-slate-100 dark:border-slate-800"
                                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                                    <div class="text-center">
                                        <div class="w-20 h-20 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2">Pesanan Berhasil!</h3>
                                        <p class="text-slate-500 text-sm mb-8" x-text="successMessage"></p>
                                        <div class="flex flex-col gap-3">
                                            <a x-bind:href="whatsappUrl" target="_blank" class="flex items-center justify-center gap-3 px-6 py-3.5 bg-[#25D366] hover:bg-[#1fb355] text-white font-bold rounded-xl transition-all shadow-lg uppercase tracking-wider text-xs">
                                                <i class="fab fa-whatsapp text-lg"></i> Konfirmasi via WhatsApp
                                            </a>
                                            <a x-bind:href="redirectUrl" class="flex items-center justify-center gap-3 px-6 py-3.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-white font-bold rounded-xl transition-all text-xs uppercase tracking-wider">
                                                <i class="fas fa-search"></i> Lihat Status Pesanan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            function carBooking() {
                                return {
                                    loading: false,
                                    showSuccess: false,
                                    successMessage: '',
                                    whatsappUrl: '',
                                    redirectUrl: '',
                                    submitForm(e) {
                                        this.loading = true;
                                        const form = e.target;
                                        const formData = new FormData(form);
                                        
                                        fetch(form.action, {
                                            method: 'POST',
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json'
                                            },
                                            body: formData
                                        })
                                        .then(async res => {
                                            const data = await res.json();
                                            if (!res.ok) throw { status: res.status, data };
                                            return data;
                                        })
                                        .then(data => {
                                            this.successMessage = data.message;
                                            this.whatsappUrl = data.whatsapp_url || '';
                                            this.redirectUrl = data.redirect || '';
                                            this.showSuccess = true;
                                        })
                                        .catch(err => {
                                            if (err.status === 422 && err.data?.errors) {
                                                const msgs = Object.values(err.data.errors).flat();
                                                window.NorthSumateraTrip.showToast(msgs[0], 'error');
                                            } else {
                                                window.NorthSumateraTrip.showToast(err.data?.message || 'Terjadi kesalahan', 'error');
                                            }
                                        })
                                        .finally(() => { this.loading = false; });
                                    }
                                }
                            }
                        </script>

                        <script>
                            (function() {
                                const daysSelect = document.getElementById('rental_days');
                                const priceDisplay = document.getElementById('total_price_display');
                                const breakdown = document.getElementById('price_breakdown');
                                
                                const basePrice = {{ $carRental->price_per_day }};
                                const pricingDetails = {!! json_encode($carRental->pricing_details ?? []) !!};
                                const exchangeRate = {{ \App\Services\CurrencyService::rate() }};
                                const symbol = "{{ \App\Services\CurrencyService::symbol() }}";
                                const locale = "{{ app()->getLocale() }}";

                                function formatCurrency(amount) {
                                    const converted = amount * exchangeRate;
                                    if (locale === 'id') {
                                        return symbol + ' ' + Math.round(converted).toLocaleString('id-ID');
                                    } else {
                                        return symbol + converted.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                    }
                                }

                                function calculate() {
                                    const days = parseInt(daysSelect.value);
                                    let currentPrice = basePrice;

                                    if (pricingDetails && pricingDetails.length > 0) {
                                        // Sort and find best match
                                        const sorted = [...pricingDetails].sort((a, b) => parseInt(a.days) - parseInt(b.days));
                                        const matched = sorted.filter(r => parseInt(r.days) <= days).pop();
                                        if (matched) {
                                            currentPrice = parseFloat(matched.price);
                                        }
                                    }

                                    const total = currentPrice * days;
                                    priceDisplay.innerText = formatCurrency(total);
                                    breakdown.innerText = days + ' x ' + formatCurrency(currentPrice);
                                }

                                daysSelect.addEventListener('change', calculate);
                                calculate();
                            })();
                        </script>

                        <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-4">{{ __('ui.need_help') }}</p>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '628123456789')) }}?text=Halo, saya ingin tanya sewa {{ urlencode($carRental->name) }}" target="_blank" class="text-xs font-bold text-[#25D366] uppercase tracking-wider hover:opacity-80 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.038 3.284l-.569 2.1c-.123.446.251.846.684.733l2.047-.524c.974.51 2.013.788 3.087.77h.003c3.181 0 5.766-2.587 5.767-5.766 0-3.18-2.585-5.763-5.767-5.763zm3.845 8.167c-.12.336-.595.617-.912.658-.27.035-.624.062-1.01-.061-.24-.077-.549-.196-1.571-.621-1.422-.593-2.339-2.035-2.41-2.127-.071-.092-.571-.759-.571-1.44s.355-1.016.483-1.152c.127-.136.279-.17.372-.17.093 0 .186.001.267.005.085.004.2.034.303.28.106.253.364.887.395.952.032.065.053.14.01.226-.042.086-.064.14-.127.213-.064.073-.134.163-.191.219-.064.063-.131.131-.057.258.074.127.329.544.706.88.485.433.896.567 1.023.63.127.063.2.053.274-.034.074-.087.316-.371.4-.499.085-.128.17-.107.286-.064.117.043.742.349.87.414.127.065.213.097.245.151.033.054.033.31-.087.646z"/></svg>
                                {{ __('ui.whatsapp_cs') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
