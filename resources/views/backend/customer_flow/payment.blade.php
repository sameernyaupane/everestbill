@extends('backend.layouts.master')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Payment
      <small>Please complete your payment</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Create Plan</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Horizontal Form -->
    <div class="box box-info">
      <div class="box-header with-border">
        
      </div>
      <!-- /.box-header -->

      <div id="paypal-button-container"></div>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
@stop

@section('extrajs')
  <script type="text/javascript">
    var createPaymentUrl  = '{{ route('customer_flow.create-payment') }}'; 
    var executePaymentUrl = '{{ route('customer_flow.execute-payment') }}'; 
  </script>
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>
  <script src="{{ asset('backend/js/paypal.js') }}"></script>
@stop