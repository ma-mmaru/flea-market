<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
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
        if($request->hasFile('profile_image')){
            //既存の画像がある時は削除
            if($user->profile_image)
                {
                    Storage::disk('public')->delete($user->profile_image);
                }
            //storage/app/public/profile_imagesに保存してパスを取得
            $path = $request->file('profile_image')->store('profile_images', 'public');
            //データベースに保存するパスを上書き
            $data['profile_image'] = $path;
        }
        //バリデーション済み、画像パスのデータで更新
        $user->update($data);
        return redirect('/mypage')->with('message', 'プロフィールを更新しました');
    }
}