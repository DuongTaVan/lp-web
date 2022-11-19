@extends('client.base.base')
@section('css')
    <style>
        .container .sidebar {
            margin-right: unset !important;
        }

        .sidebar-right__list {
            margin-top: 15px;
        }

        .sidebar-right__list::before {
            left: 1px;
        }

        .sidebar-right__navbar-order-list {
            margin-top: 20px !important;
        }

        .sidebar-right__table {
            margin-top: 13px !important;
        }

        .main {
            background: #fff !important;
        }

        .sidebar-right__table__data__td {
            padding: 3px 0 !important;
        }

        .sidebar-right__navbar-order-list {
            margin-top: 10px;
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
                       class="nav-item-link ">@lang('labels.order-list.purchase_history')</a>

                </li>
                <li class="nav-item">
                    <a href="{{route('client.student.my-page.review')}}"
                       class="nav-item-link active">@lang('labels.order-list.review')</a>
                </li>
                @include('client.common.year-search',['yearOption'=>$orderReviews])
            </ul>

            <div class="tab-content">
                <div class="table_head table_head--select">
                    <div class="border-rotate">
                        <div class="table_title">
                            @lang('labels.order-list.service_list')
                        </div>
                    </div>
                    <div class="sidebar-right__navbar-order-list__year option_tab">
                        <!-- <button id="review_and_points_PC" type="button" class="btn sidebar-right__list__review"
                                    data-toggle="tooltip"
                                    data-placement="top" title="終了後30日間まで">
                                @lang('labels.order-list.review_and_points')
                        </button> -->
                        <!-- <button id="review_and_points_SP" type="button" class="btn sidebar-right__list__review">
                                @lang('labels.order-list.review_and_points_SP')
                        </button> -->
                        @include('client.common.option-search')
                    </div>
                </div>
                <div class="sidebar-right__table">
                    @if($orderReviews['listSchedulesReviews']->total())
                        <table class="order-view-table">
                            <tr class="sidebar-right__table__header">
                                <th>サービス名</th>
                                <th>開催日</th>
                                <th>時間</th>
                                <th>ステータス</th>
                                <th>レビュー</th>
                            </tr>
                            @foreach($orderReviews['listSchedulesReviews'] as $orderReview)
                                <tr class="sidebar-right__table__data">
                                    <td class="sidebar-right__table__data__td">
                                        <div class="sidebar-right__table__data__image">
                                            <img src="{{asset($orderReview->thumbnail)}}"
                                                 alt="">
                                        </div>
                                        <div class="sidebar-right__table__data__col1">
                                            <div class="sidebar-right__table__data__col1__text">{{$orderReview->title_course}}</div>
                                            <div class="sidebar-right__table__data__col1__price">
                                                ¥{{number_format($orderReview->price)}}</div>
                                        </div>
                                    </td>
                                    <td>{{Carbon\Carbon::parse($orderReview->start_datetime)->format('Y/m/d')}}</td>
                                    <td>
                                        @if(isset($orderReview->actual_start_date))
                                            {{Carbon\Carbon::parse($orderReview->actual_start_date)->format('H:i')}}
                                            - {{Carbon\Carbon::parse($orderReview->actual_end_date)->format('H:i')}}
                                        @else
                                            {{Carbon\Carbon::parse($orderReview->start_datetime)->format('H:i')}}
                                            - {{Carbon\Carbon::parse($orderReview->end_datetime)->format('H:i')}}
                                        @endif
                                    </td>
                                    @if($orderReview->comment == null)
                                        <td>@lang('labels.order-review.waiting_for_evaluation')</td>
                                        <td>
                                            <a href="{{route('client.student.course.page-review', $orderReview->course_schedule_id)}}"
                                               class="btn sidebar-right__table__data__evaluate">
                                                @lang('labels.order-review.check')
                                            </a>
                                        </td>
                                    @else
                                        <td>@lang('labels.order-review.already')</td>
                                        <td>
                                            <a href="{{route('client.student.course.page-review', $orderReview->course_schedule_id)}}"
                                               class="btn sidebar-right__table__data__see">
                                                @lang('labels.order-review.look')
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
                @if(!empty($orderReviews['listSchedulesReviews']))
                    {{ $orderReviews['listSchedulesReviews']->appends(request()->query())->links('client.layout.paginate') }}
                @endif
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
