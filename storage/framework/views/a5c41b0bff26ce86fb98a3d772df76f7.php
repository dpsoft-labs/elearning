<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Notes'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card-action-element mb-2" style="text-align: end;">
            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                data-bs-target="#addTicketModal">
                <i class="fa fa-plus fa-xs me-1"></i> <?php echo app('translator')->get('l.Add New Note'); ?>
            </button>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Modal -->
        <div class="modal fade" id="addTicketModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-header">
                        <h3 class="modal-title text-center"><?php echo app('translator')->get('l.Add New Note'); ?></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTicketForm" class="row g-3" method="post"
                            action="<?php echo e(route('dashboard.users.notes-store')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="col-12 mb-2">
                                <label class="form-label" for="note"><?php echo app('translator')->get('l.Note'); ?></label>
                                <textarea type="text" id="note" name="note" class="form-control" placeholder="<?php echo app('translator')->get('l.Enter a note'); ?>"
                                    rows="5" required></textarea>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-label" for="date"><?php echo app('translator')->get('l.Date'); ?></label>
                                <input type="date" id="date" name="date" class="form-control"
                                    value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>" required />
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-label" for="is_still_active"><?php echo app('translator')->get('l.Keep it always'); ?> <i
                                        class="fa fa-info-circle" data-bs-toggle="tooltip"
                                        title="<?php echo app('translator')->get('l.When selected, the notification will remain visible until you delete it. If not selected, the notification will only appear on its specified date and disappear afterwards.'); ?>"></i></label>
                                <input type="hidden" name="is_still_active" value="0" />
                                <input type="checkbox" id="is_still_active" name="is_still_active" class="form-check-input"
                                    value="1" />
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="button" class="btn btn-label-secondary"
                                    data-bs-dismiss="modal"><?php echo app('translator')->get('l.Cancel'); ?></button>
                                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Create'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="padding: 15px;">
            <div class="card-datatable table-responsive">
                <div class="mb-3">
                    <button id="deleteSelected" class="btn btn-danger d-none">
                        <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete Selected'); ?>
                    </button>
                </div>
                <table class="table" id="notes-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>#</th>
                            <th><?php echo app('translator')->get('l.Note'); ?></th>
                            <th><?php echo app('translator')->get('l.Date'); ?></th>
                            <th><?php echo app('translator')->get('l.Action'); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            let table = $('#notes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(request()->fullUrl()); ?>',
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
                        data: 'note',
                        name: 'note',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [3, 'desc']
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "<?php echo app('translator')->get('l.All'); ?>"]
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

            // حذف الملاحظات المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                        text: '<?php echo app('translator')->get('l.Selected notes will be deleted!'); ?>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete them!'); ?>',
                        cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                '<?php echo e(route('dashboard.users.notes-deleteSelected')); ?>?ids=' +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-note', function() {
                let noteId = $(this).data('id');

                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: '<?php echo app('translator')->get('l.You will delete this note forever!'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete it!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?php echo e(route('dashboard.users.notes-delete')); ?>?id=' +
                            noteId;
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/users/notes/notes-list.blade.php ENDPATH**/ ?>