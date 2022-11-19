@extends('client.base.base')
@section('css')
    <style>
        @media only screen and (max-width: 576px) {
            #header {
                position: relative;
            }

            .layout-content {
                padding: 0 !important;
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
        <div class="header-title-sp">
            {{ trans('labels.order.header-title-sp') }}
        </div>
        <div class="payment-info-wrapper">
            <form action="{{ route('client.orders.payment.update') }}" method="post">
                @csrf
                <input type="hidden" value="{{ \Request::get('type') ?? null }}" name="type">
                <input type="hidden" value="{{$courseScheduleId}}" name="courseScheduleId">
                <input type="hidden" value="{{ \Request::get('main_course_schedule') ?? null }}"
                       name="mainCourseScheduleId">
                @if(isset($_GET['optional_extra_id']))
                    @foreach($_GET['optional_extra_id'] ?? [] as $extra)
                        <input type="hidden" name="optional_extra_id[]" value="{{ $extra }}">
                    @endforeach            @endif
                <div class="payment-edit-content d-flex">
                    <div class="right">
                        <div class="right-payment-content">
                            @if ($errors->has('error'))
                                <div id="show-toast-error" data-msg="{{ $errors->first('error') }}"></div>
                            @endif
                            <div class="title">
                                {{ trans('labels.order.card_info') }}
                            </div>
                            <div class="d-flex list-bank align-items-center">
                                <img src="{{ url('assets/img/clients/cards/visa.svg') }}" alt="" class="visa-icon">
                                <img src="{{ url('assets/img/clients/cards/master_card.svg') }}" alt=""
                                     class="mastercard-icon">
{{--                                <img src="{{ url('assets/img/clients/cards/jcb.svg') }}" alt="" class="jcb-icon">--}}
                                <img src="{{ url('assets/img/clients/cards/american-express.svg') }}" alt=""
                                     class="ae-icon">
{{--                                <img src="{{ url('assets/img/clients/cards/dinner.svg') }}" alt=""--}}
{{--                                     class="dinner-icon">--}}
                            </div>
                            <div class="bank-text">
                                ※Visa、Master、American Expressの対応となります。
                            </div>
                            <div class="payment-content">
                                <div class="title">
                                    {{ trans('labels.order.card_number') }}
                                </div>
                                <div class="account-number">
                                    <input
                                            value="{{ old('number') }}"
                                            type="text"
                                            class="form-control @if($errors->has('number')) validate-error @endif"
                                            name="number"
                                            id="account-number"
                                            maxlength="19"
                                    >
                                    @if ($errors->has('error_card') && $errors->first('error_card') == 'number')
                                        <div class="text-danger">
                                            {{ __('errors.MSG_5045') }}
                                        </div>
                                    @endif
                                    @if ($errors->has('number'))
                                        <span class="text-danger">{{ $errors->first('number') }}</span>
                                        <br>
                                    @endif
                                    <a class="suggest">例）1234567890123456</a>
                                </div>
                                <div class="title">
                                    {{ trans('labels.order.expired_date') }}
                                </div>
                                <div class="expired-date">
                                    <div class="d-flex expired-date-content">
                                        <div class="expired-date-month">
                                            <input value="{{ old('exp_month') }}"
                                                   type="text" name="exp_month" maxlength="2" class="form-control"
                                                   placeholder="月">
                                        </div>
                                        <div class="expired-date-year">
                                            <input value="{{ old('exp_year') }}"
                                                   type="text" name="exp_year" maxlength="4" class="form-control"
                                                   placeholder="年">
                                        </div>
                                    </div>
                                    @if ($errors->has('error_card') && ($errors->first('error_card') == 'exp_month' || $errors->first('error_card') == 'exp_year'))
                                        <div class="text-danger">
                                            {{ __('errors.MSG_5046') }}
                                        </div>
                                    @endif
                                    @if (($errors->has('exp_month') || $errors->has('exp_year'))
                                        && ($errors->first('exp_month') === \App\Enums\Constant::REQUIRED_ERROR || $errors->first('exp_year') === \App\Enums\Constant::REQUIRED_ERROR))
                                        <div class="text-danger">
                                            {{ __('errors.MSG_5049') }}
                                        </div>
                                    @else
                                        @if ($errors->has('exp_month'))
                                            <span class="text-danger">{{ $errors->first('exp_month') }}</span>
                                            <br>
                                        @endif
                                        @if ($errors->has('exp_year'))
                                            <span class="text-danger">{{ $errors->first('exp_year') }}</span>
                                            <br>
                                        @endif
                                    @endif
                                    <div class="suggest">※カードに刻印されている表記のとおりにご選択ください。</div>
                                </div>
                                <div class="title">
                                    {{ trans('labels.order.owner_bank') }}
                                </div>
                                <div class="owner-bank">
                                    <input value="{{ old('owner_bank') }}"
                                           type="text" name="owner_bank" class="form-control">
                                    @if ($errors->has('owner_bank'))
                                        <span class="text-danger">{{ $errors->first('owner_bank') }}</span>
                                        <br>
                                    @endif
                                    @if ($errors->has('error_card') && $errors->first('error_card') == 'owner_bank')
                                        <div class="text-danger">
                                            {{ __('errors.MSG_5047') }}
                                        </div>
                                    @endif
                                    <div class="suggest">※カードに刻印されている表記のとおりにご選択ください。</div>
                                </div>
                            </div>
                            <div class="title">
                                {{ trans('labels.order.bank_code') }}
                            </div>
                            <div class="secret-code d-flex align-items-center">
                                <input value="{{ old('cvc', '') }}" type="text" name="cvc" class="form-control"
                                       maxlength="4">
                                <a class="fs-14" data-toggle="modal" data-target="#explain-modal">
                                    {{ trans('labels.order.secret_code') }}
                                </a>
                            </div>
                            @if ($errors->has('cvc'))
                                <span class="text-danger">{{ $errors->first('cvc') }}</span>
                                <br>
                            @endif
                            @if ($errors->has('error_card') && $errors->first('error_card') == 'cvc')
                                <div class="text-danger">
                                    {{ __('errors.MSG_5048') }}
                                </div>
                            @endif
                        </div>
                        <div class="confirm">
                            {{-- {{dd($_GET['course_schedule_id'])}} --}}
                            <a href="{{ request()->get('type') != 'sub-course' ?
                                route('client.orders.payment.index', [$courseScheduleId, 'optional_extra_id' => $_GET['optional_extra_id'] ?? []]) :
                                route('client.orders.payment.sub-course.view', [$_GET['main_course_schedule'] ?? [], 'course_schedule_id' => $courseScheduleId, 'optional_extra_id' => $_GET['optional_extra_id'] ?? []]) }}"
                               class="btn fs-14 button-cancel">
                                {{ trans('labels.button.cancel') }}
                            </a>
                            <button class="btn fs-14 button-confirm" type="submit">
                                {{ trans('labels.button.confirm') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('client.payment.secure-explain')
@endsection
<style>
    input {
        border: 1px solid #CDCDCD !important;
    }

    input:focus {
        border: 1px solid #4BBD8B !important;
        outline: none !important;
    }
</style>
