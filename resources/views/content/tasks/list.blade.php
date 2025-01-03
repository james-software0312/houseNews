@extends('layouts/layoutMaster')

@section('title', 'Tasks List')

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
@vite(['resources/js/pages/tasks-list.js'])
@endsection

@section('content')
<div class="d-none d-sm-block">
<div class="row g-6 mb-6">
  <div class="col-sm-4 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span class="text-heading text-nowrap">Pending Tasks</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2">{{$pendingTasks}}</h4>
              {{-- <p class="text-success mb-0">(+95%)</p> --}}
            </div>
            <small class="mb-0 text-nowrap">pending by owner </small>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-warning">
              <i class="bx bx-task bx-lg"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span class="text-heading text-nowrap">Sent Tasks</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2">{{$sentTasks}}</h4>
              {{-- <p class="text-success mb-0">(0%)</p> --}}
            </div>
            <small class="mb-0 text-nowrap">emails sent to guests</small>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-grey">
              <i class="bx bx-task bx-lg"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span class="text-heading text-nowrap">Completed Tasks</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2">{{$completedTasks}}</h4>
              {{-- <p class="text-danger mb-0">(+6%)</p> --}}
            </div>
            <small class="mb-0 text-nowrap">Sent to the questura</small>
          </div>
          <div class="avatar">
            <span class="avatar-initial rounded bg-label-success">
              <i class="bx bx-task bx-lg"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Users List Table -->
<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">Search Filter</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-tasks table border-top">
      <thead>
        <tr>
          <th></th>
          <th>Id</th>
          <th>Name</th>
          <th>{{__('frontend.rental_property_address')}}</th>
          <th>{{__('frontend.check_in_date')}}</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection
