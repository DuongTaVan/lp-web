<div class="list-services-table" id="result">
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
        @forelse($data['courseScheduleNotPurchase'] as $item)
            <tr>
                <td class="service-title d-flex justify-content-center">
                    <div class="left">
                        <img src="{{empty($item->course->courseImage)? asset('assets/img/portal/default-image.svg') :asset($item->course->courseImage->img_url)}}"
                             alt="">
                    </div>
                    <div class="right d-flex">
                        <div>{{$item['title'] ?? null}}</div>
                        <div>¥{{number_format($item['price'])}}</div>
                    </div>
                </td>
                <td class="event-day">
                    {{now()->parse($item['start_datetime'])->format('y/m/d')}}
                </td>
                <td class="time">
                    {{$item->hour_minute}}
                </td>
                <td class="day-receive">
                    {{$item['receive_day'] ?? null}}
                </td>
                <td class="receive-at">
                    {{$item['receive_at'] ?? null}}
                </td>
                <td class="status">
                    @if(isset($item->lastMessage) && !$item->lastMessage['is_read'])
                        <img src="{{ url('assets/img/common/checked.svg') }}" alt="">
                    @endif
                </td>
                <td class="message">
                    <a href="{{ route('client.student.message.message-detail', array_merge(Request::all(), [$item['course_schedule_id']])) }}">
                        <img src="{{ url('assets/img/common/email.svg') }}" alt="">
                    </a>
                </td>
            </tr>
        @empty
            <tr style="background: #fff">
                <td colspan="7">
                    <p class="text-center">@lang('labels.search.no_data')</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@if(!empty($data['courseScheduleNotPurchase']))
    {{ $data['courseScheduleNotPurchase']->appends(request()->query())->links('client.layout.paginate') }}
@endif
