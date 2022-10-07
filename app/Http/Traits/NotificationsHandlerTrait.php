<?php


namespace App\Http\Traits;


use App\Broadcasting\PusherChannel;
use App\Events\InteriorNotificationEvent;
use App\Models\Users\User;
use App\Models\MasterData\SmsLog;
use App\Notifications\CustomNotification;
use http\Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laraeast\LaravelSettings\Facades\Settings;
use App\Models\Notification as NotificationModel;

use function PHPUnit\Framework\throwException;

trait NotificationsHandlerTrait
{

    private $request;
    private $users;

    public function checkAndSendNotification($request) {
        $this->request = $request;
        $this->getTypeAndUsers();
        return true;
    }

    private function getTypeAndUsers() {
        if      ($this->request->has('all_users')    )    { $this->sendToAllUsers(User::User); }
        else if ($this->request->has('all_delegates')    )    { $this->sendToAllDelegates(User::Delegate); }
        else if ($this->request->has('all') )    { $this->sendToAll(); }
        else if ($this->request->input('delegate_id') )    { $this->sendToDelegate(); }
        else if ( $this->request->input('user_id') || $this->request->input('user_id')  )    { $this->sendToUser(); }

        else { throw new \Exception(trans('global.must_select_senders')); }

        $this->sendByType();
    }

    private function sendToUser() {
        $this->users   =  User::query()
            ->where('id', $this->request->input('user_id'))
            ->select('id', 'mobile', 'city_id');
            //->firstOrFail();
    }
    private function sendToDelegate() {
        $this->users   =  User::query()
            ->Where('id', $this->request->input('delegate_id'))
            ->select('id', 'mobile', 'city_id');
            //->firstOrFail();
    }

    private function sendToAllUsers($type) {
        $this->users    =   User::query()->where('type', $type)->select('id', 'mobile');
    }
    private function sendToAllDelegates($type) {
        $this->users    =   User::query()->where('type', $type)->select('id', 'mobile');
    }

    private function sendToAll() {
        $this->users  =    User::query()->select('id', 'mobile');
    }

    private function sendByType() {
        //$this->users = method_exists($this->users, 'unique') ? $this->users->unique('id') : collect([$this->users]);
        $this->users = method_exists($this->users, 'unique') ? $this->users->unique('id') : $this->users;
        switch ($this->request->input('type')) {
            case 1:
                $this->sendNotification();
                break;
            case 2:
                $this->sendSMS();
                break;
            case 3:
                $this->sendInteriorNotification();
                break;
            default:
                throw new \Exception(trans('global.must_select_notification_type'));
        }
    }

    private function sendInteriorNotification()
    {
        event(new InteriorNotificationEvent());
    }
    private function sendNotification() {

        $this->request->offsetSet('title', $this->request->input('title') ?? 'إشعار من الإدارة');

        $this->users->chunk(1000, function ($users){
            foreach ($users as $user){
                Notification::send($user, new CustomNotification([
                    'via' => ['database', PusherChannel::class],
                    'database' => [
                        'trans' => $this->request->input('body') ?? 'notifications.messages.admin_notification',
                        'user_id' => $user->id,
                        'type' => NotificationModel::ADMIN_TYPE,
                        'id' => $user->id,
                    ],
                    'fcm' => [
                        'title' => $this->request->input('title') ?? Settings::get('name', 'Fetch App'),
                        'body' => $this->request->input('body'),
                        'type' => NotificationModel::ADMIN_TYPE,
                        'data' => [
                            'id' => $user->id,
                        ],
                    ],
                ]));
            }
        });


    }

    private function sendSMS() {
        if ($this->users->count() > 1)  throw new \Exception(trans('global.cannot_send_message_to_all'));
        $mobiles = $this->users->get()->implode('mobile', ',');
        $this->sendBulkMessage($this->users, SmsLog::AdminNotification, $mobiles);
    }

}
