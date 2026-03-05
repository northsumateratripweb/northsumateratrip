<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::active()
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('pages.hotels.index', compact('hotels'));
    }
}
