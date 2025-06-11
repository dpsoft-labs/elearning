<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Team Member Edit')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        #imagePreview {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title"><?php echo e(__('l.Team Member Edit')); ?></h5>

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

                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('dashboard.admins.teams-update')); ?>" method="POST"
                            enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <input type="hidden" name="id" value="<?php echo e($team->id ? encrypt($team->id) : ''); ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required
                                        value="<?php echo e($team->name); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Job Title')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="job" required
                                        value="<?php echo e($team->job); ?>">
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label"><?php echo e(__('l.Profile Image')); ?></label>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="me-3">
                                            <div class="mb-2"><?php echo e(__('l.Current Image')); ?>:</div>
                                            <?php if($team->image): ?>
                                                <img src="<?php echo e(asset($team->image)); ?>" alt="<?php echo e($team->name); ?>"
                                                    width="100" height="100" class="rounded">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('images/default-user.png')); ?>"
                                                    alt="<?php echo e($team->name); ?>" width="100" height="100"
                                                    class="rounded">
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="mb-2" id="previewLabel" style="display: none;">
                                                <?php echo e(__('l.New Image Preview')); ?>:</div>
                                            <img id="imagePreview" src="#" alt="<?php echo e(__('l.New Image Preview')); ?>"
                                                width="100" height="100" class="rounded">
                                        </div>
                                    </div>
                                    <input type="file" class="form-control" name="image" id="imageInput"
                                        accept="image/*">
                                    <small
                                        class="text-muted"><?php echo e(__('l.Allowed JPG, GIF or PNG. Max size of 800K')); ?></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Facebook URL')); ?></label>
                                    <input type="url" class="form-control" name="facebook"
                                        value="<?php echo e($team->facebook); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Twitter URL')); ?></label>
                                    <input type="url" class="form-control" name="twitter" value="<?php echo e($team->twitter); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.Instagram URL')); ?></label>
                                    <input type="url" class="form-control" name="instagram"
                                        value="<?php echo e($team->instagram); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo e(__('l.LinkedIn URL')); ?></label>
                                    <input type="url" class="form-control" name="linkedin"
                                        value="<?php echo e($team->linkedin); ?>">
                                </div>

                                <div class="col-12 mt-3 text-end">
                                    <a href="<?php echo e(route('dashboard.admins.teams')); ?>"
                                        class="btn btn-outline-secondary me-2"><?php echo e(__('l.Cancel')); ?></a>
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('l.Save Changes')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            // معاينة الصورة عند اختيارها
            $('#imageInput').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').css('display', 'block');
                        $('#previewLabel').css('display', 'block');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/pages/teams/teams-edit.blade.php ENDPATH**/ ?>