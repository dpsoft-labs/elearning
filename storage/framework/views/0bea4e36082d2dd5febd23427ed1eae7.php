<?php $__env->startSection('title'); ?>
    <?php echo e(__('l.College Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show colleges')): ?>
            <div class="row">
                <div class="col-12">
                    <h5 class="card-title"><?php echo e(__('l.College Details')); ?></h5>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><?php echo e($college->name); ?></h5>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit colleges')): ?>
                                <a href="<?php echo e(route('dashboard.admins.colleges-edit', ['id' => encrypt($college->id)])); ?>"
                                   class="btn btn-primary">
                                    <i class="fa fa-edit me-1"></i><?php echo e(__('l.Edit')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6><?php echo e(__('l.Name')); ?></h6>
                                    <p><?php echo e($college->name); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6><?php echo e(__('l.Email')); ?></h6>
                                    <p><?php echo e($college->email); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6><?php echo e(__('l.Phone')); ?></h6>
                                    <p><?php echo e($college->phone); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6><?php echo e(__('l.Address')); ?></h6>
                                    <p><?php echo e($college->address); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6><?php echo e(__('l.Students Count')); ?></h6>
                                    <p><?php echo e($college->students->count()); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6><?php echo e(__('l.Created At')); ?></h6>
                                    <p><?php echo e($college->created_at->format('Y-m-d H:i')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(__('l.Students in this College')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="students-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('l.Name')); ?></th>
                                            <th><?php echo e(__('l.Email')); ?></th>
                                            <th><?php echo e(__('l.Phone')); ?></th>
                                            <th><?php echo e(__('l.Branch')); ?></th>
                                            <th><?php echo e(__('l.Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $college->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($index + 1); ?></td>
                                                <td><?php echo e($student->firstname); ?> <?php echo e($student->lastlname); ?></td>
                                                <td><?php echo e($student->email); ?></td>
                                                <td><?php echo e($student->phone ?? '-'); ?></td>
                                                <td><?php echo e($student->branch->name ?? '-'); ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show students')): ?>
                                                            <a href="<?php echo e(route('dashboard.admins.students-show', ['id' => encrypt($student->id)])); ?>"
                                                               class="btn btn-sm btn-info me-1" title="<?php echo e(__('l.View')); ?>">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(function() {
            $('#students-table').DataTable({
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/colleges/colleges-show.blade.php ENDPATH**/ ?>