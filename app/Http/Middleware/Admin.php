<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/1
 * Time: 14:15
 */

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (!$request->user('admin')->is_admin) {
            abort(401);
        }
        return $next($request);
    }
}