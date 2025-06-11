<footer class="landing-footer bg-body footer-text">
    <div class="footer-top position-relative overflow-hidden z-1">
      <img
        src="{{ asset('assets/themes/default/img/front-pages/backgrounds/footer-bg.png') }}"
        alt="footer bg"
        class="footer-bg banner-bg-img z-n1" />
      <div class="container">
        <div class="row gx-0 gy-6 g-lg-10">
          <div class="col-lg-5">
            <a href="landing-page.html" class="app-brand-link mb-8">
              <span class="app-brand-logo demo">
                <img src="{{ asset($settings['logo']) }}" alt="logo" width="180">
              </span>
            </a>
            <p class="footer-text footer-logo-description mb-6">
              {{-- {{ $settings['description'] }} --}}
            </p>
            <form class="footer-form" action="{{ route('subscribe') }}" method="POST">
              @csrf
              <label for="footer-email" class="small">@lang('front.subscribe_to_newsletter')</label>
              <div class="d-flex mt-1">
                <input
                  type="email"
                  class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                  id="footer-email"
                  name="email"
                  placeholder="@lang('front.your_email')" />
                <button
                  type="submit"
                  class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                  @lang('front.subscribe')
                </button>
              </div>
            </form>
          </div>
          {{-- <div class="col-lg-2 col-md-4 col-sm-6">
            <h6 class="footer-title mb-6">Demos</h6>
            <ul class="list-unstyled">
              <li class="mb-4">
                <a href="../vertical-menu-template/" target="_blank" class="footer-link">Vertical Layout</a>
              </li>
              <li class="mb-4">
                <a href="../horizontal-menu-template/" target="_blank" class="footer-link">Horizontal Layout</a>
              </li>
              <li class="mb-4">
                <a href="../vertical-menu-template-bordered/" target="_blank" class="footer-link">Bordered Layout</a>
              </li>
              <li class="mb-4">
                <a href="../vertical-menu-template-semi-dark/" target="_blank" class="footer-link"
                  >Semi Dark Layout</a
                >
              </li>
              <li>
                <a href="../vertical-menu-template-dark/" target="_blank" class="footer-link">Dark Layout</a>
              </li>
            </ul>
          </div> --}}
          <div class="col-lg-4 col-md-4 col-sm-6">
            <h6 class="footer-title mb-6">@lang('front.pages')</h6>
            <ul class="list-unstyled">
              <li class="mb-4">
                <a href="#pricing" class="footer-link">@lang('front.pricing')<span class="badge bg-primary ms-2">New</span></a>
              </li>
              <li class="mb-4">
                <a href="payment-page.html" class="footer-link"
                  >@lang('front.team')
                </a>
              </li>
              <li class="mb-4">
                <a href="#about" class="footer-link">@lang('front.about')</a>
              </li>
              <li class="mb-4">
                <a href="#faq" class="footer-link">@lang('front.faqs')</a>
              </li>
              <li>
                <a href="{{route('home')}}" class="footer-link"
                  >@lang('front.login_register')</a
                >
              </li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-4">
            <h6 class="footer-title mb-6">@lang('front.download_our_app')</h6>
            <a href="{{ $settings['app_store_link'] }}" class="d-block mb-4" target="_blank"
              ><img src="{{ asset('assets/themes/default/img/front-pages/landing-page/apple-icon.png') }}" alt="apple icon"
            /></a>
            <a href="{{ $settings['play_store_link'] }}" class="d-block" target="_blank"
              ><img src="{{ asset('assets/themes/default/img/front-pages/landing-page/google-play-icon.png') }}" alt="google play icon"
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
  </footer>