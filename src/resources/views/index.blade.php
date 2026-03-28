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
    <header class="toppage__header">
        <img class="img" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt=" coachtech">
        <form class="seach__form" action="/search" method="get">
            <input type=" text" name="item" placeholder="なにをお探しですか？" />
        </form>
        <div class="header__link">
            <a class="login__button-submit" href="/login">ログイン</a>
            <a class="mypage__button-submit" href="/mypage">マイページ</a>
            <a class="sell__button-submit" href="/sell">出品</a>
        </div>
    </header>
    <main>
        <div class="item__list">
            <a class="recommended-items__button-submit" href="/recommended">おすすめ</a>
            <a class="mylist_button-submit" href="/?tab=mylist">マイリスト</a>
        </div>
    </main>
</body>

</html>