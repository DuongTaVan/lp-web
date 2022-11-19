@extends('client.base.base')
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="main-mypage-teacher__content">                        <div class="teacher-sidebar-right service-list-draft">
                            <div class="teacher-sidebar-right__title">
                                <div class="teacher-sidebar-right__title__text">
                                    @lang('labels.sidebar-left.message')
                                </div>
                                {{--<div class="teacher-sidebar-right__title__text">--}}
                                {{--+ @lang('labels.service-list-draft.create_new')--}}
                                {{--</div>--}}
                            </div>
                            <div class="teacher-sidebar-right__navbar-order-list">
                                @include('client.screen.teacher.my-page.message.__partials.navbar')
                                @if($message['date'])
                                    <div class="none-mobile">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $message['date']])</div>
                                @endif
                            </div>
                            <div class="teacher-sidebar-right__list title-message">
                                <div class="d-flex align-items-center">
                                    <div class="teacher-sidebar-right__list__text text-title f-w6">@lang('labels.teacher-my-page.message.service_list')</div>
                                    @if($message['date'])
                                        <div class="none-pc">@include('client.common.yearAndMonthOption', ['yearAndMonthOption'=> $message['date']])</div>
                                    @endif
                                </div>
                                @include('client.common.option-search')
                            </div>
                            <div class="teacher-sidebar-right__table">
                                @if(!empty($message['data']) && $message['data']->count() > 0)
                                    <table>
                                        <tr class="teacher-sidebar-right__table__header">
                                            <th>@lang('labels.teacher-my-page.message.received_date_alt')</th>
                                            <th>@lang('labels.teacher-my-page.message.time')</th>
                                            <th>@lang('labels.teacher-my-page.message.service_title_table')</th>
                                            <th>@lang('labels.teacher-my-page.message.status')</th>
                                            <th>@lang('labels.teacher-my-page.message.receive')</th>
                                            <th>@lang('labels.teacher-my-page.message.number')</th>
                                            <th>@lang('labels.teacher-my-page.message.buyer')</th>
                                        </tr>
                                        @foreach($message['data'] as $data)
                                            <tr class="teacher-sidebar-right__table__data">
                                                <td class="text-nowrap">{{Carbon\Carbon::parse($data['start_datetime'])->format('Y/m/d')}}</td>
                                                <td class="text-nowrap">{{Carbon\Carbon::parse($data['start_datetime'])->format('H:i')}}
                                                    - {{Carbon\Carbon::parse($data['end_datetime'])->format('H:i')}}</td>
                                                <td class="text-left">
                                                    {{$data['courseScheduleTitle']}}
                                                    <br>
                                                    ¥{{number_format($data['price'], 0, ',', ',')}}
                                                </td>
                                                <td class="text-nowrap">
                                                    @switch($data['status'])
                                                        @case(0)
                                                        @lang('labels.teacher-my-page.message.in_session')
                                                        @break
                                                        @case(1)
                                                        @lang('labels.teacher-my-page.message.course_cancel')
                                                        @break
                                                        @case(9)
                                                        @lang('labels.teacher-my-page.message.draft')
                                                        @break
                                                        @default
                                                        @lang('labels.teacher-my-page.message.end')
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if($data['isRead'] !== true)
                                                        <div class="checkbox">
                                                            {{-- <input type="checkbox" name="" checked disabled> --}}
                                                            <img src="{{ url('/assets/img/clients/message-checked.svg') }}" alt="">
                                                        </div>
                                                    @else
                                                        済
                                                    @endif
                                                </td>

                                                <td>
                                                    {{$data['totalUser']}}
                                                </td>
                                                <td>
                                                    <a href="{{route('client.teacher.my-page.message.not-buyer', array_replace_recursive(Request::all(), [$data['courseScheduleId'], 'page' => 1]))}}"
                                                       class="btn btn-custom btn-status position-relative border-none btn-status-message-course"><span
                                                                class="to_list_text">@lang('labels.sale-history.to_list')</span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                            @if(!empty($message['pagination']) && $message['data']->count()>0)
                                @include('client.screen.teacher.my-page.message.__partials.paginate-custom',['paginate'=>$message['pagination']])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            let url = $('#main-sidebar li:nth-child(4)')
            url.addClass('active')
        });
    </script>
@endsection
