<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\InteriorNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Users\User;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users  =   User::query()
            ->whereIn('type', [User::User,User::Delegate])
            ->get();
        $ads = AdminNotification::paginate();
        return view('dashboard.notifications.adminNotifications.index',
            [
                'users'     => $users->where('type', User::User),
                'delegates'     => $users->where('type', User::Delegate),
                'ads' => $ads
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $notification = AdminNotification::create($request->except('_token','media'));
            $notification->addAllMediaFromTokens();
            return redirect()->back()->with('success' , trans('global.notification_sent'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error' , $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminNotification  $adminNotification
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(AdminNotification $adminNotification)
    {
        return view('dashboard.notifications.adminNotifications.show',compact('adminNotification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminNotification  $adminNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminNotification $adminNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminNotification  $adminNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminNotification $adminNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminNotification  $adminNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminNotification $adminNotification)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminNotification  $adminNotification
     * @return \Illuminate\Http\Response
     */
    public function active(AdminNotification $adminNotification)
    {
        $adminNotification->update(['active' => ! $adminNotification->active]);
        flash()->success(trans('notifications.messages.active'));
        return redirect()->route('dashboard.adminNotifications.index');
    }
}
