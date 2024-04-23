<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRFトークンをメタタグに追加 -->
    <title>My App</title>
    <style>
        .button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        #blogView {
            margin-top: 50px;
        }

        .post {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        #postScreen {
            display: none;
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translate(-50%, 0%);
            width: 80%;
            max-width: 800px;
            min-height: 400px;
            background-color: white;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1000;
            overflow: auto;
        }

        #closeButton {
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        form > div {
            margin-bottom: 10px; /* Spacing between form sections */
        }
    </style>
</head>
<body>
    <header>
        <button id="postButton" class="button">投稿</button>
        <button id="follwButton" class="button">フォロー一覧</button>
        <button id="DMButton" class="button">メッセージ一覧</button>
    </header>
    
    <div id="blogView">
        @foreach ($posts as $post)
            <div class="post">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                <p>大学名: {{ $post->university_name }}</p>
                <p>サークル名: {{ $post->circle_name }}</p>
                <p>サークルの種類: {{ $post->circle_type }}</p>
                <p>イベント開催日時: {{ $post->event_date ? $post->event_date->format('Y-m-d H:i') : '未設定' }}</p>
                <p>イベント開催場所: {{ $post->event_location }}</p>
                <p>追加情報: {{ $post->free_text }}</p>
                <p>締め切り: {{ $post->deadline ? $post->deadline->format('Y-m-d H:i') : '未設定' }}</p>
                @if ($post->user)
                    <a href="/chat/{{$post->id}}/{{ $post->user->id }}">チャットする</a>
                @endif
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                </form>
            </div>
        @endforeach
    </div>

    <div id="postScreen">
        <button id="closeButton">閉じる</button>
    </div>

    <script>
        document.getElementById('postButton').addEventListener('click', function() {
            var postScreen = document.getElementById('postScreen');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var formHtml = '<form action="{{ route('posts.store') }}" method="post">' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<div><label>タイトル:</label><input type="text" name="title" placeholder="" required></div>' +
                '<div>本文：<textarea name="body" required></textarea></div>' +
                '<div>大学名：<input type="text" name="university_name" required></div>' +
                '<div>サークル名：<input type="text" name="circle_name" required></div>' +
                '<div>サークルの種類：<input type="text" name="circle_type" required></div>' +
                '<div>開催場所：<input type="text" name="event_location" required></div>' +
                '<div>締め切り：<input type="datetime-local" name="deadline" required></div>' +
                '<div>開催日時：<input type="datetime-local" name="event_date" required></div>' +
                '<div>自由記述：<textarea name="free_text" placeholder="追加情報があればこちらに記入してください"></textarea></div>' +
                '<div><button type="submit" class="button">送信</button></div>' +
                '</form>';

            postScreen.innerHTML = '<button id="closeButton">閉じる</button>' + formHtml; // Ensure the closeButton is inside postScreen
            postScreen.style.display = 'block';
            document.getElementById('closeButton').addEventListener('click', function() {
                postScreen.style.display = 'none';
            });
        });
    </script>
</body>
</html>
