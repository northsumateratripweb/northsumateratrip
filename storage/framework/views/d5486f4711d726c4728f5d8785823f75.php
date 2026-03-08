

<?php $__env->startSection('title', __('ui.dashboard_title') . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-50 dark:bg-slate-950">

    
    <div class="relative bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 pt-28 pb-32 px-5 overflow-hidden">
        
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        <div class="max-w-4xl mx-auto relative z-10">
            
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 rounded-2xl flex items-center justify-center text-white text-2xl font-black flex-shrink-0 border-2 border-white/30">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                </div>
                <div>
                    <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Selamat Datang 👋</p>
                    <h1 class="text-xl md:text-2xl font-extrabold text-white leading-tight"><?php echo e(auth()->user()->name); ?></h1>
                </div>
            </div>

            
            <div class="grid grid-cols-3 gap-3 md:gap-4">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center">
                    <p class="text-3xl md:text-4xl font-black text-white leading-none mb-1"><?php echo e($stats['total']); ?></p>
                    <p class="text-blue-200 text-[0.6rem] md:text-xs font-bold uppercase tracking-wider leading-tight">Total<br class="md:hidden"> Pesanan</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center">
                    <p class="text-3xl md:text-4xl font-black text-white leading-none mb-1"><?php echo e($stats['completed']); ?></p>
                    <p class="text-blue-200 text-[0.6rem] md:text-xs font-bold uppercase tracking-wider leading-tight">Selesai</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-center">
                    <p class="text-3xl md:text-4xl font-black text-white leading-none mb-1"><?php echo e($stats['pending']); ?></p>
                    <p class="text-blue-200 text-[0.6rem] md:text-xs font-bold uppercase tracking-wider leading-tight">Menunggu</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="max-w-4xl mx-auto px-4 md:px-6 -mt-10 pb-24 relative z-10">

        
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight">Riwayat Pesanan</h2>
            <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-xs font-bold border border-blue-100 dark:border-blue-800"><?php echo e($orders->total() ?? $orders->count()); ?> Pesanan</span>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->isNotEmpty()): ?>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">

                    
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wider">#ORD-<?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?></span>
                            <?php $statusKey = 'ui.status_' . $order->status; ?>
                            <span class="px-2.5 py-1 rounded-lg text-[0.6rem] font-black uppercase tracking-wider
                                <?php if($order->status == 'completed'): ?> bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400
                                <?php elseif($order->status == 'pending'): ?> bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400
                                <?php elseif($order->status == 'confirmed'): ?> bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400
                                <?php elseif($order->status == 'cancelled'): ?> bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400
                                <?php else: ?> bg-slate-100 text-slate-600 <?php endif; ?>">
                                <?php echo e(__($statusKey) !== $statusKey ? __($statusKey) : ucfirst($order->status)); ?>

                            </span>
                        </div>
                        <span class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-wide">
                            <?php echo e(\Carbon\Carbon::parse($order->trip_date)->translatedFormat('d M Y')); ?>

                        </span>
                    </div>

                    
                    <div class="p-5">
                        
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-base leading-snug mb-4">
                            <?php echo e($order->product?->name ?? $order->vehicle?->name ?? 'Sewa Mobil'); ?>

                        </h3> REPLACE
<<<<<<< SEARCH
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tripSchedule->vehicle): ?>
                                <p class="text-[0.6rem] text-slate-400 font-medium truncate"><?php echo e($order->tripSchedule->vehicle->name); ?> - <?php echo e($order->tripSchedule->vehicle->license_plate ?? $order->tripSchedule->vehicle->plate_number); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
