<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Taxes settings'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bx bx-money-withdraw"></i> <?php echo app('translator')->get('l.Taxes settings'); ?></h5>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                            <div class="text-end mb-3">
                                <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addTaxModal">
                                    <i class="bx bx-plus me-1"></i> <?php echo app('translator')->get('l.Add New Tax'); ?>
                                </a>
                            </div>
                            <div class="modal fade" id="addTaxModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo e(__('l.Add New Tax')); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?php echo e(route('dashboard.admins.taxes-store')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label"><?php echo e(__('l.Name')); ?> <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label"><?php echo e(__('l.Type')); ?> <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control form-select" name="type" required>
                                                            <option value="fixed"><?php echo app('translator')->get('l.Fixed'); ?></option>
                                                            <option value="percentage"><?php echo app('translator')->get('l.Percentage'); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-5">
                                                        <label class="form-label"><?php echo e(__('l.Rate value')); ?> <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="rate" required>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <div class="form-check form-switch mb-2">
                                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="is_default" />
                                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?php echo app('translator')->get('l.Is Default'); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <div class="form-check form-switch mb-2">
                                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="auto_translate" />
                                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?php echo app('translator')->get('l.Auto Translate'); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal"><?php echo e(__('l.Cancel')); ?></button>
                                                <button type="submit" class="btn btn-primary"><?php echo e(__('l.Add')); ?></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo app('translator')->get('l.Name'); ?></th>
                                        <th><?php echo app('translator')->get('l.Type'); ?></th>
                                        <th><?php echo app('translator')->get('l.Rate value'); ?></th>
                                        <th><?php echo app('translator')->get('l.Is Default'); ?></th>
                                        <th><?php echo app('translator')->get('l.Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><code><?php echo e($tax->name); ?></code></td>
                                        <td><?php echo e($tax->type == 'fixed' ? __('l.Fixed') : __('l.Percentage')); ?></td>
                                        <td><?php echo e($tax->rate); ?></td>
                                        <td><?php if($tax->is_default == 1): ?> <span class="badge bg-label-success"><?php echo app('translator')->get('l.Yes'); ?></span> <?php else: ?> <span class="badge bg-label-danger"><?php echo app('translator')->get('l.No'); ?></span> <?php endif; ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <div class="d-flex gap-2">
                                                    <a href="<?php echo e(route('dashboard.admins.taxes-edit', ['id' => encrypt($tax->id)])); ?>" class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('dashboard.admins.taxes-get-translations', ['id' => encrypt($tax->id)])); ?>" class="btn btn-sm btn-dark">
                                                        <i class="bx bx-globe"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-tax" data-id="<?php echo e(encrypt($tax->id)); ?>">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center"><?php echo app('translator')->get('l.No taxes found'); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            $('.delete-tax').on('click', function() {
                var taxId = $(this).data('id');

                Swal.fire({
                    title: "<?php echo e(__('l.Are you sure?')); ?>",
                    text: "<?php echo e(__('l.You will be delete this forever!')); ?>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "<?php echo e($settings['primary_color']); ?>",
                    cancelButtonColor: '#d33',
                    confirmButtonText: "<?php echo e(__('l.Yes, delete it!')); ?>",
                    cancelButtonText: "<?php echo e(__('l.Cancel')); ?>"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('dashboard.admins.taxes-delete')); ?>?id=" +
                            taxId;
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/taxes/taxes-list.blade.php ENDPATH**/ ?>