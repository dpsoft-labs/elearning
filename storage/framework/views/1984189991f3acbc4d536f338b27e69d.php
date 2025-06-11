<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Support Tickets'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show tickets')): ?>
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

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add tickets')): ?>
                <div class="card-action-element mb-2" style="text-align: end;">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addTicketModal">
                        <i class="fa fa-plus fa-xs me-1"></i> <?php echo app('translator')->get('l.Add New Ticket'); ?>
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addTicketModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-header">
                                <h3 class="modal-title text-center"><?php echo app('translator')->get('l.Add New Ticket'); ?></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addTicketForm" class="row g-3" method="post"
                                    action="<?php echo e(route('dashboard.admins.tickets-store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="modalRoleName"><?php echo app('translator')->get('l.Subject'); ?></label>
                                        <input type="text" id="modalRoleName" name="subject" class="form-control"
                                            placeholder="<?php echo app('translator')->get('l.Enter a Subject'); ?>" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="id"><?php echo app('translator')->get('l.Support type'); ?></label>
                                        <select id="id" class="select2 form-select" name="support_type" required>
                                            <option value=""><?php echo app('translator')->get('l.Select'); ?></option>
                                            <option value="sales support"><?php echo app('translator')->get('l.Sales support'); ?></option>
                                            <option value="technical support"><?php echo app('translator')->get('l.Technical support'); ?></option>
                                            <option value="Admin"><?php echo app('translator')->get('l.Admin'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="id"><?php echo app('translator')->get('l.User'); ?></label>
                                        <select id="id" class="select2 form-select" name="user_id" required>
                                            <option value=""><?php echo app('translator')->get('l.Select'); ?></option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>">
                                                    <?php echo e($user->firstname . ' ' . $user->lastname . ' (' . $user->email . ')'); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="Whois"><?php echo app('translator')->get('l.Description'); ?></label>
                                        <textarea id="Whois" name="description" class="form-control" required rows="5"></textarea>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal"><?php echo app('translator')->get('l.Cancel'); ?></button>
                                        <button type="submit" class="btn btn-secondary"><?php echo app('translator')->get('l.Create'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs nav-fill w-100" role="tablist" style="min-height: 50px;">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(!isset($_GET['inactive']) ? 'active' : ''); ?>"
                            href="<?php echo e(route('dashboard.admins.tickets')); ?>" style="padding: 15px;">
                            <i class="ti ti-ticket me-1"></i> <?php echo app('translator')->get('l.Active Tickets'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(isset($_GET['inactive']) ? 'active' : ''); ?>"
                            href="<?php echo e(route('dashboard.admins.tickets')); ?>?inactive=1" style="padding: 15px;">
                            <i class="ti ti-ticket-off me-1"></i> <?php echo app('translator')->get('l.Closed Tickets'); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card" style="padding: 15px;">
                <div class="card-datatable table-responsive">
                    <div class="mb-3">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete tickets')): ?>
                            <button id="deleteSelected" class="btn btn-danger d-none">
                                <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete Selected'); ?>
                            </button>
                            <?php if(isset($_GET['inactive'])): ?>
                                <button class="btn btn-danger delete-all-closed">
                                    <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete All Closed Tickets'); ?>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <table class="table" id="tickets-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo app('translator')->get('l.Subject'); ?></th>
                                <th><?php echo app('translator')->get('l.Support Type'); ?></th>
                                <th><?php echo app('translator')->get('l.User'); ?></th>
                                <th><?php echo app('translator')->get('l.Status'); ?></th>
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
            // إضافة كائن الترجمة
            const translations = {
                'sales support': '<?php echo app('translator')->get('l.Sales support'); ?>',
                'technical support': '<?php echo app('translator')->get('l.Technical support'); ?>',
                'admin': '<?php echo app('translator')->get('l.Admin'); ?>'
            };

            let table = $('#tickets-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(request()->fullUrl()); ?>?inactive=<?php echo e(isset($_GET['inactive']) ? $_GET['inactive'] : ''); ?>',
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<input type="checkbox" class="form-check-input row-checkbox" value="${data.id}">`;
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'support_type',
                        name: 'support_type',
                        searchable: true,
                        orderable: true,
                        render: function(data) {
                            return translations[data.toLowerCase()] || data;
                        }
                    },
                    {
                        data: 'user',
                        name: 'user.firstname',
                        searchable: true,
                        orderable: true,
                        render: function(data) {
                            return `<a href="<?php echo e(route('dashboard.admins.users-show')); ?>?id=${data.encrypted_id}"><img src="${data.photo}" alt="User Photo" class="rounded-circle" style="width: 35px; height: 35px;"> ${data.name}</a>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: true,
                        orderable: true,
                        render: function(data) {
                            let badge = '';
                            let statusText = '';

                            switch (data) {
                                case 'answered':
                                    badge = 'bg-success';
                                    statusText = '<?php echo app('translator')->get('l.Answered'); ?>';
                                    break;
                                case 'in_progress':
                                    badge = 'bg-warning';
                                    statusText = '<?php echo app('translator')->get('l.In Progress'); ?>';
                                    break;
                                case 'closed':
                                    badge = 'bg-dark';
                                    statusText = '<?php echo app('translator')->get('l.Closed'); ?>';
                                    break;
                                default:
                                    badge = 'bg-secondary';
                                    statusText = data;
                            }

                            return `<span class="badge ${badge} ${data === 'in_progress' ? 'blink' : ''}">${statusText}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [5, 'desc']
                ],
                dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex align-items-center"f>>rtip',
                language: {
                    search: "<?php echo app('translator')->get('l.Search'); ?>:",
                    lengthMenu: "<?php echo app('translator')->get('l.Show'); ?> _MENU_ <?php echo app('translator')->get('l.entries'); ?>",
                    paginate: {
                        next: '<?php echo app('translator')->get('l.Next'); ?>',
                        previous: '<?php echo app('translator')->get('l.Previous'); ?>'
                    },
                    info: "<?php echo app('translator')->get('l.Showing'); ?> _START_ <?php echo app('translator')->get('l.to'); ?> _END_ <?php echo app('translator')->get('l.of'); ?> _TOTAL_ <?php echo app('translator')->get('l.entries'); ?>",
                    infoEmpty: "<?php echo app('translator')->get('l.Showing'); ?> 0 <?php echo app('translator')->get('l.To'); ?> 0 <?php echo app('translator')->get('l.Of'); ?> 0 <?php echo app('translator')->get('l.entries'); ?>",
                    infoFiltered: "<?php echo app('translator')->get('l.Showing'); ?> 1 <?php echo app('translator')->get('l.Of'); ?> 1 <?php echo app('translator')->get('l.entries'); ?>",
                    zeroRecords: "<?php echo app('translator')->get('l.No matching records found'); ?>",
                    loadingRecords: "<?php echo app('translator')->get('l.Loading...'); ?>",
                    processing: "<?php echo app('translator')->get('l.Processing...'); ?>",
                    emptyTable: "<?php echo app('translator')->get('l.No data available in table'); ?>",
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

            // حذف التذاكر المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                        text: '<?php echo app('translator')->get('l.Selected tickets will be deleted!'); ?>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete them!'); ?>',
                        cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                '<?php echo e(route('dashboard.admins.tickets-deleteSelected')); ?>?ids=' +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // حذف جميع التذاكر المغلقة
            $('.delete-all-closed').on('click', function() {
                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: '<?php echo app('translator')->get('l.All closed tickets will be deleted!'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete all!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?php echo e(route('dashboard.admins.tickets-deleteAll')); ?>';
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/tickets/tickets-list.blade.php ENDPATH**/ ?>