<?php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
?>
<nav class="layout-navbar shadow-none py-0">
    <div class="container">
        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8">
                <!-- Mobile menu toggle: Start-->
                <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="icon-base bx bx-menu icon-lg align-middle text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="<?php echo e(route('index')); ?>" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img id="logo-image" src="<?php echo e(asset($settings['logo'])); ?>" alt="<?php echo e($settings['name']); ?>"
                            width="180">
                        <img id="logo-dark-image" src="<?php echo e(asset($settings['logo_black'])); ?>"
                            alt="<?php echo e($settings['name']); ?>" width="180">
                    </span>
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="icon-base bx bx-x icon-lg"></i>
                </button>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium "
                            href="<?php echo e(route('index')); ?>"><?php echo app('translator')->get('front.home'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo e(request()->is('about') ? 'active' : ''); ?>"
                            href="#about"><?php echo app('translator')->get('front.about'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo e(request()->is('blog') ? 'active' : ''); ?>"
                            href="#pricing"><?php echo app('translator')->get('front.pricing'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo e(request()->is('team') ? 'active' : ''); ?>"
                            href="#team"><?php echo app('translator')->get('front.team'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo e(request()->is('faqs') ? 'active' : ''); ?>"
                            href="#faq"><?php echo app('translator')->get('front.faqs'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium <?php echo e(request()->is('contact') ? 'active' : ''); ?>"
                            href="#contact"><?php echo app('translator')->get('front.contact'); ?></a>
                    </li>
                    
                </ul>
            </div>
            <div class="landing-menu-overlay d-lg-none"></div>
            <!-- Menu wrapper: End -->
            <!-- Toolbar: Start -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Language -->
                <li class="nav-item dropdown-language dropdown me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" style="margin: 0;">
                        <i class="icon-base bx bx-globe icon-md"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php $__currentLoopData = $headerLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a class="dropdown-item <?php echo e(LaravelLocalization::getCurrentLocale() == $language->code ? 'active' : ''); ?>"
                                    href="<?php echo e(LaravelLocalization::getLocalizedURL($language->code, null, [], true)); ?>">
                                    <i class="fi fi-<?php echo e($language->flag); ?>"></i>
                                    <span><?php echo e($language->native); ?></span>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                <!-- /Language -->
                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        <i class="icon-base bx bx-sun icon-lg theme-icon-active"></i>
                        <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                        <li>
                            <button type="button" class="dropdown-item align-items-center active"
                                data-bs-theme-value="light" aria-pressed="false">
                                <span><i class="icon-base bx bx-sun icon-md me-3"
                                        data-icon="sun"></i><?php echo app('translator')->get('front.light'); ?></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
                                aria-pressed="true">
                                <span><i class="icon-base bx bx-moon icon-md me-3"
                                        data-icon="moon"></i><?php echo app('translator')->get('front.dark'); ?></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
                                aria-pressed="false">
                                <span><i class="icon-base bx bx-desktop icon-md me-3"
                                        data-icon="desktop"></i><?php echo app('translator')->get('front.system'); ?></span>
                            </button>
                        </li>
                    </ul>
                </li>
                <!-- / Style Switcher-->

                <!-- navbar button: Start -->
                <li>
                    <?php if(auth()->check()): ?>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary"><span
                                class="tf-icons icon-base bx bx-log-in-circle scaleX-n1-rtl me-md-1"></span><span
                                class="d-none d-md-block"><?php echo app('translator')->get('front.dashboard'); ?></span></a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary"><span
                                class="tf-icons icon-base bx bx-log-in-circle scaleX-n1-rtl me-md-1"></span><span
                                class="d-none d-md-block"><?php echo app('translator')->get('front.login_register'); ?></span></a>
                    <?php endif; ?>
                </li>
                <!-- navbar button: End -->
            </ul>
            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/layouts/front/nav.blade.php ENDPATH**/ ?>