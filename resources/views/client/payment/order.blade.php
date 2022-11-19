@extends('client.base.base')
@section('css')
    <style>
        .credit-confirm {
            width: 324px;
            height: 41px;
            margin: 25px auto 0;
            background: #46CB90;
            font-weight: 700;
            border: 1px solid #46CB90;
            border-radius: 5px;
            color: #FFFFFF;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
        .credit-confirm:hover {
            color: #FFFFFF;
        }
        @media only screen and (max-width: 576px) {
            .credit-confirm {
                width: 100%;
                margin-bottom: 88px;
            }
            #header {
                position: relative;
            }

            .layout-content {
                padding: 0 !important;
            }

            .change {
                max-width: unset !important;
                padding-right: unset !important;
            }
        }
    </style>
@endsection
@section('content')
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
            <div class="next-step"></div>
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
        <form action="{{ route('client.orders.payment.credit-confirm') }}" method="post">
            @csrf
            <div class="payment-info-wrapper">
                <div class="header-title">
                    {{ trans('labels.order.header-title') }}
                </div>
                <div class="content">
                    <div class="left">
                        <div class="image text-center" id="image-container">
                            <img onload="loadImage(event)" id="image-course"
                                src="{{ $courseSchedule->image_url ?? asset('assets/img/portal/default-image.svg') }}"
                                alt="">
                        </div>
                        <div class="total-payment total-payment-order">
                            <div class="title f-w6 payment-word-wrap">
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
                            <div class="fee">
                                <div class="title d-flex align-items-center">
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
                    <div class="right">
                        @include('client.payment.payment')
                    </div>
                </div>
            </div>
            @if (empty($creditCard))
                <button type="submit" class="btn fs-14 credit-confirm">
                    {{ trans('labels.button.confirm') }}
                </button>
            @else
            <div class="order-confirm">
                <a class="btn fs-14 button-confirm"
                href="@if(\Request::route()->getName() == 'client.orders.payment.index') {{ route('client.orders.payment.confirm', ['courseScheduleId' => $courseScheduleId, 'optional_extra_id' => $_GET['optional_extra_id'] ?? []]) }} @else {{ route('client.orders.payment.sub-course-confirm', $courseScheduleId) }} @endif">
                    {{ trans('labels.button.confirm') }}
                </a>
            </div>
            @endif
        </form>
    </div>
@endsection
