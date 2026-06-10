<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PackageRentalSchedule;
use App\Models\RentalPackage;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class RentalPackageController extends Controller
{
    public function show($slug)
    {
        $package = RentalPackage::where('slug', $slug)->firstOrFail();
        $relatedPackages = RentalPackage::where('id', '!=', $package->id)->where('is_active', true)->limit(3)->get();

        return view('pages.rental-package-show', compact('package', 'relatedPackages'));
    }

    public function storeOrder(\App\Http\Requests\StoreRentalPackageRequest $request, $slug)
    {
        $package = RentalPackage::where('slug', $slug)->firstOrFail();

        $validated = $request->validated();
        $days = (int) $validated['rental_days'];

        $total_price = \App\Services\PricingService::calculateRentalPackagePrice($package, $days);

        $order = DB::transaction(function () use ($package, $validated, $total_price, $days) {
            $order = Order::create([
                'rental_package_id' => $package->id,
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'trip_date' => $validated['start_date'],
                'trip_end_date' => Carbon::parse($validated['start_date'])->addDays($days),
                'quantity' => $days,
                'total_price' => $total_price,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? 'Pemesanan Paket: '.$package->name,
            ]);

            // Automatically create a Package Rental Schedule entry
            PackageRentalSchedule::create([
                'order_id' => $order->id,
                'rental_package_id' => $package->id,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'start_date' => $validated['start_date'],
                'end_date' => Carbon::parse($validated['start_date'])->addDays($days),
                'rental_days' => $days,
                'number_of_people' => $validated['number_of_people'] ?? 1,
                'total_price' => $total_price,
                'payment_status' => 'pending',
                'booking_status' => 'confirmed',
                'special_requests' => $order->notes,
            ]);

            // Notify admins
            try {
                $admins = User::all();
                Notification::send($admins, new NewOrderNotification($order));
            } catch (\Throwable $e) {
                \Log::error('Notification Error: '.$e->getMessage());
            }

            return $order;
        });

        $waUrl = \App\Services\WhatsAppService::generateRentalPackageMessage($order, $package);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan paket rental berhasil dikirim!',
                'order_id' => $order->id,
                'whatsapp_url' => $waUrl,
                'redirect' => route('booking.status', [
                    'order_id' => $order->id,
                    'phone' => $validated['customer_phone'],
                ]),
            ]);
        }

        return redirect()->route('booking.status', [
            'order_id' => $order->id,
            'phone' => $validated['customer_phone'],
        ])->with('success', 'Pesanan paket rental berhasil dikirim!')
            ->with('whatsapp_url', $waUrl);
    }
}
