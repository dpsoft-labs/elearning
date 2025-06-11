<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Blog Categories'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show blog_category')): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add blog_category')): ?>
                <div class="card-action-element mb-2" style="text-align: end;">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addTicketModal">
                        <i class="fa fa-plus fa-xs me-1"></i> <?php echo app('translator')->get('l.Add New Category'); ?>
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addTicketModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-header">
                                <h3 class="modal-title text-center"><?php echo app('translator')->get('l.Add New Category'); ?></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addTicketForm" class="row g-3" method="post"
                                    action="<?php echo e(route('dashboard.admins.blogs.categories-store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="meta_keywords"><?php echo app('translator')->get('l.Meta Keywords'); ?></label>
                                        <input type="text" id="meta_keywords" name="meta_keywords" class="form-control form-control-tags" />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="meta_description"><?php echo app('translator')->get('l.Meta Description'); ?></label>
                                        <textarea id="meta_description" name="meta_description" class="form-control"
                                            placeholder="<?php echo app('translator')->get('l.Enter a meta description'); ?>" rows="3"></textarea>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="name"><?php echo app('translator')->get('l.Name'); ?><i
                                                class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-8 me-2 ms-2"></i></label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="<?php echo app('translator')->get('l.Enter a name'); ?>" required />
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="auto_translate" />
                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?php echo app('translator')->get('l.Auto Translate'); ?></label>
                                        </div>
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
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete blog_category')): ?>
                            <button id="deleteSelected" class="btn btn-danger d-none">
                                <i class="fa fa-trash ti-xs me-1"></i><?php echo app('translator')->get('l.Delete Selected'); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                    <table class="table" id="categories-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo app('translator')->get('l.Name'); ?></th>
                                <th><?php echo app('translator')->get('l.Slug'); ?></th>
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
            let table = $('#categories-table').DataTable({
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
                        data: 'name',
                        name: 'name',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'slug',
                        name: 'slug',
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
                    [1, 'desc']
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
                        text: '<?php echo app('translator')->get('l.Selected categories will be deleted!'); ?>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete them!'); ?>',
                        cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                '<?php echo e(route('dashboard.admins.blogs.categories-deleteSelected')); ?>?ids=' +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-category', function() {
                let categoryId = $(this).data('id');

                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
                    text: '<?php echo app('translator')->get('l.You will be delete this forever!'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete it!'); ?>',
                    cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href =
                            '<?php echo e(route('dashboard.admins.blogs.categories-delete')); ?>?id=' +
                            categoryId;
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/pages/blogs/categories-list.blade.php ENDPATH**/ ?>