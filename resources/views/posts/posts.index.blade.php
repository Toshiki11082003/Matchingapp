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
            <p>{{ $post->content }}</p> {{-- この部分が重要です --}}
        </div>
    @endforeach
</body>
</html>
