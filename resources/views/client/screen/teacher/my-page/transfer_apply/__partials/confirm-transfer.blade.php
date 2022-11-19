<!-- Modal confirm-transfer-->
<div class="modal fade" id="confirm-transfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="content-confirm-transfer">
                <div class="modal-header">
                    <div class="title">
                        振込内容確認
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>
                    <div class="modal-body">
                        <div class="transfer-money">
                            振込申請可能金額
                        </div>
                        <div class="money">
                            ¥{{number_format($totalPrice, 0, ',', ',') ?? ''}}
                        </div>
                    </div>
                    <div class="modal-body transfer-free">
                        <div class="transfer-money">
                            振込手数料
                        </div>
                        <div class="money">
                            ¥{{ \App\Enums\Constant::TRANSFER_FEE }}
                        </div>
                    </div>
                    <div class="modal-body transfer-free">
                        <div class="transfer-money">
                            振込金額
                        </div>
                        <div class="money">
                            ¥{{number_format($totalPrice - \App\Enums\Constant::TRANSFER_FEE, 0, ',', ',') ?? ''}}
                        </div>
                    </div>
                </div>

                <div class="button-send">
                    <button type="button" class="back" data-dismiss="modal">
                        戻る
                    </button>
                    <button id="apply-transfer-completed" type="button" class="button-ok" data-toggle="modal"
                            data-price="@if(!empty($data['totalPrice'])){{$data['totalPrice']}}@endif"
                            data-url="{{route('client.teacher.my-page.teacher-mypage.confirm-transfer')}}"
                            data-dismiss="modal">
                        申請する
                    </button>
                    <button style="display: none" id="apply-transfer-completed-success" type="button"
                            data-toggle="modal"
                            data-target="#transfer-completed"
                            data-dismiss="modal">
                        申請する
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

