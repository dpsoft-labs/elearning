<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Student Registrations')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .course-card {
            transition: all 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title"><?php echo e(__('l.Student Registrations')); ?></h5>
                        <h6 class="text-muted"><?php echo e($student->firstname); ?> <?php echo e($student->lastlname); ?> (<?php echo e($student->sid); ?>)</h6>
                    </div>
                    <div class="d-flex">
                        <?php if(
                            $settings['registration_status'] == '1' &&
                                $settings['registration_start_date'] <= now() &&
                                $settings['registration_end_date'] >= now()): ?>
                            <a href="<?php echo e(route('dashboard.users.registrations-available', ['student_id' => $student->id])); ?>"
                                class="btn btn-primary">
                                <i class="fa fa-plus me-1"></i><?php echo e(__('l.Add Courses')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('l.Student Information')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 me-3">
                                <img src="<?php echo e(asset($student->photo)); ?>" alt="<?php echo e($student->firstname); ?>" class="rounded-circle"
                                    width="60" height="60">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1"><?php echo e($student->firstname); ?> <?php echo e($student->lastlname); ?></h5>
                                <p class="mb-0"><?php echo e($student->email); ?></p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6><?php echo e(__('l.College')); ?></h6>
                            <p><?php echo e($student->college->name ?? 'N/A'); ?></p>
                        </div>
                        <div class="mb-3">
                            <h6><?php echo e(__('l.Branch')); ?></h6>
                            <p><?php echo e($student->branch->name ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <h6><?php echo e(__('l.Total Success Hours')); ?></h6>
                            <p><?php echo e($totalSuccessHours); ?> <?php echo e(__('l.hours')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo e(__('l.Enrolled Courses')); ?></h5>
                    </div>
                    <div class="card-body">
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

                        <?php if(count($enrolledCourses) > 0): ?>
                            <div class="row">
                                <?php $__currentLoopData = $enrolledCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card course-card h-100">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <span><?php echo e($course->code); ?></span>
                                                <span class="badge bg-primary"><?php echo e($course->hours); ?>

                                                    <?php echo e(__('l.hours')); ?></span>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <img src="<?php echo e(asset($course->image)); ?>" alt="<?php echo e($course->name); ?>"
                                                            class="rounded" width="60" height="60">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title mb-1"><?php echo e($course->name); ?></h5>
                                                        <p class="card-text text-muted small">
                                                            <?php echo e($course->college->name ?? 'N/A'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <h6><?php echo e(__('l.Grades')); ?></h6>
                                                    <div class="d-flex justify-content-between small text-muted">
                                                        <span><?php echo e(__('l.Quizzes')); ?>: <?php echo e($course->pivot->quizzes); ?></span>
                                                        <span><?php echo e(__('l.Midterm')); ?>: <?php echo e($course->pivot->midterm); ?></span>
                                                        <span><?php echo e(__('l.Final')); ?>: <?php echo e($course->pivot->final); ?></span>
                                                    </div>
                                                    <div class="progress mt-2" style="height: 10px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: <?php echo e($course->pivot->total); ?>%;"
                                                            aria-valuenow="<?php echo e($course->pivot->total); ?>" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            <?php echo e($course->pivot->total); ?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                                <h5><?php echo e(__('l.No courses enrolled')); ?></h5>
                                <?php if($settings['registration_status'] == '1' &&
                                    $settings['registration_start_date'] <= now() &&
                                    $settings['registration_end_date'] >= now()): ?>
                                    <a href="<?php echo e(route('dashboard.users.registrations-available', ['student_id' => $student->id])); ?>"
                                        class="btn btn-primary mt-3">
                                        <i class="fa fa-plus me-1"></i><?php echo e(__('l.Add Courses')); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if(count($successCourses) > 0): ?>
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('l.Successfully Completed Courses')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $__currentLoopData = $successCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card course-card h-100 border-success">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <span><?php echo e($course->code); ?></span>
                                                <span class="badge bg-success"><?php echo e($course->hours); ?>

                                                    <?php echo e(__('l.hours')); ?></span>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <img src="<?php echo e(asset($course->image)); ?>" alt="<?php echo e($course->name); ?>"
                                                            class="rounded" width="60" height="60">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="card-title mb-1"><?php echo e($course->name); ?></h5>
                                                        <p class="card-text text-muted small">
                                                            <?php echo e($course->college->name ?? 'N/A'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <h6><?php echo e(__('l.Final Grade')); ?></h6>
                                                    <div class="progress mt-2" style="height: 10px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: <?php echo e($course->pivot->total); ?>%;"
                                                            aria-valuenow="<?php echo e($course->pivot->total); ?>" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            <?php echo e($course->pivot->total); ?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/registrations/registrations-show.blade.php ENDPATH**/ ?>