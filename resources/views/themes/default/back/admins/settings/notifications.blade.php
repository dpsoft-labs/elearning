<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-white">
                <i class="fas fa-bell me-2"></i>@lang('l.Notifications settings')
            </h5>
        </div>

        <!-- بداية التبويبات -->
        <ul class="nav nav-pills nav-fill mt-3 mx-3" id="notificationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email"
                    type="button" role="tab">
                    <i class="fas fa-envelope me-2"></i>@lang('l.Email settings')
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sms-tab" data-bs-toggle="tab" data-bs-target="#sms" type="button"
                    role="tab">
                    <i class="fas fa-sms me-2"></i>@lang('l.SMS settings')
                </button>
            </li>
        </ul>

        <!-- محتوى التبويبات -->
        <div class="tab-content p-3" id="notificationTabsContent">
            <!-- تبويب البريد الإلكتروني -->
            <div class="tab-pane fade show active" id="email" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <form id="emailForm" action="{{ route('dashboard.admins.settings-update') }}" class="card-body"
                        enctype="multipart/form-data" method="POST">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">@lang('l.SMTP settings')</h5>
                            <div class="form-check form-switch">
                                <input type="hidden" name="email_enabled" value="0">
                                <input class="form-check-input me-2" type="checkbox" id="emailToggle"
                                    name="email_enabled"
                                    value="1"
                                    style="width: 3rem; height: 1.5rem;"
                                    onchange="toggleEmailForm(this)"
                                    {{ isset($settings['email_enabled']) && $settings['email_enabled'] == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="emailToggle">@lang('l.Enable email notifications')</label>
                            </div>
                        </div>
                        <div>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="siteEmail" name="email"
                                            value="{{ $settings['email'] }}" placeholder="@lang('l.Email')">
                                        <label for="siteEmail">@lang('l.Email')</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="emailPassword"
                                            name="MAIL_PASSWORD" value="{{ $settings['MAIL_PASSWORD'] }}"
                                            placeholder="@lang('l.Password')">
                                        <label for="emailPassword">@lang('l.Password')</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="emailServer" name="MAIL_HOST"
                                            value="{{ $settings['MAIL_HOST'] }}" placeholder="@lang('l.SMTP server')">
                                        <label for="emailServer">@lang('l.SMTP server')</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="emailPort" name="MAIL_PORT"
                                            value="{{ $settings['MAIL_PORT'] }}" placeholder="@lang('l.Port')">
                                        <label for="emailPort">@lang('l.Port')</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="emailProtocol" name="MAIL_ENCRYPTION">
                                            <option value="tls"
                                                {{ $settings['MAIL_ENCRYPTION'] == 'tls' ? 'selected' : '' }}>TLS
                                            </option>
                                            <option value="ssl"
                                                {{ $settings['MAIL_ENCRYPTION'] == 'ssl' ? 'selected' : '' }}>SSL
                                            </option>
                                        </select>
                                        <label for="emailProtocol">@lang('l.Encryption type')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>@lang('l.Save changes')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- تبويب الرسائل النصية -->
            <div class="tab-pane fade" id="sms" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">@lang('l.SMS settings')</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input me-2" type="checkbox" id="smsToggle"
                                    {{ isset($settings['sms_enabled']) && intval($settings['sms_enabled']) === 1 ? 'checked' : '' }}
                                    style="width: 3rem; height: 1.5rem;" onchange="toggleSmsFrame(this)">
                                <label class="form-check-label" for="smsToggle">@lang('l.Enable SMS notifications')</label>
                            </div>
                        </div>
                        <div id="smsFrame" class="iframe-container rounded"
                            style="height: 500px; width: 100%; border: 1px solid #dee2e6; overflow: hidden;">
                            <form id="smsPostForm" action="{{ env('SMS_URL') }}" method="POST" target="smsIframe">
                                <input type="hidden" name="license" value="{{ env('LICENSE') }}">
                                @php
                                    $domain = request()->getHost();
                                @endphp
                                <input type="hidden" name="domain" value="{{ $domain }}">
                            </form>
                            <iframe name="smsIframe" style="width: 100%; height: 100%; border: none;"
                                title="SMS Service Integration">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEmailForm(toggle) {
        const form = document.getElementById('emailForm');
        const inputs = form.querySelectorAll('input:not([type="checkbox"]):not([name="_token"]):not([name="email_enabled"])');
        const selects = form.getElementsByTagName('select');

        // تعطيل/تفعيل حقول الإدخال
        inputs.forEach(input => {
            input.disabled = !toggle.checked;
        });

        // تعطيل/تفعيل القوائم المنسدلة
        Array.from(selects).forEach(select => {
            select.disabled = !toggle.checked;
        });

        // تأثير الشفافية فقط على الحقول
        const formContent = form.querySelector('.row');
        if (!toggle.checked) {
            formContent.classList.add('opacity-50');
        } else {
            formContent.classList.remove('opacity-50');
        }
    }

    function toggleSmsFrame(toggle) {
        fetch('{{ route('dashboard.admins.settings-update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    sms_enabled: toggle.checked ? 1 : 0
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                toastr.success('@lang('l.Settings Updated Successfully')');
            })
            .catch(error => {
                toastr.success('@lang('l.Settings Updated Successfully')');
            });

        const frame = document.getElementById('smsFrame');
        if (!toggle.checked) {
            frame.classList.add('opacity-50');
            frame.style.pointerEvents = 'none';
        } else {
            frame.classList.remove('opacity-50');
            frame.style.pointerEvents = 'auto';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const smsToggle = document.getElementById('smsToggle');
        const frame = document.getElementById('smsFrame');

        if (!smsToggle.checked) {
            frame.classList.add('opacity-50');
            frame.style.pointerEvents = 'none';
        }

        document.getElementById('smsPostForm').submit();
    });

    // تهيئة الحالة الأولية عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        const emailToggle = document.getElementById('emailToggle');
        const initialState = {{ isset($settings['email_enabled']) && $settings['email_enabled'] == 1 ? 'true' : 'false' }};

        emailToggle.checked = initialState;
        toggleEmailForm(emailToggle);
    });
</script>
