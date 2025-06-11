<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel" aria-labelledby="v-pills-General-tab">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-shield-alt me-2"></i><?php echo app('translator')->get('l.Security Settings'); ?>
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="<?php echo e(route('dashboard.admins.settings-update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row mt-5">
                    <div class="col-md-4 mb-3">
                        <label for="max_sessions" class="form-label"><?php echo app('translator')->get('l.Max Sessions'); ?> <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="<?php echo app('translator')->get('l.The maximum number of active sessions allowed for each user (number of login attempts at the same time)'); ?>"></i></label>
                        <input type="number" class="form-control" id="max_sessions" name="max_sessions"
                            value="<?php echo e(old('max_sessions', $settings['max_sessions'])); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="session_timeout" class="form-label"><?php echo app('translator')->get('l.Session Timeout (hours)'); ?> <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="<?php echo app('translator')->get('l.The time period in hours before the user session expires automatically in the event of inactivity'); ?>"></i></label>
                        <input type="number" class="form-control" id="session_timeout" name="session_timeout"
                            value="<?php echo e(old('session_timeout', $settings['session_timeout'])); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="max_attempts" class="form-label"><?php echo app('translator')->get('l.Max Login Attempts'); ?> <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="<?php echo app('translator')->get('l.The maximum number of failed login attempts before temporarily locking the account'); ?>"></i></label>
                        <input type="number" class="form-control" id="max_attempts" name="max_attempts"
                            value="<?php echo e(old('max_attempts', $settings['max_attempts'])); ?>">
                    </div>
                    <div class="col-md-12 mb-3 mt-4">
                        <label for="recaptcha" class="form-label"><?php echo app('translator')->get('l.Recaptcha'); ?></label>
                        <div class="d-flex align-items-center gap-4">
                            <div class="form-check form-switch">
                                <input type="hidden" name="recaptcha" value="0">
                                <input type="checkbox" class="form-check-input me-2" id="recaptcha" name="recaptcha" value="1"
                                    style="width: 3rem; height: 1.5rem;"
                                    <?php echo e(old('recaptcha', $settings['recaptcha']) ? 'checked' : ''); ?>>
                            </div>
                            <div>
                                <img src="<?php echo e(asset('assets/themes/default/img/icons/recaptcha.gif')); ?>" alt="Recaptcha Demo" class="img-fluid" style="max-width: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?php echo app('translator')->get('l.If you need help getting these credentials, please read our detailed guide at'); ?> <a href="<?php echo e(env('recaptcha_guide_url')); ?>" target="_blank"><?php echo app('translator')->get('l.Here'); ?></a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="recaptcha_site_key" class="form-label"><?php echo app('translator')->get('l.Recaptcha Site Key'); ?></label>
                        <input type="text" class="form-control" id="recaptcha_site_key" name="recaptcha_site_key"
                            value="<?php echo e(old('recaptcha_site_key', $settings['recaptcha_site_key'])); ?>"
                            <?php echo e(!old('recaptcha', $settings['recaptcha']) ? 'disabled' : ''); ?>>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="recaptcha_secret" class="form-label"><?php echo app('translator')->get('l.Recaptcha Secret Key'); ?></label>
                        <input type="text" class="form-control" id="recaptcha_secret" name="recaptcha_secret"
                            value="<?php echo e(old('recaptcha_secret', $settings['recaptcha_secret'])); ?>"
                            <?php echo e(!old('recaptcha', $settings['recaptcha']) ? 'disabled' : ''); ?>>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Save Changes'); ?></button>
            </form>
        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-ban me-2"></i><?php echo app('translator')->get('l.Blocked IPs'); ?>
            </h5>
            <button class="btn btn-info" data-bs-toggle="modal"
                data-bs-target="#addIpModal"><?php echo app('translator')->get('l.Add IP'); ?></button>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('l.IP Address'); ?></th>
                            <th><?php echo app('translator')->get('l.Created At'); ?></th>
                            <th><?php echo app('translator')->get('l.Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $ips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($ip->ip); ?></td>
                                <td><?php echo e($ip->created_at->format('Y-m-d H:i:s')); ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete-ip" data-id="<?php echo e(encrypt($ip->id)); ?>">
                                        <i class="fas fa-trash-alt me-1"></i> <?php echo app('translator')->get('l.Delete'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center"><?php echo app('translator')->get('l.No data found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding new IP -->
    <div class="modal fade" id="addIpModal" tabindex="-1" aria-labelledby="addIpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIpModalLabel"><?php echo app('translator')->get('l.Add New IP'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('dashboard.admins.firewalls-store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="ip" class="form-label"><?php echo app('translator')->get('l.IP Address'); ?></label>
                            <input type="text" class="form-control" id="ip" name="ip" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('l.Add IP'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('recaptcha').addEventListener('change', function() {
    const siteKeyInput = document.getElementById('recaptcha_site_key');
    const secretKeyInput = document.getElementById('recaptcha_secret');

    siteKeyInput.disabled = !this.checked;
    secretKeyInput.disabled = !this.checked;
});

// إضافة كود التحذير للحذف
document.querySelectorAll('.delete-ip').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const ipId = this.getAttribute('data-id');

        Swal.fire({
            title: '<?php echo app('translator')->get("l.Are you sure?"); ?>',
            text: '<?php echo app('translator')->get("l.You will be delete this forever!"); ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '<?php echo app('translator')->get("l.Yes, delete it!"); ?>',
            cancelButtonText: '<?php echo app('translator')->get("l.Cancel"); ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?php echo e(route('dashboard.admins.firewalls-delete')); ?>?id=${ipId}`;
            }
        });
    });
});
</script>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/security.blade.php ENDPATH**/ ?>