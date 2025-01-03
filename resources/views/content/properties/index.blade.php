@extends('layouts/layoutMaster')

@section('title',  __('frontend.properties_list') )

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
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
@vite(['resources/js/pages/properties.js'])
@endsection

@section('content')

<!-- Propertys List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">{{ __('frontend.properties_list') }}</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table border-top">
      <thead>
        <tr>
          <th></th>
          <th>{{ __('frontend.ID') }}</th>
          <th>{{ __('frontend.rental_commune') }}</th>
          <th>{{ __('frontend.rental_address') }}</th>
          <th>{{ __('frontend.street_num') }}</th>
          <th>{{ __('frontend.int_num') }}</th>
          <th>{{ __('frontend.floor') }}</th>
          {{-- <th>{{ __('frontend.status') }}</th> --}}
          <th>{{ __('frontend.action') }}</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddProperty" aria-labelledby="offcanvasAddPropertyLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddPropertyLabel" class="offcanvas-title">{{ __('frontend.add_property') }}</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
      <form class="add-new-user pt-0" id="addNewPropertyForm">
        <input type="hidden" name="id" id="user_id">
        <div class="mb-6">
          <label class="form-label" for="add-rental_commune">{{ __('frontend.rental_commune') }}</label>
          <input type="text" class="form-control" id="add-rental_commune" placeholder="" name="rental_commune" aria-label="" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="rental_address">{{ __('frontend.rental_address') }}</label>
          <input type="text" class="form-control" id="rental_address" placeholder="" name="rental_address" aria-label="" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-street_num">{{ __('frontend.street_num') }}</label>
          <input type="text" id="add-street_num" class="form-control" placeholder="" aria-label="" name="street_num" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-int_num">{{ __('frontend.int_num') }}</label>
          <input type="text" id="add-int_num" class="form-control" placeholder="" aria-label="" name="int_num" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-floor">{{ __('frontend.floor') }}</label>
          <input type="text" id="add-floor" class="form-control" placeholder="" aria-label="" name="floor" />
        </div>
        {{-- <div class="form-check form-switch mb-6">
          <input class="form-check-input" type="checkbox" id="add-status" name="status" checked>
          <label class="form-check-label" for="status">{{ __('frontend.status') }}</label>
        </div> --}}
        <button type="submit" class="btn btn-primary me-3 data-submit">{{ __('frontend.submit') }}</button>
        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">{{ __('frontend.cancel') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection
