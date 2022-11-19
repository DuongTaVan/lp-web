@extends('client.base.base')
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="container">
                            <div class="row">
                                <div class="teacher-sidebar-right service-list-draft">
                                    <div class="sidebar-right__navbar-order-list tab-profit-livestream">
                                        <div class="sidebar-right__navbar-order-list__flex">
                                            <div class="sidebar-right__navbar-order-list__order">
                                                @lang('labels.profit-live-stream.sales_management')
                                            </div>
                                            <div class="sidebar-right__navbar-order-list__cancel active">
                                                @lang('labels.profit-live-stream.transfer_application')
                                            </div>
                                        </div>
                                        <div class="sidebar-right__navbar-order-list__year">
                                            <div class="sidebar-right__navbar-order-list__year__left"><img
                                                        src="{{asset('assets/img/student/my-page/icon/left.svg')}}" alt=""></div>
                                            <div class="sidebar-right__navbar-order-list__year__number">5月/2021年</div>
                                            <div class="sidebar-right__navbar-order-list__year__right"><img
                                                        src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt=""></div>
                                        </div>
                                    </div>
                                    <div class="progress-livestream">
                                        <div class="service-end">
                                            <img src="{{asset('assets/img/teacher-page/icon/service-end.svg')}}" alt="">
                                            <div class="title-progress">
                                                @lang('labels.transfer-apply.livestream.service_ends')
                                            </div>
                                        </div>
                                        <div class="transfer-application">
                                            <img src="{{asset('assets/img/teacher-page/icon/transfer-apply.svg')}}" alt="">
                                            <div class="title-progress">
                                                @lang('labels.transfer-apply.livestream.transfer_application')
                                            </div>
                                        </div>
                                        <div class="progress-transfer">
                                            <div class="progress-transfer__text">
                                                <div class="progress-transfer__text__default">
                                                    1日-15日(23:59)まで→
                                                </div>
                                                <div class="progress-transfer__text__transfer">
                                                    20日振込
                                                </div>
                                            </div>
                                            <div class="progress-transfer__text transfer-border">
                                                <div class="progress-transfer__text__default">
                                                    1日-15日(23:59)まで→
                                                </div>
                                                <div class="progress-transfer__text__transfer">
                                                    20日振込
                                                </div>
                                            </div>
                                            <div class="help-text">
                                                @lang('labels.transfer-apply.livestream.help_text_progress')
                                            </div>
                                        </div>
                                        <div class="deposit">
                                            <img src="{{asset('assets/img/teacher-page/icon/deposit.svg')}}" alt="">
                                            <div class="title-progress">
                                                @lang('labels.transfer-apply.livestream.deposit')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="manage-sale">
                                        2021年
                                    </div>
                                    <div class="teacher-sidebar-right__table tranfer-apply-livestream">
                                        <div class="row">
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <table>
                                                    <tr class="teacher-sidebar-right__table__header">
                                                        <th>@lang('labels.transfer-apply.livestream.last_3_months')</th>
                                                        <th>@lang('labels.transfer-apply.livestream.seller_profit')</th>
                                                        <th>@lang('labels.transfer-apply.livestream.consumption_tax')</th>
                                                        <th>@lang('labels.transfer-apply.livestream.transfer_fee')</th>
                                                        <th>@lang('labels.transfer-apply.livestream.balance')</th>
                                                    </tr>
                                                    <tr class="teacher-sidebar-right__table__data">
                                                        <td>5月</td>
                                                        <td>¥25,000</td>
                                                        <td>¥8,900</td>
                                                        <td>¥250</td>
                                                        <td class="last-item">¥13250</td>
                                                    </tr>
                                                    <tr class="teacher-sidebar-right__table__data">
                                                        <td>5月</td>
                                                        <td>¥25,000</td>
                                                        <td>¥8,900</td>
                                                        <td>¥250</td>
                                                        <td class="last-item">¥13250</td>
                                                    </tr>
                                                    <tr class="teacher-sidebar-right__table__data">
                                                        <td>5月</td>
                                                        <td>¥25,000</td>
                                                        <td>¥8,900</td>
                                                        <td>¥250</td>
                                                        <td class="last-item">¥13250</td>
                                                    </tr>
                                                </table>
                                                <div class="footable-text">
                                                    <div class="help-text">
                                                        @lang('labels.transfer-apply.livestream.help_text_1')
                                                    </div>
                                                    <div class="help-text">
                                                        @lang('labels.transfer-apply.livestream.help_text_2')
                                                    </div>
                                                    <div class="help-text high-light">
                                                        @lang('labels.transfer-apply.videocall.help_text')
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="panel panel-default">
                                                      <div class="panel-heading">
                                                            <div class="panel-title">
                                                                @lang('labels.transfer-apply.livestream.money_transfer')
                                                            </div>
                                                      </div>
                                                      <div class="panel-content">
                                                        ¥13,250
                                                      </div>
                                                </div>
                                                <button type="button" class="btn button-apply" data-toggle="modal" data-target="#confirm-transfer">
                                                    @lang('labels.transfer-apply.livestream.button_apply_transfer')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="account-setting">
                                        <div class="manage-sale">
                                            @lang('labels.transfer-apply.livestream.transfer_account_setting')
                                        </div>
                                        <div class="button-change">
                                            <button type="button" class="btn button-apply">
                                                @lang('labels.transfer-apply.livestream.change_account_information')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="change-account-setting">
                                        <div class="row-input">
                                            <div class="title">@lang('labels.transfer-apply.livestream.bank_name')</div>
                                            <div class="info-input">
                                                <input type="text" placeholder="みずほ銀行" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row-input">
                                            <div class="title">@lang('labels.transfer-apply.livestream.branch_name')</div>
                                            <div class="info-input">
                                                <input type="text" placeholder="中目黒支店" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row-input">
                                            <div class="title">@lang('labels.transfer-apply.livestream.type')</div>
                                            <div class="info-input-select">
                                                <select name="year" id="input" class="form-control" required="required">
                                                        <option value="1">@lang('labels.transfer-apply.livestream.usually')</option>
                                                        <option value="2">@lang('labels.transfer-apply.livestream.current')</option>
                                                        <option value="2">@lang('labels.transfer-apply.livestream.savings')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row-input">
                                            <div class="title">@lang('labels.transfer-apply.livestream.account_number')</div>
                                            <div class="info-input">
                                                <input type="text" placeholder="1234567" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row-input">
                                            <div class="title">@lang('labels.transfer-apply.livestream.account_holder')</div>
                                            <div class="info-input">
                                                <input type="text" placeholder="ナカジマ　カズヤ" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.screen.teacher.my-page.transfer_apply.__partials.confirm-transfer')
    @include('client.screen.teacher.my-page.transfer_apply.__partials.confirm-transfer-completed')
@endsection
