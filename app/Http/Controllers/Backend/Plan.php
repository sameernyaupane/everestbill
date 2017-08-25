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
     * Show list of plans
     *
     * @param View       $view
     * @param PlanDomain $planDomain
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(View $view, PlanDomain $planDomain)
    {
        $plans = $planDomain->getAll();
        
        return $view->make('backend.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param View $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(View $view)
    {
        return $view->make('backend.plans.form');
    }

    /**
     * Store new plan
     *
     * @param Request    $request
     * @param Redirector $redirect
     * @param PlanDomain $plan
     *
     * @return mixed
     */
    public function store(Request $request, Redirector $redirect, PlanDomain $plan)
    {
        $plan->store($request);

        return $redirect->route('plans.index')->withSuccess('Plan created successfully!');
    }
}
