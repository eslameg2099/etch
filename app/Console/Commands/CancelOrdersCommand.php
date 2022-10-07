<?php

namespace App\Console\Commands;

use App\Broadcasting\PusherChannel;
use App\Models\Notification as NotificationModel;
use App\Models\Orders\Order;
use App\Notifications\CustomNotification;
use Illuminate\Console\Command;
use Laraeast\LaravelSettings\Facades\Settings;

class CancelOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel all pending orders after 30 minutes';

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
        Order::where('updated_at', '<=', now()->subMinutes(Settings::get('auto_cancel_duration', 30)))
            ->whereIn('status', [
                Order::WaitingForOffers,
                Order::WaitingForAcceptOffer,
                //Order::WaitingForPayment,
            ])->each(function (Order $order) {
                //$order->forceFill(['status' => Order::CanceledAutomatic])->save();
                $order->forceFill(['status' => Order::CanceledAutomatic, 'closed_at' => now()])->save();

                $this->info("Order #{$order->id} has been canceled.");
            });
        Order::whereNotNull('schedule_date')
            ->where('schedule_date', '<=', now()->subMinutes(Settings::get('auto_cancel_duration', 30)))
            ->whereNull('start_at')
            ->each(function (Order $order) {
                $order->forceFill(['status' => Order::CanceledAutomatic])->save();
                $this->info("Order #{$order->id} has been canceled.");
            });
    }
}
