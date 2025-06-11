<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Invoice'); ?> #<?php echo e($invoice->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/css/pages/app-invoice.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
                <div class="card invoice-preview-card p-sm-12 p-6">
                    <div class="card-body invoice-preview-header rounded">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column align-items-xl-center align-items-md-start align-items-sm-center align-items-start">
                            <div class="mb-xl-0 mb-6 text-heading">
                                <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                                    <span class="app-brand-logo demo">
                                        <span class="text-primary">
                                            <img src="<?php echo e(asset($settings['logo'] ?? 'assets/images/logo/logo.png')); ?>" alt="Logo" height="40">
                                        </span>
                                    </span>
                                </div>
                                <p class="mb-2"><?php echo e($settings['address'] ?? ''); ?></p>
                                
                                <p class="mb-0"><?php echo e($settings['phone1'] ?? ''); ?>, <?php echo e($settings['email1'] ?? ''); ?></p>
                            </div>
                            <div>
                                <h5 class="mb-6"><?php echo app('translator')->get('l.Invoice'); ?> #<?php echo e($invoice->id); ?></h5>
                                <div class="mb-1 text-heading">
                                    <span><?php echo app('translator')->get('l.Date Issues'); ?>:</span>
                                    <span class="fw-medium"><?php echo e($invoice->created_at->format('Y-m-d')); ?></span>
                                </div>
                                <?php if($invoice->paid_at): ?>
                                <div class="text-heading">
                                    <span><?php echo app('translator')->get('l.Date Paid'); ?>:</span>
                                    <span class="fw-medium"><?php echo e($invoice->paid_at); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="row">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                                <h6><?php echo app('translator')->get('l.Student Information'); ?>:</h6>
                                <p class="mb-1"><?php echo e($invoice->user->fullName()); ?></p>
                                <p class="mb-1"><?php echo e($invoice->user->college->name ?? ''); ?></p>
                                <p class="mb-1"><?php echo e($invoice->user->branch->name ?? ''); ?></p>
                                <p class="mb-1"><?php echo e($invoice->user->phone ?? ''); ?></p>
                                <p class="mb-0"><?php echo e($invoice->user->email); ?></p>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                <h6><?php echo app('translator')->get('l.Invoice Details'); ?>:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4"><?php echo app('translator')->get('l.Total Amount'); ?>:</td>
                                            <td class="fw-medium"><?php echo e(number_format($invoice->amount, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4"><?php echo app('translator')->get('l.Payment Method'); ?>:</td>
                                            <td><?php echo e(ucfirst($invoice->payment_method)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4"><?php echo app('translator')->get('l.Status'); ?>:</td>
                                            <td>
                                                <span class="badge bg-label-<?php echo e($invoice->status == 'paid' ? 'success' :
                                                                ($invoice->status == 'pending' ? 'warning' :
                                                                ($invoice->status == 'failed' ? 'danger' : 'info'))); ?>">
                                                    <?php echo e(__('l.' . ucfirst($invoice->status))); ?>

                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4"><?php echo app('translator')->get('l.Transaction ID'); ?>:</td>
                                            <td><?php echo e($invoice->pid); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border border-bottom-0 border-top-0 rounded">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('l.Course Code'); ?></th>
                                    <th><?php echo app('translator')->get('l.Course Name'); ?></th>
                                    <th><?php echo app('translator')->get('l.Hours'); ?></th>
                                    <th><?php echo app('translator')->get('l.Hour Price'); ?></th>
                                    <th><?php echo app('translator')->get('l.Total'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoice->details['courses'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-nowrap text-heading"><?php echo e($course['code']); ?></td>
                                    <td class="text-nowrap"><?php echo e($course['name']); ?></td>
                                    <td><?php echo e($course['hours']); ?></td>
                                    <td><?php echo e(number_format($invoice->details['hours_info']['hour_price'] ?? 0, 2)); ?></td>
                                    <td><?php echo e(number_format($course['price'], 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0 table-borderless">
                            <tbody>
                                <tr>
                                    <td class="align-top pe-6 ps-0 py-6 text-body">
                                        <p class="mb-1">
                                            <span class="me-2 h6"><?php echo app('translator')->get('l.Status'); ?>:</span>
                                            <span class="badge bg-label-<?php echo e($invoice->status == 'paid' ? 'success' :
                                                                ($invoice->status == 'pending' ? 'warning' :
                                                                ($invoice->status == 'failed' ? 'danger' : 'info'))); ?>">
                                                <?php echo e(__('l.' . ucfirst($invoice->status))); ?>

                                            </span>
                                        </p>
                                        <span><?php echo app('translator')->get('l.Thank you for your registration'); ?></span>
                                    </td>
                                    <td class="px-0 py-6 w-px-100">
                                        <p class="mb-2"><?php echo app('translator')->get('l.Subtotal'); ?>:</p>
                                        <?php $__currentLoopData = $invoice->details['taxes_info'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p class="mb-2"><?php echo e($tax['tax_name']); ?>:</p>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <p class="mb-2 border-bottom pb-2"><?php echo app('translator')->get('l.Total Taxes'); ?>:</p>
                                        <p class="mb-0"><?php echo app('translator')->get('l.Total'); ?>:</p>
                                    </td>
                                    <td class="text-end px-0 py-6 w-px-100 fw-medium text-heading">
                                        <p class="fw-medium mb-2"><?php echo e(number_format($invoice->details['hours_info']['total_hours_price'] ?? 0, 2)); ?></p>
                                        <?php $__currentLoopData = $invoice->details['taxes_info'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p class="fw-medium mb-2"><?php echo e(number_format($tax['tax_amount'], 2)); ?>

                                            <?php if($tax['tax_type'] == 'percentage'): ?> (<?php echo e($tax['tax_rate']); ?>%) <?php endif; ?>
                                        </p>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <p class="fw-medium mb-2 border-bottom pb-2"><?php echo e(number_format($invoice->details['total_tax_amount'] ?? 0, 2)); ?></p>
                                        <p class="fw-medium mb-0"><?php echo e(number_format($invoice->amount, 2)); ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="mt-0 mb-6" />
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-medium text-heading"><?php echo app('translator')->get('l.Note'); ?>:</span>
                                <span><?php echo app('translator')->get('l.This invoice is automatically generated upon course registration. If you have any questions, please contact the student affairs department.'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        <?php if($invoice->status == 'pending'): ?>
                        <a href="javascript:void(0)" class="btn btn-primary d-grid w-100 mb-4">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <?php echo $invoice->link; ?>

                                
                            </span>
                        </a>
                        <?php endif; ?>
                        <button class="btn btn-label-secondary d-grid w-100 mb-4" onclick="window.print()">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-download me-2"></i><?php echo app('translator')->get('l.Download'); ?>
                            </span>
                        </button>
                        <button class="btn btn-label-secondary d-grid w-100" onclick="window.print()">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-printer me-2"></i><?php echo app('translator')->get('l.Print'); ?>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </div>
    <!--/ Content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/invoices/invoices-show.blade.php ENDPATH**/ ?>