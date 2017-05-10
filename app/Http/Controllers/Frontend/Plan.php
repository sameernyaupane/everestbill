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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(View $view, PlanDomain $planDomain)
    {
        $plans = $planDomain->getAll();
        
        return $view->make('frontend.plans', compact('plans'));
    }
}
