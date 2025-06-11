<div class="d-flex gap-2">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show users')): ?>
        <a href="<?php echo e(route('dashboard.admins.users-show', ['id' => encrypt($row->id)])); ?>"
           class="btn btn-sm btn-icon btn-info"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           title="<?php echo e(__('l.Show')); ?>">
            <i class="fa fa-eye"></i>
        </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit users')): ?>
        <?php if(($row->id == 1 || $row->id == 2) && auth()->user()->id == $row->id || ($row->id != 1 && $row->id != 2)): ?>
            <a href="<?php echo e(route('dashboard.admins.users-edit', ['id' => encrypt($row->id)])); ?>"
                class="btn btn-sm btn-icon btn-warning"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="<?php echo e(__('l.Edit')); ?>">
                <i class="fa fa-pencil"></i>
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($row->id != 1 && $row->id != 2): ?>
        <?php if(auth()->user()->id != $row->id): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit users')): ?>
                <a href="<?php echo e(route('impersonate', $row->id)); ?>"
                    class="btn btn-sm btn-icon btn-success"
                    data-bs-toggle="tooltip"
                    title="<?php echo e(__('l.Login as')); ?> <?php echo e($row->firstname); ?>">
                    <i class="fas fa-door-open"></i>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete users')): ?>
                <a href="<?php echo e(route('dashboard.admins.users-inactive', ['id' => encrypt($row->id)])); ?>"
                    class="btn btn-sm btn-icon btn-danger delete-record"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="<?php echo e(__('l.Delete')); ?>"
                    data-inactive="false">
                    <i class="fa fa-trash"></i>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/users/action-buttons.blade.php ENDPATH**/ ?>