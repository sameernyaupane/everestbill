<?php

namespace EverestBill\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory as View;
use EverestBill\Http\Controllers\Controller;
use EverestBill\Repositories\Plan as PlanRepository;
use EverestBill\Domains\DomainName as DomainNameDomain;

class Domain extends Controller
{
    /**
     * Show list of domains
     *
     * @param View             $view
     * @param DomainNameDomain $domainNameDomain
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(View $view, DomainNameDomain $domainNameDomain)
    {
        $domains = $domainNameDomain->getAll();

        return $view->make('backend.domains.index', compact('domains'));
    }
}
