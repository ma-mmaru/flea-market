<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item)
    {
        //ログインユーザーのみ保存
        Comment::create([
            'user_id' => Auth()->id(),
            'item_id' => $item,
            'content' => $request->content,
        ]);
        //画面を戻すとコメント数が増加表示
        return back()->with('message', 'コメントを投稿しました');
    }
}