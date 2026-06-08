@extends('layouts.main')

@section('title', 'Halaman Tidak Ditemukan - 404')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full text-center space-y-8">
        <div>
            <h1 class="text-9xl font-extrabold text-blue-600 drop-shadow-md">404</h1>
            <h2 class="mt-6 text-3xl font-bold text-gray-900 tracking-tight sm:text-4xl">
                Oops! Halaman Tidak Ditemukan
            </h2>
            <p class="mt-4 text-lg text-gray-500">
                Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
            <a href="{{ url('/') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="{{ url('/contact') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
@endsection
