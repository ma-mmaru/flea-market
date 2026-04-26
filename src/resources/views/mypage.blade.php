<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        <form class="header__search-form" action="/search" method="get">
            <input type="text" name="keyword" placeholder="なにをお探しですか？" />
        </form>
        <div class="header__link-group">
            <form method="post" action="/logout">
                @csrf
                <button type="submit" class="logout__button-submit">ログアウト</button>
            </form>
            <a class="mypage__button-submit" href="/mypage">マイページ</a>
            <a class="sell__button-submit" href="/sell">出品</a>
        </div>
    </header>
    <main>
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
            <a class="profile-edit_button" href=" {{ route('profile.edit') }}">プロフィールを編集</a>
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
                <img src="{{ $order->item->image_url }}" alt="{{ $order->item->name }}">
                <p class="profile-item_name">{{ $order->item->name }}</p>
            </div>
            @endforeach
            @endif
        </div>
    </main>
</body>

</html>