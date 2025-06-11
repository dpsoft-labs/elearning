@extends('themes.default.auth.layout')

@section('title')
    @lang('l.Forgot Password')
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
                <img src="{{ asset('assets/themes/default/img/illustrations/girl-unlock-password-light.png') }}"
                    class="img-fluid scaleX-n1-rtl" alt="Login image" width="700"
                    data-app-dark-img="illustrations/girl-unlock-password-dark.png"
                    data-app-light-img="illustrations/girl-unlock-password-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Forgot Password -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
            <div class="w-px-400 mx-auto mt-12 mt-5">
                <h4 class="mb-1">@lang('l.Forgot Password') 🔒</h4>
                <p class="mb-6">@lang('l.Enter your email and we\'ll send you instructions to reset your password')</p>
                <form id="formAuthentication" class="mb-6" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="email" class="form-label">@lang('l.Email')</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="@lang('l.Enter your email')" autofocus required />
                        @if ($errors->has('email'))
                            <div class="mt-2" style="color: red;">
                                @lang('l.Email is invalid')
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="mt-2" style="color: green;">
                                @lang('l.We have sent you a link to reset your password')
                            </div>
                        @endif
                    </div>

                    <button class="btn btn-primary d-grid w-100" type="submit">@lang('l.Send Reset Link')</button>
                </form>
                <div class="text-center">
                    <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left scaleX-n1-rtl me-1_5 align-top"></i>
                        @lang('l.Back to login')
                    </a>
                </div>
            </div>
        </div>
        <!-- /Forgot Password -->
    </div>
@endsection


@section('page-scripts')
    <script src="{{ asset('assets/themes/default/js/pages-auth.js') }}"></script>
@endsection
