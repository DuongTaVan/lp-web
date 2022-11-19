<div class="list-services-table" style="margin-top: 4px" id="result">
    @if(!empty($data['courseSchedules']) && $data['courseSchedules']->total() > 0)
    <table>
        <thead>
        <tr>
            <td class="service-title-header">
                @lang('labels.messages-course-purchase.service-title')
            </td>
            <td class="event-day-header">
                @lang('labels.messages-course-purchase.event-day')
            </td>
            <td class="time-header">
                @lang('labels.messages-course-purchase.time-header')
            </td>
            <td class="day-receive-header">
                @lang('labels.messages-course-purchase.day-receive')
            </td>
            <td class="receive-at-header">
                @lang('labels.messages-course-purchase.receive-at')
            </td>
            <td class="status-header">
                @lang('labels.messages-course-purchase.status-header')
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
                <td class="service-title">
                    <div class="left">
                        <img src="{{ $item->image }}" alt="">
                    </div>
                    <div class="right d-flex">
                        <div>{{$item['title'] ?? null}}</div>
                        <div>¥{{number_format($item['price'])}}</div>
                    </div>
                </td>
                <td class="event-day">
                    {{ now()->parse($item['start_datetime'])->format('Y/m/d') }}
                </td>
                <td class="time">
                    {{ $item->hour_minute }}
                </td>
                <td class="day-receive">
                    {{ isset($item->lastMessage['createdAt']) ? formatTime($item->lastMessage['createdAt']) : null }}
                </td>
                <td class="receive-at">
                    {{ isset($item->lastMessage['createdAt']) ? formatDayTime($item->lastMessage['createdAt']) : null }}
                </td>
                <td class="status">
                    @if(isset($item->lastMessage) && !$item->lastMessage['is_read'])
                        <img src="{{ url('assets/img/common/checked.svg') }}" alt="">
                    @endif
                </td>
                <td class="message">
                    <a href="{{ route('client.student.message.message-detail', array_merge($dataPage, [$item['course_schedule_id']])) }}">
                        <img src="{{ url('assets/img/common/email.svg') }}" alt="">
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@if(!empty($data['courseSchedules']) && $data['courseSchedules']->total() > 0)
    {{ $data['courseSchedules']->appends(request()->query())->links('client.layout.paginate') }}
@endif