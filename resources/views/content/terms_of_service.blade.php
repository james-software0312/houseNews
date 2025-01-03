@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', __("frontend.Terms_of_Service_title"))

@section('content')
<div class="content-wrapper mt-10 pt-5">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row flex-xl-nowrap">
      <div class="col-12 container-p-y">
        <h2 class="mb-6 doc-page-title">{{ __("frontend.Terms_of_Service_title") }} 📜</h2>
        {!! __('frontend.Terms_of_Service_content') !!}
      </div>
    </div>
  </div>
</div>
@endsection
