<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="<?php echo app('translator')->get('l.Content & Quizzes'); ?>"><?php echo app('translator')->get('l.Lectures & Lives & Quizzes'); ?></span>
</li>
<li class="menu-item <?php echo e(request()->is('*/lectures*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.lectures')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-play-circle"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Lectures'); ?>"><?php echo app('translator')->get('l.Lectures'); ?></div>
    </a>
</li>
<li class="menu-item <?php echo e(request()->is('*/lives*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.lives')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Lives'); ?>"><?php echo app('translator')->get('l.Lives'); ?></div>
    </a>
</li>
<li class="menu-item <?php echo e(request()->is('*/quizzes*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.quizzes')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-check"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Quizzes'); ?>"><?php echo app('translator')->get('l.Quizzes'); ?></div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="<?php echo app('translator')->get('l.Registration & Invoices'); ?>"><?php echo app('translator')->get('l.Registration & Invoices'); ?></span>
</li>
<li class="menu-item <?php echo e(request()->is('*/registrations*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.registrations')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Registrations'); ?>"><?php echo app('translator')->get('l.Registrations'); ?></div>
    </a>
</li>
<li class="menu-item <?php echo e(request()->is('*/invoices*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.invoices')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Invoices'); ?>"><?php echo app('translator')->get('l.Invoices'); ?></div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="<?php echo app('translator')->get('l.Notes & Support'); ?>"><?php echo app('translator')->get('l.Notes & Support'); ?></span>
</li>
<li class="menu-item <?php echo e(request()->is('*/ai*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.ai')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bot"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.AI Assistant'); ?>"><?php echo app('translator')->get('l.AI Assistant'); ?></div>
    </a>
</li>
<li class="menu-item <?php echo e(request()->is('*/tickets*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.tickets')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-message-square-dots"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Support Tickets'); ?>"><?php echo app('translator')->get('l.Support Tickets'); ?></div>
    </a>
</li>
<li class="menu-item <?php echo e(request()->is('*/notes*') ? 'active' : ''); ?>">
    <a href="<?php echo e(route('dashboard.users.notes')); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-note"></i>
        <div class="text-truncate" data-i18n="<?php echo app('translator')->get('l.Notes'); ?>"><?php echo app('translator')->get('l.Notes'); ?></div>
    </a>
</li>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/layouts/back/headerUsers.blade.php ENDPATH**/ ?>