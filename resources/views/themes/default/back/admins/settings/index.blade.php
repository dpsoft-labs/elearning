@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Settings')
@endsection

@section('css')
    <style>
        .settings-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .settings-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .settings-icon {
            font-size: 50px;
            margin-bottom: 15px;
            transition: transform 0.3s;
        }

        .settings-card:hover .settings-icon {
            transform: rotate(20deg);
        }
    </style>

    <style>
        [dir="rtl"] .preview-arrow .fa-arrow-right {
            transform: rotate(180deg) !important;
        }

        /* أو يمكنك استخدام هذا البديل */
        [dir="rtl"] .image-preview-container {
            flex-direction: row-reverse !important;
        }

        .preview-arrow {
            animation: fadeIn 0.3s ease-in-out;
        }

        .new-preview {
            animation: slideIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endsection

@section('content')
    @can('show settings')
        <div class="container-xxl flex-grow-1 container-p-y">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (request()->get('tab') == null)
                <div class="container mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>@lang('l.Settings')</h2>
                        @can('edit settings')
                            <form action="{{ route('dashboard.admins.clear-cache') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt me-1"></i>
                                    @lang('l.Clear Cache')
                                </button>
                            </form>
                        @endcan
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=general">
                                    <div class="settings-icon">⚙️</div>
                                    <h5>@lang('l.General')</h5>
                                    <p class="text-muted">@lang('l.General settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=contact">
                                    <div class="settings-icon">☎</div>
                                    <h5>@lang('l.Contact')</h5>
                                    <p class="text-muted">@lang('l.Contact settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.seo') }}">
                                    <div class="settings-icon">🔍</div>
                                    <h5>@lang('l.SEO')</h5>
                                    <p class="text-muted">@lang('l.SEO settings')</p>
                                </a>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=email">
                                    <div class="settings-icon">📧</div>
                                    <h5>@lang('l.Email')</h5>
                                    <p class="text-muted">@lang('l.Email settings')</p>
                                </a>
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=security">
                                    <div class="settings-icon">🔒</div>
                                    <h5>@lang('l.Security')</h5>
                                    <p class="text-muted">@lang('l.Security settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=notifications">
                                    <div class="settings-icon">🔔</div>
                                    <h5>@lang('l.Notifications')</h5>
                                    <p class="text-muted">@lang('l.Notifications settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=socialAuth">
                                    <div class="settings-icon" style="font-size: 50px;">
                                        <i class="fab fa-facebook" style="color: #1877f2;"></i>
                                        <i class="fab fa-x-twitter" style="color: #000000;"></i>
                                        <i class="fab fa-google"
                                            style="background: linear-gradient(to right, #4285f4, #db4437, #f4b400, #0f9d58); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                    </div>
                                    <h5>@lang('l.Social Auth')</h5>
                                    <p class="text-muted">@lang('l.Social Auth settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=themes">
                                    <div class="settings-icon">🎨</div>
                                    <h5>@lang('l.Themes')</h5>
                                    <p class="text-muted">@lang('l.Theme settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.languages') }}">
                                    <div class="settings-icon">🌍</div>
                                    <h5>@lang('l.Languages')</h5>
                                    <p class="text-muted">@lang('l.Languages settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.payments') }}">
                                    <div class="settings-icon">💳</div>
                                    <h5>@lang('l.Payment Gateways')</h5>
                                    <p class="text-muted">@lang('l.Payment gateway settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.currencies') }}">
                                    <div class="settings-icon">💶</div>
                                    <h5>@lang('l.Currencies')</h5>
                                    <p class="text-muted">@lang('l.Currencies settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.taxes') }}">
                                    <div class="settings-icon">🧾</div>
                                    <h5>@lang('l.Taxes')</h5>
                                    <p class="text-muted">@lang('l.Taxes settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=coding">
                                    <div class="settings-icon">👨‍💻</div>
                                    <h5>@lang('l.Coding')</h5>
                                    <p class="text-muted">@lang('l.Coding settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=update">
                                    <div class="settings-icon">🚀</div>
                                    <h5>@lang('l.Updates & Backups')</h5>
                                    <p class="text-muted">@lang('l.Available Updates & Backups')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=reset">
                                    <div class="settings-icon">🛠️</div>
                                    <h5>@lang('l.Reset')</h5>
                                    <p class="text-muted">@lang('l.Reset settings')</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="settings-card">
                                <a href="{{ route('dashboard.admins.settings') }}?tab=license">
                                    <div class="settings-icon">🔑</div>
                                    <h5>@lang('l.License')</h5>
                                    <p class="text-muted">@lang('l.License information')</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (request()->get('tab') == 'general')
                @include('themes.default.back.admins.settings.general')
            @elseif (request()->get('tab') == 'contact')
                @include('themes.default.back.admins.settings.contact')
            {{-- @elseif (request()->get('tab') == 'email')
                @include('themes.default.back.admins.settings.email') --}}
            @elseif (request()->get('tab') == 'notifications')
                @include('themes.default.back.admins.settings.notifications')
            @elseif (request()->get('tab') == 'security')
                @include('themes.default.back.admins.settings.security')
            @elseif (request()->get('tab') == 'socialAuth')
                @include('themes.default.back.admins.settings.socialAuth')
            @elseif (request()->get('tab') == 'themes')
                @include('themes.default.back.admins.settings.themes')
            @elseif (request()->get('tab') == 'coding')
                @include('themes.default.back.admins.settings.coding')
            @elseif (request()->get('tab') == 'update')
                @include('themes.default.back.admins.settings.update')
            @elseif (request()->get('tab') == 'reset')
                @include('themes.default.back.admins.settings.reset')
            @endif

        </div>
    @endcan
@endsection

@section('js')
    <script>
        document.querySelectorAll('.theme-label').forEach(label => {
            label.addEventListener('click', function() {
                document.querySelectorAll('.theme-label').forEach(lbl => lbl.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    </script>

    <script>
        document.querySelectorAll('.image-preview').forEach(input => {
            input.addEventListener('change', function(e) {
                const previewId = this.getAttribute('data-preview');
                const preview = document.getElementById(previewId);
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    // عرض السهم والصورة الجديدة
                    preview.closest('.d-flex').querySelector('.preview-arrow').classList.remove('d-none');
                    preview.classList.remove('d-none');

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }

                    reader.readAsDataURL(file);
                } else {
                    // إخفاء السهم والصورة الجديدة إذا لم يتم اختيار ملف
                    preview.closest('.d-flex').querySelector('.preview-arrow').classList.add('d-none');
                    preview.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
