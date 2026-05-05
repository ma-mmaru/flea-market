@extends('layouts.app')

@section('title', 'プロフィール編集画面（設定画面）')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('search')
<form class="header__search-form" action="{{ route('item.index') }}" method="get">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？" />
    <input type="hidden" name="tab" value="all">
</form>
@endsection

@section('content')
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
                    <img class="profile-image" src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像"
                        id="preview-img">
                    @else
                    {{-- 画像がない場合 --}}
                    <div class="image-placeholder" id="preview-placeholder"></div>
                    <img class="profile-image" src="" alt="プレビュー" id="preview-img">
                    @endif
                </div>
                <label class=" image-upload-button">
                    画像を選択する
                    <input type="file" name="profile_image" id="profile_image" accept=".jpeg, .png">
                </label>
                <div class="form__error">
                    @error('profile_image')
                    {{ $message }}
                    @enderror
                </div>
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
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" />
                </div>
                <div class="form__error">
                    @error('postal_code')
                    {{ $message }}
                    @enderror
                </div>
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
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
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
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class=" form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection