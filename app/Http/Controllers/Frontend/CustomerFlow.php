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
     * @param  View   $view
     * 
     * @return View
     */
    public function getAddDomain(View $view)
    {
        return $view->make('frontend.add_domain');
    }


    /**
     * Add the selected plan to the session
     *
     * @return Redirector
     */
    public function addDomain(Request $request, SessionManager $session, Redirector $redirect)
    {
        $session->put('domain_name', $request->domain_name);
        $session->put('domain_extension', $request->domain_extension);

        return $redirect->route('customerflow.login.register');
    }

    /**
     * Display the login/register view
     * 
     * @param  View   $view
     * 
     * @return View
     */
    public function getLoginRegister(View $view)
    {
        return $view->make('frontend.login_register');
    }
}
