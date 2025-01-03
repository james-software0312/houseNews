@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Verify Email')

@section('page-style')
    <!-- Page -->
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('page-script')
@vite(['resources/js/pages/auth-verify.js'])
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
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-6 p-sm-12">
                <div class="w-px-400 mx-auto mt-12 mt-5">
                    <h4 class="mb-1">Verify your email ✉️</h4>
                    <p class="text-start mb-0">
                        Account activation link sent to your email address: hello@example.com Please follow the link inside
                        to continue.
                    </p>
                    <a class="btn btn-primary w-100 my-3" href="{{ route('login') }}">
                        Skip for now
                    </a>
                    <input type="hidden" id="email" value="{{$email}}" />
                    <p class="text-center">Didn't get the mail?
                        <a href="javascript:void(0);" class="ms-2" id="resend">
                            Resend
                        </a>
                    </p>
                </div>
            </div>
            <!-- / Verify email -->
        </div>
    </div>
@endsection
