<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('pages.blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->take(4)
            ->get();

        $blog->increment('view_count');

        return view('pages.blogs.show', compact('blog', 'relatedBlogs'));
    }
}
