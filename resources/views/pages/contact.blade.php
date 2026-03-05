@extends('layouts.main')

@section('title', 'Hubungi Kami - NorthSumateraTrip')

@section('content')
<!-- Page Header -->
<div class="pt-36 md:pt-48 pb-20 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="max-w-3xl mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Get in Touch</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
            Hubungi <span class="text-blue-600">Kami</span>
        </h1>
        <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
            Ada pertanyaan? Kami siap membantu Anda merencanakan perjalanan wisata terbaik di Sumatera Utara.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Contact Info -->
        <div>
            <div class="space-y-5 mb-10">
                <!-- WhatsApp -->
                <div class="flex items-start gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.04] hover:-translate-y-0.5">
                    <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-emerald-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">WhatsApp</h3>
                        <p class="text-slate-500 text-sm mb-1.5">{{ $settings['whatsapp_display'] ?? '+62 812-9862-2143' }}</p>
                        <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '6281298622143' }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-700 text-xs font-bold inline-flex items-center gap-1 group">
                            Chat sekarang <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="flex items-start gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.04] hover:-translate-y-0.5">
                    <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-blue-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Email</h3>
                        <p class="text-slate-500 text-sm mb-1.5">{{ $settings['site_email'] ?? 'hello@northsumateratrip.com' }}</p>
                        <a href="mailto:{{ $settings['site_email'] ?? 'hello@northsumateratrip.com' }}" 
                           class="text-blue-600 hover:text-blue-700 text-xs font-bold inline-flex items-center gap-1 group">
                            Kirim email <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Address -->
                <div class="flex items-start gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.04] hover:-translate-y-0.5">
                    <div class="w-11 h-11 bg-rose-50 dark:bg-rose-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-rose-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Alamat</h3>
                        <p class="text-slate-500 text-sm">{{ $settings['site_address'] ?? 'Sumatera Utara, Indonesia' }}</p>
                    </div>
                </div>
                
                <!-- Business Hours -->
                <div class="flex items-start gap-4 p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/[0.04] hover:-translate-y-0.5">
                    <div class="w-11 h-11 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-amber-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Jam Operasional</h3>
                        <p class="text-slate-500 text-sm">Senin - Minggu: 08:00 - 20:00 WIB</p>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ikuti Kami</h3>
                <div class="flex gap-3">
                    @if($settings['facebook_url'] ?? false)
                    <a href="{{ $settings['facebook_url'] }}" target="_blank" 
                       class="w-10 h-10 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-300">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    @endif
                    @if($settings['instagram_url'] ?? false)
                    <a href="{{ $settings['instagram_url'] }}" target="_blank" 
                       class="w-10 h-10 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-400 rounded-xl flex items-center justify-center hover:bg-gradient-to-r hover:from-purple-500 hover:via-pink-500 hover:to-orange-500 hover:text-white hover:border-transparent transition-all duration-300">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    @endif
                    @if($settings['tiktok_url'] ?? false)
                    <a href="{{ $settings['tiktok_url'] }}" target="_blank" 
                       class="w-10 h-10 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-400 rounded-xl flex items-center justify-center hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-300">
                        <i class="fab fa-tiktok text-sm"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-7 md:p-8">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Kirim Pesan</h2>
            
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif
            
            <form action="{{ route('contact.submit') }}" method="POST" data-ajax>
                @csrf
                
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-400 @enderror"
                               placeholder="Masukkan nama lengkap">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-400 @enderror"
                               placeholder="Masukkan email">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('phone') border-red-400 @enderror"
                               placeholder="Contoh: 08123456789">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="4"
                                  class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('message') border-red-400 @enderror"
                                  placeholder="Tulis pesan Anda...">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 hover:scale-[1.01]">
                        <i class="fas fa-paper-plane text-sm"></i>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Map Section -->
<section class="pb-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254759.34723920093!2d98.5550337!3d3.5952472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303131db7687c6b7%3A0x74d7e7a9e1e0437a!2sMedan%2C%20Kota%20Medan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-slate-50 dark:bg-slate-900/50" x-data="{ openFaq: null }">
    <div class="max-w-3xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-14">
            <div class="flex items-center gap-3 justify-center mb-5">
                <div class="w-8 h-0.5 bg-blue-600"></div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">FAQ</span>
                <div class="w-8 h-0.5 bg-blue-600"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pertanyaan yang Sering Ditanyakan</h2>
        </div>
        
        <div class="space-y-3">
            @foreach([
                ['q' => 'Bagaimana cara memesan paket trip?', 'a' => 'Anda dapat memesan melalui WhatsApp, mengisi formulir kontak, atau langsung menekan tombol "Book Now" pada halaman produk yang diinginkan.'],
                ['q' => 'Apakah bisa custom itinerary?', 'a' => 'Ya, kami menerima custom itinerary sesuai keinginan Anda. Silakan hubungi kami untuk diskusi lebih lanjut.'],
                ['q' => 'Bagaimana sistem pembayarannya?', 'a' => 'Kami menggunakan sistem down payment (DP) untuk memesan trip. Pelunasan dapat dilakukan pada hari H atau sesuai kesepakatan.'],
                ['q' => 'Apakah ada biaya tambahan yang tidak termasuk?', 'a' => 'Biaya yang tidak termasuk biasanya meliputi tiket masuk objek wisata, makanan dan minuman pribadi, serta pengeluaran pribadi lainnya.'],
            ] as $i => $faq)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border transition-all duration-300"
                 :class="openFaq === {{ $i }} ? 'border-blue-200 dark:border-blue-800 shadow-lg shadow-blue-900/[0.04]' : 'border-slate-100 dark:border-slate-800'">
                <button class="w-full px-6 py-4.5 text-left font-bold text-sm flex justify-between items-center gap-4 transition-colors"
                        :class="openFaq === {{ $i }} ? 'text-blue-600' : 'text-slate-700 dark:text-slate-300'"
                        @click="openFaq = openFaq === {{ $i }} ? null : {{ $i }}">
                    <span>{{ $faq['q'] }}</span>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-300"
                         :class="openFaq === {{ $i }} ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 rotate-180' : 'bg-slate-50 dark:bg-slate-800 text-slate-400'">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="openFaq === {{ $i }}" x-collapse x-cloak
                     class="px-6 pb-5 text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
