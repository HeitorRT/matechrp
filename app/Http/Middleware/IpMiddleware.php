<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        if ($ip === '177.200.68.192' || config('app.env') === 'local') {
            return $next($request);
        }

        abort(403, 'Ação não autorizada');
    }
}
