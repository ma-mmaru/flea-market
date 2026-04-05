<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集画面（設定画面）</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}" />
</head>

<body>
    <header class="toppage__header">
        <img class="img" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        <form class="seach__form" action="/search" method="get">
            <input type="text" name="item" placeholder="なにをお探しですか？" />
        </form>
        <div class="header__link">
            <form method="post" action="/logout">
                @csrf
                <button type="submit" class="login__button-submit">ログアウト</button>
            </form>
            <a class=" mypage__button-submit" href="/mypage">マイページ</a>
            <a class="sell__button-submit" href="/sell">出品</a>
        </div>
    </header>
    <main>
        <div class="mypage__profile--form__content">
            <div class="mypage__profile--form__heading">
                <h1 class="mypage__profile">プロフィール設定</h1>
            </div>
            <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form__group">
                    <div class="form__group-content--image">
                        <div class="profile-image-container">
                            @if($user->profile_image)
                            {{-- 画像がある場合 --}}
                            <img class="profile-image" src="{{ asset('storage/' . $user->profile_image) }}"
                                alt="プロフィール画像" id="preview-img">
                            @else
                            {{-- 画像がない場合 --}}
                            <div class="image-placeholder" id="preview-placeholder"></div>
                            @endif
                        </div>
                        <label class="image-upload-button">
                            画像を選択する
                            <input type="file" name="profile_image" id="profile_image" accept=".jpeg, .png">
                        </label>
                        @error('profile_image')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">ユーザー名</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" />
                        </div>
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">郵便番号</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="postal_code"
                                value="{{ old('postal_code', $user->postal_code) }}" />
                        </div>
                        @error('postal_code')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">住所</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" />
                        </div>
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">建物名</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="building" value="{{ old('building', $user->building) }}" />
                        </div>
                        @error('building')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class=" form__button">
                    <button class="form__button-submit" type="submit">更新する</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>