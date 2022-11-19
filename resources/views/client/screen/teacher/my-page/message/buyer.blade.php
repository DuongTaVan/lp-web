@extends('client.base.base')
<style>
    .main-mypage-teacher__content .teacher-sidebar-right .title-message  {
        margin: 27px 0 26px 0!important;
    }

    @media only screen and (max-width: 767px) {
        .main-mypage-teacher__content .teacher-sidebar-right .title-message  {
            margin: 27px 0 -10px 0!important;
        }

        .flex-column {
            margin-bottom: 5px;
        }
    }

    .content-right .main-mypage-teacher__content .teacher-sidebar-right__list__option {
        padding: 0 10px
    }
</style>
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content message-buyer">
                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text">
                                    @lang('labels.sidebar-left.message')
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list">
                                @include('client.screen.teacher.my-page.message.__partials.navbar')
                            </div>
                            <div class="teacher-sidebar-right__list title-message">
                                <div class="teacher-sidebar-right__list__text text-title f-w6"> @lang('labels.teacher-my-page.message.buyer_list')</div>
                            </div>
                            <div class="teacher-sidebar-right__center d-flex justify-content-between">
                                <div class="service-amount d-flex justify-content-between">
                                    @if(!empty($messages['data']))
                                    <img src="{{$messages['data']['courseSchedule']['thumbnail']}}" alt=""
                                            class="img-fluid service-img">
                                @endif
                                @if(!empty($messages['data']) && !empty($messages['data']['courseSchedule']))
                                    <div class="service-title-name">
                                        <span class="service-title-name__title f-w6"
                                            title="{{$messages['data']['courseSchedule']['title']}}">{{$messages['data']['courseSchedule']['title']}}</span>
                                        <div class="service-describe">
                                            <div class="service-datetime d-flex">
                                                <span class="service-date f-w3">
                                                    {{now()->parse($messages['data']['courseSchedule']['start_datetime'])->format('Y/m/d')}}
                                                </span>
                                                <span class="service-time f-w3">
                                                    @if(isset($messages['data']['courseSchedule']['actual_start_date']))
                                                        {{now()->parse($messages['data']['courseSchedule']['actual_start_date'])->format('H:i')}}
                                                        - {{now()->parse($messages['data']['courseSchedule']['actual_end_date'])->format('H:i')}}
                                                    @else
                                                        {{now()->parse($messages['data']['courseSchedule']['start_datetime'])->format('H:i')}}
                                                        - {{now()->parse($messages['data']['courseSchedule']['end_datetime'])->format('H:i')}}
                                                    @endif
                                                </span>
                                            </div>
                                            <span class="service-money">
                                                ¥{{$messages['data']['courseSchedule']['price']}}</span>
                                        </div>
                                    </div>
                                @endif
                                </div>
                                <div class="option-right">
                                    <div class="d-flex flex-column wrap-popup">
                                        <span class="f-w6">※購入者全員へ</span>
                                        @php
                                            $timeCheck = $messages['data']['courseSchedule']['canceled_at'] ??
                                                        $messages['data']['courseSchedule']['end_datetime'];
                                        @endphp
                                        <button class="ml-auto btn btn-bulk-transmission" data-toggle="modal"
                                            data-target="{{ $timeCheck->addHours(48) > now() ? '#buyer-check' : '' }}"
                                                @if(!empty($messages['pagination'] && $messages['pagination']['total'] === 0)) disabled @endif>
                                            <img src="{{asset('assets/img/icons/icon_message.svg')}}"
                                                 alt=""> @lang('labels.teacher-my-page.message.bulk_transmission')
                                        </button>
                                    </div>
                                    <div>@include('client.common.option-search')</div>
                                </div>

                                {{-- for sp--}}
{{--                                <div class="option-search-sp position-absolute">--}}
{{--                                    <button class="ml-auto btn btn-bulk-transmission" data-toggle="modal"--}}
{{--                                            data-target="#buyer-check">--}}
{{--                                        <img src="{{asset('assets/img/icons/icon_message.svg')}}"--}}
{{--                                             alt=""> @lang('labels.teacher-my-page.message.bulk_transmission')--}}
{{--                                    </button>--}}
{{--                                    @include('client.common.option-search')--}}
{{--                                </div>--}}
                            </div>
                            <div class="teacher-sidebar-right__table">
                                <table class="message-buyer-table">
                                    @if(!empty($messages['data']) && !empty($messages['data']['messages']) && count($messages['data']['messages']) > 0)
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.teacher-my-page.message.event_date_alt')</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.nick_name')</th>
                                            <th>@lang('labels.teacher-my-page.message.sex')</th>
                                            <th>@lang('labels.teacher-my-page.message.age')</th>
                                            <th>@lang('labels.teacher-my-page.message.incoming_date_alt')</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.receive')</th>
                                            <th>@lang('labels.teacher-my-page.message.message')</th>
                                        </tr>
                                        @foreach($messages['data']['messages'] as  $message)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>{{now()->parse($message['purchased_at'])->format('Y/m/d')}}</td>
                                                <td>{{now()->parse($message['purchased_at'])->format('H:i')}}</td>
                                                <td class="full-name">{{$message['full_name']}}</td>
                                                <td style="white-space: nowrap">{{$message['sex_type']}}</td>
                                                <td>{{$message['age']}}</td>
                                                <td>@isset($message['lastMessageDate']){{now()->parse($message['lastMessageDate'])->format('Y/m/d')}}@endif</td>
                                                <td>@isset($message['lastMessageDate']){{now()->parse($message['lastMessageDate'])->format('H:i')}}@endif</td>
                                                <td>
                                                    @if(isset($message['isRead']) && !$message['isRead'])
                                                        <div class="checkbox">
                                                            <img src="{{ url('/assets/img/clients/message-checked.svg') }}" alt="">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="icon-letter">
                                                    <a href="
                                                        @if($message['roomId'])
                                                            {{ route('client.messages.room-detail', $message['roomId']) }}
                                                        @else
                                                            {{ route('client.teacher.my-page.message.message-detail',
                                                            [
                                                                'courseScheduleId' => $messages['data']['courseSchedule']['course_schedule_id'],
                                                                'userId' => $message['user_id']
                                                            ]) }}
                                                        @endif
                                                        " class="btn-letter">
                                                        <img src="{{asset('assets/img/icons/letter.svg')}}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            @if(!empty($messages['pagination']))
                                @include('client.screen.teacher.my-page.message.__partials.paginate-custom',['paginate'=>$messages['pagination']])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($messages['pagination']))
            @include('client.screen.teacher.my-page.message.__partials.popup_check_buyer', ['totalMember'=> $messages['pagination']['totalRecord']])
            @include('client.screen.teacher.my-page.message.__partials.message_popup', ['totalMember'=> $messages['pagination']['total']])
        @endif
    </div>

@endsection
