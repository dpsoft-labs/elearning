<?php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
?>
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base bx bx-menu icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                    <i class="icon-base bx bx-search icon-md"></i>
                    <span class="d-none d-md-inline-block text-muted fw-normal ms-4"><?php echo app('translator')->get('l.Search'); ?>
                        (Ctrl+/)</span>
                </a>
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
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
            <li class="nav-item dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="icon-base bx bx-sun icon-md theme-icon-active"></i>
                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li>
                        <button type="button" class="dropdown-item align-items-center active"
                            data-bs-theme-value="light" aria-pressed="false">
                            <span><i class="icon-base bx bx-sun icon-md me-3" data-icon="sun"></i><?php echo app('translator')->get('l.Light'); ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
                            aria-pressed="true">
                            <span><i class="icon-base bx bx-moon icon-md me-3" data-icon="moon"></i><?php echo app('translator')->get('l.Dark'); ?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
                            aria-pressed="false">
                            <span><i class="icon-base bx bx-desktop icon-md me-3" data-icon="desktop"></i><?php echo app('translator')->get('l.System'); ?></span>
                        </button>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- Quick links  -->
            <?php if(auth()->user()->hasAnyRole(\Spatie\Permission\Models\Role::all())): ?>
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        <i class="icon-base bx bx-grid-alt icon-md"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h6 class="mb-0 me-auto"><?php echo app('translator')->get('l.Shortcuts'); ?></h6>
                                
                            </div>
                        </div>
                        <div class="dropdown-shortcuts-list scrollable-container">
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-calendar icon-md text-heading"></i>
                                    </span>
                                    <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                    <small>Appointments</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-food-menu icon-md text-heading"></i>
                                    </span>
                                    <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                    <small>Manage Accounts</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-user icon-md text-heading"></i>
                                    </span>
                                    <a href="<?php echo e(route('dashboard.admins.students')); ?>"
                                        class="stretched-link"><?php echo app('translator')->get('l.Students'); ?></a>
                                    <small><?php echo app('translator')->get('l.Manage Students'); ?></small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-check-shield icon-md text-heading"></i>
                                    </span>
                                    <a href="<?php echo e(route('dashboard.admins.roles')); ?>"
                                        class="stretched-link"><?php echo app('translator')->get('l.Roles'); ?></a>
                                    <small><?php echo app('translator')->get('l.Manage Roles'); ?></small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-pie-chart-alt-2 icon-md text-heading"></i>
                                    </span>
                                    <a href="index.html" class="stretched-link">Dashboard</a>
                                    <small>User Dashboard</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-cog icon-md text-heading"></i>
                                    </span>
                                    <a href="pages-account-settings-account.html"
                                        class="stretched-link"><?php echo app('translator')->get('l.Setting'); ?></a>
                                    <small><?php echo app('translator')->get('l.System Settings'); ?></small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-help-circle icon-md text-heading"></i>
                                    </span>
                                    <a href="pages-faq.html" class="stretched-link">FAQs</a>
                                    <small>FAQs & Articles</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-window-open icon-md text-heading"></i>
                                    </span>
                                    <a href="modal-examples.html" class="stretched-link">Modals</a>
                                    <small>Useful Popups</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
            <!-- Quick links -->

            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    <span class="position-relative">
                        <i class="icon-base bx bx-bell icon-md"></i>
                        <?php if(auth()->user()->UnreadNotifications->count() > 0): ?>
                            <span
                                class="badge rounded-pill bg-danger badge-dot badge-notifications border blink"></span>
                        <?php endif; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h6 class="mb-0 me-auto"><?php echo app('translator')->get('l.Notifications'); ?></h6>
                            <div class="d-flex align-items-center h6 mb-0">
                                <span
                                    class="badge bg-label-primary me-2"><?php echo e(auth()->user()->UnreadNotifications->count()); ?>

                                    <?php echo app('translator')->get('l.New'); ?></span>
                                <a href="<?php echo e(route('dashboard.notification-markAll')); ?>"
                                    class="dropdown-notifications-all p-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="<?php echo app('translator')->get('l.Mark all as read'); ?>"><i
                                        class="icon-base bx bx-envelope-open text-heading"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            <?php $__currentLoopData = auth()->user()->Notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li
                                    class="list-group-item list-group-item-action dropdown-notifications-item <?php if($notification->read_at != null): ?> mark-as-read <?php endif; ?>">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <span class="avatar-initial rounded-circle bg-label-danger">
                                                    <i class="<?php echo e($notification->data['icon']); ?> fa-md"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <a class="flex-grow-1"
                                            href="<?php echo e(route('dashboard.notification-show')); ?>?id=<?php echo e(encrypt($notification->id)); ?>">
                                            <h6 class="small mb-0"><?php echo e($notification->data['title']); ?></h6>
                                            
                                            <small
                                                class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                                        </a>
                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                            <a href="<?php echo e(route('dashboard.notification-show')); ?>?id=<?php echo e(encrypt($notification->id)); ?>"
                                                class="dropdown-notifications-read <?php if($notification->read_at == null): ?> blink <?php endif; ?>"><span
                                                    class="badge badge-dot"
                                                    <?php if($notification->read_at != null): ?> style="background-color: #8593a5;" <?php endif; ?>></span></a>
                                            <a href="<?php echo e(route('dashboard.notification-delete')); ?>?id=<?php echo e(encrypt($notification->id)); ?>"
                                                class="dropdown-notifications-archive"><span
                                                    class="icon-base bx bx-x"></span></a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <li class="border-top">
                        <div class="d-grid p-4">
                            <a class="btn btn-primary btn-sm d-flex"
                                href="<?php echo e(route('dashboard.notification-deleteAll')); ?>">
                                <small class="align-middle"><?php echo app('translator')->get('l.Delete all notifications'); ?></small>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="<?php echo e(auth()->user()->photo); ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="<?php echo e(auth()->user()->photo); ?>" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?php echo e(auth()->user()->firstname); ?></h6>
                                    <small class="text-muted"><?php echo e(auth()->user()->getRoleNames()->first()); ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('dashboard.profile')); ?>">
                            <i class="bx bx-user bx-md me-3"></i><span><?php echo app('translator')->get('l.My Account'); ?></span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST"><?php echo csrf_field(); ?>
                            <button class="dropdown-item" type="submit">
                                <i class="bx bx-power-off bx-md me-3"></i>
                                <span class="align-middle"><?php echo app('translator')->get('l.Log Out'); ?></span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0"
            placeholder="<?php echo app('translator')->get('l.Search'); ?>..." aria-label="<?php echo app('translator')->get('l.Search'); ?>..." />
        <i class="bx bx-x bx-md search-toggler cursor-pointer"></i>
    </div>
</nav>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/layouts/back/nav.blade.php ENDPATH**/ ?>