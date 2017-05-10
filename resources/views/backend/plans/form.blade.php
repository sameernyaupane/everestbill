@extends('backend.layouts.master')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create Plan
      <small>Form to create a new plan</small>
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
      <!-- form start -->
      <form method="post" action="{{ route('plans.store') }}" class="form-horizontal">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label for="plan_name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="Starter Package">
            </div>
          </div>
          <div class="form-group">
            <label for="disk_space" class="col-sm-2 control-label">Disk Space</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="disk_space" name="disk_space" placeholder="10">
            </div>
            <div class="col-sm-3">
              <select class="form-control" name="disk_unit">
                <option>MB</option>
                <option>GB</option>
                <option>TB</option>
              </select>
            </div>
            <div class="col-sm-2">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="disk_unlimited"> Unlimited
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="bandwidth" class="col-sm-2 control-label">Bandwidth</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="bandwidth" name="bandwidth" placeholder="100">
            </div>
            <div class="col-sm-3">
              <select class="form-control" name="bandwidth_unit">
                <option>MB</option>
                <option>GB</option>
                <option>TB</option>
              </select>
            </div>
            <div class="col-sm-2">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="bandwidth_unlimited"> Unlimited
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="addon_domains" class="col-sm-2 control-label">Addon Domains</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="addon_domains" name="addon_domains" placeholder="1">
            </div>
            <div class="col-sm-2">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="addon_domains_unlimited"> Unlimited
                </label>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Submit</button>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
@stop