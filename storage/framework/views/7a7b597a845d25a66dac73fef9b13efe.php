<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Subscribers')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/sweetalert2/sweetalert2.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><?php echo e(__('l.Subscribers')); ?> /</span> <?php echo e(__('l.List')); ?></h4>

        <?php if(session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session()->get('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo e(__('l.Subscribers')); ?></h5>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add newsletters_subscribers')): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubscriberModal">
                    <i class="fa fa-plus me-2"></i><?php echo e(__('l.Add New')); ?>

                </button>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <div class="mb-3">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete newsletters_subscribers')): ?>
                        <button type="button" class="btn btn-danger d-none" id="delete-all-btn">
                            <i class="fa fa-trash me-2"></i><?php echo e(__('l.Delete Selected')); ?>

                        </button>
                        <?php endif; ?>
                    </div>
                    <table class="table table-hover" id="subscribers-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo e(__('l.Email')); ?></th>
                                <th><?php echo e(__('l.Status')); ?></th>
                                <th><?php echo e(__('l.Date')); ?></th>
                                <th><?php echo e(__('l.Actions')); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Subscriber Modal -->
        <div class="modal fade" id="addSubscriberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e(__('l.Add New Subscriber')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo e(route('dashboard.admins.subscribers-store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="email" class="form-label"><?php echo e(__('l.Email')); ?> <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo e(__('l.Enter Email')); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo e(__('l.Cancel')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(__('l.Save')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/libs/sweetalert2/sweetalert2.js')); ?>"></script>
<script>
    $(function() {
        let table = $('#subscribers-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "<?php echo e(route('dashboard.admins.subscribers')); ?>",
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="form-check-input row-checkbox" value="${row.id || ''}">`;
                    }
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [[4, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"lB><"d-flex align-items-center"f>>rtip',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "<?php echo app('translator')->get('l.All'); ?>"]
            ],
            pageLength: 10,
            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="fa fa-download me-1"></i> <?php echo app('translator')->get("l.Export"); ?>',
                    className: 'btn btn-primary dropdown-toggle mx-3',
                    buttons: [
                        {
                            text: '<i class="fa fa-file-excel me-1"></i> <?php echo app('translator')->get("l.Excel"); ?>',
                            className: 'dropdown-item',
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible:not(:first-child):not(:last-child)'
                            }
                        },
                        {
                            text: '<i class="fa fa-file-csv me-1"></i> <?php echo app('translator')->get("l.CSV"); ?>',
                            className: 'dropdown-item',
                            extend: 'csv',
                            exportOptions: {
                                columns: ':visible:not(:first-child):not(:last-child)'
                            }
                        },
                        {
                            text: '<i class="fa fa-file-pdf me-1"></i> <?php echo app('translator')->get("l.PDF"); ?>',
                            className: 'dropdown-item',
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':visible:not(:first-child):not(:last-child)'
                            }
                        },
                        {
                            text: '<i class="fa fa-print me-1"></i> <?php echo app('translator')->get("l.Print"); ?>',
                            className: 'dropdown-item',
                            extend: 'print',
                            exportOptions: {
                                columns: ':visible:not(:first-child):not(:last-child)'
                            }
                        }
                    ]
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-eye me-1"></i> <?php echo app('translator')->get("l.Columns"); ?>',
                    className: 'btn btn-secondary'
                }
            ],
            language: {
                // url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/<?php echo e(app()->getLocale()); ?>.json',
                buttons: {
                    colvis: '<?php echo app('translator')->get("l.Show/Hide Columns"); ?>'
                },
                lengthMenu: "<?php echo app('translator')->get('l.Show'); ?> _MENU_ <?php echo app('translator')->get('l.Records'); ?> <?php echo app('translator')->get('l.Per Page'); ?>",
                search: "<?php echo app('translator')->get('l.Search'); ?> :",
                paginate: {
                    first: "<?php echo app('translator')->get('l.First'); ?>",
                    previous: "<?php echo app('translator')->get('l.Previous'); ?>",
                    next: "<?php echo app('translator')->get('l.Next'); ?>",
                    last: "<?php echo app('translator')->get('l.Last'); ?>"
                },
                info: "<?php echo app('translator')->get('l.Show'); ?> _START_ <?php echo app('translator')->get('l.To'); ?> _END_ <?php echo app('translator')->get('l.Of'); ?> _TOTAL_ <?php echo app('translator')->get('l.Records'); ?>",
                infoEmpty: "<?php echo app('translator')->get('l.No Records Available'); ?>",
                infoFiltered: "<?php echo app('translator')->get('l.Filtered From'); ?> _MAX_ <?php echo app('translator')->get('l.Records'); ?>",
                processing: "<i class='fa fa-spinner fa-spin'></i> <?php echo app('translator')->get('l.Loading...'); ?>"
            },
            drawCallback: function(settings) {
                $('.dataTables_processing').hide();
            },
            preDrawCallback: function(settings) {
                $('.dataTables_processing').show();
            }
        });

        // Delete Subscriber
        $(document).on('click', '.delete-subscriber', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "<?php echo e(__('l.Are you sure?')); ?>",
                text: "<?php echo e(__('l.You will not be able to recover this item!')); ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "<?php echo e(__('l.Yes, delete it!')); ?>",
                cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo e(route('dashboard.admins.subscribers-delete')); ?>?id=" + id;
                }
            });
        });

        // تحديد/إلغاء تحديد الكل
        $('#select-all').on('change', function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
            updateDeleteButton();
        });

        // تحديث حالة زر الحذف عند تغيير أي صندوق تحديد
        $(document).on('change', '.row-checkbox', function() {
            updateDeleteButton();

            // تحديث حالة "تحديد الكل" إذا تم تحديد/إلغاء تحديد كل الصناديق
            let allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
            $('#select-all').prop('checked', allChecked);
        });

        // تحديث ظهور زر الحذف
        function updateDeleteButton() {
            let checkedCount = $('.row-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#delete-all-btn').removeClass('d-none');
            } else {
                $('#delete-all-btn').addClass('d-none');
            }
        }

        // Delete selected subscribers
        $('#delete-all-btn').click(function() {
            let selectedIds = [];

            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                Swal.fire({
                    title: "<?php echo e(__('l.Are you sure?')); ?>",
                    text: "<?php echo e(__('l.You will not be able to recover these items!')); ?>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "<?php echo e(__('l.Yes, delete them!')); ?>",
                    cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('dashboard.admins.subscribers-deleteSelected')); ?>?ids=" + selectedIds.join(',');
                    }
                });
            }
        });
    });
</script>

<?php if(session('success')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '<?php echo app('translator')->get("l.Done"); ?>',
                text: '<?php echo e(session("success")); ?>',
                confirmButtonText: '<?php echo app('translator')->get("l.OK"); ?>'
            });
        });
    </script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/subscribers/subscribers-list.blade.php ENDPATH**/ ?>