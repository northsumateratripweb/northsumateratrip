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
}
