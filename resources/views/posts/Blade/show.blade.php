<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $post->title }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>
    <!-- 日付が存在する場合にはフォーマットして表示、存在しない場合には '未設定' を表示 -->
    <p>締め切り: {{ $post->deadline ? $post->deadline->format('Y-m-d H:i') : '未設定' }}</p>
    <p>大学名: {{ $post->university_name }}</p>
    <p>サークル名: {{ $post->circle_name }}</p>
    <p>サークルの種類: {{ $post->circle_type }}</p>
    <!-- イベント日時の表示も同様に条件付きでフォーマット -->
    <p>イベント開催日時: {{ $post->event_date ? $post->event_date->format('Y-m-d H:i') : '未設定' }}</p>
    <p>イベント開催場所: {{ $post->event_location }}</p>
    <!-- 追加された「費用」フィールドを表示 -->
    <p>費用: {{ $post->cost ?? '未設定' }}</p>
    <p>追加情報: {{ $post->free_text }}</p>
</body>
</html>
