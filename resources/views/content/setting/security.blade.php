@php
 $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Account Security')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-account-settings.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite([
  'resources/js/pages/account-settings-security.js'
])
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="nav-align-top">
      <ul class="nav nav-pills flex-column flex-md-row mb-6">
        <li class="nav-item"><a class="nav-link" href="{{route('setting.account')}}"><i class="bx-sm bx bx-user me-1_5"></i> Account</a></li>
        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx-sm bx bx-lock-alt me-1_5"></i> Security</a></li>
      </ul>
    </div>

    <!-- Two-steps verification -->
    <div class="card mb-6">
      <div class="card-header">
        <h5 class="mb-0">Login Email</h5>
      </div>
      <div class="card-body pt-0">
        <h6 class="mb-1">Email</h6>
        <div class="mb-4">
          <div class="d-flex w-100 action-icons">
            <input id="defaultInput" class="form-control me-4" type="text" placeholder="" value="{{ $user->email }}" readonly>
            <a href="javascript:;" class="btn btn-icon text-secondary" data-bs-target="#enableOTP" data-bs-toggle="modal"><i class="bx bx-edit bx-md"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!--/ Two-steps verification -->
    <!-- Change Password -->
    <div class="card mb-6">
      <h5 class="card-header">Change Password</h5>
      <div class="card-body pt-1">
        <form id="formAccountSettings" method="POST" action="{{ route('setting.update_password') }}">
          @csrf
          @if($user->password != "password")
          <div class="row">
            <div class="mb-6 col-md-6 form-password-toggle">
              <label class="form-label" for="currentPassword">Current Password</label>
              <div class="input-group input-group-merge @error('currentPassword') has-validation @enderror">
                <input class="form-control" type="password" name="currentPassword" id="currentPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('currentPassword')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          @endif
          <div class="row">
            <div class="mb-6 col-md-6 form-password-toggle">
              <label class="form-label" for="newPassword">New Password</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-6 col-md-6 form-password-toggle">
              <label class="form-label" for="confirmPassword">Confirm New Password</label>
              <div class="input-group input-group-merge">
                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
          </div>
          <h6 class="text-body">Password Requirements:</h6>
          <ul class="ps-4 mb-0">
            <li class="mb-4">Minimum 8 characters </li>
            <li class="mb-4">At least one higher case character</li>
            <li>At least one number or symbol character</li>
          </ul>
          <div class="mt-6">
            <button type="submit" class="btn btn-primary me-3">Save changes</button>
            <button type="reset" class="btn btn-label-secondary">Reset</button>
          </div>
          <div class="mt-1">
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
          </div>
        </form>
      </div>
    </div>
    <!--/ Change Password -->

  </div>
</div>
<!-- Enable OTP Modal -->
<div class="modal fade" id="enableOTP" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Verify Your Email</h4>
        </div>
        <p id="instruction">Enter your email and we will send you a verification code.</p>
        <form id="enableOTPForm" class="row g-6" onsubmit="return false">
          <div class="col-12" id="email-input">
            <label class="form-label" for="email">Email</label>
            <div class="input-group">
              <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required />
            </div>
          </div>
          <div class="col-12 d-none" id="code-input">
            <label class="form-label" for="verification_code">Code</label>
            <div class="input-group">
              <input type="text" id="verification_code" name="verification_code" class="form-control" placeholder="000000" minlength="6" maxlength="6" required />
            </div>
          </div>
          <div class="mt-1">
            <div class="link-wrap" id="alert" style="color: green; font-size: 12px;display:none;">
              We`ve sent the verification code to your email.
            </div>
          </div>
          <div class="col-12">
            <button type="submit" id="submit-btn" class="btn btn-primary me-3">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
