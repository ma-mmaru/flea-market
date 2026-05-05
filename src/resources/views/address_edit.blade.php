@extends('layouts.app')

@section('title', '送付先住所変更画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address_edit.css') }}" />
@endsection

@section('search')
<form class="header__search-form" action="{{ route('item.index') }}" method="get">
    <input type="text" name="keyword" placeholder="なにをお探しですか？" />
    <input type="hidden" name="tab" value="{{ $tab ?? 'all' }}">
</form>
@endsection

@section('content')
<div class="address__container">
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
</div>
@endsection