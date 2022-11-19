<style>
    .mw-82 {
        max-width: 82px;
    }
</style>
@extends('client.base.base')
@section('css')
    <style>
        .teacher-register-wrapper .teacher-register-info-wrapper .center .teacher-register-content .financial_institution {
            margin-bottom: 20px;
        }

        .teacher-register-wrapper .teacher-register-info-wrapper .center input::placeholder {
            color: #4E5768;
        }

        ::placeholder {
            color: #666666 !important;
        }

        .teacher-register-wrapper .teacher-register-info-wrapper .center .wrap-radio .label-title {
            color: #2A3242;
        }

        .input-payment {
            position: relative;
        }

        .input-payment .select__options {
            display: none;
            transform: scaleY(1);
            position: absolute;
            z-index: 4;
            width: 100%;
            transition: ease 0.3s;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            -webkit-transform-origin: top;
            transform-origin: top;
            /*border: 1px solid #DDDDDD;*/
            box-shadow: 0 0 10px 5px #cccccc;
            max-height: 200px;
            overflow-x: hidden;
            overflow-y: auto;
            user-select: none;
        }

        .active .select__options {
            display: block;
        }

        .input-payment .select__options .select__item {
            height: 40px;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            padding: 0 15px;
            font-size: 14px;
            line-height: 21px;
            user-select: none;
        }

        .input-payment .select__options .select__item:hover {
            background-color: rgba(70, 203, 144, 0.4);
            color: #46CB90;
            border-radius: 5px;
            border: 1px solid #DDDDDD;
        }

        .input-select {
            position: relative;
        }

        .input-select img {
            position: absolute;
            right: 10px;
            top: 14px;
        }

        .active .arrow-down {
            transition: 0.4s;
            transform: rotate(180deg);
        }

        .create-course-block .course__content .wrap-item__value__select .select.active .select__options {
            opacity: 1;
            transform: scaleY(1);
        }

        .financial_institution_type .note-input {
            font-size: 10px;
            margin-top: 5px;
            margin-left: 5px;
            font-weight: bold;
        }

        .remove-event {
            pointer-events: none;
            background-color: #9B9F9E !important;
        }

        .row-input-custom {
            display: flex;
        }

        @media only screen and (max-width: 414px) {
            .row-input-custom {
                display: block;
            }

            .ml-3-custom {
                margin-left: 0.5rem !important;
            }

            .teacher-register-wrapper .teacher-register-info-wrapper .center .wrap-radio {
                width: 65px;
                margin-left: 8px;
            }

            .financial_institution_type .note-input {
                margin-top: 0;
            }

            .teacher-register-wrapper .teacher-register-info-wrapper .center .confirm .next {
                background: #46CB90;
            }
        }

        @media only screen and (max-width: 390px) {
            .teacher-register-wrapper .teacher-register-info-wrapper .center .wrap-radio {
                width: 65px;
                margin-left: 14px;
            }
        }
    </style>
