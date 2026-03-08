<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        $page = StaticPage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        if ($page->content_type === 'html') {
            return response($page->html_content);
        }

        return view('pages.static-page', compact('page'));
    }
}
