<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query()->where('is_active', true)->orderBy('sort_order');

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $galleries = $query->paginate(24);
        $categories = Gallery::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();

        return view('pages.gallery', compact('galleries', 'categories', 'category'));
    }
}
