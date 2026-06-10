<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use App\Models\Order;
use App\Models\RentalSchedule;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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

        if (! empty($validated['capacity'])) {
            if ($validated['capacity'] === '12+') {
                $query->where('capacity', '>=', 12);
            } else {
                $query->where('capacity', (int) $validated['capacity']);
            }
        }

        if (! empty($validated['transmission'])) {
            $query->where('transmission', $validated['transmission']);
        }

        if (! empty($validated['brand'])) {
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

    public function storeOrder(\App\Http\Requests\StoreCarRentalRequest $request, string $slug)
    {
        $carRental = is_numeric($slug)
            ? CarRental::find($slug)
            : CarRental::where('slug', $slug)->first();

        if (! $carRental) {
            abort(404);
        }

        $validated = $request->validated();
        $days = (int) $validated['quantity'];

        $total_price = \App\Services\PricingService::calculateCarRentalPrice($carRental, $days);

        $order = DB::transaction(function () use ($carRental, $validated, $total_price, $days) {
            $vehicleId = $carRental->vehicle_id ?: null;
            if (! $vehicleId && $carRental->vehicle) {
                $vehicleId = $carRental->vehicle->id;
            }
            $order = Order::create([
                'vehicle_id' => $vehicleId,
                'user_id' => Auth::check() ? Auth::id() : null,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'trip_date' => $validated['trip_date'],
                'quantity' => $days,
                'total_price' => $total_price,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? ('Penyewaan unit: '.($carRental->vehicle->name ?? $carRental->name)),
            ]);

            // Automatically create a Rental Schedule entry for car rentals
            RentalSchedule::create([
                'order_id' => $order->id,
                'car_rental_id' => $carRental->id,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'start_date' => $order->trip_date,
                'end_date' => Carbon::parse($order->trip_date)->addDays($days),
                'rental_days' => $days,
                'total_price' => $total_price,
                'rental_status' => 'booked',
                'notes' => $order->notes,
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

        $waUrl = \App\Services\WhatsAppService::generateCarRentalMessage($order, $carRental);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan sewa mobil berhasil dikirim!',
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
        ])->with('success', 'Pesanan sewa mobil berhasil dikirim!')
            ->with('whatsapp_url', $waUrl);
    }
}
