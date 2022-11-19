@extends('client.base.base')
@section('css')
    <style>
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

        li {
            font-size: 18px;
        }

        .sidebar-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="main dashboard-wrapper my-page-student student-follow">
        <div class="container">
            <div class="row">
                <div class="col3 col-sm-3 sidebar-sp">
                    @include('client.student-mypage.sidebar-left')
                </div>
                <div class="col9 col-sm-12 content-sp main_content">
                    <div class="sidebar-right">
                        @include('client.common.dashboard-role')
                        <div class="sidebar-right__title">
                            <div class="sidebar-right__title__text">
                                @lang('labels.follow-view.number_follow')
                            </div>
                        </div>
                        <div class="sidebar-right__list page-follow">
                            <div class="sidebar-right__list__option--follow f-w6">
                                <div class="sidebar-right__list__option__express">
                                    <img class="rotate-img"
                                         src="{{asset('assets/img/student/my-page/icon/right-grey.svg')}}" alt="">
                                </div>
                            </div>
                            <section class=" sidebar-right__list__select-follow sidebar-right__list__choose-option">
                                <div class="created_at">
                                    <div id="sort-asc">@lang('labels.point-view.new_order')</div>
                                    <div id="sort-desc">@lang('labels.point-view.oldest_first')</div>
                                </div>
                            </section>
                        </div>
                        @if(isset($data['follows']) && count($data['follows']) > 0)
                            <div class="sidebar-right__table">
                                <table>
                                    <tr class="sidebar-right__table__header">
                                        <th>@lang('labels.follow-view.registration_date')</th>
                                        <th style="width: 264px;">@lang('labels.follow-view.nickname')</th>
                                        <th>@lang('labels.follow-view.sex')</th>
                                        <th style="width: 285px;">@lang('labels.follow-view.evaluation')</th>
                                    </tr>
                                    @foreach($data['follows'] as $key => $follow)
                                        <tr class="sidebar-right__table__data-follow">
                                            <td>{{\Carbon\Carbon::parse($follow['created_at'])->format('y/m/d')}}</td>
                                            @if($follow['name_use']=== 1)
                                                <td><a class="text-deco-custom"
                                                       href="{{route('client.teacher.detail', ['user_id' => $follow->to_user_id])}}">{{$follow['nickname']}}</a>
                                                </td>
                                            @else
                                                <td><a class="text-deco-custom"
                                                       href="{{route('client.teacher.detail', ['user_id' => $follow->to_user_id])}}">{{$follow['last_name_kanji']}} {{$follow['first_name_kanji']}}</a>
                                                </td>
                                            @endif
                                            <td>{{\App\Enums\Constant::GENDER_TEXT[$follow['sex']]}}</td>
                                            @foreach($data['avg_rating'] as $index => $item)
                                                @if($key === $index)
                                                    <td class="td-star">
                                                        @include('client.common.show-star',['rating'=> ratingProcess($item)])
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                        @if(isset($data['follows']) && count($data['follows']) > 0)
                            <div class="table__footer__pagination">
                                {{ $data['follows']->appends(request()->query())->links('client.layout.paginate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        jQuery(document).ready(function ($) {
            $('.sidebar-right__list__option--follow').click(function () {
                $('.sidebar-right__list__select-follow').toggleClass('sidebar-right__list__choose-option')
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
                $('.sidebar-right__list__option--follow').append($(sortBy).html())
            } else {
                $('.sidebar-right__list__option--follow').append($('#sort-asc').html())
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

