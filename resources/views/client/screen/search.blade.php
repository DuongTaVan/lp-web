@extends('client.base.base')
@section('css')
    <style>
        .card__content__info__tt__rate__total {
            margin-left: 6px !important;
        }

        b
        .list-star > li {
            margin-left: 4px;
        }

        .list-star > li:first-child {
            margin-left: 0px;
        }

        .wrap-info {
            flex: 2;
        }

        .courses-status {
            font-size: 12px;
            line-height: 18px;
            color: #828282;
            flex: 1;
            text-align: right;
        }

        .main .sidebar-right .card {
            color: #333;
        }

        .bg-text {
            color: #4e535e;
        }

        @media only screen and (max-width: 375px) {
            .wrap-info {
                flex: 4;
            }

            .courses-status {
                font-size: 9px;
            }
        }

        @media only screen and (max-width: 414px) {
            .main {
                padding-top: 0 !important;
            }

            .main .container .row-mobile {
                margin-top: 0 !important;
            }

            .main .calendar {
                display: flex !important;
            }

            .main .sidebar-left__calendar-today {
                display: block !important;
            }

            .main .sidebar-left__clear {
                display: flex !important;
            }

            .main .sidebar-right .card__content__info__tt__date__hours {
                /*width: 100px;*/
                display: flex;
                margin-left: 3px;
            }

            .main .sidebar-right .card__content__info__tt__date__hours .hours_down {
                display: flex;
                align-items: center;
            }
        }
    </style>
