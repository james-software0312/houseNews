@extends('layouts/layoutMaster')

@section('title', 'Declarants')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/toastr/toastr.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/toastr/toastr.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/pages/declarants.js'])
@endsection

@section('content')

<!-- declarants List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">Declarants</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-declarants table border-top">
      <thead>
        <tr>
          <th></th>
          {{-- <th>Id</th> --}}
          <th>Full Name</th>
          <th>PEC Email</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Guest</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
      <form class="add-new-user pt-0" id="addNewUserForm" enctype="multipart/form-data">
        <input type="hidden" name="id" id="declarant_id">
        <div class="mb-6">
          <label class="form-label" for="first_name">{{__('frontend.first_name')}}</label>
          <input type="text" id="first_name" name="first_name" class="form-control" placeholder="" required/>
        </div>
        <div class="mb-6">
          <label class="form-label" for="last_name">{{__('frontend.last_name')}}</label>
          <input type="text" id="last_name" name="last_name" class="form-control" placeholder=""/>
        </div>
        <div class="mb-6">
          <label class="form-label" for="birthday">{{__('frontend.birthday')}}</label>
          <input type="text" id="birthday" name="birthday" class="form-control flatpickr" placeholder=""/>
        </div>
        <div class="mb-6">
          <label class="form-label" for="birth_city">{{__('frontend.birth_city')}}</label>
          <input type="text" id="birth_city" name="birth_city" class="form-control" placeholder="" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="birth_country">{{__('frontend.birth_country')}}</label>
          <input type="text" id="birth_country" name="birth_country" class="form-control" placeholder="" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="home_address">{{__('frontend.address')}}</label>
          <input type="text" id="home_address" name="address" class="form-control" placeholder=""/>
        </div>
        <div class="mb-6">
          <label class="form-label" for="pec_email">{{__('frontend.pec_email')}}</label>
          <input type="text" id="pec_email" name="pec_email" class="form-control" placeholder="" required/>
        </div>
        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom mb-6">
          <img src="{{ asset('assets/img/avatar.png') }}"
            alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
              <span class="d-none d-sm-block">Upload </span>
              <i class="bx bx-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" name="avatar" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>
          </div>
        </div>
        {{-- <div class="form-check form-switch mb-6">
          <input class="form-check-input" type="checkbox" id="is_owned" name="is_owned" >
          <label class="form-check-label" for="is_owned">Owned</label>
        </div> --}}
        <button type="submit" class="btn btn-primary me-3 data-submit">Submit</button>
        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
      </form>
    </div>
  </div>
</div>
@endsection
