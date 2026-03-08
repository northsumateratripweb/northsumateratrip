@extends('layouts.main')

@section('title', 'Cek Status Pesanan - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))

@section('content')
<section class="pt-32 pb-16 bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight">Cek Status Pesanan</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-3 text-lg">Masukkan Order ID dan nomor telepon Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/40 rounded-2xl p-8 mb-8 text-center">
                <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-3">Berhasil!</h2>
                <p class="text-slate-600 dark:text-slate-400 font-medium mb-6">{{ session('success') }}</p>
                
                @if(session('whatsapp_url'))
                <a href="{{ session('whatsapp_url') }}" target="_blank" class="inline-flex items-center gap-3 px-7 py-3.5 bg-[#25D366] hover:bg-[#1fb355] text-white font-bold rounded-xl transition-all shadow-lg shadow-[#25D366]/20 uppercase tracking-wider text-xs">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.038 3.284l-.569 2.1c-.123.446.251.846.684.733l2.047-.524c.974.51 2.013.788 3.087.77h.003c3.181 0 5.766-2.587 5.767-5.766 0-3.18-2.585-5.763-5.767-5.763zm3.845 8.167c-.12.336-.595.617-.912.658-.27.035-.624.062-1.01-.061-.24-.077-.549-.196-1.571-.621-1.422-.593-2.339-2.035-2.41-2.127-.071-.092-.571-.759-.571-1.44s.355-1.016.483-1.152c.127-.136.279-.17.372-.17.093 0 .186.001.267.005.085.004.2.034.303.28.106.253.364.887.395.952.032.065.053.14.01.226-.042.086-.064.14-.127.213-.064.073-.134.163-.191.219-.064.063-.131.131-.057.258.074.127.329.544.706.88.485.433.896.567 1.023.63.127.063.2.053.274-.034.074-.087.316-.371.4-.499.085-.128.17-.107.286-.064.117.043.742.349.87.414.127.065.213.097.245.151.033.054.033.31-.087.646z"/></svg>
                    Konfirmasi via WhatsApp
                </a>
                @endif
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form method="POST" action="{{ route('booking.check') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Order ID</label>
                    <input type="text" name="order_id" value="{{ request('order_id') }}" required class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ request('phone') }}" required class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all" placeholder="08xx...">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                    <i class="fas fa-search mr-2"></i> Cek Status
                </button>
            </form>
        </div>

        @if(isset($order))
        <div class="bg-white rounded-2xl shadow-lg p-8 mt-8" 
             x-data="{ 
                status: '{{ $order->status }}',
                statusLabel: '{{ $order->status_label ?? ucfirst($order->status) }}',
                polling: true,
                async checkStatus() {
                    if (['completed', 'cancelled'].includes(this.status)) {
                        this.polling = false;
                        return;
                    }
                    try {
                        let response = await fetch('{{ route('api.order.status', $order->id) }}?phone={{ $order->customer_phone }}');
                        let data = await response.json();
                        if (data.status) {
                            if (this.status !== data.status) {
                                this.status = data.status;
                                this.statusLabel = data.status_label;
                                // Optional logic to reload if significant changes occur (like trip schedule added)
                                if (data.has_trip_schedule) {
                                    window.location.reload();
                                }
                            }
                        }
                    } catch (e) { console.error('Polling error', e); }
                }
             }"
             x-init="setInterval(() => polling && checkStatus(), 10000)">
            <h2 class="text-xl font-bold mb-4 text-slate-800">📋 Detail Pesanan</h2>
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Order ID</span>
                    <span class="font-semibold">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Paket / Kendaraan</span>
                    <span class="font-semibold">{{ $order->product?->name ?? $order->vehicle?->name ?? '-' }}</span>
                </div> REPLACE
<<<<<<< SEARCH
                @if($order->tripSchedule->vehicle)
                <div class="flex justify-between border-b border-blue-100 pb-2">
                    <span class="text-blue-600 font-medium">Kendaraan</span>
                    <span class="font-semibold text-slate-800">{{ $order->tripSchedule->vehicle->name }} ({{ $order->tripSchedule->vehicle->license_plate ?? '-' }})</span>
                </div>
                @endif
