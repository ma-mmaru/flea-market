{{-- 一つのファイル(index.blade.php)で商品一覧とマイリストを切り替える--}}
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧画面（トップ画面）</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        {{-- 検索フォーム(現在のタブの状態$tabをhiddenで保持) --}}
        <form class="header__search-form" action="/" method="get">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？" />
            <input type="hidden" name="tab" value="{{ $tab }}">
        </form>
        <div class="header__link-group">
            @guest
            <a class="login__button-submit" href="/login">ログイン</a>
            @else
            {{-- ログアウト機能 --}}
            <form class="logout__form" action="/logout" method="post">
                @csrf
                <button type="submit" class="logout__button-submit">ログアウト</button>
            </form>
            <a class="mypage__button-submit" href="/mypage">マイページ</a>
            @endguest
            <a class="sell__button-submit" href="/sell">出品</a>
        </div>
    </header>

    <main>
        <div class="item__tabs">
            {{-- 検索ワードを保持したままタブを切り替える --}}
            <a class="tab-link {{ $tab == 'all' ? 'active' : '' }}"
                href="/?tab=all&keyword={{ request('keyword') }}">おすすめ</a>
            <a class="tab-link {{ $tab == 'mylist' ? 'active' : '' }}"
                href="/?tab=mylist&keyword={{ request('keyword') }}">マイリスト</a>
        </div>
        <div class="item__grid">
            {{-- 商品一覧の表示 --}}
            @forelse($items as $item)
            {{-- 商品詳細画面へ --}}
            <a class="item__card-link" href="/item/{{ $item->id }}">
                <div class=" item__card">
                    <div class="item__image">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        {{-- 購入済み商品は[Sold]と表示 --}}
                        @if($item->isSold())
                        <span class="sold-label">Sold</span>
                        @endif
                    </div>
                    <p class="item__name">{{ $item->name }}</p>
                </div>
                @empty
                {{-- 未認証、該当なしの場合の表示 --}}
                <p class="empty-message">
                    @if($tab === 'mylist' && !Auth::check())
                    ログインするとマイリストが表示されます。
                    @else
                    表示する商品がありません。
                    @endif
                </p>
                @endforelse
        </div>
    </main>
</body>

</html>