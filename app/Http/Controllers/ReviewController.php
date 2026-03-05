<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        // Cek duplikat review dalam 24 jam terakhir (berdasarkan email atau IP)
        $identifier = $validated['customer_email'] ?? $request->ip();
        $recentReview = Review::where('product_id', $product->id)
            ->where(function ($q) use ($identifier, $request) {
                $q->where('customer_email', $identifier)
                  ->orWhere('ip_address', $request->ip());
            })
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($recentReview) {
            return redirect()->back()->with('error', 'Anda sudah mengirim review untuk produk ini dalam 24 jam terakhir.');
        }

        $validated['product_id'] = $product->id;
        $validated['is_approved'] = false;
        $validated['ip_address'] = $request->ip();

        Review::create($validated);

        return redirect()->back()->with('success', 'Terima kasih! Review Anda telah terkirim dan akan ditinjau oleh tim kami.');
    }
}
