@extends('client.base.base')
<link rel="stylesheet" href="{{ mix('css/clients/modules/teacher/service-list.css')  }}"/>
@section('css')
    <style>
        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td:nth-child(1) {
            padding: 7px 10px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__list {
            margin-top: 16px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__list__option {
            padding: unset;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__table table {
            overflow: unset;
        }

        table tr:last-child td:first-child {
            border-bottom-left-radius: 5px;
        }

        table tr:last-child td:last-child {
            border-bottom-right-radius: 5px;
        }

        table tr:first-child th:last-child {
            border-top-right-radius: 5px;
        }

        table tr:first-child th:first-child {
            border-top-left-radius: 5px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__navbar-order-list {
            margin-top: 14px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__table table tr td {
            padding: 17px 7px;
        }

        .button-status-disabled {
            background-color: #b3b3b3 !important;
            color: #fff !important;
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher custom-service">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">
                        <div class="teacher-sidebar-right">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text-header">
                                    @lang('labels.service-list.sales_service_management')
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list">
                                @include('client.screen.teacher.my-page.services.tab')
                                <div class="confirmation-of-usage confirmation-of-usage__PC">
                                    @lang('labels.service-list.confirmation_of_usage')
                                    <div class="confirm-use">
                                        <a href="{{ route('client.delivery-method') }}"
                                           class="btn btn-default button-live active">
                                            @lang('labels.service-list.live_streaming')
                                        </a>
                                        <a href="{{ route('client.delivery-method') }}"
                                           class="btn btn-default button-live">
                                            @lang('labels.service-list.video_call')
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__list custom-service-list mt-13">

                                <div class="confirmation-of-usage confirmation-of-usage__SP">
                                    <div class="p-0 m-0 action_button custom-action-button">
                                        <span class="text-confirm f-w3">@lang('labels.service-list.confirmation_of_usage')</span>
                                        <a href="{{route('client.student.my-page.livestream-guide')}}"
                                           class="btn btn-live f-w6">@lang('labels.purchase-service.live-stream')</a>
                                        <label for="select-option">
                                            <div class="select-option d-flex justify-content-center">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </div>
                                        </label>
                                        <input type="checkbox" hidden class="option-checkbox" id="select-option">
                                        <ul class="list_guide">
                                            <li class="link-item text-center"><a
                                                        href="{{ route('client.delivery-method') }}">@lang('labels.purchase-service.live-stream')</a>
                                            </li>
                                            <li class="link-item text-center"><a
                                                        href="{{ route('client.delivery-method') }}">@lang('labels.purchase-service.video-call')</a>
                                            </li>
                                        </ul>
                                        <a href="{{route('client.student.my-page.video-call-guide')}}"
                                           class="btn btn-video f-w6">@lang('labels.purchase-service.video-call')</a>
                                    </div>
                                </div>
                                @include('client.common.option-search', ['query' => [['option' => \App\Enums\Constant::SORT_DATETIME_DESC], ['option' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                            </div>
                            @if(auth('client')->user()->teacher_category_skills !== \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                                <a href="{{ route('client.teacher.courses.create') }}"
                                   class="teacher-sidebar-right__title__create mobile mobo-hide">
                                    + @lang('labels.service-list.create_new_service')
                                </a>
                            @endif
                            <div class="teacher-sidebar-right__table mt-13">
                                <table class="service-list-table">
                                    @if($services->total())
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.service-list.title')</th>
                                            <th>@lang('labels.service-list.event_date')</th>
                                            <th>@lang('labels.service-list.time')</th>
                                            <th>@lang('labels.service-list.purchase_number')</th>
                                            <th>@lang('labels.service-list.delivery_type')</th>
                                            <th>@lang('labels.service-list.edit')</th>
                                            <th>@lang('labels.service-list.status')</th>
                                            <th>@lang('labels.service-list.delivery')</th>
                                        </tr>
                                        @foreach($services as $item)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="teacher-sidebar-right__table__data__image">
                                                            <img src="{{ $item->image_url }}" alt="" width="50"
                                                                 height="50">
                                                        </div>
                                                        <div class="teacher-sidebar-right__table__data__col1">
                                                            <div class="teacher-sidebar-right__table__data__col1__text">
                                                                {{ $item->title }}
                                                            </div>
                                                            <div class="teacher-sidebar-right__table__data__col1__price">
                                                                ¥{{ number_format($item->price) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item->month_day }}</td>
                                                <td>{{ isset($item->actual_start_date)?(now()->parse($item->actual_start_date)->format('H:i') .' - ' .now()->parse($item->actual_end_date)->format('H:i')) :$item->hour_minute }}</td>
                                                <td>{{ $item->num_of_applicants }}</td>
                                                <td>
                                                    @if( $item->dist_method == \App\Enums\DBConstant::DIST_METHOD_LIVE_VIDEO_CALL && $item->type == 2)
                                                        <span class="f-w6">個別講座</span>
                                                    @elseif($item->dist_method == \App\Enums\DBConstant::DIST_METHOD_LIVE_VIDEO_CALL && $item->type == 1)
                                                        ビデオ通話
                                                    @else
                                                        ライブ配信
                                                    @endif
                                                </td>
                                                <td class="custom-padding">
                                                    @if($item->num_of_applicants == 0)
                                                        <div class="tooltip-button custom-text custom-text-mail">
                                                            <a href="{{ route('client.teacher.course_schedules.show', [$item->course_schedule_id, 'isPublic'=> 1]) }}"
                                                               class="btn btn-custom btn-status btn-edit button-status-disabled">編集する</a>
                                                            <span class="tooltiptext">購入者がいない場合のみ編集可</span>
                                                        </div>
                                                        <div class="tooltip-button custom-text tooltipApp">
                                                            <input type="hidden" name="course_schedule_view"
                                                                   value="{{ route('client.teacher.course_schedules.show', [$item->course_schedule_id, 'isPublic'=> 1]) }}">
                                                            <button class="btn btn-custom btn-status btn-edit">編集する
                                                            </button>
                                                            <span class="tooltiptext">購入者がいない場合のみ編集可</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="custom-padding">
                                                    @if($item->num_of_applicants > 0)
                                                        <a href="{{ route('client.teacher.my-page.service-list.list-student', ['courseScheduleId' => $item->course_schedule_id]) }}"
                                                           class="btn btn-custom btn-status btn-reservation">{{ __('labels.service-list.button2') }}</a>
                                                    @endif
                                                </td>
                                                <td class="message custom-padding" style="min-width: 97px">
                                                    @if($item->num_of_applicants > 0)
                                                        @php
                                                            $start = $item->start_datetime->diffInMinutes(now(), false);
                                                            $end = $item->end_datetime->diffInMinutes(now(), false);
                                                        @endphp
                                                        @if (-$start > 15)
                                                            @php $item['prepare_start_room'] = true; @endphp
                                                        @endif
                                                        @if ($end < 0)
                                                            @php $item['during_time'] = true; @endphp
                                                        @endif

                                                        @if(isset($item['prepare_start_room']) && $item['prepare_start_room'] === true)
                                                            <div class="tooltip-button custom-text">
                                                                <span>準備中</span>
                                                                <span class="tooltiptext">開催時間15分前に表示されます</span>
                                                            </div>
                                                        @else
                                                            <a href="{{ route('client.teacher.teacher-join-course.join-course-id', ['courseId' => $item['course_schedule_id'] ?? 0]) }}"
                                                               class="btn btn-custom btn-delivery btn-center">@lang('labels.service-list.button3')</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <input type="hidden" id="user-identify-status"
                                                       value="{{ auth()->guard('client')->user()->identity_verification_status }}">
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            {{ $services->appends(request()->query())->links('client.layout.paginate') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
    <script>
        $(".tooltipApp").each(function () {
            $(this).on('click', () => {
                let href = $($(this).children()[0]).val()
                setTimeout(() => {
                    window.location = href;
                }, 2000);
            })
        });
    </script>
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

        $('.confirm-use').click(function () {
            $(".confirm-user-option").toggleClass("confirm-user-option-show");
        })

        $(document).ready(() => {
            if ($('#user-identify-status').val() == 3) {
                $('a').removeClass('button-status-disabled');
            }
        });

    </script>
@endsection

<style>
    td {
        padding: 7px;
    }

    .btn-custom {
        padding: 8px 7px !important;
    }

    .btn-delivery {
        padding: 8px 7px !important;
    }
</style>
