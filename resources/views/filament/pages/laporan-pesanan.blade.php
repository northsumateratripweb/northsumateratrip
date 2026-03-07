<x-filament-panels::page>
    {{-- ─── HEADER FILTERS ──────────────────────────────────────── --}}
    <div class="flex flex-wrap gap-4 items-end mb-6 p-4 bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tahun</label>
            <select wire:model.live="selectedYear"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring-2 focus:ring-blue-500">
                @foreach($this->getAvailableYears() as $yr)
                    <option value="{{ $yr }}">{{ $yr }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bulan</label>
            <select wire:model.live="selectedMonth"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:ring-2 focus:ring-blue-500">
                <option value="">— Semua Bulan —</option>
                @php
                $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                              7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                @endphp
                @foreach($namaBulan as $num => $nama)
                    <option value="{{ $num }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Download Buttons --}}
        <div class="flex gap-2 ml-auto flex-wrap items-center">
            <button wire:click="$set('showImportForm', !$showImportForm)"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import CSV Trip
            </button>
            <a href="{{ route('laporan.pesanan.csv', ['tahun' => $selectedYear, 'bulan' => $selectedMonth]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold transition">
                <x-heroicon-o-document-text class="w-4 h-4"/>
                CSV {{ $selectedMonth ? 'Bulan Ini' : 'Tahunan' }}
            </a>
            <a href="{{ route('laporan.pesanan.excel', ['tahun' => $selectedYear, 'bulan' => $selectedMonth]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition">
                <x-heroicon-o-table-cells class="w-4 h-4"/>
                Excel {{ $selectedMonth ? 'Bulan Ini' : 'Tahunan' }}
            </a>
        </div>
    </div>

    {{-- ─── IMPORT CSV FORM ─────────────────────────────────────── --}}
    @if($showImportForm)
    <div class="mb-6 p-5 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-xl">
        <h3 class="font-bold text-purple-700 dark:text-purple-300 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Import Data Trip dari CSV
        </h3>
        <p class="text-sm text-purple-600 dark:text-purple-400 mb-4">
            Upload file CSV dengan format kolom: <strong>Tanggal, Nama Pelanggan, Status, Nomor HP, Nama Driver, Layanan, Plat Mobil, Jenis Mobil, Drone, Jumlah Hari, Penumpang, Hotel 1-4, Harga, Deposit, Pelunasan, Tiba, Flight Balik</strong>
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-400 block mb-1">Bulan Data</label>
                <select wire:model="importBulan" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm">
                    @foreach($namaBulan as $num => $nama)
                        <option value="{{ $num }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-400 block mb-1">Tahun Data</label>
                <select wire:model="importTahun" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm">
                    @foreach(range(now()->year, now()->year - 4) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-400 block mb-1">File CSV</label>
                <input type="file" wire:model="importFile" accept=".csv,.txt"
                       class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                <div wire:loading wire:target="importFile" class="text-xs text-purple-500 mt-1">Mengupload...</div>
            </div>
        </div>
        <div class="mt-4 flex gap-3">
            <button wire:click="importCsv" wire:loading.attr="disabled"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 disabled:opacity-50 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2">
                <div wire:loading wire:target="importCsv" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                Proses Import
            </button>
            <button wire:click="$set('showImportForm', false)"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-semibold transition">
                Batal
            </button>
        </div>
    </div>
    @endif

    {{-- ─── STATS CARDS ─────────────────────────────────────────── --}}
    @php
        $monthly = $this->getMonthlyStats();
        $yearly  = $this->getYearlyStats();
        $namaBulanLabel = $namaBulan[$selectedMonth] ?? 'Bulan Ini';
    @endphp

    {{-- Monthly Stats - Orders from System --}}
    <div class="mb-2">
        <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
            📅 Ringkasan {{ $selectedMonth ? $namaBulanLabel . ' ' . $selectedYear : 'Semua Bulan ' . $selectedYear }}
        </h2>

        {{-- System Orders --}}
        <p class="text-xs uppercase tracking-widest text-blue-500 font-bold mb-2">📲 Pesanan Website</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-4">
            @php
                $statCards = [
                    ['label' => 'Total Pesanan', 'value' => $monthly['total'], 'icon' => '📋', 'color' => 'blue'],
                    ['label' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($monthly['revenue'],0,',','.'), 'icon' => '💰', 'color' => 'green'],
                    ['label' => 'Paket Wisata', 'value' => $monthly['tour'], 'icon' => '🏔️', 'color' => 'indigo'],
                    ['label' => 'Paket Rental', 'value' => $monthly['rental'], 'icon' => '🗺️', 'color' => 'purple'],
                    ['label' => 'Rental Mobil', 'value' => $monthly['car'], 'icon' => '🚗', 'color' => 'orange'],
                ];
            @endphp
            @foreach($statCards as $card)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow border border-gray-100 dark:border-gray-700 flex flex-col gap-1">
                <span class="text-2xl">{{ $card['icon'] }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $card['label'] }}</span>
                <span class="text-xl font-bold text-gray-800 dark:text-white">{{ $card['value'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- CSV Import Stats --}}
        @if($monthly['csv_total'] > 0)
        <p class="text-xs uppercase tracking-widest text-purple-500 font-bold mb-2">📂 Data Impor CSV</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-100 dark:border-purple-800 flex flex-col gap-1">
                <span class="text-2xl">📂</span>
                <span class="text-xs text-purple-500">Total Data CSV</span>
                <span class="text-xl font-bold text-purple-700 dark:text-purple-300">{{ $monthly['csv_total'] }}</span>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-100 dark:border-purple-800 flex flex-col gap-1">
                <span class="text-2xl">💵</span>
                <span class="text-xs text-purple-500">Total Harga CSV</span>
                <span class="text-xl font-bold text-purple-700 dark:text-purple-300">Rp {{ number_format($monthly['csv_revenue'],0,',','.') }}</span>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-100 dark:border-purple-800 flex flex-col gap-1">
                <span class="text-2xl">🏔️</span>
                <span class="text-xs text-purple-500">Paket Trip (CSV)</span>
                <span class="text-xl font-bold text-purple-700 dark:text-purple-300">{{ $monthly['csv_paket_trip'] }}</span>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-100 dark:border-purple-800 flex flex-col gap-1">
                <span class="text-2xl">🚗</span>
                <span class="text-xs text-purple-500">Sewa Mobil (CSV)</span>
                <span class="text-xl font-bold text-purple-700 dark:text-purple-300">{{ $monthly['csv_sewa_mobil'] }}</span>
            </div>
        </div>
        @endif

        {{-- Status breakdown --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
            @php
                $statusCards = [
                    ['label' => 'Pending', 'value' => $monthly['pending'], 'color' => 'text-yellow-600 dark:text-yellow-400', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20'],
                    ['label' => 'Dikonfirmasi', 'value' => $monthly['confirmed'], 'color' => 'text-blue-600 dark:text-blue-400', 'bg' => 'bg-blue-50 dark:bg-blue-900/20'],
                    ['label' => 'Selesai', 'value' => $monthly['completed'], 'color' => 'text-green-600 dark:text-green-400', 'bg' => 'bg-green-50 dark:bg-green-900/20'],
                    ['label' => 'Dibatalkan', 'value' => $monthly['cancelled'], 'color' => 'text-red-600 dark:text-red-400', 'bg' => 'bg-red-50 dark:bg-red-900/20'],
                ];
            @endphp
            @foreach($statusCards as $s)
            <div class="rounded-xl p-3 shadow border border-gray-100 dark:border-gray-700 {{ $s['bg'] }} flex items-center gap-3">
                <span class="text-2xl font-black {{ $s['color'] }}">{{ $s['value'] }}</span>
                <span class="text-xs {{ $s['color'] }} font-semibold">{{ $s['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Yearly Summary --}}
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl text-white shadow-lg">
        <h2 class="text-sm font-bold uppercase tracking-wider mb-3 opacity-80">📊 Ringkasan Tahunan {{ $selectedYear }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4">
            <div><div class="text-2xl font-black">{{ $yearly['total'] }}</div><div class="text-xs opacity-75">Pesanan Web</div></div>
            <div><div class="text-lg font-black">Rp {{ number_format($yearly['revenue'],0,',','.') }}</div><div class="text-xs opacity-75">Pendapatan Web</div></div>
            <div><div class="text-2xl font-black">{{ $yearly['tour'] }}</div><div class="text-xs opacity-75">Paket Wisata</div></div>
            <div><div class="text-2xl font-black">{{ $yearly['rental'] }}</div><div class="text-xs opacity-75">Paket Rental</div></div>
            <div><div class="text-2xl font-black">{{ $yearly['car'] }}</div><div class="text-xs opacity-75">Rental Mobil</div></div>
            <div><div class="text-2xl font-black">{{ $yearly['csv_total'] }}</div><div class="text-xs opacity-75">Data CSV</div></div>
            <div><div class="text-base font-black">Rp {{ number_format($yearly['csv_revenue'],0,',','.') }}</div><div class="text-xs opacity-75">Harga CSV</div></div>
        </div>
    </div>

    {{-- ─── MONTHLY CHART ───────────────────────────────────────── --}}
    @php $chartData = $this->getMonthlyChartData(); @endphp
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 mb-6">
        <h3 class="font-bold text-gray-700 dark:text-gray-200 mb-4">📈 Grafik Pesanan Per Bulan — {{ $selectedYear }}</h3>
        <div class="flex items-end gap-1 h-44 overflow-x-auto">
            @php
                $maxTotal = max(array_column($chartData, 'total')) ?: 1;
            @endphp
            @foreach($chartData as $index => $row)
            <div class="flex flex-col items-center gap-1 flex-1 min-w-[40px]">
                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400">{{ $row['total'] ?: '' }}</span>
                <div class="w-full flex flex-col-reverse gap-0.5">
                    <div class="w-full rounded-t-sm transition-all duration-500 {{ ($selectedMonth && (int)$selectedMonth === ($index+1)) ? 'bg-blue-500' : 'bg-blue-300 dark:bg-blue-600' }}"
                         style="height: {{ max(2, ($row['orders'] / $maxTotal) * 140) }}px"
                         title="{{ $row['month'] }}: {{ $row['orders'] }} pesanan web"></div>
                    @if($row['csv_orders'] > 0)
                    <div class="w-full rounded-t-sm bg-purple-400 dark:bg-purple-500 transition-all duration-500"
                         style="height: {{ max(2, ($row['csv_orders'] / $maxTotal) * 140) }}px"
                         title="{{ $row['month'] }}: {{ $row['csv_orders'] }} data CSV"></div>
                    @endif
                </div>
                <span class="text-[9px] text-gray-500 dark:text-gray-400 text-center leading-tight">{{ substr($row['month'], 0, 3) }}</span>
            </div>
            @endforeach
        </div>
        <div class="flex gap-4 mt-3 text-xs text-gray-400">
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-300 dark:bg-blue-600 inline-block"></span> Pesanan Website</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-purple-400 dark:bg-purple-500 inline-block"></span> Data CSV Import</span>
        </div>
    </div>

    {{-- ─── ORDERS TABLE (Website) ───────────────────────────────── --}}
    @php $orders = $this->getOrdersData(); @endphp
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
            <h3 class="font-bold text-gray-700 dark:text-gray-200">
                📲 Pesanan Website —
                {{ $selectedMonth ? ($namaBulan[$selectedMonth] ?? $selectedMonth) . ' ' . $selectedYear : 'Semua ' . $selectedYear }}
            </h3>
            <span class="ml-auto text-sm text-gray-400">{{ $orders->count() }} pesanan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Tgl Pesan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">ID Transaksi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Tipe</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Tgl Trip</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Total (IDR)</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Bayar</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($orders as $i => $order)
                    @php
                        if ($order->vehicle_id)          $tipe = ['label' => 'Rental Mobil', 'class' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300'];
                        elseif ($order->rental_package_id) $tipe = ['label' => 'Paket Rental', 'class' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'];
                        else                              $tipe = ['label' => 'Paket Wisata', 'class' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'];
                        $statusClass = match($order->status) {
                            'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300',
                            'confirmed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                            'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                            'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                            default     => 'bg-gray-100 text-gray-700',
                        };
                        $statusLabel = match($order->status) {
                            'pending'   => 'Pending', 'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
                            default     => ucfirst($order->status),
                        };
                        $payClass = match($order->payment_status) {
                            'paid'    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                            'partial' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                            default   => 'bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400',
                        };
                        $payLabel = match($order->payment_status) {
                            'paid' => 'Lunas', 'partial' => 'DP', default => 'Belum',
                        };
                        $item = $order->vehicle?->name ?? $order->rentalPackage?->name ?? $order->product?->name ?? '-';
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 whitespace-nowrap text-xs">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3"><span class="font-mono text-xs text-blue-600 dark:text-blue-400">{{ $order->transaction_id ?? '-' }}</span></td>
                        <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $tipe['class'] }}">{{ $tipe['label'] }}</span></td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-200 max-w-[200px] truncate" title="{{ $item }}">{{ $item }}</td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $order->customer_name }}</div>
                            <div class="text-xs text-gray-400">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300 whitespace-nowrap text-xs">
                            {{ $order->trip_date?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800 dark:text-gray-100 whitespace-nowrap">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ $statusLabel }}</span></td>
                        <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $payClass }}">{{ $payLabel }}</span></td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ url('/admin/orders/' . $order->id . '/edit') }}"
                               class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 text-xs hover:bg-blue-200 transition">
                                <x-heroicon-m-pencil class="w-3 h-3"/> Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-10 text-center text-gray-400">
                            <div class="text-3xl mb-2">📭</div>
                            <div>Tidak ada pesanan untuk periode ini.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($orders->count() > 0)
                <tfoot class="bg-gray-50 dark:bg-gray-700/40">
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-right text-sm font-bold text-gray-600 dark:text-gray-300">Total Pendapatan (non-cancelled):</td>
                        <td class="px-4 py-3 text-right font-bold text-green-600 dark:text-green-400 text-sm">
                            Rp {{ number_format($orders->where('status','!=','cancelled')->sum('total_price'), 0, ',', '.') }}
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- ─── CSV IMPORT TABLE ─────────────────────────────────────── --}}
    @php $tripImports = $this->getTripImportData(); @endphp
    @if($tripImports->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-purple-100 dark:border-purple-800 overflow-hidden">
        <div class="p-4 border-b border-purple-100 dark:border-purple-800 bg-purple-50 dark:bg-purple-900/20 flex items-center gap-3">
            <h3 class="font-bold text-purple-700 dark:text-purple-300">
                📂 Data Trip CSV —
                {{ $selectedMonth ? ($namaBulan[$selectedMonth] ?? $selectedMonth) . ' ' . $selectedYear : 'Semua ' . $selectedYear }}
            </h3>
            <span class="ml-auto text-sm text-purple-400">{{ $tripImports->count() }} data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-purple-50 dark:bg-purple-900/30">
                    <tr>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">No</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Tanggal</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Pelanggan</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">HP</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Layanan</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Driver</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Mobil</th>
                        <th class="px-3 py-2.5 text-center text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Hari</th>
                        <th class="px-3 py-2.5 text-center text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Drone</th>
                        <th class="px-3 py-2.5 text-right text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Harga</th>
                        <th class="px-3 py-2.5 text-right text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Deposit</th>
                        <th class="px-3 py-2.5 text-right text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase whitespace-nowrap">Pelunasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50 dark:divide-purple-900/30">
                    @foreach($tripImports as $i => $trip)
                    <tr class="hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-colors">
                        <td class="px-3 py-2 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-3 py-2 text-gray-700 dark:text-gray-200 whitespace-nowrap text-xs">
                            {{ $trip->tanggal ? $trip->tanggal->format('d M Y') : '-' }}
                        </td>
                        <td class="px-3 py-2">
                            <div class="font-medium text-gray-800 dark:text-gray-100 text-sm">{{ $trip->nama_pelanggan ?? '-' }}</div>
                            @if($trip->status)<div class="text-xs text-gray-400">{{ $trip->status }}</div>@endif
                        </td>
                        <td class="px-3 py-2 text-xs text-gray-500">{{ $trip->nomor_hp ?? '-' }}</td>
                        <td class="px-3 py-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ str_contains($trip->layanan ?? '', 'Trip') ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $trip->layanan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-300">{{ $trip->nama_driver ?? '-' }}</td>
                        <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-300">
                            {{ $trip->jenis_mobil ?? $trip->plat_mobil ?? '-' }}
                        </td>
                        <td class="px-3 py-2 text-center text-xs font-bold text-gray-700 dark:text-gray-200">{{ $trip->jumlah_hari ?? 1 }}</td>
                        <td class="px-3 py-2 text-center">
                            @if($trip->drone)
                                <span class="text-green-600 font-bold text-xs">✓</span>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right font-semibold text-gray-800 dark:text-gray-100 whitespace-nowrap text-xs">
                            {{ $trip->harga > 0 ? 'Rp ' . number_format($trip->harga, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-3 py-2 text-right text-xs text-gray-500 whitespace-nowrap">
                            {{ $trip->deposit > 0 ? 'Rp ' . number_format($trip->deposit, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-3 py-2 text-right text-xs text-gray-500 whitespace-nowrap">
                            {{ $trip->pelunasan > 0 ? 'Rp ' . number_format($trip->pelunasan, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-purple-50 dark:bg-purple-900/30">
                    <tr>
                        <td colspan="9" class="px-3 py-3 text-right text-sm font-bold text-purple-700 dark:text-purple-300">Total:</td>
                        <td class="px-3 py-3 text-right font-bold text-purple-700 dark:text-purple-300 text-sm">Rp {{ number_format($tripImports->sum('harga'),0,',','.') }}</td>
                        <td class="px-3 py-3 text-right font-bold text-purple-600 dark:text-purple-400 text-xs">Rp {{ number_format($tripImports->sum('deposit'),0,',','.') }}</td>
                        <td class="px-3 py-3 text-right font-bold text-purple-600 dark:text-purple-400 text-xs">Rp {{ number_format($tripImports->sum('pelunasan'),0,',','.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @else
    <div class="bg-purple-50 dark:bg-purple-900/10 border border-dashed border-purple-200 dark:border-purple-800 rounded-xl p-8 text-center">
        <div class="text-4xl mb-3">📂</div>
        <h4 class="font-bold text-purple-600 dark:text-purple-300 mb-1">Belum ada data CSV</h4>
        <p class="text-sm text-gray-500">Klik tombol <strong>Import CSV Trip</strong> di atas untuk mengupload file dari Google Sheets/Excel.</p>
    </div>
    @endif

</x-filament-panels::page>
