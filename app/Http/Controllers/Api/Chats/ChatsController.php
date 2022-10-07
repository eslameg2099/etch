<?php

namespace App\Http\Controllers\Api\Chats;

use App\Events\NewOrderChatMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chats\SendMessageRequest;
use App\Http\Requests\GetOrderMessagesRequest;
use App\Http\Resources\Chats\MessageResource;
use App\Http\Resources\Chats\OrderChatResource;
use App\Models\Chat\OrderChatDetail;
use App\Models\Orders\Order;
use App\Traits\RepositoryResponseTrait;
use App\Traits\UploadHandlerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatsController extends Controller
{
    use UploadHandlerTrait, RepositoryResponseTrait;

    public function getMessages(Request $request)
    {
        $order = Order::query()->find($request->input('order_id')); // todo use OrderRepo

        $chat = $order->chats()->latest()->firstOrCreate([
            'user_id' => $order->user_id,
            'delegate_id' => $order->delegate_id,
        ]);
        $chat->messages()->where('sender_id', '!=', auth()->id())->whereNull('read_at')->each(function ($message) {
            $message->forceFill(['read_at' => now()])->save();
        });

        //dd($chat->messages()->where('sender_id', '!=', auth()->id())->whereNull('read_at')->get());
        $messages = $chat->messages()->orderByDesc('created_at')->simplePaginate();

        return $this->success([
            'chat' => new OrderChatResource($chat),
            'messages' => MessageResource::collection($messages),
            'hasNext' => $messages->hasMorePages(),
            'currentPage' => $messages->currentPage(),
        ]);
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $order = Order::query()->find($request->input('order_id')); // todo use OrderRepo
        $chat = $order->chats()->latest()->firstOrCreate([
            'user_id' => $order->user_id,
            'delegate_id' => $order->delegate_id,
        ]);
        /** @var OrderChatDetail $message */
        $message = $chat->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->input('message'),
        ]);

        if ($request->hasFile('image')) {
            $message->addMediaFromRequest('image')->toMediaCollection();
            //$message->imagable()->create(['path' => $this->uploadImage('image', "/orders/$order->id/$chat->id")]);
        }

        broadcast(new NewOrderChatMessageEvent($order, $message));

        return $this->success([
            'message' => trans('global.message_has_been_sent'),
            'data' => new MessageResource($message),
        ]);
    }

    public function complaints()
    {
        return $this->success([
            'message' => 'تم استقبال الشكوي وجاري العمل عليها ..',
            'reference_number' => Carbon::now()->timestamp,
        ]);
    }
}
