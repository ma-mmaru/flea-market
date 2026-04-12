<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $user = Auth::user();
        $user->favoriteItems()->toggle($item->id);

        return back(); //詳細画面へ戻る
    }
}