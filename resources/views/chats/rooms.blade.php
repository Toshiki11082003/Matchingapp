<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRFトークンをメタタグに追加 -->
    <title>My App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chat-link {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .chat-link:hover {
            background-color: #e9e9e9;
        }
    </style>
</head>
<body>
    <div class="container">
        @foreach($chats as $chat)
        <a class="chat-link" href="/chat/{{$chat->guest_id}}">
            送信したユーザ：{{$chat->guest_id}}
        </a>
        @endforeach
    </div>
</body>
</html>
