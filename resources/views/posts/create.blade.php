<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Create Post</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
    <h1>Create New Post</h1>
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
         <div class="title">
            <h2>Title</h2>
            <input type="text" name="post[title]" placeholder="タイトル" value="{{ old('post.title') }}"/>
            <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
        </div>
        <div class="body">
            <h2>Body</h2>
            <textarea name="post[body]" placeholder="今日も1日お疲れさまでした。">{{ old('post.body') }}</textarea>
            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
        <div>

        {{-- 締め切り日時入力フィールドを追加 --}}
        <label for="deadline">Deadline:</label><br>
        <input type="datetime-local" id="deadline" name="deadline"><br>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>
