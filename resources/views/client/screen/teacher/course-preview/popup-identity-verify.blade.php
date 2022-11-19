@php
    $user = auth()->guard('client')->user();
@endphp
<style>
    #popup-identity-verify__Label {
        font-size: 16px;
        line-height: 24px;
        color: #2A3242;
    }
    .popup-identity-verify__body__option {
        font-size: 14px;
        line-height: 24px;
    }
    .modal-dialog {
        margin-top: 200px;
        max-width: 400px;
    }
    .modal-content {
        padding: 30px;
    }
    .modal-body {
        padding: 0;
    }
    .close-modal {
        background-color: #46CB90;
        border-radius: 5px;
        color: #FFFFFF;
        font-size: 14px;
        line-height: 21px;
        padding: 10px 54px;
        border: none;
        outline: none;
        margin-top: 27px;
    }
    @media (max-width: 526px) {
        .modal-dialog {
            margin-top: 200px;
        }
    }
</style>
<div class="modal fade" id="popup-identity-verify" tabindex="-1" aria-labelledby="popup-identity-verify"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content popup-identity-verify">
            {{-- <div class="text-center popup-identity-verify__header d-flex align-items-center justify-content-center">
                <h5 class="f-w6" id="popup-identity-verify__Label">本人確認状況について</h5>
            </div> --}}
            <div class="modal-body text-center popup-identity-verify__body">
                <div class="popup-identity-verify__body__option f-w6">
                    @if ($user->identity_verification_status == \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED)
                    本人確認が承認されていません。
                    @elseif ($user->identity_verification_status == \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED)
                    本人確認が否認されています。
                    @else
                    本人確認が承認されていません。
                    @endif
                </div>
                <button class="f-w6 close-modal" data-dismiss="modal" aria-label="Close">閉じる</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let showPopup = '<?php echo $notShow ?? 1;?>';
        if (parseInt(showPopup) === 1) {
            showModalIdentity();
        }
        function showModalIdentity() {
            let checkIdentityVerify = '<?php echo \Auth::guard('client')->check() ? \Auth::guard('client')->user()->identity_verification_status : '';?>'
            if (checkIdentityVerify != 3) {
                $('#popup-identity-verify').modal('show');
            }
        }
    })
</script>
