@extends('portal.layouts.main')
@section('styles')
    <style>
        .date-time-course {
            position: relative;
            border: 0;
            height: 30px !important;
        }

        .date-time-course > img {
            position: absolute;
            right: 11px;
            cursor: pointer;
        }

        .text-white-space {
            white-space: nowrap;
        }

        #search-form {
            padding-left: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="withdrawal-list">
        <div class="text-left withdrawal-list__title">
            <p class="f-w6">振込申請</p>
        </div>
        <div class="withdrawal-list__content">
            <form id="search-form" method="GET" action="{{ url('portal/transfer-histories') }}">
                <div class="d-flex flex-wrap list-option--top">
                    <div>
                        <p>申請日時（開始）</p>
                        <div class="jquery-datetime-picker datetimepicker date-time-course">
                            <input type="text" data-input class="auto-trim start-datetime"
                                   value="{{ $searchParam['start_created_at'] ?? null }}" name="start_created_at"
                                   autocomplete="off" data-format="Y-m-d"
                                   data-max="{{ $searchParam['end_created_at'] ?? null}}">
                            <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt="" data-toggle>
                        </div>
                    </div>
                    <div>
                        <p>申請日時（終了)</p>
                        <div class="jquery-datetime-picker datetimepicker date-time-course">
                            <input type="text" data-input class="auto-trim end-datetime"
                                   value="{{ $searchParam['end_created_at'] ?? null }}" name="end_created_at"
                                   autocomplete="off" data-format="Y-m-d"
                                   data-min="{{ $searchParam['start_created_at'] ?? null}}">
                            <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt="" data-toggle>
                        </div>
                    </div>
                    <div>
                        <p>ステータス</p>
                        <select class="form-select form-select-lg custom-select status" name="status"
                                aria-label=".form-select-lg example">
                            <option value=""></option>
                            {{--                            @foreach(\App\Enums\DBConstant::WITHDRAWAL_STATUS_PORTAL as $key => $value)--}}
                            <option
                                value="0" {{ ((int)request()->get('status') === 0 && request()->get('status') !== null) ? 'selected' : '' }}>
                                承認待ち
                            </option>
                            <option
                                value="1" {{ ((int)request()->get('status') !== 0 && request()->get('status') !== null) ? 'selected' : '' }}>
                                承認済み
                            </option>
                            {{--                            @endforeach--}}
                        </select>
                    </div>
                </div>
                <div class="d-flex list-option--bottom flex-wrap">
                    <div>
                        <p>ユーザーID</p>
                        <input type="text" value="{{ $searchParam['userId'] ?? null }}" name="userId"
                               class="user_id"/>
                    </div>
                    <div>
                        <p>ニックネーム</p>
                        <input type="text" value="{{ $searchParam['user_nickname'] ?? null }}" name="user_nickname"
                               class="nickname"/>
                    </div>
                    <div>
                        <p>入金状況</p>
                        <select class="form-select form-select-lg custom-select status" name="status_transfer"
                                aria-label=".form-select-lg example">
                            <option value=""></option>
                            @foreach(\App\Enums\DBConstant::TRANSFER_STATUS_PORTAL as $key => $value)
                                <option
                                    value="{{ $key }}" {{ request()->get('status_transfer') !== null ? ($searchParam['status_transfer'] === (string)$key ? 'selected' : '') : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="f-w3">
                        <button id="search-button" class="btn-search btn-primary">検索</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table-content">
                <div class="d-flex justify-content-between align-items-center record">
                    <div>
                        <select
                            id="select-per-page"
                            per-page="{{$data['withdrawalRequests']->perPage()}}"
                            current-page="{{$data['withdrawalRequests']->currentPage()}}"
                            last-page="{{$data['withdrawalRequests']->lastPage()}}"
                            total-record="{{$data['withdrawalRequests']->total()}}"
                            class="form-select form-select-lg custom-select record__select"
                            aria-label=".form-select-lg example"
                        >
                            @foreach(\App\Enums\Constant::ITEM_PER_PAGE as $key => $value)
                                <option value="{{ $value }}"
                                        class="f-w3" {{ array_key_exists('per_page', $searchParam) && $searchParam['per_page'] == $key ? 'selected' : '' }} >{{ $value }}</option>
                            @endforeach
                        </select>
                        <span class="f-w3">件表示</span>
                    </div>
                    <button type="button" class="transfer-error {{ $data['errorTransfer'] ? '' : 'd-none' }}"
                            style="display: none">残高エラー
                    </button>
                </div>
                <div class="table">
                    @include('portal.modules.withdrawal.withdrawalTable')
                </div>
            </div>
            @include('portal.components.table-footer', ['data' => $data['withdrawalRequests']])
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div aria-hidden="true" class="close btn-close" data-toggle="modal" data-target="#exampleModal"
                     style="opacity: 1">
                    <img src="{{ asset('assets/img/portal/icons/exit-icon.svg') }}">
                </div>
                <div class="modal-body" style="padding-top: 11px !important;">
                    <div class="d-flex content-withdraw">
                        <div class="left">
                            <div class="rule-withdraw">1日-15日(23:59)まで→<span>25日振込</span></div>
                            <div class="rule-withdraw">16日-月末(23:59)まで→<span>翌月10日振込</span></div>
                            <div class="sub-div"></div>
                            <div class="note-text rule-withdraw">
                                ※土日・祝日の場合は翌営業日になります
                            </div>
                        </div>
                        <div class="right text-center">
                            <img src="{{ asset("assets/img/teacher-page/icon/deposit.svg") }}" alt="" width="78"
                                 height="95">
                            <div>登録口座へ入金</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tryTransferModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-withdrawal" role="document">
            <div class="modal-content modal-content-withdrawal">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="padding: 13px;">
                        <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center box_title">
                    <label>Lappiアカウント口座の残高不足で<br/>振込エラーが発生しました。</label>
                    <div>
                        <div class="row-content">
                            <span>・エラー発生日</span><span>:</span>
                            <span class="failed_at_date"></span>
                        </div>
                        <div class="row-content">
                            <span>・エラー発生時</span><span>:</span>
                            <span class="failed_at_time"></span>
                        </div>
                        <div class="row-content">
                            <span>・振込合計金額</span><span>:</span>
                            <span class="sum"></span>
                        </div>
                        <div class="row-content">
                            <span>・不足金額</span><span>:</span>
                            <span class="missing_amount"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="submit" class="btn button" data-dismiss="modal"
                            data-toggle="modal" data-target="#tryTransferConfirmModal">再振込依頼
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tryTransferConfirmModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-withdrawal" role="document">
            <div class="modal-content modal-content-withdrawal">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="padding: 13px;">
                        <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center box_title">
                    <label>再振込依頼をしてもよろしいでしょうか？</label>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <form action="{{ route('portal.transfer.try-again') }}" method="POST" class="modal-form-footer">
                        @csrf
                        <input type="hidden" name="failed_at" value="">
                        <input type="hidden" name="sum" value="">
                        <input type="hidden" name="missing_amount" value="">
                        <button type="submit" class="btn button">はい</button>
                    </form>
                    <button type="button" class="btn button button__cancel" data-dismiss="modal">いいえ</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .modal-body {
        padding: 18px 0 !important;
    }

    .content-withdraw {
        margin: auto;
        align-items: center;
        justify-content: center;
    }

    .sub-div {
        margin-top: 12px;
        margin-bottom: 12px;
        border-top: 3px dashed #2A3242;
    }

    .left {
        margin-right: 36px;
    }

    .modal {
        background-color: unset;
    }

    .rule-withdraw {
        font-size: 14px;
        color: #2A3242;
    }

    .rule-withdraw span {
        color: #F55050;
    }

    .note-text {
        color: #F55050;
    }

    .modal-dialog {
        min-width: 544px !important;
    }

    .modal-content {
        position: relative;
    }

    .btn-close {
        position: absolute;
        right: 15px;
        top: 10px;
        z-index: 999;
    }

    .right div {
        color: #2A3242;
        font-size: 14px;
        font-weight: 600;
        margin-top: 11px;
    }

    .transfer-error {
        width: 100px;
        height: 30px;
        background: #F55050;
        color: white;
    }

    #tryTransferModal .box_title label {
        text-align: center;
        letter-spacing: 0;
        color: #333333;
        opacity: 1;
        font-weight: bold;
    }

    #tryTransferModal .box_title > div {
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    #tryTransferModal button[type=submit] {
        top: 482px;
        left: 593px;
        width: 180px;
        height: 48px;
        background: #1874C4;
        color: white;
    }

    .row-content {
        text-align: start;
    }

    .row-content > span:first-child {
        width: 120px;
        display: inline-block;
        text-align: start;
    }

    .row-content > span:nth-child(2) {
        width: 20px;
        display: inline-block;
    }

    .row-content > span:nth-child(3) {
        color: #F55050;
    }

    #tryTransferConfirmModal .button {
        top: 373px;
        left: 523px;
        width: 150px;
        height: 50px;
        background: #FFFFFF;
        border: 1px solid #CCCCCC;
    }

    #tryTransferConfirmModal .button__cancel {
        top: 373px;
        left: 693px;
        width: 150px;
        height: 50px;
        background: #1874C4;
        border: 1px solid #CCCCCC;
        color: white;
    }
