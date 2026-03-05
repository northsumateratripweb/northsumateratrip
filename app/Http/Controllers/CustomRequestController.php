<?php

namespace App\Http\Controllers;

use App\Models\CustomRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class CustomRequestController extends Controller
{
    public function create()
    {
        $budgetOptions        = CustomRequest::budgetOptions();
        $accommodationOptions = CustomRequest::accommodationOptions();
        $transportOptions     = CustomRequest::transportOptions();

        return view('pages.custom-request', compact(
            'budgetOptions',
            'accommodationOptions',
            'transportOptions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'      => 'required|string|max:255',
            'customer_phone'     => 'required|string|max:30',
            'customer_email'     => 'nullable|email|max:255',
            'trip_date'          => 'nullable|date|after_or_equal:today',
            'trip_duration'      => 'required|integer|min:1|max:30',
            'num_persons'        => 'required|integer|min:1|max:500',
            'destinations'       => 'nullable|string|max:500',
            'budget_range'       => 'nullable|string|max:50',
            'accommodation_type' => 'nullable|string|max:50',
            'transport_type'     => 'nullable|string|max:50',
            'special_requests'   => 'nullable|string|max:2000',
        ]);

        $customRequest = CustomRequest::create($validated);

        // Build WhatsApp message
        $whatsappUrl = $this->buildWhatsAppUrl($customRequest);

        return response()->json([
            'success'       => true,
            'message'       => __('ui.custom_request_sent'),
            'request_id'    => $customRequest->id,
            'whatsapp_url'  => $whatsappUrl,
        ]);
    }

    private function buildWhatsAppUrl(CustomRequest $req): string
    {
        $siteName = Setting::get('site_name', 'NorthSumateraTrip');
        $waNumber = preg_replace('/\D/', '', Setting::get('whatsapp_number', '628123456789'));

        $budgetLabel = CustomRequest::budgetOptions()[$req->budget_range] ?? $req->budget_range ?? '-';
        $accomLabel  = CustomRequest::accommodationOptions()[$req->accommodation_type] ?? $req->accommodation_type ?? '-';
        $transLabel  = CustomRequest::transportOptions()[$req->transport_type] ?? $req->transport_type ?? '-';

        $msg  = "Halo *{$siteName}* 👋\n\n";
        $msg .= "Saya ingin membuat *Paket Trip Custom*:\n";
        $msg .= "────────────────────\n";
        $msg .= "📋 *No. Request:* #" . str_pad($req->id, 5, '0', STR_PAD_LEFT) . "\n";
        $msg .= "👤 *Nama:* {$req->customer_name}\n";
        $msg .= "📱 *HP:* {$req->customer_phone}\n";
        $msg .= "📅 *Tanggal Trip:* " . ($req->trip_date ? $req->trip_date->format('d M Y') : 'Fleksibel') . "\n";
        $msg .= "⏱️ *Durasi:* {$req->trip_duration} hari\n";
        $msg .= "👥 *Jumlah Orang:* {$req->num_persons} pax\n";
        $msg .= "📍 *Destinasi/Minat:* " . ($req->destinations ?: '-') . "\n";
        $msg .= "💰 *Budget:* {$budgetLabel}\n";
        $msg .= "🏨 *Akomodasi:* {$accomLabel}\n";
        $msg .= "🚗 *Transportasi:* {$transLabel}\n";
        $msg .= "📝 *Permintaan Khusus:* " . ($req->special_requests ?: '-') . "\n";
        $msg .= "────────────────────\n";
        $msg .= "Mohon bantu buatkan itinerari yang sesuai. Terima kasih! 🙏";

        return "https://wa.me/{$waNumber}?text=" . rawurlencode($msg);
    }
}
