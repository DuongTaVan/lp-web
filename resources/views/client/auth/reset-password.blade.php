@extends('client.base.base')
@section('header')
<title>パスワードを再設定する</title>
@endsection

@section('content')
    <!-- CONTENT -->
    @if (session('error'))
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    @if (session('success'))
        <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
    @endif

    <div class="reset-password-wrap">
        <div class="reset-password">
            <h1 class="f-w6">パスワードをお忘れですか?</h1>
            <p class="f-w3">ご登録されているメールアドレスに、パスワードの再発行手続きの案内をお送りします。</p>
            <form action="{{ route('client.password-reset.send') }}" method="post">
                @csrf
                <label for="" class="f-w3">メールアドレス</label>
                <input type="email" name="email">
                <button type="submit" class="f-w6"><span>送信する</span></button>
            </form>
        </div>
    </div>
@endsection
