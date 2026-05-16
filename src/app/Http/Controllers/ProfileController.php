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
        $data = $request->only(['name', 'postal_code', 'address', 'building']);
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }
        $user->update($data);
        return redirect()->route('item.index')->with('message', 'プロフィールを更新しました');
    }
}