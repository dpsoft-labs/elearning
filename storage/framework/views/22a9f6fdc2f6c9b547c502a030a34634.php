<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel" aria-labelledby="v-pills-General-tab">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-code me-2"></i><?php echo app('translator')->get('l.Coding settings'); ?>
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="<?php echo e(route('dashboard.admins.settings-update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Header Code Section -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-arrow-up me-1"></i><?php echo app('translator')->get('l.headerCode'); ?>
                            </label>
                            <textarea class="form-control code-editor" name="headerCode"
                                rows="8" placeholder="<?php echo app('translator')->get('l.Enter header code here...'); ?>"
                                style="font-family: monospace;"><?php echo e($settings['headerCode'] ?? ''); ?></textarea>
                            <small class="text-muted">
                                <?php echo app('translator')->get('l.This code is added to the header of the page'); ?>
                                <code>&lt;head&gt;</code>
                            </small>
                        </div>

                        <!-- Footer Code Section -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-arrow-down me-1"></i><?php echo app('translator')->get('l.footerCode'); ?>
                            </label>
                            <textarea class="form-control code-editor" name="footerCode"
                                rows="8" placeholder="<?php echo app('translator')->get('l.Enter footer code here...'); ?>"
                                style="font-family: monospace;"><?php echo e($settings['footerCode'] ?? ''); ?></textarea>
                            <small class="text-muted">
                                <?php echo app('translator')->get('l.This code is added to the footer of the page'); ?>
                                <code>&lt;/body&gt;</code>
                            </small>
                        </div>
                    </div>

                    <!-- Control Buttons -->
                    <div class="col-12 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-1"></i> <?php echo app('translator')->get('l.Save Changes'); ?>
                        </button>
                        <a href="<?php echo e(route('dashboard.admins.settings')); ?>" class="btn btn-outline-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-1"></i> <?php echo app('translator')->get('l.Back'); ?>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this to your layout file or at the bottom of this file -->
<style>
.code-editor {
    background-color: #f8f9fabe;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    transition: all 0.3s ease;
    color: #000000bd;
}

.code-editor:focus {
    background-color: #fff;
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    color: #000;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>


<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/coding.blade.php ENDPATH**/ ?>