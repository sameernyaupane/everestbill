@extends('frontend.layouts.master')

@section('content')
  <div class="jumbotron">
    <h1>Login or Register</h1>
    <p>Please login or register to continue with your checkout.</p>
  </div>

  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
        <li><a href="#login" data-toggle="tab">Login</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in active" id="register">
          <div style="margin-top: 12px">
            @include('frontend.partials.register_form')
          </div>
        </div>
        <div class="tab-pane fade" id="login">
          <div style="margin-top: 12px">
            @include('frontend.partials.login_form')
          </div>
        </div>
      </div>
    </div>
  </div>
@stop