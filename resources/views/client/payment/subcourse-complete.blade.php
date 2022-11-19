@extends('client.base.base')
@section('content')
    <div class="payment-wrapper sub-course-order-confirm sub-course-order-completed">
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
            <div class="next-step next-step-active"></div>
            <div class="step active">
                <div>
                    3
                </div>
                <div class="ml-17">
                    {{ __('labels.order.done_payment') }}
                </div>
            </div>
        </div>
        @include('client.payment.process-payment-circle', ['step' => 'STEP 3', 'deg' => 360, 'title' => '予約完了', 'size' => 56])
        <div class="header">
            予約が完了しました
        </div>
        <div class="content-wrapper">
            <div class="content">
                <div class="datetime">
                    <div class="title">
                        {{ trans('labels.sub_course_detail.datetime') }}
                    </div>
                    <div>
                        {{ $courseSchedule->datetime_detail }}
                    </div>
                </div>
                <div class="time-usage">
                    <div class="title">
                        {{ trans('labels.sub_course_detail.time_usage') }}
                    </div>
                    <div>
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
                    <div>
                        クレジットカード
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('client.home') }}" class="btn order-btn-back sub-course-back-btn">{{ trans('labels.users.button.close') }}</a>
            </div>
            {{--            <div class="transfer-history">--}}
            {{--                <div class="d-flex transfer-history-datetime">--}}
            {{--                    <div>--}}
            {{--                        {{ trans('labels.sub_course_detail.datetime') }}--}}
            {{--                    </div>--}}
            {{--                    <div>--}}
            {{--                        3月30日--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div class="d-flex transfer-history-time-usage">--}}
            {{--                    <div>--}}
            {{--                        {{ trans('labels.sub_course_detail.time_usage') }}--}}
            {{--                    </div>--}}
            {{--                    <div>--}}
            {{--                        19:00 - 21:00--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
@endsection
