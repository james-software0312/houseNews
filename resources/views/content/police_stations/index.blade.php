@extends('layouts/layoutMaster')

@section('title',  __('frontend.police_stations') )

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
@vite(['resources/js/pages/police-stations.js'])
@endsection

@section('content')

<!-- PoliceStations List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">{{ __('frontend.police_stations') }}</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-police-stations table border-top">
      <thead>
        <tr>
          <th></th>
          <th>{{ __('frontend.ID') }}</th>
          <th>{{ __('frontend.name') }}</th>
          <th>{{ __('frontend.email') }}</th>
          <th>{{ __('frontend.address') }}</th>
          <th>{{ __('frontend.status') }}</th>
          <th>{{ __('frontend.action') }}</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddPoliceStation" aria-labelledby="offcanvasAddPoliceStationLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddPoliceStationLabel" class="offcanvas-title">{{ __('frontend.add_property') }}</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
      <form class="add-new-user pt-0" id="addNewPoliceStationForm">
        <input type="hidden" name="id" id="user_id">
        <div class="mb-6">
          <label class="form-label" for="add-name">{{ __('frontend.name') }}</label>
          <input type="text" class="form-control" id="add-name" placeholder="" name="name" aria-label="" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="add-email">{{ __('frontend.email') }}</label>
          <input type="email" class="form-control" id="add-email" placeholder="" name="email" aria-label="" />
        </div>
        <div class="mb-6">
          <label class="form-label" for="address">{{ __('frontend.address') }}</label>
          <input type="text" class="form-control" id="address" placeholder="" name="address" aria-label="" />
        </div>
        <div class="form-check form-switch mb-6">
          <input class="form-check-input" type="checkbox" id="add-status" name="status" checked>
          <label class="form-check-label" for="status">{{ __('frontend.status') }}</label>
        </div>
        <button type="submit" class="btn btn-primary me-3 data-submit">{{ __('frontend.submit') }}</button>
        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">{{ __('frontend.cancel') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection
