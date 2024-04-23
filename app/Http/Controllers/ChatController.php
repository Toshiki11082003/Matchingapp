<?php

namespace App\Http\Controllers;
use App\Library\Chat;
use App\Models\Room;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; //ユーザーデータを扱えるように
use App\Models\Post;

class ChatController extends Controller
{
    public function openChat(Post $post , User $user, Message $message)
    {
        // 自分と相手のIDを取得
        $myUserId = Auth::id();
        $otherUserId = $user->id;
        $postId = $post->id;
        
        $message->post_id=$postId;

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
        
       
        $messages = Message::where('chat_id', $chat->id)->Where('post_id', $postId)->orderBy('updated_at', 'DESC')->get();;

        return view('chats/chat')->with(['chat' => $chat, 'messages' => $messages, 'postId'=>$postId]);
    }

   // メッセージ送信時の処理
    public function sendMessage(Message $message, Request $request,)
    {
        //dd($request);
        
        // auth()->user() : 現在認証しているユーザーを取得
        $user = auth()->user();
        $strUserId = $user->id;
        $strUsername = $user->name;
        $postId=$request->post_id;

        // リクエストからデータの取り出し
        $strMessage = $request->message;

        // メッセージオブジェクトの作成
        $chat = new Chat;
        $chat->body = $strMessage;
        $chat->chat_id = $request->chat_id;
 
        $chat->userName = $strUsername;
        MessageSent::dispatch($chat);    

        //データベースへの保存処理
        $message->user_id = $strUserId;
        $message->body = $strMessage;
        $message->chat_id = $request->chat_id;
        $message->post_id = $postId;
        $message->save();
        //dd($request);
        return response()->json(['message' => $strMessage, 'user'=> $strUsername]);
    }
}
