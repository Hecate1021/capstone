<?php

use App\Models\User;
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
Broadcast::channel('chat-channel.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('chat-channel.{receiverId}', function ($user, $receiverId) {
    // Replace with your logic to determine if the user can listen to the channel
    return (int) $user->id === (int) $receiverId;
});
Broadcast::channel('chat-channel.{receiverId}', function ($user, $receiverId) {
    logger("User ID: {$user->id} trying to access chat-channel.{$receiverId}");
    return (int) $user->id === (int) $receiverId;
});
