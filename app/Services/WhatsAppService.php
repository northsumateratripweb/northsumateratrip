<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim pesan WhatsApp menggunakan Fonnte API
     *
     * @param  string  $target  Nomor tujuan (62812...)
     * @param  string  $message  Isi pesan
     * @return bool
     */
    public static function sendMessage($target, $message)
    {
        $baseUrl = env('WHATSAPP_SERVICE_URL', 'http://localhost:3000');

        try {
            $response = Http::post("{$baseUrl}/send-message", [
                'phone' => $target,
                'message' => $message,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                return true;
            }

            Log::error('WhatsApp Service Error: ' . ($result['message'] ?? 'Unknown error'), [
                'phone' => $target,
                'response' => $result,
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception: ' . $e->getMessage());

            return false;
        }
    }

    public static function getWhatsappUrl($message)
    {
        $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '6281298622143');
        return "https://wa.me/{$whatsappNumber}?text=".urlencode($message);
    }

    public static function generateTourOrderMessage(\App\Models\Order $order, \App\Models\Product $product)
    {
        $siteName = \App\Models\Setting::get('site_name', 'NorthSumateraTrip');
        $message = "Halo {$siteName},\n\n";
        $message .= "Saya ingin memesan Paket Tour:\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Paket:* {$product->name}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*ID Pesanan:* #ORD-'.str_pad($order->id, 5, '0', STR_PAD_LEFT)."\n";
        $message .= "*Nama:* {$order->customer_name}\n";
        $message .= "*Telepon:* {$order->customer_phone}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*Tanggal Trip:* '.\Carbon\Carbon::parse($order->trip_date)->format('d-m-Y')."\n";
        $message .= "*Jumlah Peserta:* {$order->pax_adult} Dewasa";
        if ($order->pax_child > 0) {
            $message .= ", {$order->pax_child} Anak";
        }
        $message .= "\n━━━━━━━━━━━━━━━━━━━━━━\n";
        if ($order->hotel_category) {
            $message .= '*Kategori Hotel:* '.ucwords(str_replace('_', ' ', $order->hotel_category))."\n";
        }
        $message .= '*Total Pembayaran:* Rp '.number_format($order->total_price, 0, ',', '.')."\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Mohon konfirmasi pesanan saya. Terima kasih.";

        return self::getWhatsappUrl($message);
    }

    public static function generateCarRentalMessage(\App\Models\Order $order, \App\Models\CarRental $carRental)
    {
        $siteName = \App\Models\Setting::get('site_name', 'NorthSumateraTrip');
        $message = "Halo {$siteName},\n\n";
        $message .= "Saya ingin memesan Sewa Mobil:\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Unit:* {$carRental->name}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*ID Pesanan:* #ORD-'.str_pad($order->id, 5, '0', STR_PAD_LEFT)."\n";
        $message .= "*Nama:* {$order->customer_name}\n";
        $message .= "*Telepon:* {$order->customer_phone}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*Tanggal Mulai:* '.\Carbon\Carbon::parse($order->trip_date)->format('d-m-Y')."\n";
        $message .= "*Durasi:* {$order->quantity} Hari\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*Total Pembayaran:* Rp '.number_format($order->total_price, 0, ',', '.')."\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Mohon konfirmasi pesanan saya. Terima kasih.";

        return self::getWhatsappUrl($message);
    }

    public static function generateRentalPackageMessage(\App\Models\Order $order, \App\Models\RentalPackage $package)
    {
        $siteName = \App\Models\Setting::get('site_name', 'NorthSumateraTrip');
        $message = "Halo {$siteName},\n\n";
        $message .= "Saya ingin memesan Paket Rental:\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Paket:* {$package->name}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*ID Pesanan:* #ORD-'.str_pad($order->id, 5, '0', STR_PAD_LEFT)."\n";
        $message .= "*Nama:* {$order->customer_name}\n";
        $message .= "*Telepon:* {$order->customer_phone}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*Tanggal Mulai:* '.\Carbon\Carbon::parse($order->trip_date)->format('d-m-Y')."\n";
        $message .= "*Durasi:* {$order->quantity} Hari\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= '*Total Pembayaran:* Rp '.number_format($order->total_price, 0, ',', '.')."\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Mohon konfirmasi pesanan saya. Terima kasih.";

        return self::getWhatsappUrl($message);
    }
}
