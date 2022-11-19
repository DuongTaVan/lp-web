@extends('client.base.base')
@section('css')
    <style>
        .sidebar-right__list::before {
            left: 1px;
        }

        .container .sidebar {
            margin-right: unset !important;
        }

        .main {
            background: #fff !important;
        }

        .sidebar-right__table__data__td {
            padding: 3px 0 !important;
        }

        .sidebar-right__table__data__col1__text {
            max-width: 300px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .sidebar-right__list {
            margin-top: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-wrapper purchase custom-dashboard custom-purchase">
        @include('client.student-mypage.sidebar-left')
        <div class="main_content">
            @include('client.common.dashboard-role')
            <div class="sidebar-right">
                <div class="col-md-12 d-flex justify-content-start purchase_head">
                    <div class="purchase_title f-w6">
                        @lang('labels.order-list.purchase_history_review')
                    </div>
                </div>

            </div>
            <ul class="nav nav-custom-purchase nav-custom-purchase--select">
                <li class="nav-item">
                    <a href="{{route('client.student.my-page.list')}}"
                       class="nav-item-link active">@lang('labels.order-list.purchase_history')</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('client.student.my-page.review')}}"
                       class="nav-item-link">@lang('labels.order-list.review')</a>
                </li>
                @include('client.common.year-search',['yearOption'=>$purchaseHistories])
            </ul>
            <div class="tab-content">
                <div class="table_head table_head--select">
                    <div class="border-rotate">
                        <div class="table_title">
                            @lang('labels.order-list.service_list')
                        </div>
                    </div>
                    @if(count($purchaseHistories['listPurchaseHistory']) > 0)
                        @include('client.common.option-search')
                    @endif
                </div>
                <div class="sidebar-right__table">
                    @if(count($purchaseHistories['listPurchaseHistory']) > 0)
                        <table class="order-list-table">
                            <tr class="sidebar-right__table__header">
                                <th class="order-list-table__th">サービス名</th>
                                <th class="order-list-table__th">開催日</th>
                                <th class="order-list-table__th">時間</th>
                                <th class="order-list-table__th">支払い</th>
                                <th class="order-list-table__th">支払い明細</th>
                            </tr>
                            @foreach($purchaseHistories['listPurchaseHistory'] as $purchaseHistory)
                                <tr class="sidebar-right__table__data">
                                    <td class="sidebar-right__table__data__td">
                                        <div class="sidebar-right__table__data__image">
                                            <img src="{{asset($purchaseHistory->image_url)}}" alt="">
                                        </div>
                                        <div class="sidebar-right__table__data__col1">
                                            <div class="sidebar-right__table__data__col1__text">{{$purchaseHistory->title_course}}</div>
                                            <div class="sidebar-right__table__data__col1__price">
                                                ¥{{number_format($purchaseHistory->price, 0, ',', ',')}}</div>
                                        </div>
                                    </td>
                                    <td>{{Carbon\Carbon::parse($purchaseHistory->start_datetime)->format('Y/m/d')}}</td>
                                    <td>
                                        @if(isset($purchaseHistory->actual_start_date))
                                            {{Carbon\Carbon::parse($purchaseHistory->actual_start_date)->format('H:i')}}
                                            - {{Carbon\Carbon::parse($purchaseHistory->actual_end_date)->format('H:i')}}
                                        @else
                                            {{Carbon\Carbon::parse($purchaseHistory->start_datetime)->format('H:i')}}
                                            - {{Carbon\Carbon::parse($purchaseHistory->end_datetime)->format('H:i')}}
                                        @endif
                                    </td>
                                    <td>{{$purchaseHistory->card_brand}}</td>
                                    <td>
                                        <a href="{{route('client.student.my-page.detail',$purchaseHistory->course_schedule_id)}}"
                                           class="btn sidebar-right__table__data__cancel">
                                            表示する
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
                @if(!empty($purchaseHistories['listPurchaseHistory']))
                    {{ $purchaseHistories['listPurchaseHistory']->appends(request()->query())->links('client.layout.paginate') }}
                @endif
            </div>

        </div>
    </div>

@endsection
