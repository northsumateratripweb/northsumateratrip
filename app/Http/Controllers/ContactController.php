<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // Simpan ke database
        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        // Kirim WhatsApp notifikasi ke admin
        try {
            $adminPhone = config('services.whatsapp.admin_phone', '6281298622143');
            WhatsAppService::sendMessage($adminPhone, "📩 Pesan baru dari {$validated['name']} ({$validated['email']}): {$validated['message']}");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('WhatsApp notification gagal untuk contact message', [
                'message_id' => $contactMessage->id,
                'error' => $e->getMessage(),
            ]);
        }

        $message = 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
