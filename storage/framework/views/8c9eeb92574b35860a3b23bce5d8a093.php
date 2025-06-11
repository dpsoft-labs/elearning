<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel" aria-labelledby="v-pills-General-tab">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-phone me-2"></i><?php echo app('translator')->get('l.Contact settings'); ?>
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="<?php echo e(route('dashboard.admins.settings-update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="form-group col-md-6">
                                        <label for="email1" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Email'); ?> 1
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['email1']); ?>"
                                                id="email1" name="email1" placeholder="<?php echo app('translator')->get('l.Email 1'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email2" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Email'); ?> 2
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['email2']); ?>"
                                                id="email2" name="email2" placeholder="<?php echo app('translator')->get('l.Email 2'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone1" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Phone'); ?> 1
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['phone1']); ?>"
                                                id="phone1" name="phone1" placeholder="<?php echo app('translator')->get('l.Phone'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone2" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Phone'); ?> 2
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['phone2']); ?>"
                                                id="phone2" name="phone2" placeholder="<?php echo app('translator')->get('l.Phone'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="siteWhatsapp" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Whatsapp'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['whatsapp']); ?>"
                                                id="siteWhatsapp" name="whatsapp" placeholder="<?php echo app('translator')->get('l.Whatsapp'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="facebook" class="form-label fw-medium">
                                            </i><?php echo app('translator')->get('l.Facebook'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['facebook']); ?>"
                                                id="facebook" name="facebook" placeholder="<?php echo app('translator')->get('l.Facebook'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Twitter'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['twitter']); ?>"
                                                id="twitter" name="twitter" placeholder="<?php echo app('translator')->get('l.Twitter'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="instagram" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Instagram'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['instagram']); ?>"
                                                id="instagram" name="instagram" placeholder="<?php echo app('translator')->get('l.Instagram'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="youtube" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Youtube'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['youtube']); ?>"
                                                id="youtube" name="youtube" placeholder="<?php echo app('translator')->get('l.Youtube'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="linkedin" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Linkedin'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['linkedin']); ?>"
                                                id="linkedin" name="linkedin" placeholder="<?php echo app('translator')->get('l.Linkedin'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="play_store_link" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Play Store Link'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-play"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['play_store_link']); ?>"
                                                id="play_store_link" name="play_store_link" placeholder="<?php echo app('translator')->get('l.Play Store Link'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="app_store_link" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.App Store Link'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-apple"></i></span>
                                            <input type="text" class="form-control" value="<?php echo e($settings['app_store_link']); ?>"
                                                id="app_store_link" name="app_store_link" placeholder="<?php echo app('translator')->get('l.App Store Link'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="address" class="form-label fw-medium">
                                            <?php echo app('translator')->get('l.Address'); ?>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <textarea class="form-control" id="address" rows="4" name="address"><?php echo e($settings['address']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/contact.blade.php ENDPATH**/ ?>