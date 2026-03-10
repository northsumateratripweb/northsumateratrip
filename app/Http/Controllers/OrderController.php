<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'customer_name'    => 'required|string|max:255',
                'customer_email'   => 'nullable|email|max:255',
                'customer_phone'   => 'required|string|max:20',
                'customer_whatsapp'=> 'nullable|string|max:20',
                'trip_date'        => 'required|date',
                'trip_end_date'    => 'nullable|date|after_or_equal:trip_date',
                'trip_type'        => 'nullable|string|max:100',
                'pax_adult'        => 'required|integer|min:1',
                'pax_child'        => 'required|integer|min:0',
                'notes'            => 'nullable|string|max:1000',
                'hotel_category'   => 'nullable|string|in:bintang_1,bintang_3,bintang_5,non_hotel',
                'hotel_1'          => 'nullable|string|max:255',
                'hotel_2'          => 'nullable|string|max:255',
                'hotel_3'          => 'nullable|string|max:255',
                'hotel_4'          => 'nullable|string|max:255',
                'flight_info'      => 'nullable|string|max:500',
                'use_drone'        => 'nullable|boolean',
                'agree_terms'      => 'accepted',
            ], [
                'agree_terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan sebelum memesan.',
            ]);

            // Look up price per person from pricing_details table
            $adultPax        = (int) $validated['pax_adult'];
            $childPax        = (int) $validated['pax_child'];
            $pricingDetails  = $product->pricing_details ?? [];
            $pricePerAdult   = $product->price_min ?? 0;
            $childPrice      = $product->child_price ?? 0;

            if (!empty($pricingDetails)) {
                // Sort by pax ascending
                usort($pricingDetails, fn ($a, $b) => (int)$a['pax'] <=> (int)$b['pax']);

                // Exact match for adult pax
                $matched = collect($pricingDetails)->firstWhere('pax', $adultPax);
                if ($matched) {
                    $pricePerAdult = (float) $matched['price_per_person'];
                } else {
                    // Nearest lower bracket
                    $lower = collect($pricingDetails)->filter(fn ($r) => (int)$r['pax'] <= $adultPax)->last();
                    if ($lower) {
                        $pricePerAdult = (float) $lower['price_per_person'];
                    } else {
                        // Nearest higher bracket
                        $higher = collect($pricingDetails)->filter(fn ($r) => (int)$r['pax'] > $adultPax)->first();
                        if ($higher) $pricePerAdult = (float) $higher['price_per_person'];
                    }
                }
            }

            $droneFee = !empty($validated['use_drone']) ? (float) ($product->drone_price ?? 1500000) : 0;
            $totalPrice = ($pricePerAdult * $adultPax) + ($childPrice * $childPax) + $droneFee;

            $order = DB::transaction(function () use ($product, $validated, $adultPax, $childPax, $droneFee, $totalPrice) {
                $order = Order::create([
                    'product_id'        => $product->id,
                    'user_id'           => auth()->check() ? auth()->id() : null,
                    'customer_name'     => $validated['customer_name'],
                    'customer_email'    => $validated['customer_email'] ?? null,
                    'customer_phone'    => $validated['customer_phone'],
                    'customer_whatsapp' => $validated['customer_whatsapp'] ?? $validated['customer_phone'],
                    'trip_date'         => $validated['trip_date'],
                    'trip_end_date'     => $validated['trip_end_date'] ?? null,
                    'trip_type'         => $validated['trip_type'] ?? null,
                    'pax_adult'         => $adultPax,
                    'pax_child'         => $childPax,
                    'quantity'          => $adultPax + $childPax,
                    'total_price'       => (float) $totalPrice,
                    'status'            => 'pending',
                    'notes'             => $validated['notes'] ?? null,
                    'hotel_category'    => $validated['hotel_category'] ?? null,
                    'hotel_1'           => $validated['hotel_1'] ?? null,
                    'hotel_2'           => $validated['hotel_2'] ?? null,
                    'hotel_3'           => $validated['hotel_3'] ?? null,
                    'hotel_4'           => $validated['hotel_4'] ?? null,
                    'flight_info'       => $validated['flight_info'] ?? null,
                    'use_drone'         => !empty($validated['use_drone']),
                ]);

                // Automatically create a Trip Schedule entry so it appears in "Jadwal Trip"
                \App\Models\TripSchedule::create([
                    'order_id'  => $order->id,
                    'trip_date' => $order->trip_date,
                    'status'    => 'scheduled',
                    'notes'     => $order->notes
                ]);

                // Notify admins
                try {
                    $admins = \App\Models\User::all();
                    \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewOrderNotification($order));
                } catch (\Throwable $e) {
                    \Log::error('Notification Error: ' . $e->getMessage());
                }

                return $order;
            });


            return response()->json([
                'success'      => true,
                'message'      => 'Pesanan berhasil disimpan.',
                'order_id'     => $order->id,
                'whatsapp_url' => $this->generateWhatsAppUrl($order)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terdapat kesalahan pada isian form.',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Order Store Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateWhatsAppUrl(Order $order)
    {
        $siteName      = Setting::get('site_name', 'NorthSumateraTrip');
        $whatsappNumber = Setting::get('whatsapp_number', '6281298622143');

        // Bank Info for Manual Payment Instruction in WA
        $bank1 = Setting::get('bank_name_1') ? "\n💳 *Transfer Ke:* " . Setting::get('bank_name_1') . " (" . Setting::get('bank_account_1') . " a/n " . Setting::get('bank_holder_1') . ")" : "";
        $bank2 = Setting::get('bank_name_2') ? "\n💳 *Transfer Ke:* " . Setting::get('bank_name_2') . " (" . Setting::get('bank_account_2') . " a/n " . Setting::get('bank_holder_2') . ")" : "";

        $message  = "Halo {$siteName},\n\n";
        $message .= "Saya ingin memesan paket wisata:\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Paket:* {$order->product->name}\n";
        if ($order->trip_type) {
            $message .= "*Tipe Trip:* {$order->trip_type}\n";
        }
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*ID Pesanan:* #ORD-" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "\n";
        $message .= "*Nama:* {$order->customer_name}\n";
        $message .= "*Telepon:* {$order->customer_phone}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Berangkat:* " . \Carbon\Carbon::parse($order->trip_date)->format('d-m-Y') . "\n";
        $message .= "*Peserta:* {$order->pax_adult} Dewasa";
        if ($order->pax_child > 0) {
            $message .= ", {$order->pax_child} Anak (<= 8 Thn)";
        }
        if ($order->use_drone) {
            $message .= "\n*Tambahan:* Paket Video Cinematic Drone";
        }
        $message .= "\n━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Total Pembayaran:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "\n*Instruksi Pembayaran Manual:*";
        $message .= $bank1;
        $message .= $bank2;
        if (Setting::get('qris_image')) {
            $message .= "\n🖼️ *Atau scan QRIS yang tersedia di website.*";
        }
        $message .= "\n\nMohon konfirmasi pesanan saya. Terima kasih.";

        return "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
    }
}
