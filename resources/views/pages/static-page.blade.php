@extends('layouts.main')

@section('title', ($page->meta_title ?? $page->title) . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
<section class="pt-32 pb-16 bg-white min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-8">{{ $page->title }}</h1>
        <div class="prose prose-lg max-w-none text-slate-700">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
