<!DOCTYPE html>
<html lang="en">
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
            border-radius: 15px; /* 角をより丸く */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* 軽い影を追加 */
            background-color: #f9f9f9; /* 背景色を薄く設定 */
        }

        #postScreen {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            max-width: 500px;
            min-height: 200px;
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            overflow: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
         <button id="postButton" class="button">投稿</button>
        <button id="searchButton" class="button">検索</button>
        <button id="settingsButton" class="button">設定</button>
    </header>
    
    <div id="blogView">
        @foreach ($posts as $post)
            <div class="post">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                @if (!is_null($post->deadline))
                    @php
                        $deadline = new DateTime($post->deadline);
                        $now = new DateTime();
                        if ($now > $deadline) {
                            echo '<p>この投稿は締め切りを過ぎています。</p>';
                        } else {
                            $interval = $now->diff($deadline);
                            echo '<p>締め切りまであと ' . $interval->format('%a 日 %h 時間 %i 分') . '</p>';
                        }
                    @endphp
                @endif
            </div>
        @endforeach
    </div>

    

    <div id="postScreen"></div>

    <script>
        document.getElementById('postButton').addEventListener('click', function() {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var formHtml = '<form action="{{ route('posts.store') }}" method="post">' +
                            '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                            '<input type="text" name="title" placeholder="タイトルを入力"　required><br>' +
                            '<textarea name="content" placeholder="ここに内容を入力" required></textarea><br>' +
                            '<label for="deadline">Deadline:</label><br>' +
                            '<input type="datetime-local" id="deadline" name="deadline"><br>' +
                            '<button type="submit" class="button">送信</button>' +
                            '</form>';

            var postScreen = document.getElementById('postScreen');
            postScreen.innerHTML = formHtml;
            postScreen.style.display = 'block';
        });
    </script>
</body>
</html>
