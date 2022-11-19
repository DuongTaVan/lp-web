@extends('client.base.base')
@section('css')
    <style>
        .main-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="main dashboard-wrapper my-page-student credit-card-info">
        <div class="container px-0">
            <div class="row">
                <div class="col-md-3 col-sm-3 mw-300">
                    @include('client.student-mypage.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right main_content">
                    <div class="main-right page-credit">
                        @include('client.common.dashboard-role')
                        <div class="main-right__title">
                            {{--                            <div class="sidebar-right__title__text">--}}
                            {{--                                @lang('labels.account-setting.account_settings') > @lang('labels.credit-card.credit_card_information')--}}
                            {{--                            </div>--}}
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item f-w6">
                                        <a>@lang('labels.account-setting.account_settings')</a></li>
                                    <li class="breadcrumb-item f-w6">
                                        <a>@lang('labels.credit-card.credit_card_information')</a></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="payment-wrapper">
                            <div class="payment-info-wrapper">
                                <form action="{{ route('client.orders.payment.update') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{ \Request::get('type') ?? null }}" name="type">
                                    <div class="payment-edit-content d-flex">
                                        <div class="right">
                                            <div class="right-payment-content">
                                                <div class="title f-w6">
                                                    {{ trans('labels.order.card_info') }}
                                                </div>
                                                <div class="d-flex align-items-center list-bank-icon">
                                                    <img src="{{ url('assets/img/clients/cards/visa.svg') }}" alt="">
                                                    <img src="{{ url('assets/img/clients/cards/master_card.svg') }}"
                                                         alt="">
{{--                                                    <img src="{{ url('assets/img/clients/cards/jcb.svg') }}" alt="">--}}
                                                    <img src="{{ url('assets/img/clients/cards/american-express.svg') }}"
                                                         alt="">
{{--                                                    <img src="{{ url('assets/img/clients/cards/dinner.svg') }}" alt="">--}}
                                                </div>
                                                <div class="bank-text">
                                                    ※Visa、Master、American Expressの対応となります。
                                                </div>
                                                <div class="payment-content">
                                                    <div class="title f-w6">
                                                        {{ trans('labels.order.card_number') }}
                                                    </div>
                                                    <div class="account-number">
                                                        <input
                                                                value="{{ old('number', '') }}"
                                                                type="text"
                                                                class="form-control @if($errors->has('number')) validate-error @endif"
                                                                name="number"
                                                                id="account-number"
                                                                maxlength="19"
                                                        >
                                                        @if ($errors->has('number'))
                                                            <span class="text-danger">{{ $errors->first('number') }}</span>
                                                            <br>
                                                        @endif
                                                        @if ($errors->has('error_card') && $errors->first('error_card') == 'number')
                                                            <div class="text-danger">
                                                                {{ __('errors.MSG_5045') }}
                                                            </div>
                                                        @endif
                                                        <a class="suggest">例）1234567890123456</a>
                                                    </div>
                                                    <div class="title f-w6">
                                                        {{ trans('labels.order.expired_date') }}
                                                    </div>
                                                    <div class="expired-date">
                                                        <div class="d-flex expired-date-content">
                                                            <div class="expired-date-month">
                                                                <input value="{{ old('exp_month', '') }}" type="text"
                                                                       name="exp_month" maxlength="2"
                                                                       class="form-control" placeholder="月">
                                                                {{-- @if ($errors->has('exp_month'))
                                                                    <span class="text-danger">{{ $errors->first('exp_month') }}</span>
                                                                    <br>
                                                                @endif --}}
                                                            </div>
                                                            <div class="expired-date-year">
                                                                <input value="{{ old('exp_year', '') }}" type="text"
                                                                       name="exp_year" maxlength="4"
                                                                       class="form-control" placeholder="年">
                                                                {{-- @if ($errors->has('exp_year'))
                                                                    <span class="text-danger">{{ $errors->first('exp_year') }}</span>
                                                                    <br>
                                                                @endif --}}
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
                                                        {{-- @if ($errors->has('error_card') && ($errors->first('error_card') == 'exp_month' || $errors->first('error_card') == 'exp_year'))
                                                            <div class="text-danger">
                                                                {{ __('errors.MSG_5046') }}
                                                            </div>
                                                        @endif --}}
                                                        <span class="suggest">※カードに刻印されている表記のとおりにご選択ください。</span>
                                                    </div>
                                                    <div class="title f-w6">
                                                        {{ trans('labels.order.owner_bank') }}
                                                    </div>
                                                    <div class="owner-bank">
                                                        <input value="{{ old('owner_bank', '') }}" type="text"
                                                               name="owner_bank" class="form-control">
                                                        @if ($errors->has('owner_bank'))
                                                            <span class="text-danger">{{ $errors->first('owner_bank') }}</span>
                                                            <br>
                                                        @endif
                                                        @if ($errors->has('error_card') && $errors->first('error_card') == 'owner_bank')
                                                            <div class="text-danger">
                                                                {{ __('errors.MSG_5047') }}
                                                            </div>
                                                        @endif
                                                        <span class="suggest">※カードに刻印されている表記のとおりにご選択ください。</span>
                                                    </div>
                                                </div>
                                                <div class="title f-w6">
                                                    {{ trans('labels.order.bank_code') }}
                                                </div>
                                                <div class="secret-code d-flex align-items-center">
                                                    <input value="{{ old('cvc', '') }}" type="text" name="cvc"
                                                           class="form-control" maxlength="4">
                                                    <a style="cursor: pointer" class="fs-14" data-toggle="modal"
                                                       data-target="#explain-modal">
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
                                                <a href="{{ url()->previous() }}" class="btn fs-14 button-cancel">
                                                    @lang('labels.button.back_step')
                                                </a>
                                                <button class="btn fs-14 button-confirm">
                                                    @lang('labels.change-password.button')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.payment.secure-explain')
@endsection
