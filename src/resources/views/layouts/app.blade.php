<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <img class=" header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
            @yield('search')
            <nav class="header__link-group">
                @auth
                <form class="logout__form" action="/logout" method="post">
                    @csrf
                    <button type="submit" class="logout__button-submit">ログアウト</button>
                </form>
                <a class="mypage__button-submit" href="/mypage">マイページ</a>
                @else
                <a class="login__button-submit" href="/login">ログイン</a>
                @endauth
                <a class="sell__button-submit" href="/sell">出品</a>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>