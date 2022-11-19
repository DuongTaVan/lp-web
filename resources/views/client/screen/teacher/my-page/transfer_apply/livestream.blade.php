@extends('client.base.base')
@section('css')
    <style>
        .note-btn {
            font-style: normal;
            font-weight: normal;
            font-size: 10px;
        }

        .deposit img {
            margin-top: 2px;
        }

        .transfer-application img {
            margin-top: 10px;
        }

        .service-end img {
            margin-top: 10px;
        }

        .progress-transfer__text img {
            width: 90%;
        }

        .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .service-end::before {
            top: 30px;
            left: 98px;
            width: 120px;
            margin-left: 15px;
        }

        .progress-transfer__text--custom {
            position: absolute;
            top: -15px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream {
            justify-content: space-between;
        }

        .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer__text__default {
            margin: 0;
        }

        .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer {
            position: relative;
            padding-left: 15px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer__text {
            display: flex;
            justify-content: center;
            position: relative;
            align-items: center;
        }

        .progress-transfer__text__default--custom {
            font-size: 12px;
        }

        .col9 {
            flex: 0 0 72.222222%;
            max-width: 72.222222%;
        }

        .col3 {
            /*flex: 0 0 26.222222%;*/
            max-width: 47.22222%;
        }

        .main-mypage-teacher__header {
            margin-bottom: 0px;
        }

        ::placeholder {
            color: #666666 !important;
        }

        .content-confirm-transfer .modal-body .money {
            width: unset;
            overflow: unset;
            white-space: unset;
            text-overflow: unset;
        }

        #updateBankAccountSubmit .title {
            font-size: 14px;
        }

        #updateBankAccountSubmit .row-input {
            margin-bottom: 15px;
        }

        #updateBankAccountSubmit .row-input:nth-of-type(1) {
            margin-top: 20px;
        }

        #updateBankAccountSubmit .row-input:nth-of-type(4) {
            margin-top: 20px;
        }

        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td:nth-child(1) {
            padding: 7px 12px;
        }

        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td {
            padding: 7px 12px;
        }

        .total-amount-custom {
            padding-left: 0;
            margin-left: auto;
        }

        .sidebar-right__navbar-order-list__cancel {
            padding: 0 4.5px;
        }

        .info-input-select *:focus {
            outline: none;
            border-color: #ced4da;
            box-shadow: none;
        }

        .info-input-select-tag {
            -webkit-appearance: none;
            -moz-appearance: none;
            background: transparent;
            background: url({{ url('/assets/img/clients/auth/arow-down.svg') }}) no-repeat 125px #fff !important;
        }

        #dropdown .selected {
            background: rgba(70, 203, 144, 0.3);
            font-style: normal;
            font-weight: normal;
            font-size: 14px;
            color: #46CB90;
        }

        .color-red > td {
            color: #EE3D48 !important;
        }

        .color-red > td:first-child {
            color: unset !important;
        }

        #confirm-transfer .modal-body {
            padding: 25px 0 0 0;
        }

        #confirm-transfer .transfer-free {
            padding: 10px 0 0 0;
        }

        #confirm-transfer .transfer-money {
            min-width: 110px;
        }

        #confirm-transfer .modal-body .transfer-money {
            margin-left: 74px;
            text-align: right;
        }

        .content-confirm-transfer .modal-body .money {
            margin-left: 40px;
        }

        #confirm-transfer .transfer-free .transfer-money:last-child, #confirm-transfer .transfer-free .money:last-child {
            color: #EE3D48;
        }

        #confirm-transfer .transfer-free:last-child {
            padding: 10px 0 25px 0;
            color: #EE3D48;
        }

        .color-red {
            color: #EE3D48 !important;
        }

        .remove-event {
            pointer-events: none;
            background-color: #9B9F9E !important;
        }

        .list-form-custom {
            display: flex;
            width: 50%;
        }

        .main-mypage-teacher__content .teacher-sidebar-right .change-account-setting .list-form-custom .info-input-select {
            width: 50%;
        }

        @media only screen and (max-width: 1023px) {
            .row {
                display: unset;
                -ms-flex-wrap: unset;
                flex-wrap: unset;
                margin-right: unset;
                margin-left: unset;
            }

            .main-mypage-teacher {
                margin-bottom: unset;
            }


            .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
                position: unset;
                width: unset;
                padding-right: unset;
                padding-left: unset;
            }
        }


        @media only screen and (max-width: 414px) {
            .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer {
                text-align: unset;
            }

            .arrow-sp {
                margin-left: 80px;
            }

            .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer {
                padding-left: 0px;
            }

            .progress-transfer__text img {
                width: 10%;
                transform: rotate(90deg);
            }

            .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .service-end::before {
                width: 100px;
                left: 15px;
                top: unset;
            }

            .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer__text {
                display: block;
            }

            .col-custom {
                padding-left: 15px;
                padding-right: 15px;
            }

            .main-mypage-teacher__header .text-left, .main-mypage-teacher__header .text-right {
                padding: 10px 0;
            }

            .main-mypage-teacher__content .teacher-sidebar-right .progress-livestream .progress-transfer__text {
                justify-content: unset !important;
            }

            .progress-transfer__text--custom {
                top: unset;
            }

            .main-mypage-teacher .teacher-sidebar-right .progress-livestream .progress-transfer__text {
                /*margin-left: unset;*/
            }

            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(1) {
                min-width: 135px;
            }

            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(1) {
                min-width: 135px;
            }

            .main-mypage-teacher__content .teacher-sidebar-right .change-account-setting .row-input-custom {
                display: block;
            }

            .list-form-custom {
                display: flex;
                width: unset;
            }

            .main-mypage-teacher .main-mypage-teacher__content .teacher-sidebar-right .change-account-setting .row-input-custom .info-input-select {
                width: 40%;
                margin-right: 10px;
            }

            .note-option-custom {
                margin-left: 6rem !important;
            }

            .main-mypage-teacher__content .teacher-sidebar-right .change-account-setting .number-account-custom {
                display: block;
            }
            .ml-3-custom{
                margin-left: 0.5rem !important;
            }

        }

        .note-input {
            font-size: 10px;
            font-weight: bold;
        }

        .bank-name-all {
            position: relative;
        }

        .branch-name-all {
            position: relative;
        }

        .bank-name-all img {
            position: absolute;
            top: 13px;
            right: 5px;
        }

        .branch-name-all img {
            position: absolute;
            top: 13px;
            right: 5px;
        }

        .select__options {
            display: none;
            transform: scaleY(1);
            position: absolute;
            z-index: 4;
            width: 100%;
            transition: ease 0.3s;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            -webkit-transform-origin: top;
            transform-origin: top;
            border: 1px solid #DDDDDD;
            max-height: 200px;
            overflow-x: hidden;
            overflow-y: auto;
            user-select: none;
        }

        .select__options .select__item {
            height: 40px;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            padding: 0 15px;
            font-size: 14px;
            line-height: 21px;
            user-select: none;
        }

        .select__options .select__item:hover {
            background-color: rgba(70, 203, 144, 0.4);
            color: #46CB90;
            border-radius: 5px;
            border: 1px solid #DDDDDD;
        }

        .active .select__options {
            display: block;
        }

        .active .icon-dropdown-type {
            transition: 0.4s;
            transform: rotate(180deg);
        }

        .create-course-block .course__content .wrap-item__value__select .select.active .select__options {
            opacity: 1;
            transform: scaleY(1);
        }

        .remove-event-button {
            pointer-events: none;
            background: #9B9F9E !important;
            border: 1px solid #9B9F9E !important;
        }

    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 col-custom-application content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="sidebar-right__navbar-order-list tab-profit-livestream">
                                @include('client.common.sub-header-teacher-mypage')
                                @include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $data['dataTransferApplyLiveStream']])
                            </div>
                            <div class="progress-livestream">
                                <div class="service-end">
                                    <img src="{{asset('assets/img/teacher-page/icon/service-end.svg')}}" alt="">
                                    <div class="title-progress f-w6">
                                        @lang('labels.transfer-apply.livestream.service_ends')
                                    </div>
                                </div>
                                <div class="transfer-application">
                                    <img src="{{asset('assets/img/teacher-page/icon/transfer-apply.svg')}}"
                                         alt="">
                                    <div class="title-progress f-w6">
                                        @lang('labels.transfer-apply.livestream.transfer_application')
                                    </div>
                                </div>
                                <div class="progress-transfer">
                                    <div class="progress-transfer__text progress-transfer__text--custom">
                                        <div class="progress-transfer__text__default" style="font-weight: bold">
                                            【各期間中１回のみ申請可能】
                                        </div>
                                    </div>

                                    <div class="progress-transfer__text">
                                        <div>
                                            <div>
                                                １日−１５日（２３：５９）まで
                                            </div>
                                            <div>
                                                １６日−月末（２３：５９）まで
                                            </div>
                                        </div>
                                        <div class="arrow-sp">
                                            <img src="{{asset('assets/img/common/arrow.svg')}}" alt="">
                                        </div>
                                        <div
                                                class="progress-transfer__text__default progress-transfer__text__default--custom">
                                            <div>締日の翌日から<span style="color: #ee3d48;">３営業日まで</span>に振込</div>
                                            <div style="display: flex">※締日は<span style="color: #ee3d48;">15日と月末</span>です
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-transfer__text transfer-border">

                                    </div>
                                    <div class="help-text">
                                        @lang('labels.transfer-apply.livestream.help_text_progress')
                                    </div>
                                </div>
                                <div class="deposit">
                                    <img src="{{asset('assets/img/teacher-page/icon/deposit.svg')}}" alt="">
                                    <div class="title-progress f-w6">
                                        @lang('labels.transfer-apply.livestream.deposit')
                                    </div>
                                </div>
                            </div>
                            <div class="manage-sale">
                                {{$data['dataTransferApplyLiveStream']['year']}}年
                            </div>
                            <div class="teacher-sidebar-right__table tranfer-apply-livestream">
                                <div class="d-flex direction-sp">
                                    <div class="col9 tranfer-apply-livestream__table">
                                        <table>
                                            <tr class="teacher-sidebar-right__table__header">
                                                <th>{{ __('labels.transfer-apply.livestream.last_3_months') }}</th>
                                                <th>振込申請</th>
                                                <th>振込金額</th>
                                                <th>{{ __('labels.transfer-apply.livestream.seller_profit') }}</th>
                                                <th>{{ __('labels.transfer-apply.livestream.consumption_tax') }}</th>
                                                <th>{{ __('labels.transfer-apply.livestream.balance') }}</th>
                                            </tr>
                                            @if(!empty($data['dataTransferApplyLiveStream']['transferApply']) && $data['dataTransferApplyLiveStream']['transferApply'] != [])
                                                @foreach($data['dataTransferApplyLiveStream']['transferApply'] as $transferApply)
                                                    <tr class="teacher-sidebar-right__table__data">
                                                        <td class="{{$transferApply['monthColor']}}">
                                                            {{ Carbon\Carbon::parse($transferApply['month'])->format('m') }}
                                                            月
                                                        </td>
                                                        <td class="{{$transferApply['payoutColor']}}">
                                                            {{$transferApply['numberOfTransfers']}}
                                                        </td>
                                                        <td class="{{$transferApply['payoutColor']}}">
                                                            ¥{{number_format($transferApply['totalTransfer'], 0, ',', ',')}}</td>
                                                        <td class="{{$transferApply['balanceColor']}}">
                                                            ¥{{number_format($transferApply['profit'], 0, ',', ',')}}</td>
                                                        <td class="{{$transferApply['balanceColor']}}">
                                                            ¥{{number_format($transferApply['saleTaxs'], 0, ',', ',')}}</td>
                                                        <td class="{{$transferApply['balanceColor']}}">
                                                            ¥{{number_format($transferApply['balance'], 0, ',', ',')}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="col3 total-amount-custom">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="panel-title f-w6">
                                                    @lang('labels.transfer-apply.livestream.money_transfer')
                                                </div>
                                            </div>
                                            <div class="panel-content">
                                                @if(!empty($data['totalPrice']))
                                                    <div class="total-price">
                                                        ¥{{ number_format($data['totalPrice'], 0, ',', ',') }}</div>
                                                @else
                                                    <div class="total-price">¥0</div>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$data['dataTransferApplyLiveStream']['isWithdrawMoney'] || !$data['canTransferWithMinDay'])
                                            <button disabled type="button"
                                                    class="btn button-apply"
                                                    data-target="#confirm-transfer">
                                                @lang('labels.transfer-apply.livestream.button_apply_transfer')
                                            </button>
                                        @else
                                            <button id="button-apply-check-price" type="button"
                                                    class="btn button-apply"
                                                    data-toggle="modal"
                                                    data-target="#confirm-transfer"
                                                    data-hidden="@if(!empty($data['totalPrice'])){{$data['totalPrice']}} @else 0 @endif">
                                                @lang('labels.transfer-apply.livestream.button_apply_transfer')
                                            </button>
                                        @endif
                                        @if (!$data['canTransferWithMinDay'])
                                            <div class="note-btn">※初回サービスの決済後の７日間は申請できません。</div>
                                        @endif

                                    </div>
                                </div>
                                <div class="footable-text footable-text-SP">
                                    <div class="help-text">
                                        @lang('labels.transfer-apply.livestream.help_text_1')
                                    </div>
                                    <div class="help-text">
                                        @lang('labels.transfer-apply.livestream.help_text_2')
                                    </div>

                                    <div class="help-text high-light">
                                        @lang('labels.transfer-apply.livestream.help_text_3')
                                    </div>
                                </div>
                            </div>
                            @if(isset($data['cardInfo']))
                                <div class="account-setting">
                                    <div class="manage-sale">
                                        振込口座設定
                                    </div>
                                    <div class="button-change button-change-PC">
                                        <button type="button"
                                                class="btn button-apply button-fix-info">
                                            @lang('labels.transfer-apply.livestream.change_account_information')
                                        </button>
                                    </div>
                                </div>
                                <div class="change-account-setting change-account-setting__all">
                                    <div class="change-account-setting__loading">
                                        <div class="lds-ellipsis" style="display: none;">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>

                                    <form action="" id="updateBankAccountSubmit">
                                        @csrf
                                        <div class="row-input">
                                            <div
                                                    class="title f-w6">@lang('labels.transfer-apply.livestream.bank_name')</div>
                                            <div class="info-input info-bank-name-all input-payment">
                                                <div class="bank-name-all">
                                                    <input autocomplete="off" type="text" id="bank_name"
                                                           name="bank_name"
                                                           data-convert="no-auto"
                                                           data-search="bank"
                                                           class="form-control"
                                                           @if(!empty($data['cardInfo']))data-value="{{$data['cardInfo']->bank_name}}"
                                                           @endif @if(!empty($data['cardInfo']))value="{{$data['cardInfo']->bank_name}}"
                                                           @endif disabled
                                                           placeholder="○○〇銀行"
                                                    >
                                                    <img src="{{asset('assets/img/icons/dropdown-arrow.svg')}}"
                                                         alt="" class="icon-dropdown-type">
                                                </div>
                                                <div class="select__options list__bank">
                                                    @if($banks->count()>0)
                                                        @foreach($banks as $bank)
                                                            <div
                                                                    class="select__item f-w3 select-parent-item category-select bank-select">
                                                                {{$bank->name}}
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>

                                                <div class="bank_name-show-error"
                                                     style="color: red; font-size: 10px; margin-top: 5px; margin-left: 10px"></div>
                                            </div>
                                        </div>
                                        <div class="row-input">
                                            <div class="title f-w6">支店名</div>
                                            <div class="info-input info-branch-name-all input-payment">
                                                <div class="branch-name-all">
                                                    <input type="text" id="branch_name" name="branch_name"
                                                           autocomplete="off"
                                                           data-convert="no-auto"
                                                           data-search="branch"
                                                           class="form-control"
                                                           @if(!empty($data['cardInfo']))data-value="{{$data['cardInfo']->branch_name}}"
                                                           @endif  @if(!empty($data['cardInfo']))value="{{$data['cardInfo']->branch_name}}"
                                                           @endif disabled
                                                           placeholder="支店名 or 支店番号">
                                                    <img src="{{asset('assets/img/icons/dropdown-arrow.svg')}}"
                                                         alt="" class="icon-dropdown-type">
                                                </div>

                                                <div class="select__options list__branch">

                                                </div>

                                                <div class="branch_name-show-error"
                                                     style="color: red; font-size: 10px; margin-top: 5px; margin-left: 10px"></div>
                                            </div>
                                        </div>
                                        <div class="row-input row-input-custom">
                                            <div class="list-form-custom">
                                                <div class="title f-w6">@lang('labels.transfer-apply.livestream.type')</div>
                                                <input class="account_type-input" type="hidden" name="account_type"
                                                       value="1">
                                                <div class="info-input-select form-option" disabled>
                                            <span class="title-option account-type" data-accountType="1"
                                                  data-current="1">普通</span>
                                                </div>
                                            </div>
                                            <span class="note-input ml-3 note-option-custom">※ゆうちょ銀行の場合は「通常貯金」のみ登録可能</span>
                                        </div>
                                        <div class="row-input">
                                            <div
                                                    class="title f-w6">@lang('labels.transfer-apply.livestream.account_number')</div>
                                            <div class="info-input account_number"
                                                 @if(!empty($data['cardInfo'])) data-number="{{$data['cardInfo']->account_number}}" @endif>
                                                <input id="account_number" type="text"
                                                       class="form-control"
                                                       name="account_number"
                                                       data-convert="half-width" data-change="true" data-min-length="7"
                                                       @if(!empty($data['cardInfo'])) value="{{$data['cardInfo']->account_number}}"
                                                       @endif @if(!empty($data['cardInfo'])) data-value="{{$data['cardInfo']->account_number}}"
                                                       @endif disabled
                                                       placeholder="1234567"
                                                >
                                                <div class="row-input mt-2 number-account-custom">
                                                    <div class="note-input ml-2">※半角数字</div>
                                                    <div class="note-input ml-3 ml-3-custom">７桁未満の場合は頭に「０」を付けて入力してください。</div>
                                                </div>
                                                <div class="account_number-show-error"
                                                     style="color: red; font-size: 10px; margin-top: 5px;margin-left: 10px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-input">
                                            <div
                                                    class="title f-w6">@lang('labels.transfer-apply.livestream.account_holder')</div>
                                            <div class="info-input account_name"
                                                 @if(!empty($data['cardInfo'])) data-name="{{$data['cardInfo']->account_name}}" @endif>
                                                <input
                                                        placeholder="ヤマダ　タロウ"
                                                        id="account_name" type="text"
                                                        class="form-control"
                                                        name="account_name"
                                                        data-convert="full-width"
                                                        data-required="space" data-change="true"
                                                        style="text-transform: capitalize;"
                                                        @if(!empty($data['cardInfo']))value="{{$data['cardInfo']->account_name}}"
                                                        @endif @if(!empty($data['cardInfo']))data-value="{{$data['cardInfo']->account_name}}"
                                                        @endif disabled>
                                                <span class="note-input ml-2">※全角カタカナ</span>
                                                <div class="account_name-show-error error ml-2"></div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="button-submit button-submit-hidden">
                                    <button type="button" class="btn button-apply button-cancel">
                                        {{ __('labels.transfer-apply.change-bank-info.button_1') }}
                                    </button>
                                    <button type="button" class="btn button-apply button-ok button-confirm"
                                            data-url="@if(!empty($data['cardInfo'])){{route('client.teacher.my-page.transfer-applyupdate-card', $data['cardInfo']->id)}}@endif">
                                        {{ __('labels.transfer-apply.change-bank-info.button_2') }}
                                    </button>
                                </div>
                                <div class="account-setting account-setting-SP">
                                    <div class="button-change button-change-SP">
                                        <button type="button"
                                                class="btn button-apply button-fix-info">
                                            {{ __('labels.transfer-apply.livestream.change_account_information') }}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($data['totalPrice']))
        @include('client.screen.teacher.my-page.transfer_apply.__partials.confirm-transfer', ['totalPrice'=>$data['totalPrice']])
        @include('client.screen.teacher.my-page.transfer_apply.__partials.confirm-transfer-completed',  ['totalPrice'=>$data['totalPrice']])
    @endif
@endsection
@section('script')
    <script src="{{ mix('js/clients/teachers/teacher-transfer-apply.js') }}"></script>
    <script src="{{ mix('js/auto-bank.js') }}"></script>
@endsection