@endsection
@section('content')
    <div class="main search-page">
        <div class="main-content">
            <div class="main__hidden"></div>
            <div class="container">
                <div class="row row-mobile">
                    <div class="col-12 col-md-3">
                        @include('client.layout.sidebar-left',['data' => $categories,'searchParams' => $searchParams])
                    </div>
                    <div class="col-12 col-md-9 col-list-item">
                        <div class="sidebar-right">
                            <div class="sidebar-right__header">
                                <div class="sidebar-right__header__sumtotal f-w6">
                                    <span>

                                    </span>({{!empty($data)? $data->total() : 0}}件)
                                </div>
                                <div class="sidebar-right__header__recommended f-w6">
                                </div>
                                <div class="sidebar-right__header__option dropdown-search">
                                    <div class="sidebar-right__header__option__selected" id="recommend_order">
                                        <div
                                            class="sidebar-right__header__option__selected__text selected dropdown-title">
                                            @if($searchParams['sort'] == 2)
                                                @lang('labels.search.order_date')
                                            @else
                                                @lang('labels.search.new_order')
                                            @endif
                                        </div>
                                        <div class="sidebar-right__header__option__selected__icon">
                                            <img
                                                src="{{asset('assets/img/search/icon/down.svg')}}"
                                                alt="">
                                        </div>

                                    </div>
                                    <div class="sidebar-right__header__option__list-options">
                                        <div class="sidebar-right__header__option__list-options__close">
                                            <img id="close_option" src="{{asset('assets/img/search/icon/close.svg')}}"
                                                 alt="">
                                        </div>
                                        <ul class="sidebar-right__header__option__list-options__ul sort-search">
                                            <li class="{{isset($searchParams['sort']) && $searchParams['sort'] == 2 ? 'active': ''}}"
                                                value="2"><a class="" href="javascript:void(0)">開催日順</a></li>
                                            <li class="{{isset($searchParams['sort']) && $searchParams['sort'] == 1 ? 'active': ''}}"
                                                value="1"><a class="" href="javascript:void(0)">新着順 </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-right__content">
                                <div class="search-main__option1">
                                    @forelse ($data as $item)
                                        <a class="link-item" href="">
                                            <div class="card">
                                                <div class="card__ct">
                                                    <div class="card__image">
                                                        <a href="{{empty($item->course_schedule_id)? 'javascript:void(0)' :route('client.course-schedules.detail',$item->course_schedule_id)}}"
                                                           class="image-course-href">
                                                            <img class="image-course cs-img-{{ $item->course_id }}"
                                                                 src="{{empty($item->image_url)? asset('assets/img/portal/default-image.svg'):asset($item->image_url)}}"
                                                                 alt="">
                                                        </a>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="card__content__tt">
                                                            <div class="card__content__info">
                                                                <div class="d-flex align-items-center wrap-info">
                                                                    <div class="card__content__info__avatar">
                                                                        <a href="{{!empty($item->user) && !empty($item->user->user_id)? route('client.teacher.detail',$item->user->user_id) : 'javascript:void(0)'}}"
                                                                           class="">
                                                                            <img src="{{$item->user->profile_image}}"
                                                                                 alt="" class="avatar-search">
                                                                        </a>
                                                                        <div class="card__content__info__avatar__icon">
                                                                            @if(isset($item->course->user) && !empty($item->course->user))
                                                                                @switch($item->course->user->rank_id)
                                                                                    @case(\App\Enums\DBConstant::BRONZE)
                                                                                    <img
                                                                                        src="{{ asset('assets/img/search/icon/Bronze.svg') }}"
                                                                                        class="rank-icon">
                                                                                    @break
                                                                                    @case(\App\Enums\DBConstant::SILVER)
                                                                                    <img
                                                                                        src="{{ asset('assets/img/search/icon/Silver.svg') }}"
                                                                                        class="rank-icon">
                                                                                    @break
                                                                                    @case(\App\Enums\DBConstant::GOLD)
                                                                                    <img
                                                                                        src="{{ asset('assets/img/search/icon/Gold.svg') }}"
                                                                                        class="rank-icon">
                                                                                    @break
                                                                                    @case(\App\Enums\DBConstant::PLATINUM)
                                                                                    <img
                                                                                        src="{{ asset('assets/img/search/icon/platium.svg') }}"
                                                                                        class="rank-icon">
                                                                                    @break
                                                                                    @default
                                                                                @endswitch
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="card__content__info__tt">
                                                                        <div class="card__content__info__tt__name f-w6">
                                                                            <a class="link-username"
                                                                               href="{{!empty($item->user) && isset($item->user->user_id) ?route('client.teacher.detail',$item->user->user_id) :asset('assets/img/portal/default-image.svg')}}">
                                                                                {{$item->user->full_name?? ''}}
                                                                            </a>
                                                                        </div>
                                                                        <div class="card__content__info__tt__rate">
                                                                            <div class="d-flex align-items-end">
                                                                                <div
                                                                                    class="card__content__info__tt__rate__rating d-flex align-items-end">
                                                                                    <strong
                                                                                        class="card__content__info__tt__rate__rating__sum">{{ $item->rating_custom }}</strong>
                                                                                    <ul class="card__content__info__tt__rate__rating__ul rating-star">
                                                                                        @include('client.common.show-star',['rating' =>$item->rating])
                                                                                    </ul>
                                                                                </div>
                                                                                <div
                                                                                    class="card__content__info__tt__rate__total f-w3">
                                                                                    <small
                                                                                        class="card__content__info__tt__rate__rating__number">
                                                                                        ({{ $item->num_of_ratings }})
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $user = auth()->guard('client')->user();
                                                                    $bgColor = null;
                                                                    $otherDate = null;
                                                                    $canRestock = false;
                                                                    if (empty($item['is_open']) ||
                                                                        ($item['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($item['num_of_applicants'] > 0 && $item['type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM))
                                                                    ) {
                                                                        $canRestock = true;
                                                                    }

                                                                    if (!empty($item['is_open']) && $item['is_open'] > 1){
                                                                       $otherDate = '他日程あり';
                                                                    }

                                                                    if (
                                                                        ($user && $user->user_id === $item['p_user_id'] && $item['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) ||
                                                                            ($item['num_of_applicants'] > 0 && $item['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM && $item['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
                                                                        ) {
                                                                        $bgColor = '販売終了';
                                                                    } else if ($item['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $item['user_status'] === \App\Enums\DBConstant::USER_STATUS_DEACTIVE) {
                                                                        $bgColor = 'サービス休止';
                                                                    } else if ($item['is_restock'] === true) {
                                                                        $bgColor = '開催リクエスト受付中';
                                                                    } else if ($item['is_restock'] === false && $item['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
                                                                        $bgColor = '開催終了';
                                                                    }
                                                                @endphp
                                                                <span class="f-w6 courses-status">{{ $bgColor }}</span>
                                                            </div>
                                                            <div
                                                                class="card__content__info__tt__date d-flex justify-content-start">

                                                                <div class="card__content__info__tt__date__calendar">
                                                                    <img
                                                                        src="{{asset('assets/img/search/icon/calendar.svg')}}"
                                                                        alt="">
                                                                </div>
                                                                <div class="card__content__info__tt__date__month f-w3">
                                                                    {{$item->month_day}}
                                                                </div>
                                                                <div class="card__content__info__tt__date__hours f-w3">
                                                                    <span
                                                                        class="hour_minute">{{$item->hour_minute}}</span>
                                                                    <span class="hours_down"><img
                                                                            src="{{asset('assets/img/search/icon/down-hour.svg')}}"
                                                                            alt=""> </span>
                                                                </div>

                                                                @if($item->courseSchedulesCanPurchaseOrder->count() > 0)
                                                                    <div
                                                                        class="card__content__info__tt__date__click content_date"
                                                                        data-img="{{$item->courseSchedulesCanPurchaseOrder[0]->course_schedule_id}}">
                                                                        @foreach($item->courseSchedulesCanPurchaseOrder as $courseSchedule)
                                                                            @if (!$courseSchedule->purchase_id)
                                                                                <div
                                                                                    class="card__content__info__tt__date__click__1 content_date_click"
                                                                                    data-course-id="{{$item->course_id}}"
                                                                                    data-id="{{$courseSchedule['course_schedule_id']}}">
                                                                                    <span
                                                                                        class="date f-w3">{{Carbon\Carbon::parse($courseSchedule->start_datetime)->format('m月d日')}}</span>
                                                                                    <span>({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($courseSchedule->purchase_deadline))] }})</span>
                                                                                    <span class="time f-w3">
                                                                                    @if(isset($courseSchedule->actual_start_date))
                                                                                            {{Carbon\Carbon::parse($courseSchedule->actual_start_date)->format('H:i')}}
                                                                                            - {{Carbon\Carbon::parse($courseSchedule->actual_end_date)->format('H:i')}}
                                                                                        @else
                                                                                            {{Carbon\Carbon::parse($courseSchedule->start_datetime)->format('H:i')}}
                                                                                            - {{Carbon\Carbon::parse($courseSchedule->end_datetime)->format('H:i')}}
                                                                                        @endif
                                                                                </span>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                <div class="card__content__info__price f-w6">
                                                                    <span class="dollars"><img
                                                                            src="{{asset('assets/img/search/icon/dollars.svg')}}"
                                                                            alt=""> </span>
                                                                    <span
                                                                        class="money-value-{{$item->course_id}}">¥{{number_format($item->price)}}</span>
                                                                    @if(isset($otherDate) && !isset($bgColor))
                                                                        <a style="text-decoration: none"
                                                                           href="{{empty($item->course_schedule_id)? 'javascript:void(0)' :route('client.course-schedules.detail',$item->course_schedule_id)}}"
                                                                           class="image-course-href">
                                                                            <span
                                                                                style="color: #46CB90; margin-left: 20px">{{$otherDate}}</span>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="card__content__detail">
                                                            <div
                                                                class="card__content__detail__title">{{$item['title']}}</div>
                                                            <div class="card__content__detail__content">
                                                                {!! $item['body'] !!}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        {{--                                        <p class="text-center"> @lang('labels.search.no_data')</p>--}}
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @if(!empty($data))
                            {{ $data->appends(request()->query())->links('client.layout.paginate') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/clients/modules/search.js') }}"></script>
@endsection

@section('script')
    {{--    <script src="{{asset('js/clients/modules/header.js')}}"></script>--}}
    <script>
        @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif

        function showResultTitle() {
            const timeFrame = {
                1: $('#time-frame .calendar__morning').text(),
                2: $('#time-frame .calendar__afternoon').text(),
                3: $('#time-frame .calendar__dinner').text(),
            };
            const $titleElement = $('.sidebar-right__header__sumtotal span');
            const urlSearchParams = new URLSearchParams(window.location.search);
            const params = Object.fromEntries(urlSearchParams.entries());
            let titleIndex = null;
            if (params.category_id || params.category_type) {
                titleIndex = params.category_id;
                const $bigCategory = $('.card__input-search');
                const bigCategory = [];
                $bigCategory.each(function () {
                    bigCategory.push($(this).text().trim().split("\n")[0]);
                })
                if (params.category_type) {
                    $titleElement.html(bigCategory[params.category_type - 1]);
                } else if (params.category_id) {
                    const $listSearch = $('.card__list-search');
                    const listSearch = [];
                    const breakPoint = [0];
                    $listSearch.each(function () {
                        $(this).find('li').each(function (index) {
                            listSearch.push($(this).text().trim())
                        })

                    })
                    if (params.category_id <= 13) {
                        $titleElement.html(`${bigCategory[0]} - ${listSearch[params.category_id - 1]}`);
                    } else if (params.category_id > 13 && params.category_id <= 22) {
                        $titleElement.html(`${bigCategory[1]} - ${listSearch[params.category_id - 1]}`);
                    } else {
                        $titleElement.html(`${bigCategory[2]} - ${listSearch[params.category_id - 1]}`);
                    }
                }
            } else if (params.start_date && params.time_frame) {
                $titleElement.html(`${timeFrame[params.time_frame]} - ${params.start_date} の検索結果`);
            } else if (params.start_date) {
                $titleElement.html(`${params.start_date} の検索結果`);
            } else if (params.time_frame) {
                $titleElement.html(`${timeFrame[params.time_frame]} の検索結果`);
            } else {
                $titleElement.html(params.keyword);
            }
        }

        showResultTitle();

        document.body.addEventListener('mouseup', function (e) {
            if (e.target.closest('.dropdown-search') === null) {
                let selectBox = document.querySelectorAll('.sidebar-right__header__option__list-options')
                selectBox[0].style.display = "none";
            }
        });
    </script>
    <script>
        $(function () {
            $('body').on('click', '.content_date_click', function (e) {
                let date = $(this).children()[0];
                let time = $(this).children()[2];
                let $this = $(this);
                if (e.currentTarget.parentElement.parentElement.querySelector(".hour_minute")) {
                    e.currentTarget.parentElement.parentElement.querySelector(".hour_minute").innerHTML = time.textContent.trim();
                }
                if (e.currentTarget.parentElement.parentElement.parentElement.querySelector(".card__content__info__tt__date__month")) {
                    e.currentTarget.parentElement.parentElement.parentElement.querySelector(".card__content__info__tt__date__month").innerHTML = date.textContent.trim();
                }
                let id = $(this).data('id');
                let courseId = $(this).data('course-id');
                let img = $(this).parent().data('img');
                let href = '/course-schedules/' + id + '/detail';
                $(this).closest('.card__ct').find('.image-course-href').attr("href", href);
                $('.image-course-href').attr("href", href);
                let route = '/course-schedules/' + id + '/detail-status';
                $.ajax({
                    url: route,
                    type: "GET"
                }).then(function (res) {
                    $this.closest(".card__ct").find('.card__content__detail__title').html(res.title);
                    $this.closest(".card__ct").find('.card__content__detail__content').html(res.body);
                    $('.cs-img-' + courseId).attr('src', res.image_url);
                    $('.money-value-' + courseId).html('¥' + res.price);
                })
            });
        });
    </script>
@endsection
