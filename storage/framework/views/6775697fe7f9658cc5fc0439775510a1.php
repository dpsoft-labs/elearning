<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.My Account'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- تضمين ملفات CSS اللازمة -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <style>
        .error-message {
            color: red;
        }

        .iti {
            width: 100%;
        }

        .iti__country {
            direction: ltr;
        }

        .iti__country-list {
            left: 0;
        }

        #phone {
            text-align: left;
        }

        .iti__selected-flag {
            direction: ltr;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
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


                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#account"><i class="bx-sm bx bx-user me-1_5"></i>
                                <?php echo app('translator')->get('l.Account'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#security"><i class="bx-sm bx bx-lock-alt me-1_5"></i>
                                <?php echo app('translator')->get('l.Security'); ?></a>
                        </li>
                        
                    </ul>
                </div>
                <div id="page1">
                    <div class="card mb-4">
                        <h5 class="card-header"><?php echo app('translator')->get('l.Profile Details'); ?></h5>
                        <!-- Account -->
                        <div class="card-body">
                            <form class="d-flex align-items-start align-items-sm-center gap-4" method="post"
                                action="<?php echo e(route('dashboard.profile-uploadPhoto')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="position-relative">
                                    <img src="<?php echo e(auth()->user()->photo); ?>" alt="user-avatar"
                                        class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                    <div id="previewOverlay" class="position-absolute top-0 start-0 w-100 h-100 rounded d-none"
                                         style="background-color: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-magnifying-glass text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-label-primary me-2 mb-3" tabindex="0"
                                        style="color: #fff !important;">
                                        <span class="d-none d-sm-block"><?php echo app('translator')->get('l.Upload new photo'); ?></span>
                                        <i class="fa-solid fa-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="photo" class="account-file-input"
                                            required hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="submit" class="btn btn-primary account-image-reset mb-3">
                                        <i class="fa-solid fa-save d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block"><?php echo app('translator')->get('l.Save'); ?></span>
                                    </button>
                                    <div class="text-muted"><?php echo app('translator')->get('l.Allowed JPG, GIF or PNG. Max size of 800K'); ?></div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2 error-message','messages' => $errors->get('photo')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2 error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('photo'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </form>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <form id="4" method="POST" action="<?php echo e(route('dashboard.profile-update')); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('patch'); ?>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label"><?php echo app('translator')->get('l.First Name'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-user"></i></span>
                                            <input class="form-control" type="text" id="firstName" name="firstname"
                                                value="<?php echo e(auth()->user()->firstname); ?>" placeholder="<?php echo app('translator')->get('l.Enter your first name'); ?>"
                                                autofocus required />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('firstname')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('firstname'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="lastName" class="form-label"><?php echo app('translator')->get('l.Last Name'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-user"></i></span>
                                            <input class="form-control" type="text" name="lastname" id="lastName"
                                                value="<?php echo e(auth()->user()->lastname); ?>" placeholder="<?php echo app('translator')->get('l.Enter your last name'); ?>"
                                                required />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('lastname')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('lastname'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label"><?php echo app('translator')->get('l.E-mail'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-envelope"></i></span>
                                            <input class="form-control" type="text" id="email" name="email"
                                                value="<?php echo e(auth()->user()->email); ?>" placeholder="john.doe@example.com"
                                                readonly disabled />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('email')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phone"><?php echo app('translator')->get('l.Phone Number'); ?></label><br>
                                        <input type="tel" id="phone" name="phone"
                                            value="<?php echo e(auth()->user()->phone); ?>" class="form-control" required>
                                        <input type="hidden" id="phone_code" name="phone_code" required>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('phone')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('phone'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('phone_code')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('phone_code'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="country"><?php echo app('translator')->get('l.Country'); ?></label>
                                        <select id="country" class="select2 form-select" name="country">
                                            <option value=""><?php echo app('translator')->get('l.Select'); ?></option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php echo e(auth()->user()->country == $country->name ? 'selected' : ''); ?>

                                                    value="<?php echo e($country->name); ?>"><?php echo e($country->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2 error-message','messages' => $errors->get('country')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2 error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('country'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="city" class="form-label"><?php echo app('translator')->get('l.City'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-buildings"></i></span>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="<?php echo e(auth()->user()->city); ?>" placeholder="<?php echo app('translator')->get('l.Enter your city'); ?>" />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('city')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('city'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="address" class="form-label"><?php echo app('translator')->get('l.Address'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-map"></i></span>
                                            <input type="text" class="form-control" id="address" name="address"
                                                value="<?php echo e(auth()->user()->address); ?>" placeholder="<?php echo app('translator')->get('l.Enter your address'); ?>" />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('address')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('address'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="state" class="form-label"><?php echo app('translator')->get('l.State'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-building"></i></span>
                                            <input class="form-control" type="text" id="state" name="state"
                                                value="<?php echo e(auth()->user()->state); ?>" placeholder="<?php echo app('translator')->get('l.Enter your state'); ?>" />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('state')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('state'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="zipCode" class="form-label"><?php echo app('translator')->get('l.Zip Code'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-hash"></i></span>
                                            <input type="text" class="form-control" id="zipCode" name="zip_code"
                                                value="<?php echo e(auth()->user()->zip_code); ?>" placeholder="35536"
                                                maxlength="8" />
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2  error-message','messages' => $errors->get('zip_code')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2  error-message','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('zip_code'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2"><?php echo app('translator')->get('l.Save changes'); ?></button>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                    <div class="card">
                        <h5 class="card-header"><?php echo app('translator')->get('l.Delete Account'); ?></h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h5 class="alert-heading mb-1"><?php echo app('translator')->get('l.Are you sure you want to delete your account?'); ?></h5>
                                    <p class="mb-0"><?php echo app('translator')->get('l.Once you delete your account, there is no going back. Please be certain.'); ?></p>
                                </div>
                            </div>
                            <form id="formAccountDeactivation" method="post"
                                action="<?php echo e(route('dashboard.profile-delete')); ?>"><?php echo csrf_field(); ?>
                                <?php echo method_field('delete'); ?>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="accountActivation"
                                        id="accountActivation" required />
                                    <label class="form-check-label" for="accountActivation"><?php echo app('translator')->get('l.I confirm my account deactivation'); ?></label>
                                </div>
                                <button type="submit"
                                    class="btn btn-danger deactivate-account"><?php echo app('translator')->get('l.Deactivate Account'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="page2">

                    <?php if(session('token')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo app('translator')->get('l.This is your Key'); ?> <br>
                            <div class="d-flex align-items-center">
                                <small style="color:green;" id="apiToken"><?php echo e(session('token')); ?></small>
                                <i class="bx bx-copy ms-2 cursor-pointer" onclick="copyToken()"
                                    style="font-size: 1.2rem;"></i>
                            </div>
                            <?php echo app('translator')->get('l.Please copy it as it will not be displayed again!'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <script>
                                function copyToken() {
                                    var token = document.getElementById('apiToken');
                                    navigator.clipboard.writeText(token.textContent);
                                    toastr.success('<?php echo app('translator')->get('l.Token copied to clipboard!'); ?>');
                                }
                            </script>
                        </div>
                    <?php endif; ?>
                    <!-- Change Password -->
                    <div class="card mb-4">
                        <h5 class="card-header"><?php echo app('translator')->get('l.Change Password'); ?></h5>
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST"
                                action="<?php echo e(route('dashboard.profile-updatePassword')); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('put'); ?>
                                <div class="row">
                                    <div class="mb-3 col-md-6 form-password-toggle">
                                        <label class="form-label" for="currentPassword"><?php echo app('translator')->get('l.Current Password'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="password" name="current_password"
                                                id="currentPassword" required
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="mt-2  error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6 form-password-toggle">
                                        <label class="form-label" for="newPassword"><?php echo app('translator')->get('l.New Password'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="password" id="newPassword" name="password"
                                                required
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="mt-2  error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3 col-md-6 form-password-toggle">
                                        <label class="form-label" for="confirmPassword"><?php echo app('translator')->get('l.Confirm New Password'); ?></label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="password" name="password_confirmation"
                                                id="confirmPassword" required
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="mt-2  error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <h6><?php echo app('translator')->get('l.Password Requirements'); ?></h6>
                                        <ul class="ps-3 mb-0">
                                            <li class="mb-1"><?php echo app('translator')->get('l.Minimum 8 characters long - the more, the better'); ?></li>
                                            <li class="mb-1"><?php echo app('translator')->get('l.At least one uppercase letter, one lowercase letter'); ?></li>
                                            <li><?php echo app('translator')->get('l.At least one number, symbol, or whitespace character'); ?></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="btn btn-primary me-2 waves-effect waves-light"><?php echo app('translator')->get('l.Save changes'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/ Change Password -->

                    <!-- Two-Factor Authentication -->
                    <div class="card mb-4">
                        <h5 class="card-header"><?php echo app('translator')->get('l.Two-Factor Authentication'); ?></h5>
                        <div class="card-body">
                            <?php if(empty(auth()->user()->google2fa_secret)): ?>
                                <!-- Setup 2FA Section -->
                                <div class="mb-4">
                                    <h6 class="fw-semibold mb-3"><?php echo app('translator')->get('l.Two-factor authentication is not enabled yet.'); ?></h6>
                                    <p>
                                        <?php echo app('translator')->get('l.Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.'); ?>
                                    </p>
                                    <button class="btn btn-primary mt-2" data-bs-toggle="modal"
                                        data-bs-target="#enable2FAModal">
                                        <?php echo app('translator')->get('l.Enable Two-Factor Authentication'); ?>
                                    </button>
                                </div>

                                <!-- Enable 2FA Modal -->
                                <div class="modal fade" id="enable2FAModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo app('translator')->get('l.Setup Two-Factor Authentication'); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php if(session('2fa_secret')): ?>
                                                    <div class="text-center mb-4">
                                                        <p class="mb-2"><?php echo app('translator')->get('l.Scan this QR code with your Google Authenticator app:'); ?></p>
                                                        <div class="mb-4">
                                                            <div
                                                                style="display: inline-block; padding: 15px; background: white; border-radius: 5px; border: 1px solid #ddd;">
                                                                <img src="<?php echo session('qrImage'); ?>" alt="QR Code"
                                                                    style="width: 200px; height: 200px;">
                                                            </div>
                                                        </div>
                                                        <p class="mb-2"><?php echo app('translator')->get('l.Or enter this code manually:'); ?></p>
                                                        <code class="d-block mb-4"><?php echo e(session('2fa_secret')); ?></code>
                                                    </div>

                                                    <form action="<?php echo e(route('profile.2fa.enable')); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="verify2FACode"><?php echo app('translator')->get('l.Verification Code'); ?></label>
                                                            <input type="text"
                                                                class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="verify2FACode" name="code" required maxlength="6"
                                                                placeholder="<?php echo app('translator')->get('l.Enter 6-digit code'); ?>" />
                                                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-label-secondary"
                                                                data-bs-dismiss="modal">
                                                                <?php echo app('translator')->get('l.Cancel'); ?>
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <?php echo app('translator')->get('l.Enable 2FA'); ?>
                                                            </button>
                                                        </div>
                                                    </form>
                                                <?php else: ?>
                                                    <div class="text-center">
                                                        <p><?php echo app('translator')->get('l.Click the button below to start the setup process'); ?></p>
                                                        <a href="<?php echo e(route('profile.2fa.form')); ?>"
                                                            class="btn btn-primary">
                                                            <?php echo app('translator')->get('l.Begin Setup'); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Manage 2FA Section -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="fw-semibold mb-1"><?php echo app('translator')->get('l.Two-factor authentication is enabled'); ?></h6>
                                            <p class="text-muted mb-0"><?php echo app('translator')->get('l.Your account is secured with two-factor authentication'); ?></p>
                                        </div>
                                        <span class="badge bg-success"><?php echo app('translator')->get('l.Enabled'); ?></span>
                                    </div>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#disable2FAModal">
                                        <?php echo app('translator')->get('l.Disable 2FA'); ?>
                                    </button>
                                </div>

                                <!-- Disable 2FA Modal -->
                                <div class="modal fade" id="disable2FAModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo app('translator')->get('l.Disable Two-Factor Authentication'); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php echo e(route('profile.2fa.disable')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="mb-3">
                                                        <p class="mb-3"><?php echo app('translator')->get('l.Please enter your verification code to disable 2FA'); ?></p>
                                                        <label class="form-label"
                                                            for="disable2FACode"><?php echo app('translator')->get('l.Verification Code'); ?></label>
                                                        <input type="text"
                                                            class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="disable2FACode" name="code" required autofocus
                                                            minlength="6" maxlength="6"
                                                            placeholder="<?php echo app('translator')->get('l.Enter 6-digit code'); ?>" />
                                                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-label-secondary"
                                                            data-bs-dismiss="modal">
                                                            <?php echo app('translator')->get('l.Cancel'); ?>
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <?php echo app('translator')->get('l.Disable 2FA'); ?>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!--/ Two-Factor Authentication -->

                    <!-- Create an API key -->
                    <div class="card mb-4">
                        <h5 class="card-header"><?php echo app('translator')->get('l.Create an API key'); ?></h5>
                        <div class="row">
                            <div class="col-md-5 order-md-0 order-1">
                                <div class="card-body">
                                    <form id="formAccountSettingsApiKey" method="POST"
                                        action="<?php echo e(route('dashboard.profile-apiCreate')); ?>"> <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <div class="mb-3 col-12">
                                                <label for="apiAccess" class="form-label"><?php echo app('translator')->get('l.Choose the Api key type you want to create'); ?></label>
                                                <select id="apiAccess" class="select2 form-select"required>
                                                    
                                                    <option value="full"><?php echo app('translator')->get('l.Full Control'); ?></option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="apiKey" class="form-label"><?php echo app('translator')->get('l.Name the API key'); ?></label>
                                                <input type="text" class="form-control" id="apiKey" name="name"
                                                    required placeholder="Server Key 1" />
                                            </div>
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-secondary me-2 d-grid w-100"><?php echo app('translator')->get('l.Create Key'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7 order-md-1 order-0">
                                <div class="text-center mt-4 mx-3 mx-md-0">
                                    <img src="<?php echo e(asset('assets/themes/default/img/illustrations/sitting-girl-with-laptop.png')); ?>"
                                        class="img-fluid" alt="Api Key Image" width="202" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Create an API key -->

                    <!-- API Key List & Access -->
                    <div class="card mb-4">
                        <h5 class="card-header"><?php echo app('translator')->get('l.API Key List & Access'); ?></h5>
                        <div class="card-body">
                            <p>
                                <?php echo app('translator')->get('l.An API key is a simple encrypted string that identifies an application without any principal. They are useful for accessing public data anonymously, and are used to associate API requests with your project for quota and billing.'); ?>
                            </p>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php $__empty_1 = true; $__currentLoopData = $apis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $api): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div
                                            class="bg-lighter rounded p-3 position-relative mb-3 d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 me-3"><?php echo e($api->name); ?></h4>
                                                <span class="badge bg-secondary"><?php echo app('translator')->get('l.Full Control'); ?></span>
                                                <span class="text-muted d-block"><?php echo app('translator')->get('l.Created on'); ?>
                                                    <?php echo e($api->created_at); ?></span>
                                            </div>
                                            <div class="dropdown api-key-actions ms-auto">
                                                <a class="btn dropdown-toggle text-muted hide-arrow p-0"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="<?php echo e(route('dashboard.profile-apiDelete')); ?>?name=<?php echo e(encrypt($api->name)); ?>"
                                                        class="dropdown-item">
                                                        <i class="ti ti-trash me-2"></i><?php echo app('translator')->get('l.Delete'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="text-center"><?php echo app('translator')->get('l.No data found'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ API Key List & Access -->

                    <!-- Recent Devices -->
                    <div class="card mb-4">
                        <h5 class="card-header"><?php echo app('translator')->get('l.Recent Devices'); ?></h5>
                        <div class="table-responsive">
                            <table class="table border-top">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-truncate"><?php echo app('translator')->get('l.Device & Browser'); ?></th>
                                        <th class="text-truncate"><?php echo app('translator')->get('l.IP Address'); ?></th>
                                        <th class="text-truncate"><?php echo app('translator')->get('l.Login Time'); ?></th>
                                        <th class="text-truncate"><?php echo app('translator')->get('l.Status'); ?></th>
                                        <th class="text-truncate"><?php echo app('translator')->get('l.Location'); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php use UAParser\Parser; ?>
                                    <?php $__empty_1 = true; $__currentLoopData = $sessions->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $parser = Parser::create();
                                            $result = $parser->parse($session->user_agent);

                                            $platform = $result->os->family;
                                            $browser = $result->ua->family;
                                        ?>
                                        <tr>
                                            <td class="text-truncate">
                                                <div class="d-flex align-items-center">
                                                    <i
                                                        class="<?php if($platform == 'Windows'): ?> fa-brands fa-windows text-info
                                                    <?php elseif($platform == 'Android'): ?> fa-brands fa-android text-success
                                                    <?php elseif($platform == 'Mac OS X'): ?> fa-brands fa-apple
                                                    <?php elseif($platform == 'iOS'): ?> fa-solid fa-mobile-screen text-danger
                                                    <?php elseif($platform == 'Linux'): ?> fa-brands fa-linux text-dark
                                                    <?php else: ?> fa-solid fa-question text-warning <?php endif; ?> me-2 fa-lg">
                                                    </i>
                                                    <div>
                                                        <strong><?php echo e($platform); ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?php echo e($browser); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-truncate"><?php echo e($session->ip_address); ?></td>
                                            <td class="text-truncate">
                                                <?php echo e(\Carbon\Carbon::parse($session->login_at)->format('Y/m/d h:i A')); ?>

                                            </td>
                                            <td class="text-truncate">
                                                <?php if($session->login_successful): ?>
                                                    <span class="badge bg-success"><?php echo app('translator')->get('l.Successful'); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><?php echo app('translator')->get('l.Failed'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-truncate">
                                                <?php echo e($session->location ?? __('l.Not Available')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center"><?php echo app('translator')->get('l.No data found'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--/ Recent Devices -->
                </div>
                <div id="page3">
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!-- تضمين ملفات JS اللازمة -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        $(document).ready(function() {
            // إنشاء حقل إدخال رقم الهاتف بشكل دولي
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                initialCountry: "us",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "";
                        callback(countryCode);
                    });
                },
                nationalMode: false,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                separateDialCode: true,
                formatOnDisplay: true,
                preferredCountries: ["us", "ca", "gb"], // يمكن تعديل الدول المفضلة هنا
            });

            // تحديث حقل الخفي "phone_code" بشكل تلقائي عند فتح الصفحة
            var phone_code = document.querySelector("#phone_code");
            var currentDialCode = iti.getSelectedCountryData().dialCode;
            phone_code.value = currentDialCode;

            // تحديث حقل الخفي "phone_code" بشكل تلقائي عند تغيير الكود الدولي فقط
            input.addEventListener("countrychange", function() {
                var currentDialCode = iti.getSelectedCountryData().dialCode;
                phone_code.value = currentDialCode;
            });

            // معاينة الصورة قبل الرفع
            document.getElementById('upload').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    const previewImage = document.getElementById('uploadedAvatar');
                    const previewOverlay = document.getElementById('previewOverlay');

                    reader.onload = function(event) {
                        previewImage.src = event.target.result;

                        // إظهار أيقونة التكبير عند تمرير المؤشر
                        previewImage.parentElement.style.cursor = 'pointer';

                        // إظهار النافذة المنبثقة للصورة عند النقر على الصورة المصغرة
                        previewImage.onclick = function() {
                            Swal.fire({
                                imageUrl: event.target.result,
                                imageAlt: 'صورة البروفايل',
                                confirmButtonText: '<?php echo app('translator')->get('l.Close'); ?>',
                                confirmButtonColor: '#696cff',
                                showClass: {
                                    popup: 'animate__animated animate__fadeIn faster'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOut faster'
                                }
                            });
                        };

                        // إظهار وإخفاء الطبقة العلوية عند تمرير المؤشر فوق الصورة
                        previewImage.parentElement.addEventListener('mouseenter', function() {
                            previewOverlay.classList.remove('d-none');
                        });

                        previewImage.parentElement.addEventListener('mouseleave', function() {
                            previewOverlay.classList.add('d-none');
                        });
                    };

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <script>
        // تحديد الديفات والروابط
        const page1 = document.getElementById("page1");
        const page2 = document.getElementById("page2");
        // const page3 = document.getElementById("page3");
        const accountLink = document.querySelector('.nav-link.active');
        const securityLink = document.querySelector('.nav-link[href="#security"]');
        // const billingLink = document.querySelector('.nav-link[href="#billing"]');

        // إضافة حدث النقر إلى روابط القائمة
        accountLink.addEventListener('click', showPage1);
        securityLink.addEventListener('click', showPage2);
        // billingLink.addEventListener('click', showPage3);

        // عرض الديف الأولي وإخفاء الديفات الأخرى
        function showPage1() {
            page1.style.display = "block";
            accountLink.classList.add('active');
            securityLink.classList.remove('active');
            // billingLink.classList.remove('active');

            // إذا كانت القيمة `showPage2` `true`، فعرض الديف الثاني
            if ('<?php echo e(session('showPage2')); ?>') {
                showPage2();
                // حذف قيمة `showPage2` من السيشن
                '<?php echo e(session()->forget('showPage2')); ?>';
            } else {
                page2.style.display = "none";
                // page3.style.display = "none";
            }
        }

        function showPage2() {
            page1.style.display = "none";
            page2.style.display = "block";
            // page3.style.display = "none";
            accountLink.classList.remove('active');
            securityLink.classList.add('active');
            // billingLink.classList.remove('active');
        }

        // function showPage3() {
        //     page1.style.display = "none";
        //     page2.style.display = "none";
        //     page3.style.display = "block";
        //     accountLink.classList.remove('active');
        //     securityLink.classList.remove('active');
        //     billingLink.classList.add('active');
        // }

        // عرض الديف الأولي في البداية
        showPage1();
    </script>

    <script src="<?php echo e(asset('assets/themes/default/js/pages-account-settings-security.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/themes/default/js/modal-enable-otp.js')); ?>"></script>

    <!-- إظهار المودال مع رسالة الخطأ إذا كان هناك خطأ في التحقق -->
    <?php if($errors->has('code') && session('2fa_action')): ?>
        document.addEventListener('DOMContentLoaded', function() {
        var modalId = "<?php echo e(session('2fa_action') === 'enable' ? 'enable2FAModal' : 'disable2FAModal'); ?>";
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
        });
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.layouts.back.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/back/profile.blade.php ENDPATH**/ ?>