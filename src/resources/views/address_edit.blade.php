<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送付先住所変更画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/address_edit.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        <form class="header__search-form" action="/" method="get">
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
    <main class="address__container">
        <h1 class="address__edit">住所の変更</h1>
        <form class="address__form" action="{{ route('address.update', $item) }}" method="post">
            @csrf
            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code"
                    value="{{ old('postal_code', $address['postal_code']) }}">
                <div class="form__error">
                    @error('postal_code')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $address['address']) }}">
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $address['building']) }}">
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <button class="address__button-submit">更新する</button>
        </form>
    </main>
</body>

</html>