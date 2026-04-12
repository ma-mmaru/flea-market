<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
    </header>
    <main>
        <div class="verify-email--form__content">
            <div class="verify-email--form__heading">
                <p class="p1">登録していただいたメールアドレスに認証メールを送付いたしました。</p>
                <p class="p2">メール認証を完了してください。</p>
            </div>
            <form class="form" action="{{ route('verification.send') }}" method="post" novalidate>
                @csrf
                <button type="submit" class="verify-email__button-submit">認証メールを再送する</button>
            </form>
        </div>
    </main>
</body>

</html>