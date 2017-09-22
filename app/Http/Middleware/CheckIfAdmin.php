<?php
namespace EverestBill\Http\Middleware;

use Closure;
use EverestBill\Models\User;
use Cartalyst\Sentinel\Sentinel;

class CheckIfAdmin
{
    /**
     * Sentinel instance
     * 
     * @var Sentinel
     */
    private $auth;

    /**
     * Sentinel instance
     * 
     * @param Sentinel $auth
     */
    public function __construct(Sentinel $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request
     *
     * @param $request
     * @param Closure $next
     * @param null $guard
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = $this->auth->getUser();

        if (!$user->inRole(1)) {
            return redirect()->route('dashboard.index')
                ->withError('Sorry, you do not have the role or the permission to access this resource.');
        }

        return $next($request);
    }
}
