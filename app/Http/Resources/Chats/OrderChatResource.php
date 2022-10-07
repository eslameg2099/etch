<?php

namespace App\Http\Resources\Chats;

use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderChatResource extends JsonResource
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
            'order_id' => $this->order_id,
            'order' => [
                'reference_number' => $this->order->reference_number,
                'shop_name' => $this->when($this->order->shop, function () {
                    return $this->order->shop->name;
                }),
            ],
            'can_replay' => (int) $this->can_replay,
            'user' => new UserResource($this->user),
            'delegate' => new UserResource($this->delegate),
        ];
    }
}
