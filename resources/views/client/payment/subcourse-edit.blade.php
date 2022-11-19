@extends('client.base.base')
@section('content')
    <div class="sub-course-detail">
        <div class="">
            <div class="header f-w6">
                {{ trans('labels.sub_course_detail.header') }}
            </div>
            <div class="wrapper-content pd-121">
                <form action="{{ route('client.orders.payment.sub-order') }}" method="POST">
                    @csrf
                    <input type="hidden" id="course-schedule-id">
                    <input type="hidden" name="mainCourseScheduleId" value="{{$courseScheduleId}}">
                    <div class="content">
                        <div class="course-title font-text">
                            <div class="title">
                                {{ trans('labels.sub_course_detail.course-title') }}
                            </div>
                            <div>{{ $subCourse->title }}</div>
                        </div>
                        <div class="datetime-wrapper d-flex font-text">
                            <div class="title">
                                {{ trans('labels.sub_course_detail.datetime') }}
                            </div>
                            <div class="datetime-content font-text">
                                @php
                                    $countCourseScheduleDisplay = 0;
                                @endphp
                                @foreach($subCourse->courseSchedules as $index => $child)
                                    @if ($child->purchases->count() === 0 && $child->num_of_applicants != $child->fixed_num)
                                        <label class="button-radio ml-0">
                                            {{ $child->datetime_detail }}
                                            <input type="radio" id="first-time_{{ $index }}"
                                                   value="{{ $child->course_schedule_id }}"
                                                   data-minute="{{ $child->minutes_required }}"
                                                   data-price="{{ number_format($child->price) }}"
                                                   name="course_schedule_id" {{ !$countCourseScheduleDisplay ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        @php
                                            $countCourseScheduleDisplay++;
                                        @endphp
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="time-usage d-flex align-items-center">
                            <div class="title">
                                {{ trans('labels.sub_course_detail.time_usage') }}
                            </div>
                            <div class="d-flex align-items-center" id="minutes_required-html">
                                @if($subCourse)
                                    {{ $subCourse->courseSchedules[0]->minutes_required . trans('labels.unit.minute') }}
                                @endif
                            </div>
                        </div>
                        <div class="fee d-flex align-items-center">
                            <div class="title">
                                {{ trans('labels.sub_course_detail.fee') }}
                            </div>
                            <div class="d-flex align-items-center" id="price-html">
                                {{ '￥'.number_format($subCourse->courseSchedules[0]->price ?? 0) }}
                            </div>
                        </div>
                    </div>
                    <div class="action">
                        <button class="btn btn-buy @if(!$countCourseScheduleDisplay) disabled-btn @endif"
                                type="submit">{{ trans('labels.button.buy') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('js/clients/orders/suborder-detail.js') }}"></script>
@endsection

@section('css')
    <style>
        .disabled-btn {
            background-color: #9B9F9E !important;
            pointer-events: none;
            border: none !important;
        }
    </style>
@endsection
