@extends('portal.layouts.guest')
@section('guest')
    @if (session('success') != null)
        <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
    @endif
    @if (session('error') != null)
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    <div id="reset-password" class="d-flex justify-content-center align-items-center">
        <div class="form">
            <form action="{{ route('portal.password-reset.reset') }}" method="POST" class="form-reset" id="form-reset">
                @csrf
                <input type="hidden" name="token_password" value="{{ $token }}">
                <div class="form-reset__label f-w6 text-left">パスワードの再設定</div>
                <div class="form-reset__description f-w3 text-left">
                    ユーザーの確認ができましたので新しいパスワードを
                    <br>ご入力下 さい。
                </div>
                <input class="form-reset__input f-w3" type="password" name="new_password" placeholder="パスワード"
                       value="{{ old('new_password') }}"/>
                @if ($errors->has('new_password'))
                    <div class="error">{{ $errors->first('new_password') }}</div>
                @endif
                <input class="form-reset__input mt-3 f-w3" type="password" name="confirm_password"
                       placeholder="パスワード（確認用）"
                       value="{{ old('confirm_password') }}"/>
                @if ($errors->has('confirm_password'))
                    <div class="error">{{ $errors->first('confirm_password') }}</div>
                @endif
                <div class="form-reset__submit d-flex justify-content-between align-items-center">
                    <button type="submit" class="form-reset__submit-btn f-w6">登録</button>
                </div>
            </form>
        </div>
    </div>
@endsection
