@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .main {
            background: #fff !important;
        }

        .calendar-order-detail {
            margin-top: 5px;
        }

        .sidebar-right__content-detail__info__sum__calendar__icon {
            margin-bottom: 5px;
        }

        .sidebar-right__content-detail__info__sum__calendar__icon > img {
            width: 12px;
            height: 13px;
        }

        .title-content-order-detail {
            margin-top: 5px;
        }

        .sidebar-right__content-detail__info__sum__calendar .price {
            margin-right: 108px;
        }

        @media only screen and (max-width: 414px) {
            .sidebar-right__content-detail__info__sum__calendar .price {
                margin-right: unset;
            }
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-wrapper purchase custom-dashboard custom-purchase">
        @include('client.student-mypage.sidebar-left')
        <div class="main_content order-detail">
            {{-- <!-- @include('client.common.dashboard-role') --> --}}
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="sidebar-right">
                <div class="col-md-12 d-flex justify-content-start purchase_head">
                    <div class="purchase_title purchase_title--breadcrumb f-w6">
                        <div class="sidebar-right__title-detail__left__text">
                            @lang('labels.order-detail.purchase_history')
                        </div>
                        <div class="sidebar-right__title-detail__left__larger">
                            &gt;
                        </div>
                        <div class="sidebar-right__title-detail__text2">
                            @lang('labels.order-detail.payment_details')
                        </div>
                    </div>
                </div>
                <div class="sidebar-right__content-detail">
                    @if($course)
                        <div class="sidebar-right__content-detail__info">
                            <div class="sidebar-right__content-detail__info__image">
                                <img class="" src="{{ $course->thumbnail }}"
                                     width="196" height="186" alt="">
                            </div>
                            <div class="sidebar-right__content-detail__info__sum">
                                <div class="sidebar-right__content-detail__info__sum__user">
                                    <div class="sidebar-right__content-detail__info__sum__user__avatar">
                                        <div class="sidebar-right__content-detail__info__sum__user__avatar__user">
                                            <img src="{{ $course->profile_image }}" height="63"
                                                 alt="">
                                        </div>
                                        <div class="sidebar-right__content-detail__info__sum__user__avatar__appellation">
                                            @switch($course->rank_id)
                                                @case(\App\Enums\DBConstant::BRONZE)
                                                    <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                @case(\App\Enums\DBConstant::SILVER)
                                                    <img src="{{ asset('assets/img/search/icon/Silver.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                @case(\App\Enums\DBConstant::GOLD)
                                                    <img src="{{ asset('assets/img/search/icon/Gold.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                @case(\App\Enums\DBConstant::PLATINUM)
                                                    <img src="{{ asset('assets/img/search/icon/platium.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>

                                    </div>
                                    <div class="sidebar-right__content-detail__info__sum__user__if">
                                        <div class="sidebar-right__content-detail__info__sum__user__if__name">{{ $course->course->user->full_name }}</div>
                                        <div class="sidebar-right__content-detail__info__sum__user__if__rate">
                                            <div class="sidebar-right__content-detail__info__sum__user__if__rate__total">
                                                {{ $course->rating >= 5 ? 5 : ratingProcess($course->rating) }}
                                            </div>
                                            <div class="sidebar-right__content-detail__info__sum__user__if__rate__rating">
                                                <ul class="card__content__rate__rating__list-rating">
                                                    @include('client.common.show-star', ['rating' => ratingProcess($course->rating)])
                                                </ul>
                                            </div>
                                            <div class="sidebar-right__content-detail__info__sum__user__if__rate__review ">
                                                ({{ $course->num_of_ratings }})
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sidebar-right__content-detail__info__sum__calendar calendar-order-detail">
                                    <div class="sidebar-right__content-detail__info__sum__calendar__icon">
                                        <img src="{{asset('assets/img/student/my-page/icon/calendar.svg')}}" alt="">
                                    </div>
                                    <div class="sidebar-right__content-detail__info__sum__calendar__day ml-1">
                                        {{ $course->start_datetime->format('m') }}
                                        月{{ $course->start_datetime->format('d') }}日
                                    </div>
                                    <div class="sidebar-right__content-detail__info__sum__calendar__hour">
                                        @if(isset($course->actual_start_date))
                                            {{ $course->actual_start_date->format('H:i') }}
                                            - {{ $course->actual_end_date->format('H:i') }}
                                        @else
                                            {{ $course->start_datetime->format('H:i') }}
                                            - {{ $course->end_datetime->format('H:i') }}
                                        @endif
                                    </div>
                                    <div class="price">
                                        <img src="{{asset('assets/img/icons/dollar1.svg')}}"
                                             alt="" class="icon-dollar">
                                        ¥{{ number_format($course->price) }}
                                    </div>
                                </div>
                                <div class="sidebar-right__content-detail__info__sum__title">
                                    <div class="title-content-order-detail">
                                        {{ $course->title }}
                                    </div>
                                </div>
                                <div class="sidebar-right__content-detail__info__sum__body-order-detail">
                                    {!! $course->body !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="sidebar-right__content-detail__list-gift">
                        <table class="list-gift">
                            <tr class="header">
                                <td>項目</td>
                                <td>数量</td>
                                <td>金額（税込)</td>
                            </tr>
                            <tr class="body">
                                <td class="text-center">サービス</td>
                                <td>1</td>
                                <td>¥{{ number_format($course ? $course->price : 0) }}</td>
                            </tr>
                            @php $totalGift = 0;  $totalAmount = 0; @endphp
                            @if(isset($purchaseDetail))
                                @foreach($purchaseDetail as $item)
                                    <tr class="body">
                                        @if($item->item === \App\Enums\DBConstant::PURCHASE_ITEM_EXTENSION)
                                            <td>{{ $item->minutes_required }}分</td>
                                        @elseif($item->item === \App\Enums\DBConstant::PURCHASE_ITEM_OPTION)
                                            <td>{{ $item->option_title }}</td>
                                        @elseif($item->item === \App\Enums\DBConstant::PURCHASE_ITEM_GIFT)
                                            <td>{{ $item->gift_name }}</td>
                                        @elseif($item->item === \App\Enums\DBConstant::PURCHASE_ITEM_QUESTION)
                                            <td>挙手</td>
                                        @endif
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            ¥{{ number_format($item->total_amount) }}</td>
                                    </tr>
                                    @php
                                        $totalGift += $item->quantity;
                                        $totalAmount += $item->total_amount;
                                    @endphp
                                @endforeach
                            @endif

                            <tr class="footer">
                                <td>合計</td>
                                <td>{{ number_format($totalGift + 1) }}</td>
                                <td>¥{{ number_format($totalAmount + ($course ? $course->price : 0)) }}</td>
                            </tr>
                        </table>
                        <div class="action-back">
                            <a class="btn" href="{{ route('client.student.my-page.list') }}">戻る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
