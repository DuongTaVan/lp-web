<div class="sidebar">
    <div class="sidebar__logo f-w6">
        Lappi管理システム
    </div>
    <div class="sidebar__menu">
        <a href="{{ route('portal.dashboard') }}" class="link {{ Route::is('portal.dashboard') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/dashboard.svg') }}" alt="">
            <span class="sidebar__label f-w6">{{ __('labels.dashboard-livestream.dashboard') }}</span>
        </a>
        <a href="{{ route('portal.user.list') }}" class="link {{ Route::is('portal.user.*') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/user.svg') }}" alt="">
            <span class="sidebar__label f-w6">ユーザー</span>
        </a>
        <a href="{{ route('portal.identity.identity-verification-image') }}"
           class="link position-relative {{ Route::is('portal.identity*') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/verify.svg') }}" alt="">
            <span class="sidebar__label f-w6">本人確認画像承認</span>
            <span class="sidebar__count identity-count {{ $identityVerificationImage > 0 ? '' : 'dp-none' }}">{{$identityVerificationImage}}</span>
        </a>
        <a href="{{ route('portal.business.business-verification-image') }}"
           class="link {{ Route::is('portal.business.*') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/verify2.svg') }}" alt="">
            <span class="sidebar__label f-w6">資格証明画像承認</span>
            <span class="sidebar__count business-count {{ $businessVerificationImage > 0 ? '' : 'dp-none' }}">{{$businessVerificationImage}}</span>
        </a>
        <a href="{{ route('portal.courses.index') }}"
           class="link {{ Route::is('portal.courses.*') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/request-course.svg') }}" alt="">
            <span class="sidebar__label f-w6">新規サービス承認申請</span>
            <span class="sidebar__count course-count {{ $courses > 0 ? '' : 'dp-none' }}">{{$courses}}</span>
        </a>
        <a href="{{route('portal.transfer-histories')}}"
           class="link {{ Route::is('portal.transfer-histories') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/withdraw.svg') }}" alt="">
            <span class="sidebar__label f-w6">振込申請</span>
            <span class="sidebar__count transfer-count {{ $transferHistory > 0 ? '' : 'dp-none' }}">{{$transferHistory}}</span>
        </a>
        <a href="{{route('portal.statistic.index')}}"
           class="link {{ Route::is('portal.statistic.index') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/news.svg') }}" alt="">
            <span class="sidebar__label f-w6">当月業績速報</span>
        </a>
        <a href="{{route('portal.term-statistic.index')}}"
           class="link {{ Route::is('portal.term-statistic.index') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/performent.svg') }}" alt="">
            <span class="sidebar__label f-w6">業績データ（上期・下期）</span>
        </a>
        <a href="{{route('portal.sale.index')}}" class="link {{ Route::is('portal.sale.index') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/sale_details.svg') }}" alt="">
            <span class="sidebar__label f-w6">売上明細</span>
        </a>
        <a class="link" href="https://mail.google.com/mail" target="_blank">
            <img class="sidebar__icon" src="{{ url('assets/img/icons/mail.svg') }}" alt="">
            <span class="sidebar__label f-w6">Email</span>
            @php
                $unseenEmail = $unseenEmail ?? 0
            @endphp
            <span class="sidebar__count email {{ $unseenEmail > 0 ? '' : 'dp-none' }}">{{ $unseenEmail }}</span>
        </a>
        <a href="{{route('portal.box-notification-trans-contents.index')}}"
           class="link {{ Route::is('portal.box-notification-trans-contents.*') ? 'active' : '' }}">
            <img class="sidebar__icon" src="{{ url('assets/img/portal/icons/notice.svg') }}" alt="">
            <span class="sidebar__label f-w6">お知らせ</span>
        </a>
    </div>
</div>
