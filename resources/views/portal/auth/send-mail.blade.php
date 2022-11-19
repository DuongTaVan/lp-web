@extends('portal.layouts.guest')
@section('guest')
    @if (session('success') != null)
        <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
    @endif
    @if (session('error') != null)
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    <div id="send-mail" class="d-flex justify-content-center align-items-center">
        <div class="form">
            <form class="form-send-mail" action="{{route('portal.password-reset.send')}}" method="POST">
                @csrf
                <div class="form-send-mail__label f-w6 text-left">
                    パスワードの再発行
                </div>
                <div class="form-send-mail__description f-w3 text-left">
                    <div>登録済みのメールアドレスをご入力下さい。</div>
                    <div>ご入力いただいたメールアドレス宛にパスワード再発行の</div>
                    <div>お手続きに関するメールをお送りいたします。</div>
                </div>
                <div class="input-group form-send-mail__wrap">
                    <div class="form-send-mail__prepend">
                    <span class="form-send-mail__prepend__icon">
                        <img src="{{ asset('assets/img/icons/email.svg') }}" alt=""/>
                    </span>
                    </div>
                    <input class="form-send-mail__input f-w3 email" type="text" name="email" placeholder="メールアドレス"
                           value="{{ old('email') }}"/>
                    @if ($errors->has('email'))
                        <div class="mail-error-server">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="form-send-mail__submit d-flex justify-content-between align-items-center">
                    <button type="submit" class="form-send-mail__submit-btn f-w6">送信</button>
                    <a href="{{route('portal.login')}}" class="form-send-mail__submit-forgot f-w3">
                        ログイン画面に戻る
                    </a>
                </div>
            </form>
        </div>
        @if (session('successMail') !== null)
            <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-modal="true"
                 style="display: block;">
                <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <button type="button" id="btn-modal-close" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span class="d-flex aligns-item-center" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body body-box offset-md-1">
                            再設定用メールを送信しました。ご確認ください。
                        </div>
                        <div class="modal-footer border-top-0 justify-content-center mb-4 pt-0">
                            <button type="button" id="redirect-login" class="btn btn-primary btn-delete cancel"
                                    data-dismiss="modal">キャンセル
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function ($) {
            $('.email').blur(function () {
                let value =  $('.email').val();
                text = value.split(' ').join('');
                return $('.email').val(text)
            })
        });
    </script>
@endsection
