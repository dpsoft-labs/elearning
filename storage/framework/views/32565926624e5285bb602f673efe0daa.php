<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Edit SEO Page'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="<?php echo e(route('dashboard.admins.seo')); ?>"
                                class="btn btn-icon btn-outline-primary back-btn me-3">
                                <i class="bx bx-arrow-back"></i>
                            </a>
                            <h4 class="fw-bold py-3 mb-0">
                                <i class="bx bx-edit text-primary me-1"></i>
                                <?php echo app('translator')->get('l.Edit SEO Page'); ?>: <?php echo e($seoPage->getTranslation('title', $defaultLanguage)); ?>

                            </h4>
                        </div>

                        <a href="<?php echo e(route('dashboard.admins.seo-get-translations', ['id' => encrypt($seoPage->id)])); ?>"
                            class="btn btn-dark auto-translate-btn">
                            <i class="bx bx-globe me-1"></i> <?php echo app('translator')->get('l.Manage Translations'); ?>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('dashboard.admins.seo-update', ['id' => encrypt($seoPage->id)])); ?>"
                        method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <h5 class="mt-4 mb-3 border-top pt-3"><?php echo app('translator')->get('l.SEO Information'); ?></h5>

                        <div class="mb-3">
                            <label for="title" class="form-label"><?php echo app('translator')->get('l.Meta Title'); ?></label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?php echo e(old('title', $seoPage->getTranslation('title', $defaultLanguage))); ?>">
                            <small class="text-muted"><?php echo app('translator')->get('l.The title that appears in search engines'); ?></small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label"><?php echo app('translator')->get('l.Meta Description'); ?></label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo e(old('description', $seoPage->getTranslation('description', $defaultLanguage))); ?></textarea>
                            <small class="text-muted"><?php echo app('translator')->get('l.The description that appears in search results'); ?></small>
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label"><?php echo app('translator')->get('l.Meta Keywords'); ?></label>
                            <textarea class="form-control" id="meta_keywords" name="keywords" rows="2"><?php echo e(old('keywords', $seoPage->getTranslation('keywords', $defaultLanguage))); ?></textarea>
                            <small class="text-muted"><?php echo app('translator')->get('l.Comma separated keywords related to the page'); ?></small>
                        </div>

                        <h5 class="mt-4 mb-3 border-top pt-3"><?php echo app('translator')->get('l.Social Media Sharing'); ?></h5>

                        <div class="mb-3">
                            <label for="og_title" class="form-label"><?php echo app('translator')->get('l.OG Title'); ?></label>
                            <input type="text" class="form-control" id="og_title" name="og_title"
                                value="<?php echo e(old('og_title', $seoPage->getTranslation('og_title', $defaultLanguage))); ?>">
                            <small class="text-muted"><?php echo app('translator')->get('l.Title that appears when sharing on social media'); ?></small>
                        </div>

                        <div class="mb-3">
                            <label for="og_description" class="form-label"><?php echo app('translator')->get('l.OG Description'); ?></label>
                            <textarea class="form-control" id="og_description" name="og_description" rows="3"><?php echo e(old('og_description', $seoPage->getTranslation('og_description', $defaultLanguage))); ?></textarea>
                            <small class="text-muted"><?php echo app('translator')->get('l.Description that appears when sharing on social media'); ?></small>
                        </div>

                        <div class="mb-3">
                            <label for="og_image" class="form-label"><?php echo app('translator')->get('l.OG Image'); ?></label>
                            <?php if($seoPage->og_image): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(asset($seoPage->og_image)); ?>" alt="OG Image" class="img-thumbnail"
                                        style="max-height: 100px;">
                                </div>
                            <?php endif; ?>
                            <input class="form-control" type="file" id="og_image" name="og_image">
                            <small class="text-muted"><?php echo app('translator')->get('l.The image that appears when sharing on social media'); ?></small>
                        </div>

                        <h5 class="mt-4 mb-3 border-top pt-3"><?php echo app('translator')->get('l.Structured Data'); ?></h5>

                        <div class="mb-3">
                            <label for="structured_data" class="form-label"><?php echo app('translator')->get('l.JSON-LD Structured Data'); ?></label>
                            <textarea class="form-control" id="structured_data" name="structured_data" rows="5"><?php echo e(old('structured_data', $seoPage->structured_data)); ?></textarea>
                            <small class="text-muted"><?php echo app('translator')->get('l.JSON-LD format structured data for rich snippets'); ?></small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Update'); ?></button>
                            <a href="<?php echo e(route('dashboard.admins.seo')); ?>" class="btn btn-secondary"><?php echo app('translator')->get('l.Cancel'); ?></a>
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
        // التحقق من صحة JSON للبيانات المنظمة
        const structuredDataInput = document.getElementById('structured_data');
        structuredDataInput.addEventListener('blur', function() {
            try {
                if (structuredDataInput.value) {
                    const json = JSON.parse(structuredDataInput.value);
                    structuredDataInput.value = JSON.stringify(json, null, 2);
                }
            } catch (e) {
                alert('<?php echo app('translator')->get('l.Invalid JSON format'); ?>');
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/seo/seo-edit.blade.php ENDPATH**/ ?>