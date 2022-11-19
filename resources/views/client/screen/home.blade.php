@extends('client.base.base')
@section('header')
    <meta name="description" content="誰でも副業ができる！Lappiはあなたの得意や、今まで仕事や生きて来て培った知識や経験で今必要な人達の「疑問・悩み・問題」を解決するオンラインのナレッジシェアサービスです。">
    <title>Lappi (ラッピ) | 人と人をつなぐナレッジマーケット</title>
@endsection
@section('css')
    <link href="{{ mix('css/clients/home-private.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="/css/owl.theme.default.min.css"/>
    <style>
        .card__content__rate__rating {
            margin-top: -6px;
        }

        .list-star li {
            margin-right: 4px;
        }

        .f-w6 {
            font-weight: unset;
        }

        .main .sidebar-right .card__content__title {
            font-weight: unset;
        }

        @media only screen and (max-width: 776px) {
            .f-w6 {
                font-weight: unset;
            }
        }

    </style>
@endsection
@section('lib-js')
    <script src="{{ mix('/js/lappi-slider.js') }}"></script>
@endsection
@section('content')
    @php
        $user = auth('client')->user()
    @endphp
    @if (session('success') != null)
        <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
    @endif
    <div class="main home-page">
        <div class="main__content">
            <div class="banner">
                <div class="container">
                    <div class="row position-relative">
                        <div class="banner-image">
                            <div class="banner__content">
                                <a href="{{route('client.about-lappi')}}"
                                   class="btn banner__content__button f-w6">
                                    @lang('labels.banner.banner_button')
                                    <img class="vector-rectangle"
                                         src="{{ asset('assets/img/top-log/vector-rectangle.svg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row row-mobile">
                <div class="col-12 col-md-3">
                    @include('client.layout.sidebar-left',['data' => $data])
                </div>
                <div class="col-12 col-md-9 col-list-item">
                    <div class="sidebar-right">
                        @if(Auth::guard('client')->check())
                            <div class="sidebar-right__content">
                                <div class="new-service">
                                    <div class="new-service__icon"></div>
                                    <div class="new-service__text f-w6">{{ __('labels.home.browsing_history') }}</div>
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
                        @else
                            <div class="sidebar-right__content">
                                <div class="new-service">
                                    <div class="new-service__icon"></div>
                                    <div class="new-service__text f-w6">{{ __('labels.home.new_service') }}</div>
                                </div>
                                <!-- Swiper -->
                                @if(count($topPage['newCourseSchedule']))
                                    @include('client.common.home-slider', [
                                        'items' => $topPage['newCourseSchedule'],
                                        'user' => $user,
                                        'index' => 1,
                                        'type' => 'DEFAULT'
                                    ])
                                @endif
                            </div>
                        @endif
                        <div class="sidebar-right__content">
                            <div class="new-service ranking-category">
                                <div class="new-service__icon-start"></div>
                                <div class="new-service__text f-w6">
                                    <span class="mr-span">@lang('labels.home.popularity_ranking_by_category')</span>
                                    <span class="span-date">@lang('labels.home.period'){{now()->subDays(\App\Enums\Constant::DAY_AGO_8)->format('m/d')}}～{{now()->subDays(\App\Enums\Constant::DAY_AGO_2)->format('m/d')}}</span>
                                </div>
                                <div class="new-service__icon-end"></div>
                            </div>
                            <div class="new-service">
                                <div class="new-service__icon"></div>
                                <div class="new-service__text f-w6">@lang('labels.home.live_distribution')</div>
                            </div>
                            <!-- Swiper -->
                            @if(count($topPage['popularCoursesInSkills']))
                                @include('client.common.home-slider', [
                                        'items' => $topPage['popularCoursesInSkills'],
                                        'user' => $user,
                                        'index' => 2,
                                        'type' => 'POPULAR',
                                        'loop' => true
                                    ])
                            @endif
                        </div>

                        <div class="sidebar-right__content">
                            <div class="new-service">
                                <div class="new-service__icon"></div>
                                <div class="new-service__text f-w6">@lang('labels.home.noline_trouble_consultation')</div>
                            </div>
                            <!-- Swiper -->
                            @if(count($topPage['popularCoursesInConsultation']))
                                @include('client.common.home-slider', [
                                        'items' => $topPage['popularCoursesInConsultation'],
                                        'user' => $user,
                                        'index' => 3,
                                        'type' => 'POPULAR',
                                        'loop' => true
                                    ])
                            @endif
                        </div>
                        <div class="sidebar-right__content">
                            <div class="new-service">
                                <div class="new-service__icon"></div>
                                <div class="new-service__text f-w6">@lang('labels.home.online_fortune_telling')</div>
                            </div>
                            <!-- Swiper -->
                            @if(count($topPage['popularCoursesFortunetelling']))
                                @include('client.common.home-slider', [
                                        'items' => $topPage['popularCoursesFortunetelling'],
                                        'user' => $user,
                                        'index' => 4,
                                        'type' => 'POPULAR',
                                        'loop' => true
                                    ])
                            @endif
                        </div>
                        @if(Auth::guard('client')->check())
                            <div class="sidebar-right__content">
                                <div class="new-service">
                                    <div class="new-service__icon"></div>
                                    <div class="new-service__text f-w6">@lang('labels.home.new_service')</div>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
