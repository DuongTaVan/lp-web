@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="titter:title" content="{{ $result['courses']['title'] ?? null }}"/>
    <meta property="titter:image" content="{{ $result['images'][0] ?? asset('assets/img/portal/default-image.svg') }}"/>
    <meta property="titter:description" content="{{ $result['courses']['body'] }}"/>
    <meta property="og:title" content="{{ $result['courses']['title'] ?? null }}"/>
    <meta property="og:image" content="{{ $result['images'][0] ?? asset('assets/img/portal/default-image.svg') }}"/>
    <meta property="og:description" content="{{ $result['courses']['body'] }}"/>
    <meta name="description" content="{{ $result['courses']['body'] }}">
    <title>{{ $result['courses']['title'] }}</title>
@endsection
@section('css')
    <link href="{{ mix('css/clients/home-private.css') }}" rel="stylesheet">
    <link href="{{ mix('css/clients/modules/livestream.css')}}" rel="stylesheet">
    <style>
        body {
            font-family: unset;
        }

        .word-break p {
            color: #666 !important;
        }

        .f-w6 {
            font-weight: bold !important;
        }

        #course-detail .content .sidebar-right .card__content__price {
            font-weight: unset !important;
        }

        #course-detail .content .sidebar-right .card__content__price span {
            font-weight: 600;
        }

        .bx-wrapper {
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 0;
            margin-bottom: 0;
        }

        .bx-wrapper img {
            border-radius: 5px;
        }

        #course-detail .content .sidebar-right .card__content__title div {
            font-weight: 300;
        }

        .purchase-deadline {
            margin-left: 84.4px;
            font-weight: 400;
            font-size: 12px;
            color: rgba(42, 50, 66, 0.53);
            line-height: 18px;
        }

        #course-detail .content .content-description .description-title {
            color: #111;
        }

        #course-detail .content .content-description .sub-description-title p {
            color: #666;
        }

        #course-detail .content .content-description .menu-evaluation__title {
            font-weight: bold;
        }

        #course-detail .content .content-description .rectangle-div__about-content .word-break, #course-detail .content .content-description .rectangle-div__flow-day .word-break, #course-detail .content .content-description .rectangle-div__using .word-break, #course-detail .content .content-description .rectangle-div__option .word-break {
            font-size: 14px;
        }

        #course-detail {
            margin: 0 auto;
            padding: 0 20px;
            max-width: 1080px;
        }

        .course-detail-list {
            padding: 0 163px 0 20px !important;
        }

        #course-detail .content .col9 {
            max-width: 74.5%;
        }

        .family img {
            cursor: pointer;
            object-fit: contain !important;
        }

        #course-detail .content .content-description .family img {
            height: auto;
        }

        .three-image img {
            cursor: pointer;
            max-width: 215px;
        }

        .family-animation {
            display: block;
            -webkit-animation: fadeInFromNone 0.5s ease-out;
            -moz-animation: fadeInFromNone 0.5s ease-out;
            -o-animation: fadeInFromNone 0.5s ease-out;
            animation: fadeInFromNone 0.5s ease-out;
        }

        a.disabled {
            pointer-events: none;
            cursor: default;
        }

        .all-img {
            display: flex;
            margin: 10px 0 20px;
        }

        #course-detail .content .content-description .three-image img {
            margin: 0 0 5px 0;
        }

        #course-detail .content .content-description .three-image {
            margin-left: 10px;
        }

        #course-detail .content .content-description .family {
            margin: unset;
        }

        #course-detail .content .content-description .three-image img {
            width: 95px;
            height: 70px;
        }

        #course-detail .content .content-table .facebook {
            margin-right: 5px;
        }

        #course-detail .content .content-table .tweeter {
            margin-right: 5px;
        }

        @-webkit-keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }

            1% {
                display: block;
                opacity: 0;
            }

            100% {
                display: block;
                opacity: 1;
            }
        }

        @-moz-keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }

            1% {
                display: block;
                opacity: 0;
            }

            100% {
                display: block;
                opacity: 1;
            }
        }

        @-o-keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }

            1% {
                display: block;
                opacity: 0;
            }

            100% {
                display: block;
                opacity: 1;
            }
        }

        @keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }

            1% {
                display: block;
                opacity: 0;
            }

            100% {
                display: block;
                opacity: 1;
            }
        }

        @media only screen and (max-width: 767px) {
            #course-detail .content .col9 {
                max-width: 100%;
            }

            .block-slider .slider-outer .lappi-slider a.card {
                height: 315px;
            }

            .course-detail-list {
                padding: 0 20px !important;
            }

            .purchase-deadline {
                margin-left: 68px;
            }
        }

        .dist-method {
            display: block;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 5px;
        }

        .price-restock {
            margin: 0 12px 0 16px;
            color: #4E5768;
        }

        .price-restock-sp {
            font-weight: bold;
            font-size: 12px;
        }

        .price-font-sp {
            font-size: 10px;
        }

        .dist-method-sp {
            display: block;
            text-align: center;
            padding-top: 5px;
            font-size: 10px;
        }

        #loading-overlay {
            background-color: unset !important;
        }

        .rectangle-course-schedule {
            background: #F3F3F3;
            border-radius: 5px;
            height: 70px;
            margin-bottom: 5px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            cursor: pointer;
        }

        .icon-arrow {
            right: 18px;
        }

        #course-detail .content .content-table .Admission-fee .choose-option.active, #course-detail .content .content-table .Admission-fee .choose-option.show .icon-arrow {
            display: none;
        }
    </style>
@endsection
@section('lib-js')
    <script src="/js/lappi-slider.js"></script>
