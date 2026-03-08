

<?php $__env->startSection('title', ($settings['site_name'] ?? 'NorthSumateraTrip') . ' - ' . ($settings['site_slogan'] ?? 'Premium Tour & Travel')); ?>

<?php $__env->startPush('schema'); ?>
    <?php echo \App\Helpers\SchemaHelper::organization($settings); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-white pt-4 pb-0 md:pt-10">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($badgeText = \App\Models\Setting::get('hero_badge_text')): ?>
        <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 text-[8px] md:text-[10px] font-black px-3 py-1 rounded-full border border-blue-100 uppercase tracking-widest mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
            <?php echo e($badgeText); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <h1 class="text-xl md:text-5xl lg:text-7xl font-black text-gray-900 uppercase tracking-tighter leading-none mb-2 md:mb-4">
            <?php echo e(\App\Models\Setting::get('hero_title', 'Jelajahi Sumatera Utara')); ?>

        </h1>
        <p class="text-gray-400 text-[8px] md:text-xs font-bold uppercase tracking-[0.25em] max-w-2xl mx-auto">
            <?php echo e(\App\Models\Setting::get('hero_subtitle', 'Sewa Mobil & Paket Wisata Terbaik.')); ?>

        </p>
    </div>
</section>


<section class="bg-white pt-4 pb-6 md:pt-6 md:pb-12">
        <?php 
            $heroRaw = \App\Models\Setting::get('default_hero_image');
            $heroImagesRaw = is_array($heroRaw) ? $heroRaw : ($heroRaw ? [$heroRaw] : []);
            
            // Filter only existing images
            $heroImages = array_filter($heroImagesRaw, function($img) {
                if(str_starts_with($img, 'http')) return true;
                // Check in storage
                if(str_contains($img, '/')) {
                    if(file_exists(storage_path('app/public/' . $img))) return true;
                }
                // Check in public/images
                if(file_exists(public_path('images/' . $img))) return true;
                return false;
            });

            // Built-in defaults if none configured OR not found
            if(empty($heroImages)) {
                $builtinDefaults = ['images/default-hero.jpg', 'images/default-hero-2.jpg'];
                $heroImages = array_filter($builtinDefaults, fn($f) => file_exists(public_path($f)));
                if(empty($heroImages)) $heroImages = []; // Will show gradient fallback
            }
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heroImages)): ?>
        
        <div class="swiper heroSwiper relative overflow-hidden rounded-[1.25rem] md:rounded-[2.5rem] shadow-2xl group border-[4px] md:border-[8px] border-white ring-1 ring-gray-100">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide aspect-[2.1/1] md:aspect-[3/1] relative overflow-hidden">
                    <img src="<?php echo e(str_starts_with($image, 'images/') ? asset($image) : \App\Models\Product::resolveImagePath($image, 'settings')); ?>" alt="Wisata Sumatera Utara" class="w-full h-full object-cover shadow-inner">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <div class="swiper-button-next !text-white !w-8 !h-8 md:!w-12 md:!h-12 bg-black/10 hover:bg-black/30 backdrop-blur rounded-full after:!text-[10px] md:after:!text-xl transition-all opacity-0 group-hover:opacity-100"></div>
            <div class="swiper-button-prev !text-white !w-8 !h-8 md:!w-12 md:!h-12 bg-black/10 hover:bg-black/30 backdrop-blur rounded-full after:!text-[10px] md:after:!text-xl transition-all opacity-0 group-hover:opacity-100"></div>
            <div class="swiper-pagination"></div>
        </div>
        <?php else: ?>
        
        <div class="relative overflow-hidden rounded-[1.25rem] md:rounded-[2.5rem] shadow-2xl border-[4px] md:border-[8px] border-white ring-1 ring-gray-100 aspect-[2.1/1] md:aspect-[3/1]"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 30%, #1d4ed8 65%, #3b82f6 100%);">
            
            <div style="position:absolute; top:-80px; right:-80px; width:400px; height:400px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
            <div style="position:absolute; bottom:-60px; left:-60px; width:300px; height:300px; border-radius:50%; background:rgba(255,255,255,0.03);"></div>
            
            <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:2rem; color:white;">
                <div style="font-size:2rem; margin-bottom:0.75rem;">🏔️</div>
                <h2 style="font-size:clamp(1.25rem, 4vw, 2.5rem); font-weight:900; text-transform:uppercase; letter-spacing:-0.03em; line-height:1.1; margin-bottom:0.5rem; text-shadow:0 2px 16px rgba(0,0,0,0.3);">
                    Jelajahi Sumatera Utara
                </h2>
                <p style="font-size:clamp(0.65rem, 1.5vw, 0.85rem); opacity:0.75; font-weight:600; text-transform:uppercase; letter-spacing:0.15em; margin-bottom:1.5rem;">
                    Danau Toba • Berastagi • Nias • Sibolga • Dan Lebih Banyak Lagi
                </p>
                <a href="<?php echo e(route('products.index')); ?>" 
                   style="display:inline-block; padding:0.6rem 1.5rem; background:white; color:#1d4ed8; border-radius:99px; font-weight:800; font-size:0.8rem; text-decoration:none; text-transform:uppercase; letter-spacing:0.08em; box-shadow:0 4px 16px rgba(0,0,0,0.2);">
                    Lihat Paket Wisata →
                </a>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <div style="position:absolute; bottom:12px; right:12px; background:rgba(255,255,255,0.15); backdrop-filter:blur(8px); padding:4px 12px; border-radius:99px; font-size:0.65rem; color:white; font-weight:600;">
                💡 Upload hero image di Profil Bisnis
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>



