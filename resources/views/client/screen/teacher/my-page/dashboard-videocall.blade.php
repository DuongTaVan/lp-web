@extends('client.base.base')
@section('content')
    <div class="main-mypage-teacher custom-livestream">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="main-mypage-teacher__header">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="text-left">@lang('labels.dashboard-livestream.buyer')</div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="text-right">@lang('labels.dashboard-livestream.seller')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-mypage-teacher__tab">
                        <div class="conatiner">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-tab-left">
                                    <div class="tab-left">
                                    @lang('labels.dashboard-livestream.dashboard')
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="tab-right">
                                        <div class="button-left">
                                        @lang('labels.dashboard-livestream.period_setting')
                                        </div>
                                        <div class="sidebar-right__navbar-order-list__year">
                                            <div class="sidebar-right__navbar-order-list__year__left"><img
                                                        src="{{asset('assets/img/student/my-page/icon/left.svg')}}" alt=""></div>
                                            <div class="sidebar-right__navbar-order-list__year__number">5月/2021年</div>
                                            <div class="sidebar-right__navbar-order-list__year__right"><img
                                                        src="{{asset('assets/img/student/my-page/icon/right.svg')}}" alt=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-mypage-teacher__content">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-green">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.total_sales')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money"> ¥114,000</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <canvas id="myChart"></canvas>
                                    <div class="chart-title">
                                    @lang('labels.dashboard-livestream.gender_ratio')
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <canvas id="myChart1"></canvas>
                                    <div class="chart-title">
                                    @lang('labels.dashboard-livestream.age_ratio')
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.delivery_service_sales')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">¥85,000</div>
                                                <div class="times times-extra"></div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-videocall.extended_service_sales')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">5回/¥15,000</div>
                                                <div class="times times-extra"></div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-videocall.other_option_sales')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">1回/¥3,000</div>
                                                <div class="times times-extra"></div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.number_of_customers')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">30人</div>
                                                <div class="times times-extra"></div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.buy')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">29人/1人</div>
                                                <div class="times">@lang('labels.dashboard-livestream.new_repeater')</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.customer_unit_price')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">¥3,800</div>
                                                <div class="times">@lang('labels.dashboard-livestream.average_purchase_price')</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-videocall.video_call_delivery_record')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">48回/8回</div>
                                                <div class="times custom-font">@lang('labels.dashboard-videocall.delivery_service')</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-videocall.average_usage_time')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="text-content d-flex text-content">
                                                    <div class="delivery">1人</div>
                                                    <div class="money">31分</div>
                                                </div>
                                                <div class="times">@lang('labels.dashboard-videocall.including_extension_time')</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-videocall.total_usage_time')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">32時間45分</div>
                                                <div class="times times-extra"></div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.number_of_followers')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">11人/125人</div>
                                                <div class="times">@lang('labels.dashboard-livestream.this_month')</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.number_of_views')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">25PV/750PV</div>
                                                <div class="times">@lang('labels.dashboard-livestream.daily_average')</div>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="panel panel-default">
                                          <div class="panel-heading panel-heading-default">
                                                <h6 class="panel-title">@lang('labels.dashboard-livestream.cancel')</h6>
                                          </div>
                                          <div class="panel-body">
                                                <div class="money">5回/0回</div>
                                                <div class="times">@lang('labels.dashboard-livestream.buyer_seller')</div>
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

@endsection
@section("script")
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        datasets: [{
            data: [300, 50, 100],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
            ],
            //hoverOffset: 4
        }]
    }
});
var ctx1 = document.getElementById('myChart1');
var myChart = new Chart(ctx1, {
    type: 'pie',
    data: {
        datasets: [{
            data: [300, 50, 100],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
            ],
            //hoverOffset: 4
        }]
    }
});
</script>
@endsection