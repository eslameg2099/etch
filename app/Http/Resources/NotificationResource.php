<?php

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'image' => $this->getImage(),
            'type' => $this->data['type'],
            'data' => $this->getData(),
            'read' => !! $this->read_at,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }

    protected function getData()
    {
        switch ($this->data['type']) {
            case Notification::DELIVERED_ORDER_TYPE:
            case Notification::PURCHASE_ORDER_TYPE:
            case Notification::SCHEDULE_DELIVERED_ORDER_TYPE:
            case Notification::SCHEDULE_PURCHASE_ORDER_TYPE:
                return [
                    'id' => $this->order_id,
                ];
            case Notification::RATE_ORDER_TYPE:
                return [
                    'id' => $this->order_id,
                    'delegate' => [
                        'name' => $this->order->Delegate->name,
                        'image' => $this->order->Delegate->image_url,
                    ],
                ];
            case Notification::RATE_SHOP_TYPE:
                return [
                    'id' => $this->shop_id,
                    'shop' => [
                        'name' => $this->shop->ar_name,
                        'image' => $this->shop->image_url,
                    ]
                ];
            case Notification::DELEGATE_TYPE:
            case Notification::WALLET_TYPE:
            case Notification::CANCELLATION_ATTEMPTS_TYPE:
                return [
                    'id' => $this->user_id,
                ];
        }
    }

    public function getTitle()
    {
        return Settings::get('name', 'Fetch App');
    }
    public function getBody()
    {
        return trans($this->data['trans'], [
            'delegate' => optional($this->user)->name,
            'user' => optional($this->user)->name,
            'order' => '#'. optional($this->order)->id,
            'shop' => optional($this->shop)->ar_name,
            'amount' => abs(optional($this->transaction)->amount) .' '. Settings::locale()->get('currency'),
        ]);
    }
    public function getImage()
    {
        return 'https://via.placeholder.com/150';
    }
}
