<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomDatabaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            'event_id' => $data['event_id'],
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }
}
