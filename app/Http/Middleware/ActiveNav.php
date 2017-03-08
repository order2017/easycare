<?php

namespace App\Http\Middleware;

use Closure;

class ActiveNav
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch (url()->current()) {
            case route('index'):
                $navActive = 'index';
                break;
            case route('coupon.list'):
                $navActive = 'coupon';
                break;
            case route('goods.list'):
                $navActive = 'goods';
                break;
            case route('user.index'):
                $navActive = 'user';
                break;
            default:
                $navActive = 'index';
        }
        view()->share('navActive', $navActive);
        return $next($request);
    }
}
