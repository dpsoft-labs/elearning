@extends('themes.default.layouts.back.master')

@section('title')
    @lang('l.Edit User')
@endsection

@section('css')
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
    <!-- تضمين ملفات CSS اللازمة -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">@lang('l.User Account') /</span>
            {{ $user->firstname }}
        </h4>
        @can('edit users')
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <div class="col-md-12">
                    <div id="page1">
                        <div class="card mb-4">
                            <h5 class="card-header">@lang('l.Profile Details')</h5>
                            <!-- Account -->
                            <div class="card-body">
                                <form class="d-flex align-items-start align-items-sm-center gap-4" method="post"
                                    action="#" enctype="multipart/form-data"> @csrf
                                    <img src="{{ $user->photo }}" style="height: 100px;" alt="user-avatar"
                                        class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                </form>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                <form id="formAccountSettings" method="POST"
                                    action="{{ route('dashboard.admins.users-update') }}"> @csrf @method('patch')
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">@lang('l.First Name')</label>
                                            <input class="form-control" type="text" id="firstName" name="firstname"
                                                value="{{ $user->firstname }}" autofocus required />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('firstname')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="lastName" class="form-label">@lang('l.Last Name')</label>
                                            <input class="form-control" type="text" name="lastname" id="lastName"
                                                value="{{ $user->lastname }}" required />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('lastname')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">@lang('l.E-mail')</label>
                                            <input class="form-control" type="text" id="email" name="email"
                                                value="{{ $user->email }}" placeholder="john.doe@example.com"
                                                required />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('email')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="phone">@lang('l.Phone Number')</label><br>
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ $user->phone }}" class="form-control" required>
                                            <input type="hidden" id="phone_code" name="phone_code" required>
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('phone')" />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('phone_code')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="country">@lang('l.Country')</label>
                                            <select id="country" class="select2 form-select" name="country">
                                                <option value="">{{ __('l.Select') }}</option>
                                                @foreach ($countries as $country)
                                                    <option {{ $user->country == $country->name ? 'selected' : '' }}
                                                        value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('country')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="city" class="form-label">@lang('l.City')</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ $user->city }}" placeholder="{{ __('l.City') }}" />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('city')" />
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="address" class="form-label">@lang('l.Address')</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                value="{{ $user->address }}" placeholder="{{ __('l.Address') }}" />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('address')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="state" class="form-label">@lang('l.State')</label>
                                            <input class="form-control" type="text" id="state" name="state"
                                                value="{{ $user->state }}" placeholder="{{ __('l.State') }}" />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('state')" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="zipCode" class="form-label">@lang('l.Zip Code')</label>
                                            <input type="text" class="form-control" id="zipCode"
                                                name="zip_code" value="{{ $user->zip_code }}" placeholder="11511"
                                                maxlength="8" />
                                            <x-input-error class="mt-2  error-message" :messages="$errors->get('zip_code')" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="{{ encrypt($user->id) }}" />
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">@lang('l.Save changes')</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /Account -->
                        </div>
                        @can('delete users')
                            <div class="card">
                                <h5 class="card-header">@lang('l.Delete Account')</h5>
                                <div class="card-body">
                                    <div class="mb-3 col-12 mb-0">
                                        <div class="alert alert-warning">
                                            <h5 class="alert-heading mb-1">@lang('l.Are you sure you want to delete this account?')
                                            </h5>
                                            <p class="mb-0">@lang('l.Once you delete this account, there is no going back. Please be certain.')</p>
                                        </div>
                                    </div>
                                    <form id="formAccountDeactivation" method="get"
                                        action="{{ route('dashboard.admins.users-inactive') }}">@csrf
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                                id="accountActivation" required />
                                            <label class="form-check-label" for="accountActivation">@lang('l.I confirm this account deactivation')</label>
                                        </div>
                                        <input type="hidden" name="id" value="{{ encrypt($user->id) }}" />
                                        <button type="submit" class="btn btn-danger deactivate-account">@lang('l.Deactivate Account')</button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <div id="page2">
                        <!-- Change Password -->
                        <div class="card mb-4 mt-5">
                            <h5 class="card-header">@lang('l.Change Password')</h5>
                            <div class="card-body">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <h5 class="alert-heading mb-1">@lang('l.Password Requirements:')</h5>
                                    <span>@lang('l.Minimum 8 characters long, uppercase &amp; symbol')</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <form id="formAccountSettings5" method="POST"
                                    action="{{ route('dashboard.admins.users-updatepassword') }}"> @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="newPassword">@lang('l.New Password')</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password" id="newPassword"
                                                    name="password" required
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2  error-message" />
                                        </div>

                                        <div class="mb-3 col-md-6 form-password-toggle">
                                            <label class="form-label" for="confirmPassword">@lang('l.Confirm New Password')</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="password"
                                                    name="password_confirmation" id="confirmPassword" required
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2  error-message" />
                                        </div>
                                        <input type="hidden" name="id" value="{{ encrypt($user->id) }}" />
                                        <div>
                                            <button type="submit" class="btn btn-primary me-2">@lang('l.Save changes')</button>
                                            {{-- <button type="reset" class="btn btn-label-secondary">Cancel</button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/ Change Password -->

                        @can('edit users')
                            <!-- assign a role -->
                            <div class="card mb-4">
                                <h5 class="card-header">@lang('l.Assign a Role to') {{ $user->firstname }}</h5>
                                <div class="row">
                                    <div class="col-md-5 order-md-0 order-1">
                                        <div class="card-body">
                                            <form id="formAccountSettingsApiKey" method="POST"
                                                action="{{ route('dashboard.admins.users-role') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="mb-3 col-12">
                                                        <label for="apiAccess" class="form-label">@lang('l.Choose the role name you want to assign')</label>
                                                        <select name="role" class="select2 form-select" required>
                                                            <option value="">{{ __('l.Choose Role Name') }}</option>
                                                            @foreach ($roles as $role)
                                                                @if ($role->name != 'root')
                                                                    <option value="{{ $role->name }}"
                                                                        @if ($user->roles->first() && $role->name == $user->roles->first()->name) selected @endif>
                                                                        {{ $role->name }}
                                                                    </option>
                                                                    @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="id"
                                                        value="{{ encrypt($user->id) }}" />
                                                    <div class="col-12">
                                                        <button type="submit"
                                                            class="btn btn-primary me-2 d-grid w-100">@lang('l.Assign')</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="formAccountSettingsApiKey5" method="POST"
                                                action="{{ route('dashboard.admins.users-roledelete') }}">
                                                @csrf
                                                <div class="row mt-2">
                                                    <input type="hidden" name="id"
                                                        value="{{ encrypt($user->id) }}" />
                                                    <div class="col-12">
                                                        <button type="submit"
                                                            class="btn btn-danger me-2 d-grid w-100">@lang('l.Delete all Roles')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-7 order-md-1 order-0">
                                        <div class="text-center mt-4 mx-3 mx-md-0">
                                            <img src="{{ asset('assets/themes/default/img/illustrations/sitting-girl-with-laptop.png') }}"
                                                class="img-fluid" alt="Api Key Image" width="202" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ assign a role  -->
                        @endcan
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection


@section('js')
    <!-- تضمين ملفات JS اللازمة -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <!-- تهيئة الحقل -->
    <script>
        $(document).ready(function() {
            // إنشاء حقل إدخال رقم الهاتف بشكل دولي
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                initialCountry: "gb",
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
@endsection
