<?php

namespace App\Http\Controllers;

use App\Models\RentalPackage;
use App\Models\Order;
use App\Models\PackageRentalSchedule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentalPackageController extends Controller
{
    public function show($slug)
    {
        $package = RentalPackage::where('slug', $slug)->firstOrFail();
        $relatedPackages = RentalPackage::where('id', '!=', $package->id)->where('is_active', true)->limit(3)->get();
        
        return view('pages.rental-package-show', compact('package', 'relatedPackages'));
    }

    public function storeOrder(Request $request, $slug)
    {
        $package = RentalPackage::where('slug', $slug)->firstOrFail();

        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'start_date'     => 'required|date|after_or_equal:today',
            'rental_days'    => 'required|integer|min:' . ($package->min_rental_days ?? 1),
            'number_of_people' => 'nullable|integer|min:1',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $total_price = $package->price_per_day * (int) $request->rental_days;

        $order = DB::transaction(function () use ($package, $request, $total_price) {
            $order = Order::create([
                'rental_package_id' => $package->id,
                'user_id'           => Auth::id(),
                'customer_name'     => $request->customer_name,
                'customer_email'    => $request->customer_email,
                'customer_phone'    => $request->customer_phone,
                'trip_date'         => $request->start_date,
                'trip_end_date'     => Carbon::parse($request->start_date)->addDays((int) $request->rental_days),
                'quantity'          => (int) $request->rental_days,
                'total_price'       => $total_price,
                'status'            => 'pending',
                'notes'             => $request->notes ?? "Pemesanan Paket: " . $package->name,
            ]);

            // Automatically create a Package Rental Schedule entry
            PackageRentalSchedule::create([
                'order_id'          => $order->id,
                'rental_package_id' => $package->id,
                'customer_name'     => $request->customer_name,
                'customer_phone'    => $request->customer_phone,
                'customer_email'    => $request->customer_email,
                'start_date'        => $request->start_date,
                'end_date'          => Carbon::parse($request->start_date)->addDays((int) $request->rental_days),
                'rental_days'       => (int) $request->rental_days,
                'number_of_people'  => $request->number_of_people ?? 1,
                'total_price'       => $total_price,
                'payment_status'    => 'pending',
                'booking_status'    => 'confirmed',
                'special_requests'  => $order->notes,
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


        $waUrl = $this->generateWhatsAppUrl($order, $package);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan paket rental berhasil dikirim!',
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
        ])->with('success', 'Pesanan paket rental berhasil dikirim!')
          ->with('whatsapp_url', $waUrl);
    }

    private function generateWhatsAppUrl(Order $order, RentalPackage $package)
    {
        $siteName      = Setting::get('site_name', 'NorthSumateraTrip');
        $whatsappNumber = Setting::get('whatsapp_number', '6281298622143');

        $message  = "Halo {$siteName},\n\n";
        $message .= "Saya ingin memesan Paket Rental:\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Paket:* {$package->name}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*ID Pesanan:* #ORD-" . str_pad($order->id, 5, '0', STR_PAD_LEFT) . "\n";
        $message .= "*Nama:* {$order->customer_name}\n";
        $message .= "*Telepon:* {$order->customer_phone}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Tanggal Mulai:* " . Carbon::parse($order->trip_date)->format('d-m-Y') . "\n";
        $message .= "*Durasi:* {$order->quantity} Hari\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "*Total Pembayaran:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "\nMohon konfirmasi pesanan saya. Terima kasih.";

        return "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
    }
}
