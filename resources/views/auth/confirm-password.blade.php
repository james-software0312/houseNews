@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Confirm Password')

@section('page-style')
    <!-- Page -->
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
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
                    <img src="{{ asset('assets/img/illustrations/boy-verify-email-' . $configData['style'] . '.png') }}"
                        class="img-fluid" alt="Login image" width="700"
                        data-app-dark-img="illustrations/boy-verify-email-dark.png"
                        data-app-light-img="illustrations/boy-verify-email-light.png">

                </div>
            </div>
            <!-- /Left Text -->

            <!--  Verify email -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-4 p-sm-5">
                <div class="w-px-400 mx-auto">
                    <h3 class="mb-2">Password Changed.</h3>
                    <p class="text-start">
                        Your password was changed successfuly.<br />
                        You can login now.
                    </p>
                    <a class="btn btn-primary w-100 my-3" href="{{ route('login') }}">
                        Login
                    </a>
                </div>
            </div>
            <!-- / Verify email -->
        </div>
    </div>
@endsection
