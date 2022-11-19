@extends('client.base.base')
<link rel="stylesheet" href="{{ mix('css/clients/modules/teacher/service-list.css')  }}"/>
@section('css')
    <style>
        .teacher-sidebar-right__table table td {
            padding-top: 17px;
            padding-bottom: 17px;
        }

        .main-mypage-teacher__content .teacher-sidebar-right__navbar-order-list {
            margin-top: 14px;
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
                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text">
                                    @lang('labels.service-list-draft.delivery_service_management')
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
                            <div class="teacher-sidebar-right__list custom-service-list">
                                <div class="confirmation-of-usage confirmation-of-usage__SP">
                                    <div class="p-0 m-0 action_button custom-action-button">
                                        <span
                                            class="text-confirm f-w3">@lang('labels.purchase-service.confirm_using')</span>
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
                            <div class="teacher-sidebar-right__table">
                                <table class="service-draft-table">
                                    @if($services->total())
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>{{ __('labels.service-list.title') }}</th>
                                            <th>{{ __('labels.service-list-draft.save_date') }}</th>
                                            <th>{{ __('labels.service-list.time') }}</th>
                                            <th>{{ __('labels.service-list-draft.motion') }}</th>
                                        </tr>

                                        @foreach($services as $service)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="teacher-sidebar-right__table__data__image">
                                                            <img src="{{ $service->image_url }}" alt="" width="50"
                                                                 height="50">
                                                        </div>
                                                        <div class="teacher-sidebar-right__table__data__col1">
                                                            <div class="teacher-sidebar-right__table__data__col1__text">
                                                                {{ $service->title }}
                                                            </div>
                                                            {{--<div class="teacher-sidebar-right__table__data__col1__price">--}}
                                                            {{--¥{{ number_format($service->price) }}</div>--}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                {{ $service->updated_at ? $service->updated_at->format('Y/m/d') : '' }}
                                                <td>
                                                {{ $service->updated_at ? $service->updated_at->format('H:i') : '' }}
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        @if($service->course_schedule_id)
                                                            <a href="{{ route('client.teacher.courses.show', ['course'=> $service->course_id, 'group' => $service->group, 'type' => 'draft']) }}"
                                                               class="btn btn-custom btn-status button-status-disabled">{{ __('labels.service-list-draft.edit') }}</a>
                                                        @else
                                                            <a href="{{ route('client.teacher.courses.show', ['course'=> $service->course_id]) }}"
                                                               class="btn btn-custom btn-status button-status-disabled">{{ __('labels.service-list-draft.edit') }}</a>
                                                        @endif
                                                        <button
                                                            class="btn btn-custom btn-delivery button-status-disabled"
                                                            data-toggle="modal"
                                                            data-target="#cancel"
                                                            data-id="{{ $service->course_id }}"
                                                            data-group="{{ $service->group }}">
                                                            {{ __('labels.service-list-draft.delete') }}
                                                        </button>
                                                    </div>
                                                </td>
                                                <input type="hidden" id="user-identify-status"
                                                       value="{{ auth('client')->user()->identity_verification_status }}">
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
        <div class="modal fade" id="cancel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="content-service-list">
                        <div class="cancel-title f-w6">
                            @lang('labels.service-list-cancel.comfirm_delete')
                        </div>
                        <div class="cancel-button">
                            <button type="button" class="button-cancel f-w6" data-dismiss="modal">
                                @lang('labels.service-list-cancel.button_cancel')
                            </button>
                            <form action="{{ route('client.teacher.my-page.service-list.delete') }}" method="post">
                                <button type="submit" class="button-ok f-w6">
                                    @lang('labels.service-list-cancel.button_ok')
                                </button>
                                @method('DELETE')
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="group" value="">
                                <input type="hidden" name="_token" value="">
                            </form>
                        </div>
                    </div>
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

        $('.confirm-use').click(function () {
            $(".confirm-user-option").toggleClass("confirm-user-option-show");
        })

        $(".btn-delivery").on("click", function () {
            $("[name='id']").val($(this).attr("data-id"));
            $("[name='group']").val($(this).attr("data-group"));
            $("[name='_token']").val($('meta[name="csrf-token"]').attr('content'));
        })

        $(document).ready(() => {
            if ($('#user-identify-status').val() == 3) {
                $('a').removeClass('button-status-disabled');
                $('.btn-delivery').removeClass('button-status-disabled');
            }
        });
    </script>
@endsection
