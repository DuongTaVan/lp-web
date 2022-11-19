@extends('client.base.base')
@section('header')
<title>登録</title>
@endsection
@section('content')
    @if (session('error') != null)
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    <!-- CONTENT -->
    <div class="register-wrap">
        <div class="register">
            <h1 class="f-w6 text-center">登録</h1>
            <p class="login__label text-center">既にアカウントをお持ちの方は<span><a href="{{ route('client.login') }}">こちら</a></span></p>
            <a href="{{ route('client.auth.url-redirect', ['service' => \App\Enums\Constant::SOCIAL_LOGIN_GOOGLE, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_REGISTER]) }}" class="register__google register__box-wrap f-w6 position-relative">
                <img
                        src="{{ url('/assets/img/user/google-login.svg') }}"
                        class="position-absolute"
                        alt=""
                />
                Googleで会員登録
            </a>
            <a href="{{ route('client.auth.url-redirect', ['service' => \App\Enums\Constant::SOCIAL_LOGIN_LINE, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_REGISTER]) }}" class="register__line register__box-wrap f-w6 position-relative">
                <img
                        src="{{ url('/assets/img/user/line-login.svg') }}"
                        class="position-absolute"
                        alt=""
                />
                LINEで会員登録
            </a>
            <a href="{{ route('client.auth.url-redirect', ['service' => \App\Enums\Constant::SOCIAL_LOGIN_FACEBOOK, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_REGISTER]) }}" class="register__facebook register__box-wrap f-w6 position-relative">
                <img
                        src="{{ url('/assets/img/user/facebook-login.svg') }}"
                        class="position-absolute"
                        alt=""
                />
                Facebookで会員登録
            </a>
            <div
                    class="
              horizontal-line
              d-flex
              justify-content-between
              align-items-center
            "
            >
                <div></div>
                <span class="f-w3 horizontal-line__text">または</span>
                <div></div>
            </div>
            <a href="{{ route('client.register-form') }}" class="register__label-email register__box-wrap f-w6" style="color: white">メールアドレスで登録する</a>
        </div>
    </div>
@endsection


@section('javascript')
    <script src="{{ asset('js/user/auth/register.js') }}"></script>
@endsection
