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
        <form class="header__search-form" action="{{ route('item.index') }}" method="get">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？" />
            <input type="hidden" name="tab" value="{{ request('tab', 'all') }}">
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
            <div class="item-detail__image">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
            </div>
            <div class="item-detail__content">
                <div class="item-detail__name">
                    <h1 class="item-name">{{ $item->name }}</h1>
                    <p class="item-detail__brand">{{ $item->brand }}</p>
                    <p class="item-detail__price">¥{{ number_format($item->price) }}<span class="price-tax">(税込)</span>
                    </p>
                </div>
                <div class="item-detail__action">
                    <div class="item-detail__icon">
                        <div class="icon-item">
                            @auth
                            <form action="{{ route('like.store', $item) }}" method="post">
                                @csrf
                                <button type="submit" class="like__button-submit">
                                    <img src="{{ $item->isLikedBy(Auth::user()) ? asset('img/ハートロゴ_ピンク.png') : asset('img/ハートロゴ_デフォルト.png') }}"
                                        alt="like">
                                </button>
                            </form>
                            @else
                            <a class="icon-button" href="{{ route('login') }}"><img
                                    src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="like"></a>
                            @endauth
                            <span class="icon-count">{{ $item->likes()->count() }}</span>
                        </div>
                        <div class="icon-item">
                            <img src="{{ asset('img/ふきだしロゴ.png') }}" alt="comment">
                            <span class="icon-count">{{ $item->comments->count() }}</span>
                        </div>
                    </div>
                </div>
                {{-- 購入手続きボタン --}}
                <div class="item-detail_purchase-action">
                    <a class="purchase__button" href="{{ route('purchase.show', $item) }}">購入手続きへ</a>
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
                {{-- コメント一覧--}}
                <div class="item-detail__section">
                    <h2 class="section-title">コメント({{ $item->comments->count() }})</h2>
                    @foreach($item->comments as $comment)
                    <div class="comment-item">
                        <div class="user-info">
                            <div class="user-icon"></div>
                            <span class="user-name">{{ $comment->user->name }}</span>
                        </div>
                        <div class="comment-body">
                            {{ $comment->content }}
                        </div>
                    </div>
                    @endforeach
                    {{-- コメント投稿フォーム --}}
                    <div class="comment-form-block">
                        <p class="form-label">商品へのコメント</p>
                        <form action="{{ route('comment.store', $item) }}" method="post">
                            @csrf
                            <textarea name="content" class="comment-textarea">{{ old('content') }}</textarea>
                            <div class="form__error">
                                @error('content')
                                {{ $message }}
                                @enderror
                            </div>
                            @auth
                            <button type="submit" class="comment__button-submit">コメントを送信する</button>
                            @else
                            <a class="comment-button-submit" href="{{ route('login') }}">コメントを送信する</a>
                            @endauth
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>