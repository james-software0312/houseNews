@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    {{-- @vite(['resources/js/pages/auth-forgot.js']) --}}
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{url('/')}}" class="auth-cover-brand d-flex align-items-center gap-2">
            <span class="app-brand-logo demo">
            <img src="{{asset('assets/img/logo.png')}}" alt="footer-logo" class="float-center">
            </span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">

            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
                <div class="w-100 d-flex justify-content-center">
                    <img src="{{ asset('assets/img/illustrations/girl-unlock-password-' . $configData['style'] . '.png') }}"
                        class="img-fluid" alt="Login image" width="600"
                        data-app-dark-img="illustrations/girl-unlock-password-dark.png"
                        data-app-light-img="illustrations/girl-unlock-password-light.png">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Forgot Password -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
                <div class="w-px-400 mx-auto mt-12 mt-5">
                    <h4 class="mb-1">Forgot Password? 🔒</h4>
                    <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>
                    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter your email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('success') || session('error'))
                            <div class="link-wrap"
                                style="color:  @if (session('success')) green @else  red @endif ;">
                                {{ session('success') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
                    </form>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                            Back to login
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
        </div>
    </div>
@endsection
