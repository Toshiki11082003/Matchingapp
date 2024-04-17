<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; //ユーザーデータを扱えるように

class ChatController extends Controller
{
    public function openChat(User $user)
    {
        // 自分と相手のIDを取得
        $myUserId = Auth::id();
        $otherUserId = $user->id;

        // データベース内でチャットが存在するかを確認
        $chat = Room::where(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $myUserId)
                ->where('guest_id', $otherUserId);
        })->orWhere(function($query) use ($myUserId, $otherUserId) {
            $query->where('owner_id', $otherUserId)
                ->where('guest_id', $myUserId);
        })->first();

        // チャットが存在しない場合、新しいチャットを作成
        if (!$chat) {
            $chat = new Room();
            $chat->owner_id = $myUserId;
            $chat->guest_id = $otherUserId;
            $chat->save();
        }

        $messages = Message::where('chat_id', $chat->id)->orderBy('updated_at', 'DESC')->get();;

        return view('chats/chat')->with(['chat' => $chat, 'messages' => $messages]);
    }

    // メッセージ送信時の処理
    public function sendMessage(Request $request)
    {
        // auth()->user() : 現在認証しているユーザーを取得
        $user = auth()->user();
        $userId = $user->id;
        $username = $user->name;

        // リクエストからデータの取り出し
        $messageBody = $request->input('message');
        $chatId = $request->input('chat_id');

        // 新しいメッセージの作成と保存
        $message = new Message;
        $message->user_id = $userId;
        $message->body = $messageBody;
        $message->chat_id = $chatId;
        $message->save();

        // メッセージ送信イベントのディスパッチ
        event(new MessageSent($message, $username));

        return response()->json(['message' => 'Message sent successfully']);
    }
}
