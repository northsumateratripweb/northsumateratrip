<?php

namespace App\Services;

use App\Repositories\Contracts\TourRepositoryInterface;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Models\Order;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class TourService
{
    protected $tourRepository;
    protected $carRepository;

    public function __construct(
        TourRepositoryInterface $tourRepository,
        CarRepositoryInterface $carRepository
    ) {
        $this->tourRepository = $tourRepository;
        $this->carRepository = $carRepository;
    }

    public function getLandingPageData($filters = [])
    {
        return [
            'filters' => $filters,
            'tours' => $this->tourRepository->with(['category'])->all(),
            'posts' => Blog::where('is_published', true)->latest()->take(3)->get(),
            'cars' => $this->carRepository->getAvailable(),
        ];
    }

    public function getTourBySlug($slug)
    {
        return [
            'tour' => $this->tourRepository->findBySlug($slug),
        ];
    }

    public function processCheckout($productId, array $data)
    {
        if (is_numeric($productId)) {
            $product = $this->tourRepository->findById($productId);
        } else {
            $product = $this->tourRepository->findBySlug($productId);
        }

        $quantity = $data['quantity'] ?? 1;
        $totalPrice = $product->price_min * $quantity; // Simple calculation for now

        $order = Order::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'customer_phone' => $data['phone'],
            'trip_date' => $data['date'],
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        // WhatsApp Notification
        try {
            $waMessage = "✨ *BOOKING BERHASIL* ✨\n\n";
            $waMessage .= "Halo *" . $order->customer_name . "*,\n";
            $waMessage .= "Terima kasih telah memesan di NorthSumateraTrip!\n\n";
            $waMessage .= "📋 *DETAIL PESANAN:*\n";
            $waMessage .= "• *Paket:* " . $product->name . "\n";
            $waMessage .= "• *Tgl Perjalanan:* " . $order->trip_date . "\n";
            $waMessage .= "• *Peserta:* " . $order->quantity . " Orang\n";
            $waMessage .= "• *Total:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n\n";
            $waMessage .= "Tim kami akan segera menghubungi Anda melalui WhatsApp ini. Terima kasih! 🙏";

            WhatsAppService::sendMessage($order->customer_phone, $waMessage);
        } catch (\Exception $e) {
            Log::error('WA Notification Error: ' . $e->getMessage());
        }

        return $order;
    }
}
