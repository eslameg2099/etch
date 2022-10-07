<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CancellationAttemptsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->cancellation_attempts <= 0) {
            abort(401, __('تم ايقاف حسابك لتجاوز عدد محاولات الالغاء'));
        }

        if ($request->user() && ! $request->user()->is_active) {
            abort(401, __('تم ايقاف حسابك'));
        }

        return $next($request);
    }
}
