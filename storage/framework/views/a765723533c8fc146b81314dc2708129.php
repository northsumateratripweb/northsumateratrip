<div class="fixed bottom-6 right-6 z-50">
    <?php
        $waNumber = \App\Models\Setting::get('whatsapp_number', '6281298622143');
        $siteName = \App\Models\Setting::get('site_name', 'NorthSumateraTrip');
        $message = urlencode("Halo {$siteName}, saya ingin bertanya mengenai paket wisata/rental mobil.");
        $waLink = "https://wa.me/{$waNumber}?text={$message}";
    ?>

    <a href="<?php echo e($waLink); ?>" target="_blank"
        class="flex items-center justify-center w-14 h-14 bg-green-500 rounded-full text-white shadow-lg hover:bg-green-600 transition duration-300 hover:scale-110 animate-bounce cursor-pointer relative group">
        
        <!-- Tooltip -->
        <span class="absolute right-16 px-3 py-1.5 bg-white text-gray-800 text-sm font-semibold rounded-lg shadow-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap hidden md:block">
            Chat dengan Kami!
            <div class="absolute -right-1 top-1/2 transform -translate-y-1/2 w-3 h-3 bg-white rotate-45"></div>
        </span>

        <!-- SVG WhatsApp Icon -->
        <svg xmlns="http://www.w3.org/Data/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.898-4.45 9.899-9.896 0-2.639-1.027-5.119-2.893-6.985-1.866-1.866-4.346-2.893-6.985-2.894-5.45 0-9.899 4.45-9.899 9.896 0 1.712.435 3.292 1.288 4.79l-.797 2.91 2.996-.793zm11.592-8.213c-.226-.113-1.339-.661-1.547-.736-.208-.075-.361-.113-.513.113-.153.226-.583.736-.714.887-.132.151-.264.17-.49.057-.226-.113-.956-.352-1.821-1.127-.674-.604-1.129-1.35-1.261-1.576-.132-.226-.014-.348.099-.46.103-.102.226-.264.339-.396.113-.132.151-.226.226-.377.075-.151.038-.283-.019-.396-.057-.113-.513-1.24-.703-1.698-.185-.445-.373-.385-.513-.393-.132-.007-.282-.01-.433-.01-.151 0-.396.057-.604.283-.208.226-.792.774-.792 1.887s.811 2.189.924 2.34c.113.151 1.595 2.436 3.864 3.414.54.231.961.37 1.291.474.542.171 1.037.147 1.427.089.435-.065 1.339-.547 1.528-1.075.189-.528.189-.981.132-1.075-.057-.094-.208-.151-.434-.264z"/>
        </svg>

        <!-- Ping Animation Ring -->
        <span class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-30 animate-ping -z-10"></span>
    </a>
</div>
<?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\components\whatsapp-floating.blade.php ENDPATH**/ ?>