<section class="py-10 md:py-16 bg-white overflow-hidden" id="popular-trips">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl md:text-3xl font-black text-gray-900 uppercase tracking-tighter"><?php echo e(__('ui.popular_trip')); ?></h2>
                <div class="w-12 h-1 bg-blue-600 mt-2"></div>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="text-[10px] font-black text-blue-600 hover:text-gray-900 uppercase tracking-widest transition-colors">
                <?php echo e(__('ui.view_all_packages')); ?> &rarr;
            </a>
        </div>

        <div class="flex gap-4 md:gap-8 overflow-x-auto no-scrollbar pb-6 snap-x">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex-shrink-0 w-[280px] md:w-[380px] snap-start group">
                <a href="<?php echo e(route('products.show', ['category' => $product->category?->slug, 'product' => $product->slug])); ?>" class="block">
                    <div class="relative aspect-[4/3] rounded-[1rem] md:rounded-[1.5rem] overflow-hidden shadow-sm md:shadow-lg transition-transform duration-500 group-hover:-translate-y-2">
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->translate('name')); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-2 right-2 md:top-4 md:right-4 bg-white/95 backdrop-blur px-3 py-1.5 md:px-4 md:py-2 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-blue-600 font-extrabold text-[10px] md:text-sm">
                                <?php echo e($product->formatted_price); ?>

                            </p>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-6">
                        <h3 class="text-xs md:text-lg font-black text-gray-900 group-hover:text-blue-600 transition-colors uppercase tracking-tight line-clamp-1 leading-tight md:leading-snug">
                            <?php echo e($product->translate('name')); ?>

                        </h3>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-1.5">
                                <div class="flex text-amber-400 text-[8px] md:text-xs">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="<?php echo e($i <= ($product->rating ?? 5) ? 'fas' : 'far'); ?> fa-star"></i>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <span class="text-gray-400 text-[8px] md:text-xs font-bold">(<?php echo e($product->review_count ?? 0); ?>)</span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->translate('duration')): ?>
                            <div class="flex items-center gap-2 text-gray-500 text-[9px] font-black uppercase tracking-widest">
                                <?php echo e($product->translate('duration')); ?>

                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section class="py-12 md:py-16 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl md:text-3xl font-black text-gray-900 uppercase tracking-tighter"><?php echo e(__('ui.car_rental_title')); ?></h2>
                <div class="w-12 h-1 bg-blue-600 mt-2"></div>
            </div>
            <a href="<?php echo e(route('car-rental')); ?>" class="text-[10px] font-black text-blue-600 hover:text-gray-900 uppercase tracking-widest transition-colors"><?php echo e(__('ui.view_all_cars')); ?> &rarr;</a>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carRentalProducts->count() > 0): ?>
        <div class="flex gap-4 md:gap-6 overflow-x-auto no-scrollbar pb-6 snap-x">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $carRentalProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex-shrink-0 w-[240px] md:w-[320px] snap-start bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-gray-100">
                <a href="<?php echo e(route('car.detail', $car->slug)); ?>" class="block">
                    <div class="aspect-video overflow-hidden bg-gray-100">
                        <img src="<?php echo e($car->image_url); ?>" alt="<?php echo e($car->translate('name')); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="p-5">
                        <h3 class="font-black text-gray-900 uppercase tracking-tight text-xs md:text-base mb-3 line-clamp-1 group-hover:text-blue-600 transition-colors"><?php echo e($car->translate('name')); ?></h3>
                        <div class="flex items-center justify-between">
                            <p class="text-blue-600 font-black text-xs md:text-sm uppercase"><?php echo e(currency($car->price_per_day)); ?><span class="text-gray-400 font-bold ml-1 text-[10px]">/ <?php echo e(__('ui.days')); ?></span></p>
                            <span class="text-[8px] md:text-[10px] bg-gray-100 text-gray-500 px-2 py-1 rounded-full font-bold uppercase"><?php echo e($car->capacity); ?> <?php echo e(__('ui.person')); ?></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php else: ?>
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mb-5 shadow-sm">
                <i class="fas fa-car text-blue-300 text-3xl"></i>
            </div>
            <p class="text-gray-400 font-black uppercase tracking-widest text-xs"><?php echo e(__('ui.coming_soon') ?? 'Segera Hadir'); ?></p>
            <a href="<?php echo e(route('car-rental')); ?>" class="mt-6 inline-block px-8 py-3 bg-blue-600 text-white font-black text-[10px] rounded-full uppercase tracking-widest hover:bg-gray-900 transition-all"><?php echo e(__('ui.view_all_cars')); ?> &rarr;</a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>


