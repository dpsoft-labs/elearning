@extends('themes.default.auth.layout')

@section('title')
    @lang('l.Verify Email')
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
                <img src="{{ asset('assets/themes/default/img/illustrations/boy-verify-email-light.png') }}"
                    class="img-fluid" alt="Login image" width="700"
                    data-app-dark-img="illustrations/boy-verify-email-dark.png"
                    data-app-light-img="illustrations/boy-verify-email-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!--  Verify email -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-6 p-sm-12">
            <div class="w-px-400 mx-auto mt-12 mt-5">
                <h4 class="mb-1">@lang('l.Verify your email') ✉️</h4>
                <p class="text-start mb-0">
                    @lang('l.Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')
                </p>
                @if (session('status') == 'verification-link-sent')
                    <div>
                        <p style="color: green; font-size:small;">@lang('l.A new verification link has been sent to the email address you provided during registration.')</p>
                    </div>
                @endif
                <form class="register-form" id="login-form" action="{{ route('verification.send') }}" method="POST">@csrf
                    <button class="btn btn-primary w-100 my-6" type="submit"> @lang('l.Resend Verification Email') </button>
                </form>
                <p class="text-center mb-0">
                    @lang('l.or')
                <form method="POST" action="{{ route('logout') }}" class="text-center"> @csrf
                    <a href="javascript:void(0);" onclick="event.preventDefault(); this.closest('form').submit();">
                        @lang('l.Logout') </a>
                </form>
                </p>
            </div>
        </div>
        <!-- / Verify email -->
    </div>
@endsection


@section('page-scripts')
@endsection
