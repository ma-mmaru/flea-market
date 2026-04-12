<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        //ログインユーザーのみ保存
        Comment::create([
            'user_id' => Auth()->id(),
            'item_id' => $request->item_id,
            'content' => $request->content,
        ]);
        //画面を戻すとコメント数が増加表示
        return back()->with('message', 'コメントを投稿しました');
    }
}