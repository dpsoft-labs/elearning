<!DOCTYPE html>
<script>
    window.primaryColor = "{{ $settings['primary_color'] ?? '#FFAB1D' }}";
</script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr' }}" data-skin="default"
    data-assets-path="{{ asset('assets/themes/default') }}/" data-template="vertical-menu-template"
    data-bs-theme="light">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>@yield('title')</title>

        <meta name="keywords" content="@yield('meta_keywords')" />
        <meta name="description" content="@yield('meta_description')" />
        <meta name="author" content="{{ $settings['author'] }}">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset($settings['favicon']) }}" />

        {{-- canonical --}}
        <link rel="canonical" href="{{ request()->fullUrl() }}">

        {{-- alternate --}}
        {{-- <link rel="alternate" hreflang="es" href="{{ url(app()->getLocale() == 'es' ? '' : 'es') . substr(request()->getRequestUri(), 3) }}" />
        <link rel="alternate" hreflang="en" href="{{ url(app()->getLocale() == 'en' ? '' : 'en') . substr(request()->getRequestUri(), 3) }}" />
        <link rel="alternate" hreflang="pt" href="{{ url(app()->getLocale() == 'pt' ? '' : 'pt') . substr(request()->getRequestUri(), 3) }}" />
        <link rel="alternate" hreflang="zh" href="{{ url(app()->getLocale() == 'zh' ? '' : 'zh') . substr(request()->getRequestUri(), 3) }}" /> --}}
        <link rel="alternate" hreflang="x-default" href="{{ url('') . substr(request()->getRequestUri(), 3) }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/fonts/boxicons.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/fonts/fontawesome.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/fonts/iconify-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/fonts/flag-icons.css') }}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/pickr/pickr-themes.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/css/core.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/css/demo.css') }}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet"
            href="{{ asset('assets/themes/default/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet"
            href="{{ asset('assets/themes/default/vendor/libs/apex-charts/apex-charts.css') }}" />

        <!-- Toastr CSS -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/toastr/toastr.css') }}" />

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/select2/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/tagify/tagify.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/themes/default/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/themes/default/vendor/libs/typeahead-js/typeahead.css') }}" />

        <!-- SweetAlert2 -->
        <script src="{{ asset('assets/themes/default/js/extended-ui-sweetalert2.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- text editor -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/quill/typography.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/quill/katex.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/quill/editor.css') }}" />

        <!-- file upload -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/dropzone/dropzone.css') }}" />

        <!-- Preloader CSS -->
        <link rel="stylesheet" href="{{ asset('assets/themes/default/vendor/libs/spinkit/spinkit.css') }}">

        <!-- google recaptcha -->
        <script async src="https://www.google.com/recaptcha/api.js?hl={{ app()->getLocale() }}"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

        <!-- sweet alert -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!-- blink animation -->
        <style>
            .blink {
                animation: blink 1s infinite;
            }

            @keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }

                100% {
                    opacity: 1;
                }
            }
        </style>

        <!-- Page CSS -->
        @yield('css')

        <!-- Helpers -->
        <script src="{{ asset('assets/themes/default/vendor/js/helpers.js') }}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ asset('assets/themes/default/vendor/js/template-customizer.js') }}"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('assets/themes/default/js/config.js') }}"></script>
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <div id="preloader"
                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.23); z-index: 9999;">
                    <div class="sk-wave sk-primary"
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <div class="sk-wave-rect"></div>
                        <div class="sk-wave-rect"></div>
                        <div class="sk-wave-rect"></div>
                        <div class="sk-wave-rect"></div>
                        <div class="sk-wave-rect"></div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const preloader = document.getElementById('preloader');
                        let navigationEvent = false;

                        // دالة لإظهار البريلودر
                        function showPreloader() {
                            preloader.style.display = 'block';
                        }

                        // دالة لإخفاء البريلودر
                        function hidePreloader() {
                            preloader.style.display = 'none';
                        }

                        // معالجة النقر على الروابط
                        document.addEventListener('click', function(e) {
                            const link = e.target.closest('a');
                            if (link &&
                                !link.hasAttribute('download') &&
                                link.href &&
                                !link.href.includes('#') &&
                                !link.href.includes('javascript:void(0)') &&
                                !link.hasAttribute('target') &&
                                link.href !== window.location.href &&
                                !link.classList.contains('delete-record') && // استثناء روابط الحذف
                                !link.classList.contains('delete-all-inactive')
                            ) { // استثناء زر حذف جميع المستخدمين غير النشطين
                                navigationEvent = true;
                                showPreloader();
                            }
                        });

                        // معالجة تقديم النماذج
                        document.addEventListener('submit', function(e) {
                            const form = e.target;
                            if (form.tagName === 'FORM' && !form.hasAttribute('target')) {
                                navigationEvent = true;
                                showPreloader();
                            }
                        });

                        // معالجة زر الرجوع والتقدم
                        window.addEventListener('popstate', function() {
                            hidePreloader();
                            navigationEvent = false;
                        });

                        // إخفاء البريلودر عند اكتمال تحميل الصفحة
                        window.addEventListener('load', function() {
                            if (!navigationEvent) {
                                hidePreloader();
                            }
                        });

                        // إخفاء البريلودر عند حدوث أي خطأ
                        window.addEventListener('error', function() {
                            hidePreloader();
                        }, true);

                        // إضافة مستمع لحدث التنقل
                        window.addEventListener('beforeunload', function(e) {
                            if (!navigationEvent) {
                                hidePreloader();
                            }
                        });

                        // إضافة مستمع لحدث hashchange
                        window.addEventListener('hashchange', function() {
                            hidePreloader();
                        });

                        // معالجة الضغط على زر الرجوع في المتصفح
                        window.addEventListener('pageshow', function(event) {
                            if (event.persisted) {
                                hidePreloader();
                            }
                        });

                        // إضافة مستمع للتحقق من حالة التحميل كل 5 ثوانٍ
                        setInterval(function() {
                            if (document.readyState === 'complete' && preloader.style.display === 'block' && !
                                navigationEvent) {
                                hidePreloader();
                            }
                        }, 5000);
                    });
                </script>

                <!-- header -->
                @include('themes.default.layouts.back.header')
                <!-- / header -->

                <div class="layout-page">
                    <!-- Navbar -->
                    @include('themes.default.layouts.back.nav')
                    <!-- / Navbar -->

                    <div class="content-wrapper">

                        {{-- impersonated_by at the top of the file --}}
                        @php use App\Models\User;@endphp
                        @if (session()->has('impersonated_by'))
                            <section id="component-footer" class="mt-2">
                                <footer class="footer bg-light">
                                    <div
                                        class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3">
                                        <div>
                                            @php $user = User::find(session()->get('impersonated_by')); @endphp
                                            @lang('l.Hi') {{ $user->firstname }}, @lang('l.You are impersonate this user now. you can back as admin by->')
                                        </div>
                                        <div>
                                            <a href="{{ route('impersonate.leave') }}"
                                                class="btn btn-sm btn-outline-danger"><i
                                                    class="ti ti-logout me-1"></i>@lang('l.Leave')</a>
                                        </div>
                                    </div>
                                </footer>
                            </section>
                        @endif

                        <!-- Content -->
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <h1>Test</h1>
                                </div>
                                {{-- <div action="/upload" class="dropzone needsclick" id="dropzone-basic">
                                    <div class="dz-message needsclick">
                                      Drop files here or click to upload
                                      <span class="note needsclick">(This is just a demo dropzone. Selected files are <span class="fw-medium">not</span> actually uploaded.)</span>
                                    </div>
                                    <div class="fallback">
                                      <input name="file" type="file" />
                                    </div>
                                </div> --}}

                                    <div action="/upload" class="dropzone needsclick" id="dropzone-basic">
                                        <div class="dz-message needsclick">
                                            Drop files here or click to upload
                                            <span class="note needsclick">(This is just a demo dropzone. Selected files are
                                                <span class="fw-medium">not</span> actually uploaded.)</span>
                                        </div>
                                        <div class="fallback">
                                            <input type="file"  name="file"  />
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        @include('themes.default.layouts.back.footer')
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>

                </div>
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>
        </div>

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->

        <script src="{{ asset('assets/themes/default/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/pickr/pickr.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/js/menu.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/tagify/tagify.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/bloodhound/bloodhound.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/@form-validation/popular.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/@form-validation/auto-focus.js') }}"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('assets/themes/default/vendor/libs/apex-charts/apexcharts.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('assets/themes/default/js/main.js') }}"></script>
        <script src="{{ asset('assets/themes/default/js/forms-selects.js') }}"></script>
        <script src="{{ asset('assets/themes/default/js/forms-tagify.js') }}"></script>
        <script src="{{ asset('assets/themes/default/js/forms-typeahead.js') }}"></script>
        <!-- Page JS -->
        <script src="{{ asset('assets/themes/default/js/dashboards-analytics.js') }}"></script>

        <!-- Toastr JS -->
        <script src="{{ asset('assets/themes/default/vendor/libs/toastr/toastr.js') }}"></script>

        <!-- text editor -->
        <script src="{{ asset('assets/themes/default/vendor/libs/quill/katex.js') }}"></script>
        <script src="{{ asset('assets/themes/default/vendor/libs/quill/quill.js') }}"></script>
        <!-- SweetAlert2 JS -->
        {{-- <script src="{{ asset('assets/themes/default/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
        <script src="{{ asset('assets/themes/default/js/extended-ui-sweetalert2.js') }}"></script> --}}

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <!-- DataTables Buttons -->
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- google recaptcha required -->
        <script>
            window.addEventListener('load', () => {
                const $recaptcha = document.querySelector('#g-recaptcha-response');
                if ($recaptcha) {
                    $recaptcha.setAttribute('required', 'required');
                }
            })
        </script>

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
                @if (session('success') || session('success') || session('error') || session('warning') || session('info'))
                    toastr.options = {
                        ...commonToastrOptions,
                        timeOut: 4000
                    };

                    @if (session('success') || session('success'))
                        toastr.success('{{ session('success') ?? session('success') }}', '@lang('l.success')');
                    @endif

                    @if (session('error'))
                        toastr.error('{{ session('error') }}', '@lang('l.error')');
                    @endif

                    @if (session('warning'))
                        toastr.warning('{{ session('warning') }}', '@lang('l.warning')');
                    @endif

                    @if (session('info'))
                        toastr.info('{{ session('info') }}', '@lang('l.info')');
                    @endif
                @endif

                // معالجة الملاحظات
                function checkNotes() {
                    fetch('{{ route('dashboard.admins.notes-check') }}', {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            if (data.notesCount > 0) {
                                toastr.clear();
                                toastr.options = {
                                    ...commonToastrOptions,
                                    timeOut: 0,
                                    extendedTimeOut: 0,
                                    progressBar: false
                                };

                                toastr.warning(
                                    `@lang('l.You have') ${data.notesCount} @lang('l.active notes')
                                <br><a href="{{ route('dashboard.admins.notes-show') }}" class="btn btn-sm btn-warning mt-2">@lang('l.View Notes')</a>`,
                                    '@lang('l.Notes Reminder')'
                                );
                            }
                        })
                        .catch(error => console.error('Error when checking notes:', error));
                }

                // جدولة فحص الملاحظات
                setTimeout(() => {
                    checkNotes();
                    setInterval(checkNotes, 3600000);
                }, 3600000);
            });
        </script>

        <!-- Tagify -->
        <script>
            new Tagify(document.getElementById('meta_keywords'));
        </script>

        <!-- Quill -->
        <script>
            const fullToolbar = [
                [{
                        font: []
                    },
                    {
                        size: []
                    }
                ],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                        color: []
                    },
                    {
                        background: []
                    }
                ],
                [{
                        script: 'super'
                    },
                    {
                        script: 'sub'
                    }
                ],
                [{
                        header: '1'
                    },
                    {
                        header: '2'
                    },
                    'blockquote',
                    'code-block'
                ],
                [{
                        list: 'ordered'
                    },
                    {
                        list: 'bullet'
                    },
                    {
                        indent: '-1'
                    },
                    {
                        indent: '+1'
                    }
                ],
                [
                    'direction',
                    {
                        align: []
                    }
                ],
                ['link', 'image', 'video', 'formula'],
                ['clean']
            ];
        </script>

        <!-- file upload -->
        <script src="{{ asset('assets/themes/default/vendor/libs/dropzone/dropzone.js') }}"></script>

        <script>

            const previewTemplate = `<div class="dz-preview dz-file-preview">
      <div class="dz-details">
        <div class="dz-filename"><span data-dz-name></span></div>
        <div class="dz-size" data-dz-size></div>
        <img data-dz-thumbnail />
      </div>
      <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
      <div class="dz-success-mark"><span>✔</span></div>
      <div class="dz-error-mark"><span>✘</span></div>
      <div class="dz-error-message"><span data-dz-errormessage></span></div>
    </div>`;
                                        const myDropzone = new Dropzone('#dropzone-basic', {
                                            previewTemplate: previewTemplate,
                                            parallelUploads: 1,
                                            maxFilesize: 5,
                                            addRemoveLinks: true,
                                            maxFiles: 1
                                        });
                                      </script>
        @yield('js')

    </body>

</html>
