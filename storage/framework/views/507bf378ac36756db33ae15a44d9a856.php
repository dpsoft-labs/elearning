<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Available Courses')); ?> - <?php echo e($student->firstname); ?> <?php echo e($student->lastlname); ?>

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

        .requirements-list {
            padding-left: 20px;
            margin-top: 5px;
            font-size: 0.85rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title"><?php echo e(__('l.Available Courses')); ?></h5>
                        <h6 class="text-muted"><?php echo e($student->firstname); ?> <?php echo e($student->lastlname); ?> (<?php echo e($student->sid); ?>)</h6>
                    </div>
                    <a href="<?php echo e(route('dashboard.users.registrations', ['student_id' => encrypt($student->id)])); ?>"
                        class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i><?php echo e(__('l.Back to Registration')); ?>

                    </a>
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
                                <img src="<?php echo e(asset($student->photo)); ?>" alt="<?php echo e($student->firstname); ?>"
                                    class="rounded-circle" width="60" height="60">
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
                            <h6><?php echo e(__('l.Total Success Hours')); ?></h6>
                            <p><?php echo e($student->totalSuccessHours()); ?> <?php echo e(__('l.hours')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo e(__('l.Available Courses')); ?></h5>
                        <button id="registerSelected" class="btn btn-primary d-none">
                            <i class="fa fa-plus me-1"></i><?php echo e(__('l.Register Selected')); ?>

                        </button>
                    </div>
                    <div class="card-body">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($error); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(count($availableCourses) > 0): ?>
                            <form id="register-form" action="<?php echo e(route('dashboard.users.registrations-store')); ?>"
                                method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">

                                <div class="row">
                                    <?php $__currentLoopData = $availableCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card course-card h-100">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center bg-light">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="course_ids[]"
                                                            class="form-check-input course-checkbox"
                                                            value="<?php echo e($course->id); ?>">
                                                        <label class="form-check-label"><?php echo e($course->code); ?></label>
                                                    </div>
                                                    <span class="badge bg-primary"><?php echo e($course->hours); ?>

                                                        <?php echo e(__('l.hours')); ?></span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex mb-3">
                                                        <div class="flex-shrink-0 me-3">
                                                            <img src="<?php echo e(asset($course->image)); ?>"
                                                                alt="<?php echo e($course->name); ?>" class="rounded" width="60"
                                                                height="60">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="card-title mb-1"><?php echo e($course->name); ?></h5>
                                                            <p class="card-text text-muted small">
                                                                <?php echo e($course->college->name ?? 'N/A'); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6 class="mb-1"><?php echo e(__('l.Required Hours')); ?>:
                                                            <?php echo e($course->required_hours); ?></h6>
                                                        <?php if($course->required1 || $course->required2 || $course->required3): ?>
                                                            <h6 class="mb-0"><?php echo e(__('l.Prerequisites')); ?>:</h6>
                                                            <ul class="requirements-list">
                                                                <?php if($course->required1): ?>
                                                                    <li><?php echo e($course->required1); ?></li>
                                                                <?php endif; ?>
                                                                <?php if($course->required2): ?>
                                                                    <li><?php echo e($course->required2); ?></li>
                                                                <?php endif; ?>
                                                                <?php if($course->required3): ?>
                                                                    <li><?php echo e($course->required3); ?></li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                                <h5><?php echo e(__('l.No available courses for registration')); ?></h5>
                                <p class="text-muted"><?php echo e(__('l.There are no courses matching the requirements')); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            // حدث تغيير الاختيار
            $('.course-checkbox').on('change', function() {
                updateRegisterButton();
            });

            function updateRegisterButton() {
                let checkedCount = $('.course-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#registerSelected').removeClass('d-none');
                } else {
                    $('#registerSelected').addClass('d-none');
                }
            }

            // تسجيل المحدد
            $('#registerSelected').on('click', function() {
                if ($('.course-checkbox:checked').length > 0) {
                    Swal.fire({
                        title: "<?php echo e(__('l.Register Courses')); ?>",
                        text: "<?php echo e(__('l.Are you sure you want to register the selected courses?')); ?>",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: "<?php echo e(__('l.Yes, register them!')); ?>",
                        cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#register-form').submit();
                        }
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/registrations/available-courses.blade.php ENDPATH**/ ?>