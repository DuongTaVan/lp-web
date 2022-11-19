@extends('client.base.base')
@section('header')
    <title>ログイン</title>
@endsection
@section('css')
    <style>
        #header .header__left__search__icon-search {
            top: 8.5px;
        }
    </style>
@endsection
@section('content')
    @if (session('error') != null)
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    <!-- CONTENT -->
    <div class="login-wrap">
        <div class="login text-center">
            <h1 class="f-w6">ログイン</h1>
            <p class="register-label f-w3">
                会員登録は<span><a href="{{ route('client.register') }}">こちら</a></span>から行えます
            </p>
            <div class="login__wrap--btn">
                <a href="{{ route('client.auth.url-redirect', ['service' => \App\Enums\Constant::SOCIAL_LOGIN_GOOGLE, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_LOGIN]) }}"
                   class="login__google login__box-wrap f-w6 position-relative">
                    <img
                            src="{{ url('/assets/img/user/google-login.svg') }}"
                            class="position-absolute"
                            alt=""
                    />
                    Googleでログイン
                </a>
                <a href="{{ route('client.auth.url-redirect', ['service' => \App\Enums\Constant::SOCIAL_LOGIN_LINE, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_LOGIN]) }}"
                   class="login__line login__box-wrap f-w6 position-relative">
                    <img
                            src="{{ url('/assets/img/user/line-login.svg') }}"
                            class="position-absolute"
                            alt=""
                    />
                    LINEでログイン
                </a>
                <a href="{{ route('client.auth.url-redirect', ['service' => \App\Enums\Constant::SOCIAL_LOGIN_FACEBOOK, 'social_type' => \App\Enums\Constant::SOCIAL_TYPE_LOGIN]) }}"
                   class="login__facebook login__box-wrap f-w6 position-relative">
                    <img
                            src="{{ url('/assets/img/user/facebook-login.svg') }}"
                            class="position-absolute"
                            alt=""
                    />
                    Facebookでログイン
                </a>
            </div>
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
            <p class="login__label-email">メールアドレスでログイン</p>
            <form class="form-login" method="post" action="{{ route('client.handle-login') }}">
                @csrf
                <input type="text" id="email" class="form-login__email" onfocus="focusInput(this)"
                       onblur="blurInput(this)" placeholder="メールアドレス" name="email"
                       value="{{ old('email') }}"
                />
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
                <input type="password" class="form-login__password" onfocus="focusInput(this)"
                       onblur="blurInput(this)" placeholder="パスワード" name="password"
                       value="{{ old('password') }}"
                />
                @if ($errors->has('password'))
                    <div class="error">{{ $errors->first('password') }}</div>
                @endif
                <div class="error">
                    @if(session('message') != null)
                        {{ session('message') }}
                    @endif
                </div>
                <button class="form-login__submit login__box-wrap f-w6 position-relative">
                    ログイン
                </button>
            </form>
            <p class="forgot-password f-w6">
                <a class="f-w6" href="{{ route('client.password-reset.show-link') }}">パスワードをお忘れの方はこちら</a>
            </p>
        </div>
    </div>
@endsection
<script>
    function focusInput(e) {
        e.classList.add('input--focus');
    }

    function blurInput(e) {
        let valueTrim = e.value.trim();
        let valueTrimAll = valueTrim.replace(/\s+/g, '');
        $(e).val(valueTrimAll);
        e.setAttribute("value", valueTrimAll);
        e.classList.remove('input--focus');
    }
</script>

@section('script')
    <script>
        $(document).ready(function () {
            localStorage.setItem('isChangeName', 1);
            $(".form-login").on("submit", function () {
                $(this).find(".form-login__submit").prop("disabled", true);
            })
        })
    </script>
@endsection
