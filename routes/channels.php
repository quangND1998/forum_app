<?php

use App\Models\Conversation;
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

Broadcast::channel('replie_event.{id}', function ($user) {
    return true;
});
Broadcast::channel('like_event', function ($user) {
    return true;
});
Broadcast::channel('conversation_event', function ($user) {
    return true;
});
Broadcast::channel('deleteConversation_event', function ($user) {
    return true;
});
Broadcast::channel('view_conversation_event', function ($user) {
    return true;
});
Broadcast::channel('update-replie.{id}', function ($user) {
    return true;
});
Broadcast::channel('update-conversation.{id}', function ($user) {
    return true;
});
Broadcast::channel('sovled-conversation', function ($user) {
    return true;
});
Broadcast::channel('active-conversation', function ($user) {
    return true;
});
Broadcast::channel('active-device', function ($user) {
    return true;
});
Broadcast::channel('delete-reply', function ($user) {
    return true;
});
Broadcast::channel('best-answer', function ($user) {
    return true;
});


Broadcast::channel('device-session.{code}', function ($user) {
    return true;
});

Broadcast::channel('message-send', function ($user) {
    return true;
});
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});