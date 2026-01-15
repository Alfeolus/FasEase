<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            abort(404);
        }

        $organization = auth()->user()->organization;

        if (!$organization || !$organization->is_active) {
            abort(404);
        }

        app()->instance('currentOrganization', $organization);

        return $next($request);
    }


}
