<?php $__env->startSection('title', __('front.admission_form') . ' #' . $admission->id); ?>
<?php $__env->startSection('description', __('front.admission_form') . ' #' . $admission->id); ?>
<?php $__env->startSection('keywords', __('front.admission_form') . ' #' . $admission->id); ?>
<?php $__env->startSection('og_title', __('front.admission_form') . ' #' . $admission->id); ?>
<?php $__env->startSection('og_description', __('front.admission_form') . ' #' . $admission->id); ?>
<?php $__env->startSection('og_image', asset($admission->student_photo)); ?>
<?php $__env->startSection('structured_data'); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .admission-form {
        border-radius: 15px;
        padding: 30px;
        margin: 30px 0;
    }
    .form-section {
        padding: 20px 0;
        margin-bottom: 20px;
    }
    .form-section:last-child {
        border-bottom: none;
    }
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .info-label {
        font-weight: 500;
    }
    .info-value {
        font-weight: 600;
    }
    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 500;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-approved {
        background-color: #d4edda;
        color: #155724;
    }
    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    .document-preview {
        max-width: 200px;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="admission-section mt-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="admission-form">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="<?php echo e(route('admission')); ?>" class="btn btn-primary"><- <?php echo app('translator')->get('l.Back'); ?></a>
                        <h2><?php echo app('translator')->get('front.admission_form'); ?> #<?php echo e($admission->id); ?></h2>
                        <span class="status-badge status-<?php echo e($admission->status); ?>">
                            <?php echo app('translator')->get('front.status_' . $admission->status); ?>
                        </span>
                    </div>

                    <!-- المعلومات الشخصية -->
                    <div class="form-section">
                        <h3 class="section-title"><?php echo app('translator')->get('front.personal_information'); ?></h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.english_name'); ?></div>
                                <div class="info-value"><?php echo e($admission->en_name); ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.arabic_name'); ?></div>
                                <div class="info-value"><?php echo e($admission->ar_name); ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.email'); ?></div>
                                <div class="info-value"><?php echo e($admission->email); ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.phone'); ?></div>
                                <div class="info-value"><?php echo e($admission->phone); ?></div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.address'); ?></div>
                                <div class="info-value"><?php echo e($admission->address); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.city'); ?></div>
                                <div class="info-value"><?php echo e($admission->city); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.country'); ?></div>
                                <div class="info-value"><?php echo e($admission->country); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.gender'); ?></div>
                                <div class="info-value"><?php echo app('translator')->get('front.' . $admission->gender); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.date_of_birth'); ?></div>
                                <div class="info-value"><?php echo e($admission->date_of_birth); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.nationality'); ?></div>
                                <div class="info-value"><?php echo e($admission->nationality); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.national_id'); ?></div>
                                <div class="info-value"><?php echo e($admission->national_id); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات التعليم -->
                    <div class="form-section">
                        <h3 class="section-title"><?php echo app('translator')->get('front.education_information'); ?></h3>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.school_name'); ?></div>
                                <div class="info-value"><?php echo e($admission->school_name); ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.certificate_type'); ?></div>
                                <div class="info-value"><?php echo app('translator')->get('front.' . $admission->certificate_type); ?></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.graduation_year'); ?></div>
                                <div class="info-value"><?php echo e($admission->graduation_year); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.grade_percentage'); ?></div>
                                <div class="info-value"><?php echo e($admission->grade_percentage); ?>%</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.grade_evaluation'); ?></div>
                                <div class="info-value"><?php echo e($admission->grade_evaluation); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.academic_section'); ?></div>
                                <div class="info-value"><?php echo app('translator')->get('front.' . $admission->academic_section); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات الوالدين -->
                    <div class="form-section">
                        <h3 class="section-title"><?php echo app('translator')->get('front.parent_information'); ?></h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.parent_name'); ?></div>
                                <div class="info-value"><?php echo e($admission->parent_name); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.parent_phone'); ?></div>
                                <div class="info-value"><?php echo e($admission->parent_phone); ?></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.parent_job'); ?></div>
                                <div class="info-value"><?php echo e($admission->parent_job); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- المرفقات -->
                    <div class="form-section">
                        <h3 class="section-title"><?php echo app('translator')->get('front.attachments'); ?></h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.student_photo'); ?></div>
                                <img src="<?php echo e(asset($admission->student_photo)); ?>" class="document-preview">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.certificate_photo'); ?></div>
                                <img src="<?php echo e(asset($admission->certificate_photo)); ?>" class="document-preview">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.national_id_photo'); ?></div>
                                <img src="<?php echo e(asset($admission->national_id_photo)); ?>" class="document-preview">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label"><?php echo app('translator')->get('front.parent_national_id_photo'); ?></div>
                                <img src="<?php echo e(asset($admission->parent_national_id_photo)); ?>" class="document-preview">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.front.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/front/admission-show.blade.php ENDPATH**/ ?>