<?php

namespace App\Http\Middleware\Admin;

use App\Helpers\Acess\Authorize;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class HandleInertiaShare
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
        Inertia::share('menu', function() {
            return collect(config()->get('menu', []))->map(function($item) {
                return [
                    'label' => Arr::get($item, 'label'),
                    'items' => Arr::where(Arr::get($item, 'items', []), fn($v) => !isset($v['can']) || Authorize::any($v['can']))
                ];
            })->filter(fn($item) => isset($item['items']) && count($item['items']) > 0);
        });

        return $next($request);
    }
}
