@php
    use Illuminate\Support\Carbon;
    use App\Models\Setting;

    $isItinerary = !isset($order) || is_null($order);
    
    // ── Resolve item details ─────────────────────────────────
    if ($isItinerary) {
        $itemName   = $product->translate('name') ?? 'Paket Wifi';
        $itemMeta   = ($product->location ?? 'Sumatera');
        $itemPrice  = $product->price ?? 0;
        $itemQty    = 1;
        $totalPrice = $itemPrice;
    } else if ($order->vehicle) {
        $itemName   = $order->vehicle?->name ?? 'Rental Mobil';
        $itemMeta   = $order->vehicle?->category ?? '';
        $itemPrice  = $order->total_price;
        $itemQty    = 1;
        $totalPrice = $order->total_price;
    } else if ($order->rentalPackage) {
        $itemName   = $order->rentalPackage?->name ?? 'Paket Rental';
        $itemMeta   = $order->rentalPackage?->category ?? '';
        $itemPrice  = $order->total_price;
        $itemQty    = 1;
        $totalPrice = $order->total_price;
    } else {
        $itemName   = $order->product?->name ?? 'Paket Wifi';
        $itemMeta   = ($order->product?->location ?? 'Sumatera');
        $itemPrice  = $order->total_price / ($order->quantity ?: 1);
        $itemQty    = $order->quantity ?? 1;
        $totalPrice = $order->total_price;
    }

    // ── Company settings ─────────────────────────────────────
    $companyName  = Setting::get('site_name', 'NorthSumateraTrip');
    $primaryColor = Setting::get('primary_color', '#3b82f6');
    $siteSlogan   = Setting::get('site_slogan', 'Premium Sumatera Travel & Tour');
    $waNumber     = Setting::get('whatsapp_number', '628123456789');
    $emailContact = Setting::get('site_email', 'info@northsumateratrip.com');

    // ── Status helpers ───────────────────────────────────────
    if (!$isItinerary) {
        $status = $order->status ?? 'pending';
        $statusLabel = strtoupper($status);
        $statusBadge = match($status) {
            'confirmed', 'paid', 'success' => '#dcfce7|#166534',
            'cancelled', 'failed'          => '#fee2e2|#991b1b',
            default                        => '#fef9c3|#854d0e',
        };
        [$statusBg, $statusFg] = explode('|', $statusBadge);

        $invoiceNo = 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
        $issuedAt  = $order->created_at->format('d F Y');
    } else {
        $invoiceNo = '#PREVIEW';
        $issuedAt  = now()->format('d F Y');
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $isItinerary ? 'Itinerary' : 'Invoice' }} – {{ $itemName }}</title>
    <style>
        @page { size: A4; margin: 0; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            background: #fff;
            line-height: 1.5;
        }

        /* ══ HEADER ═══════════════════════════════════════════ */
        .hdr { background: {{ $primaryColor }}; padding: 36px 50px 28px; color:#fff; position:relative; overflow:hidden; }
        .hdr-t  { display:table; width:100%; }
        .hdr-l  { display:table-cell; vertical-align:middle; }
        .hdr-r  { display:table-cell; vertical-align:middle; text-align:right; }
        .brand  { font-size:26px; font-weight:900; letter-spacing:-1px; color:#fff; }
        .brand-sub { font-size:9px; letter-spacing:3px; text-transform:uppercase; color:rgba(255,255,255,.6); margin-top:3px; }
        .doc-type   { font-size:9px; font-weight:700; letter-spacing:4px; text-transform:uppercase; color:rgba(255,255,255,.7); }
        .doc-num    { font-size:22px; font-weight:900; color:#fff; letter-spacing:-0.5px; margin-top:4px; }

        /* ══ META BAR ═════════════════════════════════════════ */
        .meta { background:#f8fafc; border-bottom:2px solid #e2e8f0; padding:12px 50px; }
        .meta-t { display:table; width:100%; }
        .meta-c { display:table-cell; vertical-align:middle; padding-right:36px; }
        .meta-c:last-child { padding-right:0; text-align:right; }
        .ml { font-size:8px; text-transform:uppercase; letter-spacing:1.5px; color:#64748b; margin-bottom:2px; }
        .mv { font-size:11.5px; font-weight:800; color:#1e293b; }

        .badge {
            display:inline-block; padding:3px 12px; border-radius:50px;
            font-size:8.5px; font-weight:900; text-transform:uppercase; letter-spacing:.8px;
        }

        /* ══ BODY ═════════════════════════════════════════════ */
        .body { padding:32px 50px 0; }

        .sec-title {
            font-size:8.5px; font-weight:800; letter-spacing:2px;
            text-transform:uppercase; color:{{ $primaryColor }};
            padding:0 0 7px 10px; margin-bottom:16px;
            border-bottom:1px solid #e2e8f0;
            border-left:3px solid {{ $primaryColor }};
        }

        /* ── Two-column info ─── */
        .grid2 { display:table; width:100%; margin-bottom:26px; }
        .col2   { display:table-cell; width:50%; vertical-align:top; }
        .col2-l { padding-right:18px; }
        .col2-r { padding-left:18px; border-left:1px solid #f1f5f9; }

        .dr  { margin-bottom:13px; }
        .dl  { font-size:8px; color:#94a3b8; text-transform:uppercase; letter-spacing:.9px; margin-bottom:2px; }
        .dv  { font-size:11.5px; font-weight:700; color:#1e293b; }
        .dv-a{ color:{{ $primaryColor }}; font-size:12.5px; }

        /* ── Cost table ─── */
        .ct { width:100%; border-collapse:collapse; margin-bottom:26px; }
        .ct th {
            background:#1e293b; color:#fff; padding:10px 13px;
            font-size:8.5px; text-transform:uppercase; letter-spacing:.8px;
            text-align:left;
        }
        .ct th.r { text-align:right; }
        .ct th.c { text-align:center; }
        .ct td   { padding:13px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
        .ct tr:last-child td { border-bottom:none; }
        .ct tr:nth-child(even) td { background:#fafafa; }
        .i-name { font-weight:800; font-size:13px; color:#0f172a; }
        .i-desc { font-size:9px; color:#64748b; margin-top:3px; text-transform:uppercase; letter-spacing:.5px; }

        /* ── Summary ─── */
        .sw  { display:table; width:100%; margin-bottom:30px; }
        .sn  { display:table-cell; width:52%; vertical-align:bottom; padding-right:18px; }
        .snb { background:#f8fafc; border:1px solid #e2e8f0; border-radius:9px; padding:14px 16px; }
        .snb-h { font-size:8.5px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#475569; margin-bottom:8px; }
        .snb-p { font-size:9.5px; color:#64748b; line-height:1.9; }
        .sb  { display:table-cell; width:48%; background:#0f172a; border-radius:12px; padding:22px; color:#fff; vertical-align:top; }
        .sr  { display:table; width:100%; margin-bottom:8px; }
        .sl2 { display:table-cell; font-size:10px; color:#94a3b8; }
        .sv2 { display:table-cell; text-align:right; font-weight:700; font-size:11px; color:#e2e8f0; }
        .sdiv{ border-top:1px solid rgba(255,255,255,.1); margin:12px 0; }
        .str { display:table; width:100%; }
        .stl { display:table-cell; font-size:11px; font-weight:800; color:#fff; text-transform:uppercase; letter-spacing:1px; vertical-align:middle; }
        .stv { display:table-cell; text-align:right; font-size:21px; font-weight:900; color:#60a5fa; vertical-align:middle; }

        /* ── Footer ─── */
        .ftr {
            text-align:center; padding:24px 50px 28px;
            border-top:2px solid #f1f5f9; background:#fafafa;
        }
        .ftr-h  { font-size:13px; font-weight:900; color:#0f172a; margin-bottom:5px; }
        .ftr-s  { font-size:9.5px; color:#94a3b8; max-width:400px; margin:0 auto 14px; }
        .ftr-ct { display:inline-table; }
        .ftr-ci { display:table-cell; padding:0 14px; font-size:10px; font-weight:700; color:#475569; }
        .ftr-cp { font-size:8.5px; color:#cbd5e1; margin-top:10px; }
    </style>
</head>
<body>

{{-- ══ HEADER ══════════════════════════════════════════════════ --}}
<div class="hdr">
    <table class="hdr-t">
        <tr>
            <td class="hdr-l">
                <div class="brand">{{ strtoupper($companyName) }}</div>
                <div class="brand-sub">{{ strtoupper($siteSlogan) }}</div>
            </td>
            <td class="hdr-r">
                <div class="doc-type">{{ $isItinerary ? 'Itinerary Preview' : 'Official Invoice' }}</div>
                <div class="doc-num">{{ $invoiceNo }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ══ META BAR ════════════════════════════════════════════════ --}}
<div class="meta">
    <div class="meta-t">
        <div class="meta-c">
            <div class="ml">Tanggal Terbit</div>
            <div class="mv">{{ $issuedAt }}</div>
        </div>

        @if(!$isItinerary)
        <div class="meta-c">
            <div class="ml">ID Pemesanan</div>
            <div class="mv">{{ $invoiceNo }}</div>
        </div>

        <div class="meta-c">
            <div class="ml">Status</div>
            <div class="mv">
                <span class="badge" style="background:{{ $statusBg }};color:{{ $statusFg }};">{{ $statusLabel }}</span>
            </div>
        </div>
        @endif

        <div class="meta-c">
            <div class="ml">Kategori</div>
            <div class="mv">
                @if(!$isItinerary && $order->vehicle)
                    🚗 Rental Mobil
                @elseif(!$isItinerary && $order->rentalPackage)
                    🎫 Paket Rental
                @elseif(!$isItinerary && $order->product)
                    🏔️ Paket Wisata
                @else
                    -
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ══ BODY ════════════════════════════════════════════════════ --}}
<div class="body">

    <div class="sec-title">Informasi Pelanggan &amp; Perjalanan</div>
    <div class="grid2">
        <div class="col2 col2-l">
            <div class="dr">
                <div class="dl">Nama Pelanggan</div>
                <div class="dv dv-a">{{ $isItinerary ? 'Guest Customer' : $order->customer_name }}</div>
            </div>
            <div class="dr">
                <div class="dl">WhatsApp / HP</div>
                <div class="dv">{{ $isItinerary ? $waNumber : $order->customer_phone }}</div>
            </div>
            <div class="dr">
                <div class="dl">Email</div>
                <div class="dv dv-s">{{ $isItinerary ? $emailContact : $order->customer_email }}</div>
            </div>
        </div>

        <div class="col2 col2-r">
            <div class="dr">
                <div class="dl">Tanggal Keberangkatan</div>
                <div class="dv dv-a">
                    @if($isItinerary)
                        Berdasarkan Request
                    @else
                        {{ Carbon::parse($order->trip_date)->translatedFormat('l, d F Y') }}
                    @endif
                </div>
            </div>

            <div class="dr">
                <div class="dl">Jumlah Peserta</div>
                <div class="dv">
                    {{ $itemQty }} Orang
                </div>
            </div>

            @if(!$isItinerary && $order->flight_info)
            <div class="dr">
                <div class="dl">Info Penerbangan</div>
                <div class="dv text-xs">{{ $order->flight_info }}</div>
            </div>
            @endif
        </div>
    </div>

    @if(!$isItinerary && ($order->hotel_1 || $order->hotel_2 || $order->hotel_3 || $order->hotel_4))
    <div class="sec-title">Daftar Pilihan Hotel</div>
    <div style="margin-bottom: 26px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
            @for($i=1; $i<=4; $i++)
                @php $h = "hotel_$i"; @endphp
                @if($order->$h)
                <tr>
                    <td style="padding: 6px 0; border-bottom: 1px solid #f1f5f9; width: 100px; color: #64748b; font-weight: bold;">MALAM {{ $i }}</td>
                    <td style="padding: 6px 0; border-bottom: 1px solid #f1f5f9; font-weight: 700;">{{ $order->$h }}</td>
                </tr>
                @endif
            @endfor
        </table>
    </div>
    @endif

    @if(!$isItinerary && ($order->use_drone || $order->notes))
    <div class="sec-title">Layanan & Catatan Tambahan</div>
    <div style="background: #f8fafc; border-radius: 8px; padding: 12px; margin-bottom: 26px;">
        @if($order->use_drone)
        <div style="margin-bottom: 8px;">
            <span style="font-weight: bold; color: #3b82f6;">✓ Layanan Drone Aktif</span>
            <span style="color: #64748b; font-size: 9px; margin-left: 5px;">(Dokumentasi udara termasuk dalam paket)</span>
        </div>
        @endif
        
        @if($order->notes)
        <div>
            <div style="font-size: 8px; color: #94a3b8; text-transform: uppercase; margin-bottom: 2px;">Catatan Khusus:</div>
            <div style="font-style: italic; color: #475569;">"{{ $order->notes }}"</div>
        </div>
        @endif
    </div>
    @endif

    <div class="sec-title">Rincian Biaya</div>
    <table class="ct">
        <thead>
            <tr>
                <th width="50%">Deskripsi Layanan</th>
                <th width="20%" class="r">Harga Satuan</th>
                <th width="10%" class="c">Orang</th>
                <th width="20%" class="r">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="i-name">{{ $itemName }}</div>
                    <div class="i-desc">{{ $itemMeta }}</div>
                </td>
                <td style="text-align:right;font-weight:700;">
                    Rp {{ number_format($itemPrice, 0, ',', '.') }}
                </td>
                <td style="text-align:center;font-weight:700;">
                    {{ $itemQty }}
                </td>
                <td style="text-align:right;font-weight:800;color:{{ $primaryColor }};">
                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="sw">
        <div class="sn">
            <div class="snb">
                <div class="snb-h">📋 Informasi Pembayaran</div>
                <div class="snb-p" style="line-height: 1.6;">
                    @php
                        $bank1 = Setting::get('bank_name_1');
                        $bank2 = Setting::get('bank_name_2');
                        $qris  = Setting::get('qris_image');
                    @endphp

                    @if($bank1)
                        <strong>{{ $bank1 }}:</strong> {{ Setting::get('bank_account_1') }} (a/n {{ Setting::get('bank_holder_1') }})<br>
                    @endif
                    @if($bank2)
                        <strong>{{ $bank2 }}:</strong> {{ Setting::get('bank_account_2') }} (a/n {{ Setting::get('bank_holder_2') }})<br>
                    @endif

                    @if($qris && file_exists(storage_path('app/public/' . $qris)))
                        <div style="margin-top: 10px; border: 1px dashed #cbd5e1; padding: 10px; border-radius: 8px; background: #fff; text-align: center;">
                            <p style="font-size: 8px; font-weight: bold; color: #64748b; margin-bottom: 5px; text-transform: uppercase;">Scan QRIS Untuk Bayar</p>
                            @php
                                $qrisPath = storage_path('app/public/' . $qris);
                                $qrisData = base64_encode(file_get_contents($qrisPath));
                            @endphp
                            <img src="data:image/png;base64,{{ $qrisData }}" style="width: 120px; height: auto;">
                        </div>
                    @else
                        <div style="margin-top: 8px; font-size: 8px; color: #94a3b8; font-style: italic;">
                            *Harap kirimkan bukti transfer melalui WhatsApp untuk konfirmasi cepat.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="sb">
            <div class="sr">
                <div class="sl2">Subtotal</div>
                <div class="sv2">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
            </div>
            <div class="sr">
                <div class="sl2">Pajak / Biaya Layanan</div>
                <div class="sv2">Rp 0</div>
            </div>
            <div class="sdiv"></div>
            <div class="str">
                <div class="stl">Total Tagihan</div>
                <div class="stv">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

</div>

<div class="ftr">
    <div class="ftr-h">Terima kasih telah memilih {{ $companyName }}! 🙏</div>
    <div class="ftr-s">
        Kami berkomitmen memberikan pengalaman perjalanan terbaik di Sumatera.
        Jangan ragu menghubungi kami jika ada pertanyaan atau bantuan.
    </div>
    <div class="ftr-ct">
        <div class="ftr-ci">📱 {{ $waNumber }}</div>
        <div class="ftr-sep">•</div>
        <div class="ftr-ci">✉️ {{ $emailContact }}</div>
        <div class="ftr-sep">•</div>
        <div class="ftr-ci">🌐 {{ request()->getHttpHost() }}</div>
    </div>
</div>

</body>
</html>
