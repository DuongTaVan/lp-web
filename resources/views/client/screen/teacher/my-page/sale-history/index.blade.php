@extends('client.base.base')
@section('css')
    <style>
        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td {
            padding: 6px 0px 6px 10px
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="sidebar-left">
            @include('client.screen.teacher.my-page.sidebar-left', ['radioOption'=>$saleHistories['data']])
        </div>
        <div class="content-mypage">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="main-mypage-teacher__content">
                <div class="teacher-sidebar-right service-list-draft">
                    <div class="teacher-sidebar-right__title">
                        <div class="teacher-sidebar-right__title__text">
                            @lang('labels.sidebar-left.sales_history')
                        </div>
                        {{--                                        <div class="teacher-sidebar-right__title__text">--}}
                        {{--                                        + @lang('labels.service-list-draft.create_new')--}}
                        {{--                                        </div>--}}
                    </div>
                    <div class="teacher-sidebar-right__navbar-order-list">
                        <div class="teacher-sidebar-right__navbar-order-list__flex">
                            <div class="teacher-sidebar-right__navbar-order-list__cancel f-w6 cancel-active-tab active">@lang('labels.sale-history.service_list')</div>
                        </div>
                        @if(!empty($saleHistories['data']))
                            @include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $saleHistories['data']])
                        @endif
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        @if($saleHistories['listSaleHistories']->total())
                            @include('client.common.option-search')
                        @endif
                    </div>
                    <div class="teacher-sidebar-right__table table-sale-history">
                        @if($saleHistories['listSaleHistories']->total())
                            <table>
                                <tr class="teacher-sidebar-right__table__header">
                                    <th>@lang('labels.sale-history.title')</th>
                                    <th>@lang('labels.sale-history.event_date')</th>
                                    <th>@lang('labels.sale-history.time')</th>
                                    <th class="text-nowrap">@lang('labels.sale-history.purchase_number')</th>
                                    <th>@lang('labels.sale-history.status')</th>
                                    <th>@lang('labels.sale-history.buyer')</th>
                                    {{--                                <th>@lang('labels.sale-history.review')</th>--}}
                                    <th>@lang('labels.sale-history.review')</th>
                                </tr>
                                @foreach($saleHistories['listSaleHistories'] as $saleHistory)
                                    <tr class="teacher-sidebar-right__table__data">
                                        <td class="teacher-sidebar-right__table__data__td">
                                            <div class="teacher-sidebar-right__table__data__image">
                                                <img style="width: 44px; height: 44px"
                                                     src="{{url($saleHistory->thumbnail)}}"
                                                     alt="">
                                            </div>
                                            <div class="teacher-sidebar-right__table__data__col1">
                                                <div class="teacher-sidebar-right__table__data__col1__text"
                                                     title="{{$saleHistory->title}}">
                                                    {{$saleHistory->title}}
                                                </div>
                                                <div class="teacher-sidebar-right__table__data__col1__price">
                                                    ¥{{number_format($saleHistory->price)}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{Carbon\Carbon::parse($saleHistory->start_datetime)->format('Y/m/d')}}</td>
                                        <td class="text-nowrap">
                                            @if(isset($saleHistory->actual_start_date))
                                                {{Carbon\Carbon::parse($saleHistory->actual_start_date)->format('H:i')}}
                                                - {{Carbon\Carbon::parse($saleHistory->actual_end_date)->format('H:i')}}
                                            @else
                                                {{Carbon\Carbon::parse($saleHistory->start_datetime)->format('H:i')}}
                                                - {{Carbon\Carbon::parse($saleHistory->end_datetime)->format('H:i')}}
                                            @endif
                                        </td>
                                        <td>{{$saleHistory->num_of_applicants}}</td>
                                        <td class="text-nowrap">
                                            @if($saleHistory->status == \App\Enums\Constant::SALE_HISTORY_STATUS || $saleHistory->status == \App\Enums\Constant::STATUS_COURSE_SCHEDULE_HISTORY)
                                                <span class="text-red">@lang('labels.sale-history.end_of_event')</span>
                                            @else
                                                <span class="text-red">@lang('labels.sale-history.canceled')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('client.teacher.my-page.sale-historystudent-list', $saleHistory->course_schedule_id)}}"
                                               class="btn btn-custom btn-status">@lang('labels.sale-history.to_list')</a>
                                        </td>
                                        <td>
                                            @if($saleHistory->status === \App\Enums\Constant::SALE_HISTORY_STATUS_BLADE || $saleHistory->status === \App\Enums\Constant::STATUS_COURSE_SCHEDULE_HISTORY)
                                                @if($saleHistory->reviews_count != 0)
                                                    <a href="{{route('client.teacher.my-page.sale-historyreview',$saleHistory->course_schedule_id)}}"
                                                       class="btn btn-custom btn-status">@lang('labels.sale-history.to_edit')</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                    @if(!empty($saleHistories['listSaleHistories']))
                        {{ $saleHistories['listSaleHistories']->appends(request()->query())->links('client.layout.paginate') }}
                    @endif
                    @if(!empty($orderCancels))
                        <div class="d-flex justify-content-center align-items-center f-w3"
                             style="font-size: 14px;color:#4E5768">
                            {{ $saleHistories['listSaleHistories']->total() }} @lang('labels.pagination.in_piece')
                            @if(count($saleHistories['listSaleHistories']) > 0)
                                {{ ($saleHistories['listSaleHistories']->currentPage()-1) * $saleHistories['listSaleHistories']->perPage() + 1 }}
                            @else
                                0
                            @endif -
                            {{ ($saleHistories['listSaleHistories']->currentPage()-1) * $saleHistories['listSaleHistories']->perPage() + count($saleHistories['listSaleHistories']) }}
                            @lang('labels.pagination.subject')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
    <script>
        let radioButton = document.querySelectorAll('.button-radio');
        radioButton.forEach(el => {
            el.addEventListener('click', () => {
                removeClassActive();
                el.classList.add('active-radio')
            })
        })

        function removeClassActive() {
            radioButton.forEach(el => {
                el.classList.remove('active-radio')
            })
        }
    </script>
@endsection
