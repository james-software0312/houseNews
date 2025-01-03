@extends('layouts/layoutMaster')

@section('title', 'Preview - Task')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/tagify/tagify.js',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
])
@endsection

@section('page-style')
<style>
  .tab-content{
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
    flex-shrink:  0 !important;
    background-clip: padding-box;
    background: transparent !important;
    box-shadow: none !important;
    padding: 0px !important;
  }
</style>
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
@vite(['resources/js/pages/tasks-show.js'])
@endsection


@section('content')


<div class="nav-align-top mb-6">
  <ul class="nav nav-pills mb-4" role="tablist">
    <li class="nav-item">
      <button type="button" class="nav-link @if($task->status != 2) active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-details" aria-controls="navs-pills-top-details" aria-selected="true">Detail</button>
    </li>
    <li class="nav-item"
    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<span>Once if you send the email to guest(s) then you can see their documents here.</span>">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-guests" aria-controls="navs-pills-top-guests" aria-selected="false" @if($task->status == 0 || count($taskDetails) == 0) disabled @endif >Guests Doc</button>
    </li>
    <li class="nav-item"
    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<span>Once if you send the email to guest(s) then you can see their documents here.</span>">
      <button type="button" class="nav-link @if($task->status == 2) active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false" @if($task->status == 0 || count($taskDetails) == 0) disabled @endif>Submit Doc</button>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade @if($task->status != 2) show active @endif" id="navs-pills-top-details" role="tabpanel">

      <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-6">
          <div class="card invoice-preview-card p-sm-12 p-6">
            <div class="d-flex justify-content-right" style="justify-content: right;">
              <div class="text-right">
                @if($task->status == 0)
                <span class="badge bg-warning">Pending</span>
                @elseif($task->status == 1)
                <span class="badge bg-secondary">Sent to Guests</span>
                @elseif($task->status == 2)
                <span class="badge bg-success">Completed</span>
                @elseif($task->status == 3)
                <span class="badge bg-danger">Canceled</span>
                @endif
              </div>
            </div>
            <div class="card-body text-center rounded">
              <span class="app-brand-text demo fw-bold ms-40 lh-1">{{ $task->name }}</span>
            </div>

            <div class="card-body px-0">
              <div class="row">
                  <div class="col-xl-12 col-md-12 col-sm-12 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                    <h6>{{__('frontend.declarant_info')}}</h6>
                    <div class="table-responsive   rounded">
                      <table class="table m-0 table-borderless task-preview-table">
                        <tbody>
                            <tr>
                              <td >{{__("frontend.first_name")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->owner_first_name }}</td>
                            </tr>
                            <tr>
                              <td>{{__("frontend.last_name")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->owner_last_name }}</td>
                            </tr>
                            <tr>
                              <td>{{__("frontend.birthday")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->owner_birthday }}</td>
                            </tr>
                            <tr>
                              <td>{{__("frontend.birth_city")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->owner_birth_city }}</td>
                            </tr>
                            <tr>
                              <td>{{__("frontend.birth_country")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->owner_birth_country }}</td>
                            </tr>
                            <tr>
                              <td>{{__("frontend.address")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->owner_address }}</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
            <div class="card-body px-0">
              <div class="row">
                  <div class="col-xl-12 col-md-12 col-sm-12 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                    <h6>{{__('frontend.dates')}}</h6>
                    <div class="table-responsive   rounded">
                      <table class="table m-0 table-borderless task-preview-table">
                        <tbody>
                            <tr>
                              <td >{{__("frontend.start_date")}}</td>
                              <td class="text-nowrap text-heading">{{ Helper::format_date($task->start_date) }}</td>
                            </tr>
                            <tr>
                              <td >{{__("frontend.end_date")}}</td>
                              <td class="text-nowrap text-heading">{{ Helper::format_date($task->end_date) }}</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
            <div class="card-body px-0">
              <div class="row">
                  <div class="col-xl-12 col-md-12 col-sm-12 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                    <h6>{{__('frontend.rental_property_address')}}</h6>
                    <div class="table-responsive   rounded">
                      <table class="table m-0 table-borderless task-preview-table">
                        <tbody>
                          <tr>
                              <td >{{__("frontend.rental_commune")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->rental_commune }}</td>
                          </tr>
                          <tr>
                              <td>{{__("frontend.rental_address")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->rental_address }}</td>
                          </tr>
                          <tr>
                              <td>{{__("frontend.street_num")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->street_num }}</td>
                          </tr>
                          <tr>
                              <td>{{__("frontend.int_num")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->int_num }}</td>
                          </tr>
                          <tr>
                              <td>{{__("frontend.floor")}}</td>
                              <td class="text-nowrap text-heading">{{ $task->floor }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>

            <hr class="mt-0 mb-6">
            <div class="card-body p-0">
              <div class="row">
                <div class="col-12">
                  <span class="fw-medium text-heading">Note:</span>
                  <span>Once you send the email, you can't roll it back. Good luck!</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Invoice -->

        <!-- Invoice Actions -->
        <div class="col-xl-12 col-md-12 col-12 ">
          <div class="card  mt-5">
            <div class="card-body">
              <div class="row">
                  <div class="col-xl-12 col-md-12 col-sm-12 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                    <h6>{{__('frontend.guests')}}</h6>
                    <div class="table-responsive   rounded">
                      <table class="table m-0  task-preview-table">
                        <tbody>
                            @if (is_string($task->guest_email))
                                @php
                                    $guestEmails = explode(',', $task->guest_email); // Split the string into an array
                                @endphp
                                @foreach ($guestEmails as $guest)
                                    @if (!empty($guest))
                                        @php
                                            // Find the matching detail in $taskDetails by guest email
                                            $matchingDetail = $taskDetails->firstWhere('guest_email', trim($guest));
                                        @endphp
                                        <tr>
                                            <td>{{ $guest }}</td>
                                            <td class="text-nowrap text-heading">
                                                @if($matchingDetail)
                                                    @if($matchingDetail->status == 0)
                                                        <span class="badge bg-secondary">Received</span>
                                                    @elseif($matchingDetail->status == 1)
                                                        <span class="badge bg-warning">Opened</span>
                                                    @elseif($matchingDetail->status == 2)
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif($matchingDetail->status == 3)
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif($matchingDetail->status == 4)
                                                        <span class="badge bg-dark">Canceled</span>
                                                    @endif
                                                @else
                                                    <span class="text-center">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          @if($task->status == 0)
          <div class="card mt-5">
            <div class="card-body">
              <div class="d-flex my-4">
                <a class="btn btn-label-secondary d-grid w-100 me-4"  href="{{route('tasks.edit',['id'=>$task->id])}}">
                  Edit
                </a>
                <button class="btn btn-danger d-grid w-100 cancel-task me-4" data-id="{{$task->id}}" data-url="{{route('tasks.delete',['id'=>$task->id])}}">
                  <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-close bx-sm me-2"></i>Delete</span>
                </button>
                <button class="btn btn-success d-grid w-100  send-email" data-id="{{$task->id}}" data-url="{{route('tasks.send',['id'=>$task->id])}}">
                  <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-paper-plane bx-sm me-2"></i>Send to guests </span>
                </button>
              </div>
            </div>
          </div>
          @endif
        </div>
        <!-- /Invoice Actions -->
      </div>
    </div>
    <div class="tab-pane fade" id="navs-pills-top-guests" role="tabpanel">
      <div class="accordion mt-4 accordion-header-primary guestsAccordions" id="guestsAccordions">
        @foreach ($taskDetails as $index => $taskDetail)

        <div class="accordion-item card @if($taskDetail->status == 2) active @endif">
          <h2 class="accordion-header">
            <button type="button" class="accordion-button  @if($taskDetail->status != 2)  collapsed @endif " data-bs-toggle="collapse" data-bs-target="#guestsAccordions-{{ $index }}" aria-expanded="@if($taskDetail->status == 2)  true @else false @endif" @disabled($taskDetail->status < 2) >
              <div class="d-flex" style="width:100%;justify-content:space-between;">
              <div>
                <span class="guest-name">{{ $taskDetail->guest_first_name }} {{ $taskDetail->guest_last_name }} </span>
                <br/>
                <span class="guest-email">{{ $taskDetail->guest_email }}</span>
              </div>
              <div class="p-2">
                  @if($taskDetail->status == 0)
                  <span class="badge bg-secondary">Received</span>
                  @elseif($taskDetail->status == 1)
                  <span class="badge bg-warning">Opened</span>
                  @else
                  <span class="badge bg-success">Completed</span>
                  @endif
              </div>
            </div>
            </button>
          </h2>

          <div id="guestsAccordions-{{ $index }}" class="accordion-collapse collapse @if($taskDetail->status == 2) show @endif" >
            <div class="accordion-body">
              @if($taskDetail->status > 1)
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12 ">
                  <table class="table m-0 table-borderless task-preview-table">
                    <tbody>
                      <tr>
                        <td class="guest-label">{{__('frontend.birthday')}}</td>
                        <td>{{ Helper::format_date($taskDetail->guest_birthday) }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.birth_city')}}</td>
                        <td>{{ $taskDetail->guest_birth_city }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.birth_country')}}</td>
                        <td>{{ $taskDetail->guest_birth_country }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.nationality')}}</td>
                        <td>{{ $taskDetail->guest_nationality }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.address')}}</td>
                        <td>{{ $taskDetail->guest_address }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <br />
                  <table class="table m-0 table-borderless task-preview-table">
                    <tbody>
                      <tr>
                        <td class="guest-label">{{__('frontend.id_type')}}</td>
                        <td>{{ $taskDetail->id_type }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.id_num')}}</td>
                        <td>{{ $taskDetail->id_num }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.id_date')}}</td>
                        <td>{{ Helper::format_date($taskDetail->id_date) }}</td>
                      </tr>
                      <tr>
                        <td class="guest-label">{{__('frontend.id_authority')}}</td>
                        <td>{{ $taskDetail->id_authority }}</td>
                      </tr>
                    </tbody>
                  </table>

                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 ">
                  <img
                      @if($taskDetail->passport)
                      src="{{ asset('storage/passports/'.$taskDetail->passport) }}"
                      @else
                        src="{{asset('assets/img/id-card.png')}}"
                      @endif alt="ID-CARD" class="d-block idcard-img"/>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach

      </div>


    </div>
    <div class="tab-pane fade @if($task->status == 2) show active @endif" id="navs-pills-top-messages" role="tabpanel">
      {{-- <div class="card-datatable table-responsive">
        <table class="datatables-tasks table border-top">
          <thead>
            <tr>
              <th></th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>D.O.B</th>
              <th>City of birth</th>
              <th>Country of birth</th>
              <th>Nationality</th>
              <th>Home address</th>
              <th>Document type</th>
              <th>Document n°</th>
              <th>Date issued</th>
              <th>Authority issued</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
      </div> --}}
      <div class="card">
        <div class="card-body">

          <div class="row">
            @if (!empty($task->pdf_filename) && file_exists(storage_path('app/public/documents/' . $task->pdf_filename)))
              <div class="col-md-12">
                <h6>COMUNICAZIONE DI OSPITALITA’ IN FAVORE DI CITTADINO EXTRACOMUNITARIO  </h6>
                <iframe src="{{ asset('storage/documents/'.$task->pdf_filename) }}" width="100%" height="600px">
                    This browser does not support PDFs. Please download the PDF to view it:
                    <a href="{{ asset('storage/documents/'.$task->pdf_filename) }}">Download PDF</a>
                </iframe>
              </div>
            @endif
            <div class="d-flex justify-content-center align-items-center">
              <div class="row">
                <button class="btn btn-danger d-grid w-100 mb-4 generate-pdf" data-id="{{$task->id}}" data-url="{{route('tasks.generate',['id'=>$task->id])}}">
                  <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-paper-plane bx-sm me-2"></i>Generate </span>
                </button>
              </div>
            </div>

          </div>
          @if($task->status > 0)
          <div class="row">
                {{-- <h6>Police station </h6> --}}

                <div class="col-md-6 mb-6">
                  <label for="police_station_id" class="form-label">Police station</label>
                  <select id="police_station_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                    @foreach ($police_stations as $police_station)
                      <option value="{{ $police_station->id }}">{{ $police_station->name }}</option>
                    @endforeach
                  </select>
                  <br/>

                  <button class="btn btn-success d-grid w-100 mb-4 send-pec-email" data-id="{{$task->id}}" data-url="{{route('tasks.send-pec',['id'=>$task->id])}}" @disabled($task->start_date >= date("Y-m-d"))>
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-paper-plane bx-sm me-2"></i>Send </span>
                  </button>
                </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Offcanvas -->
@endsection
