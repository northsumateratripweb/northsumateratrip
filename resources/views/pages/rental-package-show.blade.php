@extends('layouts.main')

@section('title', $package->translate('name') . ' - NorthSumateraTrip')
@section('canonical', route('rental-package.show', $package->slug))

@push('schema')
    {!! \App\Helpers\SchemaHelper::rentalPackage($package) !!}
    {!! \App\Helpers\SchemaHelper::breadcrumbs([
        'Home' => route('home'),
        'Paket Rental' => route('rental-package'),
        $package->translate('name') => url()->current()
    ]) !!}
@endpush

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            <!-- Left Content -->
            <div class="lg:col-span-8">
                <div class="mb-14">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-8 h-0.5 bg-blue-600"></div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Paket Rental</span>
                        <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Penawaran Eksklusif</span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight mb-8">{{ $package->translate('name') }}</h1>

                    @php $allImages = $package->all_image_urls; @endphp
                    <!-- Main Image -->
                    <div class="relative group rounded-2xl overflow-hidden bg-white border border-slate-100 cursor-zoom-in" onclick="openLightbox('{{ $allImages[0] ?? $package->image_url }}', '{{ $package->translate('name') }}')">
                        <div class="aspect-video overflow-hidden rounded-2xl">
                            <img src="{{ $allImages[0] ?? $package->image_url }}" alt="{{ $package->translate('name') }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                        </div>
                    </div>

                    {{-- Gallery Images --}}
                    @if(count($allImages) > 1)
                    <div class="grid grid-cols-4 gap-4 mt-6">
                        @foreach(array_slice($allImages, 1) as $galleryUrl)
                        <div class="aspect-video rounded-xl md:rounded-2xl overflow-hidden border border-slate-100 cursor-zoom-in shadow-sm hover:shadow-md transition-shadow" onclick="openLightbox('{{ $galleryUrl }}', '{{ $package->translate('name') }}')">
                            <img src="{{ $galleryUrl }}"
                                 alt="{{ $package->translate('name') }}"
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-700"
                                 loading="lazy">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Stats Row --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-16">
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('ui.price_per_day') }}</p>
                        <p class="text-xl font-extrabold text-blue-600 dark:text-white leading-none">{{ currency($package->price_per_day) }}</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Min. Sewa</p>
                        <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">{{ $package->min_rental_days ?? 1 }} {{ __('ui.days') }}</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06]">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Max. Sewa</p>
                        <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">{{ $package->max_rental_days ?? 'Flexible' }} {{ __('ui.days') }}</p>
                    </div>
                </div>

                <div class="space-y-16">
                    {{-- Includes --}}
                    @if(!empty($package->translate('includes')) && count($package->translate('includes')) > 0)
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-emerald-500"></span>
                            {{ __('ui.include') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($package->translate('includes') as $include)
                                <div class="flex items-center gap-4 p-5 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/40">
                                    <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $include }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Description --}}
                    @if($package->translate('description'))
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-blue-600"></span>
                            {{ __('ui.description') }}
                        </h2>
                        <div class="prose prose-blue dark:prose-invert max-w-none font-medium text-slate-500 dark:text-slate-400 leading-relaxed">
                            {!! $package->translate('description') !!}
                        </div>
                    </section>
                    @endif

                    {{-- Excludes --}}
                    @if(!empty($package->translate('excludes')) && count($package->translate('excludes')) > 0)
                    <section>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                            <span class="w-8 h-0.5 bg-rose-500"></span>
                            {{ __('ui.exclude') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($package->translate('excludes') as $exclude)
                                <div class="flex items-center gap-3 p-4 bg-rose-50 dark:bg-rose-900/20 rounded-xl border border-rose-100 dark:border-rose-800/40">
                                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    <span class="font-bold text-slate-700 dark:text-slate-300">{{ $exclude }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </div>

                {{-- Related Packages --}}
                @if($relatedPackages->isNotEmpty())
                <div class="mt-20">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white uppercase tracking-wide mb-8 flex items-center gap-3">
                        <span class="w-8 h-0.5 bg-blue-600"></span>
                        {{ __('ui.related_cars') }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($relatedPackages as $rel)
                        <a href="{{ route('rental-package.show', $rel->slug) }}" class="group flex items-center gap-5 p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.06] hover:border-blue-100">
                            <div class="w-20 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-900 dark:text-white line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $rel->name }}</h3>
                                <p class="text-sm font-extrabold text-blue-600 mt-1">{{ currency($rel->price_per_day) }}<span class="text-slate-400 text-xs font-medium">{{ __('ui.per_day') }}</span></p>
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
                        <div class="mb-6">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('ui.starting_from') }}</p>
                            <p class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ currency($package->price_per_day) }}<span class="text-sm text-slate-400 font-medium ml-1">{{ __('ui.per_day') }}</span></p>
                        </div>

                        <form action="{{ route('rental-package.order', $package->slug) }}" method="POST" class="space-y-5" id="bookingForm" x-data="rentalBooking()" x-on:submit.prevent="submitForm($event)">
                            @csrf
                            <input type="text" name="customer_name" required placeholder="{{ __('ui.order_name') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" value="{{ auth()->user()->name ?? '' }}">
                            <input type="email" name="customer_email" required placeholder="Email" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" value="{{ auth()->user()->email ?? '' }}">
                            <input type="tel" name="customer_phone" required placeholder="{{ __('ui.order_phone') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" value="{{ auth()->user()->phone ?? '' }}">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1 mb-2 block">{{ __('ui.order_date') }}</label>
                                    <input type="date" name="start_date" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-medium focus:border-blue-600 outline-none">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider ml-1 mb-2 block">{{ __('ui.duration') }}</label>
                                    <select name="rental_days" id="rental_days" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-medium focus:border-blue-600 outline-none appearance-none">
                                        @for($i = ($package->min_rental_days ?? 1); $i <= ($package->max_rental_days ?? 30); $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ __('ui.days') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <input type="number" name="number_of_people" required placeholder="{{ __('ui.order_persons') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all" min="1" value="1">

                            <textarea name="notes" placeholder="{{ __('ui.order_notes') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all h-28"></textarea>

                            {{-- Real-time Calculator Display --}}
                            <div class="p-6 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-100 dark:border-blue-800">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('ui.total_price') }}</span>
                                    <span id="price_breakdown" class="text-xs font-bold text-blue-600"></span>
                                </div>
                                <div class="text-xl font-extrabold text-blue-600" id="total_price_display">
                                    {{ currency($package->price_per_day) }}
                                </div>
                            </div>

                            <button type="submit" x-bind:disabled="loading" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center gap-3">
                                <template x-if="loading">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                </template>
                                <span x-text="loading ? 'Memproses...' : '{{ __('ui.book_now') }}'"></span>
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
                            function rentalBooking() {
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
                                
                                const basePrice = {{ $package->price_per_day }};
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
                                    const total = basePrice * days;
                                    priceDisplay.innerText = formatCurrency(total);
                                    breakdown.innerText = days + ' x ' + formatCurrency(basePrice);
                                }

                                daysSelect.addEventListener('change', calculate);
                                calculate();
                            })();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
