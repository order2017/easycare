<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/7
 * Time: 20:29
 */

namespace App\Http\Middleware;


use Auth;
use Closure;

class Employee
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
        if (!Auth::user()->is_employee) {
            abort(401);
        }

        return $next($request);
    }
}