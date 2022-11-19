@extends('client.base.base')
@section('css')
    <style>
        .main-mypage-teacher__header {
            margin-bottom: unset;
        }

        .sidebar-right__navbar-order-list__order {
            padding: 0 4.5px;
        }

        .custom-font-teacher {
            font-style: normal;
            font-weight: bold !important;
            font-size: 14px;
            line-height: 21px;
        }

        .col-custom {
            padding-left: 30px;
        }

        .main-mypage-teacher .service-list-draft .table-profit-livestream__footer-table .footer-text div {
            margin-bottom: 4px;
        }

        .main-mypage-teacher .service-list-draft .table-profit-livestream__footer-table .footer-text div:nth-child(2) {
            margin-left: unset;
        }

        .td_raised_hands {
            min-width: 100px;
        }

        .td_delivery_time {
            min-width: 50px;
        }

        .td_total_sales {
            min-width: 40px;
        }

        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td {
            padding: 17px 0;
        }

        .main-mypage-teacher .service-list-draft .manage-sale {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .main-mypage-teacher .service-list-draft .manage-sale .text-profit-user {
            color: #ee3d48;
        }

        td.custom-font.custom-last-td.f-w6.font-size-12 {
            font-size: 12px !important;
        }


        @media only screen and (max-width: 414px) {
            .main-mypage-teacher .container {
                max-width: 1200px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .col-custom {
                padding-left: 15px;
            }

            .main-mypage-teacher .service-list-draft .table-profit-livestream table {
                table-layout: fixed;
            }
        }

        .main-mypage-teacher .service-list-draft .table-profit-livestream table {
            margin-top: 20px;
        }

        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table th {
            padding: 11px 0;
        }

        .border-circle-livestream {
            font-size: 11px;
            color: #EE3D48;
        }

        .border-circle-video-call {
            font-size: 12px;
            color: #EE3D48;
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        @include('client.screen.teacher.my-page.sidebar-left')
        <div class="content-right">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="main-mypage-teacher__content">
                <div class="teacher-sidebar-right service-list-draft">
                    <div class="sidebar-right__navbar-order-list tab-profit-livestream">
                        @include('client.common.sub-header-teacher-mypage')
                        @include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $profitLiveStream['data']])
                    </div>
                    <div class="manage-sale">
                        <div>
                            @lang('labels.profit-live-stream.monthly_sales_management')
                        </div>
                        @if($textProfitUser)
                            <div class="text-profit-user">
                                ※現在６０日間限定の販売手数料１０％が適応されています。
                            </div>
                        @endif
                    </div>
                    <div class="teacher-sidebar-right__table table-profit-livestream">
                        <div class="fit-content-mobile">
                            @if(auth('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                <table class="table-livestream">
                                    @else
                                        <table class="table-videocall">
                                            @endif
                                            @if(auth('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                <tr class="table-profit-livestream__pre-header__livestream">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">①</div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">②</div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">③</div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">④</div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">⑤</div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">①
                                                            -(②+③+④+⑤)
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="table-profit-livestream__pre-header__livestream">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="border-circle border-circle-video-call f-w6">
                                                            ①
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-video-call f-w6">
                                                            ②
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-video-call f-w6">
                                                            ③
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-livestream f-w6">④</div>
                                                    </td>
                                                    <td>
                                                        <div class="border-circle border-circle-video-call f-w6">
                                                            ① -(②+③+④)
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="teacher-sidebar-right__table__header-videocall">
                                                <th class="f-w6"
                                                    style="border-radius: 5px 0 0 0 ;">@lang('labels.profit-live-stream.date')</th>
                                                <th class="f-w6">
                                                    @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                        入場料
                                                    @else
                                                        販売価格
                                                    @endif
                                                </th>
                                                <th class="td_delivery_time f-w6">@lang('labels.profit-live-stream.delivery_time')</th>
                                                <th class="f-w6">@lang('labels.profit-live-stream.number_of_customers')</th>
                                                <th class="f-w6">
                                                    @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                        コイン<br/>(ギフト)
                                                    @else
                                                        オプション売上
                                                    @endif
                                                </th>

                                                <th class="td_total_sales f-w6">@lang('labels.profit-live-stream.total_sales')</th>
                                                <th style="width: 75px"
                                                    class="f-w6">@lang('labels.profit-live-stream.fee')</th>

                                                @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                    <th class="td_raised_hands f-w6">手数料 <br/>(コイン売上）</th>
                                                @endif
                                                <th style="width: 100px" class="f-w6">システム利用料 <br/>(1人/50円)</th>

                                                <th class="f-w6"
                                                    style="text-overflow: unset; word-break: break-all">@lang('labels.profit-live-stream.cancellation_fee')</th>
                                                <th class="f-w6"
                                                    style="border-radius:0 5px 0 0 ;">@lang('labels.profit-live-stream.seller_profit')</th>
                                            </tr>
                                            @if(!empty($profitLiveStream['profitLiveStream']) && $profitLiveStream['profitLiveStream'] != [])
                                                @foreach($profitLiveStream['profitLiveStream'] as $profit)
                                                    <tr class="teacher-sidebar-right__table__data  @if($profit->course_schedules_status === \App\Enums\Constant::COURSE_SCHEDULE_STATUS) custom-td @endif">
                                                        @if((int)$profit->teacher_profit !== 0)
                                                            <td class="custom-font-teacher f-w6">
                                                                {{Carbon\Carbon::parse($profit->target_date)->format('m')}}
                                                                月{{Carbon\Carbon::parse($profit->target_date)->format('d')}}
                                                                日
                                                            </td>
                                                            <td>{{number_format($profit->base_price)}}</td>
                                                            <td>{{number_format($profit->total_minutes)}}</td>
                                                            <td>{{number_format($profit->total_applicants)}}</td>
                                                            <td>
                                                                @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                                    {{number_format($profit->gift_sales/10)}}
                                                                @else
                                                                    {{number_format($profit->option_sales + $profit->extension_sales)}}
                                                                @endif
                                                            </td>

                                                            <td>{{number_format($profit->total_sales)}}</td>
                                                            <td>{{number_format($profit->sales_commissions)}}</td>
                                                            @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                                <td>{{number_format($profit->other_commissions)}}</td>
                                                            @endif
                                                            <td>{{number_format($profit->system_commissions)}}</td>

                                                            <td>{{(int)$profit->cancellation_fee ? number_format($profit->cancellation_fee) : ''}}</td>
                                                            <td class="custom-font-teacher custom-last-td custom-last-td--black f-w6">{{number_format($profit->teacher_profit)}}</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="f-w6 custom-last-td">合計</td>
                                                    <td class="f-w6 custom-last-td">ー</td>
                                                    <td class="f-w6 custom-last-td">{{getHoursMinute($profitLiveStream['profitLiveStream']->sum('total_minutes'))}}</td>
                                                    <td class="f-w6 custom-last-td">{{ number_format($profitLiveStream['profitLiveStream']->sum('total_applicants'), 0, ',', ',') }}</td>
                                                    @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                        <td class="f-w6 custom-last-td">{{ number_format($profitLiveStream['profitLiveStream']->sum('gift_sales') / 10, 0, ',', ',') }}</td>
                                                    @else
                                                        <td class="f-w6 custom-last-td">{{number_format($profitLiveStream['profitLiveStream']->sum('option_sales') + $profitLiveStream['profitLiveStream']->sum('extension_sales'))}}</td>
                                                    @endif
                                                    <td class="f-w6 custom-last-td ">{{ number_format($profitLiveStream['profitLiveStream']->sum('total_sales'), 0, ',', ',') }}</td>
                                                    <td class="f-w6 custom-last-td"
                                                        title="{{ number_format($profitLiveStream['profitLiveStream']->sum('sales_commissions'), 0, ',', ',') }}">{{ number_format($profitLiveStream['profitLiveStream']->sum('sales_commissions'), 0, ',', ',') }}</td>
                                                    @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                        <td class="f-w6 custom-last-td"
                                                            title="{{ number_format($profitLiveStream['profitLiveStream']->sum('other_commissions'), 0, ',', ',') }}">{{ number_format($profitLiveStream['profitLiveStream']->sum('other_commissions'), 0, ',', ',') }}</td>
                                                    @endif
                                                    <td class="f-w6 custom-last-td"
                                                        title="{{ number_format($profitLiveStream['profitLiveStream']->sum('system_commissions'), 0, ',', ',') }}">{{ number_format($profitLiveStream['profitLiveStream']->sum('system_commissions'), 0, ',', ',') }}</td>
                                                    <td class="f-w6 custom-last-td ">{{ number_format($profitLiveStream['profitLiveStream']->sum('cancellation_fee'), 0, ',', ',') }}</td>
                                                    <td class="f-w6 custom-last-td">{{ number_format($profitLiveStream['profitLiveStream']->sum('teacher_profit'), 0, ',', ',') }}</td>
                                                </tr>
                                                <tr class="table-profit-livestream__footer-table">
                                                    @if (count($profitLiveStream['profitLiveStream']) > 0)
                                                        @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                            <td colspan="9" class="footer-text">

                                                            </td>
                                                        @else
                                                            <td colspan="7" class="footer-text">
                                                                <div></div>
                                                            </td>
                                                        @endif
                                                    @else
                                                        @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                                            <td colspan="9" class="footer-text">
                                                            </td>
                                                        @else
                                                            <td colspan="7" class="footer-text"></td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endif
                                        </table>
                                        @if(Auth::guard('client')->user()->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                                            <div class="list-note list-note-livetream">
                                                <div>
                                                    ②手数料２２％とは、コイン売上分を除く (ライブ配信・個別講座)の売上に対して２２％です。
                                                </div>
                                                <div>
                                                    ③ギフトのコイン手数料は（開催実績・レビュー評価・開催期間）など独自計算式により変更します。<br>
                                                    　また独自計算式は公開しておりません。
                                                </div>
                                                <div>
                                                    ④システム手数料は１回の配信（１ユーザー毎）に発生し、サービスを延長した場合は追加で加算されます。
                                                </div>
                                                <div>
                                                    ⑤キャンセル手数料は購入者がいる場合に出品者の都合でキャンセルを実施した場合に発生します。（開催日前日22:00以降から対象）
                                                </div>
                                            </div>
                                        @else
                                            <div class="list-note">
                                                <div>
                                                    ③システム手数料は１回の配信（１ユーザー毎）に発生し、サービスを延長した場合は追加で加算されます。
                                                </div>
                                                <div>
                                                    ④キャンセル手数料は購入者がいる場合に出品者の都合でキャンセルを実施した場合に発生します。（開催日前日22:00以降から対象）
                                                </div>
                                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
    <script>
        let radioButton = document.querySelectorAll('.button-radio');
        radioButton.forEach(el => {
            el.addEventListener('click', () => {
                removeClassActive();
                el.classList.add('active-radio')
            })
        })

        function removeClassActive() {
            radioButton.forEach(el => {
                el.classList.remove('active-radio')
            })
        }
    </script>
@endsection
