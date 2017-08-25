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
     * Show list of users
     *
     * @param View           $view
     * @param UserRepository $userRepository
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(View $view, UserRepository $userRepository)
    {
        $users = $userRepository->getAll();

        return $view->make('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @param View $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(View $view)
    {
        return $view->make('backend.users.form');
    }

    /**
     * Store the new user
     *
     * @param Request    $request
     * @param Redirector $redirect
     * @param UserDomain $user
     *
     * @return mixed
     */
    public function store(Request $request, Redirector $redirect, UserDomain $user)
    {
        $user->store($request);

        return $redirect->route('users.index')->withSuccess('User created successfully!');
    }
}
