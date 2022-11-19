@extends('client.base.base')
<link rel="stylesheet" href="{{ mix('css/clients/modules/teacher/service-list.css')  }}"/>
@section('css')
    <style>
        /* .col-md-9, .col-sm-9 {
            padding-left: 30px;
        } */

        .teacher-sidebar-right__table table td {
            padding-top: 17px;
            padding-bottom: 17px;
        }

        .main-mypage-teacher .content-mypage .teacher-sidebar-right__table td:nth-child(1) {
            padding: 7px 10px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__list {
            margin-top: 16px;
        }

        table tr:last-child th:first-child {
            border-bottom-left-radius: 5px;
        }

        table tr:last-child td:last-child {
            border-bottom-right-radius: 5px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__table table {
            overflow: unset;
        }

        .main-mypage-teacher.custom-service .main-mypage-teacher__content .teacher-sidebar-right .service-list-cancel tr th:nth-of-type(5) {
            width: 95px;
        }

        .button-status-disabled  {
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
                        <div class="teacher-sidebar-right teacher-serviec-cancel">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text-header">
                                    @lang('labels.service-list-cancel.delivery_service_management')
                                </div>
                                {{--                                        <div class="teacher-sidebar-right__title__text">--}}
                                {{--                                            + @lang('labels.service-list-cancel.create_new')--}}
                                {{--                                        </div>--}}
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list">
                                @include('client.screen.teacher.my-page.services.tab')
                            </div>
                            <div class="teacher-sidebar-right__list service-list-cancel d-flex">
                                @include('client.common.option-search', ['query' => [['option' => \App\Enums\Constant::SORT_DATETIME_DESC], ['option' => \App\Enums\Constant::SORT_DATETIME_ASC]]])
                            </div>
                            <div class="teacher-sidebar-right__table service-list-cancel-table">
                                <table class="service-list-cancel">
                                    @if($services->total())
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.service-list-cancel.service_name')</th>
                                            <th>@lang('labels.service-list-cancel.event_date')</th>
                                            <th>@lang('labels.service-list-cancel.time')</th>
                                            <th>@lang('labels.service-list-cancel.purchase_number')</th>
                                            <th>@lang('labels.service-list-cancel.delivery_type')</th>
                                            <th>@lang('labels.service-list-cancel.delete')</th>
                                            <th style="min-width: 126px">@lang('labels.service-list-cancel.cancellation_contact')</th>
                                        </tr>
                                        @foreach($services as $key => $service)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="teacher-sidebar-right__table__data__image">
                                                            <img src="{{ $service->image_url }}" alt="" width="50"
                                                                 height="50">
                                                        </div>
                                                        <div class="teacher-sidebar-right__table__data__col1">
                                                            <div class="teacher-sidebar-right__table__data__col1__text">{{ $service->title }}</div>
                                                            <div class="teacher-sidebar-right__table__data__col1__price">
                                                                ¥{{ number_format($service->price) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $service->month_day }}</td>
                                                <td>{{ isset($service->actual_start_date)?(now()->parse($service->actual_start_date)->format('H:i') .' - ' .now()->parse($service->actual_end_date)->format('H:i')) :$service->hour_minute }}</td>
                                                <td>{{ $service->num_of_applicants }}</td>
                                                <td>
                                                    @if( $service->dist_method == \App\Enums\DBConstant::DIST_METHOD_LIVE_VIDEO_CALL && $service->type == 2)
                                                        <span class="f-w6">個別講座</span>
                                                    @elseif($service->dist_method == \App\Enums\DBConstant::DIST_METHOD_LIVE_VIDEO_CALL && $service->type == 1)
                                                        ビデオ通話
                                                    @else
                                                        ライブ配信
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($service->start_datetime > now())
                                                        @if($service->num_of_applicants == 0 && !$service->canceled_at)
                                                            <button class="btn btn-delete button-status-disabled" data-toggle="modal"
                                                                    data-target="#cancel"
                                                                    data-id="{{ $service->course_schedule_id }}">
                                                                削除する
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="message">
                                                    @if($service->end_datetime > now())
                                                        @if($service->num_of_applicants > 0)
                                                            @if($service->canceled_at)
                                                                <span>キャンセル済</span>
                                                            @elseif($service->cs_status === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_PENDING)
                                                                <span>処理中</span>
                                                            @else
                                                                <div class="tooltip-button custom-text custom-text-mail">
                                                                    <img src="{{ url('assets/img/common/email.svg') }}"
                                                                         alt="" data-toggle="modal" data-target="#email"
                                                                         data-id="{{ $service->course_schedule_id }}"
                                                                         data-num="{{ $service->num_of_applicants }}"
                                                                         class="cancel-batch"
                                                                    >
                                                                    <span class="tooltiptext">{!!  __('labels.service-list-cancel.help_text_email') !!}</span>
                                                                </div>
                                                                <div class="tooltip-button custom-text tooltipApp">
                                                                    <img src="{{ url('assets/img/common/email.svg') }}"
                                                                         data-target="#email"
                                                                         data-id="{{ $service->course_schedule_id }}"
                                                                         data-num="{{ $service->num_of_applicants }}"
                                                                         class="cancel-batch-app">
                                                                    <span class="textTooltip"> @lang('labels.service-list-cancel.help_text_email')</span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                                <input type="hidden" id="user-identify-status" value="{{ auth()->guard('client')->user()->identity_verification_status }}">
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
        <!-- Modal delete-->
        <div class="modal fade" id="cancel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="content-service-list">
                        <div class="cancel-title f-w6">
                            @lang('labels.service-list-cancel.comfirm_delete')
                        </div>
                        <div class="cancel-button">
                            <button type="button" class="btn button-cancel f-w6" data-dismiss="modal">
                                @lang('labels.service-list-cancel.button_cancel')
                            </button>
                            <form action="{{ route('client.teacher.my-page.service-list.delete') }}" method="post">
                                <button type="submit" class="button-ok f-w6">
                                    @lang('labels.service-list-cancel.button_ok')
                                </button>
                                @method('DELETE')
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="type" value="SCHEDULE">
                                <input type="hidden" name="_token" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal cancel with applicant-->
        <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="hidden" name="course_schedule_id" id="course-schedule-id" value="">
                    <div class="content-service-send-mail">
                        <div class="modal-header">
                            <div class="title">
                                @lang('labels.service-list-cancel.send_message')(<span
                                        class="num-of-applicant-modal"></span>人)
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><svg width="10" height="10" viewBox="0 0 10 10" fill="#4E5768"
                                                              xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd"
      d="M1.15906 0.19884C0.893907 -0.0663155 0.464005 -0.0663157 0.19885 0.19884C-0.066306 0.463996 -0.0663059 0.893898 0.19885 1.15905L4.03982 5.00002L0.198891 8.84096C-0.0662648 9.10611 -0.0662647 9.53601 0.198891 9.80117C0.464046 10.0663 0.893948 10.0663 1.1591 9.80117L5.00003 5.96024L8.84077 9.80097C9.10592 10.0661 9.53583 10.0661 9.80098 9.80097C10.0661 9.53582 10.0661 9.10592 9.80098 8.84076L5.96025 5.00002L9.80102 1.15925C10.0662 0.894094 10.0662 0.464192 9.80102 0.199036C9.53587 -0.066119 9.10596 -0.0661184 8.84081 0.199037L5.00003 4.03981L1.15906 0.19884Z"/>
</svg>
</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                            <p style="font-size: 14px;line-height: 15px;color: #EE3D48;margin: 5px 0px;"
                               class="error-message"></p>
                            <div class="refund">
                                <div class="title">@lang('labels.service-list-cancel.content_email_1')</div>
                                <div class="help-text">
                                    @lang('labels.service-list-cancel.content_email_2')
                                </div>
                                <div class="content-text">
                                    @lang('labels.service-list-cancel.content_email_3')
                                </div>
                            </div>
                            <div class="refund">
                                <div class="help-text">
                                    @lang('labels.service-list-cancel.content_email_4')
                                </div>
                                <div class="content-text">
                                    <div>@lang('labels.service-list-cancel.content_email_5')</div>
                                    <div>@lang('labels.service-list-cancel.content_email_6')</div>
                                    <div>@lang('labels.service-list-cancel.content_email_7')</div>
                                    <div>@lang('labels.service-list-cancel.content_email_8')</div>
                                </div>
                            </div>
                        </div>
                        <div class="button-send">
                            <button type="button" class="btn button-ok" id="multi-cancel">
                                @lang('labels.service-list-cancel.button_send_mail')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal mail done-->
        <div class="modal fade" id="mailDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="content-service-list">
                        <div class="cancel-title">
                            <img src="{{ url('assets/img/teacher-page/icon/email.svg') }}" alt="">
                            <div class="text-send-email f-w6">
                                @lang('labels.service-list-cancel.sent')
                            </div>
                        </div>
                        <div class="cancel-button">
                            <button type="button" class="btn button-ok" data-dismiss="modal" aria-label="Close">
                                @lang('labels.service-list-cancel.button_close')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(".tooltipApp").each(function () {
            $(this).on('click', () => {
                $($(this).children()[1]).show()
                setTimeout(() => {
                    $($(this).children()[1]).hide()
                    $('#email').modal('show')
                }, 2000);
            })
        });

        $(document).ready(() => {
            if ($('#user-identify-status').val() == 3) {
                $('.btn-delete').removeClass('button-status-disabled');
            }
        });
    </script>
    <script src="{{ mix('js/clients/orders/list-service.js') }}"></script>
@endsection
