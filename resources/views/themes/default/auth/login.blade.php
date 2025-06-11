@extends('themes.default.auth.layout')

@section('title')
    @lang('l.Login')
@endsection

@section('description')
@endsection

@section('page-css')
@endsection


@section('content')
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="{{ asset('assets/themes/default/img/illustrations/boy-with-rocket-light.png') }}"
                    class="img-fluid" alt="Login image" width="700"
                    data-app-dark-img="illustrations/boy-with-rocket-dark.png"
                    data-app-light-img="illustrations/boy-with-rocket-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
            <div class="w-px-400 mx-auto mt-12 pt-5">
                <h4 class="mb-1">@lang('l.Welcome to') {{ $settings['name'] }}! 👋</h4>
                <p class="mb-6">@lang('l.Please sign-in to your account and start the adventure')</p>

                <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="email" class="form-label">@lang('l.Email or Phone')</label>
                        <input type="text" class="form-control" id="email" name="email"
                            placeholder="@lang('l.Enter your email or phone number')" autofocus required
                            @if (isset($_COOKIE['remember_user'])) value="{{ $_COOKIE['remember_user'] }}"
                            @else
                                value="{{ old('email') }}" @endif />
                        @if ($errors->has('email'))
                            <div class="mt-2" style="color: red; padding-left: 10px; padding-right: 10px;">
                                {{ $errors->first('email') }}</div>
                        @endif
                        @if ($errors->has('limit'))
                            <div class="mt-2" style="color: red; padding-left: 10px; padding-right: 10px;">
                                {{ $errors->first('limit') }}</div>
                        @endif
                    </div>
                    <div class="mb-6 form-password-toggle">
                        <label class="form-label" for="password">@lang('l.Password')</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password" required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"
                                @if (isset($_COOKIE['remember_pass'])) <?php $password = decrypt($_COOKIE['remember_pass']); ?>
                                    value="{{ $password }}"
                                @else
                                    value="{{ old('password') }}" @endif />
                            <span class="input-group-text cursor-pointer" style="z-index: 999;"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>
                    <div class="my-8">
                        <div class="d-flex justify-content-between">
                            <div class="form-check mb-0 ms-2">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                                    @if (isset($_COOKIE['remember_user'])) checked @endif />
                                <label class="form-check-label" for="remember-me">@lang('l.Remember Me')</label>
                            </div>
                            <a href="{{ route('password.request') }}">
                                <p class="mb-0">@lang('l.Forgot Password?')</p>
                            </a>
                        </div>
                    </div>
                    <button class="btn btn-primary d-grid w-100" type="submit">@lang('l.Sign in')</button>
                </form>

                @if ($settings['can_any_register'] == 1)
                    <p class="text-center">
                        <span>@lang('l.New on our platform?')</span>
                        <a href="{{ route('register') }}">
                            <span>@lang('l.Create an account')</span>
                        </a>
                    </p>
                @endif

                <div class="divider my-6">
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
                        <a href="{{ route('auth.twitter') }}" class="btn btn-icon btn-label-twitter {{ $btnWidth }}">
                            <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /Login -->
    </div>
@endsection


@section('page-scripts')
    <script src="{{ asset('assets/themes/default/js/pages-auth.js') }}"></script>
@endsection
