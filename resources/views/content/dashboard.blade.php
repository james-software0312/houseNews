@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="row">
  <div class="col-xxl-12 mb-12 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary mb-3">Congratulations {{ strtoupper(auth()->user()->first_name) }}! 🎉</h5>
            <p class="mb-6">You can create a new task easily.</p>

            <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-label-primary">New Task</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{asset('assets/img/illustrations/man-with-laptop.png')}}" height="175" class="scaleX-n1-rtl" alt="View Badge User">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Transactions -->
  <!-- Activity Timeline -->
  {{-- <div class="col-md-12 col-lg-6 order-4 order-lg-3">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title m-0 me-2">Activity Timeline</h5>
        <div class="dropdown">
          <button class="btn text-muted p-0" type="button" id="timelineWapper" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded bx-lg"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineWapper">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body pt-2">
        <ul class="timeline mb-0">
          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-primary"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-3">
                <h6 class="mb-0">12 Invoices have been paid</h6>
                <small class="text-muted">12 min ago</small>
              </div>
              <p class="mb-2">
                Invoices have been paid to the company
              </p>
              <div class="d-flex align-items-center mb-1">
                <div class="badge bg-lighter rounded-2">
                  <img src="{{asset('assets/img/icons/misc/pdf.png')}}" alt="img" width="15" class="me-2">
                  <span class="h6 mb-0 text-body">invoices.pdf</span>
                </div>
              </div>
            </div>
          </li>
          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-success"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-3">
                <h6 class="mb-0">Client Meeting</h6>
                <small class="text-muted">45 min ago</small>
              </div>
              <p class="mb-2">
                Project meeting with john @10:15am
              </p>
              <div class="d-flex justify-content-between flex-wrap gap-2">
                <div class="d-flex flex-wrap align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle" />
                  </div>
                  <div>
                    <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                    <small>CEO of {{config('variables.creatorName')}}</small>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-info"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-3">
                <h6 class="mb-0">Create a new project for client</h6>
                <small class="text-muted">2 Day Ago</small>
              </div>
              <p class="mb-2">
                6 team members in a project
              </p>
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                  <div class="d-flex flex-wrap align-items-center">
                    <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                      <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy" class="avatar pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/5.png')}}" alt="Avatar" />
                      </li>
                      <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/12.png')}}" alt="Avatar" />
                      </li>
                      <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Julee Rossignol" class="avatar pull-up">
                        <img class="rounded-circle" src="{{asset('assets/img/avatars/6.png')}}" alt="Avatar" />
                      </li>
                      <li class="avatar">
                        <span class="avatar-initial rounded-circle pull-up text-heading" data-bs-toggle="tooltip" data-bs-placement="bottom" title="3 more">+3</span>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div> --}}
  <!--/ Activity Timeline -->
  <!-- pill table -->
  {{-- <div class="col-md-6 order-3 order-lg-4 mb-6 mb-lg-0">
    <div class="card text-center h-100">
      <div class="card-header nav-align-top">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-browser" aria-controls="navs-pills-browser" aria-selected="true">Browser</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-os" aria-controls="navs-pills-os" aria-selected="false">Operating System</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-country" aria-controls="navs-pills-country" aria-selected="false">Country</button>
          </li>
        </ul>
      </div>
      <div class="tab-content pt-0 pb-4">
        <div class="tab-pane fade show active" id="navs-pills-browser" role="tabpanel">
          <div class="table-responsive text-start text-nowrap">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Browser</th>
                  <th>Visits</th>
                  <th class="w-50">Data In Percentage</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="Chrome" height="24" class="me-3">
                      <span class="text-heading">Chrome</span>
                    </div>
                  </td>
                  <td class="text-heading">8.92k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 64.75%" aria-valuenow="64.75" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">64.75%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/safari.png')}}" alt="Safari" height="24" class="me-3">
                      <span class="text-heading">Safari</span>
                    </div>
                  </td>
                  <td class="text-heading">1.29k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 18.43%" aria-valuenow="18.43" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">18.43%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/firefox.png')}}" alt="Firefox" height="24" class="me-3">
                      <span class="text-heading">Firefox</span>
                    </div>
                  </td>
                  <td class="text-heading">328</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 8.37%" aria-valuenow="8.37" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">8.37%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/edge.png')}}" alt="Edge" height="24" class="me-3">
                      <span class="text-heading">Edge</span>
                    </div>
                  </td>
                  <td class="text-heading">142</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 6.12%" aria-valuenow="6.12" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">6.12%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/opera.png')}}" alt="Opera" height="24" class="me-3">
                      <span class="text-heading">Opera</span>
                    </div>
                  </td>
                  <td class="text-heading">82</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 2.12%" aria-valuenow="1.94" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">2.12%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/uc.png')}}" alt="uc" height="24" class="me-3">
                      <span class="text-heading">UC Browser</span>
                    </div>
                  </td>
                  <td class="text-heading">328</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20.14%" aria-valuenow="1.94" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">20.14%</small>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-os" role="tabpanel">
          <div class="table-responsive text-start text-nowrap">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>No</th>
                  <th>System</th>
                  <th>Visits</th>
                  <th class="w-50">Data In Percentage</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/windows.png')}}" alt="Windows" height="24" class="me-3">
                      <span class="text-heading">Windows</span>
                    </div>
                  </td>
                  <td class="text-heading">875.24k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 61.50%" aria-valuenow="61.50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">61.50%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/mac.png')}}" alt="Mac" height="24" class="me-3">
                      <span class="text-heading">Mac</span>
                    </div>
                  </td>
                  <td class="text-heading">89.68k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 16.67%" aria-valuenow="16.67" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">16.67%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/ubuntu.png')}}" alt="Ubuntu" height="24" class="me-3">
                      <span class="text-heading">Ubuntu</span>
                    </div>
                  </td>
                  <td class="text-heading">37.68k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 12.82%" aria-valuenow="12.82" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">12.82%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/chrome.png')}}" alt="Chrome" height="24" class="me-3">
                      <span class="text-heading">Chrome</span>
                    </div>
                  </td>
                  <td class="text-heading">8.34k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 6.25%" aria-valuenow="6.25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">6.25%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/cent.png')}}" alt="Cent" height="24" class="me-3">
                      <span class="text-heading">Cent</span>
                    </div>
                  </td>
                  <td class="text-heading">2.25k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 2.76%" aria-valuenow="2.76" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">2.76%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{asset('assets/img/icons/brands/linux.png')}}" alt="linux" height="24" class="me-3">
                      <span class="text-heading">Linux</span>
                    </div>
                  </td>
                  <td class="text-heading">328k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20.14%" aria-valuenow="2.76" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">20.14%</small>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-country" role="tabpanel">
          <div class="table-responsive text-start text-nowrap">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Country</th>
                  <th>Visits</th>
                  <th class="w-50">Data In Percentage</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fis fi fi-us rounded-circle fs-4 me-3"></i>
                      <span class="text-heading">USA</span>
                    </div>
                  </td>
                  <td class="text-heading">87.24k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 38.12%" aria-valuenow="38.12" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">38.12%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fis fi fi-br rounded-circle fs-4 me-3"></i>
                      <span class="text-heading">Brazil</span>
                    </div>
                  </td>
                  <td class="text-heading">42.68k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 28.23%" aria-valuenow="28.23" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">28.23%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fis fi fi-in rounded-circle fs-4 me-3"></i>
                      <span class="text-heading">India</span>
                    </div>
                  </td>
                  <td class="text-heading">12.58k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 14.82%" aria-valuenow="14.82" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">14.82%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fis fi fi-au rounded-circle fs-4 me-3"></i>
                      <span class="text-heading">Australia</span>
                    </div>
                  </td>
                  <td class="text-heading">4.13k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 12.72%" aria-valuenow="12.72" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">12.72%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fis fi fi-fr rounded-circle fs-4 me-3"></i>
                      <span class="text-heading">France</span>
                    </div>
                  </td>
                  <td class="text-heading">2.21k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 7.11%" aria-valuenow="7.11" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">7.11%</small>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fis fi fi-ca rounded-circle fs-4 me-3"></i>
                      <span class="text-heading">Canada</span>
                    </div>
                  </td>
                  <td class="text-heading">22.35k</td>
                  <td>
                    <div class="d-flex justify-content-between align-items-center gap-4">
                      <div class="progress w-100" style="height:10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15.13%" aria-valuenow="7.11" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small class="fw-medium">15.13%</small>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  <!--/ pill table -->
</div>
@endsection
