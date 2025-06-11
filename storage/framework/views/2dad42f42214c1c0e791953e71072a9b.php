<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.SEO settings'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bx bx-search-alt-2"></i> <?php echo app('translator')->get('l.SEO settings'); ?></h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo app('translator')->get('l.Slug'); ?></th>
                                        <th><?php echo app('translator')->get('l.Title'); ?></th>
                                        <th><?php echo app('translator')->get('l.Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $seoPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><code><?php echo e($page->slug); ?></code></td>
                                        <td><?php echo e(Str::limit($page->title, 30)); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?php echo e(route('dashboard.admins.seo-show', ['id' => encrypt($page->id)])); ?>" class="btn btn-sm btn-info">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="<?php echo e(route('dashboard.admins.seo-edit', ['id' => encrypt($page->id)])); ?>" class="btn btn-sm btn-warning">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="<?php echo e(route('dashboard.admins.seo-get-translations', ['id' => encrypt($page->id)])); ?>" class="btn btn-sm btn-dark">
                                                    <i class="bx bx-globe"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center"><?php echo app('translator')->get('l.No SEO pages found'); ?></td>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/seo/seo-list.blade.php ENDPATH**/ ?>