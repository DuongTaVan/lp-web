@extends('client.base.base')

@section('content')
    <!-- CONTENT -->
    <div class="register-complete text-center">
        <h1 class="f-w6">本登録の完了</h1>
        <p class="_nickname f-w3">ニックネームさん</p>
        <div class="register-complete__content text-left">
            <p class="f-w3 text-left">Lappiの本登録が完了しました。</p>
            <p class="f-w3 text-left">ご登録いただいた内容は以下の通りです。</p>
            <div class="_info">
                <p>メールアドレス： nguyendinhtan1998vp@gmail.com</p>
                <p class="w-312">パスワード： ご登録いただいたパスワードです。</p>
            </div>
            <div class="f-w6 d-flex">
                <a class="_btn _btn--top-page d-flex align-items-center justify-content-center"
                   href="{{ route('client.home') }}"
                >
                    トップページへ</a>
                <a class="_btn _btn--change-info d-flex align-items-center justify-content-center"
                    href="{{ route('client.student.my-page.account-setting') }}"
                >
                    アカウント情報の変更</a>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script src="{{ asset('js/user/auth/register.js') }}"></script>
@endsection
