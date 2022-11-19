@extends('client.base.base')
@section('css')
    <style>
        @media only screen and (max-width: 414px) {
            .noti-table {
                table-layout: auto;
            }

            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(1) {
                min-width: 135px;
            }
            .main-mypage-teacher__content .teacher-sidebar-right__table__header th:nth-child(2){
                min-width: 85px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content notification">
                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text">
                                    @lang('labels.sidebar-left.message')
                                </div>
                                {{--<div class="teacher-sidebar-right__title__text">--}}
                                {{--+ @lang('labels.service-list-draft.create_new')--}}
                                {{--</div>--}}
                            </div>

                            <div class="teacher-sidebar-right__navbar-order-list">
                                @include('client.screen.teacher.my-page.message.__partials.navbar',['dataCount'=>$data['countDataMessage']])
                                @if($data['dataOption'])
                                    <div class="none-mobile">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $data['dataOption']])</div>
                                @endif
                            </div>

                            <div class="teacher-sidebar-right__list title-message">
                                <div class="d-flex align-items-center">
                                    <div class="teacher-sidebar-right__list__text text-title f-w6">  @lang('labels.teacher-my-page.message.notification_list')</div>
                                    @if($data['dataOption'])
                                        <div class="none-pc">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $data['dataOption']])</div>
                                    @endif
                                </div>
                                @include('client.common.option-search')
                            </div>
                            <div class="teacher-sidebar-right__table">
                                @if(count($data['notifications'])>0)
                                    <table class="noti-table">
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.teacher-my-page.message.received_date')</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.delivery_title')</th>
                                            <th>@lang('labels.teacher-my-page.message.receive')</th>
                                            <th>@lang('labels.teacher-my-page.message.message')</th>
                                        </tr>
                                        @if(isset($data['notifications']) &&!empty($data['notifications']))
                                            @foreach($data['notifications'] as $notification)
                                                <tr class="teacher-sidebar-right__table__data">
                                                    <td>{{\Carbon\Carbon::parse($notification->delivered_at)->format('Y/m/d')}}</td>
                                                    <td>{{\Carbon\Carbon::parse($notification->delivered_at)->format('H:i')}}</td>
                                                    <td class="title">{{$notification->title}}</td>
                                                    <td>
                                                        @if($notification->is_read === \App\Enums\DBConstant::MESSAGE_NOT_READ)
                                                            <div class="checkbox"
                                                                 id="unread-notify-{{$notification->id}}">
                                                                {{-- <input type="checkbox" name="" checked
                                                                       disabled> --}}
                                                                <img src="{{ url('/assets/img/clients/message-checked.svg') }}"
                                                                     alt="">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="btn-letter"
                                                           data-toggle="modal"
                                                           data-target="#popupNotice"
                                                           data-notice-id="{{$notification->id}}"
                                                           data-title="{{$notification->title}}"
                                                           data-body="{{$notification->body}}"
                                                           data-is-read="{{$notification->is_read}}"
                                                        ><img
                                                                    src="{{asset('assets/img/icons/letter.svg')}}"
                                                                    alt=""></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                @endif
                            </div>
                            @if(!empty($data['notifications']))
                                {{$data['notifications']->appends(request()->query())->links('client.layout.paginate')}}
                            @endif
                            {{--Notification Detal Popup--}}
                            @include('client.screen.teacher.my-page.message.__partials.notice_popup')
                            {{--End Notification Detal Popup--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
    <script src="{{ mix('js/clients/teachers/notification-detail.js') }}"></script>
@endsection
