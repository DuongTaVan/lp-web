<label for="dashboard-input-check" class="dashboard__navigation">
    <div class="dashboard__line"></div>
    <div class="dashboard__line-sub"></div>
</label>
<input type="checkbox" hidden class="dashboard__input" id="dashboard-input-check">
<label for="dashboard-input-check" class="dashboard_over">
    <div class="sidebar_mobile-close">
        <svg width="20" height="21" viewBox="0 0 20 21" fill="#666" xmlns="http://www.w3.org/2000/svg">
            <rect x="2.12109" width="25" height="3" rx="1.5" transform="rotate(45 2.12109 0)" fill="white"/>
            <rect x="0.121094" y="18" width="25" height="3" rx="1.5" transform="rotate(-45 0.121094 18)" fill="white"/>
        </svg>

    </div>
</label>
@php
    $user = auth()->guard('client')->user()
@endphp
<div class="sidebar sidebar_mobile">
    <div class="sidebar__top d-flex flex-column justify-content-center align-items-center">
        <div class="sidebar_head">
            <div class="point-balance text-center">
                <img src="{{ asset('assets/img/clients/mypage-dashboard/p.svg') }}" alt="">
                <span class="sidebar__point">{{ $user['points_balance'] }}</span>
            </div>
            <img
                    class="my-page-avatar"
                    src="{{ auth()->guard('client')->user()->getOriginal('profile_image') !== null ? auth()->guard('client')->user()->profile_thumbnail : '/assets/img/clients/header-common/not-login.svg' }}"
                    alt="" width="125"
                    height="125">
        </div>

        <div class="sidebar__username">
            {{ $user->full_name }}
        </div>
        <a href="{{ route('client.student.my-page.profile-and-email') ?? 'javascript:void(0)' }}"
           class="sidebar__name ">{{ trans('labels.sidebar-left.profile_editing') }}</a>
    </div>
    <div class="sidebar__main sidebar__main-mobile d-flex flex-column justify-content-center align-items-center">
        <ul id="main-sidebar">
            <li>
                <a href="{{ route('client.student.my-page.dashboard') }}">
                    <i class="item dashboard-icon"></i>
                    {{ trans('labels.sidebar-left.dashboard') }}
                </a>
            </li>
            <li>
                <a href="{{ route('client.student.my-page.order') }}">
                    <i class="item services-icon"></i>
                    {{ trans('labels.sidebar-left.purchase_service') }}(3)
                </a>
            </li>
            <li>
                <a href="{{ route('client.student.my-page.list') }}">
                    <i class="item transfer-history-icon"></i>
                    {{ trans('labels.sidebar-left.purchase_history') }}
                </a>
            </li>
            <li>
                <a href="{{ route('client.student.message.list') }}">
                    <i class="item chat-icon"></i>
                    {{ trans('labels.sidebar-left.message') }}(9)
                </a>
            </li>
            <li>
                <a href="{{ route('client.student.my-page.point') }}">
                    <i class="item voucher-icon"></i>
                    {{ trans('labels.sidebar-left.points_coupons') }}
                </a>
            </li>
            <li>
                <a href="{{ route('client.student.my-page.follow') }}">
                    <i class="item profile-icon"></i>
                    {{ trans('labels.sidebar-left.follow') }}(6)
                </a>
            </li>
            <li>
                <a href="{{ route('client.student.my-page.account-setting') }}">
                    <i class="item setting-icon"></i>
                    {{ trans('labels.sidebar-left.account_settings') }}
                </a>
            </li>
            <li>
                <a href="">
                    <i class="item logout-icon"></i>
                    {{ trans('labels.sidebar-left.log_out') }}
                </a>
            </li>
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
