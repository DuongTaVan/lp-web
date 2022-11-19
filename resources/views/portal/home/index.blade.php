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
            object-fit: cover;
        }

        .input-date {
            height: 40px;
            border: 1px solid #CCCCCC;
            border-radius: 3px;
            padding: 0 10px;
            font-size: 12px;
        }

        .hidden-calendar {
            display: none !important;
        }

        .search-calendar {
            margin-top: 39px;
            height: 30px;
            margin-left: 0px;
        }

        .search-calendar:disabled {
            background-color: #b3b3b3;
            color: #fff;
        }

        .text-month {
            padding: 0 13px;
        }

        .tax {
            color: black;;
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="home">
        <div class="">
            <form action="" id="search-form" method="GET">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="label_dashboard f-w6">{{ __('labels.dashboard-livestream.dashboard') }}</p>
                        <p class="label_category f-w6">
                            @switch(Request::get('category'))
                                @case(1)
                                    教えて！ライブ配信計
                                    @break

                                @case(2)
                                    オンライン悩み相談計
                                    @break

                                @case(3)
                                    オンライン占い計
                                    @break

                                @default
                                    全社計
                            @endswitch
                            @if (!request()->get('start_date') && !request()->get('end_date'))
                                <span class="text-month">{{ now()->month }}月度</span>
                            @endif
                            <span class="tax">※表示は消費税込み</span>
                        </p>
                    </div>
                    <div>
                        <select class="form-select form-select-lg custom-select select_category_option" name="category">
                            @foreach(\App\Enums\DBConstant::LIST_CATEGORY as $key => $value)
                                <option value="{{ $key }}" {{ (int)$searchParams['category'] === $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        <div class="select-date d-flex align-items-center" style="margin-top: 5px">
                            <div class="select-date__label f-w6" id="open-calendar" style="cursor: pointer;">期間設定
                            </div>
                        </div>
                        <div class="d-flex flex-wrap list-option--top hidden-calendar" style="margin-top: 15px;">
                            <div>
                                <p>指定日 (開始)</p>
                                <div class="jquery-datetime-picker datetimepicker date-time-course">
                                    <input type="text" class="auto-trim start-datetime input-date start" data-input
                                           value="{{ Request::get('start_date') ?? null }}" name="start_date"
                                           autocomplete="off" data-format="Y-m-d">
                                    <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt=""
                                         data-toggle>
                                </div>
                            </div>
                            <div>
                                <p>指定日 (終了)</p>
                                <div class="jquery-datetime-picker datetimepicker date-time-course">
                                    <input type="text" class="auto-trim end-datetime input-date end" data-input
                                           value="{{ Request::get('end_date') ?? null }}" name="end_date"
                                           autocomplete="off" data-format="Y-m-d">
                                    <img src="{{asset('assets/img/portal/icons/icon-calender.svg')}}" alt=""
                                         data-toggle>
                                </div>
                            </div>
                            <div class="f-w3">
                                <button id="search-button" class="btn-search btn-primary search-calendar" disabled>検索
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <input name="month" type="hidden" value="{{Request::get('month') ?? null}}">
            </form>
        </div>
        <div class="wrap-total mb-19 mt-11 f-w6">
            <div class="wrap-common-2">
                <div class="label-common label-total-sale text-center f-w6">GMV(流通総額)</div>
                <div class="wrap-content">
                    <div class="content d-flex justify-content-center align-items-center">
                        ¥@money($data['sales']['total_sales'])
                    </div>
                </div>
            </div>
            <div class="wrap-common-2">
                <div class="label-common label-total-sale text-center f-w6">総売上</div>
                <div class="wrap-content">
                    <div class="content d-flex justify-content-center align-items-center">
                        ¥@money($data['sales']['total_commissions'])
                    </div>
                </div>
            </div>
        </div>
        <div>
            @switch(Request::get('category'))
                @case(1)
                    @include('portal.home.live-streaming')
                    @break

                @case(2)
                    @include('portal.home.online-trouble')
                    @break

                @case(3)
                    @include('portal.home.online-fortune-telling')
                    @break
                @default
                    @include('portal.home.all-categories')
            @endswitch
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (e) {
            const url = window.location.href;
            if (url.includes('start_date') || url.includes('end_date')) {
                $(".list-option--top").removeClass("hidden-calendar");
            }
            if ($('.start').val() != '' && $('.end').val() != '' || $('.start').val() == '' && $('.end').val() == '') {
                $('#search-button').prop("disabled", false);
            }
            $("#open-calendar").click(function () {
                if ($(".list-option--top").hasClass("hidden-calendar")) {
                    $(".list-option--top").removeClass("hidden-calendar");
                } else {
                    $('.start').val('');
                    $('.end').val('');
                    $(".list-option--top").addClass("hidden-calendar");
                }
            });
            $(".input-date").change(e => {
                console.log($('.start').val());
                if ($('.start').val() != '' && $('.end').val() != '' || $('.start').val() == '' && $('.end').val() == '') {
                    $('#search-button').prop("disabled", false);
                }
                if ($('.start').val() != '' && $('.end').val() == '' || $('.start').val() == '' && $('.end').val() != '') {
                    $('#search-button').prop("disabled", true);
                }
            });
        });
    </script>
@endsection
