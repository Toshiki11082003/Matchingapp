<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>投稿一覧</title>
</head>
<body>
    <h1>投稿一覧</h1>
    @foreach ($posts as $post)
        <div>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->body }}</p> <!-- 本文を表示 -->
            <p>大学名: {{ $post->university_name }}</p>
            <p>サークル名: {{ $post->circle_name }}</p>
            <p>サークルの種類: {{ $post->circle_type }}</p>
            <p>イベント開催日時: {{ $post->event_date ? $post->event_date->format('Y-m-d H:i') : '未設定' }}</p>
            <p>イベント開催場所: {{ $post->event_location }}</p>
            <p>締め切り: {{ $post->deadline ? $post->deadline->format('Y-m-d H:i') : '未設定' }}</p>
            <p>追加情報: {{ $post->free_text }}</p>
        </div>
    @endforeach
</body>
</html>
