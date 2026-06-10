<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hotel;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->category;

        $cacheKey = 'products_index_page_' . ($categorySlug ?? 'all') . '_page_' . $request->get('page', 1);

        $data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 600, function () use ($categorySlug) {
            $category = null;
            $products = Product::active()
                ->with(['category', 'reviews'])
                ->orderBy('sort_order');

            if ($categorySlug) {
                $category = Category::where('slug', $categorySlug)->firstOrFail();
                $products = $products->where('category_id', $category->id);
            }

            return [
                'category' => $category,
                'products' => $products->paginate(12),
                'categories' => Category::active()->orderBy('sort_order')->get()
            ];
        });

        return view('pages.products.index', $data);
    }

    public function show(Category $category, Product $product)
    {
        $cacheKey = 'product_show_' . $product->id;

        $data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 600, function () use ($product) {
            return [
                'product' => $product->loadMissing(['category', 'reviews']),
                'relatedProducts' => Product::active()
                    ->with(['category'])
                    ->where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->take(4)
                    ->get(),
                'reviews' => $product->approvedReviews()
                    ->latest()
                    ->take(10)
                    ->get(),
                'hotels' => Hotel::active()->orderBy('name')->limit(50)->get()
            ];
        });

        return view('pages.products.show', $data);
    }

    public function category(Category $category)
    {
        $products = Product::active()
            ->with(['category', 'reviews'])
            ->where('category_id', $category->id)
            ->orderBy('sort_order')
            ->paginate(12);

        $categories = Category::active()->orderBy('sort_order')->get();

        return view('pages.products.category', compact('products', 'category', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->validate([
            'q' => 'nullable|string|max:100',
        ])['q'] ?? null;

        // Escape LIKE wildcards
        $searchTerm = $query ? str_replace(['%', '_'], ['\%', '\_'], $query) : null;

        $products = Product::active()
            ->with(['category', 'reviews'])
            ->when($searchTerm, function ($q) use ($searchTerm) {
                return $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', function ($catQ) use ($searchTerm) {
                        $catQ->where('name', 'like', "%{$searchTerm}%");
                    });
            })
            ->orderBy('sort_order')
            ->paginate(12);

        $categories = Category::active()->orderBy('sort_order')->get();

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'category' => null,
            'searchQuery' => $query,
        ]);
    }
}
