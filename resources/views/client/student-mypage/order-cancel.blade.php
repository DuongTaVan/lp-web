@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .sidebar-right__list__text {
            padding-left: 6px;
        }

        .sidebar-right__navbar__order:hover {
            color: rgba(78, 87, 104, 0.4) !important;
        }

        .sidebar-right__navbar {
            margin-top: 20px;
            margin-left: 0 !important;
        }

        .sidebar-right__navbar__order {
            padding: 0px 12px 10px 12px;
        }

        .sidebar-right__navbar__cancel {
            padding: 0px 12px 7px 12px;
        }

        .main {
            background: #fff !important;
        }

        .sidebar-right__list {
            margin-top: 20px;
        }

        .sidebar-right__table {
            margin-top: 21px;
        }

        .sidebar-right__table__data__col1 {
            margin: 0;
        }

        .sidebar-right__table__data__col1:hover {
            text-decoration: none;
        }

        .sidebar-right__table__data__cancel {
            background-color: #F4664E;
        }

        .sidebar-right__list::before {
            left: 0px;
            height: 21px;
        }

        .col1-outline {
            padding: 8px 12px !important;
        }

        .sidebar-right__modal-content__content__cancel {
            border: 1px solid rgba(78, 87, 104, 0.2);
        }

        th:nth-child(3) {
            min-width: 110px;
        }

        th:nth-child(6) {
            min-width: 150px;
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
                        @lang('labels.order-cancel.in-purchase_service')
                    </div>
                </div>
            </div>
            @include('client.common.header-order')
            <div class="tab-content">
                <div class="table_head table_head--nobtn d-flex justify-content-between align-items-center ">
                    <div class="border-rotate">
                        <p class="table_title">
                            @lang('labels.order-cancel.service_list')
                        </p>
                    </div>
                </div>
                <div class="sidebar-right__table">
                    @if($orderCancels->total())
                        <table>
                            <tr class="sidebar-right__table__header">
                                <th>サービス名</th>
                                <th>開催日</th>
                                <th>時間</th>
                                <th>締切日</th>
                                <th>時間</th>
                                <th>キャンセル</th>
                            </tr>
                            @foreach($orderCancels as $orderCancel)
                                <tr class="sidebar-right__table__data">
                                    <td class="col1-outline">
                                        <a class="sidebar-right__table__data__col1 @if(!isset($orderCancel->parent_course_id)) order-cancel-active @endif"
                                           @if(!isset($orderCancel->parent_course_id)) href="{{ route('client.course-schedules.detail', ['course_schedule_id' => $orderCancel['course_schedule_id']]) }}" @endif>
                                            <div class="sidebar-right__table__data__col1__text">
                                                {{$orderCancel->title_course}}
                                            </div>
                                            <div class="sidebar-right__table__data__col1__price">
                                                ¥{{number_format($orderCancel->price, 0, ',', ',')}}
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{Carbon\Carbon::parse($orderCancel->start_datetime)->format('Y/m/d')}}</td>
                                    <td>@if(isset($orderCancel->actual_start_date))
                                            {{Carbon\Carbon::parse($orderCancel->actual_start_date)->format('H:i')}}
                                            - {{Carbon\Carbon::parse($orderCancel->actual_end_date)->format('H:i')}}
                                        @else
                                            {{Carbon\Carbon::parse($orderCancel->start_datetime)->format('H:i')}}
                                            - {{Carbon\Carbon::parse($orderCancel->end_datetime)->format('H:i')}}
                                        @endif</td>
                                    <td>{{Carbon\Carbon::parse($orderCancel->end_datetime)->subDay(1)->format('Y/m/d')}}</td>
                                    <td style="padding-left: 10px; padding-right: 10px">21:59</td>
                                    <td>
                                        @if(now() > (Carbon\Carbon::parse($orderCancel->start_datetime)->subDay(1)->format('Y-m-d')) .' '. \App\Enums\Constant::TIME_ORDER_CANCEL)
                                            <div class="sidebar-right__table__data__end">
                                                @lang('labels.order-cancel.end')
                                            </div>
                                        @else
                                            <button type="button" data-toggle="modal"
                                                    data-target="#exampleModal"
                                                    class="btn sidebar-right__table__data__cancel"
                                                    data-id="{{$orderCancel->course_schedule_id}}">
                                                @lang('labels.order-cancel.btn_cancel')
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>

            @if(!empty($orderCancels))
                {{ $orderCancels->appends(request()->query())->links('client.layout.paginate') }}
            @endif
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="sidebar-right__modal-content__header">
                            <div id="sidebar-right__modal-content__header__text"
                                 class="sidebar-right__modal-content__header__text">
                                @lang('labels.button.confirm-cancel')
                            </div>
                        </div>
                        <div class="sidebar-right__modal-content__content">
                            <button class="btn sidebar-right__modal-content__content__cancel"
                                    data-dismiss="modal" aria-label="Close">
                                @lang('labels.button.cancel')
                            </button>
                            <button id="sidebar-right__modal-content__content__ok"
                                    class="btn sidebar-right__modal-content__content__ok"
                                    data-url="{{route('client.student.cancel-participation')}}">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="showMessageCancel" tabindex="-1" role="dialog"
                 aria-labelledby="showMessageCancel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="sidebar-right__modal-content__header">
                            <div id="messageCancel"
                                 class="sidebar-right__modal-content__header__text">
                                @lang('labels.button.confirm-cancel')
                            </div>
                        </div>
                        <div class="sidebar-right__modal-content__content">
                            <button data-dismiss="modal"
                                    class="btn sidebar-right__modal-content__content__ok"
                                    id="closeCancelModel">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script src="{{ mix('js/clients/orders/cancel-order.js') }}"></script>
@endsection