@endsection
@section('content')
    @php
        $isFortune = Request::session()->get('isFortune', false);
    @endphp
    <div class="teacher-register-wrapper">
        @if ($isFortune == true)
            <div class="step-wrapper d-flex justify-content-center align-items-center">
                <div class="step active">
                    <div>
                        1
                    </div>
                    <div class="ml-11">
                        {{ __('labels.teacher_register.personal_information') }}
                    </div>
                </div>
                {{-- <div class="next-step next-step-active"></div> --}}
                <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step mw-82"
                     alt="line-step-active">
                <div class="step active">
                    <div>
                        2
                    </div>
                    <div class="ml-15">
                        {{ __('labels.teacher_register.identification') }}
                    </div>
                </div>
                {{-- <div class="next-step next-step-active"></div> --}}
                <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step mw-82"
                     alt="line-step-active">
                <div class="step active">
                    <div>
                        3
                    </div>
                    <div class="ml-17">
                        機密保持契約
                    </div>
                </div>
                <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step mw-82"
                     alt="line-step-active">
                <div class="step active">
                    <div>
                        4
                    </div>
                    <div class="ml-17">
                        振込口座情報
                    </div>
                </div>
            </div>
        @else
            <div class="step-wrapper d-flex justify-content-center align-items-center">
                <div class="step active">
                    <div>
                        1
                    </div>
                    <div class="ml-11">
                        {{ __('labels.teacher_register.personal_information') }}
                    </div>
                </div>
                {{-- <div class="next-step next-step-active"></div> --}}
                <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step"
                     alt="line-step-active">
                <div class="step active">
                    <div>
                        2
                    </div>
                    <div class="ml-15">
                        {{ __('labels.teacher_register.identification') }}
                    </div>
                </div>
                {{-- <div class="next-step next-step-active"></div> --}}
                <img src="{{ url('/assets/img/clients/teacher/step-active.svg') }}" class="line-step"
                     alt="line-step-active">
                <div class="step active">
                    <div>
                        3
                    </div>
                    <div class="ml-17">
                        {{ __('labels.teacher_register.method_of_payment') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="step-mobile">
            @include('client.payment.process-payment-circle', ['step' => 'STEP 3', 'deg' => 360, 'title' => '振込口座情報', 'size' => 56])
        </div>
        <div class="teacher-register-info-wrapper">
            <div class="teacher-register-edit-content">
                {{-- <div class="withdrawal-application">
                    {{ __('labels.teacher_register.payment.withdrawal_application') }}
                </div> --}}
                <div class="center">
                    <form action="{{ route("client.teacher.register.setting-account.updatePayment", $user->user_id ?? null) }}"
                          method="post" class="form-disable-multiple-click">
                        @csrf
                        <div class="right-teacher-register-content">
                            <div class="title_center header-payment">
                                {{ trans('labels.teacher_register.title_payment') }}
                            </div>
                            <div class="img-bank">
                                <img src="{{asset('./assets/img/teacher-page/icon/bank.svg')}}" alt="">
                            </div>
                            <div class="teacher-register-content">
                                <div class="d-flex financial_institution">
                                    <div class="title_payment title_position">
                                        {{ trans('labels.teacher_register.payment.financial_institution_name') }}
                                    </div>
                                    <div class="input-payment input-payment__bank">
                                        <div class="input-select input-bank">
                                            <input value="{{ old("bank_name", $user->bankAccount->bank_name ?? null) }}"
                                                   name="bank_name" type="text" class="form-control"
                                                   data-convert="no-auto"
                                                   data-search="bank"
                                                   placeholder="◯◯◯銀行" autocomplete="off"
                                                   data-url= {{route('client.bank-autocomplete')}}>
                                            <img src="{{url('/assets/img/clients/auth/arow-down.svg')}}"
                                                 class="arrow-down" alt="">
                                        </div>
                                        <div class="select__options list__bank">
                                            @if(count($banks) > 0)
                                                @foreach($banks as $bank)
                                                    <div class="select__item f-w3 select-parent-item category-select bank-select">
                                                        {{$bank->name}}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @if($errors->has("bank_name"))
                                            <small class="error text-danger ml-2">
                                                {{ $errors->first("bank_name") }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex financial_institution" style="margin-bottom: 0">
                                    <div class="title_payment title_position">
                                        {{ trans('labels.teacher_register.payment.branch_name') }}
                                    </div>
                                    <div class="input-payment input-payment__branch">
                                        <div class="input-select input-branch">
                                            <input type="text" name="branch_name"
                                                   data-convert="no-auto"
                                                   data-search="branch"
                                                   value="{{ old("branch_name", $user->bankAccount->branch_name ?? null) }}"
                                                   class="form-control branch_name-input" placeholder="支店名 or 支店番号"
                                                   autocomplete="off"
                                                   data-url= {{route('client.branch-autocomplete')}}>
                                            <img src="{{url('/assets/img/clients/auth/arow-down.svg')}}"
                                                 class="arrow-down" alt="">
                                        </div>
                                        <div class="select__options list__branch">

                                        </div>
                                        @if($errors->has("branch_name"))
                                            <small class="error text-danger">
                                                　{{ $errors->first("branch_name") }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center financial_institution_type">
                                    <div class="title_payment">
                                        {{ trans('labels.teacher_register.payment.type') }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex">
                                            <label class="wrap-radio">
                                                <input checked type="radio" name="account_type" id="account_type_1"
                                                       value="1">
                                                <span class="label-title">{{ trans('labels.teacher_register.account_type.savings') }}</span>
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="note-input ml-3">※ゆうちょ銀行の場合は「通常貯金」のみ登録可能</span>
                                        </div>
                                        @if($errors->has("account_type"))
                                            <small class="error text-danger">
                                                {{ $errors->first("account_type") }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex financial_institution">
                                    <div class="title_payment title_position">
                                        {{ trans('labels.teacher_register.payment.account_number') }}
                                    </div>
                                    <div class="input-payment">
                                        <input maxlength="7"
                                               value="{{ old("account_number", $user->bankAccount->account_number ?? null) }}"
                                               name="account_number" type="text"
                                               data-convert="half-width" data-change="true"
                                               data-min-length="7"
                                               class="form-control account_number-input"
                                               style="text-transform: capitalize;"
                                               placeholder="1234567">
                                        <div class="row-input mt-2 row-input-custom">
                                            <div class="note-input ml-2">※半角数字</div>
                                            <div class="note-input ml-3 ml-3-custom">７桁未満の場合は頭に「０」を付けて入力してください。</div>
                                        </div>
                                        @if($errors->has("account_number"))
                                            <small class="error text-danger">
                                                　{{ $errors->first("account_number") }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex financial_institution">
                                    <div class="title_payment title_position">
                                        {{ trans('labels.teacher_register.payment.account_holder') }}
                                    </div>
                                    <div class="input-payment">
                                        <input name="account_name"
                                               style="text-transform: capitalize;"
                                               data-convert="full-width"
                                               data-required="space" data-change="true"
                                               value="{{ old("account_name", $user->bankAccount->account_name ?? null) }}"
                                               type="text" class="form-control" placeholder="ヤマダ　タロウ">
                                        <span class="note-input ml-2">※全角カタカナ</span>
                                        <div class="account_name-show-error error ml-2"></div>
                                        <br/>
                                        @if($errors->has("account_name"))
                                            <small class="error text-danger ml-2">
                                                {{ $errors->first("account_name") }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="confirm">
                                <a href="{{ route($isFortune == false ? 'client.teacher.register.setting-account.identification-two' : 'client.teacher.register.setting-account.nda-verify', $user->user_id ?? null) }}"
                                   class="btn fs-14 back button">
                                    {{ trans('labels.button.back_step') }}
                                </a>
                                <button class="btn fs-14 next button-confirm" type="submit">
                                    {{ trans('labels.button.register_action') }}
                                </button>
                            </div>
                            <div class="modal fade" id="option-after-bank" tabindex="-1"
                                 aria-labelledby="option-after-bank"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content option-after-bank">
                                        <div class="text-center option-after-bank__header d-flex align-items-center justify-content-center">
                                            <h5 class="f-w6" id="option-after-bank__Label">新規出品者登録が完了しました。</h5>
                                        </div>
                                        <div class="modal-body text-center option-after-bank__body">
                                            <div class="option-after-bank__body__option">
                                                <a href="{{ route('client.home')}}"
                                                   class="f-w6 option-after-bank__body__option-btn option-after-bank__body__option-btn--cancel text-nowrap mr-0"
                                                >
                                                    トップページへ
                                                </a>
                                            </div>
                                            <p class="note-payment f-w6">※本人確認には約3営業日ほどお時間を頂きます。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ mix('js/auto-bank.js') }}"></script>
    <script>
        if ({{ session('verifySuccess', 0) }}) {
            $('#option-after-bank').modal('show');
        }
    </script>
@endsection
