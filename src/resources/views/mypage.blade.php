@extends('layouts.app')

@section('title', 'プロフィール画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('search')
<form class="header__search-form" action="{{ route('item.index') }}" method="get">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？" />
    <input type="hidden" name="tab" value="all">
</form>
@endsection

@section('content')
@if(session('message'))
<div class="alert-success">
    {{ session('message') }}
</div>
@endif
<div class=" profile">
    <div class="profile-image">
        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('img/default-icon.png') }}"
            alt="ユーザー画像">
    </div>
    <h2 class="profile-name">{{ $user->name }}</h2>
    <a class="profile-edit_button" href="{{ route('profile.edit') }}">プロフィールを編集</a>
</div>
<div class="profile-tabs">
    <a class="profile-tab_link {{ $page == 'sell' ? 'active' : '' }}" href="?page=sell">出品した商品</a>
    <a class="profile-tab_link {{ $page == 'buy' ? 'active' : '' }}" href="?page=buy">購入した商品</a>
</div>
<div class="profile-item_list">
    @if($page == 'sell')
    @foreach($sellItems as $item)
    <div class="profile-item_card">
        <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
        <p class="profile-item_name">{{ $item->name }}</p>
    </div>
    @endforeach
    @else
    @foreach($buyItems as $order)
    <div class="profile-item_card">
        @if($order->item)
        <img src="{{ $order->item->image_url }}" alt="{{ $order->item->name }}">
        <p class="profile-item_name">{{ $order->item->name }}</p>
        @else
        <p class="profile-item_name">商品情報なし</p>
        @endif
    </div>
    @endforeach
    @endif
</div>
@endsection