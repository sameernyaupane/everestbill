@extends('frontend.layouts.master')

@section('content')
  <div class="jumbotron">
    <h1>Hosting Plans</h1>
    <p>Please select the hosting plan that you would like to order.</p>
  </div>

  <div class="row">
    @foreach($plans as $plan)
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">{{ $plan->plan_name }}</h3>
            </div>
          <div class="panel-body">
            <ul>
              <li>{{ $plan->diskSpaceWithUnit }} Diskspace</li>
              <li>{{ $plan->bandwidthWithUnit }} Bandwidth</li>
              <li>{{ $plan->addonDomains }} Addon Domains</li>
            </ul>
          </div>
          <div class="panel-footer">
            <form method="post" action="{{ route('customerflow.add.plan') }}">
              {{ csrf_field() }}
              <input type="hidden" name="plan_id" value="{{ $plan->id }}">
              <input type="submit" style="float:right;" class="btn btn-success" value="Order">
            </form>
            <br clear="all">
          </div>
        </div>
      </div>
    @endforeach
  </div>
@stop