</style>
@section('scripts')
    <script>
        $('#exampleModal').on('shown.bs.modal', function (e) {
            $(".modal-backdrop").attr('style', 'opacity: 0 !important');
        })

        @if (session('message') != null)
        $(document).ready(function () {
            $('#exampleModal').modal('show');
            $('#exampleModal').on('hidden.bs.modal', function (e) {
                $(".modal-backdrop").css("opacity", "0.5");
            });
        });
        @endif
        @if (session('toast') != null)
        $(document).ready(function () {
            toastr.success('{{ session('toast') }}');
        });
        @endif
        $(document).ready(function () {
            $('.btn_withdrawal').on('click', function () {
                $('.transfer-id').val($(this).data('id'));
                $('#transfer-dialog').modal('show');
            });
            $('body').on('click', '.btn_sendmail', function () {
                $('.sendmail-id').val($(this).data('id'));
                $('#sendmail-dialog').modal('show');
            });

            let btnMarginRight = 0;
            $('.table th:gt(-3)').each(function () {
                btnMarginRight += btnMarginRight ? $(this).outerWidth() : ($(this).outerWidth() - 100) / 2;
            })
            $('.transfer-error').attr('style', `margin-right: ${btnMarginRight}`);
            $('.transfer-error').on('click', function () {
                $.ajax({
                    beforeSend: function () {
                        $('#loading-overlay').show();
                    },
                    type: 'GET',
                    url: '/portal/transfer-error',
                }).then((response) => {
                    $('#loading-overlay').hide();
                    if (response.success && response.data) {
                        $('.failed_at_date').html(response.data.failed_at_date);
                        $('.failed_at_time').html(response.data.failed_at_time);
                        $('.sum').html(response.data.sum + ' 円');
                        $('.missing_amount').html(response.data.missing_amount + ' 円');
                        $('input[name=failed_at]').val(response.data.failed_at_date);
                        $('input[name=sum]').val(response.data.sum);
                        $('input[name=missing_amount]').val(response.data.missing_amount);
                        $('#tryTransferModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
