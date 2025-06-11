<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('l.Login'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('description'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-css'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="<?php echo e(asset('assets/themes/default/img/illustrations/boy-with-rocket-light.png')); ?>"
                    class="img-fluid" alt="Login image" width="700"
                    data-app-dark-img="illustrations/boy-with-rocket-dark.png"
                    data-app-light-img="illustrations/boy-with-rocket-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
            <div class="w-px-400 mx-auto mt-12 pt-5">
                <h4 class="mb-1"><?php echo app('translator')->get('l.Welcome to'); ?> <?php echo e($settings['name']); ?>! 👋</h4>
                <p class="mb-6"><?php echo app('translator')->get('l.Please sign-in to your account and start the adventure'); ?></p>

                <form id="formAuthentication" class="mb-6" action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-6">
                        <label for="email" class="form-label"><?php echo app('translator')->get('l.Email or Phone'); ?></label>
                        <input type="text" class="form-control" id="email" name="email"
                            placeholder="<?php echo app('translator')->get('l.Enter your email or phone number'); ?>" autofocus required
                            <?php if(isset($_COOKIE['remember_user'])): ?> value="<?php echo e($_COOKIE['remember_user']); ?>"
                            <?php else: ?>
                                value="<?php echo e(old('email')); ?>" <?php endif; ?> />
                        <?php if($errors->has('email')): ?>
                            <div class="mt-2" style="color: red; padding-left: 10px; padding-right: 10px;">
                                <?php echo e($errors->first('email')); ?></div>
                        <?php endif; ?>
                        <?php if($errors->has('limit')): ?>
                            <div class="mt-2" style="color: red; padding-left: 10px; padding-right: 10px;">
                                <?php echo e($errors->first('limit')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-6 form-password-toggle">
                        <label class="form-label" for="password"><?php echo app('translator')->get('l.Password'); ?></label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password" required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"
                                <?php if(isset($_COOKIE['remember_pass'])): ?> <?php $password = decrypt($_COOKIE['remember_pass']); ?>
                                    value="<?php echo e($password); ?>"
                                <?php else: ?>
                                    value="<?php echo e(old('password')); ?>" <?php endif; ?> />
                            <span class="input-group-text cursor-pointer" style="z-index: 999;"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>
                    <div class="my-8">
                        <div class="d-flex justify-content-between">
                            <div class="form-check mb-0 ms-2">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                                    <?php if(isset($_COOKIE['remember_user'])): ?> checked <?php endif; ?> />
                                <label class="form-check-label" for="remember-me"><?php echo app('translator')->get('l.Remember Me'); ?></label>
                            </div>
                            <a href="<?php echo e(route('password.request')); ?>">
                                <p class="mb-0"><?php echo app('translator')->get('l.Forgot Password?'); ?></p>
                            </a>
                        </div>
                    </div>
                    <button class="btn btn-primary d-grid w-100" type="submit"><?php echo app('translator')->get('l.Sign in'); ?></button>
                </form>

                <?php if($settings['can_any_register'] == 1): ?>
                    <p class="text-center">
                        <span><?php echo app('translator')->get('l.New on our platform?'); ?></span>
                        <a href="<?php echo e(route('register')); ?>">
                            <span><?php echo app('translator')->get('l.Create an account'); ?></span>
                        </a>
                    </p>
                <?php endif; ?>

                <div class="divider my-6">
                    <div class="divider-text"><?php echo app('translator')->get('l.or'); ?></div>
                </div>

                <div class="d-flex justify-content-center">
                    <?php
                        $activeLogins = collect([
                            $settings['facebookLogin'],
                            $settings['googleLogin'],
                            $settings['twitterLogin'],
                        ])
                            ->filter()
                            ->count();

                        $btnWidth = $activeLogins === 1 ? 'w-100' : ($activeLogins === 2 ? 'w-50' : '');
                    ?>

                    <?php if($settings['facebookLogin']): ?>
                        <a href="<?php echo e(route('auth.facebook')); ?>"
                            class="btn btn-icon btn-label-facebook <?php echo e($btnWidth); ?> me-3">
                            <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                        </a>
                    <?php endif; ?>
                    <?php if($settings['googleLogin']): ?>
                        <a href="<?php echo e(route('auth.google')); ?>"
                            class="btn btn-icon btn-label-google-plus <?php echo e($btnWidth); ?> me-3">
                            <i class="tf-icons fa-brands fa-google fs-5"></i>
                        </a>
                    <?php endif; ?>
                    <?php if($settings['twitterLogin']): ?>
                        <a href="<?php echo e(route('auth.twitter')); ?>" class="btn btn-icon btn-label-twitter <?php echo e($btnWidth); ?>">
                            <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- /Login -->
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-scripts'); ?>
    <script src="<?php echo e(asset('assets/themes/default/js/pages-auth.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default.auth.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/auth/login.blade.php ENDPATH**/ ?>