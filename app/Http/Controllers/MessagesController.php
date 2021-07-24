<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\User;
use App\Models\Message;
use App\Events\PrivateMessageSent;
use App\Events\MessageSent;
use App\Notifications\NewPrivateMessage;
use Illuminate\Http\Request;


class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function fetchPrivateMessages($uuid)
    {
        $chat_room = ChatRoom::where('uuid', $uuid)->first();

        if(!is_null($chat_room)) {
            $messages = $chat_room->messages()->withTrashed()->with('user')->limit(100)->get();
        }

        return $messages;
    }

    public function sendPrivateMessage($uuid, Request $request)
    {
        $chat_room = ChatRoom::where('uuid', $uuid)->first();

        if(!is_null($chat_room)) {
            $input = request()->validate([
                'message' => ['required', 'max:500'],
            ]);

            $message = auth()->user()->messages()->create([
                'chat_room_id' => $chat_room->id,
                'receiver_id' => $request->friendId,
                'message' => $request->message,
            ]);

            // When a message is sent, the MessageSent event will be broadcast to Pusher with the give relationships.
            // The toOthers() method allows you to exclude the current user from the broadcast’s recipients.
            broadcast(new PrivateMessageSent($message->load('user', 'chatRoom')))->toOthers();

            // The Notify method expects to receive a notification instance.
            $receiver = User::find($message->receiver_id);

            if(!is_null($receiver)) {
                $receiver->notify(new NewPrivateMessage($message->load('user', 'chatRoom')));
            }

            return response(['status'=>'Message sent successfully','message'=>$message]);
        }
    }



    public function post(Request $request, User $user)
    {        
        return view('chats.index');
        // $input = $request->all();
        // $input['reveiver_id'] = $user->id;
        // $message = auth()->user()->messages()->create($input);

        // // when a message is sent, the MessageSent event will be broadcast to Pusher.
        // // toOthers() allows us to exclude the current user from the broadcast’s recipients.
        // broadcast(new MessageSent(auth()->user(), $message->load('user')))->toOthers();
        
        // return response(['status'=>'Message private sent successfully', 'message'=>$message]);
    }
    
    public function show(User $user)
    {
        $privateCommunication = Message::with('user')
        ->where(['user_id'=>auth()->id(), 'receiver_id'=>$user->id])
        ->orWhere(function($query) use($user){
            $query->where(['user_id'=>$user->id, 'receiver_id'=>auth()->id()]);
        })
        ->get();

        return $privateCommunication;
    }

}
