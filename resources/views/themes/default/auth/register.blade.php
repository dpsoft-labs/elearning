@extends('themes.default.auth.layout')

@section('title')
    @lang('l.Register')
@endsection

@section('description')
@endsection

@section('page-css')
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
@endsection


@section('content')
    @if (!$settings['multistep_register'])
        {{-- ===========================================Mini registeration============================================== --}}
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-6 col-xl-6 align-items-center p-5">
                <div class="w-100 d-flex justify-content-center">
                    <img src="{{ asset('assets/themes/default/img/illustrations/girl-with-laptop-light.png') }}"
                        class="img-fluid scaleX-n1-rtl" alt="Login image" width="700"
                        data-app-dark-img="illustrations/girl-with-laptop-dark.png"
                        data-app-light-img="illustrations/girl-with-laptop-light.png" />
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Register -->
            <div class="d-flex col-12 col-lg-6 align-items-center p-sm-5 p-4">
                <div class=" mx-auto">

                    <h3 class="mb-1">@lang('l.Adventure starts here') 🚀</h3><br>
                    <!-- <p class="mb-4">Make your app work easy and fun!</p> -->

                    <form id="formAuthentication" class="mb-3" method="post" action="{{ route('register') }}"> @csrf
                        <div class="mb-3" style="display: flex;">
                            <div class="col-md-6" style="margin-right: 2px;">
                                <label for="firstname" class="form-label">@lang('l.First Name')</label>
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="@lang('l.Enter your first name')" autofocus required />
                                <x-input-error class="mt-2  error-message" :messages="$errors->get('firstname')" />
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">@lang('l.Last Name')</label>
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    placeholder="@lang('l.Enter your last name')" required />
                                <x-input-error class="mt-2  error-message" :messages="$errors->get('lastname')" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">@lang('l.Email')</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="@lang('l.Enter your email')" required />
                            @error('email')
                                <span class="text-danger">@lang('l.This email is already in use!')</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">@lang('l.Mobile')</label>
                            <input type="hidden" id="phone_code" name="phone_code" required>
                            <div class="input-group">
                                <input type="tel" id="phone" name="phone"
                                    class="form-control multi-steps-mobile" required />
                            </div>
                            <x-input-error class="mt-2 error-message" :messages="$errors->get('phone')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">@lang('l.Password')</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    aria-describedby="password" minlength="8"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    required />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            <x-input-error class="mt-2  error-message" :messages="$errors->get('password')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="multiStepsConfirmPass">@lang('l.Confirm Password')</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="multiStepsConfirmPass" name="password_confirmation"
                                    class="form-control" minlength="8"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multiStepsConfirmPass2" required />
                                <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms"
                                    required />
                                <label class="form-check-label" for="terms-conditions">
                                    @lang('l.I agree to')
                                    <a href="{{ route('terms') }}">@lang('l.privacy policy & terms')</a>
                                </label>
                            </div>
                        </div>
                        @if ($settings['recaptcha'])
                            <div class="g-recaptcha mb-3" data-sitekey="{{ config('app.recaptcha.key') }}">
                            </div>
                            {{-- disable the submit function in js file and use submit function down --}}
                            <input type="hidden" name="disabled-submit" id="disabled-submit">
                        @endif
                        <button class="btn btn-primary d-grid w-100" id="submitButton"
                            type="submit">@lang('l.Sign up')</button>
                    </form>

                    <p class="text-center">
                        <span>@lang('l.Already have an account?')</span>
                        <a href="{{ route('login') }}">
                            <span>@lang('l.Sign in instead')</span>
                        </a>
                    </p>

                    <div class="divider">
                        <div class="divider-text">@lang('l.or')</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        @php
                            $activeLogins = collect([
                                $settings['facebookLogin'],
                                $settings['googleLogin'],
                                $settings['twitterLogin'],
                            ])
                                ->filter()
                                ->count();

                            $btnWidth = $activeLogins === 1 ? 'w-100' : ($activeLogins === 2 ? 'w-50' : '');
                        @endphp

                        @if ($settings['facebookLogin'])
                            <a href="{{ route('auth.facebook') }}"
                                class="btn btn-icon btn-label-facebook {{ $btnWidth }} me-3">
                                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                            </a>
                        @endif
                        @if ($settings['googleLogin'])
                            <a href="{{ route('auth.google') }}"
                                class="btn btn-icon btn-label-google-plus {{ $btnWidth }} me-3">
                                <i class="tf-icons fa-brands fa-google fs-5"></i>
                            </a>
                        @endif
                        @if ($settings['twitterLogin'])
                            <a href="{{ route('auth.twitter') }}"
                                class="btn btn-icon btn-label-twitter {{ $btnWidth }}">
                                <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    @else
        {{-- ===========================================Full registeration============================================== --}}
        <div class="authentication-inner row m-0">
            <!-- Left Text -->
            <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-end p-5 pe-0">
                <div class="w-px-400">
                    <img src="{{ asset('assets/img/illustrations/create-account-light.png') }}" class="img-fluid"
                        alt="multi-steps" width="600" data-app-dark-img="illustrations/create-account-dark.png"
                        data-app-light-img="illustrations/create-account-light.png" />
                </div>
            </div>
            <!-- /Left Text -->

            <!--  Multi Steps Registration -->
            <div class="d-flex col-lg-8 align-items-center justify-content-center authentication-bg p-5">
                <div class="w-px-700">
                    <div id="multiStepsValidation" class="bs-stepper border-none shadow-none mt-5">
                        <div class="bs-stepper-header border-none pt-12 px-0">
                            <div class="step" data-target="#accountDetailsValidation">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-home"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">@lang('l.Account')</span>
                                        <span class="bs-stepper-subtitle">@lang('l.Account Details')</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" data-target="#personalInfoValidation">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-user"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">@lang('l.Personal')</span>
                                        <span class="bs-stepper-subtitle">@lang('l.Enter Information')</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" data-target="#billingLinksValidation">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="bx bx-detail"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">@lang('l.Finish')</span>
                                        <span class="bs-stepper-subtitle">@lang('l.Submit')</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content px-0">
                            <form id="multiStepsForm" onSubmit="return false" method="post"
                                action="{{ route('register') }}"> @csrf
                                <!-- Account Details -->
                                <div id="accountDetailsValidation" class="content">
                                    <div class="content-header mb-4">
                                        <h3 class="mb-1">@lang('l.Account Information')</h3>
                                        <p>@lang('l.Enter Your Account Details')</p>
                                    </div>
                                    <div class="row g-3">

                                        <div class="col-sm-6 w-100">
                                            <label class="form-label" for="multiStepsEmail">@lang('l.Email')</label>
                                            <input type="email" name="email" id="multiStepsEmail"
                                                class="form-control" placeholder="john.doe@email.com"
                                                aria-label="john.doe" required />
                                            <div id="email-error" class="error-message mt-2"
                                                style="display:none; color:red"></div>
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('email')" />
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="multiStepsPass">@lang('l.Password')</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="multiStepsPass" name="password"
                                                    class="form-control"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="multiStepsPass2" />
                                                <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label"
                                                for="multiStepsConfirmPass">@lang('l.Confirm Password')</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="multiStepsConfirmPass"
                                                    name="password_confirmation" class="form-control"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="multiStepsConfirmPass2" />
                                                <span class="input-group-text cursor-pointer"
                                                    id="multiStepsConfirmPass2"><i class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button class="btn btn-label-secondary btn-prev" disabled>
                                                <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                                                <span
                                                    class="align-middle d-sm-inline-block d-none">@lang('l.Previous')</span>
                                            </button>
                                            <button class="btn btn-primary btn-next" id="checkEmail">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1 me-0">@lang('l.Next')</span>
                                                <i class="ti ti-arrow-right ti-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal Info -->
                                <div id="personalInfoValidation" class="content">
                                    <div class="content-header mb-4">
                                        <h3 class="mb-1">@lang('l.Personal Information')</h3>
                                        <p>@lang('l.Enter Your Personal Information')</p>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsFirstName">@lang('l.First Name')</label>
                                            <input type="text" id="multiStepsFirstName" name="firstname"
                                                class="form-control" placeholder="John" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsLastName">@lang('l.Last Name')</label>
                                            <input type="text" id="multiStepsLastName" name="lastname"
                                                class="form-control" placeholder="Doe" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="phone">@lang('l.Mobile')</label>
                                            <input type="hidden" id="phone_code" name="phone_code" required>
                                            <div class="input-group">
                                                <input type="tel" id="phone" name="phone"
                                                    class="form-control multi-steps-mobile" placeholder="202 555 0111" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="multiStepsState">@lang('l.Country')</label>
                                            <select id="multiStepsState" class="select2 form-select"
                                                data-allow-clear="true" name="country">
                                                <option value="">@lang('l.Select')</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="multiStepsCity">@lang('l.City')</label>
                                            <input type="text" id="multiStepsCity" name="city"
                                                class="form-control multi-steps-city" placeholder="city" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="multiStepsState">@lang('l.State')</label>
                                            <input type="text" id="multiStepsState" class="form-control"
                                                placeholder="Jackson" name="state" />
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="multiStepsPincode">@lang('l.Pincode')</label>
                                            <input type="text" id="multiStepsPincode" name="zip_code"
                                                class="form-control multi-steps-pincode" placeholder="Postal Code"
                                                maxlength="6" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="multiStepsAddress">@lang('l.Address')</label>
                                            <input type="text" id="multiStepsAddress" name="address"
                                                class="form-control" placeholder="Address" />
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                                                <span
                                                    class="align-middle d-sm-inline-block d-none">@lang('l.Previous')</span>
                                            </button>
                                            <button class="btn btn-primary btn-next">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1 me-0">@lang('l.Next')</span>
                                                <i class="ti ti-arrow-right ti-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="billingLinksValidation" class="content">
                                    <div class="content-header mb-4">
                                        <center>
                                            <h3 class="mb-1">@lang('l.We\'re almost there')</h3>
                                            <p>@lang('l.Thank you for choosing us, click submit to complete your registration')
                                            </p>

                                            @if ($settings['recaptcha'])
                                                <div class="g-recaptcha mb-3"
                                                    data-sitekey="{{ config('app.recaptcha.key') }}">
                                                </div>
                                                {{-- disable the submit function in js file and use submit function down --}}
                                                <input type="hidden" name="disabled-submit" id="disabled-submit">
                                            @endif
                                            <center>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left ti-xs me-sm-1 me-0"></i>
                                                <span
                                                    class="align-middle d-sm-inline-block d-none">@lang('l.Previous')</span>
                                            </button>
                                            <button type="submit" id="submitButton"
                                                class="btn btn-success btn-next btn-submit">@lang('l.Submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        @php
                            $activeLogins = collect([
                                $settings['facebookLogin'],
                                $settings['googleLogin'],
                                $settings['twitterLogin'],
                            ])
                                ->filter()
                                ->count();

                            $btnWidth = $activeLogins === 1 ? 'w-100' : ($activeLogins === 2 ? 'w-50' : '');
                        @endphp

                        @if ($settings['facebookLogin'])
                            <a href="{{ route('auth.facebook') }}"
                                class="btn btn-icon btn-label-facebook {{ $btnWidth }} me-3">
                                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                            </a>
                        @endif
                        @if ($settings['googleLogin'])
                            <a href="{{ route('auth.google') }}"
                                class="btn btn-icon btn-label-google-plus {{ $btnWidth }} me-3">
                                <i class="tf-icons fa-brands fa-google fs-5"></i>
                            </a>
                        @endif
                        @if ($settings['twitterLogin'])
                            <a href="{{ route('auth.twitter') }}"
                                class="btn btn-icon btn-label-twitter {{ $btnWidth }}">
                                <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- / Multi Steps Registration -->
        </div>
    @endif
@endsection


@section('page-scripts')
<script>
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();
</script>
<script src="{{ asset('assets/themes/default/js/pages-auth-multisteps.js') }}"></script>
<script src="{{ asset('assets/themes/default/js/pages-auth-register.js') }}"></script>

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
    });
