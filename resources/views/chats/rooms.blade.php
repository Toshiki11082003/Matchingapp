<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRFトークンをメタタグに追加 -->
    <title>My App</title>
</head>
<body>
    <div>
        @foreach($chats as $chat)
        <a href="/chat/{{$chat->guest_id}}">
            送ってきた相手のid：{{$chat->guest_id}}
        </a>
        
        @endforeach
    
    </div>
</body>
</html>
