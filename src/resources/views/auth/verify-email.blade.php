@extends('layouts.auth')

@section('title', 'メール認証画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}" />
@endsection

@section('content')
<div class="verify-content">
    <div class="verify-heading">
        <p class="verify-message">登録していただいたメールアドレスに認証メールを送付いたしました。</p>
        <p class="verify-message">メール認証を完了してください。</p>
    </div>
    <div class="verify-action">
        <a class="verify-button" href="http://localhost:8025" target="_blank">認証はこちら</a>
    </div>
    <div class="verify-resend">
        <form class="verify-form" action="{{ route('verification.send') }}" method="post">
            @csrf
            <button type="submit" class="verify-button-submit">認証メールを再送する</button>
        </form>
    </div>
    @if(session('status') == 'verification-link-sent')
    <p class="status-message">新しい認証リンクを送信しました。</p>
    @endif
</div>
@endsection