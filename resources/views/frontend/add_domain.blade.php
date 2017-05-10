@extends('frontend.layouts.master')

@section('content')
  <div class="jumbotron">
    <h1>Add Your Domain</h1>
    <p>Please add a domain name for your hosting.(This should be already registered with your respective domain registrar)</p>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="post" action="{{ route('customerflow.add.domain') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label class="col-md-1" style="margin-top: 6px; width: 5%;">www.</label>
              <div class="col-md-8">
                <input type="text" class="form-control" name="domain_name" placeholder="yourdomain">
              </div>
              <label class="col-md-1" style="width: 2%">.</label>
              <div class="col-md-2" style="width: 25%">
                <input type="text" class="form-control" name="domain_extension" placeholder="com">
              </div>
              <br clear="all">
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-5">
                  <input type="submit" class="btn btn-lg btn-success" value="Next">
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop