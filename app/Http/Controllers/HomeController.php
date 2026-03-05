<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Hotel;
use App\Models\InstagramFeed;
use App\Models\Partner;
use App\Models\Product;
use App\Models\PromotionBanner;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()
            ->featured()
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $carRentalProducts = \App\Models\CarRental::available()
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $rentalPackageProducts = \App\Models\RentalPackage::where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $galleryProducts = Product::active()
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $latestBlogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        $partners = Partner::active()
            ->orderBy('sort_order')
            ->get();

        $instagramFeeds = InstagramFeed::active()
            ->latest()
            ->take(8)
            ->get();

        $testimonials = \App\Models\Review::where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();

        $promotionBanners = PromotionBanner::active()
            ->latest()
            ->get();

        $featuredHotels = Hotel::active()
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();

        return view('pages.home', compact(
            'featuredProducts',
            'carRentalProducts',
            'rentalPackageProducts',
            'galleryProducts',
            'latestBlogs',
            'partners',
            'instagramFeeds',
            'testimonials',
            'promotionBanners',
            'featuredHotels'
        ));
    }
}
