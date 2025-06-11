<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center py-5 mb-5 ">
            <h5 class="mb-0 text-white">
                <i class="fas fa-download me-2"></i><?php echo app('translator')->get('l.Updates & Backups'); ?>
            </h5>
        </div>

        <!-- بداية التبويبات -->
        <ul class="nav nav-pills nav-fill mt-3 mx-3" id="notificationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates"
                    type="button" role="tab">
                    <i class="fas fa-sync me-2"></i><?php echo app('translator')->get('l.Updates'); ?>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="backups-tab" data-bs-toggle="tab" data-bs-target="#backups" type="button"
                    role="tab">
                    <i class="fas fa-database me-2"></i><?php echo app('translator')->get('l.Backups'); ?>
                </button>
            </li>
        </ul>

        <!-- محتوى التبويبات -->
        <div class="tab-content p-3" id="notificationTabsContent">

            <!-- إضافة محتوى تبويب النسخ الاحتياطية -->
            <div class="tab-pane fade" id="backups" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <button class="btn btn-info" id="createBackupBtn">
                                <i class="fas fa-plus me-2"></i><?php echo app('translator')->get('l.Create New Backup'); ?>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo app('translator')->get('l.Filename'); ?></th>
                                        <th><?php echo app('translator')->get('l.Size'); ?> (MB)</th>
                                        <th><?php echo app('translator')->get('l.Created At'); ?></th>
                                        <th><?php echo app('translator')->get('l.Actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($backup['name']); ?></td>
                                            <td><?php echo e($backup['size']); ?></td>
                                            <td><?php echo e($backup['date']); ?></td>
                                            <td>
                                                <a href="<?php echo e(asset('backup/laravel/' . $backup['name'])); ?>"
                                                    class="btn btn-sm btn-info" download>
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('<?php echo e($backup['name']); ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center"><?php echo app('translator')->get('l.No backups found'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('createBackupBtn').addEventListener('click', function() {
            createBackup();
        });
    });

    function createBackup() {
        Swal.fire({
            title: '<?php echo app('translator')->get('l.Confirm Backup'); ?>',
            text: '<?php echo app('translator')->get('l.Are you sure you want to create a new backup? This may take several minutes.'); ?>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?php echo app('translator')->get('l.Yes, create it!'); ?>',
            cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '<?php echo app('translator')->get('l.Creating Backup'); ?>',
                    text: '<?php echo app('translator')->get('l.This may take several minutes'); ?>',
                    icon: 'info',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        setTimeout(function() {
                            window.location.href = "<?php echo e(route('dashboard.admins.backup-take')); ?>";
                        }, 500);
                    }
                });
            }
        });
    }

    function confirmDelete(backupName) {
        Swal.fire({
            title: '<?php echo app('translator')->get('l.Are you sure?'); ?>',
            text: '<?php echo app('translator')->get("l.You won\'t be able to revert this!"); ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '<?php echo app('translator')->get('l.Yes, delete it!'); ?>',
            cancelButtonText: '<?php echo app('translator')->get('l.Cancel'); ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo e(route('dashboard.admins.backup-delete')); ?>?backup=" + backupName;
            }
        });
    }
</script>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/update.blade.php ENDPATH**/ ?>