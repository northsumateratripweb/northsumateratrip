<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CarRental;
use App\Models\Hotel;
use App\Models\InstagramFeed;
use App\Models\Partner;
use App\Models\Product;
use App\Models\PromotionBanner;
use App\Models\RentalPackage;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $data = \Illuminate\Support\Facades\Cache::remember('homepage_data', 3600, function () {
            return [
                'featuredProducts' => Product::active()
                    ->with('category')
                    ->featured()
                    ->orderBy('sort_order')
                    ->take(6)
                    ->get(),

                'carRentalProducts' => CarRental::available()
                    ->orderBy('sort_order')
                    ->take(4)
                    ->get(),

                'rentalPackageProducts' => RentalPackage::where('is_active', true)
                    ->orderBy('sort_order')
                    ->take(4)
                    ->get(),

                'galleryProducts' => Product::active()
                    ->orderBy('sort_order')
                    ->take(8)
                    ->get(),

                'latestBlogs' => Blog::published()
                    ->orderBy('published_at', 'desc')
                    ->take(4)
                    ->get(),

                'partners' => Partner::active()
                    ->orderBy('sort_order')
                    ->get(),

                'instagramFeeds' => InstagramFeed::active()
                    ->latest()
                    ->take(8)
                    ->get(),

                'testimonials' => Review::where('is_approved', true)
                    ->latest()
                    ->take(6)
                    ->get(),

                'promotionBanners' => PromotionBanner::active()
                    ->latest()
                    ->get(),

                'featuredHotels' => Hotel::active()
                    ->orderBy('rating', 'desc')
                    ->take(4)
                    ->get(),
            ];
        });

        return view('pages.home', $data);
    }
}
