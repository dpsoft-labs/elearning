<!DOCTYPE html>
@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp
<script>
    window.primaryColor = "{{ $settings['primary_color'] ?? '#FFAB1D' }}";
</script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}" data-skin="default"
    data-assets-path="{{ asset('assets/themes/default') }}/" data-template="vertical-menu-template" data-bs-theme="light">

    <head>
        {{-- <base href="{{ $settings['domain'] }}/"> --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <meta name="author" content="Adel Fawzy">
        <meta name="copyright" content="dp soft">
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="@yield('keywords')" />
        <meta name="description" content="@yield('description')" />
        <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}" />
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}" />

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="@yield('og_title', 'Default Title')" />
        <meta property="og:description" content="@yield('og_description', 'Default Description')" />
        <meta property="og:image" content="@yield('og_image', asset('default-image.jpg'))" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
        <meta property="og:site_name" content="{{ $settings['name'] ?? 'DP Soft' }}" />

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('og_title', 'Default Title')">
        <meta name="twitter:description" content="@yield('og_description', 'Default Description')">
        <meta name="twitter:image" content="@yield('og_image', asset('default-image.jpg'))">

        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="{{ $settings['primary_color'] ?? '#FFAB1D' }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="{{ $settings['name'] ?? 'DP Soft' }}">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="apple-touch-icon" href="{{ asset($settings['logo'] ?? 'default-icon.png') }}">

        <!-- Alternate Languages -->
        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <link rel="alternate" hreflang="{{ $localeCode }}"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" />
        @endforeach

        <!-- Structured Data -->
        @yield('structured_data')


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/fonts/iconify-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/fonts/flag-icons.css') }}" />

        <!-- Core CSS -->
        <!-- build:css assets/vendor/css/theme.css  -->

        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/pickr/pickr-themes.css') }}" />

        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/css/core.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/css/demo.css') }}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/css/pages/front-page.css') }}" />

        <!-- endbuild -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/nouislider/nouislider.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/swiper/swiper.css') }}" />

        <!-- Page CSS -->

        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/css/pages/front-page-landing.css') }}" />

        <!-- Helpers -->
        <script src="{{ asset('assets/themes/default/vendor/js/helpers.js') }}"></script>

        <!-- Toastr CSS -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/toastr/toastr.css') }}" />

        <script src="{{ asset('assets/themes/default/vendor/js/template-customizer.js') }}"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('assets/themes/default/js/front-config.js') }}"></script>

        <style>
            @media (max-width: 768px) {
                .app-brand-logo {
                    width: 40px;
                }
                #logo-image {
                    width: 110px !important;
                }
                #logo-dark-image {
                    width: 110px !important;
                }
            }
        </style>

        {{-- css --}}
        @yield('css')

        {{-- header code --}}
        {!! $settings['headerCode'] !!}

        {{-- google recaptcha required --}}
        <script async src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}"></script>
    </head>

    <body>
        <script src="{{ asset('assets/themes/default/vendor/js/dropdown-hover.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/js/mega-dropdown.js') }}"></script>


        <!-- Navbar: Start -->
        @include('themes.default.layouts.front.nav')
        <!-- Navbar: End -->

        <!-- Sections:Start -->

        <div data-bs-spy="scroll" class="scrollspy-example">
           @yield('content')
        </div>

        <!-- / Sections:End -->

        <!-- Footer: Start -->
        @include('themes.default.layouts.front.footer')
        <!-- Footer: End -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/theme.js  -->

        <script src="{{ asset('assets/themes/default/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

        <script src="{{ asset('assets/themes/default/vendor/libs/pickr/pickr.js') }}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('assets/themes/default/vendor/libs/nouislider/nouislider.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/swiper/swiper.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('assets/themes/default/js/front-main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('assets/themes/default/js/front-page-landing.js') }}"></script>

        <!-- google recaptcha required -->
        <script>
            window.addEventListener('load', () => {
                const $recaptcha = document.querySelector('#g-recaptcha-response');
                if ($recaptcha) {
                    $recaptcha.setAttribute('required', 'required');
                }
            })
        </script>

        <!-- Toastr JS -->
        <script src="{{ asset('assets/themes/default/vendor/libs/toastr/toastr.js') }}"></script>


        {{-- toastr for alerts and notes --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // تهيئة إعدادات Toastr المشتركة
                const commonToastrOptions = {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                    rtl: {{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'true' : 'false' }},
                    positionClass: 'toast-top-right'
                };

                // إضافة الأنماط المخصصة
                const style = document.createElement('style');
                style.textContent = `
                    .toast {
                        background-color: var(--bs-body-bg) !important;
                        color: var(--bs-body-color) !important;
                    }
                    .toast .toast-title {
                        color: var(--bs-body-color) !important;
                    }
                    .toast .toast-message {
                        color: var(--bs-body-color) !important;
                    }
                    .toast .toast-close-button {
                        color: var(--bs-body-color) !important;
                    }
                `;
                document.head.appendChild(style);

                // معالجة تنبيهات الجلسة
                @if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
                    toastr.options = {
                        ...commonToastrOptions,
                        timeOut: 4000
                    };

                    @if (session('success') || session('success'))
                        toastr.success('{{ session('success') }}');
                    @endif

                    @if (session('error'))
                        toastr.error('{{ session('error') }}');
                    @endif

                    @if (session('warning'))
                        toastr.warning('{{ session('warning') }}');
                    @endif

                    @if (session('info'))
                        toastr.info('{{ session('info') }}');
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            toastr.error('{{ $error }}');
                        @endforeach
                    @endif
                @endif
            });
        </script>

        {{-- yield js --}}
        @yield('js')

        {{-- footer code --}}
        {!! $settings['footerCode'] !!}
    </body>

</html>
