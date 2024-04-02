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
            background-color: blue;
            color: white;
            border-radius: 20px;
        }

        #profileButton, #searchButton, #settingsButton {
            position: absolute;
            top: 10px;
        }

        #profileButton {
            left: 10px;
        }

        #searchButton {
            left: 50%;
            transform: translateX(-50%);
        }

        #settingsButton {
            right: 10px;
        }

        #blogView {
            margin-top: 50px;
        }

        #postButton {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        #postScreen {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%; /* 幅を設定 */
            max-width: 500px; /* 最大幅を設定 */
            min-height: 200px; /* 最小の高さを設定 */
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* 影を追加してポップアップ感を出す */
            z-index: 1000;
            overflow: auto; /* コンテンツがオーバーフローしたらスクロール可能にする */
        }
    </style>
</head>
<body>
    <header>
        <button id="profileButton" class="button">プロフィール</button>
        <button id="searchButton" class="button">検索</button>
        <button id="settingsButton" class="button">設定</button>
    </header>
    
    <div id="blogView">
        <?php
$date1 = new DateTime()
?>

{{dd(time())}}
        
        <!-- 投稿一覧を表示するセクション -->
        @foreach ($posts as $post)
            <div>
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                <!-- 締め切り日時の表示と判定 -->
                @if (!is_null($post->deadline))
                    @if (new DateTime() > new DateTime($post->deadline))
                        <p>この投稿は締め切りを過ぎています。</p>
                    @else
                        <p>締め切りまであと{{ (new DateTime($post->deadline))->diff(new DateTime())->format('%a 日') }}</p>
                    @endif
                @endif
            </div>
        @endforeach
    </div>

    <button id="postButton" class="button">投稿</button>

    <div id="postScreen"></div>

    <script>
        document.getElementById('postButton').addEventListener('click', function() {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var formHtml = '<form action="{{ route('posts.store') }}" method="post">' +
                            '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                            '<input type="text" name="title" placeholder="タイトルを入力"><br>' +
                            '<textarea name="content" placeholder="ここに内容を入力"></textarea><br>' +
                            '<button type="submit" class="button">送信</button>' +
                            '</form>';

            var postScreen = document.getElementById('postScreen');
            postScreen.innerHTML = formHtml;
            postScreen.style.display = 'block';
        });
    </script>
</body>
</html>


