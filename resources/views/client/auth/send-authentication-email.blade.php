@extends('client.base.base')
@section('content')
    <!-- CONTENT -->
    <div class="email-auth-wrap">
        <div class="email-auth text-center">
            <div class="email-auth__content">
                <h2 class="f-w6">{{ $email ?? null }}</h2>
                <p class="f-w3">上記アドレスに本人確認メールを送信しました。</p>
                <p class="f-w3 p--mobile">メールに記載されている認証リンクをクリックして<br class="br-mobile">頂き、登録を完了してください。</p>
            </div>
            <div class="email-auth__action">
                <div>※まだ登録は完了しておりません</div>
                <button data-toggle="modal" class="f-w6" data-target="#re-send-email">確認メールが届かない方はこちら</button>
            </div>

            <input type="hidden" value="{{ $email ?? null }}" id="email">
            <input type="hidden" value="{{ $userType ?? null }}" id="user-type">
            <input type="hidden" value="{{ $loginType ?? null }}" id="login-type">
            <input type="hidden" value="{{ $changeEmail ?? null }}" id="change-email">

            <div class="modal fade" id="re-send-email" tabindex="-1" aria-labelledby="re-send-email"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content re-send-email">
                        <div class="text-center re-send-email__header d-flex align-items-center justify-content-center">
                            <h5 class="f-w6" id="re-send-email__Label">下記のアドレスに本人確認メールを再送信しますか？</h5>
                            {{-- <button type="button" class="close re-send-email__header__btn" data-dismiss="modal"
                                    aria-label="Close">
                                <img src="{{ url('/assets/img/clients/auth/close-modal.svg') }}"/>
                            </button> --}}
                        </div>
                        <div class="modal-body text-center re-send-email__body">
                            <p class="re-send-email__body__email f-w3">{{ $email ?? null }}</p>
                            <div class="re-send-email__body__option d-flex justify-content-between">
                                <button class="f-w6 re-send-email__body__option-btn re-send-email__body__option-btn--cancel"
                                        data-dismiss="modal" aria-label="Close"
                                >
                                    キャンセル
                                </button>
                                <button class="f-w6 re-send-email__body__option-btn re-send-email__body__option-btn--send"
                                        data-dismiss="modal" aria-label="Close"
                                        id="resend-email"
                                >
                                    送信する
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('js/clients/modules/register.js') }}"></script>
@endsection
