<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Admission Details'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo app('translator')->get('l.Admission Details'); ?></h5>
                        <a href="<?php echo e(route('dashboard.admins.admissions')); ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> <?php echo app('translator')->get('l.Back'); ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- المعلومات الشخصية -->
                            <div class="col-md-6">
                                <h6 class="mb-3"><?php echo app('translator')->get('l.Personal Information'); ?></h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Name (Arabic)'); ?></th>
                                        <td><?php echo e($admission->ar_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Name (English)'); ?></th>
                                        <td><?php echo e($admission->en_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Email'); ?></th>
                                        <td><?php echo e($admission->email); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Phone'); ?></th>
                                        <td><?php echo e($admission->phone); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Address'); ?></th>
                                        <td><?php echo e($admission->address); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.City'); ?></th>
                                        <td><?php echo e($admission->city); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Country'); ?></th>
                                        <td><?php echo e($admission->country); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Gender'); ?></th>
                                        <td><?php echo e($admission->gender); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Date of Birth'); ?></th>
                                        <td><?php echo e($admission->date_of_birth); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Nationality'); ?></th>
                                        <td><?php echo e($admission->nationality); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.National ID'); ?></th>
                                        <td><?php echo e($admission->national_id); ?></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- المعلومات التعليمية -->
                            <div class="col-md-6">
                                <h6 class="mb-3"><?php echo app('translator')->get('l.Education Information'); ?></h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Certificate Type'); ?></th>
                                        <td><?php echo e($admission->certificate_type); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.School Name'); ?></th>
                                        <td><?php echo e($admission->school_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Graduation Year'); ?></th>
                                        <td><?php echo e($admission->graduation_year); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Grade Percentage'); ?></th>
                                        <td><?php echo e($admission->grade_percentage); ?>%</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Grade Evaluation'); ?></th>
                                        <td><?php echo e($admission->grade_evaluation); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Academic Section'); ?></th>
                                        <td><?php echo e($admission->academic_section); ?></td>
                                    </tr>
                                </table>

                                <h6 class="mb-3 mt-4"><?php echo app('translator')->get('l.Parent Information'); ?></h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Parent Name'); ?></th>
                                        <td><?php echo e($admission->parent_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Parent Phone'); ?></th>
                                        <td><?php echo e($admission->parent_phone); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Parent Job'); ?></th>
                                        <td><?php echo e($admission->parent_job); ?></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- المستندات -->
                            <div class="col-12 mt-4">
                                <h6 class="mb-3"><?php echo app('translator')->get('l.Documents'); ?></h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="<?php echo e(asset($admission->student_photo)); ?>" class="card-img-top" alt="Student Photo">
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo app('translator')->get('l.Student Photo'); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="<?php echo e(asset($admission->certificate_photo)); ?>" class="card-img-top" alt="Certificate">
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo app('translator')->get('l.Certificate'); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="<?php echo e(asset($admission->national_id_photo)); ?>" class="card-img-top" alt="National ID">
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo app('translator')->get('l.National ID'); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="<?php echo e(asset($admission->parent_national_id_photo)); ?>" class="card-img-top" alt="Parent National ID">
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo app('translator')->get('l.Parent National ID'); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تغيير الحالة -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit admissions')): ?>
                                <div class="col-12 mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><?php echo app('translator')->get('l.Change Status'); ?></h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo e(route('dashboard.admins.admissions-update')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e(encrypt($admission->id)); ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label><?php echo app('translator')->get('l.Status'); ?></label>
                                                            <select name="status" class="form-select">
                                                                <option value="pending" <?php echo e($admission->status == 'pending' ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Pending'); ?></option>
                                                                <option value="accepted" <?php echo e($admission->status == 'accepted' ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Accepted'); ?></option>
                                                                <option value="rejected" <?php echo e($admission->status == 'rejected' ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Rejected'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fa fa-save me-1"></i> <?php echo app('translator')->get('l.Update Status'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/admissions/admissions-show.blade.php ENDPATH**/ ?>