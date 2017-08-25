<?php
namespace EverestBill\Http\Controllers\Backend;

use Illuminate\View\Factory as View;
use EverestBill\Http\Controllers\Controller;

class Dashboard extends Controller
{
    /**
     * Show the dashboard index
     *
     * @param View $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(View $view)
    {
        return $view->make('backend.index');
    }
}