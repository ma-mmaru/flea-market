<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/item_detail.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        <form class="header__search-form" action="/" method="get">
            <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}" />
        </form>
        <div class="header__link-group">
            @auth
            <form class="logout-form" method="post" action="/logout">
                @csrf
                <button type="submit" class="logout__button-submit">ログアウト</button>
            </form>
            <a class="mypage__button-submit" href="/mypage">マイページ</a>
            @else
            <a class="login__button-submit" href="/login">ログイン</a>
            <a class="register__button-submit" href="/register">会員登録</a>
            @endauth
            <a class="sell__button-submit" href="/sell">出品</a>
        </div>
    </header>
    <main>
        <div class="item-detail__container">
            {{-- 商品画像 --}}
            <div class=" item-detail__image">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
            </div>
            <div class="item-detail__content">
                {{-- 商品名 --}}
                <div class="item-detail__name">
                    <h1 class="item-detail__name">{{ $item->name }}</h1>
                    {{-- ブランド名 --}}
                    <p class="item-detail__brand">{{ $item->brand ?? 'ブランドなし' }}</p>
                    {{-- 価格 --}}
                    <p class="item-detail__price">¥{{ number_format($item->price) }}<span class="price-tax">(税込)</span>
                    </p>
                </div>
                {{-- いいね/コメント数アイコン --}}
                <div class="item-detail__action-block">
                    <div class="item-detail__icon-row">
                        <div class="icon-item">
                            @auth
                            <form action="{{ route('like.store', $item) }}" method="post">
                                @csrf
                                {{-- アイコン --}}
                                <button type="submit" class="like__button-submit">
                                    <img src="{{ $item->isLikedBy(Auth::user()) ? asset('img/ハートロゴ_ピンク.png') : asset('img/ハートロゴ_デフォルト.png') }}"
                                        alt="like">
                                </button>
                            </form>
                            @else
                            {{-- 未ログイン時はアイコンのみ表示またはログインへ誘導 --}}
                            <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="like">
                            @endauth
                            {{-- いいいね合計 --}}
                            <span class="icon-count">{{ $item->likes()->count() }}</span>
                        </div>
                        {{-- コメント数 --}}
                        <div class="icon-item">
                            <img src="{{ asset('img/ふきだしロゴ.png') }}" alt="comment">
                            <span class="icon-count">{{ $item->comments->count() }}</span>
                        </div>
                    </div>
                    {{-- 購入手続きボタン --}}
                    <div class="item-detail_purchase-action">
                        <a class="purchase__button" href="{{ route('purchase.show', $item) }}">購入手続きへ</a>
                    </div>
                </div>
                {{-- 商品説明 --}}
                <div class="section">
                    <h2 class="section-title">商品説明</h2>
                    <div class="description-text">
                        {!! nl2br(e($item->description)) !!}
                    </div>
                </div>
                {{-- 商品の情報 --}}
                <div class="item-detail__section">
                    <h2 class="section-title">商品の情報</h2>
                    <div class="info-group">
                        <span class="info-label">カテゴリー</span>
                        <div class="category-tags">
                            @foreach($item->categories as $category)
                            <span class="category-tag">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="info-group">
                        <span class="info-label">商品の状態</span>
                        <span class="condition-text">{{ $item->condition }}</span>
                    </div>
                </div>
                {{-- コメント--}}
                <div class="item-detail__section">
                    <h2 class="section-title">コメント({{ $item->comments->count() }})</h2>
                    {{-- コメント一覧 --}}
                    <div class="comment-list">
                        @foreach($item->comments as $comment)
                        <div class="comment-item">
                            <div class="comment-user">
                                {{-- ユーザーアイコン --}}
                                <div class="user-avatar-placeholder"></div>
                                <span class=" user-name">{{ $comment->user->name }}</span>
                            </div>
                            <div class="comment-body">
                                {{ $comment->content }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{-- コメント投稿フォーム --}}
                    <div class="comment-form-block">
                        <p class="form-label">商品へのコメント</p>
                        @auth
                        <form action="{{ route('comment.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <textarea name="content" class="comment-textarea">{{ old('content') }}</textarea>
                            <div class="form__error">
                                @error('content')
                                {{ $message }}
                                @enderror
                            </div>
                            <button type="submit" class="comment__button-submit">コメントを送信する</button>
                        </form>
                        @else
                        <p class="login-prompt">コメントするには<a href="/login">ログイン</a>が必要です。</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>