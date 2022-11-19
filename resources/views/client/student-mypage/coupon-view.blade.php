@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .main {
            background: #fff !important;
        }
        .sidebar-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="main dashboard-wrapper custom-point">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    @include('client.student-mypage.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 main_content">
                    <div class="sidebar-right">
                        @include('client.common.dashboard-role')
                        <div class="sidebar-right__title">
                            <div class="sidebar-right__title__text">
                                @lang('labels.coupon-view.points_coupons')
                            </div>
                        </div>
{{--                        <div class="sidebar-right__navbar-order-list">--}}
{{--                            <div class="sidebar-right__navbar-order-list__flex">--}}
{{--                                <a href="{{route('client.student.my-page.point')}}" class="sidebar-right__navbar-order-list__order">@lang('labels.coupon-view.point')</a>--}}
{{--                                <div class="sidebar-right__navbar-order-list__cancel active f-w6">@lang('labels.coupon-view.coupon')</div>--}}
{{--                            </div>--}}
{{--                            <div class="sidebar-right__navbar-order-list__year">--}}
{{--                                <div class="sidebar-right__navbar-order-list__year__left"><img--}}
{{--                                            src="{{asset('assets/img/student/my-page/icon/left.svg')}}" alt=""></div>--}}
{{--                                <div class="sidebar-right__navbar-order-list__year__number">2021年</div>--}}
{{--                                <div class="sidebar-right__navbar-order-list__year__right"><img--}}
{{--                                            src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt=""></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <ul class="sidebar-right__navbar-order-list">
                            <li class="sidebar-right__navbar-order-list__flex ">
                                <a href="{{route('client.student.my-page.point')}}" class="sidebar-right__navbar-order-list__order ">@lang('labels.point-view.point')</a>
                            <li class="sidebar-right__navbar-order-list__flex">
                                <a class="sidebar-right__navbar-order-list__cancel active f-w6">@lang('labels.point-view.coupon')</a>
                            </li>
                            <div class="sidebar-right__navbar-order-list__year">
                                <div class="sidebar-right__navbar-order-list__year__left"><img
                                            src="{{asset('assets/img/student/my-page/icon/left.svg')}}" alt=""></div>
                                <div class="sidebar-right__navbar-order-list__year__number">2021年</div>
                                <div class="sidebar-right__navbar-order-list__year__right"><img
                                            src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt=""></div>
                            </div>
                        </ul>
{{--                        <div class="sidebar-right__list">--}}
{{--                            <div class="sidebar-right__list__text"> @lang('labels.coupon-view.coupon_list')</div>--}}
{{--                            <div class="sidebar-right__list__option">--}}
{{--                                <div class="sidebar-right__list__option__express">--}}
{{--                                    @lang('labels.coupon-view.express')--}}
{{--                                </div>--}}
{{--                                <div class="sidebar-right__list__option__new-order active">--}}
{{--                                    <div class="sidebar-right__list__option__new-order__radio">--}}
{{--                                        <input id="order-option" name="order-option" type="radio" checked>--}}
{{--                                        <label class="nomargin"></label>--}}
{{--                                    </div>--}}
{{--                                    <div class="sidebar-right__list__option__new-order__text">--}}
{{--                                        <label class="nomargin"--}}
{{--                                               for="order-option">@lang('labels.coupon-view.new_order')</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="sidebar-right__list__option__oldest-first">--}}
{{--                                    <div class="sidebar-right__list__option__oldest-first__radio">--}}
{{--                                        <input id="order-option1" name="order-option" type="radio">--}}
{{--                                        <label class="nomargin"></label>--}}
{{--                                    </div>--}}
{{--                                    <div class="sidebar-right__list__option__oldest-first__text">--}}
{{--                                        <label class="nomargin"--}}
{{--                                               for="order-option1">@lang('labels.coupon-view.oldest_first')</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="sidebar-right__table">--}}
{{--                            <table>--}}
{{--                                <tr class="sidebar-right__table__header">--}}
{{--                                    <th>@lang('labels.coupon-view.service_name')</th>--}}
{{--                                    <th>@lang('labels.coupon-view.owned_coupon')</th>--}}
{{--                                    <th>@lang('labels.coupon-view.expiration_date')</th>--}}
{{--                                    <th>@lang('labels.coupon-view.status')</th>--}}
{{--                                    <th>@lang('labels.coupon-view.date_of_use')</th>--}}
{{--                                </tr>--}}
{{--                                <tr class="sidebar-right__table__data">--}}
{{--                                    <td>クーポンタイトル</td>--}}
{{--                                    <td>¥500 OFF</td>--}}
{{--                                    <td>2021/05/01</td>--}}
{{--                                    <td>利用済み</td>--}}
{{--                                    <td>2021/04/28</td>--}}
{{--                                </tr>--}}
{{--                                <tr class="sidebar-right__table__data">--}}
{{--                                    <td>クーポンタイトル</td>--}}
{{--                                    <td>¥500 OFF</td>--}}
{{--                                    <td>2021/05/01</td>--}}
{{--                                    <td>有効</td>--}}
{{--                                    <td></td>--}}
{{--                                </tr>--}}
{{--                                <tr class="sidebar-right__table__data">--}}
{{--                                    <td>クーポンタイトル</td>--}}
{{--                                    <td>¥500 OFF</td>--}}
{{--                                    <td>2021/05/01</td>--}}
{{--                                    <td>有効</td>--}}
{{--                                    <td></td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    @include('client.layout.paginate')--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
