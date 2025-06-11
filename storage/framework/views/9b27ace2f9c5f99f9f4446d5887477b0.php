<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Payments Gateways List'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .payment-gateway-icon {
            height: 140px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .status-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-active {
            background-color: #28a745;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
        }

        .status-inactive {
            background-color: #dc3545;
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.5);
        }

        .payment-gateway-icon img {
            max-height: 100px;
            width: auto;
            object-fit: contain;
            transition: transform 0.2s ease;
        }

        .card {
            height: 100%;
            transition: transform 0.2s ease;
            border-radius: 12px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .payment-details {
            background-color: rgba(0, 0, 0, 0.02);
            padding: 12px;
            border-radius: 8px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><?php echo app('translator')->get('l.Payment Gateways'); ?> /</span> <?php echo app('translator')->get('l.List'); ?></h4>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show settings')): ?>
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($error); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <div class="row g-4">
                <?php $__currentLoopData = $payments->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100">
                            <div class="status-indicator <?php echo e($method->status == '1' ? 'status-active' : 'status-inactive'); ?>">
                            </div>
                            <div class="payment-gateway-icon">
                                <img src="<?php echo e(asset($method->image)); ?>" alt="<?php echo app('translator')->get('payment_methods.' . $method->name); ?>" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center mb-3 capital"><?php echo e(Str::title($method->name)); ?></h5>

                                <div class="payment-details">
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted"><?php echo app('translator')->get('l.Status'); ?>:</span>
                                        <?php if($method->status == '1'): ?>
                                            <span class="badge bg-success"><?php echo app('translator')->get('l.Active'); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?php echo app('translator')->get('l.Inactive'); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted"><?php echo app('translator')->get('l.Fees'); ?>:</span>
                                        <?php if($method->fees_type == 'fixed'): ?>
                                            <span><?php echo e($method->fees); ?> <?php echo e(strtoupper($settings['default_currency'])); ?></span>
                                        <?php else: ?>
                                            <span><?php echo e($method->fees); ?>%</span>
                                        <?php endif; ?>
                                    </div>

                                    <p class="card-text text-muted small mb-3">
                                        <?php echo e(Str::limit($method->description, 75)); ?>

                                    </p>
                                </div>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                                    <div class="text-center mt-3">
                                        <button data-bs-target="#model-<?php echo e($method->name); ?>" data-bs-toggle="modal"
                                            title="<?php echo app('translator')->get('l.Edit'); ?>" class="edit-<?php echo e($method->name); ?> btn btn-info">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button data-bs-target="#model-translate-<?php echo e($method->name); ?>" data-bs-toggle="modal"
                                            title="<?php echo app('translator')->get('l.Translate'); ?>" class="translate-<?php echo e($method->name); ?> btn btn-dark ">
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <g fill="currentColor">
                                                    <path d="M7.75 2.75a.75.75 0 0 0-1.5 0v1.258a32.987 32.987 0 0 0-3.599.278a.75.75 0 1 0 .198 1.487A31.545 31.545 0 0 1 8.7 5.545A19.381 19.381 0 0 1 7 9.56a19.418 19.418 0 0 1-1.002-2.05a.75.75 0 0 0-1.384.577a20.935 20.935 0 0 0 1.492 2.91a19.613 19.613 0 0 1-3.828 4.154a.75.75 0 1 0 .945 1.164A21.116 21.116 0 0 0 7 12.331c.095.132.192.262.29.391a.75.75 0 0 0 1.194-.91a18.97 18.97 0 0 1-.59-.815a20.888 20.888 0 0 0 2.333-5.332c.31.031.618.068.924.108a.75.75 0 0 0 .198-1.487a32.832 32.832 0 0 0-3.599-.278V2.75Z"></path>
                                                    <path fill-rule="evenodd" d="M13 8a.75.75 0 0 1 .671.415l4.25 8.5a.75.75 0 1 1-1.342.67L15.787 16h-5.573l-.793 1.585a.75.75 0 1 1-1.342-.67l4.25-8.5A.75.75 0 0 1 13 8Zm2.037 6.5L13 10.427L10.964 14.5h4.073Z" clip-rule="evenodd"></path>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit settings')): ?>
                        <!--  مودل التعديل -->
                        <div class="modal fade" id="model-<?php echo e($method->name); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role"
                                style="justify-content: center;">
                                <div class="modal-content p-3 p-md-5 col-md-8">
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title mb-2"><?php echo app('translator')->get('l.Edit'); ?> <span style="color:red;">
                                                    <?php echo e(strtoupper($method->name)); ?></span>
                                            </h3>
                                        </div>
                                        <form id="addProductForm" class="row g-3" method="post" enctype="multipart/form-data"
                                            action="<?php echo e(route('dashboard.admins.payments-update')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label" for="status"><?php echo app('translator')->get('l.Status'); ?></label>
                                                    <select id="status" class="form-select" name="status" required>
                                                        <option value="1" <?php echo e($method->status == 1 ? 'selected' : ''); ?>>
                                                            <?php echo app('translator')->get('l.Active'); ?>
                                                        </option>
                                                        <option value="0" <?php echo e($method->status == 0 ? 'selected' : ''); ?>>
                                                            <?php echo app('translator')->get('l.Inactive'); ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label" for="fees_type"><?php echo app('translator')->get('l.Fees Type'); ?></label>
                                                    <select id="fees_type" class="form-select" name="fees_type" required>
                                                        <option value="percentage"
                                                            <?php echo e($method->fees_type == 'percentage' ? 'selected' : ''); ?>>
                                                            <?php echo app('translator')->get('l.Percentage'); ?>
                                                        </option>
                                                        <option value="fixed"
                                                            <?php echo e($method->fees_type == 'fixed' ? 'selected' : ''); ?>>
                                                            <?php echo app('translator')->get('l.Fixed'); ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label" for="fees"><?php echo app('translator')->get('l.Fees Amount'); ?></label>
                                                    <input type="text" id="fees" name="fees" class="form-control"
                                                        value="<?php echo e($method->fees); ?>" placeholder="<?php echo app('translator')->get('l.Enter a method fees or percentage'); ?>" />
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="description"><?php echo app('translator')->get('l.Description'); ?>
                                                        <small class="text-muted">(<?php echo e($defaultLanguage->name); ?> <i
                                                                class="fi fi-<?php echo e($defaultLanguage->flag); ?> rounded"></i>)</small>
                                                    </label>
                                                    <input type="text" id="description" name="description" class="form-control"
                                                        value="<?php echo e($method->description); ?>" placeholder="<?php echo app('translator')->get('l.Enter a method description'); ?>" />
                                                </div>
                                                <?php $__currentLoopData = $method->settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-12 mb-4">
                                                        <label class="form-label" for="<?php echo e($setting->key); ?>">
                                                            <?php if($setting->key == 'CASH_ON_DELIVERY'): ?>
                                                                <?php echo app('translator')->get('l.Cash on Delivery static Fee'); ?>
                                                            <?php else: ?>
                                                                <?php echo e($setting->key); ?>

                                                            <?php endif; ?>
                                                        </label>
                                                        <input type="text" id="<?php echo e($setting->key); ?>" name="<?php echo e($setting->key); ?>"
                                                            class="form-control" value="<?php echo e($setting->value); ?>"
                                                            placeholder="<?php echo app('translator')->get('l.Enter a method'); ?> <?php echo e($setting->key); ?>" />
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo e(encrypt($method->id)); ?>">
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                                    <?php echo app('translator')->get('l.Submit'); ?>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  مودل الترجمة -->
                        <div class="modal fade" id="model-translate-<?php echo e($method->name); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role"
                                style="justify-content: center;">
                                <div class="modal-content p-3 p-md-5 col-md-8">
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title mb-2"><?php echo app('translator')->get('l.Translate'); ?> <span style="color:red;">
                                                    <?php echo e(strtoupper($method->name)); ?></span>
                                            </h3>
                                        </div>
                                        <form id="addProductForm" class="row g-3" method="post" enctype="multipart/form-data"
                                            action="<?php echo e(route('dashboard.admins.payments-translate')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <?php $__currentLoopData = $headerLanguages->where('code', '!=', $settings['default_language']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-12 mb-4">
                                                        <label class="form-label" for="description-<?php echo e($language->code); ?>"><?php echo app('translator')->get('l.Description'); ?>
                                                            <small class="text-muted">(<?php echo e($language->name); ?> <i
                                                                    class="fi fi-<?php echo e($language->flag); ?> rounded"></i>)</small>
                                                        </label>
                                                        <textarea id="description-<?php echo e($language->code); ?>"
                                                            name="description-<?php echo e($language->code); ?>"
                                                            class="form-control"
                                                            placeholder="<?php echo app('translator')->get('l.Enter a method description'); ?>"><?php echo e($method->getTranslation('description', $language->code)); ?></textarea>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo e(encrypt($method->id)); ?>">
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                                    <?php echo app('translator')->get('l.Submit'); ?>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Button = document.querySelector('.edit<?php echo e($method->name); ?>');
            const Modal = document.querySelector('#model-<?php echo e($method->name); ?>');
            const Button2 = document.querySelector('.translate<?php echo e($method->name); ?>');
            const Modal2 = document.querySelector('#model-translate-<?php echo e($method->name); ?>');

            Button.addEventListener('click', function() {
                var modal = new bootstrap.Modal(Modal);
                modal.show();
            });

            Button2.addEventListener('click', function() {
                var modal = new bootstrap.Modal(Modal2);
                modal.show();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/admins/settings/payments.blade.php ENDPATH**/ ?>