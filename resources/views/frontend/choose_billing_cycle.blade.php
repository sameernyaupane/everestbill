@extends('frontend.layouts.master')

@section('content')
    <div class="jumbotron">
        <h1>Choose your billing cycle</h1>
        <p>Please choose your billing cycle (monthly or yearly)</p>
    </div>

    <div class="row">
        <div class="col-md-8">
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
            </div>
            <label class="control-label">Choose billing cycle</label>
            <select class="form-control">
                <option>${{ $plan->pricing->monthly_price  }} Monthly</option>
                <option>${{ $plan->pricing->yearly_price  }} Yearly</option>
            </select>
        </div>
        <div class="col-md-4">

        </div>
    </div>
@stop
