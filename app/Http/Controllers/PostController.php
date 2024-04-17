<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
//use App\Models\User; 

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = new Post();
        //$user_id = Auth::id(); //ログインユーザーのID取得
        $post->title = $request->title;
        $post->body = $request->content;
        $date_test = Carbon::createFromFormat('Y-m-d\TH:i', $request->deadline)->format('Y-m-d H:i:s');
        $post->deadline = $date_test;
        $post->user_id = Auth::id(); //ログインユーザーのID取得
        $post->save();

        return redirect('/')->with('success', '投稿が成功しました！');
    }  

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->content;
        $post->save();

        return redirect('/posts')->with('success', '投稿が更新されました！');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿が削除されました。');
    }

    /**
     * 投稿にいいねを追加する
     */
    public function storeLike(Request $request, $postId)
    {
        // ユーザーがログインしているかどうかを確認するなど、適切な認証を行います

        // 既にいいねが存在するかどうかをチェックする
        $existingLike = Like::where('post_id', $postId)
                            ->where('user_id', auth()->user()->id)
                            ->first();

        if ($existingLike) {
            // 既にいいねが存在する場合は削除する
            $existingLike->delete();
            return redirect()->back()->with('success', 'いいねを取り消しました。');
        } else {
            // いいねが存在しない場合は新しいいいねを作成する
            $like = new Like();
            $like->post_id = $postId;
            $like->user_id = auth()->user()->id;
            $like->save();
            return redirect()->back()->with('success', '投稿にいいねしました！');
        }
    }
}
