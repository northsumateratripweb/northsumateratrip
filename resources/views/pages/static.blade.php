@extends('layouts.main')

@section('title', $page->title . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))
@section('meta_description', $page->meta_description ?? substr(strip_tags($page->content), 0, 160))

@section('content')
<div class="pt-32 pb-4 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-slate-600">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900">{{ $page->title }}</span>
        </nav>
    </div>
</div>

<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-8">{{ $page->title }}</h1>
        
        <div class="prose prose-lg max-w-none text-slate-700">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
