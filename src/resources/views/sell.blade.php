<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品出品画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        <form class="header__search-form" action="{{ route('item.index') }}" method="get">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？" />
            <input type="hidden" name="tab" value="all">
        </form>
        <div class=" header__link-group">
            <form method="post" action="/logout">
                @csrf
                <button type="submit" class="logout__button-submit">ログアウト</button>
            </form>
            <a class="mypage__button-submit" href="/mypage">マイページ</a>
            <a class="sell__button-submit" href="/sell">出品</a>
        </div>
    </header>
    <main>
        <div class="sell">
            <h1 class="sell-title">商品の出品</h1>
            <form method="post" action="{{ route('exhibition.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="sell-form-section">
                    <p class="sell-section-title">商品画像</p>
                    <div class="sell-image">
                        <label class="sell-label" for="image_url">
                            <span class="sell-image-button">画像を選択する</span>
                            <input type="file" class="sell-image-input" name="image_url" id="image_url">
                        </label>
                    </div>
                    <div class="form__error">
                        @error('image_url')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-form-section">
                    <h2 class="sell-section-header">商品の詳細</h2>
                    <div class="sell-input">
                        <p class="sell-input-label">カテゴリー</p>
                        <div class="sell-category-list">
                            @foreach($categories as $category)
                            <div class="sell-category-item">
                                <input type="checkbox" class="sell-category-checkbox" name="categories[]"
                                    id="cat-{{ $category->id }}" value="{{ $category->id }}">
                                <label class="sell-category-tag"
                                    for="cat-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form__error">
                            @error('categories')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="sell-input">
                        <p class="sell-input-label">商品の状態</p>
                        <div class="sell-select">
                            <select name="condition">
                                <option value="" disabled selected>選択してください</option>
                                <option value="良好">良好</option>
                                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                                <option value="状態が悪い">状態が悪い</option>
                            </select>
                        </div>
                        <div class="form__error">
                            @error('condition')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="sell-form-section">
                    <h2 class="sell-section-header">商品と説明</h2>
                    <div class="sell-input">
                        <p class="sell-input-label">商品名</p>
                        <input type="text" class="sell-text-input" name="name" value="{{ old('name') }}">
                        <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="sell-input">
                        <p class="sell-input-label">ブランド名</p>
                        <input type="text" class="sell-text-input" name="brand" value=" {{ old('brand') }}">
                    </div>
                    <div class="sell-input">
                        <p class="sell-input-label">商品の説明</p>
                        <textarea class=" sell-textarea-input" name="description" row="5">
                        {{ old('description') }}</textarea>
                        <div class=" form__error">
                            @error('description')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="sell-input">
                        <p class="sell-input-label">販売価格</p>
                        <div class="sell-price">
                            <span class="sell-price-symbol">¥</span>
                            <input type="number" class="sell-price-input" name="price" value="{{ old('price') }}">
                        </div>
                        <div class=" form__error">
                            @error('price')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="sell-button-submit">出品する</button>
            </form>
        </div>
    </main>
</body>

</html>