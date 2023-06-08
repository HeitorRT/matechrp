<?php

namespace App\Http\Middleware\Admin;

use App\Helpers\Acess\Authorize;
use Closure;
use Illuminate\Http\Request;

class MeetingIndividualViewMiddleware
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
        if (Authorize::any('meeting_individual_view')) {
            Authorize::abortIfAuthUserDoesNotMatch($request->meeting?->teacher_id);
        }

        return $next($request);
    }
}
