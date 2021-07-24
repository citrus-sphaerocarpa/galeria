<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(User $user)
    {    
        // Fetch the user's private chat rooms (including deleted ones)
        $chat_rooms = ChatRoom::withTrashed()->where('user_id', auth()->id())
        ->orWhere('invitee_id', auth()->id())
        ->get();

        if(!$chat_rooms->isEmpty()) {
            $friends = [];

            foreach ($chat_rooms as $chat_room) {
                $user = User::withTrashed()->find($chat_room->user_id == auth()->id() ? $chat_room->invitee_id : $chat_room->user_id);
    
                $data = array(
                    'room_uuid' => $chat_room->uuid,
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'image' => $user->profile ? $user->profile->profileImage() : null,
                    'deleted_at' => $user->deleted_at,
                );
    
                array_push($friends, $data);
            }
        } else {
            $friends = null;
        }

        return view('chats.index', compact('friends'));
    }

    public function show($username, Request $request)
    {
        $this->authorize('view', auth()->user());

        if($username != auth()->user()->username) {
            $friend = User::withTrashed()->where('username', $username)->first();

            if(!is_null($friend)) {
                $chat_room = ChatRoom::where([
                    ['user_id', auth()->user()->id],
                    ['invitee_id', $friend->id]
                ])->orWhere([
                    ['user_id', $friend->id],
                    ['invitee_id', auth()->user()->id]
                ])->first();

                if(is_null($chat_room)) {
                    $chat_room = auth()->user()->chatRooms()
                    ->create([
                        'uuid' => (string) Str::uuid(),
                        'user_id' => auth()->user()->id,
                        'invitee_id' => $friend->id,
                        ]);
                }
                return view('chats.show', compact('friend', 'chat_room'));
            }
        }
    }

}
