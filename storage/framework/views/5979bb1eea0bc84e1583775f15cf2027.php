<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Courses')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show courses')): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add courses')): ?>
                <div class="card-action-element mb-2" style="text-align: end;">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addCourseModal">
                        <i class="fa fa-plus fa-xs me-1"></i> <?php echo e(__('l.Add New Course')); ?>

                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-header">
                                <h3 class="modal-title text-center"><?php echo e(__('l.Add New Course')); ?></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addCourseForm" class="row g-3" method="post" enctype="multipart/form-data"
                                    action="<?php echo e(route('dashboard.admins.courses-store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="name"><?php echo e(__('l.Name')); ?></label>
                                        <input type="text" id="name" name="name" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="code"><?php echo e(__('l.Code')); ?></label>
                                        <input type="text" id="code" name="code" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="hours"><?php echo e(__('l.Hours')); ?></label>
                                        <input type="text" id="hours" name="hours" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="college_id"><?php echo e(__('l.College')); ?></label>
                                        <select id="college_id" name="college_id" class="form-select" required>
                                            <option value=""><?php echo e(__('l.Select College')); ?></option>
                                            <?php $__currentLoopData = \App\Models\College::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($college->id); ?>"><?php echo e($college->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="required_hours"><?php echo e(__('l.Required Hours')); ?></label>
                                        <input type="number" id="required_hours" name="required_hours" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label" for="is_active"><?php echo e(__('l.Status')); ?></label>
                                        <select id="is_active" name="is_active" class="form-select" required>
                                            <option value="1"><?php echo e(__('l.Active')); ?></option>
                                            <option value="0"><?php echo e(__('l.Inactive')); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label" for="required1"><?php echo e(__('l.Required Course')); ?> 1</label>
                                        <select id="required1" name="required1" class="form-select">
                                            <option value=""><?php echo e(__('l.No Requirement')); ?></option>
                                            <?php $__currentLoopData = \App\Models\Course::where('is_active', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req_course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($req_course->code); ?>">
                                                    <?php echo e($req_course->code); ?> - <?php echo e($req_course->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label" for="required2"><?php echo e(__('l.Required Course')); ?> 2</label>
                                        <select id="required2" name="required2" class="form-select">
                                            <option value=""><?php echo e(__('l.No Requirement')); ?></option>
                                            <?php $__currentLoopData = \App\Models\Course::where('is_active', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req_course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($req_course->code); ?>">
                                                    <?php echo e($req_course->code); ?> - <?php echo e($req_course->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label" for="required3"><?php echo e(__('l.Required Course')); ?> 3</label>
                                        <select id="required3" name="required3" class="form-select">
                                            <option value=""><?php echo e(__('l.No Requirement')); ?></option>
                                            <?php $__currentLoopData = \App\Models\Course::where('is_active', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req_course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($req_course->code); ?>">
                                                    <?php echo e($req_course->code); ?> - <?php echo e($req_course->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label" for="image"><?php echo e(__('l.Image')); ?></label>
                                        <input type="file" id="image" name="image" class="form-control" required />
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
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete courses')): ?>
                            <button id="deleteSelected" class="btn btn-danger d-none">
                                <i class="fa fa-trash ti-xs me-1"></i><?php echo e(__('l.Delete Selected')); ?>

                            </button>
                        <?php endif; ?>
                    </div>
                    <table class="table" id="courses-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>#</th>
                                <th><?php echo e(__('l.Image')); ?></th>
                                <th><?php echo e(__('l.Code')); ?></th>
                                <th><?php echo e(__('l.Name')); ?></th>
                                <th><?php echo e(__('l.Hours')); ?></th>
                                <th><?php echo e(__('l.College')); ?></th>
                                <th><?php echo e(__('l.Staff Count')); ?></th>
                                <th><?php echo e(__('l.Students Count')); ?></th>
                                <th><?php echo e(__('l.Status')); ?></th>
                                <th><?php echo e(__('l.Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($course->id); ?>">
                                    </td>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <img src="<?php echo e(asset($course->image)); ?>" alt="<?php echo e($course->name); ?>" width="50" height="50">
                                    </td>
                                    <td><?php echo e($course->code); ?></td>
                                    <td><?php echo e($course->name); ?></td>
                                    <td><?php echo e($course->hours); ?></td>
                                    <td><?php echo e($course->college->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($course->users()->wherePivot('status', 'staff')->count()); ?></td>
                                    <td><?php echo e($course->users()->wherePivot('status', 'enrolled')->count()); ?></td>
                                    <td>
                                        <?php if($course->is_active): ?>
                                            <span class="badge bg-success"><?php echo e(__('l.Active')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?php echo e(__('l.Inactive')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show courses')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.courses-show', ['id' => encrypt($course->id)])); ?>"
                                                   class="btn btn-sm btn-info me-1" title="<?php echo e(__('l.View')); ?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit courses')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.courses-edit', ['id' => encrypt($course->id)])); ?>"
                                                   class="btn btn-sm btn-primary me-1" title="<?php echo e(__('l.Edit')); ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?php echo e(route('dashboard.admins.courses-staff', ['id' => encrypt($course->id)])); ?>"
                                                   class="btn btn-sm btn-warning me-1" title="<?php echo e(__('l.Manage Staff')); ?>">
                                                    <i class="fa fa-users"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete courses')): ?>
                                                <button type="button" class="btn btn-sm btn-danger delete-course"
                                                        data-id="<?php echo e(encrypt($course->id)); ?>" title="<?php echo e(__('l.Delete')); ?>">
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
            let table = $('#courses-table').DataTable({
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

            // حذف المواد المحددة
            $('#deleteSelected').on('click', function() {
                let selectedIds = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: "<?php echo e(__('l.Are you sure?')); ?>",
                        text: "<?php echo e(__('l.Selected courses will be deleted!')); ?>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "<?php echo e(__('l.Yes, delete them!')); ?>",
                        cancelButtonText: "<?php echo e(__('l.Cancel')); ?>",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                "<?php echo e(route('dashboard.admins.courses-deleteSelected')); ?>?ids=" +
                                selectedIds.join(',');
                        }
                    });
                }
            });

            // إضافة معالج حدث الحذف للأزرار التي يتم إنشاؤها ديناميكياً
            $(document).on('click', '.delete-course', function() {
                let courseId = $(this).data('id');

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
                            "<?php echo e(route('dashboard.admins.courses-delete')); ?>?id=" +
                            courseId;
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/courses/courses-list.blade.php ENDPATH**/ ?>