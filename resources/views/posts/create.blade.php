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
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="タイトル" value="{{ old('title') }}"/>
            <p style="color:red">{{ $errors->first('title') }}</p>
        </div>
        <div>
            <label for="university_name">University Name:</label>
            <input type="text" id="university_name" name="university_name" placeholder="大学名" value="{{ old('university_name') }}">
            <p style="color:red">{{ $errors->first('university_name') }}</p>
        </div>
        <div>
            <label for="circle_name">Circle Name:</label>
            <input type="text" id="circle_name" name="circle_name" placeholder="サークル名" value="{{ old('circle_name') }}">
            <p style="color:red">{{ $errors->first('circle_name') }}</p>
        </div>
        <div>
            <label for="circle_type">Circle Type:</label>
            <input type="text" id="circle_type" name="circle_type" placeholder="サークルの種類" value="{{ old('circle_type') }}">
            <p style="color:red">{{ $errors->first('circle_type') }}</p>
        </div>
        <div>
            <label for="event_location">Event Location:</label>
            <input type="text" id="event_location" name="event_location" placeholder="イベント開催場所" value="{{ old('event_location') }}">
            <p style="color:red">{{ $errors->first('event_location') }}</p>
        </div>
        <div>
            <label for="cost">Cost:</label>
            <input type="text" id="cost" name="cost" placeholder="費用" value="{{ old('cost') }}">
            <p style="color:red">{{ $errors->first('cost') }}</p>
        </div>
        <div>
            <label for="event_date">Event Date:</label>
            <input type="datetime-local" id="event_date" name="event_date" value="{{ old('event_date') }}">
            <p style="color:red">{{ $errors->first('event_date') }}</p>
        </div>
        <div>
            <label for="deadline">Deadline:</label>
            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline') }}">
            <p style="color:red">{{ $errors->first('deadline') }}</p>
        </div>
        <div>
            <label for="free_text">Additional Information:</label>
            <textarea id="free_text" name="free_text" placeholder="追加情報があればこちらに記入してください。">{{ old('free_text') }}</textarea>
            <p style="color:red">{{ $errors->first('free_text') }}</p>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
