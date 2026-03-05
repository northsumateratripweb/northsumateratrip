<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = null;
        $products = Product::active()
            ->with('category')
            ->orderBy('sort_order');

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $products = $products->where('category_id', $category->id);
        }

        $products = $products->paginate(12);
        $categories = Category::active()->orderBy('sort_order')->get();

        return view('pages.products.index', compact('products', 'categories', 'category'));
    }

    public function show(Category $category, Product $product)
    {
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = $product->approvedReviews()
            ->latest()
            ->take(10)
            ->get();

        $hotels = \App\Models\Hotel::active()->orderBy('name')->limit(50)->get();

        return view('pages.products.show', compact('product', 'relatedProducts', 'reviews', 'hotels'));
    }

    public function category(Category $category)
    {
        $products = Product::active()
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
            'searchQuery' => $query
        ]);
    }
}
