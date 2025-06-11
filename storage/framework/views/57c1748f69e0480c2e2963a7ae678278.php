<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Colleges')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show colleges')): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add colleges')): ?>
                <div class="card-action-element mb-2" style="text-align: end;">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addCollegeModal">
                        <i class="fa fa-plus fa-xs me-1"></i> <?php echo e(__('l.Add New College')); ?>

                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addCollegeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-header">
                                <h3 class="modal-title text-center"><?php echo e(__('l.Add New College')); ?></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addCollegeForm" class="row g-3" method="post"
                                    action="<?php echo e(route('dashboard.admins.colleges-store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="name"><?php echo e(__('l.Name')); ?></label>
                                        <input type="text" id="name" name="name" class="form-control" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="address"><?php echo e(__('l.Address')); ?></label>
                                        <input type="text" id="address" name="address" class="form-control" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="phone"><?php echo e(__('l.Phone')); ?></label>
                                        <input type="text" id="phone" name="phone" class="form-control" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="email"><?php echo e(__('l.Email')); ?></label>
                                        <input type="email" id="email" name="email" class="form-control" required />
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal"><?php echo e(__('l.Cancel')); ?></button>
                                        <button type="submit" class="btn btn-primary"><?php echo e(__('l.Create')); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card" style="padding: 15px;">
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

                <div class="card-datatable table-responsive">
                    <div class="mb-3">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete colleges')): ?>
                            <button id="deleteSelected" class="btn btn-danger d-none">
                                <i class="fa fa-trash ti-xs me-1"></i><?php echo e(__('l.Delete Selected')); ?>

                            </button>
                        <?php endif; ?>
                    </div>
                    <table class="table" id="colleges-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo e(__('l.Name')); ?></th>
                                <th><?php echo e(__('l.Address')); ?></th>
                                <th><?php echo e(__('l.Phone')); ?></th>
                                <th><?php echo e(__('l.Email')); ?></th>
                                <th><?php echo e(__('l.Students Count')); ?></th>
                                <th><?php echo e(__('l.Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($college->id); ?>">
                                    </td>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($college->name); ?></td>
                                    <td><?php echo e($college->address); ?></td>
                                    <td><?php echo e($college->phone); ?></td>
                                    <td><?php echo e($college->email); ?></td>
                                    <td><?php echo e($college->students->count()); ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show colleges')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.colleges-show', ['id' => encrypt($college->id)])); ?>"
                                                   class="btn btn-sm btn-info me-1" title="<?php echo e(__('l.View')); ?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit colleges')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.colleges-edit', ['id' => encrypt($college->id)])); ?>"
                                                   class="btn btn-sm btn-primary me-1" title="<?php echo e(__('l.Edit')); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete colleges')): ?>
                                                <button type="button" class="btn btn-sm btn-danger delete-college"
                                                        data-id="<?php echo e(encrypt($college->id)); ?>" title="<?php echo e(__('l.Delete')); ?>">
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
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            let table = $('#colleges-table').DataTable({
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
                }
            });

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

            // حذف الفروع المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: "<?php echo e(__('l.Are you sure?')); ?>",
                        text: "<?php echo e(__('l.Selected colleges will be deleted!')); ?>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "<?php echo e(__('l.Yes, delete them!')); ?>",
                        cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                "<?php echo e(route('dashboard.admins.colleges-deleteSelected')); ?>?ids=" +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-college', function() {
                let collegeId = $(this).data('id');

                Swal.fire({
                    title: "<?php echo e(__('l.Are you sure?')); ?>",
                    text: "<?php echo e(__('l.You will be delete this forever!')); ?>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "<?php echo e(__('l.Yes, delete it!')); ?>",
                    cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            "<?php echo e(route('dashboard.admins.colleges-delete')); ?>?id=" +
                            collegeId;
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/colleges/colleges-list.blade.php ENDPATH**/ ?>