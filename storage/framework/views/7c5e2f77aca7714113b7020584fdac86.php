<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel" aria-labelledby="v-pills-General-tab">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?php echo app('translator')->get('l.General Settings'); ?></h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('dashboard.admins.settings-update')); ?>" method="POST" enctype="multipart/form-data" id="settingsForm">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <!-- معلومات الموقع الأساسية -->
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label"><?php echo app('translator')->get('l.Site Name'); ?></label>
                            <input type="text" class="form-control" name="name" required
                                value="<?php echo e($settings['name'] ?? ''); ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><?php echo app('translator')->get('l.Site Domain'); ?></label>
                            <input type="url" class="form-control" name="domain" required
                                value="<?php echo e($settings['domain'] ?? ''); ?>"
                                pattern="^https://[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$"
                                placeholder="https://example.com"
                                title="Enter a valid domain starting with https:// (e.g. https://example.com)"
                                oninput="validateDomain(this)">
                            <div class="invalid-feedback">Domain must start with https:// not http://</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><?php echo app('translator')->get('l.Site Description'); ?></label>
                            <textarea class="form-control" name="description" required
                                rows="3"><?php echo e($settings['description'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <!-- الشعارات والصور -->
                    <div class="col-md-4">
                        <div class="text-center mb-4">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                <img src="<?php echo e(asset($settings['logo'] ?? 'placeholder.png')); ?>" class="img-fluid current-image" width="180"
                                    style="max-height: 100px" alt="Current Logo">
                                <div class="preview-arrow d-none">
                                    <i class="fas fa-arrow-right fs-3 text-primary"></i>
                                </div>
                                <img src="" class="img-fluid d-none new-preview" id="logoPreview"
                                    style="max-height: 100px" alt="New Logo">
                            </div>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-2"><?php echo app('translator')->get('l.Recommended size: 850x179 pixels'); ?></small>
                                <label class="btn btn-primary btn-sm">
                                    <i class="fas fa-upload"></i> <?php echo app('translator')->get('l.Upload Logo'); ?>
                                    <input type="file" name="logo" class="d-none image-preview" accept="image/*"
                                        data-preview="logoPreview" data-container="logo-container"
                                        data-width="850" data-height="179">
                                </label>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                <img src="<?php echo e(asset($settings['favicon'] ?? 'placeholder.png')); ?>" class="img-fluid"
                                    style="max-height: 50px" alt="Current Favicon">
                                <div class="preview-arrow d-none">
                                    <i class="fas fa-arrow-right fs-3 text-info"></i>
                                </div>
                                <img src="" class="img-fluid d-none new-preview" id="faviconPreview"
                                    style="max-height: 50px" alt="New Favicon">
                            </div>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-2"><?php echo app('translator')->get('l.Recommended size: 500x500 pixels (square)'); ?></small>
                                <label class="btn btn-info btn-sm">
                                    <i class="fas fa-upload"></i> <?php echo app('translator')->get('l.Upload Favicon'); ?>
                                    <input type="file" name="favicon" class="d-none image-preview" accept="image/*"
                                        data-preview="faviconPreview" data-container="favicon-container"
                                        data-width="500" data-height="500">
                                </label>
                            </div>
                        </div>

                        <!-- تحميل شعار اللوجو البلاك -->
                        <div class="text-center mt-4">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                <img src="<?php echo e(asset($settings['logo_black'] ?? 'placeholder.png')); ?>" class="img-fluid current-image" width="180"
                                    style="max-height: 100px" alt="Current Black Logo">
                                <div class="preview-arrow d-none">
                                    <i class="fas fa-arrow-right fs-3 text-secondary"></i>
                                </div>
                                <img src="" class="img-fluid d-none new-preview" id="logoBlackPreview"
                                    style="max-height: 100px" alt="New Black Logo">
                            </div>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-2"><?php echo app('translator')->get('l.Recommended size: 850x179 pixels'); ?></small>
                                <label class="btn btn-secondary btn-sm">
                                    <i class="fas fa-upload"></i> <?php echo app('translator')->get('l.Upload Black Logo'); ?>
                                    <input type="file" name="logo_black" class="d-none image-preview" accept="image/*"
                                        data-preview="logoBlackPreview" data-container="logo-black-container"
                                        data-width="850" data-height="179">
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- إعدادات اللغة والعملة -->
                    <div class="col-md-12 mt-4">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo app('translator')->get('l.Please note if you change the default currency this will affect the currency of the site and all products in the site, so please update the prices after changing the default currency'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <h6 class="mb-3"><?php echo app('translator')->get('l.Language and Currency Settings'); ?></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="default_language"><?php echo app('translator')->get('l.Default Language'); ?></label>
                                    <select class="select2 form-select" name="default_language" id="default_language">
                                        <?php $__currentLoopData = $headerLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($language->code); ?>"
                                                <?php echo e(($settings['default_language'] ?? '') == $language->code ? 'selected' : ''); ?>>
                                                <?php echo e($language->name . ' (' . $language->native . ')'); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="default_currency"><?php echo app('translator')->get('l.Default Currency'); ?></label>
                                    <select class="select2 form-select" name="default_currency" id="default_currency">
                                        <?php $__currentLoopData = $headerCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($currency->code); ?>"
                                                <?php echo e(($settings['default_currency'] ?? '') == $currency->code ? 'selected' : ''); ?>>
                                                <?php echo e($currency->name . ' (' . $currency->symbol . ' - ' . strtoupper($currency->code) . ')'); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="timezone"><?php echo app('translator')->get('l.Timezone'); ?></label>
                                    <select class="select2 form-select" name="timezone" id="timezone">
                                        <?php $__currentLoopData = DateTimeZone::listIdentifiers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($timezone); ?>"
                                                <?php echo e(($settings['timezone'] ?? '') == $timezone ? 'selected' : ''); ?>>
                                                <?php echo e($timezone); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- إعدادات التسجيل -->
                    <div class="col-12 mt-4">
                        <h6 class="mb-3"><?php echo app('translator')->get('l.Additional Settings'); ?></h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-4 d-flex align-items-center">
                                    <label class="form-label me-3 mb-0" for="multistep_register"><?php echo app('translator')->get('l.Multistep Registration Form'); ?></label>
                                    <i class="fas fa-info-circle me-2" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo app('translator')->get('l.Enable this option to split the registration form into multiple steps for better user experience'); ?>"></i>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="multistep_register" value="0">
                                        <input type="checkbox" class="form-check-input" style="width: 3em; height: 1.5em;"
                                               name="multistep_register" id="multistep_register" value="1"
                                               <?php echo e(($settings['multistep_register'] ?? 0) == 1 ? 'checked' : ''); ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-4 d-flex align-items-center">
                                    <label class="form-label me-3 mb-0" for="emailVerified"><?php echo app('translator')->get('l.Email Verification'); ?></label>
                                    <i class="fas fa-info-circle me-2" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo app('translator')->get('l.Enable this option to require email verification before users can access their accounts, so you should update the SMTP email settings in the email settings tab'); ?>"></i>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="emailVerified" value="0">
                                        <input type="checkbox" class="form-check-input" style="width: 3em; height: 1.5em;"
                                               name="emailVerified" id="emailVerified" value="1"
                                               <?php echo e(($settings['emailVerified'] ?? 0) == 1 ? 'checked' : ''); ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-4 d-flex align-items-center">
                                    <label class="form-label me-3 mb-0" for="maintenance"><?php echo app('translator')->get('l.Maintenance Mode'); ?></label>
                                    <i class="fas fa-info-circle me-2" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo app('translator')->get('l.Enable this option to put the site in maintenance mode, so the site will be in maintenance mode and will not be accessible to the public(only admins can access the site)'); ?>"></i>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="maintenance" value="0">
                                        <input type="checkbox" class="form-check-input" style="width: 3em; height: 1.5em;"
                                               name="maintenance" id="maintenance" value="1"
                                               <?php echo e(($settings['maintenance'] ?? 0) == 1 ? 'checked' : ''); ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-4 d-flex align-items-center">
                                    <label class="form-label me-3 mb-0" for="can_any_register"><?php echo app('translator')->get('l.Can Any Register'); ?></label>
                                    <i class="fas fa-info-circle me-2" data-bs-toggle="tooltip" data-bs-offset="0,8" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-original-title="<?php echo app('translator')->get('l.Enable this option to allow any user to register, so the user will be able to register without the need to be approved by the admin'); ?>"></i>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="can_any_register" value="0">
                                        <input type="checkbox" class="form-check-input" style="width: 3em; height: 1.5em;"
                                               name="can_any_register" id="can_any_register" value="1"
                                               <?php echo e(($settings['can_any_register'] ?? 0) == 1 ? 'checked' : ''); ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- إعدادات الاكاديمية -->
                    <div class="col-12 mt-4">
                        <h6 class="mb-3"><?php echo app('translator')->get('l.Academic Settings'); ?></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="admission_status"><?php echo app('translator')->get('l.Admission Status'); ?></label>
                                    <select class="select2 form-select" name="admission_status" id="admission_status">
                                        <option value="1" <?php echo e(($settings['admission_status'] ?? 0) == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Open'); ?></option>
                                        <option value="0" <?php echo e(($settings['admission_status'] ?? 0) == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Close'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="registration_status"><?php echo app('translator')->get('l.Registration Status'); ?></label>
                                    <select class="select2 form-select" name="registration_status" id="registration_status">
                                        <option value="1" <?php echo e(($settings['registration_status'] ?? 0) == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Open'); ?></option>
                                        <option value="0" <?php echo e(($settings['registration_status'] ?? 0) == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('l.Close'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="registration_start_date"><?php echo app('translator')->get('l.Registration Start Date'); ?></label>
                                    <input type="date" class="form-control" name="registration_start_date" id="registration_start_date" value="<?php echo e($settings['registration_start_date'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="registration_end_date"><?php echo app('translator')->get('l.Registration End Date'); ?></label>
                                    <input type="date" class="form-control" name="registration_end_date" id="registration_end_date" value="<?php echo e($settings['registration_end_date'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="when_enable_content"><?php echo app('translator')->get('l.When Enable Content'); ?></label>
                                    <select class="select2 form-select" name="when_enable_content" id="when_enable_content">
                                        <option value="after_registration" <?php echo e(($settings['when_enable_content'] ?? 0) == 'after_registration' ? 'selected' : ''); ?>><?php echo app('translator')->get('l.After Registration'); ?></option>
                                        <option value="after_paid" <?php echo e(($settings['when_enable_content'] ?? 0) == 'after_paid' ? 'selected' : ''); ?>><?php echo app('translator')->get('l.After Paid'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="hour_price"><?php echo app('translator')->get('l.Hour Price'); ?></label>
                                    <input type="number" class="form-control" name="hour_price" id="hour_price" value="<?php echo e($settings['hour_price'] ?? 0); ?>">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="min_hours"><?php echo app('translator')->get('l.Min Hours'); ?></label>
                                    <input type="number" class="form-control" name="min_hours" id="min_hours" value="<?php echo e($settings['min_hours'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="max_hours"><?php echo app('translator')->get('l.Max Hours'); ?></label>
                                    <input type="number" class="form-control" name="max_hours" id="max_hours" value="<?php echo e($settings['max_hours'] ?? 0); ?>">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <h6 class="mb-3"><?php echo app('translator')->get('l.GPA Settings'); ?></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_4"><?php echo app('translator')->get('l.GPA'); ?> 4.0</label>
                                    <input type="number" class="form-control" name="gpa_4" id="gpa_4" value="<?php echo e($settings['gpa_4'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_3_6"><?php echo app('translator')->get('l.GPA'); ?> 3.6</label>
                                    <input type="number" class="form-control" name="gpa_3_6" id="gpa_3_6" value="<?php echo e($settings['gpa_3_6'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_3_2"><?php echo app('translator')->get('l.GPA'); ?> 3.2</label>
                                    <input type="number" class="form-control" name="gpa_3_2" id="gpa_3_2" value="<?php echo e($settings['gpa_3_2'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_3_0"><?php echo app('translator')->get('l.GPA'); ?> 3.0</label>
                                    <input type="number" class="form-control" name="gpa_3_0" id="gpa_3_0" value="<?php echo e($settings['gpa_3_0'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_2_7"><?php echo app('translator')->get('l.GPA'); ?> 2.7</label>
                                    <input type="number" class="form-control" name="gpa_2_7" id="gpa_2_7" value="<?php echo e($settings['gpa_2_7'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_2_5"><?php echo app('translator')->get('l.GPA'); ?> 2.5</label>
                                    <input type="number" class="form-control" name="gpa_2_5" id="gpa_2_5" value="<?php echo e($settings['gpa_2_5'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_2_2"><?php echo app('translator')->get('l.GPA'); ?> 2.2</label>
                                    <input type="number" class="form-control" name="gpa_2_2" id="gpa_2_2" value="<?php echo e($settings['gpa_2_2'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label" for="gpa_2_0"><?php echo app('translator')->get('l.GPA'); ?> 2.0</label>
                                    <input type="number" class="form-control" name="gpa_2_0" id="gpa_2_0" value="<?php echo e($settings['gpa_2_0'] ?? 0); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> <?php echo app('translator')->get('l.Save Changes'); ?>
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo me-1"></i> <?php echo app('translator')->get('l.Reset'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateDomain(input) {
    const value = input.value.trim();

    // التحقق من بدء الدومين بـ https:// وعدم انتهائه بـ /
    const isValid = /^https:\/\/[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/.test(value);

    if (!isValid) {
        if (value.startsWith('http://')) {
            input.setCustomValidity('domain must start with https:// not http://');
        } else if (value.endsWith('/')) {
            input.setCustomValidity('domain should not end with a slash /');
        } else {
            input.setCustomValidity('Enter a valid domain starting with https:// and not ending with /');
        }
        input.classList.add('is-invalid');
        return false;
    } else {
        input.setCustomValidity('');
        input.classList.remove('is-invalid');
        return true;
    }
}

function validateForm() {
    // التحقق من صحة الدومين
    const domainInput = document.querySelector('input[name="domain"]');
    if (domainInput) {
        if (!validateDomain(domainInput)) {
            domainInput.focus();
            // عرض رسالة خطأ واضحة
            const errorMsg = domainInput.value.startsWith('http://') ?
                'domain must start with https:// not http://' :
                (domainInput.value.endsWith('/') ?
                    'domain should not end with a slash /' :
                    'Enter a valid domain starting with https:// and not ending with /');

            // إظهار الرسالة للمستخدم
            if (document.querySelector('.domain-error-alert')) {
                document.querySelector('.domain-error-alert').remove();
            }

            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger mt-2 domain-error-alert';
            alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + errorMsg;
            domainInput.parentNode.appendChild(alertDiv);

            return false;
        }
    }

    // التحقق من أحجام الصور
    const imageInputs = document.querySelectorAll('input[type="file"].image-preview');
    for (let i = 0; i < imageInputs.length; i++) {
        if (imageInputs[i].files && imageInputs[i].files.length > 0) {
            if (!validateImageSize(imageInputs[i])) {
                return false;
            }
        }
    }

    return true;
}

// التحقق من حجم الصورة
function validateImageSize(fileInput) {
    if (!fileInput.files || !fileInput.files[0]) return true;

    const file = fileInput.files[0];
    const maxSize = 1 * 1024 * 1024; // 1 ميجابايت

    if (file.size > maxSize) {
        // إظهار رسالة خطأ
        const container = fileInput.closest('.text-center');

        // إزالة أي رسالة خطأ سابقة
        if (container.querySelector('.image-error-alert')) {
            container.querySelector('.image-error-alert').remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger mt-2 image-error-alert';
        alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <?php echo app('translator')->get('l.Image size must not exceed 1 MB'); ?>';
        container.appendChild(alertDiv);

        // إفراغ حقل الصورة
        fileInput.value = '';

        // إخفاء المعاينة
        const previewId = fileInput.dataset.preview;
        if (previewId) {
            const preview = document.getElementById(previewId);
            preview.src = '';
            preview.classList.add('d-none');
        }

        // إخفاء سهم المعاينة
        const arrow = fileInput.closest('.text-center').querySelector('.preview-arrow');
        if (arrow) {
            arrow.classList.add('d-none');
        }

        return false;
    }

    // إزالة رسالة الخطأ إذا كان الحجم صحيحًا
    const container = fileInput.closest('.text-center');
    if (container.querySelector('.image-error-alert')) {
        container.querySelector('.image-error-alert').remove();
    }

    return true;
}

// التحقق من أبعاد الصورة
function validateImageDimensions(fileInput) {
    if (!fileInput.files || !fileInput.files[0]) return true;

    // التحقق مما إذا كانت هناك أبعاد محددة للتحقق منها
    if (!fileInput.dataset.width || !fileInput.dataset.height) return true;

    const requiredWidth = parseInt(fileInput.dataset.width);
    const requiredHeight = parseInt(fileInput.dataset.height);

    return new Promise((resolve) => {
        const file = fileInput.files[0];
        const img = new Image();
        img.onload = function() {
            const width = this.width;
            const height = this.height;

            // التحقق من الأبعاد
            if (width !== requiredWidth || height !== requiredHeight) {
                // إظهار رسالة خطأ
                const container = fileInput.closest('.text-center');

                // إزالة أي رسالة خطأ سابقة
                if (container.querySelector('.dimension-error-alert')) {
                    container.querySelector('.dimension-error-alert').remove();
                }

                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-warning mt-2 dimension-error-alert';
                alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <?php echo app('translator')->get('l.Recommended image dimensions are'); ?> ${requiredWidth}x${requiredHeight} <?php echo app('translator')->get('l.pixels'); ?>. <?php echo app('translator')->get('l.Current dimensions'); ?> ${width}x${height} <?php echo app('translator')->get('l.pixels'); ?>.`;
                container.appendChild(alertDiv);

                resolve(false);
            } else {
                // إزالة رسالة الخطأ إذا كانت الأبعاد صحيحة
                const container = fileInput.closest('.text-center');
                if (container.querySelector('.dimension-error-alert')) {
                    container.querySelector('.dimension-error-alert').remove();
                }

                resolve(true);
            }
        };

        img.onerror = function() {
            resolve(true); // لا يوجد سبب للفشل هنا، دع التحقق من نوع الملف يتعامل مع هذا
        };

        img.src = URL.createObjectURL(file);
    });
}

// تنفيذ التحقق عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    const domainInput = document.querySelector('input[name="domain"]');
    if (domainInput) {
        // التحقق المباشر عند الكتابة
        domainInput.addEventListener('input', function() {
            validateDomain(this);
            // إزالة رسالة الخطأ إذا كان المدخل صحيحًا
            if (document.querySelector('.domain-error-alert') && validateDomain(this)) {
                document.querySelector('.domain-error-alert').remove();
            }
        });

        // التحقق الأولي
        validateDomain(domainInput);
    }

    // إضافة مستمع للتحقق من حجم الصور
    const imageInputs = document.querySelectorAll('input[type="file"].image-preview');
    imageInputs.forEach(input => {
        input.addEventListener('change', async function() {
            // التحقق من حجم الصورة
            if (!validateImageSize(this)) return;

            // التحقق من أبعاد الصورة
            await validateImageDimensions(this);

            // إظهار معاينة الصورة إذا كان الحجم مناسبًا
            const previewId = this.dataset.preview;
            if (previewId && this.files && this.files[0]) {
                const preview = document.getElementById(previewId);
                preview.src = URL.createObjectURL(this.files[0]);
                preview.classList.remove('d-none');

                // إظهار سهم المعاينة
                const arrow = this.closest('.text-center').querySelector('.preview-arrow');
                if (arrow) {
                    arrow.classList.remove('d-none');
                }
            }
        });
    });

    // إعداد التحقق عند تقديم النموذج
    const settingsForm = document.getElementById('settingsForm');
    if (settingsForm) {
        settingsForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // التحقق من صحة الإدخال
            if (!validateForm()) {
                return false;
            }

            // التحقق من أبعاد الصور
            const imageInputs = document.querySelectorAll('input[type="file"].image-preview');
            let allDimensionsValid = true;

            // معالجة التحققات غير المتزامنة
            const checks = [];

            for (let i = 0; i < imageInputs.length; i++) {
                if (imageInputs[i].files && imageInputs[i].files.length > 0) {
                    checks.push(validateImageDimensions(imageInputs[i]));
                }
            }

            // انتظار جميع التحققات
            if (checks.length > 0) {
                const results = await Promise.all(checks);
                // التحقق من أن جميع النتائج صحيحة
                allDimensionsValid = results.every(result => result === true);
            }

            // تقديم النموذج إذا كان كل شيء صحيحًا
            if (allDimensionsValid) {
                this.submit();
            } else {
                // إظهار رسالة تنبيه
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger mt-2';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <?php echo app('translator')->get('l.Please check the image dimensions'); ?>';
                alertDiv.id = 'dimensions-alert';

                // إزالة أي تنبيه سابق
                if (document.getElementById('dimensions-alert')) {
                    document.getElementById('dimensions-alert').remove();
                }

                // إضافة التنبيه في بداية النموذج
                const firstElement = this.querySelector('.row');
                this.insertBefore(alertDiv, firstElement);

                // تمرير للعنصر المحدد
                alertDiv.scrollIntoView({ behavior: 'smooth' });

                return false;
            }
        });
    }
});
</script>
<?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/general.blade.php ENDPATH**/ ?>