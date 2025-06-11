<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Admissions List'); ?>
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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo app('translator')->get('l.Admissions List'); ?></h5>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete admissions')): ?>
                    <button id="deleteSelected" class="btn btn-danger d-none">
                        <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete Selected'); ?>
                    </button>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo app('translator')->get('l.Name'); ?></th>
                                <th><?php echo app('translator')->get('l.Email'); ?></th>
                                <th><?php echo app('translator')->get('l.Phone'); ?></th>
                                <th><?php echo app('translator')->get('l.Certificate Type'); ?></th>
                                <th><?php echo app('translator')->get('l.Status'); ?></th>
                                <th><?php echo app('translator')->get('l.Created At'); ?></th>
                                <th><?php echo app('translator')->get('l.Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $admissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($admission->id); ?>">
                                    </td>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($admission->ar_name); ?></td>
                                    <td><?php echo e($admission->email); ?></td>
                                    <td><?php echo e($admission->phone); ?></td>
                                    <td><?php echo e($admission->certificate_type); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($admission->status == 'pending' ? 'warning' : ($admission->status == 'accepted' ? 'success' : 'danger')); ?>">
                                            <?php echo app('translator')->get('l.' . ucfirst($admission->status)); ?>
                                        </span>
                                    </td>
                                    <td><?php echo e($admission->created_at->format('Y-m-d')); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(route('dashboard.admins.admissions-show', ['id' => encrypt($admission->id)])); ?>"
                                               class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete admissions')): ?>
                                                <button class="btn btn-sm btn-danger delete-admission" data-id="<?php echo e(encrypt($admission->id)); ?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            // حدث تحديد/إلغاء تحديد الكل
            $('#select-all').on('change', function() {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
                updateDeleteButton();
            });

            // تحديث حالة زر الحذف عند تغيير أي صندوق تحديد
            $(document).on('change', '.row-checkbox', function() {
                updateDeleteButton();
                let allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#select-all').prop('checked', allChecked);
            });

            function updateDeleteButton() {
                let checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#deleteSelected').removeClass('d-none');
                } else {
                    $('#deleteSelected').addClass('d-none');
                }
            }

            // حذف الطلبات المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                        text: '<?php echo app('translator')->get('l.Selected admissions will be deleted!'); ?>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete them!'); ?>',
                        cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?php echo e(route('dashboard.admins.admissions-deleteSelected')); ?>?ids=' + selectedIds.join(',');
                        }
                    });
                }
            });

            // حذف طلب واحد
            $(document).on('click', '.delete-admission', function() {
                let admissionId = $(this).data('id');

                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: '<?php echo app('translator')->get('l.You will delete this admission forever!'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete it!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?php echo e(route('dashboard.admins.admissions-delete')); ?>?id=' + admissionId;
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/admissions/admissions-list.blade.php ENDPATH**/ ?>