<section class="py-12 md:py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl md:text-3xl font-black text-gray-900 uppercase tracking-tighter"><?php echo e(__('ui.rental_pkg_title')); ?></h2>
                <div class="w-12 h-1 bg-blue-600 mt-2"></div>
            </div>
            <a href="<?php echo e(route('rental-package')); ?>" class="text-[10px] font-black text-blue-600 hover:text-gray-900 uppercase tracking-widest transition-colors"><?php echo e(__('ui.view_all_rental')); ?> &rarr;</a>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rentalPackageProducts->count() > 0): ?>
        <div class="flex gap-4 md:gap-6 overflow-x-auto no-scrollbar pb-6 snap-x">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $rentalPackageProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex-shrink-0 w-[280px] md:w-[450px] snap-start relative rounded-3xl overflow-hidden group h-64 md:h-72 shadow-lg">
                <img src="<?php echo e($package->image_url); ?>" alt="<?php echo e($package->translate('name')); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent p-6 md:p-10 flex flex-col justify-end">
                    <h3 class="text-white text-lg md:text-3xl font-black uppercase tracking-tight mb-2 group-hover:text-blue-400 transition-colors"><?php echo e($package->translate('name')); ?></h3>
                    <div class="flex items-center justify-between mt-2 md:mt-4">
                        <p class="text-blue-400 font-black uppercase tracking-widest text-xs md:text-xl"><?php echo e(currency($package->price_per_day)); ?><span class="text-white/60 text-[10px] md:text-xs ml-2">/ <?php echo e(__('ui.days')); ?></span></p>
                        <a href="<?php echo e(route('rental-package.show', $package->slug)); ?>" class="bg-white/10 hover:bg-white text-white hover:text-blue-600 backdrop-blur-md px-6 py-2.5 rounded-full text-[10px] md:text-xs font-black uppercase tracking-widest transition-all">Details &rarr;</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php else: ?>
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mb-5 shadow-sm">
                <i class="fas fa-route text-blue-300 text-3xl"></i>
            </div>
            <p class="text-gray-400 font-black uppercase tracking-widest text-xs"><?php echo e(__('ui.coming_soon') ?? 'Segera Hadir'); ?></p>
            <a href="<?php echo e(route('rental-package')); ?>" class="mt-6 inline-block px-8 py-3 bg-blue-600 text-white font-black text-[10px] rounded-full uppercase tracking-widest hover:bg-gray-900 transition-all"><?php echo e(__('ui.view_all_rental')); ?> &rarr;</a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>


