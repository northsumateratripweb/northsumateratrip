<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function orderPdf(Order $order)
    {
        // Authorization: harus login
        if (!auth()->check()) {
            abort(403);
        }

        // Admin (Filament) atau pemilik order bisa akses
        $user = auth()->user();
        $isAdmin = method_exists($user, 'canAccessPanel');
        if (!$isAdmin && $user->id !== $order->user_id) {
            abort(403);
        }

        $order->load(['product', 'vehicle', 'rentalPackage']);

        // Data for invoice
        $data = [
            'order' => $order,
            'product' => $order->product,
            'vehicle' => $order->vehicle,
            'rentalPackage' => $order->rentalPackage,
            'hotels' => [
                $order->hotel_1,
                $order->hotel_2,
                $order->hotel_3,
                $order->hotel_4
            ]
        ];

        $pdf = Pdf::loadView('pages.invoice', $data)->setPaper('a4', 'portrait');

        $filename = 'Invoice-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    public function itineraryPdf(Product $product)
    {
        $pdf = Pdf::loadView('pages.invoice', [
            'product' => $product,
            'order' => null,
        ])->setPaper('a4', 'portrait');

        $filename = 'Itinerary-' . $product->slug . '.pdf';

        return $pdf->download($filename);
    }

    public function brochurePdf(Product $product)
    {
        $product->load(['category']);
        $category = $product->category;

        $pdf = Pdf::loadView('pages.brochure', [
            'product' => $product,
            'category' => $category,
        ])->setPaper('a4', 'portrait');

        $filename = 'Brochure-' . $product->slug . '.pdf';

        return $pdf->download($filename);
    }
}
