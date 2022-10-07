<?php

namespace App\Console\Commands;

use App\Broadcasting\PusherChannel;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Notifications\CustomNotification;
use Illuminate\Console\Command;
use Laraeast\LaravelSettings\Facades\Settings;

class ScheduleNotifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify customers if their schedule orders will start';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Order::where('status', Order::Schedule)
            ->where('schedule_date', '<=', now())
            ->where('notified', 0)
            ->each(function (Order $order) {
                $order->User->notify(new CustomNotification([
                    'via' => ['database', PusherChannel::class],
                    'database' => [
                        'trans' => 'notifications.user.schedule',
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'type' => $order->type == Order::Delivery
                            ? NotificationModel::SCHEDULE_DELIVERED_ORDER_TYPE
                            : NotificationModel::SCHEDULE_PURCHASE_ORDER_TYPE,
                        'id' => $order->id,
                    ],
                    'fcm' => [
                        'title' => Settings::get('name', 'Fetch App'),
                        'body' => trans('notifications.user.schedule', [
                            'order' => '#' . $order->id,
                        ]),
                        'type' => $order->type == Order::Delivery
                            ? NotificationModel::SCHEDULE_DELIVERED_ORDER_TYPE
                            : NotificationModel::SCHEDULE_PURCHASE_ORDER_TYPE,
                        'data' => [
                            'id' => $order->id,
                        ]
                    ],
                ]));

                $order->forceFill(['notified' => 1])->save();

                $this->info("Notification of schedule order #{$order->id} has been sent.");
            });
    }
}
