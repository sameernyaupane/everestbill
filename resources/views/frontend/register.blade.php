@extends('frontend.layouts.master')

@section('custom-css')
  <style type="text/css">
    .error-message { margin-top: 6px; padding: 8px; }
  </style>
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="page-header">
      <h1>Registration Form</h1>
    </div>
    @include('frontend.partials.register_form')
  </div>
</div>
@stop