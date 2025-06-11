<div class="d-flex gap-2">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show students')): ?>
        <a href="<?php echo e(route('dashboard.admins.students-show', ['id' => encrypt($row->id)])); ?>"
            class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('l.Show')); ?>">
            <i class="fa fa-eye"></i>
        </a>
        <a href="<?php echo e(route('dashboard.admins.registrations-show', ['student_id' => encrypt($row->id)])); ?>"
            class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
            title="<?php echo e(__('l.Registrations')); ?>">
            <i class="fa fa-book"></i>
        </a>
    <?php endif; ?>


    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit students')): ?>
        <a href="<?php echo e(route('dashboard.admins.students-edit', ['id' => encrypt($row->id)])); ?>"
            class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
            title="<?php echo e(__('l.Edit')); ?>">
            <i class="fa fa-pencil"></i>
        </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit students')): ?>
        <a href="<?php echo e(route('impersonate', $row->id)); ?>" class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip"
            title="<?php echo e(__('l.Login as')); ?> <?php echo e($row->firstname); ?>">
            <i class="fas fa-door-open"></i>
        </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete students')): ?>
        <a href="<?php echo e(route('dashboard.admins.students-inactive', ['id' => encrypt($row->id)])); ?>"
            class="btn btn-sm btn-icon btn-danger delete-record" data-bs-toggle="tooltip" data-bs-placement="top"
            title="<?php echo e(__('l.Delete')); ?>" data-inactive="false">
            <i class="fa fa-trash"></i>
        </a>
    <?php endif; ?>
</div>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/students/action-buttons.blade.php ENDPATH**/ ?>