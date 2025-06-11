<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Currencies List'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show settings')): ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo app('translator')->get('l.Currencies List'); ?></h5>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>


                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong><?php echo app('translator')->get('l.Note'); ?>:</strong> <?php echo app('translator')->get('l.Currency exchange rates are automatically updated 3 times per day'); ?> <?php echo app('translator')->get('l.or'); ?>
                        <a href="<?php echo e(route('dashboard.admins.currencies-exchange')); ?>" class=""><?php echo app('translator')->get('l.Update Now'); ?></a>
                        <br>
                        <?php echo app('translator')->get('l.Please note that all currencies are updated based on the euro, even if it is not the default currency, so if you are going to change the rate of one of the currencies manually, please make sure it will be based on euro'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <?php echo app('translator')->get('l.Please note you can change the default currency in the general settings, and this will affect the currency of the site and all products in the site so please update the prices after changing the default currency'); ?>
                        <a href="<?php echo e(route('dashboard.admins.settings')); ?>?tab=general"><?php echo app('translator')->get('l.Go to General Settings'); ?></a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover currencies-table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('l.Code'); ?></th>
                                    <th><?php echo app('translator')->get('l.Name'); ?></th>
                                    <th><?php echo app('translator')->get('l.Symbol'); ?></th>
                                    <th><?php echo app('translator')->get('l.Rate'); ?></th>
                                    <th><?php echo app('translator')->get('l.Status'); ?></th>
                                    <th><?php echo app('translator')->get('l.Last Updated'); ?></th>
                                    <th><?php echo app('translator')->get('l.Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $defaultCurrency = $currencies->where('code', $settings['default_currency'])->first();
                                    $activeCurrencies = $currencies
                                        ->where('is_active', true)
                                        ->where('code', '!=', $defaultCurrency->code)
                                        ->sortBy('name');
                                    $inactiveCurrencies = $currencies->where('is_active', false)->sortBy('name');
                                ?>

                                <?php if($defaultCurrency): ?>
                                    <tr class="default-currency">
                                        <td><span class="badge bg-label-primary"><?php echo e(strtoupper($defaultCurrency->code)); ?></span></td>
                                        <td><?php echo e($defaultCurrency->name); ?></td>
                                        <td><?php echo e($defaultCurrency->symbol); ?></td>
                                        <td data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo e($defaultCurrency->rate); ?> = 1 EUR"><?php echo e(number_format($defaultCurrency->rate, 4)); ?></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo e(__('l.Active')); ?></span>
                                            <span class="badge bg-info"><?php echo e(__('l.Default')); ?></span>
                                            <?php if($defaultCurrency->is_manual): ?>
                                                <span class="badge bg-warning"><?php echo e(__('l.Manual')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($defaultCurrency->last_updated_at ?? now()->format('Y-m-d H:i')); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.currencies-edit')); ?>?id=<?php echo e(encrypt($defaultCurrency->id)); ?>"
                                                    class="btn btn-sm btn-icon btn-info me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('l.Edit')); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php $__currentLoopData = $activeCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><span class="badge bg-label-primary"><?php echo e(strtoupper($currency->code)); ?></span></td>
                                        <td><?php echo e($currency->name); ?></td>
                                        <td><?php echo e($currency->symbol); ?></td>
                                        <td data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo e($currency->rate); ?> = 1 EUR"><?php echo e(number_format($currency->rate, 4)); ?></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo e(__('l.Active')); ?></span>
                                            <?php if($currency->is_manual): ?>
                                                <span class="badge bg-warning"><?php echo e(__('l.Manual')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($currency->last_updated_at ?? now()->format('Y-m-d H:i')); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.currencies-status')); ?>?id=<?php echo e(encrypt($currency->id)); ?>"
                                                    class="btn btn-sm btn-icon btn-warning me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('l.Disable')); ?>">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                                <a href="<?php echo e(route('dashboard.admins.currencies-edit')); ?>?id=<?php echo e(encrypt($currency->id)); ?>"
                                                    class="btn btn-sm btn-icon btn-info me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('l.Edit')); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-icon btn-danger delete-role"
                                                        data-role-id="<?php echo e(encrypt($currency->id)); ?>"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Delete')); ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $__currentLoopData = $inactiveCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><span class="badge bg-label-primary"><?php echo e(strtoupper($currency->code)); ?></span></td>
                                        <td><?php echo e($currency->name); ?></td>
                                        <td><?php echo e($currency->symbol); ?></td>
                                        <td data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo e($currency->rate); ?> = 1 EUR"><?php echo e(number_format($currency->rate, 4)); ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e(__('l.Inactive')); ?></span>
                                            <?php if($currency->is_manual): ?>
                                                <span class="badge bg-warning"><?php echo e(__('l.Manual')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($currency->last_updated_at ?? now()->format('Y-m-d H:i')); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                                <a href="<?php echo e(route('dashboard.admins.currencies-status')); ?>?id=<?php echo e(encrypt($currency->id)); ?>"
                                                    class="btn btn-sm btn-icon btn-success me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('l.Activate')); ?>">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="<?php echo e(route('dashboard.admins.currencies-edit')); ?>?id=<?php echo e(encrypt($currency->id)); ?>"
                                                    class="btn btn-sm btn-icon btn-info me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('l.Edit')); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-icon btn-danger delete-role"
                                                        data-role-id="<?php echo e(encrypt($currency->id)); ?>"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('l.Delete')); ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
            $('.currencies-table').DataTable({
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
                    window.location.href = '<?php echo e(route("dashboard.admins.currencies-delete")); ?>?id=' + roleId;
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/currencies/currencies-list.blade.php ENDPATH**/ ?>