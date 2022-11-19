@php
    $user = auth()->guard('client')->user()
@endphp
<style>
    #header .header__notification__list {
        right: 402px;
    }

    @media (max-width: 576px) {
        #header .header__notification__list {
            width: 100%;
            right: 0;
        }
    }

    @media (width: 1440px) {
        #header .header__notification__list {
            right: 194px;
        }
    }
</style>
<header id="header" class="custom-header">
    <div class="header-bar">
        <div class="header header-livestream">
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
            <div class="header__left left-full">
                <div class="header__left__logo">
                    <a href="{{route('client.home')}}">
                        <img class="logo-lappi" src="{{ url('assets/img/clients/header-common/logo.svg') }}"
                             alt="Logo-Lappi">
                    </a>
                    {{--                    <a href="{{route('client.home')}}" class="header__left__logo__text">Lappi</a>--}}
                </div>
                <div class="header__left__search">

                </div>
                <div class="header__bar">
                    <div class="flex-column header__bar__icon">
                        @if(\Auth::guard('client')->check())
                            <div class="set-size click-menu-sp">
                                <a>
                                    <img class="default-avatar"
                                         src="{{ auth()->guard('client')->user()->profile_thumbnail }}" alt="">
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
                    <a class="flex-column" href="{{ route('client.become-lappi') }}">
                        <div class="set-size">
                            <img src="{{url('assets/img/clients/header-common/Lappiになる.svg')}}" alt="">
                        </div>
                        <div class="text-lappi">{{ trans('labels.header.become_login') }}</div>
                    </a>
                    <a class="flex-column">
                        <div class="set-size">
                            <img src="{{url('assets/img/clients/header-common/ご利用ガイド.svg')}}" alt="">
                        </div>
                        <div class="user-guide">@lang('labels.header.question')</div>
                    </a>
                </div>
                <div class="layout__hidden"></div>
                <div class="ml-auto livestream-social">
                    <div class="py-2 flex-fill social">
                        <a href="#"
                           class="btn btn-facebook-custom btn-custom text-white">
                            <svg width="18" height="17" viewBox="0 0 20 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M19.686 9.46336C19.686 4.27258 15.4687 0.0637207 10.2674 0.0637207C5.06618 0.0637207 0.848831 4.27258 0.848831 9.46336C0.848831 14.1548 4.29251 18.0435 8.79578 18.7493V12.1813H6.40371V9.46336H8.79578V7.3925C8.79578 5.03714 10.2023 3.73504 12.3534 3.73504C13.384 3.73504 14.4621 3.91883 14.4621 3.91883V6.23224H13.2738C12.1045 6.23224 11.7387 6.95651 11.7387 7.70093V9.46336H14.3507L13.9335 12.1813H11.7391V18.7501C16.2424 18.0447 19.686 14.156 19.686 9.46336Z"
                                      fill="white"/>
                            </svg>
                            <span>{{__('labels.users.teacher_screen.social.facebook')}}</span>
                        </a>
                        <a href="#"
                           class="btn btn-twitter-custom btn-custom text-white">
                            <svg width="20" height="16" viewBox="0 0 22 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.0872 2.79459C20.3368 3.12447 19.5306 3.34735 18.6831 3.4481C19.5575 2.92903 20.2118 2.11208 20.5237 1.14968C19.7021 1.63379 18.8029 1.97454 17.8652 2.15714C17.2346 1.48924 16.3994 1.04656 15.4892 0.897799C14.579 0.749042 13.6448 0.902539 12.8315 1.33446C12.0183 1.76638 11.3715 2.45256 10.9917 3.28646C10.6119 4.12037 10.5202 5.05534 10.7309 5.94622C9.06618 5.8633 7.43759 5.43407 5.95088 4.68638C4.46417 3.93868 3.15255 2.88924 2.10116 1.60616C1.74166 2.22133 1.53495 2.93457 1.53495 3.69417C1.53455 4.37798 1.7043 5.05132 2.02915 5.65444C2.354 6.25757 2.8239 6.77183 3.39715 7.15159C2.73233 7.13061 2.08217 6.95241 1.50079 6.63182V6.68531C1.50073 7.64439 1.83516 8.57395 2.44734 9.31627C3.05952 10.0586 3.91175 10.5679 4.85942 10.7579C4.24268 10.9235 3.59608 10.9479 2.96845 10.8292C3.23583 11.6545 3.75665 12.3761 4.45801 12.8931C5.15936 13.4101 6.00615 13.6966 6.8798 13.7125C5.39672 14.8674 3.56512 15.4939 1.67964 15.4911C1.34565 15.4912 1.01194 15.4719 0.680237 15.4332C2.5941 16.6539 4.82197 17.3017 7.0973 17.2992C14.7996 17.2992 19.0102 10.971 19.0102 5.48261C19.0102 5.3043 19.0057 5.12421 18.9976 4.9459C19.8166 4.35835 20.5236 3.63077 21.0854 2.79727L21.0872 2.79459Z"
                                    fill="white"/>
                            </svg>

                            <span>{{__('labels.users.teacher_screen.social.twitter')}}</a></span>
                        <a href="#"
                           class="btn btn-line-custom btn-custom text-white">
                            <svg width="18" height="17" viewBox="0 0 20 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.5696 8.12921C15.6361 8.12692 15.7024 8.13802 15.7645 8.16183C15.8266 8.18565 15.8832 8.2217 15.9311 8.26784C15.9789 8.31398 16.017 8.36926 16.043 8.43038C16.0689 8.49151 16.0823 8.55723 16.0823 8.62363C16.0823 8.69003 16.0689 8.75576 16.043 8.81688C16.017 8.87801 15.9789 8.93329 15.9311 8.97943C15.8832 9.02556 15.8266 9.06161 15.7645 9.08543C15.7024 9.10925 15.6361 9.12034 15.5696 9.11806H14.1927V9.99938H15.5696C15.6365 9.99612 15.7033 10.0065 15.7661 10.0298C15.8289 10.0531 15.8862 10.0888 15.9347 10.1349C15.9832 10.181 16.0218 10.2365 16.0482 10.2979C16.0746 10.3594 16.0882 10.4255 16.0882 10.4923C16.0882 10.5592 16.0746 10.6253 16.0482 10.6868C16.0218 10.7482 15.9832 10.8036 15.9347 10.8497C15.8862 10.8958 15.8289 10.9316 15.7661 10.9549C15.7033 10.9782 15.6365 10.9886 15.5696 10.9853H13.6994C13.5687 10.9848 13.4435 10.9327 13.3511 10.8403C13.2588 10.7479 13.2069 10.6228 13.2067 10.4923V6.75552C13.2067 6.48348 13.4275 6.26021 13.6994 6.26021H15.5731C15.7003 6.26677 15.82 6.32188 15.9075 6.41413C15.995 6.50638 16.0436 6.6287 16.0432 6.75574C16.0428 6.88278 15.9935 7.00481 15.9054 7.09654C15.8174 7.18827 15.6973 7.24267 15.5702 7.24847H14.1933V8.1298L15.5696 8.12921ZM12.5474 10.4917C12.5463 10.6226 12.4935 10.7477 12.4005 10.8399C12.3074 10.9322 12.1817 10.984 12.0506 10.9841C11.973 10.9849 11.8962 10.9676 11.8264 10.9336C11.7566 10.8997 11.6957 10.85 11.6485 10.7885L9.73243 8.18738V10.4912C9.73243 10.6219 9.68039 10.7473 9.58777 10.8397C9.49515 10.9322 9.36953 10.9841 9.23854 10.9841C9.10755 10.9841 8.98193 10.9322 8.88931 10.8397C8.79669 10.7473 8.74465 10.6219 8.74465 10.4912V6.75434C8.74465 6.54341 8.88299 6.35422 9.08195 6.28665C9.13109 6.26933 9.1829 6.26078 9.23501 6.26139C9.38806 6.26139 9.52934 6.34423 9.62411 6.46057L11.5555 9.06753V6.75434C11.5555 6.48231 11.7763 6.25904 12.0494 6.25904C12.3225 6.25904 12.5462 6.48231 12.5462 6.75434L12.5474 10.4917ZM8.04061 10.4917C8.03999 10.6228 7.98735 10.7483 7.89423 10.8407C7.8011 10.9331 7.67509 10.9849 7.54378 10.9847C7.41345 10.9836 7.28883 10.9312 7.197 10.8389C7.10517 10.7466 7.05357 10.6218 7.05342 10.4917V6.75493C7.05342 6.48289 7.27417 6.25962 7.54731 6.25962C7.81986 6.25962 8.0412 6.48289 8.0412 6.75493L8.04061 10.4917ZM6.10568 10.9847H4.23196C4.1008 10.9844 3.97505 10.9325 3.88203 10.8402C3.789 10.7479 3.73622 10.6227 3.73513 10.4917V6.75493C3.73513 6.48289 3.95882 6.25962 4.23196 6.25962C4.5051 6.25962 4.72585 6.48289 4.72585 6.75493V9.99879H6.10568C6.23666 9.99879 6.36229 10.0507 6.45491 10.1432C6.54753 10.2356 6.59957 10.361 6.59957 10.4917C6.59957 10.6225 6.54753 10.7479 6.45491 10.8403C6.36229 10.9328 6.23666 10.9847 6.10568 10.9847ZM19.2093 8.48056C19.2093 4.27312 14.9809 0.848877 9.79071 0.848877C4.60047 0.848877 0.372101 4.27312 0.372101 8.48056C0.372101 12.2509 3.72336 15.409 8.24841 16.0088C8.5551 16.0729 8.97188 16.211 9.0796 16.4712C9.17438 16.7063 9.14082 17.0705 9.11021 17.3191L8.98129 18.1176C8.94421 18.3532 8.79116 19.0453 9.80307 18.6229C10.8179 18.2004 15.2329 15.4283 17.2102 13.1569C18.5624 11.6792 19.2093 10.161 19.2093 8.48056Z"
                                    fill="white"/>
                            </svg>
                            <span>{{__('labels.users.teacher_screen.social.line')}}</span>
                        </a>
                    </div>
                    <div class="custom-social-button">
                        <div class="sharethis-inline-share-buttons"
                             @if (isset($courseSchedule))
                             data-url="{{ route('client.course-schedules.detail', ['course_schedule_id' => $courseSchedule->course_schedule_id]) }}"
                            @endif
                        ></div>
                    </div>
                </div>
            </div>

            <div class="header-right">
                <div class="header-right__close">
                    <img src="{{url('assets//img/clients/header-common/close.svg')}}" alt="">
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
                                                     src="{{ auth()->guard('client')->user()->profile_thumbnail }}"
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
                                                    src="{{ auth()->guard('client')->user()->profile_thumbnail }}"
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
                                <div id="profile-img-teacher"
                                     class="teacher-tab-btn change-tab-img tab-pane fade {{ Request::is('teacher/*') && $user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER ? 'show active' : ''}}">
                                    <div class="header-right__menu__user__icon">
                                        <a href="{{auth()->guard('client')->user()->user_type === \App\Enums\DBConstant::USER_TYPE_STUDENT ? route('client.student.my-page.dashboard') : route('client.teacher.my-page.dashboard')}}">
                                            <img class="default-avatar"
                                                src="{{ auth()->guard('client')->user()->profile_thumbnail }}"
                                                alt="">
                                        </a>
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
                            /* #header .header__left {
                                width: 70%;
                            } */

                            #header .header .header-right {
                                width: fit-content;
                            }
                        </style>
                        <a href="{{ route('client.student.my-page.point') }}" class="header-right__menu__price">
                            <div class="header-right__menu__price__icon">
                                <img src="{{url('assets//img/clients/header-common/50コイン.svg')}}" alt="">
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
                                 src="{{url('assets//img/clients/header-common/lappiになる.svg')}}" alt="">
                            <img class="header-right__menu__lappi__logo__mobile"
                                 src="{{url('assets//img/clients/header-common/lappi-mobile.svg')}}" alt="">
                        </div>
                        <div class="header-right__menu__lappi__text">{{ trans('labels.header.become_login') }}</div>
                    </a>
                    <a class="header-right__menu__question" href="{{route('client.user-guide')}}">
                        <div class="header-right__menu__question__icon">
                            <img src="{{url('assets//img/clients/header-common/ご利用ガイド.svg')}}" alt="">
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
                                                 xmlns="http://www.w3.org/2000/svg">
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
                                             xmlns="http://www.w3.org/2000/svg">
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
                                             xmlns="http://www.w3.org/2000/svg">
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
                                        <a href="{{ route('client.teacher.notice-page') }}">
                                            <div class="header-right__menu__mobile__noti header-right__menu__mobile__parent d-flex
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
                                                    ({{$COURSE_MESSAGE_UNREAD ?? 0}})
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
                                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
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
                                            <div class="header-right__menu__mobile__noti header-right__menu__mobile__parent d-flex
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
                                                    ({{$COURSE_MESSAGE_UNREAD ?? 0}})
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
                                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
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
                                    <a href="{{ route('client.teacher.notice-page') }}">
                                        <div class="header-right__menu__mobile__noti header-right__menu__mobile__parent d-flex
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
                                    <a href="{{ route('client.teacher.my-page.service-list') }}">
                                        <div class="header-right__menu__mobile__flug header-right__menu__mobile__parent d-flex align-items-center
                                            {{ Route::currentRouteName() == 'client.teacher.my-page.service-list.list-student' ? 'active' : '' }}
                                        {{ Route::currentRouteName() == 'client.teacher.my-page.service-list' ? 'active' : '' }}">
                                            <div
                                                class="header-right__menu__mobile__item header-right__menu__mobile__flug__icon">
                                                <i class="item sale-manager-icon"></i>
                                            </div>
                                            <div
                                                class="header-right__menu__mobile__text">{{ trans('labels.sidebar-left.sales_service_management') }}
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
                                                ({{$COURSE_MESSAGE_UNREAD ?? 0 }})
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
                                                     xmlns="http://www.w3.org/2000/svg">
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
                           name="keyword">
                </div>
            </form>
        </div>
    </div>
</header>
<script>
    $(function () {
        const url = window.location.pathname,
            urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
        const domain = $(location).attr('pathname');

        $('.header-right__menu__mobile a').each(function () {
            let tab = $(this).data('value');
            if (domain === '/') {
                $(this).children(".header-right__menu__mobile__parent").removeClass('active');
            } else if (urlRegExp.test(this.href.replace(/\/$/, '')) || urlRegExp.test(tab)) {
                $(this).children(".header-right__menu__mobile__parent").addClass('active');
            }
        });
    });

    $(document).ready(function () {
        $('#logout').click(function () {
            localStorage.removeItem('isTeacher')
        })
    })

</script>
