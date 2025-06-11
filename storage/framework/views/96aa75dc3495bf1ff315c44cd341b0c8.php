<footer class="landing-footer bg-body footer-text">
    <div class="footer-top position-relative overflow-hidden z-1">
      <img
        src="<?php echo e(asset('assets/themes/default/img/front-pages/backgrounds/footer-bg.png')); ?>"
        alt="footer bg"
        class="footer-bg banner-bg-img z-n1" />
      <div class="container">
        <div class="row gx-0 gy-6 g-lg-10">
          <div class="col-lg-5">
            <a href="landing-page.html" class="app-brand-link mb-8">
              <span class="app-brand-logo demo">
                <img src="<?php echo e(asset($settings['logo'])); ?>" alt="logo" width="180">
              </span>
            </a>
            <p class="footer-text footer-logo-description mb-6">
              
            </p>
            <form class="footer-form" action="<?php echo e(route('subscribe')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <label for="footer-email" class="small"><?php echo app('translator')->get('front.subscribe_to_newsletter'); ?></label>
              <div class="d-flex mt-1">
                <input
                  type="email"
                  class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                  id="footer-email"
                  name="email"
                  placeholder="<?php echo app('translator')->get('front.your_email'); ?>" />
                <button
                  type="submit"
                  class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                  <?php echo app('translator')->get('front.subscribe'); ?>
                </button>
              </div>
            </form>
          </div>
          
          <div class="col-lg-4 col-md-4 col-sm-6">
            <h6 class="footer-title mb-6"><?php echo app('translator')->get('front.pages'); ?></h6>
            <ul class="list-unstyled">
              <li class="mb-4">
                <a href="#pricing" class="footer-link"><?php echo app('translator')->get('front.pricing'); ?><span class="badge bg-primary ms-2">New</span></a>
              </li>
              <li class="mb-4">
                <a href="payment-page.html" class="footer-link"
                  ><?php echo app('translator')->get('front.team'); ?>
                </a>
              </li>
              <li class="mb-4">
                <a href="#about" class="footer-link"><?php echo app('translator')->get('front.about'); ?></a>
              </li>
              <li class="mb-4">
                <a href="#faq" class="footer-link"><?php echo app('translator')->get('front.faqs'); ?></a>
              </li>
              <li>
                <a href="<?php echo e(route('home')); ?>" class="footer-link"
                  ><?php echo app('translator')->get('front.login_register'); ?></a
                >
              </li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-4">
            <h6 class="footer-title mb-6"><?php echo app('translator')->get('front.download_our_app'); ?></h6>
            <a href="<?php echo e($settings['app_store_link']); ?>" class="d-block mb-4" target="_blank"
              ><img src="<?php echo e(asset('assets/themes/default/img/front-pages/landing-page/apple-icon.png')); ?>" alt="apple icon"
            /></a>
            <a href="<?php echo e($settings['play_store_link']); ?>" class="d-block" target="_blank"
              ><img src="<?php echo e(asset('assets/themes/default/img/front-pages/landing-page/google-play-icon.png')); ?>" alt="google play icon"
            /></a>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom py-3 py-md-5">
      <div class="container d-flex flex-wrap justify-content-center flex-md-row flex-column text-center text-md-start">
        <div class="mb-2 mb-md-0">
          <span class="footer-bottom-text">© <script>document.write(new Date().getFullYear());</script></span>
          <a href="https://dp-soft.com" target="_blank" class="text-white">dp soft,</a>
          <span class="footer-bottom-text"> Made with ❤️ for a better education.</span>
        </div>
      </div>
    </div>
  </footer><?php /**PATH D:\laragon\www\laravel\pending\eelu\resources\views/themes/default/layouts/front/footer.blade.php ENDPATH**/ ?>