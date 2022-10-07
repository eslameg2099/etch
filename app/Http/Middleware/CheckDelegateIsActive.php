<?php

namespace App\Http\Middleware;

use App\Enums\StatusCodesEnums;
use Closure;
use Illuminate\Http\Request;

class CheckDelegateIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedUrl  =   [
            'api/verifyMobileNumber',
            'api/getPusherNotificationToken',
            'api/getPusherChannelToken'
        ];

        if(
            auth()->check() &&
            auth()->user()->isDelegate() &&
            ! optional(auth()->user()->delegate)->is_approved &&
            ! in_array($request->route()->uri(), $allowedUrl)
        ) {
            return response()->json(['message' => trans('errors.wait_for_approval')], StatusCodesEnums::Forbidden);
        }
        return $next($request);
    }
}
