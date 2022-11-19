@php
    $user = auth()->guard('client')->user()
@endphp
<style>
    .sidebar__main ul .active {
        font-weight: 600;
    }
    .sidebar_head{
        position: relative;
    }
    .rank-icon {
        position: absolute;
        right: 0;
        bottom: 0;
    }
</style>
<div class="sidebar">
    <div class="sidebar__top d-flex flex-column justify-content-center align-items-center">
        <div class="sidebar_head">
            @if(!empty($user))
                <img class="my-page-avatar" src="{{auth()->guard('client')->user()->getOriginal('profile_image') !== null ? auth()->guard('client')->user()->profile_image : '/assets/img/clients/header-common/not-login.svg'}}" alt=""
                     width="125" height="125">
                @switch($user->rank_id)
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
            @endif
        </div>
        <div class="sidebar__username text-center"
             title="@if($user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER)
             {{ $user->full_name }}
             @else
             {{ $user->nickname }}
             @endif">
            @if(!empty($user))
                @if($user->user_type === \App\Enums\DBConstant::USER_TYPE_TEACHER)
                    {{ $user->full_name }}
                @else
                    {{ $user->nickname }}
                @endif
            @endif
        </div>
        <a href="{{ route('client.teacher.mypage-teacher-profile-edit') }}"
           class="sidebar__name ">{{ trans('labels.sidebar-left.profile_editing') }}</a>
    </div>
    @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
            <div class="sidebar__center">
            @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                <div class="item-left custom-item">
                    <div class="icon-left">
                        <img src="{{ asset('assets/img/teacher-page/icon/id1.svg') }}" alt="">
                    </div>
                    <div class="text-center text-custom-default">
                        {{ trans('labels.sidebar-left.identification') }}
                    </div>
                    <div class="icon-right">
                        <img src="{{ asset('assets/img/clients/teacher/check.svg') }}" alt="">
                    </div>
                </div>
            @endif
            </div>
    @else
        <div class="sidebar__center">
            @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                <div class="item-left custom-item">
                    <div class="icon-left">
                        <img src="{{ asset('assets/img/teacher-page/icon/id1.svg') }}" alt="">
                    </div>
                    <div class="text-center text-custom-default">
                        {{ trans('labels.sidebar-left.identification') }}
                    </div>
                    <div class="icon-right">
                        <img src="{{ asset('assets/img/clients/teacher/check.svg') }}" alt="">
                    </div>
                </div>
            @endif
            @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS|| $user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING)
                @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED && $user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT )
                    <div class="item-right custom-item nda">
                        <div class="icon-left">
                            <img src="{{ asset('assets/img/teacher-page/icon/deal1.svg') }}" alt="">
                        </div>
                        <div class="text-center text-custom-default">
                            {{ trans('labels.sidebar-left.agreement') }}
                        </div>

                        <div class="icon-right">
                            <img src="{{ asset('assets/img/clients/teacher/check.svg') }}" alt="">
                        </div>

                    </div>
                @endif
            @else
                @if($user->business_card_verification_status === \App\Enums\DBConstant:: BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                    <div class="item-right custom-item">
                        <div class="icon-left">
                            <img src="{{asset('assets/img/clients/course-detail/qualification.svg')}}" alt="">
                        </div>
                        <div class="text-center text-custom-default">
                            {{ trans('labels.sidebar-left.qualification') }}
                        </div>

                        <div class="icon-right item-icon">
                            <img src="{{ asset('assets/img/clients/teacher/check.svg') }}" alt="">
                        </div>
                    </div>
                @endif
            @endif
        </div>
    @endif
    <div class="sidebar__main d-flex flex-column justify-content-center align-items-center">
        <ul id="main-sidebar">
            <a href="{{ route('client.teacher.my-page.dashboard') }}"
               class="{{ Route::currentRouteName() == 'client.teacher.my-page.dashboard' ? 'active' : '' }}">
                <li>
                    <i class="item dashboard-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.dashboard') }}
                </li>
            </a>
            <a @if(auth('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS) href="{{ route('client.teacher.my-page.service-list','tab=new') }}"
               @else href="{{ route('client.teacher.my-page.service-list','tab=clone') }}" @endif
               class=" {{ Route::currentRouteName() == 'client.teacher.my-page.service-list.list-student' ? 'active' : '' }}
            {{ Route::currentRouteName() == 'client.teacher.my-page.service-list' ? 'active' : '' }}"
            >
                <li class="">
                    <i class="item sale-manager-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.sales_service_management') }} ({{$totalCourseScheduleOpen ?? 0}})
                </li>
            </a>
            <a href="{{ route('client.teacher.sale') }}"
               class="{{ Route::currentRouteName() == 'client.teacher.sale' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.my-page.sale-historystudent-list' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.my-page.sale-historyreview' ? 'active' : '' }}">
                <li>
                    <i class="item transfer-history-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.sales_history') }}
                </li>
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
                <li>
                    <i class="item chat-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.message') }}({{$COURSE_MESSAGE_UNREAD ?? 0 }})
                </li>
            </a>
            <a href="{{ route('client.teacher.mypage-teacher-follower') }}"
               class="{{ Route::currentRouteName() == 'client.teacher.mypage-teacher-follower' ? 'active' : '' }}">
                <li>
                    {{--                    <i class="item profile-icon item-icon"></i>--}}
                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="user-plus"
                              d="M7.22249 8.56358C8.38585 8.56358 9.39324 8.14163 10.2163 7.30912C11.0394 6.47674 11.4567 5.45827 11.4567 4.28166C11.4567 3.10545 11.0394 2.08685 10.2162 1.2542C9.39297 0.421954 8.38572 0 7.22249 0C6.05898 0 5.05187 0.421954 4.22877 1.25433C3.40567 2.08671 2.98828 3.10531 2.98828 4.28166C2.98828 5.45827 3.40567 6.47687 4.2289 7.30925C5.05214 8.14149 6.05939 8.56358 7.22249 8.56358Z"
                              fill="#4E5768"/>
                        <path class="user-plus"
                              d="M14.6311 13.6707C14.6074 13.3243 14.5594 12.9465 14.4887 12.5474C14.4174 12.1454 14.3255 11.7654 14.2155 11.418C14.1019 11.059 13.9474 10.7044 13.7564 10.3647C13.5582 10.012 13.3253 9.70496 13.0641 9.45228C12.7909 9.18793 12.4564 8.97539 12.0696 8.82037C11.6841 8.66615 11.2569 8.58803 10.8 8.58803C10.6205 8.58803 10.447 8.66249 10.1118 8.88316C9.90552 9.0192 9.66423 9.17654 9.39492 9.35055C9.16463 9.49894 8.85266 9.63796 8.46734 9.76383C8.09139 9.88685 7.70968 9.94924 7.33294 9.94924C6.95619 9.94924 6.57462 9.88685 6.19827 9.76383C5.81335 9.6381 5.50138 9.49907 5.27136 9.35069C5.0046 9.1783 4.76318 9.02097 4.55381 8.88303C4.21905 8.66235 4.04536 8.58789 3.86591 8.58789C3.40882 8.58789 2.98178 8.66615 2.59645 8.8205C2.20991 8.97526 1.87528 9.18779 1.60181 9.45241C1.34067 9.70523 1.10771 10.0122 0.909744 10.3647C0.718889 10.7044 0.564382 11.0588 0.450647 11.4181C0.340802 11.7655 0.248929 12.1454 0.177576 12.5474C0.106895 12.9459 0.0588792 13.3239 0.0351398 13.6711C0.0118027 14.0113 0 14.3644 0 14.7209C0 15.6489 0.291713 16.4002 0.866959 16.9543C1.4351 17.501 2.18685 17.7784 3.10101 17.7784H11.5657C12.4798 17.7784 13.2313 17.5011 13.7996 16.9543C14.375 16.4006 14.6667 15.6492 14.6667 14.7208C14.6665 14.3626 14.6546 14.0093 14.6311 13.6707Z"
                              fill="#4E5768"/>
                        <circle cx="12.8885" cy="14.6668" r="3.11111" fill="#F9FAFB"/>
                        <rect class="user-plus" x="10.2227" y="14.2219" width="4.44445" height="0.88889" rx="0.444445"
                              fill="#4E5768"/>
                        <rect class="user-plus" x="12.8887" y="12.4448" width="4.44445" height="0.88889" rx="0.444445"
                              transform="rotate(90 12.8887 12.4448)" fill="#4E5768"/>
                    </svg>
                    {{ trans('labels.sidebar-left.follower') }}({{$teacherFollow ?? 0}})

                </li>
            </a>
            <a href="{{route('client.teacher.profit-livestream')}}"
               class="{{ Route::currentRouteName() == 'client.teacher.profit-livestream' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.my-page.transfer-apply' ? 'active' : '' }}">
                <li>
                    <i class="item application-sale-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.sales_management') }}
                </li>
            </a>
            <a href="{{ route('client.teacher.mypage-teacher-settingAccount') }}"
               class="
               {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-settingAccount' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-info-edit' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-verifi-identity' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-credentials' ? 'active' : '' }}
               {{ Route::currentRouteName() == 'client.teacher.mypage-teacher-delete-account' ? 'active' : '' }}">
                <li>
                    <i class="item setting-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.account_settings') }}
                </li>
            </a>
            <a href="{{route('client.teacher.seller-user-guide')}}"
               class="{{ Route::currentRouteName() === 'client.teacher.seller-user-guide' ? 'active' : '' }}">
                <li>
                    <i class="item guide-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.seller_user_guide') }}
                </li>
            </a>
            <a href="{{route('client.handle-logout')}}">
                <li class="">
                    <i class="item logout-icon item-icon"></i>
                    {{ trans('labels.sidebar-left.log_out') }}
                </li>
            </a>
        </ul>
    </div>
</div>
<script>
    $(function () {
        const url = window.location.pathname,
            urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
        $('ul#main-sidebar li a').each(function () {
            if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
                $(this).parent().addClass('active');
            }
        });
    });
</script>

