<?php

namespace App\Notifications;

use App\Notifications\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollower extends Notification implements ShouldQueue
{
    use Queueable;

    private $params;

    public function __construct($params)
    {
        // Require an instance of the $follower to be injected when this notification is created.
        $this->params = $params;
    }

    public function via($notifiable)
    {
        if(!$notifiable->notification_followed) {
            return [];
        }
        
        // Tell Laravel to send this notification via the database channel.
        // When Laravel encounters this, it will create a new record in the notifications table.
        return [CustomDatabaseChannel::class];
    }

    public function toDatabase($notifiable)
    {
        // The user_id and notification type are automatically set.
        // The returned array will be added to the data field of the notification.
        return [
            'event_id' => $this->params['id'],
            'sender_id' => $this->params['user_id'],
            'sender_username' => $this->params['username'],
            'receiver_id' => $this->params['profile_id'],
        ];
    }
}
