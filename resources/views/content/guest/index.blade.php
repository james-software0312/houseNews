@extends('layouts/blankLayout')

@section('title', $task->name)

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/dropzone/dropzone.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
]
)
@endsection

@section('page-style')
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/dropzone/dropzone.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite(['resources/js/pages/guest-task.js'])
@endsection


@section('content')

<div class="row ">
  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-sm-12 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6 d-flex justify-content-center">
    <div class="card invoice-preview-card p-sm-12 p-6">

      <div class="card-body text-center rounded">
        <span class="app-brand-text demo fw-bold ms-40 lh-1">{{ $task->name }}</span>
      </div>

      <div class="card-body px-0">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
                Regarding your stay with

                <h5 class="my-3">{{ $task->owner_first_name }} {{ $task->owner_last_name }}</h5>
                <p>for the dates</p>
                <div class="p-1">
                    <p >{{__("frontend.start_date")}}  :
                        <span class="text-nowrap text-heading">{{ Helper::format_date($task->start_date) }}</span>
                    </p>

                    <p >{{__("frontend.end_date")}} :
                        <span class="text-nowrap text-heading">{{ Helper::format_date($task->end_date) }}</span>
                    </p>
                </div>
                <div class="mt-3 mb-6">
                    <p >{{__("frontend.rental_property_address")}}  :  </p>
                    <span class="text-heading">
                        {{ $task->rental_address.', '.$task->street_num }}
                    </span><br/>
                    <span class="text-heading">{{ $task->rental_commune }}</span><br/>
                    <span class="text-heading">Int {{ $task->int_num }}</span><br/>
                    <span class="text-heading">Floor {{ $task->floor }}</span>

                </div>
                <h5>Please supply the following information so it can be forwarded to the local police.</h5>
            </div>
        </div>
    </div>
    <hr class="mt-0 mb-3">
    <form id="task-details-panel" class="needs-validation" enctype="multipart/form-data">
      <input type="hidden" value="{{$task->task_id}}" name="task_id" />
      <input type="hidden" value="{{$task->token}}" name="token" />
    <div class="">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{__('frontend.your_details')}}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="first_name">{{__('frontend.first_name')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="{{ $task->guest_first_name }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="last_name">{{__('frontend.last_name')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="{{ $task->guest_last_name  }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="birthday">{{__('frontend.birthday')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control flatpickr" id="birthday" name="birthday" placeholder="" value="{{ $task->guest_birthday }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="birth_city">{{__('frontend.birth_city')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="birth_city" name="birth_city" placeholder="" value="{{ $task->guest_birth_city }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="birth_country">{{__('frontend.birth_country')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="birth_country" name="birth_country" placeholder="" value="{{ $task->guest_birth_country }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="nationality">{{__('frontend.nationality')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="nationality" name="nationality" placeholder="" value="{{ $task->guest_nationality }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="address">{{__('frontend.address')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="address" name="address" placeholder="" value="{{ $task->guest_address }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{__('frontend.identification')}}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="id_type">{{__('frontend.id_type')}}</label>
                <div class="col-sm-9">
                  <select id="id_type" name="id_type" class=" form-select " data-allow-clear="true">
                    <option value="passport" @if($task->id_type == "passport") selected @endif>Passport</option>
                    <option value="idcard" @if($task->id_type == "idcard") selected @endif>ID Card</option>
                  </select>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="id_num">{{__('frontend.id_num')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="id_num" name="id_num" placeholder="" value="{{ $task->id_num }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="id_date">{{__('frontend.id_date')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control flatpickr" id="id_date" name="id_date" placeholder="" value="{{ $task->id_date }}"/>
                </div>
            </div>
            <div class="row mb-1">
                <label class="col-sm-3 col-form-label" for="id_authority">{{__('frontend.id_authority')}}</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="id_authority" name="id_authority" placeholder="" value="{{ $task->id_authority }}"/>
                </div>
            </div>
        </div>
    </div>
    <input class="d-none" name="id_card" type="hidden" id="id_card" />
    <input class="d-none" name="id_card_path" type="hidden" id="id_card_path" value="{{ $task->passport ? asset('storage/passports/'.$task->passport) : "" }}"/>

    </form>
    <div class="mb-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="id_type_label">{{__('frontend.passport')}}</h5>
        </div>
        <div class="card-body">
          <form action="/upload" class="dropzone needsclick" id="passport-area" enctype="multipart/form-data">
            <div class="dz-message needsclick">
              Drop your passport here or click to upload
            </div>
            <div class="fallback">
              <input name="passport" type="file" />
            </div>
          </form>
        </div>
      </div>
    <div class="row">
      <div class="col-12">
        @if($task_detail->status < 2)
        <div class="d-flex justify-content-center align-items-center">
            <div class="row">
              <form onSubmit="return false"  id="privacy-policy" enctype="multipart/form-data">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms_conditions" name="terms_conditions" >
                        <label class="form-check-label" for="terms_conditions">
                        I agree to
                        <a href="javascript:void(0);">privacy policy & terms</a>
                        </label>
                    </div>
                </div>
                <button class="btn btn-danger d-grid w-100 mb-4 send-email" data-id="{{$task->my_task_id}}" data-url="{{route('guest.submit')}}">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-paper-plane bx-sm me-2"></i>Submit </span>
                </button>
              </form>
            </div>
        </div>

        @else
        <hr class="mt-0 mb-6">
        <div class="alert alert-info" role="alert">
          <strong>Info:</strong> You already submited your document.
        </div>
        @endif
      </div>
    </div>

      {{-- <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <span class="fw-medium text-heading">Note:</span>
            <span>Once you send the email, you can't roll it back. Good luck!</span>
          </div>
        </div>
      </div> --}}
    </div>
  </div>
  <!-- /Invoice -->



<!-- /Offcanvas -->
@endsection
