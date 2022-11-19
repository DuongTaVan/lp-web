<style>
    .no-card input {
        background-color: #FFFFFF!important;
    }
</style>
<div class="right-payment-content {{ empty($creditCard) ? 'no-card' : '' }}">
    <div class="title">
        {{ trans('labels.order.card_info') }}
    </div>
    <div class="d-flex list-bank align-items-center">
        <img src="{{ url('assets/img/clients/cards/visa.svg') }}" alt="" class="visa-icon">
        <img src="{{ url('assets/img/clients/cards/master_card.svg') }}" alt="" class="mastercard-icon">
{{--        <img src="{{ url('assets/img/clients/cards/jcb.svg') }}" alt="" class="jcb-icon">--}}
        <img src="{{ url('assets/img/clients/cards/american-express.svg') }}" alt="" class="ae-icon">
{{--        <img src="{{ url('assets/img/clients/cards/dinner.svg') }}" alt="" class="dinner-icon">--}}
    </div>
    <div class="bank-text">
        ※VISA、Master、American Expressがご利用できます。
    </div>
    <div class="payment-content">
        <div class="title title-custom">
            {{ trans('labels.order.card_number') }}
            <style>
                .title-custom {
                    display: flex;
                    white-space: nowrap;
                    align-items: center;
                }

                .change_set {
                    font-style: normal;
                    font-weight: 300;
                    font-size: 10px;
                    line-height: 15px;
                    color: #EE3D48;
                    white-space: nowrap;
                    margin-left: 10px
                }

                .change {
                    margin-top: 18px;
                    max-width: 306px;
                    padding-right: 28px;
                }

                .change a {
                    width: 100%;
                }
            </style>
{{--            <span class="change_set">※画面下の「設定する」を押してから入力して下さい。</span>--}}
        </div>
        @if ($errors->has('error'))
            <div id="show-toast-error" data-msg="{{ $errors->first('error') }}"></div>
        @endif
        <div class="account-number">
            <input type="text" class="form-control @if($errors->has('number')) validate-error @endif" name="number" id="account-number" maxlength="19" value="{{ old('number') ?? (isset($creditCard["last4"]) ? "**** **** **** ".$creditCard["last4"] : "") }}" @if (isset($creditCard["last4"])) disabled @endif>
            @if ($errors->has('error_card') && $errors->first('error_card') == 'number')
            <div class="text-danger">
                {{ __('errors.MSG_5045') }}
            </div>
            @endif
            @if ($errors->has('number'))
            <span class="text-danger">{{ $errors->first('number') }}</span>
            <br>
            @endif
        </div>
        <div class="title">
            {{ trans('labels.order.expired_date') }}
        </div>
        <div class="expired-date d-flex">
            <div class="expired-date-month">
                <input type="text" name="exp_month" maxlength="2" value="{{ old('exp_month') ?? (isset($creditCard["exp_month"]) ? str_pad($creditCard["exp_month"], 2, '0', STR_PAD_LEFT) : "") }}" class="form-control" placeholder="月" @if (isset($creditCard["exp_month"])) disabled @endif>
            </div>
            <div class="expired-date-year">
                <input type="text" name="exp_year" maxlength="4" value="{{ old('exp_year') ?? $creditCard["exp_year"] ?? "" }}" class="form-control" placeholder="年" @if (isset($creditCard["exp_year"])) disabled @endif>
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
        <div class="title">
            {{ trans('labels.order.owner_bank') }}
        </div>
        <div class="owner-bank">
            <input type="text" name="owner_bank" value="{{ old('owner_bank') ?? $creditCard["account_name"] ?? "" }}" class="form-control" @if (isset($creditCard["account_name"])) disabled @endif>
            @if ($errors->has('owner_bank'))
            <span class="text-danger">{{ $errors->first('owner_bank') }}</span>
            <br>
            @endif
            @if ($errors->has('error_card') && $errors->first('error_card') == 'owner_bank')
            <div class="text-danger">
                {{ __('errors.MSG_5047') }}
            </div>
            @endif
        </div>
    </div>
    <div class="title">
        {{ trans('labels.order.bank_code') }}
    </div>
    <div class="secret-code d-flex align-items-center">
        <input type="text" name="cvc" class="form-control" maxlength="4" @if (isset($creditCard["last4"])) disabled @endif value="{{ old('cvc') ?? isset($creditCard["last4"]) ? '***' : ''}}">
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
    <input type="hidden" name="courseScheduleId" value="{{ $courseScheduleId ? $courseScheduleId : null }}">
    <input type="hidden" name="type" value="{{ \Request::route()->getName() == 'client.orders.payment.sub-course.view' ? 'sub-course' : null }}">
    <input type="hidden" name="main_course_schedule" value="{{ \Request::route()->getName() == 'client.orders.payment.sub-course.view' ? $mainCourseScheduleId : null }}">
    @if(isset($_GET['optional_extra_id']))
    @foreach($_GET['optional_extra_id'] ?? [] as $extra)
    <input type="hidden" name="optional_extra_id[]" value="{{ $extra }}">
    @endforeach @endif
    @if (!empty($creditCard))
    <div class="change">
        <a href="{{ route('client.orders.payment.edit', [$courseScheduleId, 'type' => \Request::route()->getName() == 'client.orders.payment.sub-course.view' ? 'sub-course' : null, 'optional_extra_id' => $_GET['optional_extra_id'] ?? [], 'main_course_schedule' => \Request::route()->getName() == 'client.orders.payment.sub-course.view' ? $mainCourseScheduleId : null]) }}" class="btn fs-14 change-button">
            {{ trans('labels.button.change_custom') }}
        </a>
    </div>
    @endif
</div>

@include('client.payment.secure-explain')
