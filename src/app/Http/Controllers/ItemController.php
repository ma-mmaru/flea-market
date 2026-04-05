<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        //クエリを準備する(自分が出品した商品は除く)
        $query = Item::query()->where('user_id', '!=', Auth::id());
        //検索キーワードがある場合商品名で部分一致
        if($request->filled('keyword'))
            {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            }
        //タブの判定
        $tab = $request->query('tab', 'all');
        if($tab === 'mylist')
            {
                //マイリスト：いいねした商品のみ
                if(Auth::check())
                    {
                        $query->whereHas('likes', function($q)
                        {
                            $q->where('user_id', Auth::id());
                        });
                    } else {
                        //未認証なら空にする
                        $query->whereRaw('1 = 0');
                    }
            }
            //データを取得
            $items = $query->get();
            //ビューに変数$itemsと$tabを渡す
            return view('index', compact('items', 'tab'));
    }
}