<div class="list-services-table" id="purchased">
    @if(!empty($data['courseSchedules']) && count($data['courseSchedules']) > 0)
        <table>
            <thead>
            <tr>
                <td class="send-at-header">
                    @lang('labels.messages-course-purchase.day-receive')
                </td>
                <td class="time-at-header">
                    @lang('labels.messages-course-purchase.time-header')
                </td>
                <td class="full_name-header">
                    @lang('labels.messages-course-purchase.user_name')
                </td>
                <td class="sex_text-header">
                    @lang('labels.messages-course-purchase.sex')
                </td>
                <td class="age-header">
                    @lang('labels.messages-course-purchase.age')
                </td>
                <td>
                    @lang('labels.teacher-my-page.message.receive')
                </td>
                <td class="age-header">
                    サービス名
                </td>
                <td class="message-header">
                    @lang('labels.messages-course-purchase.message-header')
                </td>
            </tr>
            </thead>
            <tbody>
            @php
                $requestAll = Request::all();
                $dataPage = [
                    "sort" => $requestAll["sort"],
                    "option" => (int)$data["option"],
                    "perPage" => $requestAll["perPage"],
                    "page" => $requestAll["page"],
                ];
            @endphp
            @foreach($data['courseSchedules'] as $item)
                <tr>
                    <td class="send-at">
                        {{ isset($item['lastMessage']['createdAt']) ? formatTime($item['lastMessage']['createdAt']) : null }}
                    </td>
                    <td class="time-at">
                        {{ isset($item['lastMessage']['createdAt']) ? formatDayTime($item['lastMessage']['createdAt']) : null }}
                    </td>
                    <td class="full_name">
                        {{ $item['full_name'] ?? null }}
                    </td>
                    <td class="sex">
                        {{ $item['sex_text'] ?? null }}
                    </td>
                    <td class="age">
                        {{ $item['age'] ?? null }}
                    </td>
                    <td>
                        @if(!$item['isRead'])
                            <img src="{{ url('assets/img/common/checked.svg') }}" alt="">
                        @endif
                    </td>
                    @if (isset($item['title']) && isset($item['price']))
                        <td class="service-title">
                            <div class="right d-flex">
                                <div>{{ $item['title'] }}</div>
                                <div>¥{{ number_format($item['price'])}}</div>
                            </div>
                        </td>
                    @else
                        <td></td>
                    @endif
                    <td class="message">
                        <a href="{{ route('client.messages.room-detail', $item['roomId']) }}">
                            <img src="{{ url('assets/img/common/email.svg') }}" alt="">
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
    @endif
</div>
@if(!empty($data['pagination']))
        @include('client.screen.teacher.my-page.message.__partials.paginate-custom',['paginate'=>$data['pagination']])
@endif
@section('css')
<style>
    .full_name {
        word-break: break-all;
        max-width: 100px;
    }
</style>
@endsection
