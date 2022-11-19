@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
            width: unset;
        }

        .col3 {
            flex: 0 0 22.5%;
            max-width: 22.5%;
            padding: unset;
        }

        .col9 {
            flex: 0 0 77.5%;
            max-width: 77.5%;
            padding: 0 0 0 30px;
        }

        .main {
            background: #fff !important;
        }

        .sidebar-right__list::before {
            left: 0;
        }

        .sidebar-right__list__text {
            padding-left: 0;
        }

        @media screen and (max-width: 576px) {
            .col9 {
                flex: unset;
                max-width: 100%;
                padding: unset;
            }
        }

        .sidebar-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('header')
    <meta name="description" content="ポイント・クーポン">
    <title>ポイント・クーポン</title>
@endsection
@section('content')
    <div class="main dashboard-wrapper my-page-student custom-point">
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
                                @lang('labels.point-view.points_coupons')
                            </div>
                        </div>
                        <ul class="sidebar-right__navbar-order-list">
                            <li class="sidebar-right__navbar-order-list__flex">
                                <a href="javascript:;"
                                   class="sidebar-right__navbar-order-list__order active f-w6">@lang('labels.point-view.point')</a>
                            <li class="sidebar-right__navbar-order-list__flex">
                                <a href="{{ route('client.student.my-page.coupon') }}"
                                   class="sidebar-right__navbar-order-list__cancel">@lang('labels.point-view.coupon')</a>
                            </li>
                            <div class="sidebar-right__navbar-order-list__year">
                                @include('client.common.year-search', ['yearOption'=>$data])
                            </div>
                        </ul>
                        <div class="sidebar-right__list list-point f-w6">
                            @if(!empty($pointBalance))
                                <div class="sidebar-right__list__text">@lang('labels.point-view.total_point'){{$pointBalance->points_balance}}
                                    pt
                                </div>
                            @else
                                <div class="sidebar-right__list__text">@lang('labels.point-view.total_point')</div>
                            @endif
                            <div class="sidebar-right__list__option--point">
                                <div class="sidebar-right__list__option__express">
                                    <img class="rotate-img"
                                         src="{{asset('assets/img/student/my-page/icon/right-grey.svg')}}" alt="">
                                </div>
                            </div>
                            <section class=" sidebar-right__list__select-point sidebar-right__list__choose-option">
                                <div class="expiration_date">
                                    <div id="sort-asc">@lang('labels.point-view.new_order')</div>
                                    <div id="sort-desc">@lang('labels.point-view.oldest_first')</div>
                                </div>
                            </section>
                        </div>
                        {{--                        <div class="sidebar-right__table">--}}
                        {{--                            @if(isset($data['listPoint']) && count($data['listPoint']) > 0)--}}
                        {{--                                <table>--}}
                        {{--                                    <tr class="sidebar-right__table__header">--}}
                        {{--                                        <th>@lang('labels.point-view.service_name')</th>--}}
                        {{--                                        <th>@lang('labels.point-view.grant_points')</th>--}}
                        {{--                                        <th>@lang('labels.point-view.expiration_date')</th>--}}
                        {{--                                        <th>@lang('labels.point-view.status')</th>--}}
                        {{--                                        <th>@lang('labels.point-view.usage_points')</th>--}}
                        {{--                                        <th>@lang('labels.point-view.date_of_use')</th>--}}
                        {{--                                        <th>@lang('labels.point-view.remaining')</th>--}}
                        {{--                                    </tr>--}}
                        {{--                                    @foreach($data['listPoint'] as $key => $item)--}}
                        {{--                                        <tr class="sidebar-right__table__data">--}}
                        {{--                                            <td class="sidebar-right__table__data__td-point">--}}
                        {{--                                                <div class="sidebar-right__table__data__image-point">--}}
                        {{--                                                    <img src="{{$item['img'] ?? asset('assets/img/portal/default-image.svg')}}"--}}
                        {{--                                                            alt="">--}}
                        {{--                                                </div>--}}
                        {{--                                                <div class="sidebar-right__table__data__col1">--}}
                        {{--                                                    <div class="sidebar-right__table__data__col1__title">{{$item['title']}}</div>--}}
                        {{--                                                    <div class="sidebar-right__table__data__col1__price">¥{{number_format($item['price'])}}</div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </td>--}}
                        {{--                                            @if(isset($item['deposit_points']) && isset($item['withdrawal_points']))--}}
                        {{--                                                <td>{{number_format($item['deposit_points'])}}pt</td>--}}
                        {{--                                            @elseif(isset($item['deposit_points']))--}}
                        {{--                                                <td>{{number_format($item['deposit_points'])}}pt</td>--}}
                        {{--                                            @else--}}
                        {{--                                                <td>-{{number_format($item['withdrawal_points'])}}pt</td>--}}
                        {{--                                            @endif--}}
                        {{--    --}}
                        {{--                                            <td>{{formatTime($item['expiration_date'],'Y/m/d')}}</td>--}}
                        {{--                                            @if($item['is_consumed'] === 0 && $item['is_processed'] === 0)--}}
                        {{--                                                <td>{{\App\Enums\Constant::IS_CONSUMED_AND_PROCESSED}}</td>--}}
                        {{--                                            @elseif($item['is_consumed'] === 1 && $item['is_processed'] === 1)--}}
                        {{--                                                <td>{{\App\Enums\Constant::IS_PROCESSED}}</td>--}}
                        {{--                                            @elseif($item['is_consumed'] === 1)--}}
                        {{--                                                <td>{{\App\Enums\Constant::IS_CONSUMED}}</td>--}}
                        {{--                                            @elseif($item['is_processed'] === 1)--}}
                        {{--                                                <td>{{\App\Enums\Constant::IS_PROCESSED}}</td>--}}
                        {{--                                            @else--}}
                        {{--                                                <td></td>--}}
                        {{--                                            @endif--}}
                        {{--                                            <td>{{number_format($item['consumed_points'])}}pt</td>--}}
                        {{--                                            <td>{{formatTime($item['transacted_at'], 'Y/m/d')}}</td>--}}
                        {{--                                            <td>{{number_format($item['deposit_points']-$item['consumed_points'])}}pt--}}
                        {{--                                            </td>--}}
                        {{--                                        </tr>--}}
                        {{--                                    @endforeach--}}
                        {{--                                </table>--}}
                        {{--                            @endif--}}
                        {{--                        </div>--}}
                        {{--                        @if(isset($data['listPoint']) && count($data['listPoint']) > 0)--}}
                        {{--                            <div class="table__footer__pagination">--}}
                        {{--                                {{ $data['listPoint']->appends(request()->query())->links('client.layout.paginate') }}--}}
                        {{--                            </div>--}}
                        {{--                        @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        jQuery(document).ready(function ($) {
            $('.sidebar-right__list__option--point').click(function () {
                $('.sidebar-right__list__select-point').toggleClass('sidebar-right__list__choose-option')
            });

            let url = new URL(window.location.href);
            let searchParams = url.searchParams;
            let sortColumn, sortBy;
            $('#sort-asc').addClass("active")
            searchParams.forEach((item, index) => {
                if (index === "sort_column") {
                    sortColumn = "#" + item;
                }
                if (index == "sort_by") {
                    sortBy = "#sort-" + item;
                }
                if (sortBy && sortColumn) {
                    let sortElement = $(sortBy);
                    sortElement.addClass('active-item')
                    $('#sort-asc').removeClass("active");
                }
            });
            if (sortBy) {
                $('.sidebar-right__list__option--point').append($(sortBy).html())
            } else {
                $('.sidebar-right__list__option--point').append($('#sort-asc').html())
            }
            if (sortBy != '#sort-desc') {
                $("#sort-desc").on("click", function (e) {
                    let sortColumn = e.target.parentNode.className;
                    let sortBy = "desc";
                    let newPath = formatUrl(searchParams, ['sort_by', 'sort_column']);
                    newPath += `sort_by=${sortBy}&sort_column=${sortColumn}`;
                    window.location.href = window.location.pathname + newPath;

                });
            } else {
                $("#sort-asc").on("click", function (e) {
                    let sortColumn = e.target.parentNode.className;
                    let sortBy = "asc";
                    let newPath = formatUrl(searchParams, ['sort_by', 'sort_column']);
                    newPath += `sort_by=${sortBy}&sort_column=${sortColumn}`;
                    window.location.href = window.location.pathname + newPath;
                });
            }


            function formatUrl(searchParams, params = []) {
                let newSearchParams = "?";
                searchParams.forEach((item, index) => {
                    if (item && !params.includes(index) && !newSearchParams.includes(index)) {
                        newSearchParams += index + "=" + encodeURIComponent(item) + "&";
                    }
                });
                return newSearchParams;
            }
        })
    </script>
@endsection

