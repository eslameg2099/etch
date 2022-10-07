<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Pusher\PushNotifications\PushNotifications;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admins')->except('logout');
        $this->middleware('guest:users_web')->except('logout', 'getPusherNotificationToken', 'getPusherChannelToken');
    }

    public function username()
    {
        return 'mobile';
    }

    protected function guard()
    {
        return Auth::guard('users_web');
    }

    public function getPusherNotificationToken(Request $request) {
        if($request->user('users_web')) {
            $pusher =   new Pusher('98d66d631fb3ac28b54b', 'b8e9a1808c3c71bcb6c2' , '1130040');

            $auth   =   $pusher->socket_auth($request->channel_name, $request->socket_id, json_encode(['user_id'=>$request->user('users_web')->id]) );
            $auth   =   json_decode($auth);
            return response()->json($auth);
        }
        return  response()->json('', 403);
    }

    public function getPusherChannelToken(Request $request) {
        if($request->user('users_web') && $request->has('channel_name') && $request->has('socket_id')) {
            $pusher =   new Pusher('98d66d631fb3ac28b54b', 'b8e9a1808c3c71bcb6c2' , '1130040');

            $auth   =   $pusher->socket_auth($request->channel_name, $request->socket_id, json_encode(['user_id'=>$request->user('users_web')->id]) );

            $auth   =   json_decode($auth);
            return response()->json($auth);
        }
        return  response()->json('', 403);
    }
}
