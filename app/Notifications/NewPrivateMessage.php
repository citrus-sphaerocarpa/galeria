<?php

namespace App\Notifications;

use App\Models\Message;
use App\Notifications\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPrivateMessage extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        // Require an instance of the $user to be injected when this notification is created.
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!$notifiable->notification_message) {
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
            'event_id' => $this->message->id,
            'chat_room_id' => $this->message->chat_room_id,
            'sender_username' => $this->message->user->username,
            'sender_id' => $this->message->user_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
        ];
    }

}
