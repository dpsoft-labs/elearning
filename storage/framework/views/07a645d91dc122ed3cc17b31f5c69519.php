<?php $__env->startSection('title', $seoPage->title); ?>
<?php $__env->startSection('description', $seoPage->description); ?>
<?php $__env->startSection('keywords', $seoPage->keywords); ?>
<?php $__env->startSection('og_title', $seoPage->og_title); ?>
<?php $__env->startSection('og_description', $seoPage->og_description); ?>
<?php $__env->startSection('og_image', asset($seoPage->og_image)); ?>
<?php $__env->startSection('structured_data'); ?>
    <script type="application/ld+json">
        <?php echo $seoPage->structured_data; ?>

    </script>
<?php $__env->stopSection(); ?>

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
    .form-label {
        font-weight: 500;
    }
    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
    }
    .required-field::after {
        content: "*";
        color: red;
        margin-left: 4px;
    }
    .preview-image {
        max-width: 200px;
        max-height: 200px;
        margin-top: 10px;
        border-radius: 8px;
        display: none;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="admission-section mt-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="admission-form">
                    <h2 class="text-center mb-4"><?php echo app('translator')->get('front.admission_form'); ?></h2>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?> <a href="<?php echo e(route('admission.show')); ?>?id=<?php echo e(session('admission')->id); ?>"><?php echo app('translator')->get('front.admission_number'); ?> #<?php echo e(session('admission')->id); ?> <?php echo app('translator')->get('front.view_admission'); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <ul class="nav nav-tabs" id="admissionTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="true"><?php echo app('translator')->get('front.search_admission'); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="create-tab" data-bs-toggle="tab" data-bs-target="#create" type="button" role="tab" aria-controls="create" aria-selected="false"><?php echo app('translator')->get('front.create_admission'); ?></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="admissionTabsContent">
                        <!-- فورم البحث -->
                        <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
                            <div class="search-form">
                                <form action="<?php echo e(route('admission.show')); ?>" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('front.admission_number'); ?></label>
                                                <input type="text" name="id" class="form-control" placeholder="<?php echo app('translator')->get('front.enter_admission_number'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary w-100"><?php echo app('translator')->get('front.search'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- فورم إنشاء طلب جديد -->
                        <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                            <form action="<?php echo e(route('admission.store')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <!-- المعلومات الشخصية -->
                                <div class="form-section">
                                    <h3 class="section-title"><?php echo app('translator')->get('front.personal_information'); ?></h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.english_name'); ?></label>
                                            <input type="text" name="en_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.arabic_name'); ?></label>
                                            <input type="text" name="ar_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.email'); ?></label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.phone'); ?></label>
                                            <input type="tel" name="phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.address'); ?></label>
                                            <input type="text" name="address" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.city'); ?></label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.country'); ?></label>
                                            <select name="country" class="form-control form-select select2" required>
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.gender'); ?></label>
                                            <select name="gender" class="form-control form-select select2" required>
                                                <option value=""><?php echo app('translator')->get('front.choose_gender'); ?></option>
                                                <option value="male"><?php echo app('translator')->get('front.male'); ?></option>
                                                <option value="female"><?php echo app('translator')->get('front.female'); ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.date_of_birth'); ?></label>
                                            <input type="date" name="date_of_birth" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.nationality'); ?></label>
                                            <input type="text" name="nationality" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.national_id'); ?></label>
                                            <input type="text" name="national_id" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- معلومات التعليم -->
                                <div class="form-section">
                                    <h3 class="section-title"><?php echo app('translator')->get('front.education_information'); ?></h3>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.school_name'); ?></label>
                                            <input type="text" name="school_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.certificate_type'); ?></label>
                                            <select name="certificate_type" class="form-control form-select select2" required>
                                                <option value=""><?php echo app('translator')->get('front.choose_certificate_type'); ?></option>
                                                <option value="azhary"><?php echo app('translator')->get('front.azhary'); ?></option>
                                                <option value="languages"><?php echo app('translator')->get('front.languages'); ?></option>
                                                <option value="general"><?php echo app('translator')->get('front.general'); ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.graduation_year'); ?></label>
                                            <input type="text" name="graduation_year" class="form-control" maxlength="4" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.grade_percentage'); ?></label>
                                            <input type="number" name="grade_percentage" class="form-control" min="0" max="100" step="0.01" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.grade_evaluation'); ?></label>
                                            <input type="text" name="grade_evaluation" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.academic_section'); ?></label>
                                            <select name="academic_section" class="form-control form-select select2" required>
                                                <option value=""><?php echo app('translator')->get('front.choose_academic_section'); ?></option>
                                                <option value="science"><?php echo app('translator')->get('front.science'); ?></option>
                                                <option value="math"><?php echo app('translator')->get('front.math'); ?></option>
                                                <option value="arts"><?php echo app('translator')->get('front.arts'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- معلومات الوالدين -->
                                <div class="form-section">
                                    <h3 class="section-title"><?php echo app('translator')->get('front.parent_information'); ?></h3>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.parent_name'); ?></label>
                                            <input type="text" name="parent_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.parent_phone'); ?></label>
                                            <input type="tel" name="parent_phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.parent_job'); ?></label>
                                            <input type="text" name="parent_job" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- المرفقات -->
                                <div class="form-section">
                                    <h3 class="section-title"><?php echo app('translator')->get('front.attachments'); ?></h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.student_photo'); ?></label>
                                            <input type="file" name="student_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'student_preview')">
                                            <img id="student_preview" class="preview-image">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.certificate_photo'); ?></label>
                                            <input type="file" name="certificate_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'certificate_preview')">
                                            <img id="certificate_preview" class="preview-image">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.national_id_photo'); ?></label>
                                            <input type="file" name="national_id_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'national_id_preview')">
                                            <img id="national_id_preview" class="preview-image">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field"><?php echo app('translator')->get('front.parent_national_id_photo'); ?></label>
                                            <input type="file" name="parent_national_id_photo" class="form-control" accept="image/*" required onchange="previewImage(this, 'parent_national_id_preview')">
                                            <img id="parent_national_id_preview" class="preview-image">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('front.submit_request'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.front.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/front/admission.blade.php ENDPATH**/ ?>