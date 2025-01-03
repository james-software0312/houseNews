@extends('layouts/layoutMaster')

@section('title', $task->name)

<!-- Vendor Style -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/tagify/tagify.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
  'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/toastr/toastr.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss'
])
@endsection

<!-- Vendor Script -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/tagify/tagify.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
  'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/toastr/toastr.js'
])
@endsection

<!-- Page Script -->
@section('page-script')
@vite(['resources/js/pages/tasks-edit.js'])
@endsection

@section('content')
<!-- Property Listing Wizard -->
<div id="wizard-property-listing" class="bs-stepper vertical mt-2">
  <div class="bs-stepper-header border-end">
    <div class="step" data-target="#task-name">
      <button type="button" class="step-trigger" data-step="0">
        <span class="bs-stepper-circle">
          <i class='bx bx-user bx-md'></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">{{__('frontend.task_name')}}</span>
          <span class="bs-stepper-subtitle"></span>
        </span>
      </button>
    </div>
    <div class="line"></div>
    <div class="step" data-target="#declarant-info">
      <button type="button" class="step-trigger" data-step="1">
        <span class="bs-stepper-circle">
          <i class='bx bx-user bx-md'></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">{{__('frontend.declarant_info')}}</span>
          <span class="bs-stepper-subtitle"></span>
        </span>
      </button>
    </div>
    <div class="line"></div>
    <div class="step" data-target="#start-end-dates">
      <button type="button" class="step-trigger" data-step="2">
        <span class="bs-stepper-circle">
          <i class='bx bx-user bx-md'></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">{{__('frontend.dates')}}</span>
          <span class="bs-stepper-subtitle"></span>
        </span>
      </button>
    </div>
    <div class="line"></div>
    <div class="step" data-target="#rental-property-address">
      <button type="button" class="step-trigger" data-step="3">
        <span class="bs-stepper-circle">
          <i class='bx bx-home bx-md'></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">{{__('frontend.rental_property_address')}}</span>
          <span class="bs-stepper-subtitle"></span>
        </span>
      </button>
    </div>
    <div class="line"></div>
    <div class="step" data-target="#guest-info">
      <button type="button" class="step-trigger" data-step="4">
        <span class="bs-stepper-circle">
          <i class='bx bx-star bx-md'></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">{{__('frontend.guest_info')}}</span>
          <span class="bs-stepper-subtitle"></span>
        </span>
      </button>
    </div>
  </div>
  <div class="bs-stepper-content">
    <form id="wizard-property-listing-form" onSubmit="return false" method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}" enctype="multipart/form-data">
      <input type="hidden" value="{{ $step }}" id="stepIndex"  name="step" />
      <!-- Personal Details -->
      <div id="task-name" class="content">
        <div class="row g-6 min-height-300">
          <div class="col-sm-12" >
            <div class="mt-10 mb-4 row">
              <label for="task_name" class="col-md-2 col-form-label">{{__('frontend.task_name')}}</label>
              <div class="col-md-10">
                <input class="form-control" type="hidden" value="{{ $task->id }}" id="task_id" name="task_id" />
                <input class="form-control" type="text" value="{{ $task->name }}" id="task_name" name="task_name" />
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-between margin-top-auto">
            <button class="btn btn-label-secondary btn-prev" disabled> <i class="bx bx-left-arrow-alt bx-sm me-sm-2 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">{{__('frontend.previous')}}</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">{{__('frontend.next')}}</span> <i class="bx bx-right-arrow-alt bx-sm"></i></button>
          </div>
        </div>
      </div>

      <!-- Property Details -->
      <div id="declarant-info" class="content">

        <div class="row g-6 min-height-300">
          <input type="hidden" id="new_declarant_id" name="new_declarant_id" value="0"/>
          <div class="col-sm-12 mt-2">
            <div class="row">
              <div class="col-sm-12">
                <label for="declarant_id" class="form-label">{{__('frontend.select_declarant')}}</label>
                <select id="declarant_id" name="declarant_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                  <option value="0" @empty($task->declarant_id) selected @endempty>+ Add New Declarant</option>
                  @foreach($declarants as $declarant)
                    <option value="{{ $declarant->id }}" @if($declarant->id == $task->declarant_id) selected @endif
                      data-first_name="{{ $declarant->first_name }}"
                      data-last_name="{{ $declarant->last_name }}"
                      data-pec_email="{{ $declarant->pec_email }}"
                      data-birthday="{{ Helper::format_date($declarant->birthday) }}"
                      data-birth_city="{{ $declarant->birth_city }}"
                      data-birth_country="{{ $declarant->birth_country }}"
                      data-address="{{ $declarant->address }}"
                      data-avatar="{{ $declarant->avatar }}"
                      data-is_owned="{{ $declarant->is_owned }}"
                    >{{ $declarant->first_name. ' ' . $declarant->last_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="first_name">{{__('frontend.first_name')}}</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $task->owner_first_name }}" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="last_name">{{__('frontend.last_name')}}</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $task->owner_last_name }}" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="birthday">{{__('frontend.birthday')}}</label>
                <input type="text" id="birthday" name="birthday" class="form-control flatpickr" value="{{ $task->owner_birthday }}"  />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="birth_city">{{__('frontend.birth_city')}}</label>
                <input type="text" id="birth_city" name="birth_city" class="form-control" value="{{ $task->owner_birth_city }}" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="birth_country">{{__('frontend.birth_country')}}</label>
                <input type="text" id="birth_country" name="birth_country" class="form-control" value="{{ $task->owner_birth_country }}" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="home_address">{{__('frontend.address')}}</label>
                <input type="text" id="home_address" name="address" class="form-control" value="{{ $task->owner_address }}" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="pec_email">{{__('frontend.pec_email')}}</label>
                <input type="text" id="pec_email" name="pec_email" class="form-control" value="{{ $task->owner_pec_email }}" />
              </div>
              <div class="col-sm-6">
                <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 ">
                  <img src="{{ $task->owner_avatar ? $task->owner_avatar : asset('assets/img/avatar.png') }}"
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
                  </div>
                </div>
              </div>
              <div class="col-sm-12 mt-4" id="save_info_div">
                <div class="d-flex justify-content-center form-check">
                    <input type="hidden" id="declarant_new" name="declarant_new" value="0"/>
                  <input class="form-check-input" type="checkbox" value="" id="owner_save_chk" />&nbsp;
                  <label class="form-check-label" for="owner_save_chk">
                    {{ __('frontend.save_info') }}
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-between margin-top-auto">
            <button class="btn btn-label-secondary btn-prev"> <i class="bx bx-left-arrow-alt bx-sm me-sm-2 me-0"></i> <span class="align-middle d-sm-inline-block d-none">{{__('frontend.previous')}}</span> </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">{{__('frontend.next')}}</span> <i class="bx bx-right-arrow-alt bx-sm"></i></button>
          </div>
        </div>
      </div>

      <!-- Property Features -->
      <div id="start-end-dates" class="content">
        <div class="row g-6 min-height-300">
          <div class="col-md-6 col-12 mb-6">
            <label for="dateRangePicker" class="form-label">{{__('frontend.check_in_date')}}</label>
            <input type="text" id="start_date" name="start_date" class="form-control flatpickr" value="{{ Helper::format_date($task->start_date) }}"  />
          </div>
          <div class="col-md-6 col-12 mb-6">
            <label for="dateRangePicker" class="form-label">{{__('frontend.check_out_date')}}</label>
            <input type="text" id="end_date" name="end_date" class="form-control flatpickr" value="{{ Helper::format_date($task->end_date) }}"  />
          </div>
          <div class="col-12 d-flex justify-content-between margin-top-auto">
            <button class="btn btn-label-secondary btn-prev"> <i class="bx bx-left-arrow-alt bx-sm me-sm-2 me-0"></i> <span class="align-middle d-sm-inline-block d-none">{{__('frontend.previous')}}</span> </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">{{__('frontend.next')}}</span> <i class="bx bx-right-arrow-alt bx-sm"></i></button>
          </div>
        </div>
      </div>

      <!-- Property Area -->
      <div id="rental-property-address" class="content">
        <div class="row g-6 min-height-300">
          <div class="col-12 ">
            <div class="row">
              <input type="hidden" id="new_property_id" name="new_property_id" value="0"/>

              <div class="col-sm-12">
                <label for="property_id" class="form-label">{{__('frontend.select_rental_property')}}</label>
                <select id="property_id" name="property_id" class="select2 form-select form-select-lg" data-allow-clear="true">
                  <option value="0" @empty($task->property_id) selected @endempty>+ Add New Property</option>
                  @foreach($properties as $property)
                    <option value="{{ $property->id }}" @if($property->id == $task->property_id) selected @endif
                      data-rental_commune="{{ $property->rental_commune }}"
                      data-rental_address="{{ $property->rental_address }}"
                      data-street_num="{{ $property->street_num }}"
                      data-int_num="{{ $property->int_num }}"
                      data-floor="{{ $property->floor }}"
                    >{{ $property->rental_commune. ', ' . $property->rental_address. ', ' . $property->street_num. ', ' . $property->int_num. ', ' . $property->floor }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-12 mt-2">
                <div class="row mb-2" id="rental_property_panel">
                  <div class="col-sm-12">
                    <label class="form-label" for="rental_commune">{{__('frontend.rental_commune')}}</label>
                    <input type="text" id="rental_commune" name="rental_commune" class="form-control" placeholder="" value="{{ $task->rental_commune }}" />
                  </div>
                  <div class="col-sm-12">
                    <label class="form-label" for="rental_address">{{__('frontend.rental_address')}} </label>
                    <input type="text" id="rental_address" name="rental_address" class="form-control" placeholder="" value="{{ $task->rental_address }}"/>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="street_num">{{__('frontend.street_num')}}</label>
                    <input type="text" id="street_num" name="street_num" class="form-control" placeholder="" value="{{ $task->street_num }}"/>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="int_num">{{__('frontend.int_num')}}</label>
                    <input type="text" id="int_num" name="int_num" class="form-control" placeholder="" value="{{ $task->int_num }}"/>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="floor">{{__('frontend.floor')}}</label>
                    <input type="text" id="floor" name="floor" class="form-control" placeholder="" value="{{ $task->floor }}"/>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 mt-4" id="property_new_div">
                <div class="d-flex justify-content-center form-check">
                  <input type="hidden" id="property_new" name="property_new" value="0"/>
                  <input class="form-check-input" type="checkbox" value="" id="property_new_chk" />&nbsp;
                  <label class="form-check-label" for="property_new_chk">
                    {{ __('Save Property') }}
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-between margin-top-auto">
            <button class="btn btn-label-secondary btn-prev"> <i class="bx bx-left-arrow-alt bx-sm me-sm-2 me-0"></i> <span class="align-middle d-sm-inline-block d-none">{{__('frontend.previous')}}</span> </button>
            <button class="btn btn-primary btn-next" id="rental_property_next_btn"> <span class="align-middle d-sm-inline-block d-none me-sm-2">{{__('frontend.next')}}</span> <i class="bx bx-right-arrow-alt bx-sm"></i></button>
          </div>
        </div>
      </div>

      <!-- Price Details -->
      <div id="guest-info" class="content">
        <div class="row g-6 min-height-300">
          <div class="col-md-12 mb-2">
            <label class="form-label" for="message">{{__('frontend.guests_emails')}}</label>
            <input id="guest_email" name="guest_email" class="form-control" value="{{ $task->guest_email }}">
          </div>
          <div class="col-12 d-flex justify-content-between margin-top-auto">
            <button class="btn btn-label-secondary btn-prev"> <i class="bx bx-left-arrow-alt bx-sm me-sm-2 me-0"></i> <span class="align-middle d-sm-inline-block d-none">{{__('frontend.previous')}}</span> </button>
            <button type="submit" class="btn btn-success btn-submit btn-next">{{__('frontend.save_and_review')}}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!--/ Property Listing Wizard -->



@endsection
