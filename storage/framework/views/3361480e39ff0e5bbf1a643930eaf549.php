

<?php $__env->startSection('title', $product->translate('name') . ' - NorthSumateraTrip'); ?>
<?php $__env->startSection('meta_description', $product->meta_description ?? $product->translate('short_description')); ?>
<?php $__env->startSection('og_image', $product->image_url); ?>
<?php $__env->startSection('canonical', route('products.show', [$product->category?->slug ?? 'uncategorized', $product->slug])); ?>

<?php $__env->startPush('schema'); ?>
    <?php echo \App\Helpers\SchemaHelper::product($product); ?>

    <?php echo \App\Helpers\SchemaHelper::breadcrumbs([
        'Home' => route('home'),
        $product->category?->name ?? 'Paket' => route('products.category', $product->category?->slug ?? 'uncategorized'),
        $product->translate('name') => url()->current()
    ]); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<style>
    [x-cloak] { display: none !important; }
    .image-fade { transition: opacity 0.3s ease-in-out; }
    
    /* Modern Timeline Style for Rich Text Itinerary */
    .itinerary-timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    .itinerary-timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 2rem;
        bottom: 2rem;
        width: 2px;
        background: #E2E8F0; /* slate-200 */
        border-radius: 4px;
    }
    .itinerary-timeline h2, .itinerary-timeline h3, .itinerary-timeline h4 {
        position: relative;
        color: #1E40AF !important; /* blue-800 */
        font-weight: 800 !important;
        margin-top: 2.5rem !important;
        margin-bottom: 1rem !important;
        padding-left: 1rem;
    }
    .itinerary-timeline h2:first-child, .itinerary-timeline h3:first-child, .itinerary-timeline h4:first-child {
        margin-top: 0 !important;
    }
    .itinerary-timeline h2::before, .itinerary-timeline h3::before, .itinerary-timeline h4::before {
        content: '';
        position: absolute;
        left: -1.35rem; /* align with the vertical line */
        top: 50%;
        transform: translateY(-50%);
        width: 1.25rem;
        height: 1.25rem;
        background-color: #3B82F6; /* blue-500 */
        border: 4px solid #DBEAFE; /* blue-100 */
        border-radius: 50%;
        z-index: 10;
        box-shadow: 0 0 0 4px white;
    }
    .itinerary-timeline p, .itinerary-timeline ul, .itinerary-timeline ol {
        background: #F8FAFC; /* slate-50 */
        padding: 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid #F1F5F9; /* slate-100 */
        margin-bottom: 1rem;
        margin-left: 1rem;
        color: #475569;
        line-height: 1.7;
    }
    .itinerary-timeline ul {
        list-style-type: none !important;
        padding-left: 2rem !important;
    }
    .itinerary-timeline ul li {
        position: relative;
        margin-bottom: 0.5rem;
    }
    .itinerary-timeline ul li::before {
        content: '\f10c'; /* FontAwesome circle */
        font-family: 'Font Awesome 6 Free';
        font-weight: 400;
        font-size: 0.5rem;
        position: absolute;
        left: -1.25rem;
        top: 0.5rem;
        color: #3B82F6; /* blue-500 */
    }
    .itinerary-timeline strong {
        color: #0F172A;
    }
