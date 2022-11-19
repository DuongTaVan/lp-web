{{--custom slider--}}
<div class="block-slider">
    <div class="slider-outer lappi-slider{{ $index }}">
        <div class="lappi-slider">
            @foreach($items as $key => $item)
                <a class="card" href="{{ route('client.course-schedules.detail', $item["course_schedule_id"]) }}">
                    <div class="card__image">
                        <div class="link-item">
                            <img class="link-item__image"
                                 src="{{asset($item['thumbnail'])}}"
                                 alt="">
                        </div>
                        @if($key<\App\Enums\Constant::NUMBER_RANKING_IMAGE && $type === 'POPULAR')
                            <div class="ranking-view">
                                <img src="{{asset('assets/img/top/ranking' . $key . '.svg')}}" alt="">
                            </div>
                        @endif
                    </div>
                    <div class="card__content">
                        <div class="card__content__title f-w6" title="{{$item['title']??null}}">
                            <div>{{$item['title']??null}}</div>
                        </div>
                        <div class="card__content__author" data-teacherId="{{ $item['user_id'] }}">
                            <div class="card__content__author__avatar">
                                <div class="link-item">
                                    <img class="default-avatar"
                                         src="{{asset($item['profile_thumbnail'])}}"
                                         alt="">
                                </div>
                            </div>
                            <div class="card__content__author__name f-w3"
                                 title=" {{$item['full_name']}}">
                                <div class="link-item">
                                    {{$item['full_name']}}
                                </div>
                            </div>
                        </div>
                        <div class="card__content__rate">
                            <div class="card__content__rate__sum-rating f-w6">
                                {{$item['rating_custom']}}
                            </div>
                            <div class="card__content__rate__rating">
                                <ul class="card__content__rate__rating__list-rating">
                                    @include('client.common.show-star', ['rating' => $item['rating_custom']])
                                </ul>
                            </div>
                            <div class="card__content__rate__sum-rate f-w3">
                                ({{number_format($item['num_of_ratings'])}})
                            </div>
                        </div>

                        @php
                            $bgColor = '';
                            $canRestock = false;

                            if ($type === 'POPULAR') {
                                if (isset($item['closeAll']) ||
                                    ((isset($item['count_open']) && $item['count_open'] === 1) && ($item['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($item['num_of_applicants'] > 0 && $item['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM))) ||
                                    (($item['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) && ($item['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($item['num_of_applicants'] > 0 && $item['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM)))
                                    ) {
                                    $canRestock = true;
                                    $bgColor = 'bg-green';
                                }
                            } else {
                                if (empty($item['count_open']) ||
                                    (($item['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($item['num_of_applicants'] > 0 && $item['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM)))
                                ) {
                                    $canRestock = true;
                                    $bgColor = 'bg-green';

                                }
                            }

                            if ($user && $user->user_id === $item['p_user_id'] && $item['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
                                $bgColor = 'bg-blue';
                            } else if ($item['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $item['user_status'] === \App\Enums\DBConstant::USER_STATUS_DEACTIVE) {
                                $bgColor = 'bg-grey';
                            } else if ($item['is_restock'] === true) {
                                $bgColor = 'bg-green';
                            } else if ($item['is_restock'] === false && $item['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
                                $bgColor = 'bg-red';
                            }

                            if ($type === 'POPULAR') {
                                $bgColor = '';
                               $canRestock = false;
                               if (isset($item['closeAll']) ||
                                   ((isset($item['count_open']) && $item['count_open'] === 1) && ($item['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($item['num_of_applicants'] > 0 && $item['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM))) ||
                                   (($item['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) && ($item['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($item['num_of_applicants'] > 0 && $item['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM)))
                               ) {
                                   $canRestock = true;
                                   $bgColor = 'bg-green';
                               }
                               if ($user && $user->user_id === $item['p_user_id'] && empty($item['closeAll'])) {
                                   $bgColor = 'bg-blue';
                               } else if ((!$user && $item['user_status'] === \App\Enums\DBConstant::USER_STATUS_DEACTIVE) || ($item['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $item['user_status'] === \App\Enums\DBConstant::USER_STATUS_DEACTIVE)) {
                                   $bgColor = 'bg-grey';
                               } else if ($canRestock) {
                                   $bgColor = 'bg-green';
                               } else if (($item['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) && empty($item['closeAll'])) {
                                   $bgColor = 'bg-red';
                               }

                               if (!empty($item['count_open']) && $item['count_open'] > 1){
                                    $bgColor = '他日程あり';
                               }
                            } else {
                                if (!empty($item['count_open']) && $item['count_open'] > 1) {
                                     // $bgColor = '他日程あり';
                                     if ($item['countLoginPurchased'] === 0) {
                                        $bgColor = 'bg-blue';
                                    } else if ($item['countLoginPurchased'] === 1) {
                                        $bgColor = '';
                                    } else {
                                        $bgColor = '他日程あり';
                                    }
                                }
                            }
                        @endphp
                        @if ($bgColor === '他日程あり')
                            <div class="card__content__calendar">
                                <div class="card__content__calendar__icon">
                                    <img src="{{asset('assets/img/top-log/icon/calendar.svg')}}"
                                         alt="">
                                </div>
                                <div class="card__content__calendar__date f-w3">{{$item['month_day']}}</div>
                                <div class="card__content__hours f-w3">{{$item['hour_minute']}}</div>
                            </div>

                            <div class="card__content__price f-w6">
                                <img src="{{asset('assets/img/icons/dollar1.svg')}}" alt="" class="icon-dollar">
                                ¥{{number_format($item['price'], 0, ',', ',')}}
                                <span style="color: #46CB90; margin-left: 20px">他日程あり</span>
                            </div>
                        @endif
                        @if ($bgColor === '')
                            <div class="card__content__calendar">
                                <div class="card__content__calendar__icon">
                                    <img src="{{asset('assets/img/top-log/icon/calendar.svg')}}"
                                         alt="">
                                </div>
                                <div class="card__content__calendar__date f-w3">
                                    {{$item['month_day']}}
                                </div>
                                <div class="card__content__hours f-w3">
                                    {{$item['hour_minute']}}
                                </div>
                            </div>
                            <div class="card__content__price f-w6">
                                <img src="{{asset('assets/img/icons/dollar1.svg')}}"
                                     alt="" class="icon-dollar">
                                ¥{{number_format($item['price'])}}
                            </div>
                        @else
                            <div class="card__content__flagged">
                                <span class="f-w6">
                                    @if ($bgColor === 'bg-grey')
                                        サービス休止
                                    @elseif ($bgColor === 'bg-blue')
                                        販売終了
                                    @elseif ($bgColor === 'bg-green')
                                        開催リクエスト受付中
                                    @elseif ($bgColor === 'bg-red')
                                        開催終了
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="lappi-slider__button iconBack iconBack{{ $index }}">
        <img class="swiper-button-next{{ $index }}" src="{{asset('assets/img/top/back.svg')}}" alt="">
    </div>
    <div class="lappi-slider__button iconNext iconNext{{ $index }}">
        <img class="swiper-button-prev{{ $index }}" src="{{asset('assets/img/top/next.svg')}}" alt="">
    </div>
</div>

<script>
    $('.lappi-slider{{ $index }}').lappiSlider({
        btnNext: 'iconNext{{ $index }}',
        btnPrev: 'iconBack{{ $index }}',
        loop: true
    });
    @if($loop)
    if ($(window).width() < 768) {
        $('.lappi-slider{{ $index }}').on('scroll', function () {
            const maxWidth = $('.lappi-slider').width() - 228 - $('.lappi-slider{{ $index }}').width()

            if ($('.lappi-slider{{ $index }}').scrollLeft() === maxWidth + 228) {
                $('.lappi-slider{{ $index }}').scrollLeft(0)
            }
        })
    }
    @endif
</script>