@endsection
@section('content')
    @php
        $user = auth()->guard('client')->user()
    @endphp
    @if (session('success') !== null)
        <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
    @endif
    @if (session('error') !== null)
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    <div id="course-detail">
        <div class="content">
            <input id="course_schedule_id" value="{{ $courseScheduleId }}" type="hidden">
            <input id="course_id" value="{{ $result['courses']['course_id'] }}" type="hidden">
            <input id="currentPage" value="1" type="hidden">
            <div class="row-course">
                <div class="col9 content-description">
                    <p class="description-title f-w6 text-left">{{ $result['courseSchedule']['title'] ?? null }}</p>
                    <div class="sub-description-title text-left">{!! $result['courseSchedule']['subtitle'] ?? null !!} </div>
                    <div class="rating position-relative d-flex justify-content-between align-items-start rating-app">
                        <div class=" rating-position d-flex">
                            <ul class="content-rating d-flex">
                                @include('client.common.show-star', ['rating' => ratingProcess($result['courses']['rating'])])
                            </ul>
                            <div class="rating__star">
                                <span
                                        class="average">{{ $result['courses']['rating'] >= 5 ? 5 : bcdiv($result['courses']['rating'],1,1)}}</span>
                                <span
                                        class="votes">({{number_format($result['courses']['num_of_ratings'] ?? null)}})</span>
                            </div>
                        </div>

                        <div class="rating__information d-flex justify-content-end align-items-end">
                            @if(isset($result['courses']->category->type) && $result['courses']->category->type === 1)
                                <div class="holding">
                                    <img src="{{asset('assets/img/clients/course-detail/holding.svg')}}" alt="">
                                    <span>開催実績 <span
                                                style="color: #111111; margin-left: 0; font-size: 14px; font-weight: bold">({{number_format($result['countHoldingCourseSchedule'])}})</span></span>
                                </div>
                            @endif
                            <div class="user">
                                <img src="{{asset('assets/img/clients/course-detail/users.svg')}}" alt="">
                                <span>利用者数 <span
                                            style="color: #111111; margin-left: 0; font-size: 14px; font-weight: bold">({{number_format($result['countApplicants'])}})</span></span>
                            </div>
                            <div class="like">
                                <img src="{{asset('assets/img/clients/course-detail/like.svg')}}" alt="">
                                <span>フォロワー <span
                                            style="color: #111111; margin-left: 0; font-size: 14px; font-weight: bold">({{number_format($result['countFollower'])}})</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="explain-content">
                        <div class="all-img">
                            <div class="family">
                                <img src="{{ $result['images'][0] }}" alt="">
                            </div>
                            <div
                                    class="three-image @if(count($result['images']) === 4) justify-content-between @endif">
                                @if(count($result['images']) > 0)
                                    @foreach(range(0, count($result['images']) - 1) as $item)
                                        <div class="three-image__item">
                                            <img src="{{ $result['images'][$item] }}" alt="">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{--Slider image sp--}}
                        <div class="family-app">
                            <ul class="bxslider">
                                {{--                                <div class="swiper-wrapper">--}}
                                @foreach($result['images'] as $item)
                                    <li>
                                        <img src="{{ $item ?? asset('assets/img/portal/default-image.svg') }}"
                                             alt="">
                                    </li>
                                @endforeach
                                {{--                                </div>--}}
                            </ul>
                            <section class="paginate-swiper">
                                <div class="swiper-pagination family-app__paginate"></div>
                            </section>
                        </div>
                        <!--End Slider image sp-->

                        {{--seller-profile-app--}}
                        <div>
                            <div class="content-table">

                                <div class="seller-profile seller-profile-app">
                                    <a href="{{route('client.teacher.detail', ['user_id' => $result['courses']->user->user_id])}}"
                                       class="seller-profile__header position-relative">
                                        <p class="seller-profile__header--title">@lang('labels.course-detail.seller_profile')</p>
                                        <div class="d-flex justify-content-between align-items-center mb-10">
                                            <div class="d-flex">
                                                <div class="seller-avt-wrapper">
                                                    @if(isset($result['courses']))
                                                        <img class="seller-avt" alt=""
                                                             src="{{ $result['courses']->user->profile_thumbnail }}">
                                                    @else
                                                        <img class="seller-avt" alt="画像エラー">
                                                        <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}"
                                                             class="rank-icon">
                                                    @endif
                                                    @switch($result['courses']->user->rank_id)
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
                                                @if(isset($result['courses']))
                                                    <div class="d-flex flex-column">
                                                        <p class="seller-profile__header--cat">{{ $result['courses']->user->full_name }}</p>
                                                        @if($result['courses']['is_mask_required'] === 0)
                                                            <div class="formality fs-12 f-w6">
                                                                @lang('labels.course-detail.formality')
                                                                <span>(OK)</span>
                                                            </div>
                                                        @else
                                                            <div class="formality fs-12 fw-600">
                                                                @lang('labels.course-detail.formality')
                                                                <span class="fs-12 fw-600">(NG)</span>
                                                                <span class="lappi-ar fw-300">※Lappi ARエフェクト</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <img src="{{ asset('assets/img/search/icon/view-profile.svg') }}"
                                                 class="rank-icon">
                                        </div>
                                        <img class="arrow-right position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}"
                                             alt="">
                                    </a>
                                    @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS && $result['courses']->user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                        <div class="d-flex flex-wrap justify-content-start">
                                            <div
                                                    class="identification d-flex justify-content-center align-items-center position-relative">
                                                <div
                                                        class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                                <img
                                                        class="icon-identification icon-identification__mobile position-absolute"
                                                        src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                                        alt="">
                                                <button
                                                        class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                                <img class=" icon-tick icon-tick__mobile position-absolute"
                                                     src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                     alt="">
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            @if($result['courses']->user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                                <div class="identification d-flex justify-content-center align-items-center position-relative">
                                                    <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                                    <img class="icon-identification icon-identification__mobile position-absolute"
                                                         src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                                         alt="">
                                                    <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                                    <img class=" icon-tick icon-tick__mobile position-absolute icon-nondisclosure-agreement icon-nondisclosure-agreement__mobile"
                                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                         alt="">
                                                </div>
                                            @endif
                                            @if($result['courses']->user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING && $result['courses']->user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                                <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative nda">
                                                    <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                                    <img class="position-absolute icon-nondisclosure-agreement icon-nondisclosure-agreement__mobile"
                                                         src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                                         alt="">
                                                    <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                                    <img class=" icon-tick icon-tick__mobile position-absolute"
                                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                         alt="">
                                                </div>
                                            @endif
                                            @if($result['courses']->user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION && $result['courses']->user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                                <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative">
                                                    <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                                    <img class="position-absolute icon-nondisclosure-agreement icon-qualification-mobile"
                                                         src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                                         alt="">
                                                    <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                                    <img class=" icon-tick icon-tick__mobile position-absolute"
                                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                         alt="">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="d-flex flex-wrap">
                                        <div
                                                class="question question__mobile d-flex justify-content-center align-items-center position-relative">
                                            <img class="icon-question icon-question__mobile position-absolute"
                                                 src="{{asset('assets/img/clients/course-detail/question.svg')}}"
                                                 alt="">
                                            @if(auth('client')->check())
                                                @if(auth('client')->id() === $result['courses']->user->user_id)
                                                    <a href="#"
                                                       class="btn-question disabled text-center">@lang('labels.course-detail.question_course')</a>
                                                @else
                                                    <a href="{{route('client.student.message.message-detail', ['courseScheduleId' => $courseScheduleId, 'redirect' => 'course-detail', 'restock' => $result['enabled_request_restock'] ? 'true' : 'false'])}}"
                                                       class="btn-question text-center @if(now()->subHour(48)->format('Y-m-d H:i:s') > now()->parse($result['courseSchedule']['end_datetime'])->format('Y-m-d H:i:s')) disabled @endif">@lang('labels.course-detail.question_course')</a>
                                                @endif
                                            @else
                                                <button data-toggle="modal" data-target="#modalLogin"
                                                        class="btn-question">@lang('labels.course-detail.question_course')</button>
                                            @endif
                                        </div>
                                        @if(auth('client')->check())
                                            <div
                                                    class="follow-us follow-us__mobile d-flex justify-content-center align-items-center position-relative">
                                                <button type="button" data-toggle="modal" data-target="#modal-follow"
                                                        class="btn-follow-us ">@lang('labels.course-detail.follow_course')
                                                </button>
                                                <img class="icon-follower icon-follower__mobile position-absolute"
                                                     src="{{asset('assets/img/clients/course-detail/follower.svg')}}"
                                                     alt="">
                                            </div>
                                        @else
                                            <div
                                                    class="follow-us follow-us__mobile d-flex justify-content-center align-items-center position-relative">
                                                <button type="button" data-toggle="modal" data-target="#modalLogin"
                                                        class="btn-follow-us ">@lang('labels.course-detail.follow_course')
                                                </button>
                                                <img class="icon-follower icon-follower__mobile position-absolute"
                                                     src="{{asset('assets/img/clients/course-detail/follower.svg')}}"
                                                     alt="">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="seller-profile__footer position-relative d-none">
                                        @if (isset($result['courses']->user->catchphrase))
                                            <p class="seller-profile__footer__catchphrase">{{$result['courses']['catchphrase']}}</p>
                                            <div class="position-absolute see-all">
                                                <span></span>
                                                <img class="arrow-down"
                                                     src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}"
                                                     alt="">
                                            </div>
                                        @else
                                            <span
                                                    class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="seller-social-app">
                                    <div class="w-100 d-flex justify-content-between ">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}`"
                                           class="facebook d-flex align-items-center justify-content-center">
                                            <img src="{{asset('assets/img/clients/course-detail/fb.svg')}}" alt="">
                                            <span>@lang('labels.course-detail.share_course')</span>
                                        </a>
                                        <a href="https://twitter.com/share?text=&url={{url()->current()}}"
                                           class="tweeter d-flex align-items-center justify-content-center">
                                            <img src="{{asset('assets/img/clients/course-detail/tw.svg')}}" alt="">
                                            <span>@lang('labels.course-detail.tweet_course')</span>
                                        </a>
                                        <a href="https://social-plugins.line.me/lineit/share?url={{url()->current()}}"
                                           class="line d-flex align-items-center justify-content-center">
                                            <img src="{{asset('assets/img/clients/course-detail/line.svg')}}" alt="">
                                            <span>@lang('labels.course-detail.line_course')</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        end seller-profile-app--}}

                        <div class="rectangle-div rectangle-div__about-content">
                            <p class="text-left fs-16 f-w6"
                            >@lang('labels.course-detail.content_course')</p>
                            <span class="text-content body"><div
                                        class="word-break course-schedule-body">{!! $result['courseSchedule']['body'] ?? null !!}</div></span>
                            <p class="read-more__open text-center dp-none">
                                @lang('labels.course-detail.read_more_course')
                            </p>
                            <p class="read-more__close text-center dp-none">
                                @lang('labels.course-detail.read_more_course_close')
                            </p>
                        </div>
                        <div class="rectangle-div rectangle-div__flow-day">
                            <p class="text-left f-w6 fs-16"
                            >@lang('labels.course-detail.follow_day_course')</p>
                            <span class="body"><div
                                        class="word-break course-schedule-flow">{!! $result['courseSchedule']['flow'] ?? null !!}</div></span>
                        </div>
                        @if($result['courses']->category->type === 1)
                            <a href="{{route('client.live-streaming')}}"
                               class="live-stream d-flex align-items-center">
                                <img src="{{asset('assets/img/clients/course-detail/play.svg')}}" alt="">
                                <p class="f-w6">@lang('labels.course-detail.tutorial_livestream_course')</p>
                            </a>
                        @else
                            <a href="{{route('client.video-call')}}"
                               class="live-stream d-flex align-items-center">
                                <img src="{{asset('assets/img/clients/course-detail/play.svg')}}" alt="">
                                <p class="f-w6">@lang('labels.course-detail.tutorial_consultation_course')</p>
                            </a>
                        @endif
                        <div class="rectangle-div rectangle-div__using">
                            <p class="text-left f-w6 fs-16"
                            >@lang('labels.course-detail.using_course')</p>
                            <span><div class="word-break course-schedule-cautions">{!! $result['courseSchedule']['cautions'] ?? null !!}</div></span>
                        </div>
                    </div>
                    <div class="menu-evaluation">
                        <div class="d-flex">
                            <div class="rectangle-title"></div>
                            <p class="menu-evaluation__title">@lang('labels.course-detail.evaluate_course')
                                （@if(isset($result['courses']))
                                    <span class="total-review">{{($result['courses']['num_of_ratings'])}}件</span>
                                @else
                                    <span class="total-review">0件</span>
                                @endif）</p>
                        </div>
                        <div class="menu-evaluation__rating d-flex align-items-end">
                            <div class="rating-position">
                                @if(isset($result['courses']))
                                    <ul class="content-rating d-flex">
                                        @include('client.common.show-star', ['rating' => ratingProcess($result['courses']['rating'])])
                                    </ul>
                                @endif
                            </div>
                            <p>{{ $result['courses']['rating'] >= 5 ? 5 : bcdiv($result['courses']['rating'],1,1)}}</p>
                        </div>
                        @if(isset($result['reviewsData']) && count($result['reviewsData']) > 0)
                            <input class="lastPage" type="hidden"
                                   value="{{$result['reviewsData']->lastPage()}}">
                            @foreach($result['reviewsData'] as $key => $item)
                                <div class="menu-evaluation__description d-flex">
                                    <div class="avt">
                                        @if($item['is_public'] === 0)
                                            <img src="{{asset('assets/img/clients/header-common/not-login.svg')}}"
                                                 alt=""
                                                 class="rounded-circle img-fluid">
                                        @else
                                            <img src="{{$item->getOriginal('profile_image') !== null ? $item->profile_thumbnail : '/assets/img/clients/header-common/not-login.svg'}}"
                                                 alt="">
                                        @endif
                                        @php
                                            if(isset($item->date_of_birth))
                                            $current_age = Carbon\Carbon::parse($item->date_of_birth)->age;
                                            else
                                                $current_age = null;
                                        @endphp
                                        <div class="age fs-12">
                                            {{ $item->sex_text === '無回答' ? '' : $item->sex_text }}
                                            @fakeBirthday($current_age)
                                        </div>
                                    </div>
                                    <div class="menu-evaluation__rectangle">
                                        @if($item['is_public'] === 1)
                                            <p class="title text-left ">
                                                {{
                                                    $item['full_name']
                                                }}
                                            </p>
                                        @else
                                            <p class="title text-left ">@lang('labels.course-detail.noName')</p>
                                        @endif
                                        <div class="d-flex justify-content-between align-items-end position-relative"
                                             style="margin-bottom: 8px">
                                            <div class="rating-position flex">
                                                <ul class="content-rating rating-star d-flex">
                                                    @include('client.common.show-star', ['rating' => ratingProcess($item['rating'])])
                                                </ul>
                                                <p class="start-text">{{ $item['rating'] >= 5 ? 5 : bcdiv($item['rating'],1,1)}}</p>
                                            </div>

                                            <p class="text">{{ date_format(date_create($item['start_datetime']), 'Y/m/d') }}
                                                @lang('labels.course-detail.hold_course')</p>
                                        </div>
                                        <span>{{$item['comment']}}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span
                                    class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
                        @endif
                    </div>
                    @if(isset($result['reviewsData']) && count($result['reviewsData']) > 0)
                        <p class="text-center see-more">
                            @lang('labels.course-detail.see_more_course')</p>
                    @endif

                </div>
                <div class="col3 content-table">
                    @if(
                        ($result['courses']->user->user_status ?? \App\Enums\DBConstant::USER_STATUS_DEACTIVE) === \App\Enums\DBConstant::USER_STATUS_DEACTIVE ||
                        (int)$result['courses']['status'] === \App\Enums\DBConstant::COURSE_STATUS_CLOSE ||
                        (isset($result['is_all_schedule_close']) && $result['is_all_schedule_close'])
                    )
                        <div class="Admission-fee">
                            <p class="Admission-fee__notification text-center">@lang('labels.course-detail.no_schedule')</p>
                            <div class="rectangle-none">
                                <span class="rectangle__text dist-method">
                                    {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                                </span>
                                @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                                    <div class="d-flex align-items-center" style="margin-left: 45px;">
                                        @if(!empty($result['courses']->category->type))
                                            @switch($result['courses']->category->type)
                                                @case($result['courses']->category->type === 1)
                                                    <span
                                                            class="price-restock">@lang('labels.course-detail.course_livestream')</span>
                                                    @break
                                                @case($result['courses']->category->type === 2)
                                                    <span
                                                            class="price-restock">@lang('labels.course-detail.course_consultation')</span>
                                                    @break
                                                @default
                                                    <span
                                                            class="price-restock">@lang('labels.course-detail.course_fortune')</span>
                                            @endswitch
                                        @endif
                                        <div>
                                            <span class="text-bold">{{ number_format($result['courseSchedules'][0]['price']) }}</span>
                                            <small>(@lang('labels.course-detail.tax_included_course'))</small>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{asset('assets/img/clients/course-detail/sad-face.svg')}}" alt="">
                                @endif
                            </div>
                            <div>
                                <a id="purchase_procedure_noTime">@lang('labels.course-detail.purchase_procedure_no_time_course')</a>
                            </div>
                        </div>
                    @elseif ($result['enabled_request_restock'])
                        <div class="Admission-fee">
                            <p class="Admission-fee__notification text-center">@lang('labels.course-detail.no_schedule')</p>
                            <div class="rectangle-none">
                                <span class="rectangle__text dist-method">
                                    {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                                </span>
                                @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                                    <div class="d-flex align-items-center" style="margin-left: 45px;">
                                        @if(!empty($result['courses']->category->type))
                                            @switch($result['courses']->category->type)
                                                @case($result['courses']->category->type === 1)
                                                    <span
                                                            class="price-restock">@lang('labels.course-detail.course_livestream')</span>
                                                    @break
                                                @case($result['courses']->category->type === 2)
                                                    <span
                                                            class="price-restock">@lang('labels.course-detail.course_consultation')</span>
                                                    @break
                                                @default
                                                    <span
                                                            class="price-restock">@lang('labels.course-detail.course_fortune')</span>
                                            @endswitch
                                        @endif
                                        <div>
                                            <span class="text-bold">¥{{ number_format($result['courseSchedules'][0]['price'])}}</span>
                                            <small>(@lang('labels.course-detail.tax_included_course'))</small>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{asset('assets/img/clients/course-detail/sad-face.svg')}}" alt="">
                                @endif
                            </div>
                            <div class="btn-restock">
                                @if($result['is_request_restock'])
                                    <a id="purchase_procedure_noTime">@lang('labels.course-detail.purchase_procedure_had_request_restock')</a>
                                @else

                                    <a id="restock-course"
                                       @if(!auth('client')->check())
                                           data-toggle="modal" data-target="#modalLogin"
                                       @else
                                           class="restock-course__click"
                                            @endif
                                    >
                                        @lang('labels.course-detail.purchase_procedure_request_restock')
                                    </a>
                                @endif
                            </div>
                            <div class="fs-10 fw-400">
                                <span class="fs-10 fw-700 count_request_restock"
                                      data-value="{{ $result['count_request_restock'] }}">
                                    {{ $result['count_request_restock'] }}人
                                </span>
                                開催リクエスト中
                            </div>
                            <div class="fs-10 fw-300 text-danger">※開催日のリクエストはできません</div>
                            <div class="fs-10 fw-400 mb-10">開催日が決定しましたら登録メールにてお知らせ</div>
                        </div>
                    @else
                        <div class="Admission-fee" id="choose-course-schedule">
                            {!! $html !!}
                        </div>
                    @endif
                    <div class="seller-profile">
                        <div class="seller-profile__header text-center position-relative">
                            <p class="seller-profile__header--title">@lang('labels.course-detail.seller_profile')</p>
                            <div class="seller-avt-wrapper">
                                @if(isset($result['courses']))
                                    <img class="seller-avt"
                                         src="{{ $result['courses']->user->profile_thumbnail }}"
                                         alt="">
                                @else
                                    <img class="seller-avt"
                                         alt="画像エラー">
                                    <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}" class="rank-icon">
                                @endif
                                @switch($result['courses']->user->rank_id)
                                    @case(\App\Enums\DBConstant::BRONZE)
                                        <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}" class="rank-icon">
                                        @break
                                    @case(\App\Enums\DBConstant::SILVER)
                                        <img src="{{ asset('assets/img/search/icon/Silver.svg') }}" class="rank-icon">
                                        @break
                                    @case(\App\Enums\DBConstant::GOLD)
                                        <img src="{{ asset('assets/img/search/icon/Gold.svg') }}" class="rank-icon">

                                        @break
                                    @case(\App\Enums\DBConstant::PLATINUM)
                                        <img src="{{ asset('assets/img/search/icon/platium.svg') }}" class="rank-icon">
                                        @break
                                    @default
                                @endswitch
                            </div>
                            <!--popup-rank-->
                            <div class="rank-popup">
                                @include('client.common.popup-rank', ['data' => $result['courses']->user])
                            </div>
                            <!--end popup-rank-->
                            <p class="seller-profile__header--cat">{{ $result['courses']->user->full_name }}</p>
                            @if($result['courses']['is_mask_required'] === 0)
                                <div class="formality fs-12 fw-600">
                                    @lang('labels.course-detail.formality')
                                    <span>(OK)</span>
                                </div>
                            @else
                                <div class="formality fs-12 fw-600">
                                    @lang('labels.course-detail.formality')
                                    <span class="fs-12 fw-600">(NG)</span>
                                    <span class="lappi-ar fw-300">※Lappi ARエフェクト</span>
                                </div>
                            @endif
                            <div class="position-relative">
                                @if(isset($result['courses']))
                                    <a href="{{route('client.teacher.detail', ['user_id' => $result['courses']->user->user_id])}}"
                                       class="seller-profile__header--profile-detail">@lang('labels.course-detail.profile_detail_course')</a>
                                @else
                                    <a class="seller-profile__header--profile-detail">@lang('labels.course-detail.profile_detail_course')</a>
                                @endif
                                <img class="arrow-right position-absolute"
                                     src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}"
                                     alt="">
                            </div>
                        </div>
                        @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS && $result['courses']->user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                            <div class="d-flex flex-wrap justify-content-center">
                                <div
                                        class="identification d-flex justify-content-center align-items-center position-relative">
                                    <div
                                            class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                    <img class="icon-identification position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/identification.svg')}}" alt="">
                                    <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                    <img class=" icon-tick position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                         alt="">
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-between flex-wrap pd-pc-12">
                                @if($result['courses']->user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <div class="identification d-flex justify-content-center align-items-center position-relative length-div @if($result['courses']->user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION) identification-large @endif">
                                        <div
                                                class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                        <img class="icon-identification position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                             alt="">
                                        <button
                                                class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                        <img class=" icon-tick position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    </div>
                                @endif
                                @if($result['courses']->user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION && $result['courses']->user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                    <div
                                            class="nondisclosure-agreement d-flex justify-content-center align-items-center length-div  position-relative @if($result['courses']->user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION ) nondisclosure-agreement-small @endif">
                                        <div
                                                class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.credentials')</div>
                                        <img class="position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                             alt="">
                                        <button
                                                class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                        <img class=" icon-tick position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    </div>
                                @endif
                                @if($result['courses']->user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING && $result['courses']->user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                    <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative length-div">
                                        <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                        <img class="position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                             alt="">
                                        <button
                                                class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                        <img class=" icon-tick position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="d-flex flex-wrap pd-pc-12">
                            <div class="question d-flex justify-content-center align-items-center position-relative">
                                @if($result['courses']->user->user_status === \App\Enums\Constant::USER_STATUS_REST)
                                    <img class="icon-question position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/question.svg')}}" alt="">
                                    @if(auth('client')->check())
                                        @if(auth('client')->id() === $result['courses']->user->user_id)
                                            <a
                                                    class="btn-question disabled text-center"><span>@lang('labels.course-detail.question_course')</span></a>
                                        @else
                                            <a href="{{route('client.student.message.message-detail', ['courseScheduleId' => $courseScheduleId, 'redirect' => 'course-detail', 'restock' => $result['enabled_request_restock'] ? 'true' : 'false'])}}"
                                               class="btn-question text-center @if(now()->subHour(48)->format('Y-m-d H:i:s') > now()->parse($result['courseSchedule']['end_datetime'])->format('Y-m-d H:i:s')) disabled @endif">
                                                <span>@lang('labels.course-detail.question_course')</span></a>
                                        @endif
                                    @else
                                        <a data-toggle="modal" data-target="#modalLogin"
                                           class="btn-question text-center"><span>@lang('labels.course-detail.question_course')</span></a>
                                    @endif
                                @else
                                    <img class="icon-question position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/question.svg')}}" alt="">
                                    <a class="btn-question disabled text-center"><span>@lang('labels.course-detail.question_course')</span></a>
                                @endif
                            </div>
                            @if(auth('client')->check())
                                <div
                                        class="follow-us d-flex justify-content-center align-items-center position-relative">
                                    <a type="button" data-toggle="modal" data-target="#modal-follow"
                                       class="btn-follow-us text-center"><span>@lang('labels.course-detail.follow_course')</span>
                                    </a>
                                    <img class="icon-follower position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/follower.svg')}}" alt="">
                                </div>
                            @else
                                <div
                                        class="follow-us d-flex justify-content-center align-items-center position-relative">
                                    <a type="button" data-toggle="modal" data-target="#modalLogin"
                                       class="btn-follow-us text-center"><span>@lang('labels.course-detail.follow_course')</span>
                                    </a>
                                    <img class="icon-follower position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/follower.svg')}}" alt="">
                                </div>
                            @endif
                        </div>
                        <div class="seller-profile__footer position-relative">
                            @if (isset($result['courses']->user->catchphrase))
                                <p class="seller-profile__footer__catchphrase text-more">{{$result['courses']->user->catchphrase}}</p>
{{--                                <p class="seller-profile__footer__catchphrase check-height" style="display: none">{{$result['courses']->user->catchphrase}}</p>--}}
                                <div class="position-absolute see-all">
                                    <span class="f-w3" style="font-size: 12px">すべて見る</span>
                                    <img class="arrow-down"
                                         src="{{ asset('assets/img/clients/course-detail/arrow-right.svg') }}" alt="">
                                </div>
                                <div class="position-absolute compact-text">
                                    <span class="f-w3" style="font-size: 12px">折りたたむ</span>
                                    <img class="arrow-down"
                                         src="{{ asset('assets/img/clients/course-detail/arrow-right.svg') }}" alt="">
                                </div>
                            @else
                                <span
                                        class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
                            @endif
                        </div>
                    </div>
                    <div class="seller-social w-100 d-flex justify-content-between">
                        <a href="#"
                           class="facebook btn-facebook-custom d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/clients/course-detail/fb.svg') }}" alt="">
                            <span>@lang('labels.course-detail.share_course')</span>
                        </a>
                        <a href="#"
                           class="tweeter btn-twitter-custom d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/clients/course-detail/tw.svg') }}" alt="">
                            <span>@lang('labels.course-detail.tweet_course')</span>
                        </a>
                        <a href="#"
                           class="line btn-line-custom d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/clients/course-detail/line.svg') }}" alt="">
                            <span>@lang('labels.course-detail.line_course')</span>
                        </a>
                    </div>
                    <div class="custom-social-button">
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>
                </div>
                <div class="modal" id="modal-follow" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p class="text text-center">@lang('labels.course-detail.subscribe_to_follow_list_course')</p>
                                <div class="popup-content-button d-flex justify-content-center">
                                    <button class="cancel text-center"
                                            data-dismiss="modal">@lang('labels.course-detail.cancel_course')</button>
                                    @if(isset($result['courses']->user->user_id))
                                        <form id="followTeacherForm">
                                            @csrf
                                            <input type="hidden" name="user_id"
                                                   value="{{ $result['courses']->user->user_id }}">
                                            <button type="submit" class="flowUs text-center">
                                                @lang('labels.course-detail.follow_course')
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{route('client.common.404')}}"
                                           class="flowUs text-center">@lang('labels.course-detail.follow_course')</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('client.screen.teacher.my-page.component.modal-login')
        </div>
        @include('client.screen.teacher.my-page.component.modal-login')
    </div>
    {{--Admission-fee-app--}}
    @if(
        ($result['courses']->user->user_status ?? \App\Enums\DBConstant::USER_STATUS_DEACTIVE) === \App\Enums\DBConstant::USER_STATUS_DEACTIVE ||
        (int)$result['courses']['status'] === \App\Enums\DBConstant::COURSE_STATUS_CLOSE ||
        (isset($result['is_all_schedule_close']) && $result['is_all_schedule_close'])
    )
        <div class="Admission-fee-app">
            <p class="Admission-fee__notification fw-600">@lang('labels.course-detail.no_schedule')</p>
            <div class="d-flex">
                <div class="content-left">
                    <div class="rectangle-none">
                        <span class="rectangle__text dist-method-sp">
                            {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                        </span>
                        @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                            <div class="d-flex align-items-center" style="margin-left: 23px;">
                                @if(!empty($result['courses']->category->type))
                                    @switch($result['courses']->category->type)
                                        @case($result['courses']->category->type === 1)
                                            <span
                                                    class="price-restock price-font-sp">@lang('labels.course-detail.course_livestream')</span>
                                            @break
                                        @case($result['courses']->category->type === 2)
                                            <span
                                                    class="price-restock price-font-sp">@lang('labels.course-detail.course_consultation')</span>
                                            @break
                                        @default
                                            <span
                                                    class="price-restock price-font-sp">@lang('labels.course-detail.course_fortune')</span>
                                    @endswitch
                                @endif
                                <div>
                                    <span class="text-bold price-restock-sp">¥{{ number_format($result['courseSchedules'][0]['price']) }}</span>
                                    <small class="price-font-sp">(@lang('labels.course-detail.tax_included_course')
                                        )</small>
                                </div>
                            </div>
                        @else
                            <img src="{{asset('assets/img/clients/course-detail/sad-face.svg')}}" alt="">
                        @endif
                    </div>
                </div>
                <div class="content-right">
                    <a id="purchase_procedure_noTime">@lang('labels.course-detail.purchase_procedure_no_time_course')</a>
                </div>
            </div>
        </div>
    @elseif ($result['enabled_request_restock'] && !$result['enabled_request_restock_course'])
        <div class="Admission-fee-app">
            <p class="Admission-fee__notification fw-600">@lang('labels.course-detail.no_schedule')</p>
            <div class="d-flex">
                <div class="content-left">
                    <div class="rectangle-none">
                        <span class="rectangle__text dist-method-sp">
                            {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                        </span>
                        @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                            <div class="d-flex align-items-center" style="margin-left: 23px;">
                                @if(!empty($result['courses']->category->type))
                                    @switch($result['courses']->category->type)
                                        @case($result['courses']->category->type === 1)
                                            <span
                                                    class="price-restock price-font-sp">@lang('labels.course-detail.course_livestream')</span>
                                            @break
                                        @case($result['courses']->category->type === 2)
                                            <span
                                                    class="price-restock price-font-sp">@lang('labels.course-detail.course_consultation')</span>
                                            @break
                                        @default
                                            <span
                                                    class="price-restock price-font-sp">@lang('labels.course-detail.course_fortune')</span>
                                    @endswitch
                                @endif
                                <div>
                                    <span class="text-bold price-restock-sp">¥{{ number_format($result['courseSchedules'][0]['price']) }}</span>
                                    <small class="price-font-sp">(@lang('labels.course-detail.tax_included_course')
                                        )</small>
                                </div>
                            </div>
                        @else
                            <img src="{{asset('assets/img/clients/course-detail/sad-face.svg')}}" alt="">
                        @endif
                    </div>
                </div>
                <div class="content-right btn-restock">
                    @if($result['is_request_restock'])
                        <a id="purchase_procedure_noTime">@lang('labels.course-detail.purchase_procedure_had_request_restock')</a>
                    @else
                        <a id="restock-course"
                           @if(!auth('client')->check())
                               data-toggle="modal" data-target="#modalLogin"
                           @else
                               class="restock-course__click"
                                @endif
                        >
                            @lang('labels.course-detail.purchase_procedure_request_restock')
                        </a>
                    @endif
                </div>
            </div>
            <div class="fs-10 fw-400">
                                <span class="fs-10 fw-700 count_request_restock"
                                      data-value="{{ $result['count_request_restock'] }}">
                                    {{ $result['count_request_restock'] }}人
                                </span>
                開催リクエスト中
            </div>
            <div class="fs-10 fw-300 text-danger">※開催日のリクエストはできません</div>
            <div class="fs-10 fw-400 mb-10">開催日が決定しましたら登録メールにてお知らせ</div>
        </div>
    @else
        <form id="purchase-course-sp"
              action="{{ route('client.orders.payment.index', ['courseScheduleId' => $courseScheduleId]) }}">
            <div class="Admission-fee-app">
                @if(!empty($result['courses']->category->type))
                    @switch($result['courses']->category->type)
                        @case($result['courses']->category->type === 1)
                            <span class="mr-5">@lang('labels.course-detail.course_livestream')</span>
                            @break
                        @case($result['courses']->category->type === 2)
                            <span class="mr-5">@lang('labels.course-detail.course_consultation')</span>
                            @break
                        @default
                            <span class="mr-5">@lang('labels.course-detail.course_fortune')</span>
                    @endswitch
                @endif
                <span class="text-bold">￥{{number_format($result['courseSchedule']->price)}}</span>
                <small>(@lang('labels.course-detail.tax_included_course'))</small>
                <div class="option-list text-left d-flex">
                    <div class="content-left">
                        @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS )
                            @if(isset($result['courseSchedulesCheckPurchase']) && count($result['courseSchedulesCheckPurchase']) > 0)
                                <div class="d-flex flex-column">
                                    @php
                                        $order = 0;
                                    @endphp
                                    @foreach($result['courseSchedulesCheckPurchase'] as $key => $item)
                                        @if (!$item->purchase_id)
                                        <div id="option{{$key}}" data-id="{{ $item["course_schedule_id"] }}"
                                             href="#" data-toggle="modal" data-target="#modal-choose-schedule"
                                             data-url="{{ route('client.course-schedules.detail', $item["course_schedule_id"]) }}"
                                             data-price="{{ number_format($item['price']) }}"
                                             data-number_of_participants="{{ number_format($item['num_of_applicants']) }}人"
                                             data-deadline="{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})"
                                             class="rectangle-sp d-flex flex-column justify-content-center align-items-center position-relative choose-option @if($result['courseSchedule']->course_schedule_id === $item['course_schedule_id']) active @endif">
                                            <span class="rectangle-sp__date">{{ date('m', strtotime($item['start_datetime'])) }}月{{ date('d', strtotime($item['start_datetime'])) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]  }})</span>
                                            <span class="rectangle-sp__time">
                                                @if(isset($item['actual_start_date']))
                                                    {{ date_format(date_create($item['actual_start_date']), 'H:i') }}
                                                    - {{ date_format(date_create($item['actual_end_date']), 'H:i') }}
                                                @else
                                                    {{ date_format(date_create($item['start_datetime']), 'H:i') }}
                                                    - {{ date_format(date_create($item['end_datetime']), 'H:i') }}
                                                @endif
                                            </span>
                                            @if(count($result['courseSchedules']) > 1)
                                                <img class="icon-arrow position-absolute @if($key === 0) rotate @endif"
                                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                                            @endif
                                            <span class="rectangle-sp__text">
                                            {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                                        </span>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif


                            @if(isset($result['courseSchedulesCheckPurchase']) && count($result['courseSchedulesCheckPurchase']) > 0)
                                <div class="deadline d-flex">
                                    <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                                    <span class="deadline__result">{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})</span>
                                </div>
                                <div class="purchase-deadline">※開催１時間前</div>
                            @endif
                        @else
                            @if(isset($result['courseSchedules']) && count($result['courseSchedules']) > 0)
                                <div class="d-flex flex-column">
                                    @php
                                        $order = 0;
                                    @endphp
                                    @foreach($result['courseSchedules'] as $key => $item)
                                        <div id="option{{$key}}" data-id="{{ $item["course_schedule_id"] }}"
                                             href="#" data-toggle="modal" data-target="#modal-choose-schedule"
                                             data-url="{{ route('client.course-schedules.detail', $item["course_schedule_id"]) }}"
                                             data-price="{{ number_format($item['price']) }}"
                                             data-number_of_participants="{{ number_format($item['num_of_applicants']) }}人"
                                             data-deadline="{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})"
                                             class="rectangle-sp d-flex flex-column justify-content-center align-items-center position-relative choose-option @if($result['courseSchedule']->course_schedule_id === $item['course_schedule_id']) active @endif">
                                            <span class="rectangle-sp__date">{{ date('m', strtotime($item['start_datetime'])) }}月{{ date('d', strtotime($item['start_datetime'])) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]  }})</span>
                                            <span class="rectangle-sp__time">
                                                @if(isset($item['actual_start_date']))
                                                    {{ date_format(date_create($item['actual_start_date']), 'H:i') }}
                                                    - {{ date_format(date_create($item['actual_end_date']), 'H:i') }}
                                                @else
                                                    {{ date_format(date_create($item['start_datetime']), 'H:i') }}
                                                    - {{ date_format(date_create($item['end_datetime']), 'H:i') }}
                                                @endif
                                            </span>
                                            @if(count($result['courseSchedules']) > 1)
                                                <img class="icon-arrow position-absolute @if($key === 0) rotate @endif"
                                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                                            @endif
                                            <span class="rectangle-sp__text">
                                            {{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$result['courses']['dist_method']] }}
                                        </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif


                            @if(isset($result['courseScheduleList']) && count($result['courseScheduleList']) > 0)
                                <div class="deadline d-flex">
                                    <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                                    {{--                                    <span class="deadline__result">（@lang('labels.course-detail.money_course'))</span>--}}
                                    <span class="deadline__result">{{\Carbon\Carbon::parse($result['courseSchedule']->purchase_deadline)->format('m月d日')}} ({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($result['courseSchedule']->purchase_deadline))] }})</span>
                                </div>
                                <div class="purchase-deadline">※開催１時間前</div>
                            @endif
                        @endif
                    </div>
                    <div class="content-right">
                        <div class="cs-mobile">
                            <button type="submit" id="purchase_procedure"
                                    @if($result['courses']->user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                                        class="@if(!$result['current_cs_can_buy'] || $result['user_can_buy'] || $result['courseSchedulePurchased'] || (int)$result['courses']->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_CLOSED || $result['courses']->cs_purchase_deadline < now() || $result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants) bg-disabled @endif"
                                    @else
                                        class="@if(!$result['current_cs_can_buy'] || $result['user_can_buy'] || $result['courseSchedulePurchased'] || (int)$result['courses']->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_CLOSED || $result['courses']->cs_purchase_deadline < now() || $result['courseSchedule']->fixed_num === $result['courseSchedule']->num_of_applicants)
                                        bg-disabled
                                    @endif"
                                    @endif>
                                @if(true)
                                    @lang('labels.course-detail.purchase_procedure_course')
                                @elseif(auth('client')->id() === $result['courses']->user->user_id)
                                    @lang('labels.course-detail.purchase_procedure_course')
                                @else
                                    @lang('labels.course-detail.purchase_procedure_course')
                                @endif
                            </button>
                        </div>
                        @if(!empty($result['courseScheduleList']))
                            @if(isset($result['courses']->category->type)
                              && $result['courses']->category->type === 3
                              && isset($result['optionData'])
                              && count($result['optionData']) > 0 )
                                <section id="charged-option-app">
                                    <div class="charged-option d-flex justify-content-center align-items-center">
                                        <img src="{{asset('assets/img/clients/course-detail/circle-plus.svg')}}"
                                             alt="">
                                        <span
                                                class="charged-option-text">@lang('labels.course-detail.charged_option_course')</span>
                                        <img class="arrow-down"
                                             src="{{asset('assets/img/clients/course-detail/arrow-right-grey.svg')}}"
                                             alt="">
                                    </div>
                                </section>
                            @endif
                        @endif
                        <span class="warning text-center">@lang('labels.course-detail.waring_time')</span>
                    </div>
                </div>
            </div>
            {{--End Admission-fee-app--}}
            {{--    choose other option--}}
            <div class="other-option">
                <div class="position-relative">
                    <div class="line-top"></div>
                    <div class="close-other-option">
                        <img src="{{asset('assets/img/icons/close.svg')}}" alt="">
                    </div>
                    <div class="table-option disable-option">
                        @foreach($result['optionData'] as $key => $item)
                            @if($result['courseSchedulePurchased'])
                                @if(isset($result['optionExtraPurchased']) && count($result['optionExtraPurchased']) > 0)
                                    @foreach($result['optionExtraPurchased'] as $key => $optionPurchase)
                                        <div
                                                class="table-option-item d-flex align-items-center justify-content-between">
                                            <label class="checkbox">
                                                @if($result['courseSchedulePurchased'] && $item['optional_extra_id'] === $optionPurchase['optional_extra_id'])
                                                    <input type="radio" checked
                                                           name="optional_extra_id[]"
                                                           data-value="{{($item['optional_extra_id'])}}"
                                                           value="{{$item['optional_extra_id']}}"> {{$item['title']}}
                                                @else
                                                    <input type="checkbox"
                                                           disabled
                                                           @if($item->isPurchased) checked
                                                           @endif
                                                           data-value="{{($item['optional_extra_id'])}}"
                                                           value="{{$item['title']}}"> {{$item['title']}}
                                                @endif
                                                <span class="checkmark"></span>
                                            </label>
                                            <div style="white-space: nowrap">
                                                <img
                                                        src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                                        alt="">
                                                <span>¥{{number_format($item['price'])}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="table-option-item d-flex align-items-center justify-content-between">
                                        <label class="checkbox">
                                            <input type="checkbox" disabled
                                                   data-value="{{($item['optional_extra_id'])}}"
                                                   value="{{$item['title']}}"> {{$item['title']}}
                                            <span class="checkmark"></span>
                                        </label>
                                        <div style="white-space: nowrap">
                                            <img
                                                    src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                                    alt="">
                                            <span
                                                    class="option-price">¥{{number_format($item['price'])}}</span>
                                        </div>
                                    </div>
                                @endif
                            @elseif(auth('client')->check() && auth('client')->user()->user_id === $result['courses']->user->user_id)
                                <div
                                        class="table-option-item d-flex align-items-center justify-content-between">
                                    <label class="checkbox">
                                        <input type="checkbox" disabled
                                               name="optional_extra_id[]"
                                               data-value="{{($item['optional_extra_id'])}}"
                                               value="{{$item['optional_extra_id']}}"> {{$item['title']}}
                                        <span class="checkmark"></span>
                                    </label>
                                    <div style="white-space: nowrap">
                                        <img
                                                src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                                alt="">
                                        <span
                                                class="option-price">¥{{number_format($item['price'])}}</span>
                                    </div>
                                </div>
                            @else
                                <div
                                        class="table-option-item d-flex align-items-center justify-content-between">
                                    <label class="checkbox">
                                        <input type="checkbox"
                                               name="optional_extra_id[]"
                                               data-value="{{($item['optional_extra_id'])}}"
                                               value="{{$item['optional_extra_id']}}"> {{$item['title']}}
                                        <span class="checkmark"></span>
                                    </label>
                                    <div style="white-space: nowrap">
                                        <img
                                                src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                                alt="">
                                        <span
                                                class="option-price">¥{{number_format($item['price'])}}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </form>
    @endif
    {{--    End choose other option--}}
    @include('client.screen.course-detail.choose-schedule-sp', ['data' => $result['courseSchedules']])
    <div id="course-detail" class="course-detail-list">
        <div class="content">
            <div class="sidebar-right">
                <!--live_distribution-->
                @if($result['courses']->category->type === \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                    <div class="sidebar-right__content">
                        <div class="new-service">
                            <div class="new-service__icon"></div>
                            <div class="new-service__text f-w6"
                            >@lang('labels.course-detail.livestream')</div>
                        </div>
                        <!-- Swiper -->
                        @if(count($topPage['popularCoursesInSkills']))
                            @include('client.common.home-slider', [
                                    'items' => $topPage['popularCoursesInSkills'],
                                    'user' => $user,
                                    'index' => 3,
                                    'type' => 'POPULAR'
                                ])
                        @else
                            <p>@lang('labels.course-detail.message.no_data')</p>
                        @endif
                    </div>
                @elseif($result['courses']->category->type === \App\Enums\DBConstant::CATEGORY_TYPE_CONSULTATION)
                    <div class="sidebar-right__content">
                        <div class="new-service">
                            <div class="new-service__icon"></div>
                            <div class="new-service__text f-w6"
                            >@lang('labels.course-detail.consultation')</div>
                        </div>
                        <!-- Swiper -->
                        @if(count($topPage['popularCoursesInConsultation']))
                            @include('client.common.home-slider', [
                                    'items' => $topPage['popularCoursesInConsultation'],
                                    'user' => $user,
                                    'index' => 3,
                                    'type' => 'POPULAR'
                                ])
                        @endif
                    </div>
                @else
                    <div class="sidebar-right__content">
                        <div class="new-service">
                            <div class="new-service__icon"></div>
                            <div class="new-service__text f-w6"
                            >@lang('labels.course-detail.fortune')</div>
                        </div>
                        <!-- Swiper -->
                        @if(count($topPage['popularCoursesFortunetelling']))
                            @include('client.common.home-slider', [
                                    'items' => $topPage['popularCoursesFortunetelling'],
                                    'user' => $user,
                                    'index' => 4,
                                    'type' => 'POPULAR'
                                ])
                        @endif
                    </div>
                @endif
                <!--new_service-->
                <div class="sidebar-right__content">
                    <div class="new-service">
                        <div class="new-service__icon"></div>
                        <div class="new-service__text f-w6"
                        >@lang('labels.home.new_service')</div>
                    </div>
                    <!-- Swiper -->
                    @if(count($topPage['newCourseSchedule']))
                        @include('client.common.home-slider', [
                            'items' => $topPage['newCourseSchedule'],
                            'user' => $user,
                            'index' => 5,
                            'type' => 'DEFAULT'
                        ])
                    @endif
                </div>
                <!--browsing_history-->
                @if(auth('client')->check())
                    <div class="sidebar-right__content">
                        <div class="new-service">
                            <div class="new-service__icon"></div>
                            <div class="new-service__text f-w6"
                            >@lang('labels.home.browsing_history')</div>
                        </div>
                        <!-- Swiper -->
                        @if(count($topPage['courseViewedRecently']))
                            @include('client.common.home-slider', [
                                'items' => $topPage['courseViewedRecently'],
                                'user' => $user,
                                'index' => 0,
                                'type' => 'DEFAULT'
                            ])
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(".bxslider").bxSlider({
                autoStart: false,
                auto: false,
                pager: true,
                controls: false,
                infiniteLoop: false,
                hideControlOnEnd: true,
                speed: 200,
                preventDefaultSwipeY: true,
                preloadImages: 'all',
                mode: 'fade'
            });
            //disable button
            $('body').on('click', '.bg-disabled', function (e) {
                e.preventDefault();
            })
            $('.restock-course__click').click(() => {
                $('#loading-overlay').show();
                const val = $('#course_id').val();
                const courseScheduleId = $('#course_schedule_id').val();
                if (!val) return;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/student/course/restock",
                    type: "POST",
                    data: {course_id: val, course_schedule_id: courseScheduleId},
                    success: function (response) {
                        if (response.status) {
                            $('#loading-overlay').hide();
                            $('#modal-follow').modal('hide');
                            toastr.info(response.message);
                            const element = $('.count_request_restock');
                            const dataValue = +element.data('value') + 1;
                            element.html(dataValue + '人');
                            $('.btn-restock').html('<a id="purchase_procedure_noTime">開催リクエストをする</a>');
                        } else {
                            $('#loading-overlay').hide();
                            $('#modal-follow').modal('hide');
                            toastr.error(response.message);
                        }
                    },
                    error: function (err) {
                        $('#loading-overlay').hide();
                    }
                });
            });

            let activeElm = $('.rectangle-course-schedule.active');

            $('body').on('click', '.rectangle-course-schedule.active', function () {
                $(this).removeClass('active');
                $('.rectangle-course-schedule.choose-option').addClass('show');
            });

            $('body').on('click', '.rectangle-course-schedule.show', function () {
                const id = $(this).attr('id');
                const courseScheduleId = $(this).data("id");
                const url = $(this).data('url');
                const actionUrl = window.location.hostname;
                $('.rectangle-course-schedule.choose-option').removeClass('show');
                $(this).addClass('active');
                activeElm = $('.rectangle-course-schedule.active');
                if (id === 'option0') {
                    return false;
                }

                $('.price-schedule').html('￥' + activeElm.data('price'));
                $('.deadline__result').html(activeElm.data('deadline'));
                $.ajax({
                    beforeSend: () => {
                        $('#loading-overlay').show();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "GET",
                    url: url,
                    data: {
                        is_ajax: true,
                    },
                    success: function (result) {
                        $('#purchase-course').attr('action', actionUrl + '/orders/' + courseScheduleId);
                        $('.description-title').html(result.data.title);
                        $('.sub-description-title').html(result.data.subtitle);
                        $('.course-schedule-body').html(result.data.body);
                        $('.course-schedule-flow').html(result.data.flow);
                        $('.course-schedule-cautions').html(result.data.cautions);
                        $('#choose-course-schedule').html(result.html);
                        $('#loading-overlay').hide();
                        let threeImages = "";
                        if (result.images) {
                            for (let i = 0; i < result.images.length; i++) {
                                threeImages += `<div class="three-image__item">
                                            <img src="${result.images[i]}" alt="">
                                        </div>`;
                            }
                            $('.family img').attr('src', result.images[0]);
                            $('.three-image').html(threeImages);
                            $('.three-image img').hover(function () {
                                $('.three-image img').prop('disabled', false);
                                let src = $(this).attr('src');
                                let srcImgFamily = $('.family img').attr('src');
                                $(this).prop('disabled', true);
                                if (src === srcImgFamily) {
                                    return false;
                                }
                                $('.family img').removeClass('family-animation')
                                setTimeout(function () {
                                    $('.family img').attr("src", src);
                                    $('.family img').addClass('family-animation');
                                }, 200);

                            }, function () {
                            })
                        }
                    }
                });
            });

            let isMobile = {
                Android: function () {
                    return navigator.userAgent.match(/Android/i);
                },
                BlackBerry: function () {
                    return navigator.userAgent.match(/BlackBerry/i);
                },
                iOS: function () {
                    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                },
                Opera: function () {
                    return navigator.userAgent.match(/Opera Mini/i);
                },
                Windows: function () {
                    return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
                },
                any: function () {
                    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                }
            };

            function setValueScheduleSP(price, date, time, type, deadline) {
                $('.text-bold').html(price);
                $('.rectangle-sp__date').html(date);
                $('.rectangle-sp__time').html(time);
                $('.rectangle-sp__text').html(type);
                $('.deadline__result').html(deadline);
            }

            if (isMobile.any()) {
                $('.schedule-list').click(function () {
                    $('#modal-choose-schedule').modal('hide');
                    setValueScheduleSP(
                        $(this).find('#schedule-list__price').html(),
                        $(this).find('.schedule-list__date').html(),
                        $(this).find('.schedule-list__time').html(),
                        $(this).find('.schedule-list__text').html(),
                        $(this).find('#deadline').html(),
                    )
                    $('#loading-overlay').show();
                    const courseScheduleId = $(this).data("id");
                    const url = $(this).data('url');
                    const actionUrl = location.protocol + '//' + location.host;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "GET",
                        url: url,
                        data: {
                            is_ajax: true,
                            is_mobile: true
                        },
                        success: function (result) {
                            $('#purchase-course-sp').attr('action', actionUrl + '/orders/' + courseScheduleId);
                            $('.description-title').html(result.data.title);
                            $('.sub-description-title').html(result.data.subtitle);
                            $('.course-schedule-body').html(result.data.body);
                            $('.course-schedule-flow').html(result.data.flow);
                            $('.course-schedule-cautions').html(result.data.cautions);
                            $('.cs-mobile').html(result.html)
                            $('#loading-overlay').hide();
                        }
                    });
                });
            }

            const matched = $(".length-div");
            if (matched.length === 1) {
                matched.parent().css('justify-content', 'center')
            } else {
                matched.parent().css('justify-content', 'between')
            }

            $('#followTeacherForm').on("submit", (e) => {
                e.preventDefault();
                let formData = $('#followTeacherForm').serializeArray();
                $('#loading-overlay').show();
                $.ajax({
                    url: "/student/follow-teacher",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.status) {
                            $('#loading-overlay').hide();
                            $('#modal-follow').modal('hide');
                            toastr.info(response.message);
                        } else {
                            $('#loading-overlay').hide();
                            $('#modal-follow').modal('hide');
                            toastr.error(response.message);
                        }
                        $(".flowUs").removeClass('btn-disabled')
                    },
                    error: function (err) {
                        $('#loading-overlay').hide();
                        $(".flowUs").removeClass('btn-disabled')
                    }
                });
            });
            $('.three-image img').hover(function () {
                $('.three-image img').prop('disabled', false);
                let src = $(this).attr('src');
                let srcImgFamily = $('.family img').attr('src');
                $(this).prop('disabled', true);
                if (src === srcImgFamily) {
                    return false;
                }
                $('.family img').removeClass('family-animation')
                setTimeout(function () {
                    $('.family img').attr("src", src);
                    $('.family img').addClass('family-animation');
                }, 200);

            }, function () {
            })
        })
    </script>
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=60fe75f919c512001348300e&product=inline-share-buttons'
            async='async'></script>
    <script src="{{ mix('js/clients/modules/livestream.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/clients/commons/button-social.js') }}"></script>
@endsection
