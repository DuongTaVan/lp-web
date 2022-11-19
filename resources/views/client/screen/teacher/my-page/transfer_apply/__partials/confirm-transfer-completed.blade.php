<!-- Modal confirm-transfer-completed-->
<div class="modal fade" id="transfer-completed" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="content-confirm-transfer">
                <div class="transfer-completed">
                    <div class="image">
                        <img src="{{asset('assets/img/teacher-page/icon/checked-transfer.svg')}}" alt="">
                    </div>
                    <div class="text-complete">
                        振込申請完了
                    </div>
                </div>
                <div class="modal-body">
                    <div class="transfer-money">
                        受領金額
                    </div>
                    <div class="money">
                        ¥{{number_format($totalPrice - \App\Enums\Constant::TRANSFER_FEE, 0, ',', ',') ?? ''}}
                    </div>
                </div>
                <div class="button-send">
                    <button type="button" class="button-ok button-reload" data-dismiss="modal">
                        閉じる
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
