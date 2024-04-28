<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * 投稿一覧を表示する。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();  // すべての投稿を取得
        return view('posts.index', ['posts' => $posts]);  // 投稿一覧ビューを表示
    }

    /**
     * 新しい投稿作成フォームを表示する。
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');  // 投稿作成ビューを表示
    }

    /**
     * 新しい投稿を保存する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 入力データのバリデーション
        $validatedData = $request->validate([
            'title' => 'required|max:255', // タイトルは必須で最大255文字
            'body' => 'nullable', // 本文は必須
            'deadline' => 'nullable|date_format:Y-m-d\TH:i', // 締め切りは特定のフォーマットが必要
            'university_name' => 'required|max:255', // 大学名は必須で最大255文字
            'circle_name' => 'required|max:255', // サークル名は必須で最大255文字
            'circle_type' => 'required|max:255', // サークルの種類は必須で最大255文字
            'event_date' => 'required|date_format:Y-m-d\TH:i', // 開催日時は必須で特定のフォーマットが必要
            'event_location' => 'required|max:255', // 開催場所は必須で最大255文字
            'free_text' => 'nullable|max:1000', // 追加情報は最大1000文字
            'cost' => 'nullable|numeric' // 費用は数値で必須ではない
        ]);

        // 新しい投稿のインスタンスを作成し、データベースに保存
        $post = new Post($validatedData);
        $post->user_id = Auth::id(); // ログインユーザーのIDを取得
        $post->save();

        // 投稿一覧ページへリダイレクトし、成功メッセージを表示
        return redirect('/')->with('success', '投稿が成功しました！');
    }

    /**
     * 指定された投稿を削除する。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);  // IDに基づいて投稿を検索
        $post->delete();  // 投稿を削除

        // 投稿一覧ページへリダイレクトし、成功メッセージを表示
        return redirect()->route('posts.index')->with('success', '投稿が削除されました。');
    }

    /**
     * 投稿にいいねを追加または削除する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function storeLike(Request $request, $postId)
    {
        $existingLike = Like::where('post_id', $postId)  // 投稿IDに基づいていいねを検索
                            ->where('user_id', Auth::id())
                            ->first();

        if ($existingLike) {
            // 既にいいねが存在する場合は削除
            $existingLike->delete();
            return redirect()->back()->with('success', 'いいねを取り消しました。');
        } else {
            // いいねが存在しない場合は新しいいいねを作成
            $like = new Like([
                'post_id' => $postId,
                'user_id' => Auth::id(),
            ]);
            $like->save();
            return redirect()->back()->with('success', '投稿にいいねしました！');
        }
    }
}