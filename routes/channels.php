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

// チャットルームごとの認証を設定
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return auth()->check(); // 必要に応じて、特定のユーザーがそのチャットルームにアクセスできるかを確認するロジックを追加
});
