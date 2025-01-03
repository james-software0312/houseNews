@extends('layouts/layoutMaster')

@section('title', 'Account Profile')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/pages/account-settings-account.js'])
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="nav-align-top">
      <ul class="nav nav-pills flex-column flex-md-row mb-6">
        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-sm bx-user me-1_5"></i> Account</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('setting.security')}}"><i class="bx bx-sm bx-lock-alt me-1_5"></i> Security</a></li>
        {{-- <li class="nav-item"><a class="nav-link" href="{{url('setting.idverification')}}"><i class="bx bx-sm bx-detail me-1_5"></i> ID Verification</a></li> --}}
      </ul>
    </div>
    <div class="card mb-6">
      <form id="formAccountSettings" method="POST" action="{{ route('setting.update') }}"  enctype="multipart/form-data">
        @csrf
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
          <img src="{{ Auth::user() && Auth::user()->avatar ? Auth::user()->avatar : asset('assets/img/avatar.png') }}"
            alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="bx bx-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" name="avatar" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
          </div>
        </div>
      </div>
      <div class="card-body pt-4">
          {{-- <input class="d-none" name="avatar" type="hidden" id="avatar" /> --}}

          <div class="row g-6">
            <div class="col-md-6">
              <label for="first_name" class="form-label">First Name</label>
              <input class="form-control" type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" autofocus />
            </div>
            <div class="col-md-6">
              <label for="last_name" class="form-label">Last Name</label>
              <input class="form-control" type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" />
            </div>
            <div class="col-md-6">
              <label for="birthday" class="form-label">Date of Birth</label>
              <input type="date" class="form-control flatpickr" id="birthday" name="birthday" value="{{ $user->birthday??'' }}" />
            </div>
            <div class="col-md-6">
              <label for="birth_city" class="form-label">City of Birth</label>
              <input type="text" class="form-control" id="birth_city" name="birth_city" value="{{ $user->birth_city??'' }}"  />
            </div>
            <div class="col-md-6">
              <label for="birth_country" class="form-label">Country of Birth</label>
              <input type="text" class="form-control" id="birth_country" name="birth_country" value="{{ $user->birth_country??'' }}"  />
            </div>
            <div class="col-md-6">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="home_address" name="address" value="{{ $user->address??'' }}"  />
            </div>
            <div class="col-md-6">
              <label for="pec_email" class="form-label">PEC email</label>
              <input class="form-control" type="text" id="pec_email" name="pec_email" value="{{ $user->pec_email??'' }}" />
            </div>
          </div>
          <div class="form-check form-switch my-6">
            <input class="form-check-input" type="checkbox" id="is_owned" name="is_owned" >
            <label class="form-check-label" for="is_owned">Add as Declarant</label>
          </div>
          <div class="mt-6">
            <button type="submit" class="btn btn-primary me-3">Save changes</button>
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
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
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
