<!DOCTYPE html>
<?php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
?>
<script>
    window.primaryColor = "<?php echo e($settings['primary_color'] ?? '#FFAB1D'); ?>";
</script>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>" data-skin="default"
    data-assets-path="<?php echo e(asset('assets/themes/default')); ?>/" data-template="vertical-menu-template" data-bs-theme="light">

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <meta name="author" content="Adel Fawzy">
        <meta name="copyright" content="dp soft">
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />
        <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>" />
        <link rel="shortcut icon" href="<?php echo e(asset($settings['favicon'])); ?>" />
        <link rel="canonical" href="<?php echo e(url()->current()); ?>">
        <link rel="sitemap" type="application/xml" href="<?php echo e(url('/sitemap.xml')); ?>" />

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', 'Default Title'); ?>" />
        <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', 'Default Description'); ?>" />
        <meta property="og:image" content="<?php echo $__env->yieldContent('og_image', asset('default-image.jpg')); ?>" />
        <meta property="og:url" content="<?php echo e(url()->current()); ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:locale" content="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" />
        <meta property="og:site_name" content="<?php echo e($settings['name'] ?? 'DP Soft'); ?>" />

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo $__env->yieldContent('og_title', 'Default Title'); ?>">
        <meta name="twitter:description" content="<?php echo $__env->yieldContent('og_description', 'Default Description'); ?>">
        <meta name="twitter:image" content="<?php echo $__env->yieldContent('og_image', asset('default-image.jpg')); ?>">

        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="<?php echo e($settings['primary_color'] ?? '#FFAB1D'); ?>">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="<?php echo e($settings['name'] ?? 'DP Soft'); ?>">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="apple-touch-icon" href="<?php echo e(asset($settings['logo'] ?? 'default-icon.png')); ?>">

        <!-- Alternate Languages -->
        <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <link rel="alternate" hreflang="<?php echo e($localeCode); ?>"
                href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>" />
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Structured Data -->
        <?php echo $__env->yieldContent('structured_data'); ?>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/fonts/iconify-icons.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/fonts/flag-icons.css')); ?>" />

        <!-- Core CSS -->
        <!-- build:css assets/vendor/css/theme.css  -->

        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/pickr/pickr-themes.css')); ?>" />

        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/css/core.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/css/demo.css')); ?>" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/css/pages/front-page.css')); ?>" />

        <!-- endbuild -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/nouislider/nouislider.css')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/swiper/swiper.css')); ?>" />

        <!-- Page CSS -->

        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/css/pages/front-page-landing.css')); ?>" />

        <!-- Helpers -->
        <script src="<?php echo e(asset('assets/themes/default/vendor/js/helpers.js')); ?>"></script>

        <!-- Toastr CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/toastr/toastr.css')); ?>" />

        <script src="<?php echo e(asset('assets/themes/default/vendor/js/template-customizer.js')); ?>"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="<?php echo e(asset('assets/themes/default/js/front-config.js')); ?>"></script>

        <style>
            @media (max-width: 768px) {
                .app-brand-logo {
                    width: 40px;
                }
                #logo-image {
                    width: 110px !important;
                }
                #logo-dark-image {
                    width: 110px !important;
                }
            }
        </style>

        
        <?php echo $__env->yieldContent('css'); ?>

        
        <?php echo $settings['headerCode']; ?>


        
        <script async src="https://www.google.com/recaptcha/api.js?hl=<?php echo e(app()->getLocale()); ?>"></script>
    </head>

    <body>
        <script src="<?php echo e(asset('assets/themes/default/vendor/js/dropdown-hover.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/themes/default/vendor/js/mega-dropdown.js')); ?>"></script>


        <!-- Navbar: Start -->
        <?php echo $__env->make('themes.default.layouts.front.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- Navbar: End -->

        <!-- Sections:Start -->

        <div data-bs-spy="scroll" class="scrollspy-example">
           <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- / Sections:End -->

        <!-- Footer: Start -->
        <?php echo $__env->make('themes.default.layouts.front.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- Footer: End -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/theme.js  -->

        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/jquery/jquery.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/popper/popper.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/themes/default/vendor/js/bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/@algolia/autocomplete-js.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/pickr/pickr.js')); ?>"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/nouislider/nouislider.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/swiper/swiper.js')); ?>"></script>

        <!-- Main JS -->
        <script src="<?php echo e(asset('assets/themes/default/js/front-main.js')); ?>"></script>

        <!-- Page JS -->
        <script src="<?php echo e(asset('assets/themes/default/js/front-page-landing.js')); ?>"></script>

        <!-- google recaptcha required -->
        <script>
            window.addEventListener('load', () => {
                const $recaptcha = document.querySelector('#g-recaptcha-response');
                if ($recaptcha) {
                    $recaptcha.setAttribute('required', 'required');
                }
            })
        </script>

        <!-- Toastr JS -->
        <script src="<?php echo e(asset('assets/themes/default/vendor/libs/toastr/toastr.js')); ?>"></script>


        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // تهيئة إعدادات Toastr المشتركة
                const commonToastrOptions = {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                    rtl: <?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'true' : 'false'); ?>,
                    positionClass: 'toast-top-right'
                };

                // إضافة الأنماط المخصصة
                const style = document.createElement('style');
                style.textContent = `
                    .toast {
                        background-color: var(--bs-body-bg) !important;
                        color: var(--bs-body-color) !important;
                    }
                    .toast .toast-title {
                        color: var(--bs-body-color) !important;
                    }
                    .toast .toast-message {
                        color: var(--bs-body-color) !important;
                    }
                    .toast .toast-close-button {
                        color: var(--bs-body-color) !important;
                    }
                `;
                document.head.appendChild(style);

                // معالجة تنبيهات الجلسة
                <?php if(session('success') || session('error') || session('warning') || session('info') || $errors->any()): ?>
                    toastr.options = {
                        ...commonToastrOptions,
                        timeOut: 4000
                    };

                    <?php if(session('success') || session('success')): ?>
                        toastr.success('<?php echo e(session('success')); ?>');
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        toastr.error('<?php echo e(session('error')); ?>');
                    <?php endif; ?>

                    <?php if(session('warning')): ?>
                        toastr.warning('<?php echo e(session('warning')); ?>');
                    <?php endif; ?>

                    <?php if(session('info')): ?>
                        toastr.info('<?php echo e(session('info')); ?>');
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            toastr.error('<?php echo e($error); ?>');
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            });
        </script>

        
        <?php echo $__env->yieldContent('js'); ?>

        
        <?php echo $settings['footerCode']; ?>

    </body>

</html>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/layouts/front/master.blade.php ENDPATH**/ ?>