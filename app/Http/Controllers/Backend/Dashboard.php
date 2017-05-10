<?php
namespace EverestBill\Http\Controllers\Backend;

use Illuminate\View\Factory as View;
use EverestBill\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function index(View $view)
    {
        return $view->make('backend.index');
    }
}