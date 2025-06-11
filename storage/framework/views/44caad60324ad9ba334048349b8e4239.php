<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.Languages List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show settings')): ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo e(__('l.Languages List')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover languages-table">
                            <thead>
                                <tr class="text-center">
                                    <th><?php echo e(__('l.Code')); ?></th>
                                    <th><?php echo e(__('l.Name')); ?></th>
                                    <th><?php echo e(__('l.Flag')); ?></th>
                                    <th><?php echo e(__('l.Status')); ?></th>
                                    <th><?php echo e(__('l.Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $defaultLanguage = $languages->firstWhere('code', $settings['default_language'] ?? '');
                                    $activeLanguages = $languages
                                        ->where('is_active', true)
                                        ->where('code', '!=', $settings['default_language'])
                                        ->sortBy('name');
                                    $inactiveLanguages = $languages->where('is_active', false)->sortBy('name');
                                ?>

                                <?php if($defaultLanguage): ?>
                                    <tr class="text-center">
                                        <td><span class="badge bg-label-primary"><?php echo e($defaultLanguage->code); ?></span></td>
                                        <td><?php echo e($defaultLanguage->name); ?> (<?php echo e($defaultLanguage->native); ?>)</td>
                                        <td>
                                            <i class="fi fi-<?php echo e(strtolower($defaultLanguage->flag)); ?> fs-3"></i>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?php echo e(__('l.Active')); ?></span>
                                            <span class="badge bg-info"><?php echo e(__('l.Default')); ?></span>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <div class="d-inline-flex">
                                                    <a href="<?php echo e(route('dashboard.admins.languages-translate')); ?>?id=<?php echo e(encrypt($defaultLanguage->id)); ?>&type=front"
                                                        class="btn btn-sm btn-icon btn-dark me-2"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Translate')); ?>">
                                                        <i class="fas fa-language"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php $__currentLoopData = $activeLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="text-center">
                                        <td><span class="badge bg-label-primary"><?php echo e($language->code); ?></span></td>
                                        <td><?php echo e($language->name); ?> (<?php echo e($language->native); ?>)</td>
                                        <td>
                                            <i class="fi fi-<?php echo e(strtolower($language->flag)); ?> fs-3"></i>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?php echo e(__('l.Active')); ?></span>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <div class="d-inline-flex">
                                                    <a href="<?php echo e(route('dashboard.admins.languages-status')); ?>?id=<?php echo e(encrypt($language->id)); ?>"
                                                        class="btn btn-sm btn-icon btn-warning me-2"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Disable')); ?>">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('dashboard.admins.languages-translate')); ?>?id=<?php echo e(encrypt($language->id)); ?>&type=front"
                                                        class="btn btn-sm btn-icon btn-dark me-2"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Translate')); ?>">
                                                        <i class="fas fa-language"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-icon btn-danger delete-role"
                                                            data-role-id="<?php echo e(encrypt($language->id)); ?>"
                                                            data-bs-toggle="tooltip"
                                                            title="<?php echo e(__('l.Delete')); ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $inactiveLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="text-center">
                                        <td><span class="badge bg-label-primary"><?php echo e($language->code); ?></span></td>
                                        <td><?php echo e($language->name); ?> (<?php echo e($language->native); ?>)</td>
                                        <td>
                                            <i class="fi fi-<?php echo e(strtolower($language->flag)); ?> fs-3"></i>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e(__('l.Inactive')); ?></span>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <div class="d-inline-flex">
                                                    <a href="<?php echo e(route('dashboard.admins.languages-status')); ?>?id=<?php echo e(encrypt($language->id)); ?>"
                                                        class="btn btn-sm btn-icon btn-success me-2"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Activate')); ?>">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('dashboard.admins.languages-translate')); ?>?id=<?php echo e(encrypt($language->id)); ?>&type=front"
                                                        class="btn btn-sm btn-icon btn-dark me-2"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Translate')); ?>">
                                                        <i class="fas fa-language"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-icon btn-danger delete-role"
                                                            data-role-id="<?php echo e(encrypt($language->id)); ?>"
                                                            data-bs-toggle="tooltip"
                                                            title="<?php echo e(__('l.Delete')); ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            $('.languages-table').DataTable({
                "order": [],
                "pageLength": 25,
                "aaSorting": [],
                "dom": '<"float-end mb-3"f><"float-start mb-3"l>rtip', // تغيير ترتيب عناصر الجدول لنقل البحث للطرف وإضافة مسافة
                language: {
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
                }
            });
        });

        //  كود حذف اللغة
        $(document).on('click', '.delete-role', function(e) {
            e.preventDefault();
            var roleId = $(this).data('role-id');

            Swal.fire({
                title: '<?php echo e(__('l.Are you sure?')); ?>',
                text: '<?php echo e(__('l.You will be delete this forever!')); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<?php echo e(__('l.Yes, delete it!')); ?>',
                cancelButtonText: '<?php echo e(__('l.Cancel')); ?>',
                customClass: {
                    confirmButton: 'btn btn-danger ms-2 mr-2 ml-2',
                    cancelButton: 'btn btn-dark ms-2 mr-2 ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo e(route("dashboard.admins.languages-delete")); ?>?id=' + roleId;
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/languages/languages-list.blade.php ENDPATH**/ ?>