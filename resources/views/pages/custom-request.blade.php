@extends('layouts.main')

@section('title', __('ui.custom_trip') . ' — ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))
@section('meta_description', __('ui.custom_trip_desc'))

@section('content')
<div class="pt-28 md:pt-36 pb-20">

    {{-- Hero Banner --}}
    <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-800 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
        </div>
        <div class="max-w-4xl mx-auto px-6 lg:px-8 py-16 relative z-10 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/15 text-white/90 rounded-xl text-xs font-semibold uppercase tracking-widest mb-5 border border-white/20">
                <span class="w-1.5 h-1.5 rounded-full bg-white/80 animate-pulse"></span>
                {{ __('ui.custom_trip_badge') }}
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-tight mb-4">
                {{ __('ui.custom_trip') }}
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
                {{ __('ui.custom_trip_sub') }}
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 lg:px-8 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- =========================
                 LEFT: WHY CUSTOM TRIP
            ========================= --}}
            <div class="lg:col-span-1 space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight mb-5">{{ __('ui.why_custom_title') }}</h2>
                    <div class="space-y-4">
                        @foreach([
                            ['icon' => 'fa-calendar-alt',  'bg' => 'bg-blue-50 dark:bg-blue-900/20',     'text' => 'text-blue-600',   'title' => __('ui.why_flexible'),  'desc' => __('ui.why_flexible_desc')],
                            ['icon' => 'fa-coins',         'bg' => 'bg-green-50 dark:bg-green-900/20',   'text' => 'text-green-600',  'title' => __('ui.why_budget'),    'desc' => __('ui.why_budget_desc')],
                            ['icon' => 'fa-heart',         'bg' => 'bg-rose-50 dark:bg-rose-900/20',     'text' => 'text-rose-600',   'title' => __('ui.why_personal'),  'desc' => __('ui.why_personal_desc')],
                            ['icon' => 'fa-user-shield',   'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600', 'title' => __('ui.why_support'),   'desc' => __('ui.why_support_desc')],
                        ] as $why)
                        <div class="flex items-start gap-4 p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl {{ $why['bg'] }} flex items-center justify-center {{ $why['text'] }} flex-shrink-0">
                                <i class="fas {{ $why['icon'] }} text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $why['title'] }}</p>
                                <p class="text-slate-500 text-xs leading-relaxed mt-0.5">{{ $why['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="bg-slate-900 dark:bg-slate-800 rounded-2xl p-6 text-white">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">NorthSumateraTrip</p>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([['num' => '500+', 'label' => 'Trip Done'], ['num' => '99%', 'label' => 'Puas'], ['num' => '50+', 'label' => 'Destinasi'], ['num' => '24/7', 'label' => 'Support']] as $stat)
                        <div>
                            <p class="text-2xl font-extrabold text-blue-400 leading-none">{{ $stat['num'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $stat['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- =========================
                 RIGHT: FORM
            ========================= --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-900/5 overflow-hidden"
                     x-data="customRequestForm()" @keydown.escape.window="closeSuccess()">

                    {{-- Step Progress Bar --}}
                    <div class="border-b border-slate-100 dark:border-slate-800 px-8 pt-7 pb-0">
                        <div class="flex items-center gap-0 mb-0">
                            @foreach([__('ui.step_contact'), __('ui.step_trip'), __('ui.step_preferences')] as $i => $stepLabel)
                            <div class="flex-1 flex flex-col items-center group cursor-pointer" @click="goStep({{ $i + 1 }})">
                                <div class="flex items-center w-full">
                                    @if($i > 0)<div class="flex-1 h-0.5 transition-colors duration-300" :class="step > {{ $i }} ? 'bg-blue-600' : 'bg-slate-100 dark:bg-slate-800'"></div>@endif
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 flex-shrink-0"
                                         :class="step === {{ $i + 1 }} ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : (step > {{ $i + 1 }} ? 'bg-green-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400')">
                                        <span x-show="step <= {{ $i + 1 }}">{{ $i + 1 }}</span>
                                        <i x-show="step > {{ $i + 1 }}" class="fas fa-check text-xs"></i>
                                    </div>
                                    @if($i < 2)<div class="flex-1 h-0.5 transition-colors duration-300" :class="step > {{ $i + 1 }} ? 'bg-blue-600' : 'bg-slate-100 dark:bg-slate-800'"></div>@endif
                                </div>
                                <p class="text-xs font-semibold mt-2 transition-colors duration-200"
                                   :class="step === {{ $i + 1 }} ? 'text-blue-600' : 'text-slate-400'">
                                    {{ $stepLabel }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <form @submit.prevent="submitForm" class="p-8">

                        {{-- STEP 1: Contact --}}
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">{{ __('ui.step_contact') }}</h3>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.order_name') }} *</label>
                                    <input type="text" x-model="form.customer_name" placeholder="Nama lengkap Anda"
                                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           :class="errors.customer_name ? 'border-red-400 bg-red-50' : ''">
                                    <p x-show="errors.customer_name" class="text-red-500 text-xs mt-1" x-text="errors.customer_name"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.order_phone') }} *</label>
                                    <input type="tel" x-model="form.customer_phone" placeholder="+62 812-xxxx-xxxx"
                                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           :class="errors.customer_phone ? 'border-red-400 bg-red-50' : ''">
                                    <p x-show="errors.customer_phone" class="text-red-500 text-xs mt-1" x-text="errors.customer_phone"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Email <span class="text-slate-300 font-normal normal-case">(opsional)</span></label>
                                    <input type="email" x-model="form.customer_email" placeholder="email@contoh.com"
                                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                        </div>

                        {{-- STEP 2: Trip Info --}}
                        <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">{{ __('ui.step_trip') }}</h3>
                            <div class="space-y-5">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.order_date') }}</label>
                                        <input type="date" x-model="form.trip_date"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                        <p class="text-xs text-slate-400 mt-1">Bisa dikosongkan jika belum pasti</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.trip_duration_label') }} *</label>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="form.trip_duration = Math.max(1, form.trip_duration - 1)"
                                                    class="w-10 h-11 bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors flex-shrink-0">−</button>
                                            <input type="number" x-model.number="form.trip_duration" min="1" max="30"
                                                   class="flex-1 px-3 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <button type="button" @click="form.trip_duration = Math.min(30, form.trip_duration + 1)"
                                                    class="w-10 h-11 bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors flex-shrink-0">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.num_persons_label') }} *</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" @click="form.num_persons = Math.max(1, form.num_persons - 1)"
                                                class="w-11 h-11 bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors flex-shrink-0">−</button>
                                        <div class="flex-1 relative">
                                            <input type="number" x-model.number="form.num_persons" min="1" max="500"
                                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm text-center font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 font-medium">orang</span>
                                        </div>
                                        <button type="button" @click="form.num_persons = Math.min(500, form.num_persons + 1)"
                                                class="w-11 h-11 bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors flex-shrink-0">+</button>
                                    </div>
                                    {{-- Group size chips --}}
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @foreach([1, 2, 3, 4, 5, 6, 10, 15, 20] as $n)
                                        <button type="button" @click="form.num_persons = {{ $n }}"
                                                class="px-3 py-1 rounded-lg text-xs font-semibold transition-all border"
                                                :class="form.num_persons === {{ $n }} ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-50 text-slate-500 border-slate-200 hover:border-blue-300'">
                                            {{ $n }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.destinations_label') }}</label>
                                    <textarea x-model="form.destinations" rows="3"
                                              placeholder="{{ __('ui.destinations_placeholder') }}"
                                              class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none leading-relaxed"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- STEP 3: Preferences --}}
                        <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">{{ __('ui.step_preferences') }}</h3>
                            <div class="space-y-6">
                                {{-- Budget --}}
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">{{ __('ui.budget_label') }}</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        @foreach($budgetOptions as $value => $label)
                                        <button type="button" @click="form.budget_range = '{{ $value }}'"
                                                class="px-4 py-3 rounded-xl text-xs font-semibold text-left transition-all border"
                                                :class="form.budget_range === '{{ $value }}' ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-blue-300'">
                                            {{ $label }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Accommodation --}}
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">{{ __('ui.accommodation_label') }}</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        @foreach($accommodationOptions as $value => $label)
                                        <button type="button" @click="form.accommodation_type = '{{ $value }}'"
                                                class="px-4 py-3 rounded-xl text-xs font-semibold text-left transition-all border"
                                                :class="form.accommodation_type === '{{ $value }}' ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-blue-300'">
                                            {{ $label }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Transport --}}
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">{{ __('ui.transport_label') }}</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        @foreach($transportOptions as $value => $label)
                                        <button type="button" @click="form.transport_type = '{{ $value }}'"
                                                class="px-4 py-3 rounded-xl text-xs font-semibold text-left transition-all border"
                                                :class="form.transport_type === '{{ $value }}' ? 'bg-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-blue-300'">
                                            {{ $label }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Special Requests --}}
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">{{ __('ui.special_requests_label') }}</label>
                                    <textarea x-model="form.special_requests" rows="3"
                                              placeholder="{{ __('ui.special_requests_ph') }}"
                                              class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none leading-relaxed"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                            <button x-show="step > 1" type="button" @click="prevStep"
                                    class="flex items-center gap-2 px-5 py-2.5 text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 text-sm font-semibold transition-colors">
                                <i class="fas fa-arrow-left text-xs"></i>
                                Kembali
                            </button>
                            <div x-show="step <= 1" class="w-4"></div>

                            <div class="flex items-center gap-3">
                                {{-- Summary chip --}}
                                <div x-show="step >= 2" class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-xs text-blue-600 font-semibold">
                                    <i class="fas fa-users text-xs"></i>
                                    <span x-text="form.num_persons + ' orang · ' + form.trip_duration + ' hari'"></span>
                                </div>

                                {{-- Next / Submit --}}
                                <button x-show="step < 3" type="button" @click="nextStep"
                                        class="flex items-center gap-2 px-7 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl text-sm font-bold hover:bg-blue-700 hover:text-white transition-all active:scale-95">
                                    Lanjut
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                                <button x-show="step === 3" type="submit"
                                        :disabled="submitting"
                                        class="flex items-center gap-2.5 px-7 py-3 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition-all active:scale-95 disabled:opacity-60 disabled:cursor-not-allowed shadow-lg shadow-green-500/25">
                                    <i class="fab fa-whatsapp text-base" x-show="!submitting"></i>
                                    <svg x-show="submitting" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span x-text="submitting ? 'Mengirim...' : '{{ __('ui.submit_custom') }}'"></span>
                                </button>
                            </div>
                        </div>

                    </form>

                    {{-- Success Overlay --}}
                    <div x-show="success"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0 bg-white dark:bg-slate-900 rounded-3xl flex flex-col items-center justify-center p-10 text-center"
                         style="display: none;">
                        <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center mb-6">
                            <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">{{ __('ui.custom_success_title') }}</h3>
                        <p class="text-slate-500 text-sm mb-8 max-w-xs leading-relaxed">{{ __('ui.custom_success_msg') }}</p>
                        <div class="flex flex-col sm:flex-row gap-3 w-full max-w-xs">
                            <a :href="whatsappUrl" target="_blank"
                               class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 bg-green-500 text-white rounded-xl font-semibold text-sm hover:bg-green-600 transition-colors">
                                <i class="fab fa-whatsapp text-base"></i>
                                Buka WhatsApp
                            </a>
                            <button @click="closeSuccess"
                                    class="flex-1 px-6 py-3.5 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-xl font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function customRequestForm() {
    return {
        step: 1,
        submitting: false,
        success: false,
        whatsappUrl: '',
        form: {
            customer_name:      '',
            customer_phone:     '',
            customer_email:     '',
            trip_date:          '',
            trip_duration:      3,
            num_persons:        2,
            destinations:       '',
            budget_range:       '',
            accommodation_type: '',
            transport_type:     '',
            special_requests:   '',
        },
        errors: {},

        goStep(s) {
            if (s < this.step) this.step = s;
        },

        nextStep() {
            this.errors = {};
            if (this.step === 1) {
                if (!this.form.customer_name.trim()) {
                    this.errors.customer_name = 'Nama wajib diisi';
                    return;
                }
                if (!this.form.customer_phone.trim()) {
                    this.errors.customer_phone = 'Nomor HP wajib diisi';
                    return;
                }
            }
            if (this.step < 3) this.step++;
        },

        prevStep() {
            if (this.step > 1) this.step--;
        },

        async submitForm() {
            this.submitting = true;
            this.errors = {};

            try {
                const res = await fetch('{{ route('custom-request.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.form),
                });

                const data = await res.json();

                if (data.success) {
                    this.whatsappUrl = data.whatsapp_url;
                    this.success = true;
                    // Auto-open WhatsApp after 800ms
                    setTimeout(() => { window.open(data.whatsapp_url, '_blank'); }, 800);
                } else if (data.errors) {
                    this.errors = data.errors;
                    // Go to first step with errors
                    if (this.errors.customer_name || this.errors.customer_phone) this.step = 1;
                    else if (this.errors.trip_duration || this.errors.num_persons) this.step = 2;
                }
            } catch(e) {
                alert('Terjadi kesalahan, silakan coba lagi.');
            } finally {
                this.submitting = false;
            }
        },

        closeSuccess() {
            this.success = false;
            this.step = 1;
            this.form = {
                customer_name: '', customer_phone: '', customer_email: '',
                trip_date: '', trip_duration: 3, num_persons: 2,
                destinations: '', budget_range: '', accommodation_type: '',
                transport_type: '', special_requests: '',
            };
        }
    }
}
</script>
@endpush
