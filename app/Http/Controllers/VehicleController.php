<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'capacity' => 'nullable|string|in:2,4,6,8,12,12+',
            'transmission' => 'nullable|string|in:manual,automatic,Manual,Automatic',
            'brand' => 'nullable|string|max:50',
        ]);

        $query = CarRental::available()->with('vehicle');

        if (!empty($validated['capacity'])) {
            if ($validated['capacity'] === '12+') {
                $query->where('capacity', '>=', 12);
            } else {
                $query->where('capacity', (int) $validated['capacity']);
            }
        }

        if (!empty($validated['transmission'])) {
            $query->where('transmission', $validated['transmission']);
        }

        if (!empty($validated['brand'])) {
            $brand = str_replace(['%', '_'], ['\%', '\_'], $validated['brand']);
            $query->where('brand', 'like', "%{$brand}%");
        }

        $carRentals = $query->orderBy('sort_order')->paginate(12);

        return view('pages.car-rental', compact('carRentals'));
    }

    public function show(string $slug)
    {
        // Support both slug and legacy numeric id
        $carRental = is_numeric($slug)
            ? CarRental::with('vehicle')->find($slug)
            : CarRental::with('vehicle')->where('slug', $slug)->first();

        if (! $carRental) {
            abort(404);
        }

        $relatedCarRentals = CarRental::available()
            ->where('id', '!=', $carRental->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('pages.car-detail', compact('carRental', 'relatedCarRentals'));
    }

    public function storeOrder(Request $request, string $slug)
    {
        $carRental = is_numeric($slug)
            ? CarRental::find($slug)
            : CarRental::where('slug', $slug)->first();

        if (! $carRental) {
            abort(404);
        }

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'trip_date'      => 'required|date|after_or_equal:today',
            'quantity'       => 'required|integer|min:1',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $days = (int) $request->quantity;
        $pricePerDay = (float) ($carRental->price_per_day ?? 0);
        $pricingDetails = $carRental->pricing_details ?? [];

        if (!empty($pricingDetails)) {
            // Sort by days ascending
            usort($pricingDetails, fn ($a, $b) => (int)$a['days'] <=> (int)$b['days']);

            // Find exact match or nearest lower bracket
            $matched = collect($pricingDetails)->filter(fn ($r) => (int)$r['days'] <= $days)->last();
            if ($matched) {
                $pricePerDay = (float) $matched['price'];
            }
        }

        $total_price = $pricePerDay * $days;

        $order = DB::transaction(function () use ($carRental, $request, $total_price, $days) {
            $order = Order::create([
                'vehicle_id'     => $carRental->vehicle_id ?? $carRental->id,
                'user_id'        => Auth::check() ? Auth::id() : null,
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'trip_date'      => $request->trip_date,
                'quantity'       => $days,
                'total_price'    => $total_price,
                'status'         => 'pending',
                'notes'          => $request->input('notes', "Penyewaan unit: " . ($carRental->vehicle->name ?? $carRental->name)),
            ]);

            // Automatically create a Rental Schedule entry for car rentals
            \App\Models\RentalSchedule::create([
                'order_id'       => $order->id,
                'car_rental_id'  => $carRental->id,
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'start_date'     => $order->trip_date,
                'end_date'       => \Carbon\Carbon::parse($order->trip_date)->addDays($days),
                'rental_days'    => $days,
                'total_price'    => $total_price,
                'rental_status'  => 'booked',
                'notes'          => $order->notes,
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


        $waUrl = $this->generateWhatsAppUrl($order, $carRental);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan sewa mobil berhasil dikirim!',
                'order_id' => $order->id,
                'whatsapp_url' => $waUrl,
                'redirect' => route('booking.status', [
                    'order_id' => $order->id,
                    'phone'    => $request->customer_phone,
                ])
            ]);
        }

        return redirect()->route('booking.status', [
            'order_id' => $order->id,
            'phone'    => $request->customer_phone,
        ])->with('success', 'Pesanan sewa mobil berhasil dikirim!')
          ->with('whatsapp_url', $waUrl);
    }

    private function generateWhatsAppUrl(Order $order, CarRental $carRental)
    {
        $siteName      = \App\Models\Setting::get('site_name', 'NorthSumateraTrip');
        $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '6281298622143');

        $message  = "Halo {$siteName},\n\n";
        $message .= "Saya ingin memesan Sewa Mobil:\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Unit:* {$carRental->name}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*ID Pesanan:* #ORD-" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "\n";
        $message .= "*Nama:* {$order->customer_name}\n";
        $message .= "*Telepon:* {$order->customer_phone}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Tanggal Mulai:* " . \Carbon\Carbon::parse($order->trip_date)->format('d-m-Y') . "\n";
        $message .= "*Durasi:* {$order->quantity} Hari\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Total Pembayaran:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "\nMohon konfirmasi pesanan saya. Terima kasih.";

        return "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
    }
}
