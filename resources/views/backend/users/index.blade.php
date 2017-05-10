@extends('backend.layouts.master')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Users
      <small>List of all the users</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Users</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Users</h3>
        <div class="box-tools">
          <a class="btn btn-sm btn-info" href="{{ route('plans.create') }}">Create User</a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered">
          <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th style="width: 120px">Updated At</th>
            <th style="width: 120px">Created At</th>
          </tr>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}.</td>
              <td>{{ $user->full_name }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @foreach($user->roles as $role)
                  <span class="label label-success">{{ $role->name }}</span>
                @endforeach
              </td>
              <td>{{ $user->updated_at->diffForHumans() }}</td>
              <td>{{ $user->created_at->diffForHumans() }}</td>
            </tr>
          @endforeach

        </tbody></table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
          <li><a href="#">«</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">»</a></li>
        </ul>
      </div>
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
@stop