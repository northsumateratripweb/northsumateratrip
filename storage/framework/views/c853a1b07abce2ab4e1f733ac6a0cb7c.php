<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', ($settings['site_name'] ?? 'NorthSumateraTrip') . ' - ' . ($settings['site_slogan'] ?? 'Private Tour Sumatera Utara')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', $settings['site_description'] ?? 'Mudahnya Private Trip di Sumatera. Paket wisata Sumatera Utara terbaik dengan harga terjangkau.'); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#F59E0B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        display: ['Outfit', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php if (! empty(trim($__env->yieldContent('header_hero')))): ?>
        <?php echo $__env->yieldContent('header_hero'); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- WhatsApp Floating Button -->
    <?php if (isset($component)) { $__componentOriginald7091dc45d318d44153565cb4c9c9ed5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7091dc45d318d44153565cb4c9c9ed5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.whatsapp-floating','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('whatsapp-floating'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7091dc45d318d44153565cb4c9c9ed5)): ?>
<?php $attributes = $__attributesOriginald7091dc45d318d44153565cb4c9c9ed5; ?>
<?php unset($__attributesOriginald7091dc45d318d44153565cb4c9c9ed5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7091dc45d318d44153565cb4c9c9ed5)): ?>
<?php $component = $__componentOriginald7091dc45d318d44153565cb4c9c9ed5; ?>
<?php unset($__componentOriginald7091dc45d318d44153565cb4c9c9ed5); ?>
<?php endif; ?>
    
    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\layouts\app.blade.php ENDPATH**/ ?>