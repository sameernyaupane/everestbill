<?php
namespace EverestBill\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory as View;
use EverestBill\Domains\Plan as PlanDomain;
use EverestBill\Http\Controllers\Controller;
use EverestBill\Repositories\Plan as PlanRepository;

class Plan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(View $view, PlanDomain $planDomain)
    {
        $plans = $planDomain->getAll();
        
        return $view->make('backend.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(View $view)
    {
        return $view->make('backend.plans.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PlanDomain                $plan
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Redirector $redirect, PlanDomain $plan)
    {
        $plan->store($request);

        return $redirect->route('plans.index')->withSuccess('Plan created successfully!');
    }
}
