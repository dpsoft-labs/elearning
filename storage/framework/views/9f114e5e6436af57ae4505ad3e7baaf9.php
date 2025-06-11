<?php $__env->startSection('title'); ?>
    <?php echo e($tax->name); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit blog_category')): ?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($error); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <a href="<?php echo e(route('dashboard.admins.taxes')); ?>"
                            class="btn btn-icon btn-outline-primary back-btn me-3">
                            <i class="bx bx-arrow-back"></i>
                        </a>
                        <h4 class="fw-bold py-3 mb-0">
                            <i class="bx bx-edit text-primary me-1"></i>
                            <?php echo e($tax->name); ?>

                        </h4>
                    </div>

                    <a href="<?php echo e(route('dashboard.admins.taxes-get-translations', ['id' => encrypt($tax->id)])); ?>"
                        class="btn btn-dark auto-translate-btn">
                        <i class="bx bx-globe me-1"></i> <?php echo app('translator')->get('l.Manage Translations'); ?>
                    </a>
                </div>

                <div class="card-body">
                    <form id="translateForm" class="row g-3" method="post"
                        action="<?php echo e(route('dashboard.admins.taxes-update')); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('patch'); ?>
                        <input type="hidden" name="id" value="<?php echo e(encrypt($tax->id)); ?>">

                        <div class="row">
                            <div class="col-12 mb-5">
                                <label class="form-label"><?php echo app('translator')->get('l.Name'); ?><i class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i> <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control"
                                    value="<?php echo e($tax->getTranslation('name', $defaultLanguage->code)); ?>"required />
                            </div>
                            <div class="col-6 mb-5">
                                <label class="form-label"><?php echo app('translator')->get('l.Type'); ?> <span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="type" required>
                                    <option value="fixed" <?php if($tax->type == 'fixed'): ?> selected <?php endif; ?>><?php echo app('translator')->get('l.Fixed'); ?></option>
                                    <option value="percentage" <?php if($tax->type == 'percentage'): ?> selected <?php endif; ?>><?php echo app('translator')->get('l.Percentage'); ?></option>
                                </select>
                            </div>
                            <div class="col-6 mb-5">
                                <label class="form-label"><?php echo app('translator')->get('l.Rate value'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="rate" class="form-control" value="<?php echo e($tax->rate); ?>" required />
                            </div>

                            <div class="col-6 mb-5">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="is_default" <?php if($tax->is_default == 1): ?> checked <?php endif; ?> />
                                    <label class="form-check-label" for="flexSwitchCheckDefault"><?php echo app('translator')->get('l.Is Default'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <a href="<?php echo e(route('dashboard.admins.taxes')); ?>" class="btn btn-label-secondary"><?php echo app('translator')->get('l.Cancel'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Update'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- / Content -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/taxes/taxes-edit.blade.php ENDPATH**/ ?>