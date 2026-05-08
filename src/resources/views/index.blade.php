@extends('layouts.app')

@section('title', '商品一覧画面（トップ画面）')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('search')
<form class="header__search-form" action="{{ route('item.index') }}" method="get">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？" />
    <input type="hidden" name="tab" value="{{ $tab ?? 'all' }}">
</form>
@endsection

@section('content')
<div class="item__tabs">
    <div class="item__tabs-inner">
        <a class="tab-link {{ $tab == 'all' ? 'active' : '' }}" href="/?tab=all&keyword={{ request('keyword') }}">
            おすすめ</a>
        @auth
        <a class="tab-link {{ $tab == 'mylist' ? 'active' : '' }}"
            href="/?tab=mylist&keyword={{ request('keyword') }}">マイリスト</a>
        @else
        <a class="tab-link {{ $tab == 'mylist' ? 'active' : '' }}" href="{{ route('mypage') }}">マイリスト</a>
        @endauth
    </div>
</div>
<div class="item__grid">
    {{-- 商品一覧の表示 --}}
    @forelse($items as $item)
    {{-- 商品詳細画面へ --}}
    <a class="item__card-link" href="/item/{{ $item->id }}">
        <div class="item__card">
            <div class="item__image">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                {{-- 購入済み商品は[Sold]と表示 --}}
                @if($item->isSold())
                <span class="sold-label">Sold</span>
                @endif
            </div>
            <p class="item__name">{{ $item->name }}</p>
        </div>
    </a>
    @empty
    {{-- 未認証、該当なしの場合の表示 --}}
    <p class="empty-message">表示する商品がありません。</p>
    @endforelse
</div>
@endsection