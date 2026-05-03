<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品購入画面 - {{ $item->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
</head>

<body>
    <header class="header">
        <img class="header__logo" src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="coachtech">
        <form class="header__search-form" action="{{ route('item.index') }}" method="get">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder=" なにをお探しですか？" />
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
    <main class="purchase">
        <form class="purchase__form" action=" {{ route('purchase.store', $item) }}" method="post">
            @csrf
            <input type="hidden" name="shipping_postal_code" value="{{ $address['postal_code'] }}">
            <input type="hidden" name="shipping_address" value="{{ $address['address'] }}">
            <input type="hidden" name="shipping_building" value="{{ $address['building'] }}">
            <div class="purchase__container">
                <div class="purchase__main">
                    <div class="purchase__item-info">
                        <div class="purchase__item-image">
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        </div>
                        <div class="purchase__item-detail">
                            <h1 class="purchase__item-name">{{ $item->name }}</h1>
                            <p class="purchase__item-price">¥ {{ number_format($item->price) }}</p>
                        </div>
                    </div>
                    <hr class="purchase__hr">
                    <div class="purchase__section">
                        <h2 class="purchase__section-title">支払い方法</h2>
                        <div class="purchase__select-wrapper">
                            <select class="purchase__select" name="payment_method"
                                onchange="location.href='?payment_method=' + this.value;">
                                <option value="" disabled {{ !$selectedPayment ? 'selected' : ''}}>選択してください
                                </option>
                                <option value="konbini" {{ $selectedPayment == 'konbini' ? 'selected' : '' }}>
                                    コンビニ支払い
                                </option>
                                <option value="card" {{ $selectedPayment == 'card' ? 'selected' : ''}}>カード支払い
                                </option>
                            </select>
                        </div>
                        <div class="form__error">
                            @error('payment_method')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <hr class="purchase__hr">
                    <div class="purchase__section">
                        <div class="purchase__section-header">
                            <h2 class="purchase__section-title">配送先</h2>
                            <a class="purchase__link" href=" {{ route('address.edit', $item) }}">変更する</a>
                        </div>
                        <div class="purchase__address-display">
                            <p class="purchase__text">〒 {{ $address['postal_code'] }}</p>
                            <p class="purchase__text">{{ $address['address'] }} {{ $address['building'] }}
                            </p>
                        </div>
                        <div class="form__error">
                            @error('shipping_postal_code')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <hr class="purchase__hr">
                </div>
                <aside class="purchase_sidebar">
                    <div class="purchase__summary">
                        <table class="purchase__table">
                            <tr>
                                <th>商品代金</th>
                                <td>¥ {{ number_format($item->price) }}</td>
                            </tr>
                            <tr>
                                <th>支払い方法</th>
                                <td>
                                    @if(request('payment_method') == 'card' || old('payment_method') == 'card')
                                    カード支払い
                                    @elseif(request('payment_method') == 'konbini' || old('payment_method') ==
                                    'konbini')
                                    コンビニ支払い
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="purchase__action">
                        <button class="purchase__button-submit" type="submit">購入する</button>
                    </div>
                </aside>
            </div>
        </form>
    </main>
</body>

</html>