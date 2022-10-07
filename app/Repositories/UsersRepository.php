<?php

namespace App\Repositories;

use App\Broadcasting\PusherChannel;
use App\Events\NewOrderEvent;
use App\Http\Requests\Users\StoreDelegateLastLocationRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\MasterData\SmsLog;
use App\Models\Order;
use App\Models\Orders\OrderOffer;
use App\Models\Users\DelegateLocation;
use App\Models\Users\User;
use App\Notifications\CustomNotification;
use App\Notifications\Orders\NewOrderNotification;
use App\Models\Notification as NotificationModel;
use App\Traits\HISMS;
use App\Traits\RepositoryResponseTrait;
use App\Traits\UploadHandlerTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;
use Pusher\Pusher;

class UsersRepository implements UsersRepositoryInterface
{
    use RepositoryResponseTrait, UploadHandlerTrait, HISMS;

    public function getUsers()
    {
        // TODO: Implement getUsers() method.
    }

    public function getUser($id)
    {
        // TODO: Implement getUser() method.
    }

    public function getUserByMobile()
    {
        return User::query()->where('mobile', \request('mobile'))->first();
    }

    public function storeOrUpdateUser(Request $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = $id ? User::query()->find($id) : new User();

            if ($id && ! $user) {
                return $this->error(['message' => trans('errors.user_not_found')]);
            }
            $user->name = $request->input('name');
            $user->city_id = $request->input('city_id');
            $user->email = $request->input('email');
            $user->type = $this->getValue($user, 'type');
            $user->mobile = $this->getValue($user, 'mobile');
            $user->password = $this->getValue($user, 'password', true);

            $user->save();
            $this->checkAndSaveIfUserDelegate($user);

            if ($request->has('image')) {
                $user->addMediaFromRequest('image')->toMediaCollection();
            }
            //$imagePath = $this->uploadImage('image', 'users/'.$user->id);
            //if ($imagePath) {
            //    $user->update(['image' => $imagePath]);
            //}
            if (! auth()->check()) {
                $this->sendVerificationCode($user);
            }
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->serverError(['message' => $e->getMessage()]);
        }
    }

    public function deleteUser($id)
    {
        // TODO: Implement deleteUser() method.
    }

    public function changePassword()
    {
        if (Hash::check(\request()->input('old_password'), \request()->user()->password)) {
            \request()->user()->update(['password' => bcrypt(\request()->input('new_password'))]);
        } else {
            return $this->error(['message' => trans('errors.old_password_not_correct')]);
        }

        return $this->success([
            'message' => trans('global.updated_success'),
            'user' => new UserResource(\request()->user()),
        ]);
    }

    public function resetMyPassword()
    {
        $user = User::query()->where('mobile', \request('mobile'))->first();

        if (! $user) {
            return $this->error(['message' => trans('global.invalid_phone_number')]);
        }

        $sms = $user->lastResetPasswordCode();

        if (is_null($sms) || $sms->code != \request('code')) {
            return $this->error(['message' => trans('global.invalid_verification_code')]);
        }

        $user->update(['password' => bcrypt(\request('password'))]);
        $user->sms()->where('type', SmsLog::ResetPassword)->update(['code' => null]);

        return $this->success(['message' => trans('global.reset_password_success')]);
    }

    private function getValue($user, $key, $password = false)
    {
        return $user->exists ? $user->{$key} : ($password ? bcrypt(\request()->input('password')) : \request()->input($key));
    }

    /**
     * @param User $user
     */
    private function checkAndSaveIfUserDelegate($user)
    {
        if ($user->type == User::Delegate) {
            if (request()->has('national_id_front_image')) {
                $user->addMediaFromRequest('national_id_front_image')->toMediaCollection('national_id_front_image');
            }
            if (request()->has('national_id_back_image')) {
                $user->addMediaFromRequest('national_id_back_image')->toMediaCollection('national_id_back_image');
            }
            if (request()->has('vehicle_number_image')) {
                $user->addMediaFromRequest('vehicle_number_image')->toMediaCollection('vehicle_number_image');
            }
            //$national_id_front_image = $this->uploadImage('national_id_front_image', "delegate/$user->id");
            //$national_id_back_image = $this->uploadImage('national_id_back_image', "delegate/$user->id");
            //$vehicle_number_image = $this->uploadImage('vehicle_number_image', "delegate/$user->id");

            $data = request()->only([
                'national_id',
                'vehicle_type',
                'vehicle_model',
                'vehicle_number',
            ]);
            $delegate = $user->delegate()->updateOrCreate([
                'user_id' => $user->id,
            ], $data);

            $user->delegate->forceFill(['can_receive_cash_orders' => ! ! request('can_receive_cash_orders')])->save();
        }
    }

    public function StoreDelegateLastLocation(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        //$lastLocation = $request->user()->delegateLocations()->latest()->first();

        $user->forceFill([
            'lat' => $request->input('lat'),
            'lng' => $request->input('long'),
        ])->save();

        //$user
        //    ->delegateLocation()
        //    ->updateOrCreate([
        //        //'delegate_id' => auth()->id(),
        //        'order_id' => $request->input('order_id'),
        //    ], [
        //        'lat' => $request->input('lat'),
        //        'lng' => $request->input('long'),
        //        'order_id' => $request->input('order_id'),
        //    ]);

        if (! $user->delegate->is_available) {
            return $this->success(['message' => 'done']);
        }
        if ($user->delegateTodayCompletedOrders()->count() >= (int) Settings::get('orders_per_day')) {
            return $this->success(['message' => 'done']);
        }

        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        $response = $pusher->get('/channels/presence-socket-status/users');
        $onlineUsers = [];

        if ($response && $response['status'] == 200) {
            $onlineUsers = array_map(function ($user) {
                return $user->id;
            }, json_decode($response['body'])->users);
        }
        Order::where('status', Order::WaitingForOffers)
            ->whereDoesntHave('offers', function (Builder $builder) {
                $builder->where('delegate_id', auth()->id());
            })
            ->whereDoesntHave('withdrawals', function (Builder $builder) {
                $builder->where('delegate_id', auth()->id());
            })->each(function (Order $order) use ($onlineUsers) {
                $lat = null;
                $lng = null;
                if ($order->type == Order::Delivery) {
                    $address = optional($order->receivingAddress);
                    $lat = $address->lat;
                    $lng = $address->lng;
                }
                if ($order->type == Order::Purchase) {
                    $address = optional($order->deliveryAddress);
                    $lat = $address->lat;
                    $lng = $address->lng;
                }
                /** @var User $user */
                $user = User::where('id', auth()->id())
                    ->distance($lat, $lng)
                    ->first();
                if (! $user) {
                    return;
                }

                if ($order->payment_type == Order::PAYMENT_ON_DELIVERY && ! $user->delegate->can_receive_cash_orders) {
                    return;
                }

                OrderOffer::query()->create([
                    'delegate_id' => $user->id,
                    'order_id' => $order->id,
                    'lat' => $user->lat,
                    'lng' => $user->lng,
                    'status' => OrderOffer::WaitingDelegateAction,
                    'distance' => $user->distance,
                ]);

                if (in_array($user->id, $onlineUsers)) {
                    broadcast(new NewOrderEvent($order, $user, $user->distance));
                } else {
                }
                Notification::send($user, new CustomNotification([
                    'via' => ['database', PusherChannel::class],
                    'database' => [
                        'trans' => 'notifications.user.new_order',
                        'order_id' => $order->id,
                        'type' => $order->type == Order::Delivery
                            ? NotificationModel::DELIVERED_ORDER_TYPE
                            : NotificationModel::PURCHASE_ORDER_TYPE,
                        'id' => $order->id,
                    ],
                    'fcm' => [
                        'title' => Settings::get('name', 'Fetch App'),
                        'body' => trans('notifications.user.new_order', [
                            'order' => '#' . $order->id,
                        ]),
                        'type' => $order->type == Order::Delivery
                            ? NotificationModel::DELIVERED_ORDER_TYPE
                            : NotificationModel::PURCHASE_ORDER_TYPE,
                        'data' => [
                            'id' => $order->id,
                        ],
                    ],
                ]));
            });

        return $this->success(['message' => 'done']);
    }

    private function distanceTwoPoint($lat1, $lon1, $lat2, $lon2)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;
        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return $km;
    }
}
