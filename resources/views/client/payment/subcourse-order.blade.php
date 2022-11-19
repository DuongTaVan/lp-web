@extends('client.base.base')
@section('css')
    <style>
        .payment-wrapper .payment-info-wrapper .content {
            max-width: 900px;
        }

        .payment-wrapper .payment-info-wrapper .left {
            max-width: 376px;
        }

        .payment-wrapper .payment-info-wrapper .left .total-payment .text-data {
            margin-left: auto !important;
        }
    </style>
@endsection
@section('content')
    <div class="payment-wrapper sub-course-order">
        <div class="step-wrapper d-flex justify-content-center align-items-center">
            <div class="step active">
                <div>
                    1
                </div>
                <div class="ml-11">
                    {{ __('labels.order.choose_method') }}
                </div>
            </div>
            <div class="next-step"></div>
            {{--            <div class="next-step next-step-active"></div>--}}
            <div class="step">
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
        @include('client.payment.process-payment-circle', ['step' => 'STEP 1', 'deg' => 120, 'title' => 'お支払い方法選択', 'size' => 56])
        @if(isset($message))
            <div class="header">
                {{$message}}
            </div>
        @endif
        @if(isset($courseSchedule))
            <div class="header">
                予約する内容の確認
            </div>

            <div class="payment-info-wrapper">
                <div class="content d-flex">
                    <div class="left">
                        <div class="total-payment total-payment-subcourse">
                            <div class="d-flex datetime align-items-center">
                                <div class="title">
                                    {{ trans('labels.sub_course_detail.datetime') }}
                                </div>
                                <div class="text-data">
                                    {{ $courseSchedule->datetime_detail ?? null }}
                                </div>
                            </div>
                            <div class="d-flex time-usage align-items-center">
                                <div class="title">
                                    {{ trans('labels.sub_course_detail.time_usage') }}
                                </div>
                                <div>
                                    {{ $courseSchedule->course ? $courseSchedule->minutes_required : null }}{{ trans('labels.unit.minute') }}
                                </div>
                            </div>
                            <div class="d-flex total align-items-center">
                                <div class="title f-w6">
                                    {{ trans('labels.sub_course_detail.fee') }}
                                </div>
                                <div>
                                    {{ formatCurrency($courseSchedule->course ? $courseSchedule->price : 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        @include('client.payment.payment')
                    </div>
                </div>
            </div>
        @endif
        @if(isset($courseSchedule))
            <div class="order-confirm">
                <a class="btn fs-14 button-confirm"
                   href="@if(\Request::route()->getName() == 'client.orders.payment.index') {{ route('client.orders.payment.confirm', ['courseScheduleId' => $courseScheduleId, 'optional_extra_id' => $_GET['optional_extra_id'] ?? []]) }} @else {{ route('client.orders.payment.sub-course-confirm', [$mainCourseScheduleId, 'course_schedule_id' => $courseScheduleId]) }} @endif">
                    {{ trans('labels.button.confirm') }}
                </a>
            </div>
        @endif
    </div>
@endsection