</style>
<!-- Breadcrumb -->
<div class="pt-28 pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-blue-600 transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <a href="<?php echo e(route('products.category', $product->category?->slug ?? 'uncategorized')); ?>" class="hover:text-blue-600 transition-colors"><?php echo e($product->category?->name ?? 'Paket'); ?></a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-700 font-semibold"><?php echo e($product->translate('name')); ?></span>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Gallery -->
            <div>
                <!-- Main Image -->
                <div class="relative rounded-2xl overflow-hidden mb-4 cursor-zoom-in" onclick="openLightbox(document.getElementById('main-image').src, '<?php echo e($product->translate('name')); ?>')">
                    <img id="main-image" 
                         src="<?php echo e($product->image_url); ?>" 
                         alt="<?php echo e($product->translate('name')); ?>" 
                         class="w-full h-96 object-cover image-fade opacity-100">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->location_tag): ?>
                    <div class="absolute top-4 left-4 bg-blue-600/90 backdrop-blur-sm text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-[10px]"></i>
                        <?php echo e($product->location_tag); ?>

                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <!-- Thumbnail Gallery -->
                <?php $allImages = $product->all_image_urls; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($allImages) > 1): ?>
                <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imageUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button onclick="changeImage(event, '<?php echo e($imageUrl); ?>')"
                            class="thumbnail-btn flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 <?php echo e($index === 0 ? 'border-blue-600' : 'border-transparent'); ?> hover:border-blue-600 transition-colors">
                        <img src="<?php echo e($imageUrl); ?>"
                             alt="<?php echo e($product->translate('name')); ?>"
                             class="w-full h-full object-cover">
                    </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div>
                <!-- Pre-order Badge -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->pre_order_info): ?>
                <div class="inline-block bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
                    <?php echo e($product->pre_order_info); ?>

                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <!-- Title -->
                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 dark:text-white tracking-tight mb-4"><?php echo e($product->translate('name')); ?></h1>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i <= $product->rating): ?>
                                <i class="fas fa-star"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <span class="text-slate-500 ml-2">(<?php echo e($product->review_count); ?> <?php echo e(__('ui.reviews')); ?>)</span>
                </div>
                
                <!-- Price & Brochure -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                    <div class="text-3xl font-extrabold text-blue-600">
                        <?php echo e(currency($product->price_min)); ?>

                        <span class="text-sm font-normal text-slate-500 block mt-1 uppercase tracking-widest"><?php echo e(__('ui.starting_from')); ?></span>
                    </div>
                    <a href="<?php echo e(route('product.brochure', $product->slug)); ?>" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border border-slate-200">
                        <i class="fas fa-file-pdf text-red-500"></i>
                        Download Brochure
                    </a>
                </div>
                
                <!-- Full Booking Form -->
                <style>[x-cloak] { display: none !important; }</style>

                <div id="booking-panel" 
                     x-data="bookingForm()" 
                     class="rounded-2xl overflow-hidden border border-slate-200 shadow-xl bg-white mb-6 relative">
                    
                    
                    <div x-show="submitting" x-cloak 
                         class="absolute inset-0 z-[100] bg-white/80 backdrop-blur-sm flex items-center justify-center p-8 text-center animate-fade-in">
                        <div class="space-y-4">
                            <div class="w-16 h-16 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
                            <p class="text-sm font-bold text-blue-600 uppercase tracking-wider animate-pulse">Memproses Pesanan...</p>
                        </div>
                    </div>

                    
                    <div class="flex bg-white border-b border-slate-200">
                        <div class="flex-1 py-3 text-center step-indicator" :class="step >= 1 ? 'active-step' : ''">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-sm font-bold mr-1"
                                  :class="step >= 1 ? (step > 1 ? 'bg-green-400 text-white' : 'bg-blue-600 text-white') : 'bg-slate-100 text-slate-500'"
                                  x-text="step > 1 ? '✓' : '1'"></span>
                            <span class="text-xs font-semibold uppercase tracking-wide"
                                  :class="step >= 1 ? 'text-blue-600' : 'text-slate-400'"><?php echo e(__('ui.step_trip')); ?></span>
                        </div>
                        <div class="flex-1 py-3 text-center step-indicator" :class="step >= 2 ? 'active-step' : ''">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-sm font-bold mr-1"
                                  :class="step >= 2 ? (step > 2 ? 'bg-green-400 text-white' : 'bg-blue-600 text-white') : 'bg-slate-100 text-slate-500'"
                                  x-text="step > 2 ? '✓' : '2'"></span>
                            <span class="text-xs font-semibold uppercase tracking-wide"
                                  :class="step >= 2 ? 'text-blue-600' : 'text-slate-400'"><?php echo e(__('ui.step_contact')); ?></span>
                        </div>
                        <div class="flex-1 py-3 text-center step-indicator" :class="step >= 3 ? 'active-step' : ''">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-sm font-bold mr-1"
                                  :class="step >= 3 ? (lastOrderId ? 'bg-green-500 text-white' : 'bg-blue-600 text-white') : 'bg-slate-100 text-slate-500'"
                                  x-text="lastOrderId ? '✓' : '3'"></span>
                            <span class="text-xs font-semibold uppercase tracking-wide"
                                  :class="step >= 3 ? 'text-blue-600' : 'text-slate-400'"><?php echo e(__('ui.step_confirm')); ?></span>
                        </div>
                    </div>

                    <form id="booking-form" class="bg-slate-50 m-0">
                        <?php echo csrf_field(); ?>

                        
                        <div x-show="step === 1" class="booking-step p-5 space-y-5">
                            <input type="hidden" name="trip_type" value="">

                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Dewasa (Adult)</p>
                                    <div class="relative">
                                        <input type="number" name="pax_adult" x-model="pax" list="list-pax-adult" min="1"
                                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               placeholder="Jumlah">
                                        <datalist id="list-pax-adult">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 15; $i++): ?>
                                            <option value="<?php echo e($i); ?>">
                                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </datalist>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Anak (<= 8 Thn)</p>
                                    <div class="relative">
                                        <input type="number" name="pax_child" x-model="paxChild" list="list-pax-child" min="0"
                                               class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               placeholder="Jumlah">
                                        <datalist id="list-pax-child">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i <= 10; $i++): ?>
                                            <option value="<?php echo e($i); ?>">
                                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </datalist>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-blue-500 uppercase font-bold tracking-wider"><?php echo e(__('ui.total_price')); ?></p>
                                    <p class="text-lg font-bold text-blue-700" x-text="formatCurrency(totalPrice)"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider" x-text="pax + ' <?php echo e(__('ui.person')); ?>'"></p>
                                    <p class="text-xs text-blue-600 font-medium" x-text="formatCurrency(pricePerPax) + '/<?php echo e(__('ui.person')); ?>'"></p>
                                </div>
                            </div>

                            <button type="button" @click="step = 2; scrollToForm();"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20">
                                <?php echo e(__('ui.read_more')); ?> <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                        </div>

                        
                        <div x-show="step === 2" x-cloak class="booking-step p-5 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Data Diri</p>

                            <div>
                                <input type="text" name="customer_name" x-model="formData.name"
                                       placeholder="Nama Lengkap *"
                                       :class="errors.name ? 'border-red-500 ring-1 ring-red-200' : 'border-slate-200'"
                                       class="w-full bg-white border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p x-show="errors.name" class="text-xs text-red-500 mt-1 ml-1" x-text="errors.name"></p>
                            </div>
                            <div>
                                <input type="email" name="customer_email" x-model="formData.email"
                                       placeholder="Alamat Email (Opsional)"
                                       class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <input type="tel" name="customer_phone" x-model="formData.phone"
                                       placeholder="Nomor WhatsApp / No. Telepon *"
                                       :class="errors.phone ? 'border-red-500 ring-1 ring-red-200' : 'border-slate-200'"
                                       class="w-full bg-white border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p x-show="errors.phone" class="text-xs text-red-500 mt-1 ml-1" x-text="errors.phone"></p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Berangkat *</label>
                                    <input type="date" name="trip_date" x-model="formData.date"
                                           :class="errors.date ? 'border-red-500 ring-1 ring-red-200' : 'border-slate-200'"
                                           class="w-full bg-white border rounded-xl px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <p x-show="errors.date" class="text-xs text-red-500 mt-1 ml-1" x-text="errors.date"></p>
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Tiba / Selesai</label>
                                    <input type="date" name="trip_end_date" x-model="formData.endDate"
                                           class="w-full bg-white border border-slate-200 rounded-xl px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest pt-2">Kategori Hotel & Penerbangan</p>

                            <div>
                                <div class="relative">
                                    <select name="hotel_category" x-model="formData.hotel_category"
                                            class="w-full appearance-none bg-white border border-slate-200 rounded-xl px-4 py-3 pr-10 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-400 cursor-pointer">
                                        <option value="">-- Pilih Kategori Hotel --</option>
                                        <option value="bintang_1">⭐ Bintang 1</option>
                                        <option value="bintang_3">⭐⭐⭐ Bintang 3</option>
                                        <option value="bintang_5">⭐⭐⭐⭐⭐ Bintang 5</option>
                                        <option value="non_hotel">🏠 Non Hotel</option>
                                    </select>
                                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1 ml-1">Hotel spesifik akan ditentukan oleh admin setelah pemesanan</p>
                            </div>
                            <div>
                                <input type="text" name="flight_info" x-model="formData.flight"
                                       placeholder="Info Penerbangan (Opsional)"
                                       class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest pt-2">Layanan Tambahan</p>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between bg-white rounded-xl border border-slate-200 px-4 py-3">
                                    <span class="text-sm text-slate-700 font-medium">Gunakan Drone?</span>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="use_drone" value="1" x-model="formData.use_drone" class="text-blue-600">
                                            <span class="text-sm font-semibold text-blue-600">YA</span>
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="use_drone" value="0" x-model="formData.use_drone" class="text-slate-500">
                                            <span class="text-sm font-semibold text-slate-600">TIDAK</span>
                                        </label>
                                    </div>
                                </div>
                                <div x-show="formData.use_drone === '1'" x-cloak x-transition
                                     class="p-4 bg-blue-50 border border-blue-100 rounded-xl space-y-2">
                                    <p class="text-xs font-semibold text-blue-800 uppercase tracking-wider">Detail Paket Cinematic Drone</p>
                                    <h4 class="text-sm font-bold text-blue-900">Rp 1.500.000 <span class="text-xs font-normal text-blue-600">(Dji Mavic 3 Pro)</span></h4>
                                    <ul class="text-xs text-blue-700 space-y-1">
                                        <li class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-xs"></i> 2 Lokasi @ Bukit Cinta & Holbung</li>
                                        <li class="flex items-center gap-2"><i class="fas fa-video text-xs"></i> Video Unlimited, Take sampai Hasil Bagus</li>
                                        <li class="flex items-center gap-2"><i class="fas fa-check-circle text-xs"></i> File Asli + Editing 1-2 Video</li>
                                        <li class="flex items-center gap-2"><i class="fas fa-mobile-alt text-xs"></i> Foto & Video Dari iPhone</li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <textarea name="notes" rows="3" x-model="formData.notes"
                                          placeholder="Catatan Tambahan (Opsional)"
                                          class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <div>
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" name="agree_terms" x-model="formData.agree"
                                           class="mt-1 rounded text-blue-600">
                                    <span class="text-xs leading-relaxed" :class="errors.agree ? 'text-red-500' : 'text-slate-600'">
                                        Saya menyetujui
                                        <a href="<?php echo e(route('legal.terms')); ?>" target="_blank" class="text-blue-600 underline">Syarat &amp; Ketentuan</a>
                                        serta memberikan izin penggunaan data sesuai kebijakan
                                        <a href="<?php echo e(route('legal.privacy')); ?>" target="_blank" class="text-blue-600 underline">Privasi</a>.
                                    </span>
                                </label>
                                <p x-show="errors.agree" class="text-xs text-red-500 mt-1 ml-1" x-text="errors.agree"></p>
                            </div>

                            <div class="flex gap-2 pt-1">
                                <button type="button" @click="step = 1"
                                        class="flex-1 bg-white border border-slate-200 text-slate-600 font-semibold py-3 rounded-xl text-sm hover:bg-slate-50 transition-colors">
                                    ← Kembali
                                </button>
                                <button type="button" @click="if(validateStep2()) { step = 3; scrollToForm(); } else { alert('Mohon lengkapi data diri Anda:\n' + Object.values(errors).join('\n')); }"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors text-sm">
                                    Lanjutkan →
                                </button>
                            </div>
                        </div>

                        
                        <div x-show="step === 3" x-cloak class="booking-step p-5 space-y-4">

                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Ringkasan Pesanan</p>

                            <div class="bg-white rounded-xl border border-slate-200 p-4 text-sm space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-slate-500"><?php echo e(__('ui.nav_packages')); ?></span>
                                    <span class="font-semibold text-slate-800 text-right max-w-[55%]"><?php echo e($product->translate('name')); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Jumlah Dewasa (Adult)</span>
                                    <span class="font-semibold text-slate-800" x-text="pax + ' <?php echo e(__('ui.person')); ?>'">-</span>
                                </div>
                                <div class="flex justify-between" x-show="parseInt(paxChild) > 0">
                                    <span class="text-slate-500">Jumlah Anak (<= 8 Thn)</span>
                                    <span class="font-semibold text-slate-800" x-text="paxChild + ' Anak'">-</span>
                                </div>
                                <div class="flex justify-between" x-show="formData.use_drone === '1'">
                                    <span class="text-slate-500">Paket Cinematic Drone</span>
                                    <span class="font-semibold text-slate-800" x-text="formatCurrency(dronePrice)">-</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-100 pt-2 mt-2">
                                    <span class="text-slate-500">Harga per Dewasa</span>
                                    <span class="font-semibold text-blue-600" x-text="formatCurrency(pricePerPax) + '/pax'">-</span>
                                </div>
                                <div class="flex justify-between" x-show="paxChild > 0">
                                    <span class="text-slate-500">Harga per Anak</span>
                                    <span class="font-semibold text-blue-600" x-text="formatCurrency(childPrice) + '/anak'">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500"><?php echo e(__('ui.order_date')); ?></span>
                                    <span class="font-semibold text-slate-800" x-text="formatSummaryDate(formData.date)">-</span>
                                </div>
                            </div>

                            
                            <div class="bg-blue-600 rounded-xl p-4">
                                <p class="text-xs text-blue-100 uppercase tracking-widest font-semibold mb-1">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-white" x-text="formatCurrency(totalPrice)">Rp 0</p>
                            </div>

                            <?php
                                $bank1 = \App\Models\Setting::get('bank_name_1');
                                $bank2 = \App\Models\Setting::get('bank_name_2');
                                $qris  = \App\Models\Setting::get('qris_image');
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bank1 || $bank2 || $qris): ?>
                            <div class="bg-white rounded-xl border border-dashed border-blue-300 p-4 space-y-3">
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Informasi Pembayaran</p>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bank1): ?>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <p class="text-xs text-slate-500 uppercase font-bold"><?php echo e($bank1); ?></p>
                                    <p class="text-sm font-bold text-slate-800"><?php echo e(\App\Models\Setting::get('bank_account_1')); ?></p>
                                    <p class="text-xs text-slate-600">a/n <?php echo e(\App\Models\Setting::get('bank_holder_1')); ?></p>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bank2): ?>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <p class="text-xs text-slate-500 uppercase font-bold"><?php echo e($bank2); ?></p>
                                    <p class="text-sm font-bold text-slate-800"><?php echo e(\App\Models\Setting::get('bank_account_2')); ?></p>
                                    <p class="text-xs text-slate-600">a/n <?php echo e(\App\Models\Setting::get('bank_holder_2')); ?></p>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($qris): ?>
                                <div class="text-center pt-2">
                                    <p class="text-xs text-slate-500 uppercase font-bold mb-2">QRIS Pembayaran</p>
                                    <img src="<?php echo e(asset('storage/' . $qris)); ?>" alt="QRIS" class="mx-auto w-40 h-auto rounded-lg shadow-sm border border-slate-200">
                                    <p class="text-xs text-slate-400 mt-2">*Simpan gambar QRIS untuk membayar via E-Wallet / Mobile Banking</p>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                                    <p class="text-xs text-yellow-700 font-bold leading-tight">
                                        <i class="fas fa-info-circle mr-1"></i> 
                                        Pesanan akan dikonfirmasi setelah Anda mengirimkan bukti transfer via WhatsApp.
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <button type="button" 
                                    id="submit-btn" 
                                    @click.stop.prevent="submitForm()"
                                    :disabled="submitting"
                                    style="cursor: pointer !important; position: relative; z-index: 50;"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all flex items-center justify-center gap-3 text-xs shadow-lg shadow-blue-500/20 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-widest group">
                                <span x-show="!submitting" class="pointer-events-none flex items-center gap-2">
                                    PESAN SEKARANG 
                                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </span>
                                <span x-show="submitting" x-cloak class="pointer-events-none">
                                    <i class="fas fa-circle-notch fa-spin text-xl"></i>
                                </span>
                            </button>

                            <a id="wa-direct-link"
                               href="https://wa.me/<?php echo e(\App\Models\Setting::get('whatsapp_number','6281298622143')); ?>?text=<?php echo e(urlencode('Halo, saya ingin tanya tentang paket '.$product->translate('name'))); ?>"
                               target="_blank"
                               class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-colors text-sm">
                                <i class="fab fa-whatsapp text-lg"></i>
                                Tanya via WhatsApp
                            </a>

                            <a x-show="lastOrderId" :href="'/order/' + lastOrderId + '/invoice'"
                               class="w-full flex items-center justify-center gap-2 bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 font-bold py-3 rounded-xl transition-all text-sm mb-2 shadow-sm" x-cloak>
                                <i class="fas fa-file-invoice"></i>
                                Download Invoice Resmi (PDF)
                            </a>

                            <div class="pt-1">
                                <button type="button" @click="step = 1; scrollToForm();"
                                        class="text-sm text-blue-600 hover:underline">← Kembali</button>
                            </div>
                        </div>

                        
                        <div x-show="step === 4" x-cloak class="booking-step p-8 text-center space-y-6 bg-white animate-fade-in">
                            <div class="relative inline-block">
                                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                                    <i class="fas fa-check text-4xl"></i>
                                </div>
                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">1</div>
                            </div>

                            <div class="animate-fade-in-up">
                                <h3 class="text-2xl font-extrabold text-slate-900">Berhasil Terkirim!</h3>
                                <p class="text-xs text-slate-500 mt-2">Nomor Pesanan Anda:</p>
                                <p class="text-2xl font-extrabold text-blue-600 mt-1" x-text="'#ORD-' + String(lastOrderId).padStart(5, '0')"></p>
                                <div class="mt-6 p-4 bg-green-50 rounded-2xl border border-green-100 shadow-inner">
                                    <p class="text-xs text-green-800 font-bold leading-relaxed">PENTING: Mohon klik tombol WhatsApp di bawah untuk mengaktifkan pesanan agar tim kami segera memproses perjalanan Anda.</p>
                                </div>
                            </div>
                            
                            <div class="space-y-3 pt-4">
                                <a id="wa-final-btn" :href="whatsappUrl" 
                                   class="w-full flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-green-500/20 uppercase tracking-wider text-xs">
                                    <i class="fab fa-whatsapp text-2xl"></i>
                                    Hubungi CS WhatsApp Sekarang
                                </a>
                                
                                <div class="flex gap-2">
                                    <a :href="'/order/' + lastOrderId + '/invoice'"
                                       class="flex-1 flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-4 rounded-2xl transition-all shadow-sm uppercase tracking-widest text-xs">
                                        <i class="fas fa-file-invoice"></i>
                                        Cetak Invoice
                                    </a>
                                    <button @click="location.reload()"
                                       class="px-6 bg-white border-2 border-slate-100 hover:bg-slate-50 text-slate-400 font-bold py-4 rounded-2xl transition-all uppercase tracking-widest text-xs">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-slate-100">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">
                                    Status: <span class="text-orange-500 animate-pulse">MENUNGGU KONFIRMASI PEMBAYARAN</span>
                                </p>
                            </div>
                        </div>

                    </form>
                </div>
                
                
                <!-- Short Description -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->translate('short_description')): ?>
                <div class="prose max-w-none text-slate-600">
                    <p><?php echo e($product->translate('short_description')); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Tabs Section -->
