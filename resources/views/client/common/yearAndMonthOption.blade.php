<div class="sidebar-right__navbar-order-list__day-year text-nowrap">
    <div class="d-flex align-items-center outline-date">
        @if(now()->year - 5 < $yearAndMonthOption['year'] || now()->year - 5 == $yearAndMonthOption['year'] && $yearAndMonthOption['month']>1)
            <a @if(now()->year - 5 < $yearAndMonthOption['year'])
               href="@if($yearAndMonthOption['month'] == 1){{request()->fullUrlWithQuery(['month'=>12, 'year'=>$yearAndMonthOption['year']-1])}}
            @else{{request()->fullUrlWithQuery(['month'=>$yearAndMonthOption['month']-1, 'year'=>$yearAndMonthOption['year']])}}
            @endif"

               @elseif(now()->year - 5 == $yearAndMonthOption['year'] && $yearAndMonthOption['month']>1) href="@if($yearAndMonthOption['month'] == 1){{request()->fullUrlWithQuery(['month'=>12, 'year'=>$yearAndMonthOption['year']-1])}}
               @else{{request()->fullUrlWithQuery(['month'=>$yearAndMonthOption['month']-1, 'year'=>$yearAndMonthOption['year']])}}
               @endif"
               @endif
               class="sidebar-right__navbar-order-list__day-year__left"><img
                        src="{{asset('assets/img/student/my-page/icon/left.svg')}}"
                        alt="" width="9" height="16"></a>
        @else
            <a class="sidebar-right__navbar-order-list__day-year__left opacity-50"><img
                        src="{{asset('assets/img/student/my-page/icon/left.svg')}}"
                        alt="" width="9" height="16"></a>
        @endif
        <div class="sidebar-right__navbar-order-list__day-year__number">{{$yearAndMonthOption['month']}}月/{{$yearAndMonthOption['year']}}年
        </div>
{{--        @if(now()->year > $yearAndMonthOption['year'] || now()->year == $yearAndMonthOption['year'] && $yearAndMonthOption['month']< now()->month)--}}
            <a @if(now()->year > $yearAndMonthOption['year']) href="@if($yearAndMonthOption['month'] == 12){{request()->fullUrlWithQuery(['month'=>1, 'year'=>$yearAndMonthOption['year']+1])}}
            @else{{request()->fullUrlWithQuery(['month'=>$yearAndMonthOption['month']+1, 'year'=>$yearAndMonthOption['year']])}}
            @endif"
               @elseif(now()->year == $yearAndMonthOption['year']) href="@if($yearAndMonthOption['month'] == 12){{request()->fullUrlWithQuery(['month'=>1, 'year'=>$yearAndMonthOption['year']+1])}}
               @else{{request()->fullUrlWithQuery(['month'=>$yearAndMonthOption['month']+1, 'year'=>$yearAndMonthOption['year']])}}
               @endif"
               @endif
               class="sidebar-right__navbar-order-list__day-year__right"><img
                        src="{{asset('assets/img/student/my-page/icon/right.svg')}}"
                        alt="" width="12" height="16"></a>
{{--        @else--}}
{{--            <a class="sidebar-right__navbar-order-list__day-year__right opacity-50"><img--}}
{{--                        src="{{asset('assets/img/student/my-page/icon/right.svg')}}"--}}
{{--                        alt=""></a>--}}
{{--        @endif--}}
    </div>
</div>
