<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('heading', null, []); ?> 
            📊 Rekapitulasi Pesanan <?php echo e($year); ?>

         <?php $__env->endSlot(); ?>
         <?php $__env->slot('description', null, []); ?> 
            Ringkasan bulanan semua jenis pesanan
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('headerEnd', null, []); ?> 
            <a href="<?php echo e(route('laporan.pesanan', ['tahun' => $year])); ?>"
               target="_blank"
               class="fi-link text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline">
               Laporan Lengkap →
            </a>
         <?php $__env->endSlot(); ?>

        <div class="overflow-x-auto">
            <table style="width:100%; border-collapse:collapse; font-size:.82rem;">
                <thead>
                    <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <th style="padding:.6rem .85rem; text-align:left; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; white-space:nowrap">Bulan</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b">Total</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#166534">🏔️ Wisata</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#5b21b6">🗺️ Rental</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#92400e">🚗 Mobil</th>
                        <th style="padding:.6rem .85rem; text-align:right; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b">Pendapatan (IDR)</th>
                        <th style="padding:.6rem .85rem; text-align:center; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b">Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $monthlyBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-top:1px solid #f1f5f9; <?php echo e(!$row['active'] ? 'opacity:.45;' : ''); ?> <?php echo e(($i + 1) == $month ? 'background:#eff6ff;' : ''); ?>">
                        <td style="padding:.6rem .85rem; font-weight:600; color:<?php echo e(($i+1)==$month ? '#1d4ed8' : '#334155'); ?>;">
                            <?php echo e($row['bulan']); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($i+1) == $month): ?>
                                <span style="font-size:.65rem; background:#dbeafe; color:#1d4ed8; padding:1px 5px; border-radius:99px; font-weight:700; margin-left:4px">Ini</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td style="padding:.6rem .85rem; text-align:center; font-weight:700;"><?php echo e($row['total']); ?></td>
                        <td style="padding:.6rem .85rem; text-align:center; color:#166534;"><?php echo e($row['tour'] ?: '-'); ?></td>
                        <td style="padding:.6rem .85rem; text-align:center; color:#5b21b6;"><?php echo e($row['rental'] ?: '-'); ?></td>
                        <td style="padding:.6rem .85rem; text-align:center; color:#92400e;"><?php echo e($row['car'] ?: '-'); ?></td>
                        <td style="padding:.6rem .85rem; text-align:right; font-weight:600; white-space:nowrap;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['revenue'] > 0): ?>
                                Rp <?php echo e(number_format($row['revenue'],0,',','.')); ?>

                            <?php else: ?>
                                <span style="color:#cbd5e1">—</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td style="padding:.6rem .85rem; text-align:center;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['total'] > 0): ?>
                            <div style="display:flex; gap:4px; justify-content:center;">
                                <a href="<?php echo e(route('laporan.pesanan.csv', ['tahun' => $year, 'bulan' => $i+1])); ?>"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#f1f5f9; color:#475569; text-decoration:none; font-weight:600; border:1px solid #e2e8f0;"
                                   title="CSV <?php echo e($row['bulan']); ?>">CSV</a>
                                <a href="<?php echo e(route('laporan.pesanan.excel', ['tahun' => $year, 'bulan' => $i+1])); ?>"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#dcfce7; color:#166534; text-decoration:none; font-weight:600; border:1px solid #bbf7d0;"
                                   title="Excel <?php echo e($row['bulan']); ?>">XLS</a>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
                <tfoot>
                    <tr style="border-top:2px solid #e2e8f0; background:#f8fafc; font-weight:700;">
                        <td style="padding:.7rem .85rem; color:#475569;">Total <?php echo e($year); ?></td>
                        <td style="padding:.7rem .85rem; text-align:center; color:#1e293b;"><?php echo e($yearTotal); ?></td>
                        <td colspan="3"></td>
                        <td style="padding:.7rem .85rem; text-align:right; color:#16a34a; white-space:nowrap;">
                            Rp <?php echo e(number_format($yearRevenue,0,',','.')); ?>

                        </td>
                        <td style="padding:.7rem .85rem; text-align:center;">
                            <div style="display:flex; gap:4px; justify-content:center;">
                                <a href="<?php echo e(route('laporan.pesanan.csv', ['tahun' => $year])); ?>"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#f1f5f9; color:#475569; text-decoration:none; font-weight:600; border:1px solid #e2e8f0;">CSV</a>
                                <a href="<?php echo e(route('laporan.pesanan.excel', ['tahun' => $year])); ?>"
                                   target="_blank"
                                   style="font-size:.68rem; padding:2px 7px; border-radius:99px; background:#dcfce7; color:#166534; text-decoration:none; font-weight:600; border:1px solid #bbf7d0;">XLS</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views/filament/widgets/order-summary.blade.php ENDPATH**/ ?>