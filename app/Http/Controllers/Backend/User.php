<?php
namespace EverestBill\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory as View;
use EverestBill\Domains\User as UserDomain;
use EverestBill\Http\Controllers\Controller;
use EverestBill\Repositories\User as UserRepository;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(View $view, UserRepository $userRepository)
    {
        $users = $userRepository->getAll();

        return $view->make('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(View $view)
    {
        return $view->make('backend.users.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserDomain                $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Redirector $redirect, UserDomain $user)
    {
        $user->store($request);

        return $redirect->route('users.index')->withSuccess('User created successfully!');
    }
}