<section class="py-16 bg-gray-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 mb-10">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tighter"><?php echo e(__('ui.gallery_title')); ?></h2>
                <div class="w-12 h-1 bg-blue-600 mt-2"></div>
            </div>
            <a href="<?php echo e(route('gallery')); ?>" class="text-[10px] font-black text-white/50 hover:text-blue-400 uppercase tracking-widest transition-colors"><?php echo e(__('ui.read_more') ?? 'Lihat Semua'); ?> &rarr;</a>
        </div>
    </div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryProducts->count() > 0): ?>
    <div class="flex gap-4 overflow-x-auto no-scrollbar px-4 pb-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $galleryProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image_url): ?>
        <div class="flex-shrink-0 w-48 h-48 md:w-64 md:h-64 rounded-3xl overflow-hidden cursor-zoom-in group" onclick="openLightbox('<?php echo e($product->image_url); ?>', '<?php echo e($product->translate('name')); ?>')">
            <img src="<?php echo e($product->image_url); ?>" alt="Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale hover:grayscale-0">
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php else: ?>
    <div class="flex flex-col items-center justify-center py-12 text-center px-4">
        <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center mb-5">
            <i class="fas fa-images text-white/30 text-3xl"></i>
        </div>
        <p class="text-white/30 font-black uppercase tracking-widest text-xs"><?php echo e(__('ui.coming_soon') ?? 'Segera Hadir'); ?></p>
        <a href="<?php echo e(route('gallery')); ?>" class="mt-6 inline-block px-8 py-3 bg-white/10 hover:bg-blue-600 text-white font-black text-[10px] rounded-full uppercase tracking-widest transition-all"><?php echo e(__('ui.read_more') ?? 'Lihat Semua'); ?> &rarr;</a>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</section>


<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                ['icon' => 'fa-car',      'title' => __('ui.feature_fleet')],
                ['icon' => 'fa-user-tie', 'title' => __('ui.feature_driver')],
                ['icon' => 'fa-tags',     'title' => __('ui.feature_price')],
                ['icon' => 'fa-headset',  'title' => __('ui.feature_support')],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="text-center group">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-200 shadow-sm transition-all group-hover:bg-blue-600 group-hover:text-white group-hover:-translate-y-1">
                    <i class="fas <?php echo e($feature['icon']); ?> text-xl"></i>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-900"><?php echo e($feature['title']); ?></h3>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-blue-600 rounded-[2.5rem] p-8 md:p-16 text-center shadow-2xl shadow-blue-200">
            <h2 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tighter">
                <?php echo e(__('ui.custom_trip')); ?>

            </h2>
            <p class="text-white/80 mt-6 max-w-2xl mx-auto text-sm md:text-lg font-bold">
                <?php echo e(__('ui.custom_trip_sub')); ?>

            </p>
            <div class="mt-10">
                <a href="<?php echo e(route('custom-request.create')); ?>" class="inline-block px-12 py-5 bg-white text-blue-600 font-black text-sm rounded-full hover:bg-gray-100 transition-all uppercase tracking-widest">
                    <?php echo e(__('ui.custom_trip_badge')); ?>

                </a>
            </div>
        </div>
    </div>
</section>


<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
            <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter"><?php echo e(__('ui.latest_blog')); ?></h2>
            <a href="<?php echo e(route('blog.index')); ?>" class="text-sm font-bold text-blue-600 hover:text-gray-900 transition-colors uppercase tracking-widest">
                <?php echo e(__('ui.view_all_blog')); ?> &rarr;
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $latestBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('blog.show', $blog->slug)); ?>" class="group">
                <div class="aspect-square rounded-3xl overflow-hidden shadow-md mb-4 bg-gray-100">
                    <img src="<?php echo e($blog->image_url); ?>" alt="<?php echo e($blog->translate('title')); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>
                <h3 class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 uppercase tracking-tight">
                    <?php echo e($blog->translate('title')); ?>

                </h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase mt-2 tracking-widest"><?php echo e($blog->formatted_date); ?></p>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
    });
</script>
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .heroSwiper .swiper-pagination-bullet {
        background: white;
        opacity: 0.5;
        width: 8px;
        height: 8px;
        transition: all 0.3s;
    }
    .heroSwiper .swiper-pagination-bullet-active {
        background: white;
        opacity: 1;
        width: 30px;
        border-radius: 4px;
    }
    /* Snap scroll behavior */
    .snap-x {
        scroll-snap-type: x mandatory;
    }
    .snap-start {
        scroll-snap-align: start;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\home.blade.php ENDPATH**/ ?>