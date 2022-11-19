@extends('client.base.base')
@section('css')
    <style>
        .main-mypage-teacher__content .teacher-sidebar-right__center {
            margin: 25px 0;
        }

        .teacher-sidebar-right__center {
            padding: 0;
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher custom-service">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="teacher-sidebar-right">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text  text-breadcrumb">
                                    <a href="{{ route('client.teacher.my-page.service-list') }}">@lang('labels.service-list-order-status.manager_service')</a>
                                    <span>></span>
                                    @lang('labels.service-list-order-status.reservation_status')
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__center d-flex">
                                <div class="teacher-sidebar-right__center--group">
                                    <div class="service-title-name text-ellipsis">{{ $courseSchedule->title }}</div>
                                    <div class="service-amount d-flex custom-order-service">
                                        <div class="service-date">{{ $courseSchedule->month_day }}</div>
                                        <div class="service-time">{{ $courseSchedule->hour_minute }}</div>
                                        <div class="service-money">¥{{ $courseSchedule->price }}</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center ml-auto order-status-align-items-start">
                                    <a href="{{ route('client.teacher.my-page.service-list') }}"
                                       class="btn-back ">一覧に戻る</a>
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__table">
                                <table class="order-status-table">
                                    <tr class="teacher-sidebar-right__table__header">
                                        <th>@lang('labels.service-list-order-status.purchase_date')</th>
                                        <th>@lang('labels.service-list-order-status.time')</th>
                                        <th>@lang('labels.service-list-order-status.nickname')</th>
                                        <th>@lang('labels.service-list-order-status.sex')</th>
                                        <th>@lang('labels.service-list-order-status.age')</th>
                                        <th>@lang('labels.service-list-order-status.purchase_history')</th>
                                        <th>@lang('labels.service-list-order-status.point')</th>
                                        <th>@lang('labels.service-list-order-status.coupon')</th>
                                        <th>@lang('labels.service-list-order-status.payment')</th>
                                    </tr>
                                    @foreach($students as $item)
                                        <tr class="teacher-sidebar-right__table__data">
                                            <td>{{ now()->parse($item->created_at)->format('Y/m/d') }}</td>
                                            <td>{{ now()->parse($item->created_at)->format('H:i') }}</td>
                                            <td>{{ $item->nickname }}</td>
                                            <td>
                                                @if($item->sex == 1)
                                                    男性
                                                @elseif($item->sex == 2)
                                                    女性
                                                @elseif($item->sex == 9)
                                                    その他
                                                @endif
                                            </td>
                                            <td>{{ $item->current_age - $item->current_age%10 }}</td>
                                            <td>{{ $item->purchases_count }}</td>
                                            <td>{{ number_format($item->points_balance) }}pt</td>
                                            <td></td>
                                            <td>{{ $item->card_brand }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            {{ $students->appends(request()->query())->links('client.layout.paginate') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .teacher-sidebar-right__title__text {
        font-size: 16px;
        line-height: 24px;
    }

    .teacher-sidebar-right__center {
        padding: 0 10px;
    }

    .teacher-sidebar-right__title__text span {
        width: 6px;
        height: 10px;
    }

    .teacher-sidebar-right__title__text a {
        color: #2A3242 !important;
    }
</style>
