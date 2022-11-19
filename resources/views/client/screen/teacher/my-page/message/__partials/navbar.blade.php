<div class="teacher-sidebar-right__navbar-order-list__flex">
    <a href="{{route('client.teacher.my-page.message.message-course')}}" class="teacher-link">
        <div class="teacher-sidebar-right__navbar-order-list__cancel @if(Route::currentRouteName() === 'client.teacher.my-page.message.buyer') active @endif">
            @lang('labels.sale-history.buyer')({{ $totalPurchasedUnread ?? 0 }})
        </div>
    </a>
    <a href="{{route('client.teacher.my-page.message.inquiry-list')}}" class="teacher-link">
        <div class="teacher-sidebar-right__navbar-order-list__cancel">
            お問い合わせ
            <strong class="new-notification">
                (<span class="number-new-notification">{{ $totalNotPurchasedUnread ?? 0 }}</span>)
            </strong>
        </div>
    </a>
    <a href="{{route('client.teacher.my-page.message.notice')}}" class="teacher-link">
        <div class="teacher-sidebar-right__navbar-order-list__cancel">
            @lang('labels.sale-history.send_notify')</div>
    </a>
    <a href="{{route('client.teacher.my-page.message.notification')}}" class="teacher-link">
        <div class="teacher-sidebar-right__navbar-order-list__cancel">
            @lang('labels.sale-history.what_new')
            <strong class="new-notification">
                (<span class="number-new-notification">{{$totalMessageNotification['unreadNotification']??0}}</span>)
            </strong>
        </div>
    </a>
</div>
<script>
    $(function () {
        const url = window.location.pathname,
            urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
        $('.teacher-link').each(function () {
            if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
                $(this).children().addClass('active');
            }
        });
    });
</script>
