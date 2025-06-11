<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Lectures List'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="page-category">
            <div class="content-wrapper">
                <?php if(isset($courses)): ?>
                    <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo e($course->name); ?></h4>
                                        <div class="stats mt-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><?php echo app('translator')->get('l.Students'); ?></span>
                                                <span class="badge bg-primary"><?php echo e($course->students()->count()); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><?php echo app('translator')->get('l.Lectures'); ?></span>
                                                <span class="badge bg-info"><?php echo e($course->lectures()->count()); ?></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo e(route('dashboard.admins.lectures')); ?>?course=<?php echo e(encrypt($course->id)); ?>"
                                            class="btn btn-primary btn-block mt-3">
                                            <?php echo app('translator')->get('l.View Lectures'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo app('translator')->get('l.No Courses Found'); ?></h4>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show lectures')): ?>
                        <!-- Multilingual -->
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add lectures')): ?>
                            <div class="card-action-element mb-2 add-new-lecture" style="text-align: end; ">
                                <a href="#" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn btn-secondary waves-effect waves-light">
                                    <i class="ti ti-plus ti-xs me-1"></i><?php echo app('translator')->get('l.Add new Lecture'); ?>
                                </a>
                            </div>
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <!-- Add Role Modal -->
                            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-lecture"
                                    style="justify-content: center;">
                                    <div class="modal-content p-3 p-md-5 col-md-8">
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <h3 class="role-title mb-2"><?php echo app('translator')->get('l.Add new Lecture'); ?></h3>
                                            </div>
                                            <!-- Add role form -->
                                            <form id="addLectureForm" class="row g-3" method="post" enctype="multipart/form-data"
                                                action="<?php echo e(route('dashboard.admins.lectures-store')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="name"><?php echo app('translator')->get('l.Name'); ?></label>
                                                    <input type="text" id="name" name="name" class="form-control"
                                                        required />
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="description"><?php echo app('translator')->get('l.Description'); ?></label>
                                                    <textarea type="text" id="description" name="description" class="form-control"></textarea>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="video"><?php echo app('translator')->get('l.Video'); ?></label>
                                                    <input type="text" id="video" name="video" class="form-control" />
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="files"><?php echo app('translator')->get('l.Files'); ?></label>
                                                    <input type="file" id="files" name="files" class="form-control" />
                                                </div>
                                                <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit"
                                                        class="btn btn-primary me-sm-3 me-1"><?php echo app('translator')->get('l.Submit'); ?></button>
                                                </div>
                                            </form>
                                            <!--/ Add role form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Add Role Modal -->
                        <?php endif; ?>

                        <div class="card" id="div1" style="padding: 30px;">
                            <div class="card-datatable table-responsive">
                                <table class=" table" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo app('translator')->get('l.Name'); ?></th>
                                            <th><?php echo app('translator')->get('l.Course'); ?></th>
                                            <th><?php echo app('translator')->get('l.Created At'); ?></th>
                                            <th><?php echo app('translator')->get('l.Action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $lectures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="capital">
                                                    <?php echo e(($lectures->currentPage() - 1) * $lectures->perPage() + $loop->iteration); ?>

                                                </td>
                                                <td class="capital">
                                                    <?php echo e($lecture->name); ?>

                                                </td>
                                                <td class="capital">
                                                    <?php echo e($lecture->course->name); ?>

                                                </td>
                                                <td class="capital"><?php echo e($lecture->created_at->format('d/m/Y')); ?></td>
                                                <td class="capital">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lectures')): ?>
                                                        <a href="<?php echo e(route('dashboard.admins.lectures-edit')); ?>?id=<?php echo e(encrypt($lecture->id)); ?>"
                                                            data-bs-toggle="tooltip" title="edit" class=" btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete lectures')): ?>
                                                        <a class="delete-lecture btn btn-danger btn-sm" href="javascript:void(0);"
                                                            data-bs-toggle="tooltip" title="delete lecture"
                                                            data-lecture-id="<?php echo e(encrypt($lecture->id)); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        var table = $('#data-table').DataTable({
            ordering: true,
            order: [],
        });

        $('#search-input').keyup(function() {
            table.search($(this).val()).draw();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addRoleButton = document.querySelector('.add-new-lecture');
            const addRoleModal = document.querySelector('#addRoleModal');

            addRoleButton.addEventListener('click', function() {
                var modal = new bootstrap.Modal(addRoleModal);
                modal.show();
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-lecture', function(e) {
            e.preventDefault();
            const lectureId = $(this).data('lecture-id');

            Swal.fire({
                title: "<?php echo app('translator')->get('l.Are you sure?'); ?>",
                text: "<?php echo app('translator')->get('l.You will be delete this forever!'); ?>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#343a40',
                confirmButtonText: "<?php echo app('translator')->get('l.Yes, delete it!'); ?>",
                cancelButtonText: "<?php echo app('translator')->get('l.Cancel'); ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo e(route('dashboard.admins.lectures-delete')); ?>?id=' + lectureId;
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/lectures/lectures-list.blade.php ENDPATH**/ ?>