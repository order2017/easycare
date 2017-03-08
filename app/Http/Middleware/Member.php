<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/8
 * Time: 11:51
 */

namespace App\Http\Middleware;


use Auth;
use Closure;

class Member
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
        if (!Auth::user()->is_member) {
            abort(401);
        }
        return $next($request);
    }
}