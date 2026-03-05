<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(StaticPage $page)
    {
        if (!$page->is_published) {
            abort(404);
        }

        return view('pages.static', compact('page'));
    }
}