</script>

@if ($settings['recaptcha'])
    <!-- google recaptcha required -->
    <script>
        window.addEventListener('load', () => {
            const $recaptcha = document.querySelector('#g-recaptcha-response');
            if ($recaptcha) {
                $recaptcha.setAttribute('required', 'required');
            }
        })
        // submit the form by js
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('submitButton');
            const form = document.getElementById('formAuthentication');

            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                // التحقق من جميع الحقول المطلوبة
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    return;
                }

                // إذا تم التحقق من جميع الحقول، قم بإرسال النموذج
                form.submit();
            });
        });
    </script>
@endif

<script>
    @if ($settings['multistep_register'] == 1)
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('submitButton');
            const form = document.getElementById('multiStepsForm');

            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                // التحقق من جميع الحقول المطلوبة
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    return;
                }

                // إذا تم التحقق من جميع الحقول، قم بإرسال النموذج
                form.submit();
            });
        });
    @endif

    // check email is avilable in database
    $(document).ready(function() {
        // التحقق من البريد الإلكتروني وإرسال النموذج عندما ينتقل المستخدم إلى حقل آخر
        $('#multiStepsEmail').on('blur', function() {
            var email = $('#multiStepsEmail').val();

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                return;
            }
            var csrfToken = "{{ csrf_token() }}";
            $.ajax({
                url: '{{route('auth.check-email')}}',
                method: 'post',
                data: {
                    email: email,
                    _token: csrfToken
                },
                success: function(response) {
                    if (response.status === 'used') {
                        $('#email-error').show().text('@lang('l.This email is already in use!')');
                        return false;
                    } else {
                        $('#email-error').hide().text('@lang('l.This email is already in use!')');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection
