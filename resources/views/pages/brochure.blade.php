@php
    use App\Models\Setting;
    $companyName = Setting::get('site_name', 'NorthSumateraTrip');
    $primaryColor = Setting::get('primary_color', '#3b82f6');
    $siteSlogan = Setting::get('site_slogan', 'Premium Sumatera Travel & Tour');
    $waNumber = Setting::get('whatsapp_number', '6281298622143');
    $emailContact = Setting::get('site_email', 'info@northsumateratrip.com');
    $instagram = Setting::get('instagram_handle', '@northsumateratrip');

    // Base64 image helper for DomPDF
    function getBase64Image($path) {
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) return null;
        $type = pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    
    $featuredImage = null;
    if ($product->featured_image) {
        // Try storage path first (Filament uploads)
        $imgP = storage_path('app/public/' . $product->featured_image);
        if (!file_exists($imgP)) {
            // Try public/images/products fallback (legacy/demo)
            $imgP = public_path('images/products/' . $product->featured_image);
        }
        if (file_exists($imgP)) {
            $type = pathinfo($imgP, PATHINFO_EXTENSION);
            $data = file_get_contents($imgP);
            $featuredImage = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Brosur - {{ $product->name }}</title>
    <style>
        @page { margin: 0; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1e293b;
            background: #fff;
            line-height: 1.4;
        }
        .hero {
            position: relative;
            height: 400px;
            background-color: #0f172a;
            color: #fff;
            overflow: hidden;
        }
        .hero-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            opacity: 0.6;
        }
        .hero-overlay {
            position: absolute;
            bottom: 0; left: 0; width: 100%;
            background: linear-gradient(transparent, rgba(15, 23, 42, 0.9));
            padding: 60px 40px 40px;
        }
        .badge {
            display: inline-block;
            background: {{ $primaryColor }};
            color: #fff;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            line-height: 1.1;
        }
        .meta-header {
            font-size: 14px;
            color: #cbd5e1;
        }
        .content {
            padding: 40px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: {{ $primaryColor }};
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 8px;
            margin-bottom: 20px;
            margin-top: 30px;
        }
        .itinerary-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 25px;
            border-left: 2px solid #e2e8f0;
        }
        .itinerary-day {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }
        .itinerary-desc {
            font-size: 12px;
            color: #475569;
        }
        .dot {
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            background: {{ $primaryColor }};
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }
        .list-item {
            font-size: 12px;
            color: #475569;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        .list-item:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }
        .list-item.exclude:before {
            content: '×';
            color: #ef4444;
        }
        .footer {
            background: #f8fafc;
            padding: 40px;
            border-top: 1px solid #e2e8f0;
        }
        .footer-table {
            width: 100%;
        }
        .footer-brand {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
        }
        .footer-contact {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }
        .price-box {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }
        .price-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            color: #64748b;
        }
        .price-value {
            font-size: 24px;
            font-weight: 800;
            color: {{ $primaryColor }};
        }
    </style>
</head>
<body>
    <div class="hero">
        @if($featuredImage)
            <img src="{{ $featuredImage }}" class="hero-img">
        @endif
        <div class="hero-overlay">
            <div class="badge">{{ $category->name ?? 'Wisata Terpopuler' }}</div>
            <h1 class="title">{{ $product->name }}</h1>
            <div class="meta-header">
                📍 {{ $product->location }} &bull; ⏱️ {{ $product->duration ?? '-' }} Hari
            </div>
        </div>
    </div>

    <div class="content">
        <div class="grid">
            <div class="col" style="padding-right: 30px;">
                <div class="section-title">Detail Perjalanan</div>
                @if($product->itinerary && count($product->itinerary) > 0)
                    @foreach($product->itinerary as $index => $item)
                    <div class="itinerary-item">
                        <div class="dot"></div>
                        <div class="itinerary-day">Hari {{ $index + 1 }}: {{ $item['title'] ?? ($item['day'] ?? 'Tujuan Hari Ini') }}</div>
                        <div class="itinerary-desc">{{ $item['description'] ?? ($item['content'] ?? '') }}</div>
                    </div>
                    @endforeach
                @else
                    <div class="itinerary-desc">Silakan hubungi admin untuk detail itinerari lengkap.</div>
                @endif
            </div>

            <div class="col">
                <div class="price-box">
                    <div class="price-label">Mulai Dari</div>
                    <div class="price-value">Rp {{ number_format($product->price_start_from ?? $product->price, 0, ',', '.') }}</div>
                    <div class="price-label">per orang</div>
                </div>

                <div class="section-title">Sudah Termasuk (Inclusion)</div>
                @if($product->includes)
                    @foreach($product->includes as $item)
                    <div class="list-item">{{ $item }}</div>
                    @endforeach
                @endif

                <div class="section-title">Belum Termasuk (Exclusion)</div>
                @if($product->excludes)
                    @foreach($product->excludes as $item)
                    <div class="list-item exclude">{{ $item }}</div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <div class="footer-brand">{{ strtoupper($companyName) }}</div>
                    <div class="footer-contact">{{ $siteSlogan }}</div>
                </td>
                <td style="text-align: right;">
                    <div class="footer-contact">📱 WhatsApp: {{ $waNumber }}</div>
                    <div class="footer-contact">✉️ Email: {{ $emailContact }}</div>
                    <div class="footer-contact">🌐 {{ request()->getHttpHost() }}</div>
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 30px; font-size: 8px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">
            Dibuat secara otomatis oleh sistem NorthSumateraTrip &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
