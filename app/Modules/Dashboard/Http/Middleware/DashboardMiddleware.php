<?php

namespace App\Modules\Dashboard\Http\Middleware;

use Closure;
use App\Helpers\AclHelper;

class DashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$params)
    {
        return $next($request);
    }
}
