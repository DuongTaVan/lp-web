@extends('client.base.base')
@section('css')
    <style>
        .total-sale-money {
            max-width: 250px;
        }

        @media only screen and (max-width: 767px) {
            .teacher-dashboard__item .wrap-chart__legend .chart-title-mobile {
                transform: unset;
                width: 70%;
            }

            .teacher-dashboard__item.fluid {
                width: 100%;
                height: 210px;
                overflow: hidden;
            }
        }

        @media only screen and (max-width: 414px) {
            .teacher-dashboard__item .wrap-chart__legend .chart-title-mobile {
                width: 68%;
            }
            .hidden-custom{
                display: none;
            }
        }

        @media only screen and (max-width: 375px) {
            .teacher-dashboard__item .wrap-chart__legend .chart-title-mobile {
                width: 70%;
            }
        }

    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher d-flex custom-livestream">
        @include('client.screen.teacher.my-page.sidebar-left')
        <div class="content-right content-right__wrap px-0">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="main-mypage-teacher__tab">
                <div class="conatiner">
                    <div class="row align-items-center pb-10 pb-14">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 text-tab-left">
                            <div class="tab-left px-2">
                                @lang('labels.dashboard-livestream.dashboard')
                            </div>
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="tab-right">
                                {{--                                <div class="button-left">--}}
                                {{--                                    @lang('labels.dashboard-livestream.period_setting')--}}
                                {{--                                </div>--}}
                                <div class="button-setting">
                                    <img src="{{asset('assets/img/teacher-page/icon/setting.svg')}}" alt="">
                                </div>
                                @if($dashboard['date'])
                                    @include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $dashboard['date']])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="teacher-dashboard">
                @if(!empty($dashboard['sales']))
                    <div class="teacher-dashboard__item mobile-100">
                        <div class="panel panel-default">
                            <div class="panel-heading panel-heading--big panel-heading-green">
                                <h6 class="panel-title fs-header">@lang('labels.dashboard-livestream.total_sales')</h6>
                            </div>
                            <div class="panel-body panel-body--big total-sale">
                                <div class="money money-mobile-big"
                                     title="¥{{number_format($dashboard['sales']->total_sales, 0, '.', ',')}}">
                                    ¥{{number_format($dashboard['sales']->total_sales, 0, '.', ',')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="teacher-dashboard__item wrap-chart-sex fluid @if(!collect($dashboard['dataSexRatio'])->filter(function($item) { return $item != null;})->count()) hidden-custom @endif"
                         id="wrap-chart" data-json="{{json_encode($dashboard['dataSexRatio'])}}">
                        @if(collect($dashboard['dataSexRatio'])->filter(function($item) { return $item != null;})->count())
                            <div class="wrap-chart__legend">
                                <div class="wrap-chart__legend__1">
                                    <div id="piechart"></div>
                                    <span class="chart-title f-w6">
                                                                @lang('labels.dashboard-livestream.gender_ratio')
                                                            </span>
                                </div>
                                <span class="chart-title-mobile f-w6"> @lang('labels.dashboard-livestream.gender_ratio') </span>
                            </div>

                        @endif
                    </div>

                    <div class="teacher-dashboard__item wrap-chart-age fluid @if(!collect($dashboard['ageRatio'])->filter(function($item) { return $item != null;})->count()) hidden-custom @endif" id="wrap-chart1"
                         data-json="{{json_encode($dashboard['ageRatio'])}}">
                        @if(collect($dashboard['ageRatio'])->filter(function($item) { return $item != null;})->count())
                            <div class="wrap-chart__legend">
                                <div class="wrap-chart__legend__2">
                                    <div id="piechart1"></div>
                                    <span class="chart-title f-w6">
                                                                @lang('labels.dashboard-livestream.age_ratio')
                                                            </span>
                                </div>
                                <span class="chart-title-mobile f-w6">@lang('labels.dashboard-livestream.age_ratio')</span>
                            </div>

                        @endif
                    </div>

                    <div class="teacher-dashboard__item">
                        <div class="panel panel-default">
                            <div class="panel-heading panel-heading-default">
                                <h6 class="panel-title">@lang('labels.dashboard-livestream.delivery_service_sales')</h6>
                            </div>
                            @if(Auth::guard('client')->user()->teacher_category_skills === 1)
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money total-sale-money"
                                             title="¥{{number_format(($dashboard['sales']->total_sales_skills + $dashboard['sales']->total_sales_skills_sub), 0, '.', ',')}}">
                                            ¥{{number_format(($dashboard['sales']->total_sales_skills + $dashboard['sales']->total_sales_skills_sub), 0, '.', ',')}}</div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.fee_and_consultation')</div>
                                    </div>
                                </div>
                            @else
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money total-sale-money"
                                             title=" ¥{{number_format(($dashboard['sales']->total_sales - $dashboard['sales']->extension_sales), 0, '.', ',')}}">
                                            ¥{{number_format(($dashboard['sales']->total_sales - $dashboard['sales']->extension_sales - $dashboard['sales']->option_sales), 0, '.', ',')}}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::guard('client')->user()->teacher_category_skills === 1)
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.gift_total')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="¥{{ number_format($dashboard['sales']->gift_sales, 0, '.', ',')}}">
                                            ¥{{ number_format(($dashboard['sales']->gift_sales), 0, '.', ',')}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.number_of_customers')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="{{ number_format($dashboard['sales']->skills_applicants , 0, '.', ',')}}人 / {{ number_format($dashboard['sales']->skills_sub_applicants , 0, '.', ',')}}人">
                                            {{ number_format($dashboard['sales']->skills_applicants , 0, '.', ',')}}人
                                            / {{ number_format($dashboard['sales']->skills_sub_applicants , 0, '.', ',')}}
                                            人
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.live_distribution')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.buy')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="{{number_format(($dashboard['sales']->skills_applicants_teacher_new + $dashboard['sales']->skills_sub_applicants_teacher_new ) , 0, '.', ',')}}人 / {{number_format(($dashboard['sales']->skills_applicants_teacher_repeater + $dashboard['sales']->skills_sub_applicants_teacher_repeater), 0, '.', ',')}}人">
                                            {{number_format(($dashboard['sales']->skills_applicants_teacher_new + $dashboard['sales']->skills_sub_applicants_teacher_new ) , 0, '.', ',')}}
                                            人
                                            / {{number_format(($dashboard['sales']->skills_applicants_teacher_repeater + $dashboard['sales']->skills_sub_applicants_teacher_repeater), 0, '.', ',')}}
                                            人
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.new_repeater')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.customer_unit_price')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money total-sale-money"
                                             title="¥@if($dashboard['sales']->total_applicants != 0){{number_format(($dashboard['sales']->total_sales/$dashboard['sales']->total_applicants) , 0, '.', ',')}} @endif">
                                            ¥@if($dashboard['sales']->total_applicants != 0){{number_format(($dashboard['sales']->total_sales/$dashboard['sales']->total_applicants) , 0, '.', ',')}}
                                            @else<span class="fs-span">0</span>@endif</div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.average_purchase_price')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.live_distribution_service')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="@if(!empty($dashboard['sales'])){{ number_format($dashboard['sales']->is_skills , 0, '.', ',')}}@endif回 / @if(!empty($dashboard['sales'])){{number_format($dashboard['sales']->is_skills_sub , 0, '.', ',')}}@endif回">
                                            @if(!empty($dashboard['sales'])){{ number_format($dashboard['sales']->is_skills , 0, '.', ',')}}@else
                                                <span class="fs-span">0</span>@endif回
                                            / @if(!empty($dashboard['sales'])){{number_format($dashboard['sales']->is_skills_sub , 0, '.', ',')}}@else
                                                <span class="fs-span">0</span>@endif回
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.excluding_individual_courses')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.gift_acquisition_rate')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="text-content d-flex justify-content-center">
                                            {{--                                                            <div--}}
                                            {{--                                                                    class="delivery">@lang('labels.dashboard-livestream.delivery')</div>--}}
                                            <div class="money"
                                                 title="@if($dashboard['sales']->skills_applicants !=0){{ number_format(($dashboard['sales']->total_number_give_gift/$dashboard['sales']->skills_applicants) * 100 , 1, '.', ',')}}@endif%">@if($dashboard['sales']->skills_applicants !=0){{ number_format(($dashboard['sales']->total_number_give_gift/$dashboard['sales']->skills_applicants) * 100 , 1, '.', ',')}}@else
                                                    <span class="fs-span">0</span>@endif%
                                            </div>
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.number_of_gifts_sent')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.average_usage_time')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="@if($dashboard['sales']->is_skills !=0){{ number_format(($dashboard['sales']->minutes_skills/$dashboard['sales']->is_skills) , 0, '.', ',')}}@endif分 / @if($dashboard['sales']->is_skills_sub !=0){{number_format(($dashboard['sales']->minutes_skills_sub/$dashboard['sales']->is_skills_sub) , 0, '.', ',')}}@endif分">@if($dashboard['sales']->is_skills !=0){{ number_format(($dashboard['sales']->minutes_skills/$dashboard['sales']->is_skills) , 0, '.', ',')}}@else
                                                <span class="fs-span">0</span>@endif分
                                            / @if($dashboard['sales']->is_skills_sub !=0){{number_format(($dashboard['sales']->minutes_skills_sub/$dashboard['sales']->is_skills_sub) , 0, '.', ',')}}@else
                                                <span class="fs-span">0</span>@endif分
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.individual_course')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.total_usage_time')</h6>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if (isset($dashboard['sales']->total_minutes)) {
                                        $minutes = (int)$dashboard['sales']->total_minutes;
                                        if ($minutes < 1) {
                                            $hourAndMinutes = null;

                                        } else {
                                            $hour = floor($minutes / 60);
                                            $minute = ($minutes % 60);
                                            $hourAndMinutes = number_format($hour, 0, '.', ',') . '時間' . $minute;
                                        }

                                    }
                                    ?>
                                    <div class="money"
                                         title="@if(!empty($hourAndMinutes)){{$hourAndMinutes}}@endif分">@if(!empty($hourAndMinutes)){{$hourAndMinutes}}@else
                                            <span class="fs-span">0</span>@endif分
                                    </div>
                                    <div class="times"></div>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-videocall.extended_service_sales')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="money"
                                         title="¥{{ number_format($dashboard['sales']->extension_sales, 0, '.', ',')}}">
                                        ¥{{ number_format($dashboard['sales']->extension_sales, 0, '.', ',')}}</div>
                                    <div class="times times-extra"></div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-videocall.other_option_sales')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="money total-sale-money"
                                         title="¥{{ number_format($dashboard['sales']->option_sales, 0, '.', ',')}}">
                                        ¥{{ number_format($dashboard['sales']->option_sales, 0, '.', ',')}}</div>
                                    <div class="times times-extra"></div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.profit-live-stream.number_of_customers')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="flex-column">
                                        <div class="money"
                                             title="{{number_format($dashboard['sales']->total_applicants , 0, '.', ',')}}人">{{number_format($dashboard['sales']->total_applicants , 0, '.', ',')}}
                                            人
                                        </div>
                                        <div class="times times-extra">@lang('labels.dashboard-livestream.number_of_purchasers') </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.buy')</h6>
                                </div>
                                <div class="panel-body">
                                    @if(Auth::guard('client')->user()->teacher_category_consultation == 1)
                                        <div class="d-flex flex-column">
                                            <div class="money"
                                                 title="{{ number_format($dashboard['sales']->consultation_applicants_teacher_new , 0, '.', ',')}}人 / {{number_format($dashboard['sales']->consultation_applicants_teacher_repeater  , 0, '.', ',')}}人">{{ number_format($dashboard['sales']->consultation_applicants_teacher_new , 0, '.', ',')}}
                                                人
                                                / {{number_format($dashboard['sales']->consultation_applicants_teacher_repeater  , 0, '.', ',')}}
                                                人
                                            </div>
                                            <div class="times">@lang('labels.dashboard-livestream.new_repeater')</div>
                                        </div>
                                    @else
                                        <div class="d-flex flex-column">
                                            <div
                                                    class="money"
                                                    title="{{ number_format($dashboard['sales']->fortunetelling_applicants_teacher_new, 0, '.', ',')}}人 / {{number_format($dashboard['sales']->fortunetelling_applicants_teacher_repeater , 0, '.', ',')}}人">{{ number_format($dashboard['sales']->fortunetelling_applicants_teacher_new, 0, '.', ',')}}
                                                人
                                                / {{number_format($dashboard['sales']->fortunetelling_applicants_teacher_repeater , 0, '.', ',')}}
                                                人
                                            </div>
                                            <div class="times">@lang('labels.dashboard-livestream.new_repeater')</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-livestream.customer_unit_price')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div class="money total-sale-money"
                                             title="¥@if($dashboard['sales']->total_applicants !=0){{ number_format(($dashboard['sales']->total_sales/$dashboard['sales']->total_applicants) , 0, '.', ',')}}@endif">
                                            ¥@if($dashboard['sales']->total_applicants !=0){{ number_format(($dashboard['sales']->total_sales/$dashboard['sales']->total_applicants) , 0, '.', ',')}}@endif</div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.average_purchase_price')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-videocall.video_call_delivery_record')</h6>
                                </div>
                                @if(Auth::guard('client')->user()->teacher_category_consultation == 1)
                                    <div class="panel-body">
                                        <div class="d-flex flex-column">
                                            <div class="money"
                                                 title="{{number_format($dashboard['sales']->is_consultation , 0, '.', ',')}}回 / {{ number_format($dashboard['sales']->consultation_extension_count, 0, '.', ',')}}回">{{number_format($dashboard['sales']->is_consultation , 0, '.', ',')}}
                                                回
                                                / {{ number_format($dashboard['sales']->consultation_extension_count, 0, '.', ',')}}
                                                回
                                            </div>
                                            <div
                                                    class="times custom-font">@lang('labels.dashboard-videocall.delivery_service')</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="panel-body">
                                        <div class="d-flex flex-column">
                                            <div class="money"
                                                 title="{{number_format($dashboard['sales']->is_fortunetelling , 0, '.', ',')}}回/{{ number_format($dashboard['sales']->fortunetelling_extension_count, 0, '.', ',')}}回">{{number_format($dashboard['sales']->is_fortunetelling , 0, '.', ',')}}
                                                回/{{ number_format($dashboard['sales']->fortunetelling_extension_count, 0, '.', ',')}}
                                                回
                                            </div>
                                            <div
                                                    class="times custom-font">@lang('labels.dashboard-videocall.delivery_service')</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-videocall.average_usage_time')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <div
                                                class="text-content d-flex text-content justify-content-center">
                                            @if(Auth::guard('client')->user()->teacher_category_consultation == 1)
                                                <div class="money"
                                                     title="@if($dashboard['sales']->is_consultation != 0){{ number_format(($dashboard['sales']->total_minutes/$dashboard['sales']->is_consultation), 0, '.', ',')}}@endif分">@if($dashboard['sales']->is_consultation != 0){{ number_format(($dashboard['sales']->total_minutes/$dashboard['sales']->is_consultation), 0, '.', ',')}}@endif
                                                    <span class="fs-span">分</span>
                                                </div>
                                            @else
                                                <div class="money"
                                                     title="@if($dashboard['sales']->is_fortunetelling != 0){{ number_format(($dashboard['sales']->total_minutes/$dashboard['sales']->is_fortunetelling), 0, '.', ',')}}@endif分">@if($dashboard['sales']->is_fortunetelling != 0){{ number_format(($dashboard['sales']->total_minutes/$dashboard['sales']->is_fortunetelling), 0, '.', ',')}}@endif
                                                    <span class="fs-span">分</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-videocall.including_extension_time')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-dashboard__item">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-default">
                                    <h6 class="panel-title">@lang('labels.dashboard-videocall.total_usage_time')</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="d-flex flex-column">
                                        <?php
                                        if (isset($dashboard['sales']->total_minutes)) {
                                            $minutes = (int)$dashboard['sales']->total_minutes;
                                            if ($minutes < 1) {
                                                $hourAndMinutes = null;

                                            } else {
                                                $hour = floor($minutes / 60);
                                                $minute = ($minutes % 60);
                                                $hourAndMinutes = number_format($hour, 0, '.', ',') . '時間' . $minute;
                                            }

                                        }
                                        ?>
                                        <div class="money"
                                             title="@if(!empty($hourAndMinutes)){{$hourAndMinutes}}@endif分">@if(!empty($hourAndMinutes)){{$hourAndMinutes}}@endif
                                            <span class="fs-span">分</span>
                                        </div>
                                    </div>
                                    <div class="times times-extra"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="teacher-dashboard__item">
                        <div class="panel panel-default">
                            <div class="panel-heading panel-heading-default">
                                <h6 class="panel-title">@lang('labels.dashboard-livestream.number_of_followers')</h6>
                            </div>
                            <div class="panel-body">
                                <div class="d-flex flex-column">
                                    @if(!empty($dashboard['follow']))
                                        <div class="money"
                                             title="{{ number_format($dashboard['follow']['countFollowInMonth']->amount_follower , 0, '.', ',')}}人 / {{ number_format($dashboard['follow']['countFollow'] , 0, '.', ',')}}人">
                                            {{ number_format($dashboard['follow']['countFollowInMonth']->amount_follower , 0, '.', ',')}}
                                            人
                                            / {{ number_format($dashboard['follow']['countFollow'], 0, '.', ',')}}
                                            人
                                        </div>
                                    @endif

                                    <div
                                            class="times">@lang('labels.dashboard-livestream.this_month')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="teacher-dashboard__item">
                        <div class="panel panel-default">
                            <div class="panel-heading panel-heading-default">
                                <h6 class="panel-title">@lang('labels.dashboard-livestream.number_of_views')</h6>
                            </div>
                            <div class="panel-body">
                                @if(Auth::guard('client')->user()->teacher_category_skills === 1)
                                    <div class="d-flex flex-column">
                                        {{-- @dd($dashboard) --}}
                                        <div class="money fs-span"
                                             title="@if(!empty($dashboard['pageView'])){{ number_format(($dashboard['pageView']->is_skills/date('t')) , 1, '.', ',')}}@endif PV/@if(!empty($dashboard['pageView'])){{ number_format($dashboard['pageView']->is_skills , 0, '.', ',')}}@endif PV"> @if(!empty($dashboard['pageView'])){{ number_format(($dashboard['pageView']->is_skills/date('t')) , 1, '.', ',')}}@endif
                                            <span class="fs-span">PV / </span>@if(!empty($dashboard['pageView'])){{ number_format($dashboard['pageView']->is_skills , 0, '.', ',')}}@endif
                                            <span class="fs-span">PV</span>
                                        </div>
                                        <div class="times">@lang('labels.dashboard-livestream.daily_average')</div>
                                    </div>
                                @elseif(Auth::guard('client')->user()->teacher_category_consultation == 1)
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="@if(!empty($dashboard['pageView'])){{ number_format(($dashboard['pageView']->is_consultation/date('t')) , 1, '.', ',')}}@endif PV/@if(!empty($dashboard['pageView'])){{ number_format($dashboard['pageView']->is_consultation , 0, '.', ',')}}@endif PV"> @if(!empty($dashboard['pageView'])){{ number_format(($dashboard['pageView']->is_consultation/date('t')) , 1, '.', ',')}}@endif
                                            <span class="fs-span">PV / </span>@if(!empty($dashboard['pageView'])){{ number_format($dashboard['pageView']->is_consultation , 0, '.', ',')}}@endif
                                            <span class="fs-span">PV</span>
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.daily_average')</div>
                                    </div>
                                @else
                                    <div class="d-flex flex-column">
                                        <div class="money"
                                             title="@if(!empty($dashboard['pageView'])){{ number_format(($dashboard['pageView']->is_fortunetelling/date('t')) , 1, '.', ',')}}@endif PV/@if(!empty($dashboard['pageView'])){{ number_format($dashboard['pageView']->is_fortunetelling , 0, '.', ',')}}@endif PV"> @if(!empty($dashboard['pageView'])){{ number_format(($dashboard['pageView']->is_fortunetelling/date('t')) , 1, '.', ',')}}@endif
                                            <span class="fs-span">PV / </span>@if(!empty($dashboard['pageView'])){{ number_format($dashboard['pageView']->is_fortunetelling , 0, '.', ',')}}@endif
                                            <span class="fs-span">PV</span>
                                        </div>
                                        <div
                                                class="times">@lang('labels.dashboard-livestream.daily_average')</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="teacher-dashboard__item">
                        <div class="panel panel-default">
                            <div class="panel-heading panel-heading-default">
                                <h6 class="panel-title">@lang('labels.dashboard-livestream.cancel')</h6>
                            </div>
                            <div class="panel-body">
                                <div class="d-flex flex-column">
                                    <div class="money"
                                         title="@if(!empty($dashboard['countStudentCancellation'])){{number_format($dashboard['countStudentCancellation'] , 0, '.', ',')}}@endif 回/@if(!empty($dashboard['countTeacherCancellation'])){{number_format($dashboard['countTeacherCancellation'] , 0, '.', ',')}}@endif回">@if(!empty($dashboard['countStudentCancellation']))
                                            {{number_format($dashboard['countStudentCancellation'] , 0, '.', ',')}}@else
                                            <span class="fs-span">0</span>@endif<span
                                                class="fs-span">回 /@if(!empty($dashboard['countTeacherCancellation'])){{number_format($dashboard['countTeacherCancellation'] , 0, '.', ',')}}@else
                                                <span class="fs-span">0</span>@endif回
                                        </span>
                                    </div>
                                    <div class="times">@lang('labels.dashboard-livestream.buyer_seller')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

