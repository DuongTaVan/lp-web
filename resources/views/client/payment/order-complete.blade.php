@extends('client.base.base')
@section('css')
    <style>
        .payment-wrapper .payment-confirm-wrapper {
            max-width: 500px;
        }

        .payment-confirm-wrapper__content-course {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .payment-confirm-wrapper__content-course .title {
            text-align: center;
        }

        .payment-wrapper .payment-confirm-wrapper .detail-payment {
            max-width: 170px;
            margin: auto;
        }

        @media only screen and (max-width: 576px) {
            #header {
                position: relative;
            }

            .payment-confirm-wrapper__content-course {
                display: unset;
            }

            .payment-confirm-wrapper__content-course .title {
                text-align: unset;
            }

            .payment-wrapper .payment-confirm-wrapper .detail-payment {
                max-width: unset;
            }

            .payment-wrapper .payment-confirm-wrapper .time:last-child {
                margin-left: unset;
            }

            .layout-content {
                padding: 0 !important;
            }
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('client.orders.payment.submit-payment') }}" method="post">
        @csrf
        <div class="payment-wrapper">
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
            <div class="confirm-title">
                {{ trans('labels.confirm_order.payment_success') }}
            </div>
            <div class="payment-confirm-wrapper">
                <div class="payment-confirm-wrapper__content-course">
                    <div class="title f-w6">
                        {{ $courseSchedule->title }}
                    </div>
                    <div class="time d-flex align-items-center">
                        <img src="{{ url('assets/img/clients/calender.svg') }}" alt="">
                        <div>
                            {{ formatMonthYear($courseSchedule->start_datetime) }}
                        </div>
                        <div>
                            {{ formatDayTime($courseSchedule->start_datetime) }}
                            - {{ formatDayTime($courseSchedule->end_datetime) }}
                        </div>
                    </div>
                </div>

                <div class="detail-payment">
                    <div class="fee">
                        <div class="title">
                            @if($categoryType === \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                                {{ trans('labels.course-detail.course_livestream') }}
                            @elseif($categoryType === \App\Enums\DBConstant::CATEGORY_TYPE_CONSULTATION)
                                {{ trans('labels.course-detail.course_consultation') }}
                            @elseif($categoryType === \App\Enums\DBConstant::CATEGORY_TYPE_FORTUNETELLING)
                                {{ trans('labels.course-detail.course_fortune') }}
                            @endif
                        </div>
                        <div class="fee-amount f-w6">
                            {{ formatCurrency($courseSchedule->price) }}
                        </div>
                    </div>
                    @foreach($optionExtras as $optionExtra)
                        <div class="option d-flex">
                            <div class="option-left confirm">
                                <div class="d-flex">
                                    <div class="option-title d-flex justify-content-center">
                                        {{ trans('labels.order.option') }}
                                    </div>
                                    <div class="ml-2 title-str">{{ $optionExtra->optionalExtra->title }}</div>
                                </div>
                                <div class="mt-6 title-str"></div>
                            </div>
                            <div class="option-right">
                                {{ formatCurrency($optionExtra->optionalExtra->price ?? 0) }}
                            </div>
                        </div>
                    @endforeach
                    <div class="total d-flex">
                        <div class="total-title">
                            {{ trans('labels.order.total_mount') }}
                        </div>
                        <div class="total-amount">
                            {{ formatCurrency($purchase->total_amount) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('client.course-schedules.detail', $courseScheduleId) }}"
                   class="btn order-btn-back">{{ trans('labels.button.back_step') }}</a>
            </div>
        </div>
    </form>
@endsection
