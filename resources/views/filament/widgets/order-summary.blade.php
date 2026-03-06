<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            📊 Rekapitulasi Pesanan {{ $year }}
        </x-slot>
        <x-slot name="description">
            Ringkasan bulanan semua jenis pesanan
        </x-slot>
        <x-slot name="headerEnd">
            <a href="{{ route('laporan.pesanan', ['tahun' => $year]) }}"
               target="_blank"
               class="fi-link text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline">
               Laporan Lengkap →
            </a>
        </x-slot>

        <div class="overflow-x-auto">
            <table style="width:100%; border-collapse:collapse; font-size:.82rem;">
                <thead>
                    <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <th style="padding:.6rem .85rem; text-align:left; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; white-space:nowrap">Bulan</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b">Total</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#166534">🏔️ Wisata</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#5b21b6">🗺️ Rental</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#92400e">🚗 Mobil</th>
                        <th style="padding:.6rem .85rem; text-align:right; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b">Pendapatan (IDR)</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b">Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyBreakdown as $i => $row)
                    <tr style="border-top:1px solid #f1f5f9; {{ !$row['active'] ? 'opacity:.45;' : '' }} {{ ($i + 1) == $month ? 'background:#eff6ff;' : '' }}">
                        <td style="padding:.6rem .85rem; font-weight:600; color:{{ ($i+1)==$month ? '#1d4ed8' : '#334155' }};">
                            {{ $row['bulan'] }}
                            @if(($i+1) == $month)
                                <span style="font-size:.65rem; background:#dbeafe; color:#1d4ed8; padding:1px 5px; border-radius:99px; font-weight:700; margin-left:4px">Ini</span>
                            @endif
                        </td>
                        <td style="padding:.6rem .85rem; text-align:center; font-weight:700;">{{ $row['total'] }}</td>
                        <td style="padding:.6rem .85rem; text-align:center; color:#166534;">{{ $row['tour'] ?: '-' }}</td>
                        <td style="padding:.6rem .85rem; text-align:center; color:#5b21b6;">{{ $row['rental'] ?: '-' }}</td>
                        <td style="padding:.6rem .85rem; text-align:center; color:#92400e;">{{ $row['car'] ?: '-' }}</td>
                        <td style="padding:.6rem .85rem; text-align:right; font-weight:600; white-space:nowrap;">
                            @if($row['revenue'] > 0)
                                Rp {{ number_format($row['revenue'],0,',','.') }}
                            @else
                                <span style="color:#cbd5e1">—</span>
                            @endif
                        </td>
                        <td style="padding:.6rem .85rem; text-align:center;">
                            @if($row['total'] > 0)
                            <div style="display:flex; gap:4px; justify-content:center;">
                                <a href="{{ route('laporan.pesanan.csv', ['tahun' => $year, 'bulan' => $i+1]) }}"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#f1f5f9; color:#475569; text-decoration:none; font-weight:600; border:1px solid #e2e8f0;"
                                   title="CSV {{ $row['bulan'] }}">CSV</a>
                                <a href="{{ route('laporan.pesanan.excel', ['tahun' => $year, 'bulan' => $i+1]) }}"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#dcfce7; color:#166534; text-decoration:none; font-weight:600; border:1px solid #bbf7d0;"
                                   title="Excel {{ $row['bulan'] }}">XLS</a>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top:2px solid #e2e8f0; background:#f8fafc; font-weight:700;">
                        <td style="padding:.7rem .85rem; color:#475569;">Total {{ $year }}</td>
                        <td style="padding:.7rem .85rem; text-align:center; color:#1e293b;">{{ $yearTotal }}</td>
                        <td colspan="3"></td>
                        <td style="padding:.7rem .85rem; text-align:right; color:#16a34a; white-space:nowrap;">
                            Rp {{ number_format($yearRevenue,0,',','.') }}
                        </td>
                        <td style="padding:.7rem .85rem; text-align:center;">
                            <div style="display:flex; gap:4px; justify-content:center;">
                                <a href="{{ route('laporan.pesanan.csv', ['tahun' => $year]) }}"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#f1f5f9; color:#475569; text-decoration:none; font-weight:600; border:1px solid #e2e8f0;">CSV</a>
                                <a href="{{ route('laporan.pesanan.excel', ['tahun' => $year]) }}"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#dcfce7; color:#166534; text-decoration:none; font-weight:600; border:1px solid #bbf7d0;">XLS</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
