<?php $__env->startSection('seo'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Lives'); ?>
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
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="page-category">

            <div class="row">
                <?php $__currentLoopData = $lives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $live): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <?php
                            $current_time = now();
                            $live_start_time = \Carbon\Carbon::parse($live->date);
                            $is_live_now = $live_start_time->isPast();
                        ?>

                        <div class="card position-relative">
                            <div class="image-container">
                                <img src="<?php echo e(asset($live->course->image)); ?>" class="card-img-top" alt="<?php echo e($live->name); ?>">
                                <div
                                    class="card-overlay d-flex flex-column justify-content-center align-items-center text-center">
                                    <?php if($is_live_now): ?>
                                        <a href="<?php echo e($live->link); ?>" class="btn btn-primary">
                                            <?php echo app('translator')->get('l.Join Now'); ?>
                                        </a>
                                    <?php else: ?>
                                        <div id="countdown-<?php echo e($live->id); ?>" class="text-white"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center"><?php echo e($live->name); ?></h5>
                            </div>
                        </div>
                    </div>

                    <script>
                        // JavaScript for Countdown Timer
                        const countdown<?php echo e($live->id); ?> = document.getElementById('countdown-<?php echo e($live->id); ?>');
                        const liveStartTime<?php echo e($live->id); ?> = new Date("<?php echo e(Carbon\Carbon::parse($live->date)->toIso8601String()); ?>")
                            .getTime();

                        const timer<?php echo e($live->id); ?> = setInterval(function() {
                            const now = new Date().getTime();
                            const distance = liveStartTime<?php echo e($live->id); ?> - now;

                            if (distance > 0) {
                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                countdown<?php echo e($live->id); ?>.innerText =
                                    `<?php echo app('translator')->get('l.Time remaining'); ?>: ${days} <?php echo app('translator')->get('l.days'); ?> ${hours} <?php echo app('translator')->get('l.hours'); ?> ${minutes} <?php echo app('translator')->get('l.minutes'); ?> ${seconds} <?php echo app('translator')->get('l.seconds'); ?>`;
                            } else {
                                clearInterval(timer<?php echo e($live->id); ?>);
                                countdown<?php echo e($live->id); ?>.innerText = "<?php echo app('translator')->get('l.Live Started'); ?>!";
                            }
                        }, 1000);
                    </script>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </div>
    <!-- / Content -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/lives/lives-list.blade.php ENDPATH**/ ?>