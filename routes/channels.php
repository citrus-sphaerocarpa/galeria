<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Only authenticated users will be able to listen on the chat channel.
// The channel(), the name of our channel and a callback function
// that will either return true or false depending on whether the current user is authenticated.
Broadcast::channel('chat', function ($user) {
    return auth()->check();
  });

Broadcast::channel('pchat.{chat_room_id}', function ($user, $chat_room_id) {
    return auth()->check();
});

Broadcast::channel('follow.{id}', function ($user) {
    return auth()->check();
});