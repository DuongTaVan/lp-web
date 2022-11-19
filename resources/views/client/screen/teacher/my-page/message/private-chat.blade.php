@extends('client.base.base')
@section('css')
    <style>
        .none-pc {
            display: none;
        }
        @media (max-width: 414px) {
            .list-message {
                display: flex;
                justify-content: space-between!important;
            }
            .none-pc {
                display: block;
            }
            .sidebar-right__navbar-order-list__day-year__left, .sidebar-right__navbar-order-list__day-year__right {
                background: #efefef;
                border-radius: 2px;
                padding: 3px 1px;
                cursor: pointer;
                width: 17px;
                height: 20px;
                line-height: 13px;
                text-align: center;
            }
            .sidebar-right__navbar-order-list__day-year__left img, .sidebar-right__navbar-order-list__day-year__right img {
                width: 11px;
                height: 11px;
            }
        }

        @media (max-width: 376px) {
            .sidebar-right__navbar-order-list__day-year .outline-date {
                margin-left: 7px;
                margin-right: 10px;
            }
        }

        .teacher-sidebar-right__table__header {
            th {
                white-space: nowrap;
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
                    <div class="main-mypage-teacher__content private-chat">
                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text">
                                    @lang('labels.sidebar-left.message')
                                </div>
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list">
                                @include('client.screen.teacher.my-page.message.__partials.navbar')
                                @if($messages['date'])
                                    <div class="none-mobile">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $messages['date']])</div>
                                @endif
                            </div>
                            <div class="teacher-sidebar-right__list list-message">
                                <div class="d-flex align-items-center">
                                    <div class="teacher-sidebar-right__list__text text-title f-w6"> @lang('labels.teacher-my-page.message.private_chat_list')</div>
                                    @if($messages['date'])
                                        <div class="none-pc">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $messages['date']])</div>
                                    @endif
                                </div>
                                @include('client.common.option-search')
                            </div>
                            <div class="teacher-sidebar-right__table">
                                @if(!empty($messages['users']) && count($messages['users']) > 0)
                                    <table>
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>受信日</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.nick_name')</th>
                                            <th>@lang('labels.teacher-my-page.message.sex')</th>
                                            <th>@lang('labels.teacher-my-page.message.age')</th>
                                            <th>@lang('labels.teacher-my-page.message.receive')</th>
                                            <th>サービス名</th>
                                            <th>@lang('labels.teacher-my-page.message.message')</th>
                                        </tr>
                                        @foreach($messages['users'] as $user)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td>{{ isset($user['lastMessage']) ? formatTime($user['lastMessage']['createdAt']) : null }}</td>
                                                <td>{{ isset($user['lastMessage']) ? formatDayTime($user['lastMessage']['createdAt']) : null }}</td>
                                                <td>{{$user['full_name']}}</td>
                                                <td>
                                                    {{ $user['sex_text'] }}
                                                </td>
                                                <td>
                                                    {{$user['age']}}代
                                                </td>
                                                <td>
                                                    @if($user['isRead'] === false)
                                                        <div class="checkbox">
                                                            {{-- <input type="checkbox" name="" checked disabled> --}}
                                                            <img src="{{ url('/assets/img/clients/message-checked.svg') }}"
                                                                     alt="">
                                                        </div>
                                                    @endif
                                                </td>
                                                @if (isset($user['title']) && isset($user['price']))
                                                    <td class="text-left">
                                                        {{$user['title']}}
                                                        <br>
                                                        ¥{{number_format($user['price'])}}
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>
                                                    <a href="
                                                        @if (isset($user['roomId']))
                                                            {{ route('client.messages.room-detail',['roomId' => $user['roomId']]) }}
                                                        @else
                                                            {{ route('client.teacher.my-page.message.message-private-detail',['userId' => $user['user_id']]) }}
                                                        @endif
                                                        " class="btn-letter">
                                                        <img src="{{asset('assets/img/icons/letter.svg')}}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                            @if(!empty($messages['pagination']))
                                @include('client.screen.teacher.my-page.message.__partials.paginate-custom',['paginate'=>$messages['pagination']])
                            @endif
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
    </script>
@endsection