=======
                @if($order->tripSchedule?->vehicle)
                <div class="flex justify-between border-b border-blue-100 pb-2">
                    <span class="text-blue-600 font-medium">Kendaraan</span>
                    <span class="font-semibold text-slate-800">{{ $order->tripSchedule->vehicle->name }} ({{ $order->tripSchedule->vehicle->license_plate ?? '-' }})</span>
                </div>
                @endif
                @if($order->notes)
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Catatan</span>
                    <span class="font-semibold text-right text-sm max-w-xs">{{ $order->notes }}</span>
                </div>
                @endif
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Tanggal Trip</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($order->trip_date)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Jumlah</span>
                    <span class="font-semibold">{{ $order->quantity }} {{ $order->vehicle_id ? 'hari' : 'orang' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Total</span>
                    <span class="font-bold text-green-600">{{ currency($order->total_price) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Status</span>
                    <span x-text="statusLabel"
                        :class="{
                            'bg-green-100 text-green-800': status === 'completed',
                            'bg-yellow-100 text-yellow-800': status === 'pending',
                            'bg-blue-100 text-blue-800': status === 'confirmed',
                            'bg-red-100 text-red-800': status === 'cancelled',
                            'bg-slate-50 text-slate-800': !['completed', 'pending', 'confirmed', 'cancelled'].includes(status)
                        }"
                        class="px-3 py-1 rounded-full text-sm font-semibold transition-all duration-500">
                    </span>
                </div>
            </div>
            
            <template x-if="polling">
                <div class="mt-4 flex items-center justify-center gap-2 text-[10px] text-slate-400">
                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                    Memantau status secara realtime...
                </div>
            </template>
        </div>

        {{-- Trip Schedule / Driver Info --}}
        @if($order->tripSchedule)
        <div class="bg-blue-50 border border-blue-100 rounded-2xl shadow-lg p-8 mt-6">
            <h2 class="text-xl font-bold mb-4 text-blue-800">🚗 Info Jadwal & Driver</h2>
            <div class="space-y-3">
                @if($order->tripSchedule->driver_name)
                <div class="flex justify-between border-b border-blue-100 pb-2">
                    <span class="text-blue-600 font-medium">Driver</span>
                    <span class="font-semibold text-slate-800">{{ $order->tripSchedule->driver_name }}</span>
                </div>
                @endif
                @if($order->tripSchedule->driver_phone)
                <div class="flex justify-between border-b border-blue-100 pb-2">
                    <span class="text-blue-600 font-medium">No. Driver</span>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $order->tripSchedule->driver_phone) }}" target="_blank" class="font-semibold text-green-600 hover:underline">
                        {{ $order->tripSchedule->driver_phone }}
                    </a>
                </div>
                @endif
                @if($order->tripSchedule->vehicle)
                <div class="flex justify-between border-b border-blue-100 pb-2">
                    <span class="text-blue-600 font-medium">Kendaraan</span>
                    <span class="font-semibold text-slate-800">{{ $order->tripSchedule->vehicle->name }} ({{ $order->tripSchedule->vehicle->license_plate ?? '-' }})</span>
                </div>
                @endif
                @if($order->tripSchedule->trip_date)
                <div class="flex justify-between border-b border-blue-100 pb-2">
                    <span class="text-blue-600 font-medium">Jadwal Keberangkatan</span>
                    <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($order->tripSchedule->trip_date)->format('d M Y, H:i') }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-blue-600 font-medium">Status Jadwal</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->tripSchedule->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->tripSchedule->status == 'ongoing') bg-yellow-100 text-yellow-800
                        @elseif($order->tripSchedule->status == 'scheduled') bg-blue-100 text-blue-800
                        @elseif($order->tripSchedule->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-slate-50 text-slate-800
                        @endif">
                        {{ $order->tripSchedule->status_label ?? ucfirst($order->tripSchedule->status) }}
                    </span>
                </div>
            </div>
        </div>
        @endif


        <div class="mt-6 text-center">
            <a href="{{ route('order.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors text-xs uppercase tracking-wider shadow-lg shadow-blue-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Download Invoice
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
