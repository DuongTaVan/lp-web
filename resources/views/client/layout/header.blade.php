@php
    $user = auth()->guard('client')->user()
@endphp
<header id="header" class="custom-header">
    <div class="header-bar">
        <div class="header">
            <div class="header__notification">
                <div class="header__notification__list">
                    <div class="header__notification__list__text">
                        @lang('labels.header.notice')
                    </div>
                    @if(Auth::guard('client')->check())
                        @if(count($noticePopup) > 0)
                            <ul id="noticePopup">
                                @foreach($noticePopup as $item)
                                    <li class="notice-detail" data-id="{{$item['id']}}">
                                        <a href="{{route('client.teacher.notice-detail',$item['id'])}}">
                                            <div class="header__notification__list__content">
                                                <div class="header__notification__list__content__main">
                                                    <div class="header__notification__list__content__main__icon">
                                                        <img
                                                                src="{{ url('assets/img/clients/header-common/lappiになる.svg') }}"
                                                                alt="Logo-Lappi">
                                                    </div>
                                                    <div class="header__notification__list__content__main__description">
                                                        <span class="title"> [{{ $item['title'] ?? '' }}]</span>
                                                        <span class="body">{!! $item['body'] ?? null !!}</span>
                                                    </div>
                                                </div>
                                                <div
                                                        class="header__notification__list__content__date">
                                                    {{ now()->parse($item['created_at'])->diffForHumans() ?? '' }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center text-no-data">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                {{ trans('labels.common.no_notify') }}
                            </div>
                        @endif
                        {{--                                @endif--}}
                    @endif
                    <div class="header__notification__list__view-more" id="view-more">
                        <a href="{{ route('client.teacher.notice-page') }}">{{ trans('labels.header.view_more') }}</a>
                    </div>
                </div>
            </div>
            <div class="header__left">
                <div id="header__left__logo" class="header__left__logo" data-url="{{route('client.home')}}">
                    <a href="{{route('client.home')}}">
                        <img class="logo-lappi" src="{{ url('assets/img/clients/header-common/logo.svg') }}"
                             alt="Logo-Lappi">
                    </a>
                </div>
                <div class="header__left__search">
                    @php
                        $pageNoSeacher = \Request::route() ? Request::route()->getName() : null;
                    @endphp
                    <form action="{{route('client.home.search')}}">
                        @if (\Auth::guard('client')->check() && $pageNoSeacher !== 'client.active-account' || in_array($pageNoSeacher, \App\Enums\Constant::LIST_SCREEN_NOT_SEARCH_FORM))
                            <div
                                    class="position-relative {{Auth::check('client') ? 'input-search' : 'input-searchLarge'}}">
                                <input type="text"
                                       value="{{request()->get('keyword') ?? ''}}" name="keyword"
                                       id="search-form" placeholder="キーワードで検索" autocomplete="off">
                                <button class="header__left__search__icon-search">
                                    <img src="{{asset('assets/img/clients/header-common/search.svg')}}" alt="">
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="header__bar">
                    <div class="flex-column header__bar__icon">
                        @if(\Auth::guard('client')->check())
                            <div class="set-size click-menu-sp">
                                <a>
                                    <img class="default-avatar"
                                         src="{{ auth()->guard('client')->user()->getOriginal('profile_image') !== null ? auth()->guard('client')->user()->profile_image : '/assets/img/clients/header-common/not-login.svg' }}"
                                         alt="">
                                </a>
                            </div>
                            <div class="text-user">@lang('labels.header.user')</div>
                        @else
                            <a href="{{route('client.handle-login')}}">
                                <div class="set-size">
                                    <img src="{{url('assets/img/clients/header-common/not-login.svg')}}" alt="">
                                </div>
                            </a>
                            <div class="text-user">@lang('labels.header.login_register')</div>
                        @endif
                    </div>
                    <a id="flex-column-become" class="flex-column" href="{{ route('client.become-lappi') }}"
                       data-url="{{ route('client.become-lappi') }}">
                        <div class="set-size">
                            <img src="{{url('assets/img/clients/header-common/lappiになる.svg')}}" alt="">
                        </div>
                        <div class="text-lappi">{{ trans('labels.header.become_login') }}</div>
                    </a>
                    <a id="flex-column-user-guide" class="flex-column" href="{{route('client.user-guide')}}"
                       data-url="{{route('client.user-guide')}}">
                        <div class="set-size">
                            <img src="{{url('assets/img/clients/header-common/ご利用ガイド.svg')}}" alt="">
                        </div>
                        <div class="user-guide">@lang('labels.header.question')</div>
                    </a>
                </div>
                <div class="layout__hidden"></div>
            </div>
            <div class="header-right">
                <div class="header-right__close">
                    <img src="{{url('assets/img/clients/header-common/close.svg')}}" alt="">
                </div>
                @if ($user && $user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER)
                    <div class="header-right__change-role">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @if ($user && !Request::is('student/*') && !Request::is('teacher/*'))
                                <li class="nav-item" onclick="changeTabImg('profile-img-student')">
                                    <a class="student-tab-btn f-w6 nav-link active" id="student-tab-btn"
                                       data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                                       aria-selected="true">購入者マイページ</a>
                                </li>
                            @else
                                <li class="nav-item" onclick="changeTabImg('profile-img-student')">
                                    <a class="student-tab-btn f-w6 nav-link {{ Request::is('student/*') || $user && $user->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? 'active' : ''}}"
                                       id="student-tab-btn" data-toggle="pill" href="#pills-home" role="tab"
                                       aria-controls="pills-home" aria-selected="true">購入者マイページ</a>
                                </li>
                            @endif
                            <li class="nav-item" onclick="changeTabImg('profile-img-teacher')">
                                <a class="teacher-tab-btn f-w6 nav-link {{ Request::is('teacher/*') && $user && $user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER ? 'active' : '' }}"
                                   id="teacher-tab-btn" data-toggle="pill" href="#pills-profile" role="tab"
                                   aria-controls="pills-profile" aria-selected="false">出品者マイページ</a>
                            </li>
                        </ul>
                    </div>
                @endif
                <div class="header-right__menu">
                    <div class="header-right__menu__user">
                        @if(\Auth::guard('client')->check())
                            <div class="tab-content">
                                @if ($user && !Request::is('student/*') && !Request::is('teacher/*'))
                                    <div id="profile-img-student"
                                         class="student-tab-btn change-tab-img tab-pane fade show active">
                                        <div class="header-right__menu__user__price justify-content-center">
                                            <img style="width: unset"
                                                 src="{{ asset('assets/img/clients/header-common/mobile/price.svg') }}"
                                                 alt="">
                                            <div
                                                    class="header-right__menu__user__price__text">{{number_format(Auth::guard('client')->user()->points_balance)}}
                                                pt
                                            </div>
                                        </div>
                                        <div class="header-right__menu__user__icon">
                                            <a href="{{auth()->guard('client')->user()->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? route('client.student.my-page.dashboard') : route('client.teacher.my-page.dashboard')}}">
                                                <img class="default-avatar"
                                                     src="{{ auth()->guard('client')->user()->getOriginal('profile_image') !== null ? auth()->guard('client')->user()->profile_image : '/assets/img/clients/header-common/not-login.svg' }}"
                                                     alt="">
                                            </a>
                                        </div>
                                        <div
                                                class="header-right__menu__user__text text-name-pc">@lang('labels.header.user')</div>
                                        <div
                                                class="header-right__menu__user__text dp-none text-name-sp">{{ $user->full_name }}</div>
                                        <div class="header-right__menu__user__change"><a
                                                    class="d-flex justify-content-center"
                                                    href="{{auth()->guard('client')->user()->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER ? route('client.teacher.mypage-teacher-profile-edit-nickname') : route('client.student.my-page.profile-and-email') ?? 'javascript:void(0)' }}">{{trans('labels.sidebar-left.profile_editing')}}</a>
                                        </div>
                                    </div>
                                @else
                                    <div id="profile-img-student"
                                         class="student-tab-btn change-tab-img tab-pane fade {{ Request::is('student/*') || $user->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? 'show active' : ''}}">
                                        <div class="header-right__menu__user__price justify-content-center">
                                            <img style="width: unset"
                                                 src="{{ asset('assets/img/clients/header-common/mobile/price.svg') }}"
                                                 alt="">
                                            <div
                                                    class="header-right__menu__user__price__text">{{number_format(Auth::guard('client')->user()->points_balance)}}
                                                pt
                                            </div>
                                        </div>
                                        <div class="header-right__menu__user__icon">
                                            <a href="{{auth()->guard('client')->user()->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? route('client.student.my-page.dashboard') : route('client.teacher.my-page.dashboard')}}">
                                                <img class="default-avatar"
                                                     src="{{ auth()->guard('client')->user()->getOriginal('profile_image') !== null ? auth()->guard('client')->user()->profile_image : '/assets/img/clients/header-common/not-login.svg' }}"
                                                     alt="">
                                            </a>
                                        </div>
                                        <div class="header-right__menu__user__text">@lang('labels.header.user')</div>
                                        <div class="header-right__menu__user__change"><a
                                                    class="d-flex justify-content-center"
                                                    href="{{auth()->guard('client')->user()->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER ? route('client.teacher.mypage-teacher-profile-edit-nickname') : route('client.student.my-page.profile-and-email') ?? 'javascript:void(0)' }}">{{trans('labels.sidebar-left.profile_editing')}}</a>
                                        </div>
                                    </div>
                                @endif
                                <style>
                                    .header-right__menu__user__icon .rank-icon {
                                        display: none;
                                    }

                                    @media (max-width: 414px) {
                                        .header-right__menu__user__icon {
                                            position: relative;
                                        }

                                        .header-right__menu__user__icon .rank-icon {
                                            display: block;
                                            width: unset !important;
                                            height: unset !important;
                                            border: unset !important;
                                            right: 0 !important;
                                            bottom: 0 !important;
                                            position: absolute !important;
                                        }
                                    }
                                </style>
                                <div id="profile-img-teacher"
                                     class="teacher-tab-btn change-tab-img tab-pane fade {{ Request::is('teacher/*') && $user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER ? 'show active' : ''}}">
                                    <div class="header-right__menu__user__icon">
                                        <a href="{{auth()->guard('client')->user()->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? route('client.student.my-page.dashboard') : route('client.teacher.my-page.dashboard')}}">
                                            <img class="default-avatar"
                                                 src="{{auth()->guard('client')->user()->getOriginal('profile_image') !== null ? auth()->guard('client')->user()->profile_image : '/assets/img/clients/header-common/not-login.svg' }}"
                                                 alt="">
                                        </a>
                                        @switch(auth()->guard('client')->user()->rank_id)
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
                                    <div class="header-right__menu__user__text visible-mobile" style="display: none;">
                                        @if($user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER)
                                            {{ $user->full_name }}
                                        @else
                                            {{ $user->nickname }}
                                        @endif
                                    </div>
                                    <div
                                            class="header-right__menu__user__text none-mobile">@lang('labels.header.user')</div>
                                    <div class="header-right__menu__user__change"><a
                                                class="d-flex justify-content-center"
                                                href="{{ route('client.teacher.mypage-teacher-profile-edit') }}">{{trans('labels.sidebar-left.profile_editing')}}</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{route('client.handle-login')}}">
                                <div class="header-right__menu__user__icon">
                                    <img class="default-avatar"
                                         src="{{url('assets/img/clients/header-common/not-login.svg')}}"
                                         alt="">
                                </div>
                            </a>
                            <div class="header-right__menu__user__text">@lang('labels.header.login_register')</div>
                        @endif
                    </div>
                    @if(Auth::guard('client')->check())
                        <style>
                            #header .header .header-right {
                                width: fit-content;
                            }
                        </style>
                        <a href="{{ route('client.student.my-page.point') }}" class="header-right__menu__price">
                            <div class="header-right__menu__price__icon">
                                <img src="{{url('assets/img/clients/header-common/50コイン.svg')}}" alt="">
                            </div>
                            <div class="header-right__menu__price__text"
                                 title="{{number_format(Auth::guard('client')->user()->points_balance)}} @lang('labels.header.price')">{{number_format(Auth::guard('client')->user()->points_balance)}}
                                @lang('labels.header.price')
                            </div>
                        </a>

                        <div class="header-right__menu__notification">
                            <div class="header-right__menu__notification__icon">
                                <img
                                        src="{{ asset("assets/img/clients/header-common/" . (isset($noticePopup) && count($noticePopup) ? 'active-notify.svg' : 'notify.svg')) }}"
                                        alt="">
                            </div>
                            <div class="header-right__menu__notification__text">@lang('labels.header.notify')</div>
                        </div>
                    @endif
                    @php
                        $isLogin = \Auth::guard('client')->check();
                        $userType = \Auth::guard('client')->user()->user_type ?? null;
                    @endphp
                    <a href="{{ route('client.become-lappi') }}" class="header-right__menu__lappi">
                        <div class="header-right__menu__lappi__logo">
                            <img class="header-right__menu__lappi__logo__pc"
                                 src="{{url('assets/img/clients/header-common/lappiになる.svg')}}" alt="">
                            <img class="header-right__menu__lappi__logo__mobile"
                                 src="{{url('assets/img/clients/header-common/lappi-mobile.svg')}}" alt="">
                        </div>
                        <div class="header-right__menu__lappi__text">{{ trans('labels.header.become_login') }}</div>
                    </a>
                    <a class="header-right__menu__question" href="{{route('client.user-guide')}}">
                        <div class="header-right__menu__question__icon">
                            <img src="{{url('assets/img/clients/header-common/ご利用ガイド.svg')}}" alt="">
                        </div>
                        <div class="header-right__menu__question__text">@lang('labels.header.question')</div>
                    </a>
                    <div class="header-right__role-teacher">
                        @if(!empty($courses['category_type']))
                            <div class="bd-highlight achievement">
                                <img class="achievement-icon" src="{{asset('assets/img/teacher-page/icon/id1.svg')}}"
                                     alt="id1"><span>本人確認</span>
                                <span>
                        @if($courses['category_type'] === 1 || $courses['category_type'] ===3)
                                        @if($courses['identity_verification_status'] === 3 )
                                            <svg class="achievement-checked" width="13" height="11" viewBox="0 0 13 11"
                                                 fill="none"
                                                 xmlns="http:/www.w3.org/2000/svg">
                                    <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                          stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                        @endif
                                    @endif
                        </span>
                            </div>
                        @endif
                        @if(!empty($courses['category_type']))
                            <div class="bd-highlight achievement">
                                @if($courses['category_type'] === 1 || $courses['category_type'] ===3)
                                    <img style="margin-bottom: 5px;"
                                         class="achievement-icon"
                                         src="{{asset('assets/img/teacher-page/icon/deal1.svg')}}"
                                         alt="deal1">
                                    <span>{{ trans('labels.sidebar-left.agreement') }}</span>
                                    @if($courses['nda_status'] === 1)
                                        <svg class="achievement-checked" width="13" height="11" viewBox="0 0 13 11"
                                             fill="none"
                                             xmlns="http:/www.w3.org/2000/svg">
                                            <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                                  stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                @else
                                    <img style="margin-bottom: 5px;"
                                         class="achievement-icon"
                                         src="{{asset('assets/img/teacher-page/icon/deal1.svg')}}"
                                         alt="deal1">
                                    <span>  {{ trans('labels.sidebar-left.qualification') }} </span>
                                    @if($courses['nda_status'] === 3)
                                        <svg class="achievement-checked" width="13" height="11" viewBox="0 0 13 11"
                                             fill="none"
                                             xmlns="http:/www.w3.org/2000/svg">
                                            <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                                  stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        @if ($user && !Request::is('student/*') && !Request::is('teacher/*'))
                            <div class="student-tab-btn tab-pane fade show active" id="pills-home" role="tabpanel"
                                 aria-labelledby="student-tab-btn">
                                <div class="header-right__menu__mobile student-mobile">
                                    @if(Auth::guard('client')->check())
                                        <a>
                                            <div class="header-right__menu__mobile__noti header-right__menu__mobile__parent d-flex mobile-noti
                                                {{ Route::currentRouteName() === 'client.teacher.notice-page' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__text header-right__menu__mobile__noti__icon">
                                                    {{--                                        <i class="item noti-icon"></i>--}}
                                                    <img class="icon-noti"
                                                         src="{{ asset("assets/img/clients/header-common/" . (isset($noticePopup) && count($noticePopup) ? 'active-notify.svg' : 'notify.svg')) }}"
                                                         alt="">
                                                </div>
                                                <div class="header-right__menu__mobile__text">通知</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.dashboard') }}">
                                            <div class="header-right__menu__mobile__dashboard header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.dashboard' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__dashboard__icon">
                                                    <i class="item dashboard-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text"> {{ trans('labels.sidebar-left.dashboard') }}</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.purchase-service') }}">
                                            <div class="header-right__menu__mobile__flug header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.purchase-service' ? 'active' : '' }}
                                            {{Route::currentRouteName() == 'client.student.my-page.order' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__flug__icon">
                                                    <i class="item services-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.purchase_service') }}
                                                    ({{isset($purchaseService) && !empty($purchaseService) ? $purchaseService->total() : 0}}
                                                    )
                                                </div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.list') }}">
                                            <div class="header-right__menu__mobile__reload header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.list' ?'active':''}}
                                            {{Route::currentRouteName() == 'client.student.my-page.review' ?'active':''}}
                                            {{Route::currentRouteName() == 'client.student.my-page.detail' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__reload__icon">
                                                    <i class="item transfer-history-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.purchase_history') }}
                                                </div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.message.list') }}">
                                            <div class="header-right__menu__mobile__message header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.message.list' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__message__icon">
                                                    <i class="item chat-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text"> {{ trans('labels.sidebar-left.message') }}
                                                    ({{ $COURSE_MESSAGE_UNREAD_STUDENT ?? 0 }})
                                                </div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.point') }}">
                                            <div class="header-right__menu__mobile__card header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.point' ?'active':''}}
                                            {{Route::currentRouteName() == 'client.student.my-page.coupon' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__card__icon">
                                                    <i class="item voucher-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.points_coupons') }}</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.follow') }}">
                                            <div class="header-right__menu__mobile__user header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.follow' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__user__icon">
                                                    {{--                                    <i class="item profile-plus-icon"></i>--}}
                                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                         xmlns="http:/www.w3.org/2000/svg">
                                                        <path class="user-plus"
                                                              d="M7.22249 8.56358C8.38585 8.56358 9.39324 8.14163 10.2163 7.30912C11.0394 6.47674 11.4567 5.45827 11.4567 4.28166C11.4567 3.10545 11.0394 2.08685 10.2162 1.2542C9.39297 0.421954 8.38572 0 7.22249 0C6.05898 0 5.05187 0.421954 4.22877 1.25433C3.40567 2.08671 2.98828 3.10531 2.98828 4.28166C2.98828 5.45827 3.40567 6.47687 4.2289 7.30925C5.05214 8.14149 6.05939 8.56358 7.22249 8.56358Z"
                                                              fill="#4E5768"/>
                                                        <path class="user-plus"
                                                              d="M14.6311 13.6707C14.6074 13.3243 14.5594 12.9465 14.4887 12.5474C14.4174 12.1454 14.3255 11.7654 14.2155 11.418C14.1019 11.059 13.9474 10.7044 13.7564 10.3647C13.5582 10.012 13.3253 9.70496 13.0641 9.45228C12.7909 9.18793 12.4564 8.97539 12.0696 8.82037C11.6841 8.66615 11.2569 8.58803 10.8 8.58803C10.6205 8.58803 10.447 8.66249 10.1118 8.88316C9.90552 9.0192 9.66423 9.17654 9.39492 9.35055C9.16463 9.49894 8.85266 9.63796 8.46734 9.76383C8.09139 9.88685 7.70968 9.94924 7.33294 9.94924C6.95619 9.94924 6.57462 9.88685 6.19827 9.76383C5.81335 9.6381 5.50138 9.49907 5.27136 9.35069C5.0046 9.1783 4.76318 9.02097 4.55381 8.88303C4.21905 8.66235 4.04536 8.58789 3.86591 8.58789C3.40882 8.58789 2.98178 8.66615 2.59645 8.8205C2.20991 8.97526 1.87528 9.18779 1.60181 9.45241C1.34067 9.70523 1.10771 10.0122 0.909744 10.3647C0.718889 10.7044 0.564382 11.0588 0.450647 11.4181C0.340802 11.7655 0.248929 12.1454 0.177576 12.5474C0.106895 12.9459 0.0588792 13.3239 0.0351398 13.6711C0.0118027 14.0113 0 14.3644 0 14.7209C0 15.6489 0.291713 16.4002 0.866959 16.9543C1.4351 17.501 2.18685 17.7784 3.10101 17.7784H11.5657C12.4798 17.7784 13.2313 17.5011 13.7996 16.9543C14.375 16.4006 14.6667 15.6492 14.6667 14.7208C14.6665 14.3626 14.6546 14.0093 14.6311 13.6707Z"
                                                              fill="#4E5768"/>
                                                        <circle cx="12.8885" cy="14.6668" r="3.11111" fill="#F9FAFB"/>
                                                        <rect class="user-plus" x="10.2227" y="14.2219" width="4.44445"
                                                              height="0.88889"
                                                              rx="0.444445" fill="#4E5768"/>
                                                        <rect class="user-plus" x="12.8887" y="12.4448" width="4.44445"
                                                              height="0.88889"
                                                              rx="0.444445"
                                                              transform="rotate(90 12.8887 12.4448)" fill="#4E5768"/>
                                                    </svg>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.follow') }}</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.account-setting') }}">
                                            <div class="header-right__menu__mobile__setting header-right__menu__mobile__parent d-flex align-items-center
                                                {{ Route::currentRouteName() == 'client.student.my-page.edit-profile' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.account-setting' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.change-password' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.notify-setting' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.credit-card-info' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__setting__icon">
                                                    <i class="item setting-icon"></i>
                                                </div>
                                                <div class="header-right__menu__mobile__text">アカウント設定</div>
                                            </div>
                                        </a>
                                        <a href="{{route('client.handle-logout')}}" id="logout">
                                            <div
                                                    class="header-right__menu__mobile__logout header-right__menu__mobile__parent d-flex align-items-center">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__logout__icon">
                                                    <i class="item logout-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.log_out') }}</div>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div
                                    class="student-tab-btn tab-pane fade {{ Request::is('student/*') || $user && $user->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? 'show active' : ''}}"
                                    id="pills-home" role="tabpanel" aria-labelledby="student-tab-btn">
                                <div class="header-right__menu__mobile student-mobile">
                                    @if(Auth::guard('client')->check())
                                        <a href="{{ route('client.teacher.notice-page') }}">
                                            <div class="header-right__menu__mobile__noti header-right__menu__mobile__parent d-flex mobile-noti
                                                {{ Route::currentRouteName() === 'client.teacher.notice-page' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__text header-right__menu__mobile__noti__icon">
                                                    <img class="icon-noti"
                                                         src="{{ asset("assets/img/clients/header-common/" . (isset($noticePopup) && count($noticePopup) ? 'active-notify.svg' : 'notify.svg')) }}"
                                                         alt="">
                                                </div>
                                                <div class="header-right__menu__mobile__text">通知</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.dashboard') }}">
                                            <div class="header-right__menu__mobile__dashboard header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.dashboard' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__dashboard__icon">
                                                    <i class="item dashboard-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text"> {{ trans('labels.sidebar-left.dashboard') }}</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.purchase-service') }}">
                                            <div class="header-right__menu__mobile__flug header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.purchase-service' ? 'active' : '' }}
                                            {{Route::currentRouteName() == 'client.student.my-page.order' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__flug__icon">
                                                    <i class="item services-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.purchase_service') }}
                                                    ({{isset($purchaseService) && !empty($purchaseService) ? $purchaseService->total() : 0}}
                                                    )
                                                </div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.list') }}">
                                            <div class="header-right__menu__mobile__reload header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.list' ?'active':''}}
                                            {{Route::currentRouteName() == 'client.student.my-page.review' ?'active':''}}
                                            {{Route::currentRouteName() == 'client.student.my-page.detail' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__reload__icon">
                                                    <i class="item transfer-history-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.purchase_history') }}
                                                </div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.message.list') }}">
                                            <div class="header-right__menu__mobile__message header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.message.list' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__message__icon">
                                                    <i class="item chat-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text"> {{ trans('labels.sidebar-left.message') }}
                                                    ({{ $COURSE_MESSAGE_UNREAD_STUDENT ?? 0 }})
                                                </div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.point') }}">
                                            <div class="header-right__menu__mobile__card header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.point' ?'active':''}}
                                            {{Route::currentRouteName() == 'client.student.my-page.coupon' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__card__icon">
                                                    <i class="item voucher-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.points_coupons') }}</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.follow') }}">
                                            <div class="header-right__menu__mobile__user header-right__menu__mobile__parent d-flex align-items-center
                                                {{Route::currentRouteName() == 'client.student.my-page.follow' ?'active':''}}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__user__icon">
                                                    {{--                                    <i class="item profile-plus-icon"></i>--}}
                                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                         xmlns="http:/www.w3.org/2000/svg">
                                                        <path class="user-plus"
                                                              d="M7.22249 8.56358C8.38585 8.56358 9.39324 8.14163 10.2163 7.30912C11.0394 6.47674 11.4567 5.45827 11.4567 4.28166C11.4567 3.10545 11.0394 2.08685 10.2162 1.2542C9.39297 0.421954 8.38572 0 7.22249 0C6.05898 0 5.05187 0.421954 4.22877 1.25433C3.40567 2.08671 2.98828 3.10531 2.98828 4.28166C2.98828 5.45827 3.40567 6.47687 4.2289 7.30925C5.05214 8.14149 6.05939 8.56358 7.22249 8.56358Z"
                                                              fill="#4E5768"/>
                                                        <path class="user-plus"
                                                              d="M14.6311 13.6707C14.6074 13.3243 14.5594 12.9465 14.4887 12.5474C14.4174 12.1454 14.3255 11.7654 14.2155 11.418C14.1019 11.059 13.9474 10.7044 13.7564 10.3647C13.5582 10.012 13.3253 9.70496 13.0641 9.45228C12.7909 9.18793 12.4564 8.97539 12.0696 8.82037C11.6841 8.66615 11.2569 8.58803 10.8 8.58803C10.6205 8.58803 10.447 8.66249 10.1118 8.88316C9.90552 9.0192 9.66423 9.17654 9.39492 9.35055C9.16463 9.49894 8.85266 9.63796 8.46734 9.76383C8.09139 9.88685 7.70968 9.94924 7.33294 9.94924C6.95619 9.94924 6.57462 9.88685 6.19827 9.76383C5.81335 9.6381 5.50138 9.49907 5.27136 9.35069C5.0046 9.1783 4.76318 9.02097 4.55381 8.88303C4.21905 8.66235 4.04536 8.58789 3.86591 8.58789C3.40882 8.58789 2.98178 8.66615 2.59645 8.8205C2.20991 8.97526 1.87528 9.18779 1.60181 9.45241C1.34067 9.70523 1.10771 10.0122 0.909744 10.3647C0.718889 10.7044 0.564382 11.0588 0.450647 11.4181C0.340802 11.7655 0.248929 12.1454 0.177576 12.5474C0.106895 12.9459 0.0588792 13.3239 0.0351398 13.6711C0.0118027 14.0113 0 14.3644 0 14.7209C0 15.6489 0.291713 16.4002 0.866959 16.9543C1.4351 17.501 2.18685 17.7784 3.10101 17.7784H11.5657C12.4798 17.7784 13.2313 17.5011 13.7996 16.9543C14.375 16.4006 14.6667 15.6492 14.6667 14.7208C14.6665 14.3626 14.6546 14.0093 14.6311 13.6707Z"
                                                              fill="#4E5768"/>
                                                        <circle cx="12.8885" cy="14.6668" r="3.11111" fill="#F9FAFB"/>
                                                        <rect class="user-plus" x="10.2227" y="14.2219" width="4.44445"
                                                              height="0.88889"
                                                              rx="0.444445" fill="#4E5768"/>
                                                        <rect class="user-plus" x="12.8887" y="12.4448" width="4.44445"
                                                              height="0.88889"
                                                              rx="0.444445"
                                                              transform="rotate(90 12.8887 12.4448)" fill="#4E5768"/>
                                                    </svg>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.follow') }}</div>
                                            </div>
                                        </a>
                                        <a href="{{ route('client.student.my-page.account-setting') }}">
                                            <div class="header-right__menu__mobile__setting header-right__menu__mobile__parent d-flex align-items-center
                                                {{ Route::currentRouteName() == 'client.student.my-page.edit-profile' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.account-setting' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.change-password' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.notify-setting' ? 'active' : '' }}
                                            {{ Route::currentRouteName() == 'client.student.my-page.credit-card-info' ? 'active' : '' }}">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__setting__icon">
                                                    <i class="item setting-icon"></i>
                                                </div>
                                                <div class="header-right__menu__mobile__text">アカウント設定</div>
                                            </div>
                                        </a>
                                        <a href="{{route('client.handle-logout')}}" id="logout">
                                            <div
                                                    class="header-right__menu__mobile__logout header-right__menu__mobile__parent d-flex align-items-center">
                                                <div
                                                        class="header-right__menu__mobile__item header-right__menu__mobile__logout__icon">
                                                    <i class="item logout-icon"></i>
                                                </div>
                                                <div
                                                        class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.log_out') }}</div>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div
                                class="teacher-tab-btn tab-pane fade {{ Request::is('teacher/*') && $user && $user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER ? 'show active' : ''}}"
                                id="pills-profile" role="tabpanel" aria-labelledby="teacher-tab-btn">
                            <div class="header-right__menu__mobile teacher-mobile">
                                @if(Auth::guard('client')->check())
                                    <div class="header-right__menu__mobile__wrap-role custom-wrapper">
                                        @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                                            @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                                <div class="role-item position-relative">
                                                    <div class="icon-left position-absolute">
                                                        <img src="{{ asset('assets/img/teacher-page/icon/id1.svg') }}"
                                                             alt="">
                                                    </div>
                                                    <div class="text-center text-content">
                                                        {{ trans('labels.sidebar-left.identification') }}
                                                    </div>

                                                    <div class="icon-right position-absolute">
                                                        <img src="{{ asset('assets/img/clients/teacher/check.svg') }}"
                                                             alt="">
                                                    </div>

                                                </div>
                                            @endif
                                        @else
                                            @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                                <div class="role-item position-relative">
                                                    <div class="icon-left position-absolute">
                                                        <img src="{{ asset('assets/img/teacher-page/icon/id1.svg') }}"
                                                             alt="">
                                                    </div>
                                                    <div class="text-center text-content">
                                                        {{ trans('labels.sidebar-left.identification') }}
                                                    </div>

                                                    <div class="icon-right position-absolute">
                                                        <img src="{{ asset('assets/img/clients/teacher/check.svg') }}"
                                                             alt="">
                                                    </div>

                                                </div>
                                            @endif
                                            @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS|| $user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING)
                                                <div class="role-item position-relative nda">
                                                    <div class="icon-left position-absolute">
                                                        <img src="{{ asset('assets/img/teacher-page/icon/deal1.svg') }}"
                                                             alt="">
                                                    </div>
                                                    <div class="text-center text-content">
                                                        {{ trans('labels.sidebar-left.agreement') }}
                                                    </div>
                                                    @if($user->nda_status == \App\Enums\DBConstant::NDA_STATUS_CONTRACT )
                                                        <div class="icon-right position-absolute">
                                                            <img
                                                                    src="{{ asset('assets/img/clients/teacher/check.svg') }}"
                                                                    alt="">
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="role-item position-relative">
                                                    <div class="icon-left position-absolute">
                                                        <img
                                                                src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                                                alt="">
                                                    </div>
                                                    <div class="text-center text-content">
                                                        {{ trans('labels.sidebar-left.qualification') }}
                                                    </div>
                                                    @if($user->business_card_verification_status == \App\Enums\DBConstant:: BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                                        <div class="icon-right position-absolute">
                                                            <img
                                                                    src="{{ asset('assets/img/clients/teacher/check.svg') }}"
                                                                    alt="">
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                        @endif
                                    </div>
                                    <a>
                                        <div class="header-right__menu__mobile__noti header-right__menu__mobile__parent d-flex mobile-noti
                                            {{ Route::currentRouteName() === 'client.teacher.notice-page' ? 'active' : '' }}">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__text header-right__menu__mobile__noti__icon">
                                                <img class="icon-noti"
                                                     src="{{ asset("assets/img/clients/header-common/" . (isset($noticePopup) && count($noticePopup) ? 'active-notify.svg' : 'notify.svg')) }}"
                                                     alt="">
                                            </div>
                                            <div class="header-right__menu__mobile__text">通知</div>
                                        </div>
                                    </a>
                                    {{-- TEACHER MOBILE --}}
                                    <a href="{{ route('client.teacher.my-page.dashboard') }}">
                                        <div class="header-right__menu__mobile__dashboard header-right__menu__mobile__parent d-flex align-items-center
                                            {{ Route::currentRouteName() == 'client.teacher.my-page.dashboard' ? 'active' : '' }}">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__dashboard__icon">
                                                <i class="item dashboard-icon"></i>
                                            </div>
                                            <div
                                                    class="header-right__menu__mobile__text"> {{ trans('labels.sidebar-left.dashboard') }}</div>
                                        </div>
                                    </a>
                                    <a @if(auth('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS) href="{{ route('client.teacher.my-page.service-list', 'tab=new') }}"
                                       @else href="{{ route('client.teacher.my-page.service-list', 'tab=clone') }}" @endif>
                                        <div class="header-right__menu__mobile__flug header-right__menu__mobile__parent d-flex align-items-center
                                            {{ Route::currentRouteName() == 'client.teacher.my-page.service-list.list-student' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.my-page.service-list' ? 'active' : '' }}">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__flug__icon">
                                                <i class="item sale-manager-icon"></i>
                                            </div>
                                            <div
                                                    class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.sales_service_management') }}
                                                ({{$totalCourseScheduleOpen ?? 0}})
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ route('client.teacher.sale') }}">
                                        <div class="header-right__menu__mobile__reload header-right__menu__mobile__parent d-flex align-items-center
                                            {{ Route::currentRouteName() == 'client.teacher.sale' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.my-page.sale-historystudent-list' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.my-page.sale-historyreview' ? 'active' : '' }}">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__reload__icon">
                                                <i class="item transfer-history-icon"></i>
                                            </div>
                                            <div
                                                    class="header-right__menu__mobile__text"> {{ trans('labels.sidebar-left.sales_history') }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ route('client.teacher.my-page.message.message-course') }}"
                                       class="@if(in_array(\Illuminate\Support\Facades\Route::currentRouteName(), \App\Enums\Constant::ROUTE_TEACHER_MESSAGE)) active @endif
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message.message-course' ? 'active' : '' }}
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message.buyer' ? 'active' : '' }}
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message.not-buyer' ? 'active' : '' }}
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message.course-not-buyer' ? 'active' : '' }}
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message.notice' ? 'active' : '' }}
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message.notification' ? 'active' : '' }}
                                       {{ Route::currentRouteName() == 'client.teacher.my-page.message. inquiry-list' ? 'active' : '' }}">
                                        <li class="header-right__menu__mobile__reload header-right__menu__mobile__parent d-flex align-items-center">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__reload__icon">
                                                <i class="item chat-icon item-icon"></i>
                                            </div>
                                            <div class="header-right__menu__mobile__text">
                                                {{ trans('labels.sidebar-left.message') }}
                                                ({{ $COURSE_MESSAGE_UNREAD ?? 0 }})
                                            </div>
                                        </li>
                                    </a>
                                    <a href="{{ route('client.teacher.mypage-teacher-follower') }}"
                                       class="{{ Route::currentRouteName() == 'client.teacher.mypage-teacher-follower' ? 'active' : '' }}">
                                        <div
                                                class="header-right__menu__mobile__card header-right__menu__mobile__parent d-flex align-items-center">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__card__icon"
                                                    style="top: -1px">
                                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                     xmlns="http:/www.w3.org/2000/svg">
                                                    <path class="user-plus"
                                                          d="M7.22249 8.56358C8.38585 8.56358 9.39324 8.14163 10.2163 7.30912C11.0394 6.47674 11.4567 5.45827 11.4567 4.28166C11.4567 3.10545 11.0394 2.08685 10.2162 1.2542C9.39297 0.421954 8.38572 0 7.22249 0C6.05898 0 5.05187 0.421954 4.22877 1.25433C3.40567 2.08671 2.98828 3.10531 2.98828 4.28166C2.98828 5.45827 3.40567 6.47687 4.2289 7.30925C5.05214 8.14149 6.05939 8.56358 7.22249 8.56358Z"
                                                          fill="#4E5768"/>
                                                    <path class="user-plus"
                                                          d="M14.6311 13.6707C14.6074 13.3243 14.5594 12.9465 14.4887 12.5474C14.4174 12.1454 14.3255 11.7654 14.2155 11.418C14.1019 11.059 13.9474 10.7044 13.7564 10.3647C13.5582 10.012 13.3253 9.70496 13.0641 9.45228C12.7909 9.18793 12.4564 8.97539 12.0696 8.82037C11.6841 8.66615 11.2569 8.58803 10.8 8.58803C10.6205 8.58803 10.447 8.66249 10.1118 8.88316C9.90552 9.0192 9.66423 9.17654 9.39492 9.35055C9.16463 9.49894 8.85266 9.63796 8.46734 9.76383C8.09139 9.88685 7.70968 9.94924 7.33294 9.94924C6.95619 9.94924 6.57462 9.88685 6.19827 9.76383C5.81335 9.6381 5.50138 9.49907 5.27136 9.35069C5.0046 9.1783 4.76318 9.02097 4.55381 8.88303C4.21905 8.66235 4.04536 8.58789 3.86591 8.58789C3.40882 8.58789 2.98178 8.66615 2.59645 8.8205C2.20991 8.97526 1.87528 9.18779 1.60181 9.45241C1.34067 9.70523 1.10771 10.0122 0.909744 10.3647C0.718889 10.7044 0.564382 11.0588 0.450647 11.4181C0.340802 11.7655 0.248929 12.1454 0.177576 12.5474C0.106895 12.9459 0.0588792 13.3239 0.0351398 13.6711C0.0118027 14.0113 0 14.3644 0 14.7209C0 15.6489 0.291713 16.4002 0.866959 16.9543C1.4351 17.501 2.18685 17.7784 3.10101 17.7784H11.5657C12.4798 17.7784 13.2313 17.5011 13.7996 16.9543C14.375 16.4006 14.6667 15.6492 14.6667 14.7208C14.6665 14.3626 14.6546 14.0093 14.6311 13.6707Z"
                                                          fill="#4E5768"/>
                                                    <circle cx="12.8885" cy="14.6668" r="3.11111" fill="#F9FAFB"/>
                                                    <rect class="user-plus" x="10.2227" y="14.2219" width="4.44445"
                                                          height="0.88889" rx="0.444445"
                                                          fill="#4E5768"/>
                                                    <rect class="user-plus" x="12.8887" y="12.4448" width="4.44445"
                                                          height="0.88889" rx="0.444445"
                                                          transform="rotate(90 12.8887 12.4448)" fill="#4E5768"/>
                                                </svg>
                                            </div>
                                            <div class="header-right__menu__mobile__text">
                                                {{ trans('labels.sidebar-left.follower') }}({{$teacherFollow ?? 0}})
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{route('client.teacher.profit-livestream')}}">
                                        <div class="header-right__menu__mobile__card header-right__menu__mobile__parent d-flex align-items-center
                                            {{ Route::currentRouteName() == 'client.teacher.profit-livestream' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.my-page.transfer-apply' ? 'active' : '' }}">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__card__icon">
                                                <i class="item application-sale-icon"></i>
                                            </div>
                                            <div
                                                    class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.sales_management') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('client.teacher.mypage-teacher-settingAccount') }}">
                                        <div class="header-right__menu__mobile__setting header-right__menu__mobile__setting header-right__menu__mobile__parent d-flex align-items-center
                                            {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-settingAccount' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-info-edit' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-verifi-identity' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-credentials' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-delete-account' ? 'active' : '' }}">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__setting__icon">
                                                <i class="item setting-icon"></i>
                                            </div>
                                            <div
                                                    class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.account_settings') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{route('client.teacher.seller-user-guide')}}"
                                       class="{{ Route::currentRouteName() === 'client.teacher.seller-user-guide' ? 'active' : '' }}">
                                        <div
                                                class="header-right__menu__mobile__setting header-right__menu__mobile__setting header-right__menu__mobile__parent d-flex align-items-center">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__setting__icon">
                                                <i class="item guide-icon item-icon"></i>
                                            </div>
                                            <div class="header-right__menu__mobile__text">
                                                {{ trans('labels.sidebar-left.seller_user_guide') }}
                                            </div>
                                        </div>
                                    </a>
                                @endif

                                @if(Auth::guard('client')->check())
                                    <a href="{{route('client.handle-logout')}}" id="logout">
                                        <div
                                                class="header-right__menu__mobile__logout header-right__menu__mobile__parent d-flex align-items-center">
                                            <div
                                                    class="header-right__menu__mobile__item header-right__menu__mobile__logout__icon">

                                                <i class="item logout-icon"></i>
                                            </div>
                                            <div
                                                    class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.log_out') }}</div>
                                        </div>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
            class="header-search  {{ in_array(\Request::route() ? Request::route()->getName() : null, \App\Enums\Constant::LIST_SCREEN_SP_SEARCH_FORM) ? 'show-search' : '' }}">
        <div class="header-right-search-sp">
            <form action="{{route('client.home.search')}}">
                <div class="header-right__mobile__search">
                    <div class="icon-search-mobile">
                        <button>
                            <img class="icon-search-mobile__img"
                                 src="{{url('assets/img/clients/header-common/search.svg')}}"
                                 alt="icon-search">
                        </button>
                    </div>
                    <input id="search-option-header" type="text" value="{{request()->get('keyword') ?? ''}}"
                           name="keyword" autocomplete="off" placeholder="キーワードで検索">
                </div>
            </form>
        </div>
    </div>
</header>
<script src="{{ mix('js/clients/modules/header.js') }}"></script>
