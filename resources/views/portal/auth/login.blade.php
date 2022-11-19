@extends('portal.layouts.guest')
@section('guest')
    <div id="login" class="d-flex justify-content-center align-items-center">
        <div class="form">
            <form id="form-login" method="post" action="{{ route('portal.handle-login') }}" class="form-login">
                @csrf
                <div class="form-login__label f-w6 text-left">{{ __('auth.label.title') }}</div>
                <div class="input-group form-login__wrap position-relative">
                    <div class="form-login__prepend">
                    <span class="form-login__prepend__icon">
                        <img src="{{ asset('assets/img/icons/email.svg') }}" alt=""/>
                    </span>
                    </div>
                    <input class="form-login__input f-w3" type="text" name="email"
                           placeholder="{{ __('auth.placeholder.email') }}" value="{{ old('email') }}"
                           @if ($errors->has('email')) autofocus @endif />
                    @if ($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="input-group form-login__wrap position-relative">
                    <div class="form-login__prepend">
                    <span class="form-login__prepend__icon">
                        <img src="{{ asset('assets/img/icons/pass.svg') }}" alt=""/>
                    </span>
                    </div>
                    <input class="form-login__input f-w3 password" type="password" name="password"
                           placeholder="{{ __('auth.placeholder.password') }}" value="" autocomplete="off"
                           @if ($errors->has('password')) autofocus @endif />
                    @if ($errors->has('password'))
                        <div class="error">{{ $errors->first('password') }}</div>
                    @endif
                    <div class="error">
                        @if(session('message') != null) {{ session('message') }} @endif
                    </div>
                </div>
                <div class="form-login__submit d-flex justify-content-between align-items-center">
                    <button type="submit" class="form-login__submit-btn f-w6">{{ __('auth.button.login') }}</button>
                    <a href="{{ route('portal.password-reset.show-link') }}" class="form-login__submit-forgot f-w3">
                        {{ __('auth.label.forgot_password') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
