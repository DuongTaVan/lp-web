@extends('client.base.base')
<style>
    .main-mypage-teacher__content .teacher-sidebar-right .title-message {
        margin: 27px 0 26px 0!important;
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
                    <div class="main-mypage-teacher__content message-not-buyer">
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
                            <div class="teacher-sidebar-right__center d-flex justify-content-between align-items-end">
                                <div class="service-amount d-flex justify-content-between">
                                    <div class="service-title-image">
                                        @if(!empty($messages['data']))
                                                 <img src="{{$messages['data']['image_url']}}" alt=""
                                                class="img-fluid service-img">
                                        @endif
                                    </div>
                                    @if(!empty($messages['data']) && !empty($messages['data']['courseSchedule']))
                                        {{-- <div class="service-info">
                                            <div class="service-title-name">{{$messages['data']['courseSchedule']['title']}}</div>
                                            <div class="service-amount d-flex">
                                                <div class="service-date">{{Carbon\Carbon::parse($messages['data']['courseSchedule']['start_datetime'])->format('m')}}
                                                    月{{Carbon\Carbon::parse($messages['data']['courseSchedule']['start_datetime'])->format('d')}}
                                                    日
                                                </div>
                                                <div class="service-time">{{Carbon\Carbon::parse($messages['data']['courseSchedule']['start_datetime'])->format('H:i')}}
                                                    - {{Carbon\Carbon::parse($messages['data']['courseSchedule']['end_datetime'])->format('H:i')}}</div>
                                                <div class="service-money-pc">
                                                    ¥{{$messages['data']['courseSchedule']['price']}}</div>
                                            </div>
                                            <div class="service-money-sp">
                                                ¥{{$messages['data']['courseSchedule']['price']}}</div>
                                        </div> --}}
    
                                        <div class="service-title-name">
                                            <span class="service-title-name__title f-w6"
                                                title="{{$messages['data']['courseSchedule']['title']}}">{{$messages['data']['courseSchedule']['title']}}</span>
                                            <div class="service-describe">
                                                <div class="service-datetime d-flex">
                                                    <span class="service-date f-w3">
                                                        {{Carbon\Carbon::parse($messages['data']['courseSchedule']['start_datetime'])->format('Y/m/d')}}
                                                    </span>
                                                    <span class="service-time f-w3">{{Carbon\Carbon::parse($messages['data']['courseSchedule']['start_datetime'])->format('H:i')}}
                                                        - {{Carbon\Carbon::parse($messages['data']['courseSchedule']['end_datetime'])->format('H:i')}}</span>
                                                </div>
                                                <span class="service-money">
                                                    ¥{{$messages['data']['courseSchedule']['price']}}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                               <div class="option-right">
                                    <button class="ml-auto btn btn-bulk-transmission pc" data-toggle="modal"
                                        data-target="#messagePopup"
                                        @if(!empty($messages['pagination'] && $messages['pagination']['total'] === 0)) disabled @endif>
                                        <img
                                            src="{{asset('assets/img/icons/icon_message.svg')}}"
                                            alt=""> @lang('labels.teacher-my-page.message.bulk_transmission')
                                    </button>
                                    <div class="pc">@include('client.common.option-search')</div>
                               </div>

                                {{-- for sp--}}
                                <div class="option-search-sp position-absolute">
                                    <button class="ml-auto btn btn-bulk-transmission" data-toggle="modal"
                                            data-target="#messagePopup">
                                        <img
                                                src="{{asset('assets/img/icons/icon_message.svg')}}"
                                                alt=""> @lang('labels.teacher-my-page.message.bulk_transmission')
                                    </button>
                                    @include('client.common.option-search')
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__table">
                                <table>
                                    @if(!empty($messages['data']) && !empty($messages['data']['messages']) && count($messages['data']['messages']) > 0)
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.teacher-my-page.message.nick_name')</th>
                                            <th>@lang('labels.teacher-my-page.message.sex')</th>
                                            <th>@lang('labels.teacher-my-page.message.age')</th>
                                            <th>@lang('labels.teacher-my-page.message.incoming_date')</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.receive')</th>
                                            <th>@lang('labels.teacher-my-page.message.message')</th>
                                        </tr>
                                        @foreach($messages['data']['messages'] as  $message)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>{{$message['full_name']}}</td>
                                                <td>
                                                    @switch($message['sex'])
                                                        @case (1)
                                                        @lang('labels.teacher-my-page.message.male')
                                                        @break
                                                        @case (2)
                                                        @lang('labels.teacher-my-page.message.female')
                                                        @break
                                                        @case (9)
                                                        @lang('labels.teacher-my-page.message.not_applicable')
                                                        @break
                                                        @default

                                                    @endswitch
                                                </td>
                                                <td>
                                                    {{$message['age']}}代
                                                </td>
                                                <td>@isset($message['lastMessage']){{Carbon\Carbon::parse($message['lastMessage']['createdAt'])->format('Y/m/d')}}@endif</td>
                                                <td>@isset($message['lastMessage']){{Carbon\Carbon::parse($message['lastMessage']['createdAt'])->format('H:i')}}@endif</td>
                                                <td>
                                                    @if(isset($message['lastMessage']) && !$message['lastMessage']['is_read'])
                                                        {{-- <div class="checkbox">
                                                            <input type="checkbox" name="" checked disabled>
                                                        </div> --}}
                                                        <img src="{{ url('/assets/img/clients/message-checked.svg') }}" alt="">
                                                    @endif
                                                </td>
                                                <td style="">
                                                    @if (isset($message['unreadMessageCount']) && $message['unreadMessageCount'] > 0)
                                                        <a class="d-inline-block w-100 h-100" style="margin-bottom: 5px" href="{{ route('client.teacher.my-page.message.message-detail',
                                                                    [
                                                                        'courseScheduleId' => $messages['data']['courseSchedule']['course_schedule_id'],
                                                                        'userId' => $message['user_id']
                                                                    ]) }}" class="btn-letter"><img
                                                                    src="{{asset('assets/img/icons/letter.svg')}}"
                                                                    alt=""></a>
                                                    @endif
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
            @include('client.screen.teacher.my-page.message.__partials.message_popup', ['totalMember'=> $messages['pagination']['total']])
        @endif
    </div>

@endsection
