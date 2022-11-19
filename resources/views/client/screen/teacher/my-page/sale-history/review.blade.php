@extends('client.base.base')
@section('css')
    <style>
        .row {
            margin-right: unset;
            margin-left: unset;
        }

        .col-sm-9 {
            padding-right: 0;
            padding-left: 30px;
        }

        .option_tab {
            min-width: 100px;
            position: relative;
        }

        .option_tab_select {
            position: absolute;
            top: -15px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__navbar-order-list {
            margin-top: 5px;
        }

        .content-review {
            word-break: break-all;
        }

        @media only screen and (max-width: 767px) {
            .main-mypage-teacher__content.sale-history-review .teacher-sidebar-right__table {
                white-space: unset !important;
            }
        }

        @media only screen and (max-width: 414px) {
            .col-sm-9 {
                padding-right: 15px;
                padding-left: 15px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="sidebar-left">
            @include('client.screen.teacher.my-page.sidebar-left')
        </div>
        <div class="content-mypage">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="main-mypage-teacher__content sale-history-review">
                <div class="teacher-sidebar-right service-list-draft">
                    <div class="teacher-sidebar-right__title">
                        <div class="teacher-sidebar-right__title__text">
                            @lang('labels.sidebar-left.sales_history') <img
                                    src="{{asset('assets/img/common/arrow-breadcrumb.svg')}}"
                                    style="margin: 0 7px 0 10px; position: relative; top: -3px" alt="Image"> レビュー
                        </div>

                    </div>
                    <div class="teacher-sidebar-right__navbar-order-list d-flex justify-content-between">
                        <div class="teacher-sidebar-right__navbar-order-list__flex">
                            <div class="teacher-sidebar-right__navbar-order-list__cancel f-w6 active">@lang('labels.sale-history.review_list')</div>
                        </div>
                        <a href="{{route('client.teacher.sale')}}"
                           class="teacher-sidebar-right__title__text review-right-text">
                            @lang('labels.service-list-draft.back_to')
                        </a>
                    </div>
                    <div class="teacher-sidebar-right__center">
                        <div class="service-amount d-flex justify-content-between">
                            @if(count($reviews)>0)
                                <div class="d-flex">
                                    <img class="service-img" src="{{$reviews[0]->image_course}}"
                                         alt="">
                                    <div class="service-title-name">
                                        <span class="service-title-name__title"
                                              title="{{$reviews[0]->title}}">{{$reviews[0]->title}}</span>
                                        <div class="service-describe">
                                            <div class="service-datetime d-flex">
                                                <span class="service-date f-w3">{{Carbon\Carbon::parse($reviews[0]->start_datetime)->format('Y/m/d')}}</span>
                                                <span class="service-time f-w3">{{Carbon\Carbon::parse($reviews[0]->start_datetime)->format('H:i')}} - {{Carbon\Carbon::parse($reviews[0]->end_datetime)->format('H:i')}}</span>
                                            </div>
                                            <span class="service-money">
                                                ¥{{$reviews[0]->price}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(count($reviews)>0)
                                @include('client.common.option-search')
                            @endif
                        </div>
                    </div>
                    <div class="teacher-sidebar-right__table review_teacher_content">
                        @if(count($reviews)>0)
                            @foreach($reviews as $review)
                                <div class="teacher-sidebar-right__table__review-block">
                                    <div class="teacher-sidebar-right__table__review-block__avatar">
                                        @if($review->is_public === \App\Enums\DBConstant::PUBLIC_INFO )
                                            <img src="{{$review->profile_thumbnail}}"
                                                 alt=""
                                                 width="55" height="55">
                                        @else
                                            <img src="{{asset('assets/img/clients/header-common/not-login.svg')}}"
                                                 alt=""
                                                 width="55" height="55">
                                        @endif
                                        <div class="title_img">
                                            @if($review->sex == 1)
                                                <h6>男性 {{$review->current_age - $review->current_age%10}}代</h6>
                                            @elseif($review->sex == 2)
                                                <h6>女性 {{$review->current_age - $review->current_age%10}}代</h6>
                                            @elseif($review->sex == 9)
                                                <h6>その他 {{$review->current_age - $review->current_age%10}}代</h6>
                                            @else
                                                <h6>{{$review->current_age - $review->current_age%10}}代</h6>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="teacher-sidebar-right__table__review-block__review">
                                        <div class="header-right__menu__notification__triangle-up"></div>
                                        <div class="title"> @if($review->is_public === 1)
                                                {{$review->full_name}}
                                            @else
                                                <strong>購入者さん</strong>
                                            @endif
                                        </div>
                                        <div class="rating">
                                            @include('client.common.show-star',['rating'=>$review->rating])
                                            <span class="mr-2 mt-auto mb-auto">@if($review->rating>5)
                                                    5 @else{{$review->rating}}@endif</span>
                                        </div>
                                        <div class="content">
                                            <div class="content-review">{{$review->comment}}</div>
                                        </div>
                                        <div class="info-review">
                                            <div class="event-date">投稿日</div>
                                            <div class="date"
                                                 style="margin-left: 16px; font-size: 14px; font-weight: 300">{{Carbon\Carbon::parse($review->created_at)->format('Y/m/d')}}</div>
                                            <div class="time"
                                                 style="margin-left: 12px;font-size: 14px; font-weight: 300"> {{Carbon\Carbon::parse($review->created_at)->format('H:i')}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if(!empty($reviews))
                        {{$reviews->appends(request()->query())->links('client.layout.paginate') }}
                    @endif
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
