<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReadNotificationsMiddleware
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
        if ($request->notification_id && $notification = Notification::find($request->notification_id)) {
            $notification->markAsRead();

            if ($request->action == 'delete') {
                $notification->delete();
            }
        }

        return $next($request);
    }
}
