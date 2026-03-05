<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BookingStatusController extends Controller
{
    public function index(Request $request)
    {
        $orderId = $request->query('order_id');
        $phone   = $request->query('phone');

        if ($orderId && $phone) {
            // Validasi input
            if (!is_numeric($orderId) || strlen($phone) > 20) {
                return view('pages.booking-status');
            }

            $order = Order::with(['product', 'vehicle', 'tripSchedule.vehicle'])
                ->where('id', (int) $orderId)
                ->where('customer_phone', $phone)
                ->first();

            if ($order) {
                return view('pages.booking-status', compact('order'));
            }
        }

        return view('pages.booking-status');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|min:1',
            'phone'    => 'required|string|max:20',
        ]);

        $order = Order::with(['product', 'vehicle', 'tripSchedule.vehicle'])
            ->where('id', $validated['order_id'])
            ->where('customer_phone', $validated['phone'])
            ->first();

        if (! $order) {
            return redirect()->route('booking.status')
                ->with('error', 'Pesanan tidak ditemukan. Pastikan Order ID dan No. WhatsApp sudah benar.');
        }

        return view('pages.booking-status', compact('order'));
    }

    public function getStatus(Order $order, Request $request)

    {
        // Simple security: check if phone matches
        if ($request->phone !== $order->customer_phone) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => $order->status,
            'status_label' => $order->status_label ?? ucfirst($order->status),
            'payment_status' => $order->payment_status,
            'has_trip_schedule' => (bool) $order->tripSchedule,
            'trip_schedule_status' => $order->tripSchedule?->status_label ?? null,
        ]);
    }
}
