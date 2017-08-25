<?php
namespace EverestBill\Http\Controllers\Frontend;

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
        
        return $view->make('frontend.plans', compact('plans'));
    }
}
