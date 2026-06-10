<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TripSchedule;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(\App\Http\Requests\StoreOrderRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();

            $adultPax = (int) $validated['pax_adult'];
            $childPax = (int) $validated['pax_child'];
            
            $totalTourPrice = \App\Services\PricingService::calculateTourPrice($product, $adultPax, $childPax);
            $droneFee = ! empty($validated['use_drone']) ? (float) ($product->drone_price ?? 1500000) : 0;
            $totalPrice = $totalTourPrice + $droneFee;

            $order = DB::transaction(function () use ($product, $validated, $adultPax, $childPax, $totalPrice) {
                $order = Order::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'] ?? null,
                    'customer_phone' => $validated['customer_phone'],
                    'customer_whatsapp' => $validated['customer_whatsapp'] ?? $validated['customer_phone'],
                    'trip_date' => $validated['trip_date'],
                    'trip_end_date' => $validated['trip_end_date'] ?? null,
                    'trip_type' => $validated['trip_type'] ?? null,
                    'pax_adult' => $adultPax,
                    'pax_child' => $childPax,
                    'quantity' => $adultPax + $childPax,
                    'total_price' => (float) $totalPrice,
                    'status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                    'hotel_category' => $validated['hotel_category'] ?? null,
                    'hotel_1' => $validated['hotel_1'] ?? null,
                    'hotel_2' => $validated['hotel_2'] ?? null,
                    'hotel_3' => $validated['hotel_3'] ?? null,
                    'hotel_4' => $validated['hotel_4'] ?? null,
                    'flight_info' => $validated['flight_info'] ?? null,
                    'use_drone' => ! empty($validated['use_drone']),
                ]);

                // Automatically create a Trip Schedule entry so it appears in "Jadwal Trip"
                TripSchedule::create([
                    'order_id' => $order->id,
                    'trip_date' => $order->trip_date,
                    'status' => 'scheduled',
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

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil disimpan.',
                'order_id' => $order->id,
                'whatsapp_url' => \App\Services\WhatsAppService::generateTourOrderMessage($order, $product),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terdapat kesalahan pada isian form.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Order Store Exception: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: '.$e->getMessage(),
            ], 500);
        }
    }
}
