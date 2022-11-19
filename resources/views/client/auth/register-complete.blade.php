@extends('client.base.base')
<style>
    ._btn:hover {
        text-decoration: none;
    }
</style>
@section('content')
    <!-- CONTENT -->
    <div class="register-complete-wrap">
        <div class="register-complete text-center">
            <h1 class="f-w6">本登録の完了</h1>
            <p class="_nickname f-w3">{{ auth()->guard('client')->user()->nickname }}様</p>
            <div class="register-complete__content text-left">
                <p class="f-w3 text-center">Lappiの本登録が完了しました。</p>
                <p class="f-w3 text-center">ご登録いただいた内容は以下の通りです。</p>
                <div class="_info">
                    <p>メールアドレス： {{ auth()->guard('client')->user()->email }}</p>
                    <p class="w-312">パスワード： ご登録いただいたパスワードです。</p>
                </div>
                @if (request()->get('user_type') == \App\Enums\DBConstant::USER_TYPE_TEACHER)
                    <div class="f-w6 d-flex">
                        <a class="_btn d-flex align-items-center justify-content-center mx-mobile-14"
                        href="{{ route('client.teacher.register.setting-account', auth()->guard('client')->user()->user_id) }}"
                        >{{ trans('labels.teacher_register.new_seller_registration') }}</a>
                    </div>
                @else
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
                @endif
            </div>
        </div>
    </div>
@endsection
