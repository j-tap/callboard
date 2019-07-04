<?php

namespace App\Http\Middleware;

use App\Exceptions\NotFoundException;
use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Auth;

class OrganizationType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        if (Auth::guard('api')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (Auth::guard('api')->user()->organization->org_type == $type) {
            return $next($request);
        }

        throw new NotFoundException();
    }
}
