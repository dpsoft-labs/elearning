<?php $__env->startSection('title'); ?>
    <?php echo e($lecture->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="content-wrapper">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lectures')): ?>
                <!-- Add Role Modal -->
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div id="addRoleModal" tabindex="-1" aria-hidden="false">
                    <div class=" modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <h3 class="role-title mb-2"><?php echo e($lecture->name); ?></h3>
                                </div>
                                <!-- Add role form -->
                                <form id="editProductForm" method="post" class="row g-3" enctype="multipart/form-data" action="<?php echo e(route('dashboard.admins.lectures-update')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('patch'); ?>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="name"><?php echo app('translator')->get('l.Name'); ?></label>
                                        <input type="text" id="name" name="name" class="form-control" required value="<?php echo e($lecture->name); ?>" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="description"><?php echo app('translator')->get('l.Description'); ?></label>
                                        <textarea type="text" id="description" name="description" class="form-control"
                                            placeholder="<?php echo app('translator')->get('l.Enter a lecture description'); ?>"><?php echo e($lecture->description); ?></textarea>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="video"><?php echo app('translator')->get('l.Video'); ?></label>
                                        <input type="text" id="video" name="video" class="form-control"
                                            placeholder="<?php echo app('translator')->get('l.Enter a lecture video'); ?>" value="<?php echo e($lecture->video); ?>" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label" for="files"><?php echo app('translator')->get('l.Change Files'); ?></label>
                                        <input type="file" id="files" name="files" class="form-control" />
                                        <?php if($lecture->files): ?>
                                            <a href="<?php echo e(asset($lecture->files)); ?>" target="_blank"><?php echo app('translator')->get('l.View File'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-secondary me-sm-3 me-1"><?php echo app('translator')->get('l.Update'); ?></button>
                                        <a href="<?php echo e(route('dashboard.admins.lectures')); ?>?course=<?php echo e(encrypt($lecture->course_id)); ?>" class="btn btn-label-secondary"><?php echo app('translator')->get('l.Back'); ?></a>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo e(encrypt($lecture->id)); ?>" />
                                </form>
                            </div>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/lectures/lectures-edit.blade.php ENDPATH**/ ?>