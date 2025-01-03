@php
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite(['resources/js/pages/auth-register.js'])
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
        <img src="{{asset('assets/img/illustrations/girl-with-laptop-'.$configData['style'].'.png')}}" class="img-fluid scaleX-n1-rtl" alt="Login image" width="700" data-app-dark-img="illustrations/girl-with-laptop-dark.png" data-app-light-img="illustrations/girl-with-laptop-light.png">

      </div>
    </div>
    <!-- /Left Text -->

    <!-- Register -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
      <div class="w-px-400 mx-auto mt-12 pt-5">
        <h4 class="mb-1">Adventure starts here 🚀</h4>
        <p class="mb-6">Make your app management easy and fun!</p>

        <div class="d-flex justify-content-center">
          <a href="{{ route('social.oauth', 'google') }}" class="btn btn-outline-primary  w-100">
            <svg class="shrink-0" width="22" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M23.001 12.2332C23.001 11.3699 22.9296 10.7399 22.7748 10.0865H12.7153V13.9832H18.62C18.501 14.9515 17.8582 16.4099 16.4296 17.3898L16.4096 17.5203L19.5902 19.935L19.8106 19.9565C21.8343 18.1249 23.001 15.4298 23.001 12.2332Z" fill="#4285F4"></path>
              <path d="M12.714 22.5C15.6068 22.5 18.0353 21.5666 19.8092 19.9567L16.4282 17.3899C15.5235 18.0083 14.3092 18.4399 12.714 18.4399C9.88069 18.4399 7.47596 16.6083 6.61874 14.0766L6.49309 14.0871L3.18583 16.5954L3.14258 16.7132C4.90446 20.1433 8.5235 22.5 12.714 22.5Z" fill="#34A853"></path>
              <path d="M6.62046 14.0767C6.39428 13.4234 6.26337 12.7233 6.26337 12C6.26337 11.2767 6.39428 10.5767 6.60856 9.92337L6.60257 9.78423L3.25386 7.2356L3.14429 7.28667C2.41814 8.71002 2.00146 10.3084 2.00146 12C2.00146 13.6917 2.41814 15.29 3.14429 16.7133L6.62046 14.0767Z" fill="#FBBC05"></path>
              <path d="M12.7141 5.55997C14.7259 5.55997 16.083 6.41163 16.8569 7.12335L19.8807 4.23C18.0236 2.53834 15.6069 1.5 12.7141 1.5C8.52353 1.5 4.90447 3.85665 3.14258 7.28662L6.60686 9.92332C7.47598 7.39166 9.88073 5.55997 12.7141 5.55997Z" fill="#EB4335"></path>
          </svg> &nbsp;Login with Google
          </a>
        </div>
        <div class="divider my-6">
          <div class="divider-text">or</div>
        </div>
        <form id="formAuthentication" class="mb-6 row" method="POST" action="{{ route('register') }}">
            @csrf
          <div class="mb-3 col-6">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control " id="firstname" name="firstname" placeholder="First Name" autofocus required>
            @error('firstname')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3 col-6">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
            @error('lastname')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control" name="password" placeholder="" aria-describedby="password" required/>
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
              <label class="form-check-label" for="terms-conditions">
                I agree to
                <a href="javascript:void(0);">privacy policy & terms</a>
              </label>
            </div>
          </div>
          @if (session('success'))
            <div class="link-wrap" style="color: green; font-size: 12px;">
              {{ session('success') }}
            </div>
          @endif
          @if (session('error'))
            <div class="link-wrap" style="color: red; font-size: 12px;">
              {{ session('error') }}
            </div>
          @endif
          <button class="btn btn-primary d-grid w-100">
            Sign up with email
          </button>
        </form>

        <p class="text-center">
          <span>Already have an account?</span>
          <a href="{{route('login') }}">
            <span>Sign in instead</span>
          </a>
        </p>

        {{-- <div class="divider my-4">
          <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center">
          <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-icon btn-label-facebook me-3">
            <i class="tf-icons bx bxl-facebook"></i>
          </a>

          <a href="{{ route('social.oauth', 'google') }}" class="btn btn-icon btn-label-google-plus me-3">
            <i class="tf-icons bx bxl-google-plus"></i>
          </a>

          <a href="{{ route('social.oauth', 'linkedin') }}" class="btn btn-icon btn-label-linkedin">
            <i class="tf-icons bx bxl-linkedin"></i>
          </a>
        </div> --}}
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
@endsection
