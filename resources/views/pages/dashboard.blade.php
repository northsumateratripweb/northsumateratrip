@extends('layouts.main')

@section('title', __('ui.dashboard_title') . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))

@section('content')
<section class="py-32 md:py-48 bg-slate-50 dark:bg-slate-950 min-h-screen relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-50/50 to-transparent dark:from-blue-900/10 pointer-events-none"></div>
    <div class="absolute top-48 -left-24 w-96 h-96 bg-blue-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div>
                <div class="inline-flex items-center gap-3 px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl text-xs font-bold uppercase tracking-[0.2em] mb-6 border border-blue-100 dark:border-blue-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    {{ __('ui.site_premium') }}
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    {{ __('ui.dashboard_title') }}
                </h1>
                <p class="text-slate-500 dark:text-slate-400 font-medium mt-4 max-w-xl">
                    Selamat datang kembali, <span class="text-blue-600 dark:text-blue-400 font-bold">{{ auth()->user()->name }}</span>. Kelola semua rencana perjalananmu di Sumatera Utara di sini.
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="px-6 py-4 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl shadow-sm">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ __('ui.total_orders') }}</p>
                    <p class="text-2xl font-extrabold text-slate-900 dark:text-white leading-none">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 mb-16">
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 transition-all hover:shadow-lg hover:shadow-blue-900/[0.06] group">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-route text-lg"></i>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white leading-none mb-2">{{ $stats['total'] }}</p>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ __('ui.total_orders') }}</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 transition-all hover:shadow-lg hover:shadow-blue-900/[0.06] group">
                <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white leading-none mb-2">{{ $stats['completed'] }}</p>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ __('ui.completed_orders') }}</p>
            </div>
            <div class="col-span-2 md:col-span-1 bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 transition-all hover:shadow-lg hover:shadow-blue-900/[0.06] group">
                <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center text-amber-600 mb-6 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-clock text-lg"></i>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white leading-none mb-2">{{ $stats['pending'] }}</p>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ __('ui.pending_orders') }}</p>
            </div>
        </div>

        <!-- Section: Active & History -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- List Section -->
            <div class="lg:col-span-12">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('ui.order_history') }}</h2>
                </div>

                @if($orders->isNotEmpty())
                    <div class="space-y-6">
                        @foreach($orders as $order)
                        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden group hover:shadow-lg hover:shadow-blue-900/[0.06] transition-all duration-500">
                            <div class="flex flex-col md:flex-row">
                                <!-- Main Info Side -->
                                <div class="p-8 md:p-10 flex-1">
                                    <div class="flex flex-wrap items-center gap-4 mb-6">
                                        <span class="px-4 py-1.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-slate-900/10">
                                            #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                                            @if($order->status == 'completed') bg-emerald-50 text-emerald-600 border border-emerald-100
                                            @elseif($order->status == 'pending') bg-amber-50 text-amber-600 border border-amber-100
                                            @elseif($order->status == 'confirmed') bg-blue-50 text-blue-600 border border-blue-100
                                            @elseif($order->status == 'cancelled') bg-rose-50 text-rose-600 border border-rose-100
                                            @else bg-slate-50 text-slate-500 border border-slate-100
                                            @endif">
                                            @php $statusKey = 'ui.status_' . $order->status; @endphp
                                            {{ __($statusKey) !== $statusKey ? __($statusKey) : ucfirst($order->status) }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-400 flex items-center gap-1.5 uppercase tracking-wider ml-auto">
                                            <i class="far fa-calendar-alt text-blue-500"></i>
                                            {{ \Carbon\Carbon::parse($order->trip_date)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>

                                    <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-6 tracking-tight leading-none group-hover:text-blue-600 transition-colors">
                                        {{ $order->product->name ?? ($order->vehicle->name ?? 'Sewa Mobil') }}
                                    </h3>

                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-8 border-t border-slate-50 dark:border-slate-800/50">
                                        <div>
                                            <p class="text-[0.5rem] font-bold text-slate-400 uppercase tracking-widest mb-1.5">{{ __('ui.total_price') }}</p>
                                            <p class="text-lg font-extrabold text-blue-600 dark:text-blue-400 leading-none">{{ currency($order->total_price) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[0.5rem] font-bold text-slate-400 uppercase tracking-widest mb-1.5">{{ __('ui.order_persons') }}</p>
                                            <p class="text-lg font-extrabold text-slate-900 dark:text-white leading-none">{{ $order->quantity }} {{ $order->vehicle_id ? __('ui.days') : __('ui.person') }}</p>
                                        </div>
                                        
                                        @if($order->tripSchedule)
                                        <div class="col-span-2 bg-blue-50/50 dark:bg-blue-900/10 p-4 rounded-2xl border border-blue-100/50 dark:border-blue-800/30">
                                            <p class="text-[0.5rem] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-2">🚀 {{ __('ui.driver_info') }} ({{ $order->tripSchedule->status_label }})</p>
                                            <div class="flex items-center justify-between gap-3">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-900 dark:text-white uppercase">{{ $order->tripSchedule->driver_name ?? 'Driver Menunggu' }}</p>
                                                    @if($order->tripSchedule->vehicle)
                                                        <p class="text-xs text-slate-500 font-medium">{{ $order->tripSchedule->vehicle->name }} - {{ $order->tripSchedule->vehicle->license_plate ?? $order->tripSchedule->vehicle->plate_number }}</p>
                                                    @endif
                                                </div>
                                                @if($order->tripSchedule->driver_phone)
                                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $order->tripSchedule->driver_phone) }}" target="_blank" class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm group/wa">
                                                    <i class="fab fa-whatsapp text-sm group-hover/wa:scale-110 transition-transform"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        @elseif($order->rentalSchedule)
                                        <div class="col-span-2 bg-indigo-50/50 dark:bg-indigo-900/10 p-4 rounded-2xl border border-indigo-100/50 dark:border-indigo-800/30">
                                            <p class="text-[0.5rem] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-2">🚗 JADWAL RENTAL ({{ $order->rentalSchedule->status_label }})</p>
                                            <div class="flex items-center justify-between gap-3">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-900 dark:text-white uppercase">{{ $order->rentalSchedule->carRental->name ?? 'Mobil Rental' }}</p>
                                                    <p class="text-xs text-slate-500 font-medium">{{ $order->rentalSchedule->start_date->format('d M') }} s/d {{ $order->rentalSchedule->end_date->format('d M Y') }}</p>
                                                </div>
                                                <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-[0.5rem] font-bold uppercase">{{ $order->rentalSchedule->rental_days }} Hari</span>
                                            </div>
                                        </div>
                                        @elseif($order->packageRentalSchedule)
                                        <div class="col-span-2 bg-violet-50/50 dark:bg-violet-900/10 p-4 rounded-2xl border border-violet-100/50 dark:border-violet-800/30">
                                            <p class="text-[0.5rem] font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest mb-2">📦 JADWAL PAKET RENTAL ({{ $order->packageRentalSchedule->status_label }})</p>
                                            <div class="flex items-center justify-between gap-3">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-900 dark:text-white uppercase">{{ $order->packageRentalSchedule->rentalPackage->name ?? 'Paket Rental' }}</p>
                                                    <p class="text-xs text-slate-500 font-medium">{{ $order->packageRentalSchedule->start_date->format('d M') }} s/d {{ $order->packageRentalSchedule->end_date->format('d M Y') }}</p>
                                                </div>
                                                <span class="px-2 py-0.5 bg-violet-100 text-violet-700 rounded text-[0.5rem] font-bold uppercase">{{ $order->packageRentalSchedule->rental_days }} Hari</span>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-span-2">
                                            <p class="text-[0.5rem] font-bold text-slate-400 uppercase tracking-widest mb-1.5">🚀 {{ __('ui.driver_info') }}</p>
                                            <p class="text-xs text-slate-400">{{ __('ui.no_driver_yet') }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    @if($order->hotel_1 || $order->hotel_2)
                                    <div class="mt-6 flex flex-wrap gap-2">
                                        @for($i=1; $i<=4; $i++)
                                            @php $h = "hotel_$i"; @endphp
                                            @if($order->$h)
                                            <span class="px-3 py-1 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg text-xs font-bold text-slate-500 uppercase tracking-wider">
                                                <i class="fas fa-hotel mr-1 text-blue-500"></i> H{{ $i }}: {{ $order->$h }}
                                            </span>
                                            @endif
                                        @endfor
                                    </div>
                                    @endif
                                </div>

                                <!-- Actions Side -->
                                <div class="bg-slate-50/50 dark:bg-slate-900/50 p-8 md:w-64 flex flex-col justify-center gap-3 border-l border-slate-100 dark:border-slate-800">
                                    <h4 class="text-[0.5rem] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2 px-2 text-center">Tindakan Cepat</h4>
                                    
                                    <a href="{{ route('order.invoice', $order->id) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-600 hover:text-white transition-all shadow-lg shadow-slate-900/10 active:scale-95">
                                        <i class="fas fa-file-invoice-dollar text-sm"></i>
                                        {{ __('ui.invoice') }} (PDF)
                                    </a>

                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '6281298622143')) }}?text={{ urlencode('Halo Admin NorthSumateraTrip, saya ingin konfirmasi/tanya tentang Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}" 
                                       target="_blank"
                                       class="flex items-center justify-center gap-2 w-full py-3.5 bg-white dark:bg-slate-800 text-emerald-600 border border-emerald-100 dark:border-emerald-900 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-600 hover:text-white transition-all shadow-sm active:scale-95">
                                        <i class="fab fa-whatsapp text-sm"></i>
                                        Hubungi Admin
                                    </a>

                                    @if($order->status == 'pending' && \App\Models\Setting::get('qris_image'))
                                    <button x-data x-on:click="$dispatch('open-payment-modal')" class="flex items-center justify-center gap-2 w-full py-3 bg-blue-50 text-blue-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-100 transition-all border border-blue-100">
                                        <i class="fas fa-qrcode text-xs"></i>
                                        Cara Bayar
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-32 text-center bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-8">
                            <i class="fas fa-suitcase-rolling text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2 tracking-wider">{{ __('ui.no_orders') }}</h3>
                        <p class="text-slate-400 mb-10">{{ __('ui.packages_sub') }}</p>
                        <a href="{{ route('packages') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-900 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                            {{ __('ui.view_all_packages') }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- Payment Modal (QRIS) -->
<div x-data="{ open: false }" x-on:open-payment-modal.window="open = true" x-show="open" x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
    <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" x-on:click="open = false"></div>
    <div class="relative bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-md w-full shadow-2xl border border-slate-100 dark:border-slate-800"
         x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
        <button x-on:click="open = false" class="absolute top-5 right-5 w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="text-center">
            <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-5 text-blue-600">
                <i class="fas fa-qrcode text-2xl"></i>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">Cara Pembayaran</h3>
            <p class="text-slate-500 text-sm mb-8">Scan QRIS berikut untuk melakukan pembayaran</p>
            @if(\App\Models\Setting::get('qris_image'))
            <div class="bg-white p-4 rounded-2xl border border-slate-100 inline-block mb-6">
                <img src="{{ asset('storage/' . \App\Models\Setting::get('qris_image')) }}" alt="QRIS Payment" class="w-56 h-56 object-contain">
            </div>
            @endif
            @if(\App\Models\Setting::get('bank_name'))
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 text-left space-y-3 mt-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Transfer Bank</p>
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">Bank</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('bank_name') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">No. Rekening</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('bank_account_number') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">Atas Nama</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ \App\Models\Setting::get('bank_account_name') }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
