<x-filament-panels::page>
    {{-- ─── HEADER FILTERS ──────────────────────────────────────── --}}
    <div style="display:flex; flex-wrap:wrap; gap:1rem; align-items:flex-end; margin-bottom:1.5rem; padding:1rem; background:white; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,.1); border:1px solid #e5e7eb;">
        <div style="display:flex; flex-direction:column; gap:0.25rem;">
            <label style="font-size:0.7rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Tahun</label>
            <select wire:model.live="selectedYear"
                    style="border-radius:0.5rem; border:1px solid #d1d5db; background:white; padding:0.4rem 0.75rem; font-size:0.875rem;">
                @foreach($this->getAvailableYears() as $yr)
                    <option value="{{ $yr }}">{{ $yr }}</option>
                @endforeach
            </select>
        </div>

        <div style="display:flex; flex-direction:column; gap:0.25rem;">
            <label style="font-size:0.7rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Bulan</label>
            <select wire:model.live="selectedMonth"
                    style="border-radius:0.5rem; border:1px solid #d1d5db; background:white; padding:0.4rem 0.75rem; font-size:0.875rem;">
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
        <div style="display:flex; gap:0.5rem; margin-left:auto; flex-wrap:wrap; align-items:center;">
            <button wire:click="$set('showImportForm', !$showImportForm)"
                    style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.4rem 1rem; border-radius:0.5rem; background:#9333ea; color:white; font-size:0.875rem; font-weight:600; border:none; cursor:pointer;">
                <svg style="width:16px; height:16px; flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import CSV Trip
            </button>
            <a href="{{ route('laporan.pesanan.csv', ['tahun' => $selectedYear, 'bulan' => $selectedMonth]) }}"
               target="_blank"
               style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.4rem 1rem; border-radius:0.5rem; background:#4b5563; color:white; font-size:0.875rem; font-weight:600; text-decoration:none;">
                <svg style="width:16px; height:16px; flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                CSV {{ $selectedMonth ? 'Bulan Ini' : 'Tahunan' }}
            </a>
            <a href="{{ route('laporan.pesanan.excel', ['tahun' => $selectedYear, 'bulan' => $selectedMonth]) }}"
               target="_blank"
               style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.4rem 1rem; border-radius:0.5rem; background:#16a34a; color:white; font-size:0.875rem; font-weight:600; text-decoration:none;">
                <svg style="width:16px; height:16px; flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
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
    <div style="margin-bottom:0.5rem;">
        <h2 style="font-size:0.75rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:0.75rem;">
            📅 Ringkasan {{ $selectedMonth ? $namaBulanLabel . ' ' . $selectedYear : 'Semua Bulan ' . $selectedYear }}
        </h2>

        {{-- System Orders --}}
        <p style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:#3b82f6; font-weight:700; margin-bottom:0.5rem;">📲 Pesanan Website</p>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:0.75rem; margin-bottom:1rem;">
            @php
                $statCards = [
                    ['label' => 'Total Pesanan', 'value' => $monthly['total'], 'icon' => '📋'],
                    ['label' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($monthly['revenue'],0,',','.'), 'icon' => '💰'],
                    ['label' => 'Paket Wisata', 'value' => $monthly['tour'], 'icon' => '🏔️'],
                    ['label' => 'Paket Rental', 'value' => $monthly['rental'], 'icon' => '🗺️'],
                    ['label' => 'Rental Mobil', 'value' => $monthly['car'], 'icon' => '🚗'],
                ];
            @endphp
            @foreach($statCards as $card)
            <div style="background:white; border-radius:0.75rem; padding:1rem; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #f3f4f6; display:flex; flex-direction:column; gap:0.25rem;">
                <span style="font-size:1.5rem;">{{ $card['icon'] }}</span>
                <span style="font-size:0.72rem; color:#6b7280;">{{ $card['label'] }}</span>
                <span style="font-size:1.25rem; font-weight:800; color:#111827;">{{ $card['value'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- CSV Import Stats --}}
        @if($monthly['csv_total'] > 0)
        <p style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:#9333ea; font-weight:700; margin-bottom:0.5rem;">📂 Data Impor CSV</p>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:0.75rem; margin-bottom:1rem;">
            <div style="background:#faf5ff; border-radius:0.75rem; padding:1rem; border:1px solid #e9d5ff; display:flex; flex-direction:column; gap:0.25rem;">
                <span style="font-size:1.5rem;">📂</span>
                <span style="font-size:0.72rem; color:#9333ea;">Total Data CSV</span>
                <span style="font-size:1.25rem; font-weight:800; color:#7e22ce;">{{ $monthly['csv_total'] }}</span>
            </div>
            <div style="background:#faf5ff; border-radius:0.75rem; padding:1rem; border:1px solid #e9d5ff; display:flex; flex-direction:column; gap:0.25rem;">
                <span style="font-size:1.5rem;">💵</span>
                <span style="font-size:0.72rem; color:#9333ea;">Total Harga CSV</span>
                <span style="font-size:1.25rem; font-weight:800; color:#7e22ce;">Rp {{ number_format($monthly['csv_revenue'],0,',','.') }}</span>
            </div>
            <div style="background:#faf5ff; border-radius:0.75rem; padding:1rem; border:1px solid #e9d5ff; display:flex; flex-direction:column; gap:0.25rem;">
                <span style="font-size:1.5rem;">🏔️</span>
                <span style="font-size:0.72rem; color:#9333ea;">Paket Trip (CSV)</span>
                <span style="font-size:1.25rem; font-weight:800; color:#7e22ce;">{{ $monthly['csv_paket_trip'] }}</span>
            </div>
            <div style="background:#faf5ff; border-radius:0.75rem; padding:1rem; border:1px solid #e9d5ff; display:flex; flex-direction:column; gap:0.25rem;">
                <span style="font-size:1.5rem;">🚗</span>
                <span style="font-size:0.72rem; color:#9333ea;">Sewa Mobil (CSV)</span>
                <span style="font-size:1.25rem; font-weight:800; color:#7e22ce;">{{ $monthly['csv_sewa_mobil'] }}</span>
            </div>
        </div>
        @endif

        {{-- Status breakdown --}}
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:0.75rem; margin-bottom:1.5rem;">
            @php
                $statusCards = [
                    ['label' => 'Pending',      'value' => $monthly['pending'],   'color' => '#b45309', 'bg' => '#fffbeb', 'border' => '#fde68a'],
                    ['label' => 'Dikonfirmasi', 'value' => $monthly['confirmed'], 'color' => '#1d4ed8', 'bg' => '#eff6ff', 'border' => '#bfdbfe'],
                    ['label' => 'Selesai',      'value' => $monthly['completed'], 'color' => '#15803d', 'bg' => '#f0fdf4', 'border' => '#bbf7d0'],
                    ['label' => 'Dibatalkan',   'value' => $monthly['cancelled'], 'color' => '#b91c1c', 'bg' => '#fef2f2', 'border' => '#fecaca'],
                ];
            @endphp
            @foreach($statusCards as $s)
            <div style="border-radius:0.75rem; padding:0.75rem 1rem; border:1px solid {{ $s['border'] }}; background:{{ $s['bg'] }}; display:flex; align-items:center; gap:0.75rem;">
                <span style="font-size:1.6rem; font-weight:800; color:{{ $s['color'] }};">{{ $s['value'] }}</span>
                <span style="font-size:0.78rem; font-weight:600; color:{{ $s['color'] }};">{{ $s['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Yearly Summary --}}
    <div style="margin-bottom:1.5rem; padding:1.25rem 1.5rem; background:linear-gradient(135deg, #1e40af, #4f46e5); border-radius:0.75rem; color:white; box-shadow:0 4px 16px rgba(30,64,175,.25);">
        <h2 style="font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:0.07em; margin-bottom:0.85rem; opacity:0.8;">📊 Ringkasan Tahunan {{ $selectedYear }}</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(130px, 1fr)); gap:1rem;">
            <div><div style="font-size:1.5rem; font-weight:800;">{{ $yearly['total'] }}</div><div style="font-size:0.75rem; opacity:0.75;">Pesanan Web</div></div>
            <div><div style="font-size:1rem; font-weight:800;">Rp {{ number_format($yearly['revenue'],0,',','.') }}</div><div style="font-size:0.75rem; opacity:0.75;">Pendapatan Web</div></div>
            <div><div style="font-size:1.5rem; font-weight:800;">{{ $yearly['tour'] }}</div><div style="font-size:0.75rem; opacity:0.75;">Paket Wisata</div></div>
            <div><div style="font-size:1.5rem; font-weight:800;">{{ $yearly['rental'] }}</div><div style="font-size:0.75rem; opacity:0.75;">Paket Rental</div></div>
            <div><div style="font-size:1.5rem; font-weight:800;">{{ $yearly['car'] }}</div><div style="font-size:0.75rem; opacity:0.75;">Rental Mobil</div></div>
            <div><div style="font-size:1.5rem; font-weight:800;">{{ $yearly['csv_total'] }}</div><div style="font-size:0.75rem; opacity:0.75;">Data CSV</div></div>
            <div><div style="font-size:1rem; font-weight:800;">Rp {{ number_format($yearly['csv_revenue'],0,',','.') }}</div><div style="font-size:0.75rem; opacity:0.75;">Harga CSV</div></div>
        </div>
    </div>

    {{-- ─── MONTHLY CHART ───────────────────────────────────────── --}}
    @php $chartData = $this->getMonthlyChartData(); @endphp
    <div style="background:white; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #f3f4f6; padding:1.25rem; margin-bottom:1.5rem;">
        <h3 style="font-weight:700; color:#374151; margin-bottom:1rem;">📈 Grafik Pesanan Per Bulan — {{ $selectedYear }}</h3>
        <div style="display:flex; align-items:flex-end; gap:4px; height:160px; overflow-x:auto;">
            @php
                $maxTotal = max(array_column($chartData, 'total')) ?: 1;
            @endphp
            @foreach($chartData as $index => $row)
            <div style="display:flex; flex-direction:column; align-items:center; gap:4px; flex:1; min-width:40px;">
                <span style="font-size:10px; font-weight:700; color:#2563eb;">{{ $row['total'] ?: '' }}</span>
                <div style="width:100%; display:flex; flex-direction:column-reverse; gap:2px;">
                    <div style="width:100%; border-radius:2px 2px 0 0; background:{{ ($selectedMonth && (int)$selectedMonth === ($index+1)) ? '#3b82f6' : '#93c5fd' }}; height:{{ max(2, ($row['orders'] / $maxTotal) * 140) }}px;"
                         title="{{ $row['month'] }}: {{ $row['orders'] }} pesanan web"></div>
                    @if($row['csv_orders'] > 0)
                    <div style="width:100%; border-radius:2px 2px 0 0; background:#c084fc; height:{{ max(2, ($row['csv_orders'] / $maxTotal) * 140) }}px;"
                         title="{{ $row['month'] }}: {{ $row['csv_orders'] }} data CSV"></div>
                    @endif
                </div>
                <span style="font-size:9px; color:#9ca3af; text-align:center;">{{ substr($row['month'], 0, 3) }}</span>
            </div>
            @endforeach
        </div>
        <div style="display:flex; gap:1rem; margin-top:0.75rem; font-size:0.75rem; color:#9ca3af;">
            <span style="display:flex; align-items:center; gap:4px;"><span style="width:12px; height:12px; border-radius:3px; background:#93c5fd; display:inline-block;"></span> Pesanan Website</span>
            <span style="display:flex; align-items:center; gap:4px;"><span style="width:12px; height:12px; border-radius:3px; background:#c084fc; display:inline-block;"></span> Data CSV Import</span>
        </div>
    </div>

    {{-- ─── ORDERS TABLE (Website) ───────────────────────────────── --}}
    @php $orders = $this->getOrdersData(); @endphp
    <div style="background:white; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #f3f4f6; overflow:hidden; margin-bottom:1.5rem;">
        <div style="padding:1rem; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; gap:0.75rem;">
            <h3 style="font-weight:700; color:#374151; margin:0;">
                📲 Pesanan Website —
                {{ $selectedMonth ? ($namaBulan[$selectedMonth] ?? $selectedMonth) . ' ' . $selectedYear : 'Semua ' . $selectedYear }}
            </h3>
            <span style="margin-left:auto; font-size:0.875rem; color:#9ca3af;">{{ $orders->count() }} pesanan</span>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%; font-size:0.85rem; border-collapse:collapse;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">No</th>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Tgl Pesan</th>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">ID Transaksi</th>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Tipe</th>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Item</th>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Pelanggan</th>
                        <th style="padding:0.75rem 1rem; text-align:left; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Tgl Trip</th>
                        <th style="padding:0.75rem 1rem; text-align:right; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Total (IDR)</th>
                        <th style="padding:0.75rem 1rem; text-align:center; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Status</th>
                        <th style="padding:0.75rem 1rem; text-align:center; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Bayar</th>
                        <th style="padding:0.75rem 1rem; text-align:center; font-size:0.7rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Aksi</th>
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
                                <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit
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

    {{-- ─── CSV IMPORT TABLE ───────────────────────────────── --}}
    @php $tripImports = $this->getTripImportData(); @endphp
    @if($tripImports->count() > 0)
    <div style="background:white; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #f3e8ff; overflow:hidden;">
        <div style="padding:1rem; border-bottom:1px solid #f3e8ff; background:#faf5ff; display:flex; align-items:center; gap:0.75rem;">
            <h3 style="font-weight:700; color:#7e22ce; margin:0;">
                📂 Data Trip CSV —
                {{ $selectedMonth ? ($namaBulan[$selectedMonth] ?? $selectedMonth) . ' ' . $selectedYear : 'Semua ' . $selectedYear }}
            </h3>
            <span style="margin-left:auto; font-size:0.875rem; color:#a855f7;">{{ $tripImports->count() }} data</span>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%; font-size:0.82rem; border-collapse:collapse;">
                <thead style="background:#faf5ff;">
                    <tr>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">No</th>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Tanggal</th>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Pelanggan</th>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">HP</th>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Layanan</th>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Driver</th>
                        <th style="padding:0.5rem 0.75rem; text-align:left; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Mobil</th>
                        <th style="padding:0.5rem 0.75rem; text-align:center; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Hari</th>
                        <th style="padding:0.5rem 0.75rem; text-align:center; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Drone</th>
                        <th style="padding:0.5rem 0.75rem; text-align:right; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Harga</th>
                        <th style="padding:0.5rem 0.75rem; text-align:right; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Deposit</th>
                        <th style="padding:0.5rem 0.75rem; text-align:right; font-size:0.68rem; font-weight:600; color:#9333ea; text-transform:uppercase; white-space:nowrap;">Pelunasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tripImports as $i => $trip)
                    <tr style="border-top:1px solid #faf5ff;">
                        <td style="padding:0.5rem 0.75rem; color:#9ca3af; font-size:0.72rem;">{{ $i + 1 }}</td>
                        <td style="padding:0.5rem 0.75rem; color:#374151; font-size:0.72rem; white-space:nowrap;">
                            {{ $trip->tanggal ? $trip->tanggal->format('d M Y') : '-' }}
                        </td>
                        <td style="padding:0.5rem 0.75rem;">
                            <div style="font-weight:600; color:#111827; font-size:0.82rem;">{{ $trip->nama_pelanggan ?? '-' }}</div>
                            @if($trip->status)<div style="font-size:0.7rem; color:#9ca3af;">{{ $trip->status }}</div>@endif
                        </td>
                        <td style="padding:0.5rem 0.75rem; font-size:0.72rem; color:#6b7280;">{{ $trip->nomor_hp ?? '-' }}</td>
                        <td style="padding:0.5rem 0.75rem;">
                            <span style="display:inline-flex; align-items:center; padding:2px 8px; border-radius:99px; font-size:0.7rem; font-weight:600; {{ str_contains($trip->layanan ?? '', 'Trip') ? 'background:#f0fdf4; color:#15803d;' : 'background:#fff7ed; color:#c2410c;' }}">
                                {{ $trip->layanan ?? '-' }}
                            </span>
                        </td>
                        <td style="padding:0.5rem 0.75rem; font-size:0.72rem; color:#4b5563;">{{ $trip->nama_driver ?? '-' }}</td>
                        <td style="padding:0.5rem 0.75rem; font-size:0.72rem; color:#4b5563;">
                            {{ $trip->jenis_mobil ?? $trip->plat_mobil ?? '-' }}
                        </td>
                        <td style="padding:0.5rem 0.75rem; text-align:center; font-weight:700; color:#374151; font-size:0.72rem;">{{ $trip->jumlah_hari ?? 1 }}</td>
                        <td style="padding:0.5rem 0.75rem; text-align:center;">
                            @if($trip->drone)
                                <span style="color:#16a34a; font-weight:700; font-size:0.72rem;">✓</span>
                            @else
                                <span style="color:#d1d5db; font-size:0.72rem;">—</span>
                            @endif
                        </td>
                        <td style="padding:0.5rem 0.75rem; text-align:right; font-weight:600; color:#111827; white-space:nowrap; font-size:0.72rem;">
                            {{ $trip->harga > 0 ? 'Rp ' . number_format($trip->harga, 0, ',', '.') : '-' }}
                        </td>
                        <td style="padding:0.5rem 0.75rem; text-align:right; font-size:0.72rem; color:#6b7280; white-space:nowrap;">
                            {{ $trip->deposit > 0 ? 'Rp ' . number_format($trip->deposit, 0, ',', '.') : '-' }}
                        </td>
                        <td style="padding:0.5rem 0.75rem; text-align:right; font-size:0.72rem; color:#6b7280; white-space:nowrap;">
                            {{ $trip->pelunasan > 0 ? 'Rp ' . number_format($trip->pelunasan, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#faf5ff;">
                    <tr>
                        <td colspan="9" style="padding:0.75rem; text-align:right; font-size:0.875rem; font-weight:700; color:#7e22ce;">Total:</td>
                        <td style="padding:0.75rem; text-align:right; font-weight:700; color:#7e22ce; font-size:0.875rem;">Rp {{ number_format($tripImports->sum('harga'),0,',','.') }}</td>
                        <td style="padding:0.75rem; text-align:right; font-weight:700; color:#9333ea; font-size:0.75rem;">Rp {{ number_format($tripImports->sum('deposit'),0,',','.') }}</td>
                        <td style="padding:0.75rem; text-align:right; font-weight:700; color:#9333ea; font-size:0.75rem;">Rp {{ number_format($tripImports->sum('pelunasan'),0,',','.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @else
    <div style="background:#faf5ff; border:2px dashed #e9d5ff; border-radius:0.75rem; padding:2rem; text-align:center;">
        <div style="font-size:2.5rem; margin-bottom:0.75rem;">📂</div>
        <h4 style="font-weight:700; color:#9333ea; margin-bottom:0.25rem;">Belum ada data CSV</h4>
        <p style="font-size:0.875rem; color:#6b7280;">Klik tombol <strong>Import CSV Trip</strong> di atas untuk mengupload file dari Google Sheets/Excel.</p>
    </div>
    @endif

</x-filament-panels::page>
