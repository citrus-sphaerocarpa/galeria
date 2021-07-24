<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $items = auth()->user()->unreadNotifications()->get();
        
        $notifications = [];

        foreach ($items as $item) {
            $sender = User::find($item->sender_id);

            $notification = array(
                'id' => $item->id,
                'user_id' => $item->sender_id,
                'username' => $sender->username,
                'image' => $sender->profile->profileImage(),
                'type' => $item->type,
                'data' => $item->type == 'App\\Notifications\\NewPrivateMessage' ? $item->data['message'] : '',
                'date' => get_time_ago(strtotime($item->created_at)),
                // The get_time_ago() is custom helper function in App\Helper\Helper.php
            );
            
            array_push($notifications, $notification);
        }

        return view('notifications.index', compact('notifications'));
    }

    public function show()
    {
        $new_followers = auth()->user()->notification_followed;
        $new_messages = auth()->user()->notification_message;

        return view('notifications.show', compact('new_followers', 'new_messages'));
    }

    public function update(Request $request)
    {
        $this->authorize('update', auth()->user());

        $new_followers = $request->input('new_followers');
        $new_messages = $request->input('new_messages');

        if(!is_null($new_followers)) {
            auth()->user()->update([
                'notification_followed' => true,
            ]);
        } else {
            auth()->user()->update([
                'notification_followed' => false,
            ]);
        }

        if(!is_null($new_messages)) {
            auth()->user()->update([
                'notification_message' => true,
            ]);
        } else {
            auth()->user()->update([
                'notification_message' => false,
            ]);
        }

        return back()->with('success', __('Successfully saved the settings.'));
    }

    public function fetchNotifications(Request $request)
    {
        // Prevent to display new notifications when user is in a private chat      
        if(preg_match('{/chat/private/}', $request->path)) {
            $arr = explode('/', $request->path);
            $friend = User::withTrashed()->where('username', $arr[count($arr) - 1])->first();

            if(!is_null($friend)) {
                $notifications = auth()->user()->unreadNotifications()->where([
                    ['type', 'App\\Notifications\\NewPrivateMessage'],
                    ['sender_id', $friend->id],
                    ['notifiable_id', auth()->user()->id],
                    ])
                    ->get();

                if(!is_null($notifications->toArray())) {
                    foreach ($notifications as $notification) {
                        $notification->markAsRead();
                    }
                }
            }
        }

        // Show a listing of notifications.
        return auth()->user()->unreadNotifications()->get()->toArray();
    }

    // public function makePrivateMessageAsRead(Request $request)
    // {
    //     // make massage as read 
    //     $notifications = auth()->user()->unreadNotifications()->where([
    //         ['type', 'App\\Notifications\\NewPrivateMessage'],
    //         ['sender_id', $request->friendId],
    //         ['notifiable_id', auth()->user()->id],
    //         ])
    //         ->get();

    //     if(!is_null($notifications->toArray())) {
    //         foreach ($notifications as $notification) {
    //             $notification->markAsRead();
    //         }
    //     }
    // }
}
