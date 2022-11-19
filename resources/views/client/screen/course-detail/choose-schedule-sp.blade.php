<div class="modal fade modal-custom pr-0" id="modal-choose-schedule" tabindex="-1"
     aria-labelledby="modal-choose-scheduleLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-choose-schedule-content ">
            <div class="modal-body text-center">
                <div class="d-flex flex-column">
                    @php
                        $order = 0;
                    @endphp
                    @if(isset($consultationPreview))
                        <div data-id="{{ $data["course_schedule_id"] }}"
                             class="schedule-list d-flex flex-column justify-content-center align-items-center">
                            <span class="schedule-list__date fw-600">{{ date('m', strtotime($data['start_datetime'])) }}月{{ date('d', strtotime($data['start_datetime'])) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($data['start_datetime']))]  }})</span>
                            <span class="schedule-list__time">{{ date_format(date_create($data['start_datetime']), 'H:i') }} - {{ date_format(date_create($data['end_datetime']), 'H:i') }}</span>
                            <span id="schedule-list__price"
                                  style="display: none">{{ number_format($data['price']) }}</span>
                            <span id="deadline" style="display: none"> {{ (date('m', strtotime($data['purchase_deadline']))) }}月{{ (date('d', strtotime($data['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($data['purchase_deadline']))] }})</span>
                            <span id="number_of_participants"
                                  style="display: none">{{ number_format($data['fixed_num']) }}</span>
                            <input type="hidden" value="{{$data['course_schedule_id']}}">
                        </div>
                    @else
                        @foreach($data as $key => $item)
                            <div id="option{{$key}}"
                                data-id="{{ $item["course_schedule_id"] }}"
                                data-url="{{ route('client.course-schedules.detail', $item["course_schedule_id"]) }}"
                                class="schedule-list d-flex flex-column justify-content-center align-items-center">
                                <span class="schedule-list__date fw-600">{{ date('m', strtotime($item['start_datetime'])) }}月{{ date('d', strtotime($item['start_datetime'])) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]  }})</span>
                                <span class="schedule-list__time">{{ date_format(date_create($item['start_datetime']), 'H:i') }} - {{ date_format(date_create($item['end_datetime']), 'H:i') }}</span>

                                <span class="schedule-list__text">{{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$item['dist_method'] ?? $item->course->dist_method] }}</span>
                                <span id="schedule-list__price" style="display: none"
                                        data-id="{{ $key }}">{{ number_format($item['price']) }}</span>
                                <span id="deadline" style="display: none" data-id="{{ $key }}"> {{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})</span>
                                <span id="number_of_participants" style="display: none"
                                        data-id="{{ $key }}">{{ number_format($item['fixed_num']) }}</span>
                                <input type="hidden" value="{{$item['course_schedule_id']}}">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .schedule-list {
        background: #f3f3f3;
        border-radius: 5px;
        height: 80px;
        width: 100%;
        color: #2A3242;
    }

    .schedule-list:not(:first-child) {
        margin-top: 8px;
    }

    .schedule-list__date {
        font-size: 16px;
    }

    .schedule-list__time {
        font-size: 20px;
    }

    .schedule-list__text {
        font-size: 14px;
        color: rgba(42, 50, 66, 0.53);
    }
</style>
