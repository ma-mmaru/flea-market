<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();
        //ログインしている場合のみ自分の商品を除く
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }
        //検索キーワードがある場合商品名で部分一致
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        //タブの判定
        $tab = $request->query('tab', 'all');
        if ($tab === 'mylist') {
            //マイリスト：いいねした商品のみ
            if (Auth::check()) {
                $query->whereHas('likes', function ($q) {
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
    public function show(Item $item)
    {
        //Eager Loadingでカテゴリとコメント・投稿者情報を一括に取得
        $item->load(['categories', 'comments.user']);
        return view('item_detail', compact('item'));
    }
    //購入手続き画面へ
    public function purchase(Item $item)
    {
        //商品情報を保持したまま購入確認画面を表示
        return view('purchase', compact('item'));
    }
    //出品画面の表示
    public function create()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }
    //出品処理
    public function store(ExhibitionRequest $request)
    {
        $user = Auth::user();
        $path = $request->file('image_url')->store('item_images', 'public');
        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'image_url' => $path
        ]);
        $item->categories()->attach($request->categories);
        return redirect()->route('mypage')->with('message', '商品を出品しました');
    }
}