<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.List'); ?> <?php if($inactiveUsers == 1): ?>
        <?php echo app('translator')->get('l.Inactive'); ?>
    <?php endif; ?> <?php echo app('translator')->get('l.Students'); ?>
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

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($error); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show students')): ?>
            <?php if($inactiveUsers == 0): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add students')): ?>
                    <div class="card-action-element mb-2" style="text-align: end; ">
                        <a href="<?php echo e(route('dashboard.admins.students-import-get')); ?>" class="btn btn-info waves-effect waves-light me-2">
                            <i class="fa fa-file-import ti-xs me-1"></i>
                            <?php echo app('translator')->get('l.Import Students'); ?>
                        </a>
                        <a href="<?php echo e(route('dashboard.admins.students-add')); ?>"
                            class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus ti-xs me-1"></i>
                            <?php echo app('translator')->get('l.Add New Student'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php elseif($inactiveUsers == 1): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete students')): ?>
                    <div class="card-action-element mb-2" style="text-align: end; ">
                        <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light delete-all-inactive"><i
                                class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete All Inactive Students'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs nav-fill w-100" role="tablist" style="min-height: 50px;">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($inactiveUsers == 0 ? 'active' : ''); ?>"
                            href="<?php echo e(route('dashboard.admins.students')); ?>" style="padding: 15px;">
                            <i class="fa fa-users ti-xs me-1"></i> <?php echo app('translator')->get('l.Active Students'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($inactiveUsers == 1 ? 'active' : ''); ?>"
                            href="<?php echo e(route('dashboard.admins.students')); ?>?inactive=1" style="padding: 15px;">
                            <i class="fa fa-user-times ti-xs me-1"></i> <?php echo app('translator')->get('l.Inactive Students'); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card" id="div1" style="padding: 15px;">
                <div class="card-datatable table-responsive">
                    <div class="mb-3">
                        <button id="deleteSelected" class="btn btn-danger d-none">
                            <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete Selected'); ?>
                        </button>
                    </div>
                    <table class="table" id="students-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo app('translator')->get('l.Student Name'); ?></th>
                                <th><?php echo app('translator')->get('l.Email'); ?></th>
                                <th><?php echo app('translator')->get('l.Phone'); ?></th>
                                <th>SID</th>
                                <th><?php echo app('translator')->get('l.Branch'); ?></th>
                                <th><?php echo app('translator')->get('l.College'); ?></th>
                                <?php if($inactiveUsers == 1): ?>
                                    <th><?php echo app('translator')->get('l.Deleted At'); ?></th>
                                <?php endif; ?>
                                <th><?php echo app('translator')->get('l.Action'); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            let table = $('#students-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '<?php echo e(request()->url()); ?>?inactive=<?php echo e($inactiveUsers); ?>',
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        exportable: false,
                        render: function (data, type, row) {
                            if (type === 'display') {
                                return `<input type="checkbox" class="form-check-input row-checkbox" value="${row?.id || ''}">`;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'sid',
                        name: 'sid',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'branch',
                        name: 'branch_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'college',
                        name: 'college_id',
                        orderable: false,
                        searchable: false
                    },
                    <?php if($inactiveUsers == 1): ?>
                        {
                            data: 'deleted_at',
                            name: 'deleted_at',
                            orderable: true,
                            searchable: true
                        },
                    <?php endif; ?> {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                <?php if($inactiveUsers == 1): ?>
                    order: [
                        [8, 'desc']
                    ],
                <?php else: ?>
                    order: [
                        [1, 'desc']
                    ],
                <?php endif; ?>
                dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"lB><"d-flex align-items-center"f>>rtip',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "<?php echo app('translator')->get('l.All'); ?>"]
                ],
                pageLength: 10,
                buttons: [{
                        extend: 'collection',
                        text: '<i class="ti ti-download me-1"></i> <?php echo app('translator')->get('l.Export'); ?>',
                        className: 'btn btn-primary dropdown-toggle mx-3',
                        buttons: [{
                                text: '<i class="ti ti-file-spreadsheet me-1"></i> <?php echo app('translator')->get('l.Excel'); ?>',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    window.open(
                                        '<?php echo e(route('dashboard.admins.students.export')); ?>?type=excel&' +
                                        $.param({
                                            search: {
                                                value: table.search()
                                            },
                                            order: [{
                                                column: table.order()[0][0],
                                                dir: table.order()[0][1]
                                            }],
                                            columns: table.settings().init().columns,
                                            inactive: <?php echo e($inactiveUsers ?? 0); ?>

                                        }), '_blank');
                                }
                            },
                            {
                                text: '<i class="ti ti-file-text me-1"></i> <?php echo app('translator')->get('l.CSV'); ?>',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    window.open(
                                        '<?php echo e(route('dashboard.admins.students.export')); ?>?type=csv&' +
                                        $.param({
                                            search: {
                                                value: table.search()
                                            },
                                            order: [{
                                                column: table.order()[0][0],
                                                dir: table.order()[0][1]
                                            }],
                                            columns: table.settings().init().columns,
                                            inactive: <?php echo e($inactiveUsers ?? 0); ?>

                                        }), '_blank');
                                }
                            },
                            {
                                text: '<i class="ti ti-file-description me-1"></i> <?php echo app('translator')->get('l.PDF'); ?>',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    exportData('pdf');
                                }
                            },
                            {
                                text: '<i class="ti ti-printer me-1"></i> <?php echo app('translator')->get('l.Print'); ?>',
                                className: 'dropdown-item',
                                action: function(e, dt, node, config) {
                                    e.preventDefault();
                                    exportData('print');
                                }
                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="ti ti-eye me-1"></i> <?php echo app('translator')->get('l.Columns'); ?>',
                        className: 'btn btn-secondary'
                    }
                ],
                language: {
                    // url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/<?php echo e(app()->getLocale()); ?>.json',
                    buttons: {
                        colvis: '<?php echo app('translator')->get('l.Show/Hide Columns'); ?>'
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

            function exportData(type) {
                if (type === 'print' || type === 'pdf') {
                    $.ajax({
                        url: '<?php echo e(route('dashboard.admins.students.export')); ?>',
                        type: 'GET',
                        data: {
                            search: {
                                value: table.search()
                            },
                            order: [{
                                column: table.order()[0][0],
                                dir: table.order()[0][1]
                            }],
                            columns: table.settings().init().columns.filter(col => col.exportable !== false),
                            inactive: <?php echo e($inactiveUsers ?? 0); ?>

                        },
                        success: function(response) {
                            printData(response.data);
                        }
                    });
                }
            }

            function printData(data) {
                let printWindow = window.open('', '_blank');
                let html = `
            <html dir="<?php echo e(in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr'); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
                <head>
                    <!-- <title><?php echo app('translator')->get('l.Students List'); ?></title> -->
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; }
                        th { background-color: #f5f5f5; }
                        h1 { text-align: center; }
                    </style>
                </head>
                <body>
                    <h1><?php echo app('translator')->get('l.Students List'); ?></h1>
                    <table>
                        <thead>
                            <tr>${Object.keys(data[0]).map(key => `<th>${key}</th>`).join('')}</tr>
                        </thead>
                        <tbody>
                            ${data.map(row => `
                                    <tr>${Object.values(row).map(value => `<td>${value}</td>`).join('')}</tr>
                                `).join('')}
                        </tbody>
                    </table>
                </body>
            </html>
        `;
                printWindow.document.write(html);
                printWindow.document.close();
                printWindow.print();
            }

            // معالجة أحداث الحذف
            $(document).on('click', '.delete-record', function(e) {
                e.preventDefault();
                const deleteUrl = $(this).attr('href');
                const isInactive = $(this).data('inactive');

                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: isInactive ? "<?php echo app('translator')->get('l.The student will be deleted permanently!'); ?>" : "<?php echo app('translator')->get('l.The student will be disabled!'); ?>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete it!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });

            // تفعيل tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // إضافة معالج حدث للزر حذف جميع المستخدمين غير النشطين
            $('.delete-all-inactive').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: "<?php echo app('translator')->get('l.All inactive students will be deleted permanently! This action cannot be undone.'); ?>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete all!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // قم بتوجيه المستخدم إلى رابط حذف جميع المستخدمين غير النشطين
                        window.location.href =
                            '<?php echo e(route('dashboard.admins.students-delete-allinactive')); ?>';
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
                    $('#deleteSelected').removeClass('d-none');
                } else {
                    $('#deleteSelected').addClass('d-none');
                }
            }

            // معالجة حدث الحذف المتعدد
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                        text: "<?php echo app('translator')->get('l.Selected students will be deleted!'); ?>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete them!'); ?>',
                        cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?php echo e(route("dashboard.admins.students-delete-selected")); ?>?ids=' + selectedIds.join(',');
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
                    title: '<?php echo app('translator')->get('l.Done'); ?>',
                    text: '<?php echo e(session('success')); ?>',
                    confirmButtonText: '<?php echo app('translator')->get('l.OK'); ?>'
                });
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/students/students-list.blade.php ENDPATH**/ ?>