<section class="py-8 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tab Navigation -->
        <div class="border-b border-slate-200 mb-8">
            <nav class="flex space-x-8 overflow-x-auto">
                <button onclick="switchTab(event, 'itinerary')" class="tab-btn active py-4 px-1 border-b-2 border-blue-600 text-blue-600 text-xs font-bold uppercase tracking-wider whitespace-nowrap" data-tab="itinerary">
                    PILIHAN TRIP
                </button>
                <button onclick="switchTab(event, 'reviews')" class="tab-btn py-4 px-1 border-b-2 border-transparent text-slate-400 hover:text-slate-600 text-xs font-bold uppercase tracking-wider whitespace-nowrap" data-tab="reviews">
                    REVIEW
                </button>
                <button onclick="switchTab(event, 'related')" class="tab-btn py-4 px-1 border-b-2 border-transparent text-slate-400 hover:text-slate-600 text-xs font-bold uppercase tracking-wider whitespace-nowrap" data-tab="related">
                    TRIP LAINNYA
                </button>
                <button onclick="switchTab(event, 'notes')" class="tab-btn py-4 px-1 border-b-2 border-transparent text-slate-400 hover:text-slate-600 text-xs font-bold uppercase tracking-wider whitespace-nowrap" data-tab="notes">
                    NOTE
                </button>
            </nav>
        </div>
        
        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Itinerary Tab -->
            <div id="tab-itinerary" class="tab-pane active">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->translate('itinerary_text')): ?>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 prose max-w-none itinerary-timeline">
                    <?php echo $product->translate('itinerary_text'); ?>

                </div>
                <?php else: ?>
                <div class="text-center py-12 text-slate-500">
                    <i class="fas fa-map-marked-alt text-4xl mb-4"></i>
                    <p>Detail itinerary akan segera ditambahkan.</p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <!-- Reviews Tab -->
            <div id="tab-reviews" class="tab-pane hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Feedback List -->
                    <div class="lg:col-span-2 space-y-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviews->count() > 0): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-2xl border border-slate-100 p-6">
                                    <?php echo e(strtoupper(substr($review->customer_name, 0, 1))); ?>

                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-900"><?php echo e($review->customer_name); ?></h4>
                                    <div class="flex text-yellow-400 text-sm">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i <= $review->rating): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <p class="text-slate-600 mb-4"><?php echo e($review->comment); ?></p>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->gallery_images && count($review->gallery_images) > 0): ?>
                            <div class="flex flex-wrap gap-2 mt-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $review->gallery_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewImgUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="w-20 h-20 rounded-lg overflow-hidden border border-slate-100 shadow-sm cursor-pointer hover:opacity-80 transition-opacity"
                                     onclick="openLightbox('<?php echo e($reviewImgUrl); ?>')">
                                    <img src="<?php echo e($reviewImgUrl); ?>" 
                                         alt="Review Image" 
                                         class="w-full h-full object-cover">
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                        <div class="text-center py-12 text-slate-500">
                            <i class="fas fa-comments text-4xl mb-4"></i>
                            <p>Belum ada review untuk produk ini.</p>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Review Form -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 sticky top-24">
                            <h3 class="font-bold text-lg text-slate-900 mb-6">Tulis Review</h3>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                                <?php echo e(session('success')); ?>

                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <form action="<?php echo e(route('products.review', $product->slug)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="space-y-4">
                                    <div class="rating-input flex gap-2 text-2xl text-slate-300">
                                        <input type="hidden" name="rating" id="rating-value" value="5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                        <button type="button" class="star" data-value="<?php echo e($i); ?>">
                                            <i class="fas fa-star text-yellow-400"></i>
                                        </button>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                                        <input type="text" name="customer_name" required class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-600 border-slate-200 text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Pesan Kesan</label>
                                        <textarea name="comment" required rows="3" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-600 border-slate-200 text-sm"></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition-colors text-sm">
                                        Kirim Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Products Tab -->
            <div id="tab-related" class="tab-pane hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedProducts->count() > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg hover:shadow-blue-900/[0.06] hover:-translate-y-1 transition-all duration-300 group">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo e($related->image_url); ?>" 
                                 alt="<?php echo e($related->name); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="p-4">
                            <div class="text-blue-600 font-bold text-sm mb-1"><?php echo e($related->formatted_price); ?></div>
                            <h3 class="font-semibold text-slate-900 text-sm line-clamp-2 hover:text-blue-600 transition-colors">
                                <a href="<?php echo e(route('products.show', ['category' => $related->category?->slug ?? 'uncategorized', 'product' => $related->slug])); ?>">
                                    <?php echo e($related->name); ?>

                                </a>
                            </h3>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12 text-slate-500">
                    <i class="fas fa-box-open text-4xl mb-4"></i>
                    <p>Tidak ada trip lainnya dalam kategori ini.</p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <!-- Notes Tab -->
            <div id="tab-notes" class="tab-pane hidden">
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->translate('notes')): ?>
                    <div class="prose max-w-none text-slate-600">
                        <?php echo nl2br(e($product->translate('notes'))); ?>

                    </div>
                    <?php else: ?>
                    <div class="text-center py-8 text-slate-500">
                        <i class="fas fa-sticky-note text-4xl mb-4"></i>
                        <p>Tidak ada catatan khusus untuk produk ini.</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->translate('includes') && count($product->translate('includes')) > 0): ?>
                    <div class="mt-6">
                        <h4 class="font-semibold text-slate-900 mb-3">Termasuk:</h4>
                        <ul class="list-disc list-inside text-slate-600 space-y-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $product->translate('includes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $include): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($include); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->translate('excludes') && count($product->translate('excludes')) > 0): ?>
                    <div class="mt-6">
                        <h4 class="font-semibold text-slate-900 mb-3">Tidak Termasuk:</h4>
                        <ul class="list-disc list-inside text-slate-600 space-y-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $product->translate('excludes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exclude): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($exclude); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    // ── Image Gallery ─────────────────────────────────────────────────────────
    function changeImage(e, src) {
        const img = document.getElementById('main-image');
        img.classList.add('opacity-0');
        setTimeout(() => {
            img.src = src;
            img.classList.remove('opacity-0');
        }, 150);
        
        document.querySelectorAll('.thumbnail-btn').forEach(btn => {
            btn.classList.remove('border-blue-600');
            btn.classList.add('border-transparent');
        });
        e.currentTarget.classList.remove('border-transparent');
        e.currentTarget.classList.add('border-blue-600');
    }

    // ── Tab Switching ─────────────────────────────────────────────────────────
    function switchTab(e, tabName) {
        document.querySelectorAll('.tab-pane').forEach(tab => {
            tab.classList.add('hidden');
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-blue-600', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-slate-400');
        });
        document.getElementById('tab-' + tabName).classList.remove('hidden');
        document.getElementById('tab-' + tabName).classList.add('active');
        e.currentTarget.classList.remove('border-transparent', 'text-slate-400');
        e.currentTarget.classList.add('border-blue-600', 'text-blue-600');
    }

    // ── Alpine.js Booking Form Logic ──────────────────────────────────────────
    function bookingForm() {
        return {
            step: 1,
            pax: 1,
            paxChild: 0,
            submitting: false,
            lastOrderId: null,
            whatsappUrl: '',
            priceMin: <?php echo e($product->price_min); ?>,
            childPrice: <?php echo e($product->child_price); ?>,
            pricingTable: <?php echo json_encode($product->pricing_details, 15, 512) ?>,
            dronePrice: 1500000,
            formData: {
                name: '',
                email: '',
                phone: '',
                whatsapp: '',
                date: '',
                endDate: '',
                flight: '',
                use_drone: '0',
                notes: '',
                agree: false,
                hotel_category: ''
            },
            errors: {},

            get pricePerPax() {
                if (this.pricingTable && this.pricingTable.length) {
                    const paxCount = parseInt(this.pax);
                    // exact match
                    const exact = this.pricingTable.find(r => parseInt(r.pax) === paxCount);
                    if (exact) return parseFloat(exact.price_per_person);
                    // nearest lower bracket
                    const lower = this.pricingTable
                        .filter(r => parseInt(r.pax) <= paxCount)
                        .sort((a, b) => parseInt(b.pax) - parseInt(a.pax));
                    if (lower.length) return parseFloat(lower[0].price_per_person);
                    // nearest higher bracket
                    const higher = this.pricingTable
                        .filter(r => parseInt(r.pax) > paxCount)
                        .sort((a, b) => parseInt(a.pax) - parseInt(b.pax));
                    if (higher.length) return parseFloat(higher[0].price_per_person);
                }
                return this.priceMin;
            },

            goStep(s) {
                if (s < this.step) {
                    this.step = s;
                    this.scrollToForm();
                }
            },

            scrollToForm() {
                document.getElementById('booking-panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
            },

            get totalPrice() {
                const adultTotal = this.pricePerPax * parseInt(this.pax);
                const childTotal = parseInt(this.paxChild) * this.childPrice;
                const droneTotal = (this.formData.use_drone === '1') ? this.dronePrice : 0;
                return adultTotal + childTotal + droneTotal;
            },

            formatCurrency(amount) {
                const exchangeRate = <?php echo e(\App\Services\CurrencyService::rate()); ?>;
                const symbol = "<?php echo e(\App\Services\CurrencyService::symbol()); ?>";
                const locale = "<?php echo e(app()->getLocale()); ?>";
                const converted = amount * exchangeRate;

                if (locale === 'id') {
                    return symbol + ' ' + Math.round(converted).toLocaleString('id-ID');
                } else {
                    return symbol + converted.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },

            formatSummaryDate(dateStr) {
                if (!dateStr) return '—';
                return new Date(dateStr).toLocaleDateString('<?php echo e(app()->getLocale()); ?>', {day:'2-digit',month:'long',year:'numeric'});
            },

            validateStep2() {
                this.errors = {};
                if (!this.formData.name.trim()) this.errors.name = 'Nama Lengkap wajib diisi.';
                if (!this.formData.phone.trim()) this.errors.phone = 'Nomor Telepon/WhatsApp wajib diisi.';
                if (!this.formData.date) this.errors.date = 'Tanggal Berangkat wajib diisi.';
                if (!this.formData.agree) this.errors.agree = 'Anda harus menyetujui S&K.';
                
                return Object.keys(this.errors).length === 0;
            },

            async submitForm() {
                console.log('CRITICAL: submitForm triggered');
                console.log('Current Data:', JSON.parse(JSON.stringify(this.formData)));
                
                if (this.submitting) return;

                if (!this.validateStep2()) {
                    console.warn('Validation Failed:', this.errors);
                    this.step = 2;
                    let errorList = Object.values(this.errors).join('\n');
                    alert('⚠️ MOHON LENGKAPI DATA:\n\n' + errorList);
                    this.scrollToForm();
                    return;
                }

                this.submitting = true;
                try {
                    const formElement = document.getElementById('booking-form');
                    if (!formElement) throw new Error('ERR: Form element selection failed.');
                    
                    const formDataObj = new FormData(formElement);
                    // Add pax manually just in case
                    formDataObj.append('pax_adult', this.pax);
                    formDataObj.append('pax_child', this.paxChild);
                    formDataObj.append('quantity', parseInt(this.pax) + parseInt(this.paxChild));
                    formDataObj.append('total_price', this.totalPrice);
                    
                    console.log('Fetching order route...');
                    const response = await fetch('<?php echo e(route('products.order', $product->slug)); ?>', {
                        method: 'POST',
                        body: formDataObj,
                        headers: { 
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        throw new Error(errorData.message || 'Server error: ' + response.status);
                    }

                    const result = await response.json();
                    console.log('Server Response:', result);

                    if (result.success) {
                        console.log('Success! Transitioning to step 4');
                        this.lastOrderId = result.order_id;
                        this.whatsappUrl = result.whatsapp_url;
                        this.submitting = false; // Hide loading immediately
                        this.step = 4; 
                        
                        this.scrollToForm();
                        
                        setTimeout(() => {
                            try {
                                window.open(result.whatsapp_url, '_blank');
                            } catch (e) {
                                console.error('WA Open Error:', e);
                            }
                        }, 500);
                    } else {
                        const errorMsg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Gagal memproses pesanan.');
                        alert('⚠️ GAGAL:\n' + errorMsg);
                    }
                } catch (error) {
                    console.error('Booking Error:', error);
                    if (error.message.includes('419')) {
                        alert('Sesi berakhir (419). Silakan Refresh halaman dan coba lagi.');
                    } else {
                        alert('Kesalahan Sistem:\n' + error.message);
                    }
                } finally {
                    this.submitting = false;
                }
            },

            resetForm() {
                this.formData = {
                    name: '', email: '', phone: '', date: '', endDate: '',
                    flight: '', use_drone: '0', notes: '', agree: false,
                    hotel_category: ''
                };
                this.errors = {};
            }
        };
    }

    // ── Star Rating (Vanilla) ────────────────────────────────────────────────
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function () {
            const value = this.dataset.value;
            document.getElementById('rating-value').value = value;
            document.querySelectorAll('.star').forEach(s => {
                const icon = s.querySelector('i');
                if (s.dataset.value <= value) {
                    icon.classList.remove('text-slate-300');
                    icon.classList.add('text-yellow-400');
                } else {
                    icon.classList.remove('text-yellow-400');
                    icon.classList.add('text-slate-300');
                }
            });
        });
    });

    // openLightbox is provided globally by the layout

    window.onerror = function(msg, url, lineNo, columnNo, error) {
        console.error('Global Error:', msg, url, lineNo);
        // Only alert in local development to help debugging
        if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
            alert('JavaScript Error: ' + msg + '\nLine: ' + lineNo);
        }
        return false;
    };
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\products\show.blade.php ENDPATH**/ ?>