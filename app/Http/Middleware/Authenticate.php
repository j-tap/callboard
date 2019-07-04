<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()
                || $request->segment(1) == 'api'
                || ($request->segment(1) == 'admin' && $request->segment(2) == 'api')) {
                return response()->json(['result' => false, 'error' => 'Unauthorized.'], 401);
            } else {
                if ($request->segment(1) == 'admin') {
                    return redirect()->route('login');
                } else
                    return redirect('/');
            }
        } else {
            $request->setUserResolver(function() {
                if (Auth::guard('api')->user()) {
                    return Auth::guard('api')->user();
                }

                return null;
            });
        }

        return $next($request);
    }
}