<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Chat\OrderChat;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate();

        $notifications->each(function (DatabaseNotification $notification) {
            $notification->markAsRead();
        });

        return NotificationResource::collection($notifications)->additional([
            'unread_count' => auth()->user()->unreadNotifications()->count()
        ]);
    }

    public function count()
    {
        $notificationsCount = 0;
        $messagesCount = 0;
        if (auth()->user()) {
            $notificationsCount = auth()->user()->unreadNotifications()->count();
            $messagesCount = OrderChat::query()->myChats()->whereHas('messages', function ($query) {
                $query->whereNull('read_at');
                $query->where('sender_id', '!=', auth()->id());
            })->count();
        }

        return response()->json([
            'notifications_count' => $notificationsCount,
            'messages_count' => $messagesCount,
        ]);
    }
}
