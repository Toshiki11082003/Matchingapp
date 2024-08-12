<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        $myUserId = auth()->user()->id;
        $chats = Room::where(function($query) use ($myUserId) {
            $query->where('owner_id', $myUserId)
                  ->orWhere('guest_id', $myUserId);
        })->get();

        return view('chats.rooms')->with(['chats' => $chats]);
    }

    public function openChat(User $user)
    {
        $myUserId = auth()->user()->id;
        $postUserId = $user->id;

        // ルームが既に存在するか確認する
        $chat = Room::where(function($query) use ($myUserId, $postUserId) {
            $query->where('owner_id', $myUserId)
                  ->where('guest_id', $postUserId);
        })->orWhere(function($query) use ($myUserId, $postUserId) {
            $query->where('owner_id', $postUserId)
                  ->where('guest_id', $myUserId);
        })->first();

        // ルームが存在しない場合、新しいルームを作成する
        if (!$chat) {
            $chat = new Room();
            $chat->owner_id = $myUserId;
            $chat->guest_id = $postUserId;
            $chat->save();
        }

        $messages = Message::where('chat_id', $chat->id)->orderBy('created_at', 'DESC')->get();

        return view('chats.chat')->with(['chat' => $chat, 'messages' => $messages]);
    }

    public function sendMessage(Request $request)
{
    $user = auth()->user();
    $strUserId = $user->id;
    $strUsername = $user->name;

    $strMessage = $request->message;
    $chatId = $request->chat_id;

    // ルームが存在するか確認する
    $room = Room::find($chatId);
    if (!$room) {
        return response()->json(['error' => 'Room not found'], 404);
    }

    $message = new Message();
    $message->user_id = $strUserId;
    $message->body = $strMessage;
    $message->chat_id = $chatId;
    $message->save();

    // Pusherイベントの発火
    event(new MessageSent($message));  // 修正: イベントの発火を確認

    return response()->json(['message' => $strMessage, 'user' => $strUsername]);
}
    public function show($chatId)
    {
        $room = Room::with(['messages' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($chatId);

        return view('chats.chat', ['chat' => $room, 'messages' => $room->messages]);
    }
}
