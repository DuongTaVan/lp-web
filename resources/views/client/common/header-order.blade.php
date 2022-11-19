<ul class="nav nav-custom-purchase">
    <li class="nav-item">
        <a href="{{route('client.student.my-page.purchase-service')}}" class="nav-item-link">@lang('labels.order-cancel.in-purchase_service_number')</a>
    </li>
    <li class="nav-item">
        <a href="{{route('client.student.my-page.order')}}" class="nav-item-link active">@lang('labels.order-cancel.cancel')
            ({{isset($orderCancelService) && !empty($orderCancelService) ? $orderCancelService->total() : 0}})</a>
    </li>
</ul>
