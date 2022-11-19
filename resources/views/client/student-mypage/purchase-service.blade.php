@extends('client.base.base')
@section('css')
    <style>
        /*.tab-content {*/
        /*    margin-top: 18px;*/
        /*}*/

        .purchase-a:hover {
            text-decoration: none;
        }

        .purchase-b:hover {
            cursor: pointer;
        }

        .list-services-table {
            margin-top: 10px !important;
        }

        .action {
            width: 143px;
        }

        .service-title {
            min-width: 327px;
        }

        .list-services-table .event-day,
        .list-services-table.time,
        .list-services-table .service,
        .list-services-table .action {
            padding: 12px 5px !important;
        }

        .nav-item-link {
            padding-bottom: 12px !important;
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-wrapper purchase custom-dashboard custom-purchase">
        @include('client.student-mypage.sidebar-left', ['purchase_service' => $data])
        <!-- @include('client.student-mypage.dashboard_left_mobile') -->
        <div class="main_content">
            {{-- <!-- @include('client.common.dashboard-role') -->
            @include('client.screen.teacher.my-page.teacher-header') --}}
            @include('client.common.dashboard-role')
            <div class="col-md-12 d-flex justify-content-start purchase_head">
                <span class="purchase_title f-w6">@lang('labels.purchase-service.service') </span>
            </div>
            <ul class="nav nav-custom-purchase" role="tablist">
                <li class="nav-item">
                    <a class="nav-item-link active pc"
                       href="{{route('client.student.my-page.purchase-service')}}">@lang('labels.purchase-service.service')
                        ({{!empty($data)? $data->total() : 0}}) </a>
                    <a class="nav-item-link active sp"
                       href="{{route('client.student.my-page.purchase-service')}}">@lang('labels.purchase-service.service_sp')
                        ({{!empty($data)? $data->total() : 0}}) </a>
                </li>
                <li class="nav-item">
                    <a class="nav-item-link "
                       href="{{route('client.student.my-page.order')}}">@lang('labels.purchase-service.order_cancel') </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane p-0 active home-tab">
                    <div class="table_head d-flex justify-content-between align-items-center ">
                        <div class="border-rotate">
                            <p class="table_title">@lang('labels.purchase-service.list_service')</p>
                        </div>
                        <div class="p-0 m-0 action_button ">
                            <span class="text-confirm f-w3">@lang('labels.purchase-service.confirm_using')</span>
                            <a href="{{route('client.live-streaming')}}"
                               class="btn btn-live f-w6">@lang('labels.purchase-service.live-stream')</a>
                            <label for="select-option">
                                <div class="select-option d-flex justify-content-center">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                            </label>
                            <input type="checkbox" hidden class="option-checkbox" id="select-option">
                            <ul class="list_guide js-btn-close">
                                <li class="link-item text-center"><a
                                            href="{{route('client.live-streaming')}}">@lang('labels.purchase-service.live-stream')</a>
                                </li>
                                <li class="link-item text-center"><a
                                            href="{{route('client.video-call')}}">@lang('labels.purchase-service.video-call')</a>
                                </li>
                            </ul>
                            <a href="{{route('client.video-call')}}"
                               class="btn btn-video f-w6">@lang('labels.purchase-service.video-call')</a>
                        </div>
                    </div>
                    @if(!empty($data) && count($data))
                        <div class="list-services-table">
                            <table>
                                <thead>
                                @if($data->total())
                                    <tr>
                                        <th class="service-title-header">
                                            @lang('labels.purchase-service.service_name')
                                        </th>
                                        <th class="event-day-header">
                                            @lang('labels.purchase-service.event_day')
                                        </th>
                                        <th class="time-header">
                                            @lang('labels.purchase-service.time')
                                        </th>
                                        <th class="service-header">
                                            @lang('labels.purchase-service.service_header')
                                        </th>
                                        <th class="action-go">
                                            @lang('labels.purchase-service.action')
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td class="service-title">
                                            <a class="d-flex justify-content-center purchase-a  @if($item['parent_course_id'] === null) purchase-b @endif"
                                               href="{{ route('client.course-schedules.detail', ['course_schedule_id' => $item['course_schedule_id']]) }}">
                                                {{--                                               @if($item['parent_course_id'] === null) href="{{ route('client.course-schedules.detail', ['course_schedule_id' => $item['course_schedule_id']]) }}" @endif>--}}
                                                <div class="left">
                                                    <img src="{{ empty($item->image_url) ? asset('assets/img/portal/default-image.svg') : $item->image_url }}"
                                                         alt="">
                                                </div>
                                                <div class="right d-flex">
                                                    <div>{{$item['title_course']}}</div>
                                                    <div>¥{{number_format($item['price'])}}</div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="event-day">
                                            {{now()->parse($item['start_datetime'])->format('Y/m/d')}}
                                        </td>
                                        <td class="time">{{ isset($item['actual_start_date'])?(now()->parse($item['actual_start_date'])->format('H:i') .' - ' .now()->parse($item['actual_end_date'])->format('H:i')) :$item->hour_minute }}</td>
                                        <td class="service">
                                            @if( $item->dist_method == \App\Enums\DBConstant::DIST_METHOD_LIVE_VIDEO_CALL && $item->course_type == 2)
                                                <span style="color: #ee3d48;font-size: 14px;font-weight: 600">個別講座</span>
                                            @elseif($item->dist_method == \App\Enums\DBConstant::DIST_METHOD_LIVE_VIDEO_CALL && $item->course_type == 1)
                                                ビデオ通話
                                            @else
                                                ライブ配信
                                            @endif
                                        </td>
                                        <td class="action">
                                            @if(isset($item['prepare_start_room']) && $item['prepare_start_room'] === true)
                                                <div class="tooltip-title">準備中
                                                    <span class="tooltip-text">開催時間15分前に表示されます</span>
                                                </div>
                                            @else
                                                <a href="{{ route('client.student.student-join-course.join-course-id', ['courseScheduleId' => $item->course_schedule_id]) }}"
                                                   class="btn btn-go-to">準備画面へ</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
                    @endif
                    @if(!empty($data))
                        {{ $data->appends(request()->query())->links('client.layout.paginate') }}
                    @endif
                </div>
                <div class="tab-pane fade">
                </div>
            </div>
        </div>

    </div>
    <script>
        const clickOut = () => {
            $(document).off().on('click', function (e) {
                console.log(e.target);
                if ($(e.target).closest(".action_button").length === 0 && $(".js-btn-close").is(":visible")) {
                    $(".js-btn-close").hide();
                } else if ($(e.target).hasClass('option-checkbox')) {
                    if ($(".list_guide").is(":visible")) {
                        $(".list_guide").hide();
                    } else {
                        $(".list_guide").show();
                    }
                } else if ($(e.target).hasClass('text-confirm')) {
                    $(".list_guide").hide();
                }
            });

        }
        clickOut();
    </script>
@endsection
