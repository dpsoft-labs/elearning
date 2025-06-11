

<?php $__env->startSection('title', __('l.Grades')); ?>

<?php $__env->startSection('css'); ?>
<style>
    .course-card {
        transition: all 0.3s ease;
        height: 100%;
        cursor: pointer;
    }
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .upload-form {
        display: none;
    }
    .course-image {
        height: 150px;
        object-fit: cover;
    }
    .note-box {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    .upload-type {
        margin-bottom: 15px;
    }
    .card-actions {
        position: relative;
        z-index: 10;
    }
    .course-stats {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-left-warning">
                <div class="card-header bg-warning-subtle d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-warning me-2 fa-lg"></i>
                    <h5 class="mb-0 fw-bold text-warning"><?php echo e(__('l.Important Note')); ?></h5>
                </div>
                <div class="card-body">
                    <p class="mb-3"><?php echo e(__('l.Please note that your Excel file must contain only 2 columns:')); ?></p>
                    <div class="bg-light p-3 rounded mb-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <?php echo e(__('l.First column: Student SID (as shown in the template)')); ?>

                            </li>
                            <li class="list-group-item bg-transparent d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <?php echo e(__('l.Second column: Grade value (numeric only)')); ?>

                            </li>
                        </ul>
                    </div>
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-download me-2"></i>
                        <div><?php echo e(__('l.You can download a template for each course that includes all enrolled students.')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 col-xl-3 mb-4">
            <div class="card course-card" onclick="goToCourseDetails('<?php echo e(encrypt($course->id)); ?>')">
                <?php if($course->image): ?>
                <img src="<?php echo e(asset($course->image)); ?>" class="card-img-top course-image" alt="<?php echo e($course->name); ?>">
                <?php else: ?>
                <div class="card-img-top course-image bg-light d-flex justify-content-center align-items-center">
                    <i class="fas fa-book fa-3x text-secondary"></i>
                </div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($course->name); ?></h5>
                    <p class="card-text">
                        <span class="badge bg-primary"><?php echo e($course->code); ?></span>
                        <span class="badge bg-info"><?php echo e($course->hours); ?> <?php echo e(__('l.hours')); ?></span>
                    </p>
                    
                    <div class="course-stats">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted"><?php echo e(__('l.Students')); ?>:</span>
                            <span class="fw-bold"><?php echo e($course->users()->wherePivot('status', 'enrolled')->count()); ?></span>
                        </div>
                        
                        <?php
                            $successCount = $course->users()->wherePivot('status', 'success')->count();
                            $enrolledCount = $course->users()->wherePivot('status', 'enrolled')->count();
                            $successRate = $enrolledCount > 0 ? round(($successCount / $enrolledCount) * 100) : 0;
                        ?>
                        
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($successRate); ?>%" 
                                aria-valuenow="<?php echo e($successRate); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="small text-muted text-end"><?php echo e($successRate); ?>% <?php echo e(__('l.Success Rate')); ?></div>
                    </div>
                    
                    <div class="card-actions d-flex mt-3" onclick="event.stopPropagation();">
                        <button class="btn btn-sm btn-primary me-2 show-upload-btn" data-bs-toggle="modal" 
                                data-bs-target="#uploadModal" data-course-id="<?php echo e(encrypt($course->id)); ?>" 
                                data-course-name="<?php echo e($course->name); ?>">
                            <i class="fas fa-upload"></i> <?php echo e(__('l.Upload Grades')); ?>

                        </button>
                        <a href="<?php echo e(route('dashboard.admins.grades-download-template', ['course_id' => encrypt($course->id)])); ?>" 
                           class="btn btn-sm btn-outline-success">
                            <i class="fas fa-download"></i> <?php echo e(__('l.Template')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="alert alert-info">
                <?php echo e(__('l.No active courses available')); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel"><?php echo e(__('l.Upload Grades')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadGradeForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <h6 id="course-name-display" class="mb-3 fw-bold text-primary"></h6>
                    
                    <input type="hidden" id="course_id" name="course_id">
                    
                    <div class="mb-3">
                        <label for="grade_type" class="form-label"><?php echo e(__('l.Grade Type')); ?></label>
                        <select class="form-select" id="grade_type" name="grade_type" required>
                            <option value=""><?php echo e(__('l.Select Grade Type')); ?></option>
                            <option value="quizzes"><?php echo e(__('l.Quizzes')); ?></option>
                            <option value="midterm"><?php echo e(__('l.Midterm')); ?></option>
                            <option value="attendance"><?php echo e(__('l.Attendance')); ?></option>
                            <option value="final"><?php echo e(__('l.Final')); ?></option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excel_file" class="form-label"><?php echo e(__('l.Excel File')); ?></label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" required
                               accept=".xlsx,.xls,.csv">
                        <div class="form-text"><?php echo e(__('l.Acceptable formats: .xlsx, .xls, .csv')); ?></div>
                    </div>
                    
                    <div class="alert alert-success d-none" id="upload-success"></div>
                    <div class="alert alert-danger d-none" id="upload-error"></div>
                    <div id="errors-list"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('l.Close')); ?></button>
                    <button type="submit" class="btn btn-primary" id="submit-upload">
                        <span class="spinner-border spinner-border-sm d-none" id="loading-spinner" role="status" aria-hidden="true"></span>
                        <?php echo e(__('l.Upload')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // عرض معلومات الكورس في النافذة المنبثقة
    $('.show-upload-btn').on('click', function() {
        var courseId = $(this).data('course-id');
        var courseName = $(this).data('course-name');
        
        $('#course_id').val(courseId);
        $('#course-name-display').text(courseName);
        
        // إعادة تعيين النموذج والرسائل
        $('#uploadGradeForm')[0].reset();
        $('#upload-success, #upload-error').addClass('d-none').text('');
        $('#errors-list').html('');
    });
    
    // معالجة رفع الملف
    $('#uploadGradeForm').on('submit', function(e) {
        e.preventDefault();
        
        // التحقق من الإدخالات
        if (!$('#grade_type').val()) {
            $('#upload-error').removeClass('d-none').text("<?php echo e(__('l.Please select grade type')); ?>");
            return;
        }
        
        if (!$('#excel_file').val()) {
            $('#upload-error').removeClass('d-none').text("<?php echo e(__('l.Please select an Excel file')); ?>");
            return;
        }
        
        // إظهار حالة التحميل
        $('#submit-upload').prop('disabled', true);
        $('#loading-spinner').removeClass('d-none');
        $('#upload-success, #upload-error').addClass('d-none');
        $('#errors-list').html('');
        
        // إنشاء كائن FormData
        var formData = new FormData(this);
        formData.append('_token', '<?php echo e(csrf_token()); ?>');
        
        // إرسال طلب AJAX
        $.ajax({
            url: '<?php echo e(route('dashboard.admins.grades-upload')); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // إخفاء حالة التحميل
                $('#submit-upload').prop('disabled', false);
                $('#loading-spinner').addClass('d-none');
                
                if (response.success) {
                    $('#upload-success').removeClass('d-none').text(response.success);
                    
                    // عرض الأخطاء إن وجدت
                    if (response.errors && response.errors.length > 0) {
                        var errorsHtml = '<div class="mt-3"><h6 class="text-warning"><?php echo e(__('l.Warnings')); ?>:</h6><ul class="list-group">';
                        
                        for (var i = 0; i < response.errors.length; i++) {
                            errorsHtml += '<li class="list-group-item list-group-item-warning small">' + response.errors[i] + '</li>';
                        }
                        
                        errorsHtml += '</ul></div>';
                        $('#errors-list').html(errorsHtml);
                    }
                    
                    // إعادة تعيين النموذج بعد ثواني
                    setTimeout(function() {
                        $('#uploadGradeForm')[0].reset();
                    }, 2000);
                } else if (response.error) {
                    $('#upload-error').removeClass('d-none').text(response.error);
                }
            },
            error: function(xhr) {
                // إخفاء حالة التحميل وعرض خطأ
                $('#submit-upload').prop('disabled', false);
                $('#loading-spinner').addClass('d-none');
                $('#upload-error').removeClass('d-none').text(xhr.responseJSON ? xhr.responseJSON.error : "<?php echo e(__('l.An error occurred during upload')); ?>");
            }
        });
    });
});

// الانتقال إلى صفحة تفاصيل الكورس
function goToCourseDetails(courseId) {
    window.location.href = "<?php echo e(route('dashboard.admins.grades-show')); ?>?course_id=" + courseId;
}
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/grades/grades-list.blade.php ENDPATH**/ ?>