<style>
    svg > g > g:last-child {
        pointer-events: none
    }
</style>
@section("script")
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // function isMobileDevice() {
        //     return /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)
        //         || (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.platform))
        //         || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
        // }

        const widthScreen = $(window).width();
        var positionChart;
        var alignChart;
        var heightChart;
        var widthChart;
        var chartAreaLeft;
        var topPosition;
        if (widthScreen <= 414) {
            positionChart = 'right';
            alignChart = 'center';
            heightChart = '70%';
            widthChart = '100%';
            chartAreaLeft = 15;
            topPosition = 7;

        } else {
            positionChart = 'right';
            alignChart = 'center';
            heightChart = '90%';
            widthChart = '90%';
            chartAreaLeft = 20;
            topPosition = 0;
        }

        //Chart 1
        let dataSexRatio = $("#wrap-chart").attr('data-json');
        dataSexRatio = JSON.parse(dataSexRatio);
        dataSexLabel = ['男性', '女性', '無回答', 'その他'];
        var valueToPush = new Array();
        valueToPush.push(['Task', 'Hours per Day']);
        let dataSexLabel1 = [];

        for (var i = 0; i < dataSexLabel.length; i++) {
            dataSexLabel1 = [dataSexLabel[i], parseInt(dataSexRatio[i])];
            valueToPush.push(dataSexLabel1);
        }
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(valueToPush);

            var options = {
                chartArea: {left: chartAreaLeft, top: topPosition, width: widthChart, height: heightChart},
                legend: {position: positionChart, alignment: alignChart},
                // tooltip: { trigger: 'none' },
                colors: ['#41AAE5', '#D64A8F', '#8E84CB', '#F4664E']
            };

            const chartElm = document.getElementById('piechart');
            var chart = new google.visualization.PieChart(chartElm);

            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'click', clearSelection);
            document.body.addEventListener('click', clearSelection);

            // if (isMobileDevice()) {
            //     google.visualization.events.addListener(chart, 'touchstart', clearSelection);
            //     document.body.addEventListener('touchstart', clearSelection);
            // }

            // function clearSelection(e) {
            //     if (!chartElm.contains(e.srcElement)) {
            //         if (e.srcElement.tagName == "A" || e.srcElement.tagName == "DIV") {
            //             return;
            //         }
            //         if (isMobileDevice()) {
            //             chart.draw(data, options);
            //         } else {
            //             chart.setSelection(null);
            //         }
            //     }
            // }
        }

        //Chart 2

        let dataAgeRatio = $("#wrap-chart1").attr('data-json');
        dataAgeRatio = JSON.parse(dataAgeRatio);
        dataAgeLabel = ['10代', '20代', '30代', '40代', '50代', '60代以上'];
        let dataSexLabel2 = [];
        var valueToPush1 = new Array();
        valueToPush1.push(['Task', 'Hours per Day']);
        for (var i = 0; i < dataAgeLabel.length; i++) {
            dataSexLabel2 = [dataAgeLabel[i], parseInt(dataAgeRatio[i])];
            valueToPush1.push(dataSexLabel2);
        }
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart1);

        function drawChart1() {

            var data = google.visualization.arrayToDataTable(valueToPush1);

            var options = {
                chartArea: {left: chartAreaLeft, top: topPosition, width: widthChart, height: heightChart},
                legend: {position: positionChart, alignment: alignChart},
                // tooltip: { trigger: 'none' },
                colors: ['#23C460', '#8E84CB', '#F4664E', '#41AAE5', '#D64A8F', '#FFCE21']
            };

            const chartElm = document.getElementById('piechart1');
            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

            chart.draw(data, options);

            google.visualization.events.addListener(chart, 'click', clearSelection);
            document.body.addEventListener('click', clearSelection, false);

            // if (isMobileDevice()) {
            //     google.visualization.events.addListener(chart, 'touchstart', clearSelection);
            //     document.body.addEventListener('touchstart', clearSelection, false);
            // }

            // function clearSelection(e) {
            //     if (!chartElm.contains(e.srcElement)) {
            //         if (e.srcElement.tagName == "A" || e.srcElement.tagName == "DIV") {
            //             return;
            //         }
            //         if (isMobileDevice()) {
            //             chart.draw(data, options);
            //         } else {
            //             chart.setSelection(null);
            //         }
            //     }
            // }
        }
    </script>

@endsection
