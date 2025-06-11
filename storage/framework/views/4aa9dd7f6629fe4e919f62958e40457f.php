<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Invoices'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/themes/default/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(asset('assets/themes/default/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"><?php echo app('translator')->get('l.Invoices'); ?> /</span> <?php echo app('translator')->get('l.Invoices List'); ?>
        </h4>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="invoice-list-table table border-top">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo app('translator')->get('l.Student'); ?></th>
                            <th><?php echo app('translator')->get('l.Amount'); ?></th>
                            <th><?php echo app('translator')->get('l.Payment Method'); ?></th>
                            <th><?php echo app('translator')->get('l.Status'); ?></th>
                            <th><?php echo app('translator')->get('l.Created Date'); ?></th>
                            <th><?php echo app('translator')->get('l.Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a
                                        href="<?php echo e(route('dashboard.admins.invoices-show', ['invoice_id' => encrypt($invoice->id)])); ?>">
                                        #<?php echo e($invoice->id); ?>

                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2">
                                                <span
                                                    class="avatar-initial rounded-circle
                                                    bg-label-<?php echo e($invoice->status == 'paid'
                                                        ? 'success'
                                                        : ($invoice->status == 'pending'
                                                            ? 'warning'
                                                            : ($invoice->status == 'failed'
                                                                ? 'danger'
                                                                : 'info'))); ?>">
                                                    <?php echo e(substr($invoice->user->firstname ?? 'U', 0, 1)); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="<?php echo e(route('dashboard.admins.students-show', ['id' => encrypt($invoice->user_id)])); ?>"
                                                class="text-body fw-medium">
                                                <?php echo e($invoice->user->firstname); ?> <?php echo e($invoice->user->lastname); ?> <small
                                                    class="text-muted"
                                                    style="font-size: 0.6rem; color: #e1d00f;">(<?php echo e($invoice->user->sid ?? ''); ?>)</small>
                                            </a>
                                            <small class="text-muted"><?php echo e($invoice->user->email); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e(number_format($invoice->amount, 2)); ?></td>
                                <td><?php echo e($invoice->payment_method); ?></td>
                                <td>
                                    <span
                                        class="badge bg-label-<?php echo e($invoice->status == 'paid'
                                            ? 'success'
                                            : ($invoice->status == 'pending'
                                                ? 'warning'
                                                : ($invoice->status == 'failed'
                                                    ? 'danger'
                                                    : 'info'))); ?>">
                                        <?php echo e(__('l.' . ucfirst($invoice->status))); ?>

                                    </span>
                                </td>
                                <td><?php echo e($invoice->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="<?php echo e(route('dashboard.admins.invoices-show', ['invoice_id' => encrypt($invoice->id)])); ?>"
                                            class="btn btn-sm btn-icon">
                                            <i class="bx bx-show mx-1"></i>
                                        </a>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete invoices')): ?>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon delete-invoice" data-invoice-id="<?php echo e(encrypt($invoice->id)); ?>">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('assets/themes/default/vendor/libs/datatables-bs5/datatables-bootstrap5.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            $('.invoice-list-table').DataTable({
                responsive: true,
                order: [
                    [0, 'desc']
                ],
                language: {
                    search: '<?php echo app('translator')->get('l.Search'); ?>',
                    lengthMenu: '<?php echo app('translator')->get('l.Show _MENU_ entries'); ?>',
                    paginate: {
                        first: '<?php echo app('translator')->get('l.First'); ?>',
                        last: '<?php echo app('translator')->get('l.Last'); ?>',
                        next: '<?php echo app('translator')->get('l.Next'); ?>',
                        previous: '<?php echo app('translator')->get('l.Previous'); ?>'
                    }
                }
            });
        });
        // تأكيد حذف تسجيل واحد
        $('.delete-invoice').on('click', function(e) {
            e.preventDefault();
            let invoice_id = $(this).data('invoice-id');
            Swal.fire({
                title: "<?php echo e(__('l.Are you sure?')); ?>",
                text: "<?php echo e(__('l.This invoice will be deleted!')); ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "<?php echo e(__('l.Yes, delete it!')); ?>",
                cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo e(route('dashboard.admins.invoices-delete', ['invoice_id' => ':invoice_id'])); ?>".replace(':invoice_id', invoice_id);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/invoices/invoices-list.blade.php ENDPATH**/ ?>