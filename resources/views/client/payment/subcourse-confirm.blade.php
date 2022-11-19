@extends('client.base.base')
@section('content')
    <div class="payment-wrapper sub-course-order-confirm">
        <div class="step-wrapper d-flex justify-content-center align-items-center">
            <div class="step active">
                <div>
                    1
                </div>
                <div class="ml-11">
                    {{ __('labels.order.choose_method') }}
                </div>
            </div>
            <div class="next-step next-step-active"></div>
            <div class="step active">
                <div>
                    2
                </div>
                <div class="ml-15">
                    {{ __('labels.order.confirm_payment') }}
                </div>
            </div>
            <div class="next-step"></div>
            <div class="step">
                <div>
                    3
                </div>
                <div class="ml-17">
                    {{ __('labels.order.done_payment') }}
                </div>
            </div>
        </div>
        @include('client.payment.process-payment-circle', ['step' => 'STEP 2', 'deg' => 240, 'title' => '内容の確認', 'size' => 56])
        <div class="header">
            {{ trans('labels.confirm_order.confirm_content_order') }}
        </div>
        <div class="content-wrapper">
            <form action="{{ route('client.course-schedules.purchase-sub-course') }}" method="post">
                @csrf
                <input type="hidden" name="course_schedule_id" value="{{ $courseScheduleId }}">
                <input type="hidden" name="main_course_schedule_id" value="{{ $mainCourseScheduleId }}">
                <div class="content">
                    {{--                    @if($errors->has('error'))--}}
                    {{--                        <div id="show-toast-error" data-msg="{{ $errors->first('error') }}"></div>--}}
                    {{--                    @endif--}}
                    <div class="datetime">
                        <div class="title">
                            {{ trans('labels.sub_course_detail.datetime') }}
                        </div>
                        <div class="f-w6">
                            {{ $courseSchedule->datetime_detail }}
                        </div>
                    </div>
                    <div class="time-usage">
                        <div class="title">
                            {{ trans('labels.sub_course_detail.time_usage') }}
                        </div>
                        <div class="f-w6">
                            {{ $courseSchedule->course ? $courseSchedule->minutes_required : null }}分
                        </div>
                    </div>
                    <div class="fee">
                        <div class="title">
                            {{ trans('labels.sub_course_detail.fee') }}
                        </div>
                        <div>
                            {{ formatCurrency($courseSchedule->course ? $courseSchedule->price : 0) }}
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="title">
                            {{ trans('labels.sub_course_confirm.payment_method') }}
                        </div>
                        <div class="f-w6">
                            {{ trans('labels.sub_course_confirm.credit_card') }}
                        </div>
                    </div>
                </div>
                <div class="action">
                    <a class="btn btn-back action-button"
                       href="{{ route('client.orders.payment.sub-course.view', [$mainCourseScheduleId, 'course_schedule_id' => $courseScheduleId]) }}">
                        {{ trans('labels.button.back_step') }}
                    </a>
                    <button class="btn btn-pay">
                        {{ trans('labels.button.pay') }}
                    </button>
                </div>
            </form>
        </div>
        @include('client.payment.modal-error')
    </div>
@endsection
