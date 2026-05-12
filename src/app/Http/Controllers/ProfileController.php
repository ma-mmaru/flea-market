<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    //マイページの表示
    public function index(Request $request)
    {
        $user = Auth::user();
        $sellItems = Item::where('user_id', $user->id)->get();
        $buyItems = Order::where('user_id', $user->id)->with('item')->get();
        $page = $request->query('page', 'sell');
        return view('mypage', compact('user', 'sellItems', 'buyItems', 'page'));
    }
    //プロフィール編集画面の表示
    public function edit()
    {
        return view('mypage_profile', ['user' => Auth::user()]);
    }
    //プロフィールの更新処理
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        //画像がアップロードされた時の処理
        if ($request->hasFile('profile_image')) {
            //既存の画像がある時は削除
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            //storage/app/public/profile_imagesに保存してパスを取得
            $path = $request->file('profile_image')->store('profile_images', 'public');
            //データベースに保存するパスを上書き
            $data['profile_image'] = $path;
        }
        //バリデーション済み、画像パスのデータで更新
        $user->update($data);
        return redirect()->route('mypage')->with('message', 'プロフィールを更新しました');
    }
}