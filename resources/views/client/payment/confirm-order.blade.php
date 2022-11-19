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
        .payment-wrapper .payment-confirm-wrapper .detail-payment {
            max-width: 170px;
            margin: auto;
        }

        @media only screen and (max-width: 576px) {
            #header {
                position: relative;
            }

            .layout-content {
                padding: 0 !important;
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
        }
    </style>
@endsection
@section('content')
    <form id="purchase-main-course" action="{{ route('client.course-schedules.purchase-main-course') }}" method="post">
        @csrf
        @foreach($_GET['optional_extra_id'] ?? [] as $extra)
            <input type="hidden" name="optional_extra_id[]" value="{{ $extra }}">
        @endforeach
        <input type="hidden" name="course_schedule_id" value="{{ $courseScheduleId }}">
        <div class="payment-wrapper">
            @include('client.payment.process-payment-circle', ['step' => 'STEP 2', 'deg' => 240, 'title' => '内容の確認', 'size' => 56])
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
            <div class="confirm-title">
                {{ trans('labels.confirm_order.confirm_content_order') }}
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
                    @foreach($courseSchedule->optionalExtras as $optionExtra)
                        <input type="hidden" name="optional_extra_ids[]" value="{{ $optionExtra->optional_extra_id }}">
                        <div class="option d-flex">
                            <div class="option-left">
                                <div class="option-title d-inline-block">
                                    {{ trans('labels.order.option') }}
                                </div>
                                <span class="ml-2 title-str">{{ $optionExtra->title }}</span>
                            </div>
                            <div class="option-right d-flex justify-content-center align-items-center">
                                {{ formatCurrency($optionExtra->price) }}
                            </div>
                        </div>
                    @endforeach
                    <div class="total d-flex">
                        <div class="total-title">
                            {{ trans('labels.order.total_mount') }}
                        </div>
                        <div class="total-amount">
                            {{ formatCurrency($courseSchedule->price + $courseSchedule->optional_price_sum) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="payment-action">
                <a href="{{ route('client.orders.payment.index', ['courseScheduleId' => $courseScheduleId, 'optional_extra_id' => $_GET['optional_extra_id'] ?? []]) }}"
                   class="btn btn-action btn-back">
                    {{ trans('labels.button.back_step') }}
                </a>
                <button class="btn btn-pay" type="submit">
                    {{ trans('labels.button.pay') }}
                </button>
            </div>
        </div>
        @include('client.payment.modal-error')
    </form>
@endsection