=======
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tripSchedule?->vehicle): ?>
                                <p class="text-[0.6rem] text-slate-400 font-medium truncate"><?php echo e($order->tripSchedule->vehicle->name); ?> - <?php echo e($order->tripSchedule->vehicle->license_plate ?? $order->tripSchedule->vehicle->plate_number); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3.5">
                                <p class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Harga</p>
                                <p class="text-base font-extrabold text-blue-600 dark:text-blue-400 leading-none"><?php echo e(currency($order->total_price)); ?></p>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-3.5">
                                <p class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo e($order->vehicle_id ? 'Durasi' : 'Peserta'); ?></p>
                                <p class="text-base font-extrabold text-slate-900 dark:text-white leading-none"><?php echo e($order->quantity); ?> <?php echo e($order->vehicle_id ? __('ui.days') : __('ui.person')); ?></p>
                            </div>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tripSchedule): ?>
                        <div class="flex items-center gap-3 p-3.5 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/40 mb-4">
                            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-tie text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[0.55rem] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-0.5">🚀 Driver (<?php echo e($order->tripSchedule->status_label); ?>)</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate"><?php echo e($order->tripSchedule->driver_name ?? 'Driver Menunggu'); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tripSchedule->vehicle): ?>
                                <p class="text-[0.6rem] text-slate-400 font-medium truncate"><?php echo e($order->tripSchedule->vehicle->name); ?> - <?php echo e($order->tripSchedule->vehicle->license_plate ?? $order->tripSchedule->vehicle->plate_number); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tripSchedule->driver_phone): ?>
                            <a href="https://wa.me/<?php echo e(preg_replace('/\D/', '', $order->tripSchedule->driver_phone)); ?>" target="_blank"
                               class="w-9 h-9 bg-emerald-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-emerald-600 transition-colors">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php elseif($order->rentalSchedule): ?>
                        <div class="flex items-center gap-3 p-3.5 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/40 mb-4">
                            <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-car text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[0.55rem] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-0.5">🚗 Jadwal Rental (<?php echo e($order->rentalSchedule->status_label); ?>)</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate"><?php echo e($order->rentalSchedule->carRental->name ?? 'Mobil Rental'); ?></p>
                                <p class="text-[0.6rem] text-slate-400 font-medium"><?php echo e($order->rentalSchedule->start_date->format('d M')); ?> s/d <?php echo e($order->rentalSchedule->end_date->format('d M Y')); ?></p>
                            </div>
                            <span class="flex-shrink-0 px-2 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-lg text-[0.55rem] font-bold uppercase"><?php echo e($order->rentalSchedule->rental_days); ?> Hari</span>
                        </div>
                        <?php elseif($order->packageRentalSchedule): ?>
                        <div class="flex items-center gap-3 p-3.5 bg-violet-50 dark:bg-violet-900/20 rounded-xl border border-violet-100 dark:border-violet-800/40 mb-4">
                            <div class="w-9 h-9 bg-violet-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-box text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[0.55rem] font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest mb-0.5">📦 Paket Rental (<?php echo e($order->packageRentalSchedule->status_label); ?>)</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate"><?php echo e($order->packageRentalSchedule->rentalPackage->name ?? 'Paket Rental'); ?></p>
                                <p class="text-[0.6rem] text-slate-400 font-medium"><?php echo e($order->packageRentalSchedule->start_date->format('d M')); ?> s/d <?php echo e($order->packageRentalSchedule->end_date->format('d M Y')); ?></p>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->hotel_1 || $order->hotel_2): ?>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i=1; $i<=4; $i++): ?>
                                <?php $h = "hotel_$i"; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->$h): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg text-[0.6rem] font-bold text-slate-500 uppercase tracking-wider">
                                    <i class="fas fa-hotel text-blue-400 text-[0.55rem]"></i> H<?php echo e($i); ?>: <?php echo e($order->$h); ?>

                                </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="flex flex-col sm:flex-row gap-2.5 pt-4 border-t border-slate-50 dark:border-slate-800">
                            <a href="<?php echo e(route('order.invoice', $order->id)); ?>" target="_blank"
                               class="flex-1 flex items-center justify-center gap-2 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-600 hover:dark:bg-blue-600 hover:dark:text-white transition-all active:scale-95">
                                <i class="fas fa-file-invoice-dollar text-sm"></i>
                                Invoice PDF
                            </a>

                            <a href="https://wa.me/<?php echo e(preg_replace('/\D/', '', \App\Models\Setting::get('whatsapp_number', '6281298622143'))); ?>?text=<?php echo e(urlencode('Halo Admin NorthSumateraTrip, saya ingin konfirmasi/tanya tentang Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT))); ?>"
                               target="_blank"
                               class="flex-1 flex items-center justify-center gap-2 py-3 bg-white dark:bg-slate-800 text-emerald-600 border border-emerald-100 dark:border-emerald-900 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all active:scale-95">
                                <i class="fab fa-whatsapp text-sm"></i>
                                Hubungi Admin
                            </a>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status == 'pending' && \App\Models\Setting::get('qris_image')): ?>
                            <button x-data x-on:click="$dispatch('open-payment-modal')"
                                    class="flex-1 flex items-center justify-center gap-2 py-3 bg-blue-50 text-blue-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-100 transition-all border border-blue-100 active:scale-95">
                                <i class="fas fa-qrcode text-xs"></i>
                                Cara Bayar
                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->hasPages()): ?>
            <div class="mt-6">
                <?php echo e($orders->links()); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php else: ?>
            
            <div class="py-20 text-center bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-6">
                    <i class="fas fa-suitcase-rolling text-3xl"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-2 tracking-wide">Belum Ada Pesanan</h3>
                <p class="text-slate-400 text-sm mb-8 px-6">Mulai petualanganmu di Sumatera Utara sekarang!</p>
                <a href="<?php echo e(route('packages')); ?>" class="inline-flex items-center gap-2 px-7 py-3.5 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                    Lihat Paket Wisata
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div x-data="{ open: false }" x-on:open-payment-modal.window="open = true" x-show="open" x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
    <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" x-on:click="open = false"></div>
    <div class="relative bg-white dark:bg-slate-900 rounded-2xl p-6 max-w-sm w-full shadow-2xl border border-slate-100 dark:border-slate-800"
         x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
        <button x-on:click="open = false" class="absolute top-4 right-4 w-9 h-9 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="text-center">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-4 text-blue-600">
                <i class="fas fa-qrcode text-xl"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-1">Cara Pembayaran</h3>
            <p class="text-slate-500 text-sm mb-6">Scan QRIS untuk melakukan pembayaran</p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('qris_image')): ?>
            <div class="bg-white p-3 rounded-2xl border border-slate-100 inline-block mb-5">
                <img src="<?php echo e(asset('storage/' . \App\Models\Setting::get('qris_image'))); ?>" alt="QRIS Payment" class="w-52 h-52 object-contain">
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('bank_name')): ?>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 text-left space-y-2.5">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Transfer Bank</p>
                <div class="flex justify-between"><span class="text-sm text-slate-500">Bank</span><span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e(\App\Models\Setting::get('bank_name')); ?></span></div>
                <div class="flex justify-between"><span class="text-sm text-slate-500">No. Rekening</span><span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e(\App\Models\Setting::get('bank_account_number')); ?></span></div>
                <div class="flex justify-between"><span class="text-sm text-slate-500">Atas Nama</span><span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e(\App\Models\Setting::get('bank_account_name')); ?></span></div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\dashboard.blade.php ENDPATH**/ ?>