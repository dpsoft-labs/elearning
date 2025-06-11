<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Course Grades')); ?>: <?php echo e($course->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .course-header {
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .course-image {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
    }
    .stat-box {
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        height: 100%;
    }
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #666;
    }
    .grade-cell {
        min-width: 70px;
        text-align: center;
    }
    .success-row {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }
    .fail-row {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- معلومات الكورس -->
            <div class="col-12">
                <div class="card course-header bg-light shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php if($course->image): ?>
                                    <img src="<?php echo e(asset($course->image)); ?>" class="course-image" alt="<?php echo e($course->name); ?>">
                                <?php else: ?>
                                    <div class="course-image bg-primary d-flex justify-content-center align-items-center">
                                        <i class="fas fa-book fa-2x text-white"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <h3 class="mb-1"><?php echo e($course->name); ?></h3>
                                <div class="d-flex mb-2">
                                    <span class="badge bg-primary me-2"><?php echo e($course->code); ?></span>
                                    <span class="badge bg-info me-2"><?php echo e($course->hours); ?> <?php echo e(__('l.hours')); ?></span>
                                    <span class="badge bg-secondary"><?php echo e($course->college->name ?? ''); ?></span>
                                </div>
                                <p class="mb-0">
                                    <a href="<?php echo e(route('dashboard.admins.grades')); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-arrow-left"></i> <?php echo e(__('l.Back to Courses')); ?>

                                    </a>
                                    <a href="<?php echo e(route('dashboard.admins.grades-download-template', ['course_id' => encrypt($course->id)])); ?>"
                                       class="btn btn-sm btn-outline-success ms-2">
                                        <i class="fas fa-download"></i> <?php echo e(__('l.Download Template')); ?>

                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إحصائيات الكورس -->
            <div class="col-12">
                <div class="row">
                    <?php
                        $totalStudents = count($students);
                        $passedStudents = $students->where('pivot.status', 'success')->count();
                        $failedStudents = $students->where('pivot.status', 'fail')->count();
                        $passRate = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100) : 0;

                        $avgQuizzes = $students->avg('pivot.quizzes') ?: 0;
                        $avgMidterm = $students->avg('pivot.midterm') ?: 0;
                        $avgAttendance = $students->avg('pivot.attendance') ?: 0;
                        $avgFinal = $students->avg('pivot.final') ?: 0;
                        $avgTotal = $students->avg('pivot.total') ?: 0;
                    ?>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-primary bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-value"><?php echo e($totalStudents); ?></div>
                                <div class="stat-label"><?php echo e(__('l.Total Students')); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-success bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-value"><?php echo e($passedStudents); ?></div>
                                <div class="stat-label"><?php echo e(__('l.Passed Students')); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-danger bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stat-value"><?php echo e($failedStudents); ?></div>
                                <div class="stat-label"><?php echo e(__('l.Failed Students')); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card stat-box bg-info bg-opacity-10 border-0">
                            <div class="card-body">
                                <div class="stat-icon text-info">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stat-value"><?php echo e($enrolledStudents); ?></div>
                                <div class="stat-label"><?php echo e(__('l.Enrolled Students')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- متوسطات الدرجات -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light mb-5">
                        <h5 class="mb-0"><?php echo e(__('l.Average Grades')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($avgQuizzes); ?>%;"
                                         aria-valuenow="<?php echo e($avgQuizzes); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo e(round($avgQuizzes, 1)); ?>

                                    </div>
                                </div>
                                <p class="text-center small mt-1"><?php echo e(__('l.Quizzes')); ?></p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($avgMidterm); ?>%;"
                                         aria-valuenow="<?php echo e($avgMidterm); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo e(round($avgMidterm, 1)); ?>

                                    </div>
                                </div>
                                <p class="text-center small mt-1"><?php echo e(__('l.Midterm')); ?></p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($avgAttendance); ?>%;"
                                         aria-valuenow="<?php echo e($avgAttendance); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo e(round($avgAttendance, 1)); ?>

                                    </div>
                                </div>
                                <p class="text-center small mt-1"><?php echo e(__('l.Attendance')); ?></p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo e($avgFinal); ?>%;"
                                         aria-valuenow="<?php echo e($avgFinal); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo e(round($avgFinal, 1)); ?>

                                    </div>
                                </div>
                                <p class="text-center small mt-1"><?php echo e(__('l.Final')); ?></p>
                            </div>
                            <div class="col-md">
                                <div class="progress mb-1" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($avgTotal); ?>%;"
                                         aria-valuenow="<?php echo e($avgTotal); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo e(round($avgTotal, 1)); ?>

                                    </div>
                                </div>
                                <p class="text-center small mt-1"><?php echo e(__('l.Total')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- نسبة النجاح -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-light mb-5">
                        <h5 class="mb-0"><?php echo e(__('l.Success Rate')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="progress" style="height: 30px;">
                            <?php
                                $passRateStyle = "width: {$passRate}%";
                                $failRateStyle = "width: " . (100 - $passRate) . "%";
                            ?>
                            <div class="progress-bar bg-success" style="<?php echo e($passRateStyle); ?>" role="progressbar" aria-valuenow="<?php echo e($passRate); ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo e($passRate); ?>% <?php echo e(__('l.Passed')); ?>

                            </div>
                            <div class="progress-bar bg-danger" style="<?php echo e($failRateStyle); ?>" role="progressbar" aria-valuenow="<?php echo e(100 - $passRate); ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo e(100 - $passRate); ?>% <?php echo e(__('l.Failed')); ?>

                            </div>
                        </div>
                        <div class="text-muted small mt-2 text-center">
                            <?php echo e(__('l.Note: Success rate is calculated only for examined students (excluding enrolled students without final scores).')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول الطلاب ودرجاتهم -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e(__('l.Students Grades')); ?></h5>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table table-striped" id="students-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(__('l.SID')); ?></th>
                                    <th><?php echo e(__('l.Name')); ?></th>
                                    <th class="grade-cell"><?php echo e(__('l.Quizzes')); ?></th>
                                    <th class="grade-cell"><?php echo e(__('l.Midterm')); ?></th>
                                    <th class="grade-cell"><?php echo e(__('l.Attendance')); ?></th>
                                    <th class="grade-cell"><?php echo e(__('l.Final')); ?></th>
                                    <th class="grade-cell"><?php echo e(__('l.Total')); ?></th>
                                    <th class="grade-cell"><?php echo e(__('l.Status')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // تحديد لون وفئة الصف بناءً على الحالة
                                    $status = $student->pivot->status;
                                    if ($status == 'success') {
                                        $rowClass = 'success-row';
                                        $badgeClass = 'bg-success';
                                        $statusText = __('l.Passed');
                                    } elseif ($status == 'fail') {
                                        $rowClass = 'fail-row';
                                        $badgeClass = 'bg-danger';
                                        $statusText = __('l.Failed');
                                    } else { // الحالة هي 'enrolled' أو غيرها
                                        $rowClass = '';
                                        $badgeClass = 'bg-info';
                                        $statusText = __('l.Enrolled');
                                    }

                                    // التأكد من الحصول على القيم الصحيحة للدرجات
                                    $quizzes = $student->pivot->quizzes;
                                    $midterm = $student->pivot->midterm;
                                    $attendance = $student->pivot->attendance;
                                    $final = $student->pivot->final;
                                    $total = $student->pivot->total;
                                ?>
                                <tr class="<?php echo e($rowClass); ?>">
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($student->getSidAttribute()); ?></td>
                                    <td><?php echo e($student->firstname); ?> <?php echo e($student->lastname); ?></td>
                                    <td class="grade-cell"><?php echo e($quizzes); ?></td>
                                    <td class="grade-cell"><?php echo e($midterm); ?></td>
                                    <td class="grade-cell"><?php echo e($attendance); ?></td>
                                    <td class="grade-cell"><?php echo e($final); ?></td>
                                    <td class="grade-cell fw-bold"><?php echo e($total); ?></td>
                                    <td class="grade-cell">
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($statusText); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // إعداد الجدول مع البحث والترتيب والصفحات
    let table = $('#students-table').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "<?php echo e(__('l.All')); ?>"]
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex align-items-center"f>>rtip',
        language: {
            search: "<?php echo e(__('l.Search')); ?>:",
            lengthMenu: "<?php echo e(__('l.Show')); ?> _MENU_ <?php echo e(__('l.entries')); ?>",
            paginate: {
                next: "<?php echo e(__('l.Next')); ?>",
                previous: "<?php echo e(__('l.Previous')); ?>"
            },
            info: "<?php echo e(__('l.Showing')); ?> _START_ <?php echo e(__('l.to')); ?> _END_ <?php echo e(__('l.of')); ?> _TOTAL_ <?php echo e(__('l.entries')); ?>",
            infoEmpty: "<?php echo e(__('l.Showing')); ?> 0 <?php echo e(__('l.To')); ?> 0 <?php echo e(__('l.Of')); ?> 0 <?php echo e(__('l.entries')); ?>",
            infoFiltered: "<?php echo e(__('l.Showing')); ?> 1 <?php echo e(__('l.Of')); ?> 1 <?php echo e(__('l.entries')); ?>",
            zeroRecords: "<?php echo e(__('l.No matching records found')); ?>",
            loadingRecords: "<?php echo e(__('l.Loading...')); ?>",
            processing: "<?php echo e(__('l.Processing...')); ?>",
            emptyTable: "<?php echo e(__('l.No data available in table')); ?>",
        },
        // إضافة ميزة الترتيب الافتراضي
        order: [[7, 'desc']], // ترتيب حسب العمود الثامن (إجمالي الدرجات) تنازليًا
        // تمكين التصدير
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });

    // إضافة لون خلفية مختلف للصفوف اعتمادًا على حالة النجاح/الرسوب
    $('#students-table tbody tr').each(function() {
        if ($(this).hasClass('success-row')) {
            $(this).find('td').css('background-color', 'rgba(40, 167, 69, 0.05)');
        } else if ($(this).hasClass('fail-row')) {
            $(this).find('td').css('background-color', 'rgba(220, 53, 69, 0.05)');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/grades/grades-show.blade.php ENDPATH**/ ?>