@extends('client.base.base')
@section('css')
    <style>
        td {
            padding: 17px 0;
            text-align: center;
        }

        .student-name {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .option_tab {
            min-width: 100px;
            position: relative;
        }

        .option_tab_select {
            position: absolute;
            top: -6px;
        }

        @media only screen and (max-width: 767px) {
            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(1) {
                min-width: 135px;
            }

            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(2) {
                min-width: 85px;
            }

            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(5) {
                min-width: 50px;
            }
        }

    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="sidebar-left">
            @include('client.screen.teacher.my-page.sidebar-left')
        </div>

        <div class="content-mypage">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="main-mypage-teacher__content sale-history-student">
                <div class="teacher-sidebar-right service-list-draft">
                    <div class="teacher-sidebar-right__title">
                        <div class="teacher-sidebar-right__title__text">
                            @lang('labels.sidebar-left.sales_history') <img
                                    src="{{asset('assets/img/common/arrow-breadcrumb.svg')}}"
                                    style="margin: 0 7px 0 10px; position: relative; top: -3px" alt="Image"> 一覧
                        </div>
                    </div>
                    <div class="teacher-sidebar-right__navbar-order-list student_list d-flex justify-content-between col-12">
                        <div class="teacher-sidebar-right__navbar-order-list__flex">
                            <div class="teacher-sidebar-right__navbar-order-list__cancel f-w6 active">@lang('labels.sale-history.student_list')</div>
                        </div>
                        <a href="{{route('client.teacher.sale')}}"
                           class="teacher-sidebar-right__title__text back_to_index">
                            @lang('labels.service-list-draft.back_to')
                        </a>
                    </div>
                    @if(!empty($students))
                        @if(isset($students[0]))
                            <div class="teacher-sidebar-right__center">
                                <div class="service-amount d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="service-img" src="{{$students[0]->image}}"
                                             alt="">
                                        <div class="service-title-name">
                                            <span class="service-title-name__title"
                                                  title="{{$students[0]->title}}">{{$students[0]->title}}</span>
                                            <div class="service-describe">
                                                <div class="service-datetime d-flex">
                                                    <span class="service-date f-w3">{{Carbon\Carbon::parse($students[0]->start_datetime)->format('Y/m/d')}}</span>
                                                    <span class="service-time f-w3">
                                                        @if(isset($students[0]->actual_start_date))
                                                            {{Carbon\Carbon::parse($students[0]->actual_start_date)->format('H:i')}}
                                                            - {{Carbon\Carbon::parse($students[0]->actual_end_date)->format('H:i')}}
                                                        @else
                                                            {{$students[0]->hour_minute}}
                                                        @endif
                                                    </span>
                                                </div>
                                                <span class="service-money">
                                                        ¥{{number_format($students[0]->price, 0, ',', ',')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @include('client.common.option-search')
                                </div>
                            </div>

                        @endif
                        <div class="teacher-sidebar-right__table">
                            @if(count($students)>0)
                                <table>
                                    <tr class="teacher-sidebar-right__table__header">
                                        <th>@lang('labels.sale-history.event_date_alt')</th>
                                        <th>@lang('labels.sale-history.time')</th>
                                        <th>@lang('labels.sale-history.nick_name')</th>
                                        <th>@lang('labels.sale-history.sex')</th>
                                        <th>@lang('labels.sale-history.age')</th>
                                        <th>@lang('labels.sale-history.purchase_history')</th>
                                        <th>@lang('labels.sale-history.point')</th>
                                        {{--                                            <th>@lang('labels.sale-history.coupon')</th>--}}
                                        <th>@lang('labels.sale-history.payment')</th>
                                    </tr>
                                    @foreach($students as $student)
                                        <tr class="teacher-sidebar-right__table__data">
                                            <td>{{Carbon\Carbon::parse($student->created_at)->format('Y/m/d')}}</td>
                                            <td>{{Carbon\Carbon::parse($student->created_at)->format('H:i')}}</td>
                                            <td class="student-name"
                                                title="{{$student->full_name}}">{{$student->full_name}}</td>
                                            @if($student->sex == 1)
                                                <td>男性</td>
                                            @elseif($student->sex == 2)
                                                <td>女性</td>
                                            @elseif($student->sex == 9)
                                                <td>その他</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{{$student->current_age - $student->current_age % 10}}</td>
                                            <td>{{$student->count_purchased}}</td>
                                            <td>{{number_format($student->points_balance, 0, ',', ',')}}pt
                                            </td>
                                            {{--                                                <td>￥500 OFF</td>--}}
                                            <td>{{ucwords($student->card_brand)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    @endif
                    @if(!empty($students))
                        {{ $students->appends(request()->query())->links('client.layout.paginate') }}
                    @endif
                    @if(!empty($orderCancels))
                        <div class="d-flex justify-content-center align-items-center f-w3"
                             style="font-size: 14px;color:#4E5768">
                            {{ $students->total() }} @lang('labels.pagination.in_piece')
                            @if(count($students) > 0)
                                {{ ($students->currentPage()-1) * $students->perPage() + 1 }}
                            @else
                                0
                            @endif -
                            {{ ($students->currentPage()-1) * $students->perPage() + count($students) }}
                            @lang('labels.pagination.subject')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
