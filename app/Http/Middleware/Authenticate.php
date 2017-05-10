<?php
namespace EverestBill\Http\Middleware;

use Closure;
use EverestBill\Models\User;
use Cartalyst\Sentinel\Sentinel;

class Authenticate
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
        if ($user = $this->auth->guest()) {
            return redirect()->guest(route('login.index'));
        }

        return $next($request);
    }
}
