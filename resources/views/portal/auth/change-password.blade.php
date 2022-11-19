@extends('portal.layouts.main')
@section('content')
    <div id="change-password" class="">
        <div class="label f-w6 text-left">パスワード変更</div>
        <div class="form text-left">
            <div class="form__label f-w6">パスワード情報</div>
            <form class="d-flex justify-content-between align-items-end" id="change-password-form"
                  action="{{route('portal.post-change-password')}}" method="post">
                @csrf
                <div class="form__info-password align-items-center">
                    <div class="row password_row">
                        <div class="col-md-4 f-w6 form__info-password__label">現在のパスワード</div>
                        <div class="col-md-7">
                            <input type="password" name="current_password" class="form__info-password__input f-w3"
                                   value="{{ old('current_password') }}"/>
                            @if ($errors->has('current_password'))
                                <div class="error">{{ $errors->first('current_password') }}</div>
                            @endif
                            @if (session('error') != null)
                                <div class="error">{{ session('error') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row password_row align-items-center">
                        <div class="col-md-4 f-w6 form__info-password__label">新しいパスワード</div>
                        <div class="col-md-7">
                            <input type="password" name="new_password" class="form__info-password__input f-w3"
                                   value="{{ old('new_password') }}"/>
                            @if ($errors->has('new_password'))
                                <div class="error">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row password_row align-items-center">
                        <div class="col-md-4 f-w6 form__info-password__label">新しいパスワード(確認用)</div>
                        <div class="col-md-7">
                            <input type="password" name="confirm_password" class="form__info-password__input f-w3"
                                   value="{{ old('confirm_password') }}"/>
                            @if ($errors->has('confirm_password'))
                                <div class="error">{{ $errors->first('confirm_password') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <button class="btn-submit f-w6">変更する</button>
            </form>
            @if (session('success') != null)
                <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
            @endif
        </div>
    </div>
@endsection
