<div class="sidebar-right__navbar-order-list__flex">
    <a href="{{route('client.teacher.profit-livestream')}}"
       class="sidebar-right__navbar-order-list__order @if(Route::currentRouteName() == 'client.teacher.profit-livestream') active-title @endif">
        @lang('labels.profit-live-stream.sales_management')
    </a>
    <a href="{{route('client.teacher.my-page.transfer-apply')}}"
       class="sidebar-right__navbar-order-list__cancel @if(Route::currentRouteName() == 'client.teacher.my-page.transfer-apply') active-title @endif">
        @lang('labels.profit-live-stream.transfer_application')
    </a>
</div>