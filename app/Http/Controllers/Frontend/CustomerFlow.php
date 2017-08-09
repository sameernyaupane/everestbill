<?php

namespace EverestBill\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory as View;
use Illuminate\Session\SessionManager;
use EverestBill\Domains\Plan as PlanDomain;
use EverestBill\Http\Controllers\Controller;
use EverestBill\Repositories\Plan as PlanRepository;

class CustomerFlow extends Controller
{
    /**
     * Add the selected plan to the session
     *
     * @return Redirector
     */
    public function addPlan(Request $request, SessionManager $session, Redirector $redirect)
    {
        $session->put('plan_id', $request->plan_id);

        return $redirect->route('customerflow.add.domain');
    }

    /**
     * Display the add domain view
     *
     * @param  View $view
     *
     * @return View
     */
    public function getAddDomain(View $view)
    {
        return $view->make('frontend.add_domain');
    }

    /**
     * Add the selected domain to the session
     *
     * @return Redirector
     */
    public function addDomain(Request $request, SessionManager $session, Redirector $redirect)
    {
        $session->put('domain_name', $request->domain_name);
        $session->put('domain_extension', $request->domain_extension);

        return $redirect->route('customerflow.choose.billing.cycle');
    }

    /**
     * Display the login/register view
     *
     * @param  View $view
     *
     * @return View
     */
    public function getLoginRegister(View $view)
    {
        return $view->make('frontend.login_register');
    }

    /**
     *  Display choose billing cycle view
     *
     * @param View           $view
     * @param SessionManager $session
     * @param PlanDomain     $planDomain
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getChooseBillingCycleView(View $view, SessionManager $session, PlanDomain $planDomain)
    {
        $planId = $session->get('plan_id');

        $plan = $planDomain->getById($planId);

        return $view->make('frontend.choose_billing_cycle', compact('plan'));
    }

    /**
     * Choose billing cycle
     *
     * @return Redirector
     */
    public function chooseBillingCycle(Request $request, SessionManager $session, Redirector $redirect)
    {
        $session->put('billing_cycle', $request->billing_cycle);

        return $redirect->route('customerflow.login.register');
    }
}
