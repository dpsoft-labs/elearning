<?php $__env->startSection('seo'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Lectures'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .image-container {
            width: 100%;
            height: 200px;
            /* تحديد ارتفاع ثابت للصور */
            overflow: hidden;
            /* لإخفاء الأجزاء الزائدة من الصور */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            /* تضمن أن العرض يغطي الحاوية بالكامل */
            height: auto;
            /* تحافظ على التناسب */
            object-fit: cover;
            /* لضبط الصورة لتملأ الحاوية بدون تشويه */
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            /* خلفية شبه شفافة */
            color: white;
            opacity: 0;
            /* مخفي افتراضيًا */
            transition: opacity 0.3s ease-in-out;
            /* تأثير الانتقال */
        }

        .image-container:hover .card-overlay {
            opacity: 1;
            /* يظهر عند الوقوف */
        }

        /* تنسيقات جديدة للكروت */
        .lecture-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: none;
        }

        .lecture-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .lecture-card .card-body {
            padding: 1.5rem;
            position: relative;
        }

        .lecture-card .card-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .lecture-card .lecture-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #007bff;
        }

        .lecture-card .card-footer {
            background-color: rgba(0, 123, 255, 0.1);
            border-top: none;
            padding: 0.75rem 1.5rem;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <?php if(isset($courses)): ?>
            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if($course->image): ?>
                                <img src="<?php echo e(asset($course->image)); ?>" class="card-img-top" alt="<?php echo e($course->name); ?>"
                                    style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo e($course->name); ?></h4>
                                <div class="text-center">
                                    <a href="<?php echo e(route('dashboard.users.lectures')); ?>?course=<?php echo e(encrypt($course->id)); ?>"
                                        class="btn btn-primary mt-3">
                                        <?php echo app('translator')->get('l.View Lectures'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo app('translator')->get('l.No Courses Found'); ?></h4>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <?php $__currentLoopData = $lectures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <a href="<?php echo e(route('dashboard.users.lectures-show')); ?>?id=<?php echo e(encrypt($lecture->id)); ?>"
                            class="text-decoration-none">
                            <div class="card lecture-card">
                                <div class="card-body text-center">
                                    <div class="lecture-icon">
                                        <i class="fas fa-book-reader"></i>
                                    </div>
                                    <h5 class="card-title"><?php echo e($lecture->name); ?></h5>
                                    <div class="card-footer mt-3">
                                        <small class="text-muted"><?php echo app('translator')->get('l.Click to view lecture'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/lectures/lectures-list.blade.php ENDPATH**/ ?>