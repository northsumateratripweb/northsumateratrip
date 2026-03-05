<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::active()->select('slug', 'category_id', 'updated_at')->with('category:id,slug')->get();
        $categories = Category::active()->select('slug', 'updated_at')->get();
        $blogs = Blog::published()->select('slug', 'updated_at')->get();
        $pages = StaticPage::where('is_published', true)->select('slug', 'updated_at')->get();
        $cars = \App\Models\CarRental::where('is_available', true)->select('slug', 'updated_at')->get();
        $rentalPackages = \App\Models\RentalPackage::where('is_active', true)->select('slug', 'updated_at')->get();

        return response()->view('sitemap', [
            'products' => $products,
            'categories' => $categories,
            'blogs' => $blogs,
            'pages' => $pages,
            'cars' => $cars,
            'rentalPackages' => $rentalPackages,
        ])->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $siteUrl = url('/');
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Sitemap: {$siteUrl}/sitemap.xml\n";

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
