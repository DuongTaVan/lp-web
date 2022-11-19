@extends('client.base.base')
<style>
    @media (max-width: 414px) {
        .d-flex.align-items-center.outline-date {
            margin-left: 10px;
        }

        button.btn.btn-new-message {
            margin-left: 5px;
        }
    }

    .notice-success {
        max-width: 400px !important;
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
                    <div class="main-mypage-teacher__content notice">
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
                                @if($data['countDataMessage'])
                                    @include('client.screen.teacher.my-page.message.__partials.navbar',['dataCount'=>$data['countDataMessage']])
                                @endif
                                @if($data['dataOption'])
                                    <div class="none-mobile">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $data['dataOption']])</div>
                                @endif
                            </div>
                            <div class="teacher-sidebar-right__list title-message">
                                <div class="d-flex align-items-center">
                                    <div class="teacher-sidebar-right__list__text text-title f-w6"> @lang('labels.teacher-my-page.message.notice_list')</div>
                                    @if($data['dataOption'])
                                        <div class="none-pc">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $data['dataOption']])</div>
                                    @endif
                                </div>
                                <div class="teacher-sidebar-right__list__new-message">
                                    <span class="count-subscriber">@lang('labels.teacher-my-page.message.registered_person')({{$data['count_subscriber']}})</span>
                                    <button
                                            @if($data['count_subscriber']<=0)
                                            disabled
                                            @endif
                                            data-toggle="modal"
                                            data-num-subscriber="{{$data['count_subscriber']}}"
                                            data-target="#popupNoticeCreate"
                                            class="btn btn-new-message">
                                        <img src="{{asset('assets/img/icons/plus_new_message.svg')}}" alt=""
                                             class="icon-new-message">
                                        <span class="label-new-message">@lang('labels.teacher-my-page.message.create_new_message')</span></button>
                                </div>
                                @include('client.common.option-search')
                            </div>
                            <div class="teacher-sidebar-right__table">
                                @if(count($data['notices'])>0)
                                    <table>
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.teacher-my-page.message.received_date')</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.delivery_title')</th>
                                            <th>@lang('labels.teacher-my-page.message.number_of_distributors')</th>
                                            <th>@lang('labels.teacher-my-page.message.message')</th>
                                        </tr>
                                        @if(isset($data['notices']) && !empty($data['notices']))
                                            @foreach($data['notices'] as $notice)
                                                <tr class="teacher-sidebar-right__table__data">
                                                    <td>{{\Carbon\Carbon::parse($notice->created_at)->format('Y/m/d')}}</td>
                                                    <td>{{\Carbon\Carbon::parse($notice->created_at)->format('H:i')}}</td>
                                                    <td class="title"><b>{{$notice->title}}</b></td>
                                                    <td>
                                                        {{$notice->num_of_delivery}}
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="btn-letter"
                                                           data-toggle="modal"
                                                           data-target="#popupNotice"
                                                           data-notice-id="{{$notice->promotional_message_id}}"
                                                           data-title="{{$notice->title}}"
                                                           data-body="{{$notice->body}}"
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
                            @if(!empty($data['notices']))
                                {{$data['notices']->appends(request()->query())->links('client.layout.paginate')}}
                            @endif
                            {{--Notice Detal Popup--}}
                            @include('client.screen.teacher.my-page.message.__partials.notice_popup')
                            {{--End Notice Detal Popup--}}
                            {{--  Popup Create Notice--}}
                            @if($data['count_subscriber']>0)
                                @include('client.screen.teacher.my-page.message.__partials.notice_create_popup')
                            @endif
                            {{-- End Popup Create Notice--}}
                            @include('client.screen.teacher.my-page.message.__partials.message_popup_complete')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
    <script src="{{ mix('js/clients/teachers/letter-detail.js') }}"></script>
    <script>
        $('.option_tab').addClass('ml-0');
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
    </script>
@endsection
