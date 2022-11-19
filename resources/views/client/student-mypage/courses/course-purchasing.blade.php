<div class="list-services-table" id="result">
    @if(!empty($data['courseSchedules']) && $data['courseSchedules']->total() > 0)
        <table>
            <thead>
            <tr class="header">
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
            @foreach($data['courseSchedules'] as $index => $item)
                <tr>
                    <td class="service-title">
                        <div class="left">
                            <img src="{{ $item->image }}"
                                 alt="">
                        </div>
                        <div class="right d-flex">
                            <div>{{$item['title_course'] ?? null}}</div>
                            <div>¥{{number_format($item['price'])}}</div>
                        </div>
                    </td>
                    <td class="event-day">
                        {{ now()->parse($item['start_datetime'])->format('Y/m/d') }}
                    </td>
                    <td>{{ isset($item->actual_start_date)?(now()->parse($item->actual_start_date)->format('H:i') .' - ' .now()->parse($item->actual_end_date)->format('H:i')) :$item->hour_minute }}</td>
                    <td class="day-receive">
                        {{ isset($item->lastSentDatetime) ? formatTime($item->lastSentDatetime) : null }}
                    </td>
                    <td class="receive-at">
                        {{ isset($item->lastSentDatetime) ? formatDayTime($item->lastSentDatetime) : null }}
                    </td>
                    <td class="status">
                        @if(isset($item->lastMessage) && !$item->lastMessage['is_read'])
                            <img src="{{ url('assets/img/common/checked.svg') }}" alt="">
                        @endif
                    </td>
                    <td class="message">
                        <a href="
                            @if(isset($item['roomId']))
                                {{ route('client.messages.room-detail', $item['roomId']) }}
                            @else
                                {{ route('client.student.message.message-detail', $item['course_schedule_id']) }}
                            @endif
                            ">
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
