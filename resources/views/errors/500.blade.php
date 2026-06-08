@extends('layouts.main')

@section('title', 'Terjadi Kesalahan - 500')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full text-center space-y-8">
        <div>
            <h1 class="text-9xl font-extrabold text-red-500 drop-shadow-md">500</h1>
            <h2 class="mt-6 text-3xl font-bold text-gray-900 tracking-tight sm:text-4xl">
                Internal Server Error
            </h2>
            <p class="mt-4 text-lg text-gray-500">
                Maaf, sedang terjadi kendala pada server kami. Silakan coba beberapa saat lagi.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
            <a href="{{ url('/') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-colors duration-200">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
