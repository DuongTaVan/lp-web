@extends('client.base.base')
@section('css')
    <style>
        .register-area {
            display: none;
        }

        .terms_of_service-area {
            display: block;
        }

        .register-area_list__header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            color: #2A3242;
        }

        .register-area_list__title {
            margin-left: 5px;
        }

        .register-area_list__main {
            font-weight: bold;
            font-size: 13px;
        }

        .label-filed {
            margin-right: 0;
        }

        .btn-disabled {
            pointer-events: unset;
        }

        .register-area {
            transform: scaleY(1);
            position: relative;
            z-index: 4;
            width: 100%;
            transition: ease 0.3s;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            transform-origin: top;
            border: 1px solid #DDDDDD;
            max-height: 200px;
            overflow-x: hidden;
            overflow-y: auto;
            user-select: none;
            margin-bottom: 15px;
        }

        .register-area-list__title__left {
            font-weight: normal;
            font-size: 12px;
            color: #2A3242;
        }
    </style>
@endsection
@section('header')
    <title>新規会員登録</title>
@endsection
@section('content')
    <!-- CONTENT -->
    @if (session('error') != null)
        <div id="show-toast-error" data-msg="{{ session('error') }}"></div>
    @endif
    <div class="register-less-20-wrap">
        <div class="register-less-20">
            <h1 class="f-w6 text-center">{{ __('labels.auth.register.label_register') }}</h1>
            <form action="{{ route('client.handle-register') }}" method="post" class="text-left"
                  enctype="multipart/form-data" id="register-form" autocomplete="off">
                @csrf
                @if(isset($user))
                    <input type="hidden" name="userId" value="{{ $user->user_id }}">
                    <input type="hidden" name="loginType" value="{{ $user->login_type }}">
                @endif
                <div class="form-wrap">
                    <label for=""
                           class="register-less-20__label label-filed f-w6">{{ __('labels.auth.register.email_address') }}</label>
                    <span class="register-less-20__required f-w3">※必須<span
                                class="register-less-20__required register-less-20__required--note">（非公開）</span></span>
                    <input type="text" name="email" onblur="blurInput(this)" class="email-input wrap-box"
                           value="{{ old('email') ?? (isset($user) ? $user->email : "") }}" autocomplete='off'/>
                    <span class="message-error">
                    @error('email')
                        {{ $message }}
                        @enderror
                </span>
                </div>
                <div class="form-wrap">
                    <label for=""
                           class="register-less-20__label f-w6 label-filed">{{ __('labels.auth.register.nick_name') }}</label>
                    <span class="register-less-20__required f-w3">※必須</span>
                    <input type="text" name="nickname" class="wrap-box"
                           value="{{ old('nickname') ?? (isset($user) ? $user->nickname : "") }}" autocomplete='off'/>
                    <small>※３文字以上20文字以内、記号可能</small>
                    <span class="message-error">
                    @error('nickname')
                        {{ $message }}
                        @enderror
                </span>
                </div>
                @if(!isset($social)
                    && !(isset($user) && $user->login_type != \App\Enums\DBConstant::LOGIN_TYPE_EMAIL)
                    //&& !(session('user') && session('user')->loginType != \App\Enums\DBConstant::LOGIN_TYPE_EMAIL)
                    && request()->get('login_type') !== 'LINE'
                    && request()->get('login_type') !== 'FACEBOOK'
                    && request()->get('login_type') !== 'GOOGLE'
                )
                    <input type="hidden" name="login_type" value="{{ \App\Enums\DBConstant::LOGIN_TYPE_EMAIL }}">
                    <div class="form-wrap">
                        <label for=""
                               class="register-less-20__label f-w6">{{ __('labels.auth.register.password') }}</label>
                        <span class="register-less-20__required f-w3">※必須</span>
                        <input type="password" name="password_current" class="wrap-box"
                               value="{{ old('password_current') }}" autocomplete='off'/>
                        <small>※8~20文字の英数字で設定してください</small>
                        <span class="message-error">
                        @error('password_current')
                            {{ $message }}
                            @enderror
                    </span>
                    </div>
                    <div class="form-wrap">
                        <label for=""
                               class="register-less-20__label f-w6">{{ __('labels.auth.register.re-password') }}</label>
                        <span class="register-less-20__required f-w3">※必須</span>
                        <input type="password" name="confirm_password" class="wrap-box"
                               value="{{ old('confirm_password') }}" autocomplete='off'/>
                        <span class="message-error">
                        @error('confirm_password')
                            {{ $message }}
                            @enderror
                    </span>
                    </div>
                @endif

                <!-- BIRTHDAY -->
                <div class="form-wrap">
                    <label for="" class="register-less-20__label f-w6">{{ __('labels.auth.register.birthday') }}</label>
                    <span class="register-less-20__required f-w3">※必須</span>
                    <div class="register-less-20__birthday d-flex">
                        <div class=" register-less-20__birthday__year-wrap d-flex justify-content-center align-items-center"
                        >
                            <div class="select">
                                <input type="text" class="select__value f-w3 register-less-20__birthday__year__value"
                                       readonly
                                       value="{{ old('year') ?? (isset($user) ? formatTime($user->date_of_birth, 'Y') : "2000") }}"
                                       name="year">
                                <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" class="arrow-down"
                                     alt="">
                                <div class="select__options">
                                    @for($i = \App\Enums\Constant::TIME_POINT; $i <= now()->format('Y'); $i ++)
                                        @if ($i <= (int)now()->format('Y') - 18)
                                            <div class="select__item select__item__year f-w3">{{ $i }}</div>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <span class="register-less-20__birthday__label">年</span>
                        </div>
                        <div class="register-less-20__birthday__month d-flex justify-content-between align-items-center">
                            <div class="select">
                                <input type="text" class="select__value f-w3 register-less-20__birthday__month__value"
                                       readonly
                                       value="{{ old('month') ?? (isset($user) ? formatTime($user->date_of_birth, 'm') : "01") }}"
                                       name="month">
                                <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" class="arrow-down"
                                     alt="">
                                <div class="select__options select__options__month">
                                    @for($i = 1; $i <= \App\Enums\Constant::MONTH_POINT; $i ++)
                                        <div class="select__item select__item__month f-w3">{{ $i < 10 ? 0 . $i : $i }}</div>
                                    @endfor
                                </div>
                            </div>
                            <span class="register-less-20__birthday__label">月</span>
                        </div>
                        <div class="register-less-20__birthday__day d-flex justify-content-between align-items-center">
                            <div class="select">
                                <input type="text" class="select__value f-w3 register-less-20__birthday__day__value"
                                       readonly
                                       value="{{ old('day') ?? (isset($user) ? formatTime($user->date_of_birth, 'd') : "01") }}"
                                       name="day">
                                <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" class="arrow-down"
                                     alt="">
                                <div class="select__options select__options__day">
                                    @for($i = 1; $i <= \App\Enums\Constant::DAY_POINT; $i ++)
                                        <div class="select__item f-w3">{{ $i < 10 ? 0 . $i : $i }}</div>
                                    @endfor
                                </div>
                            </div>
                            <span class="register-less-20__birthday__label">日</span>
                        </div>
                    </div>
                    <span class="message-error">
                    @error('birthday')
                        {{ $message }}
                        @enderror
                        <?php $customerErrors = $errors->toArray() ?>
                        @if(isset($customerErrors['year']) || isset($customerErrors['month']) || isset($customerErrors['day']))
                            生年月日必ず指定してください。
                        @endif
                </span>
                </div>
                <div class="wrap-confirm form-wrap">
                    <div class="register-less-20__confirm d-flex align-items-center">
                        <input type="checkbox" class="register-less-20__confirm__checkbox d-none" checked disabled
                               name=""
                               id="agree">
                        <input type="hidden" id="hidden-checkbox" name="hidden-checkbox"
                               value="{{ old('hidden-checkbox') ?? 0 }}">
                        <img class="register-not-checked cursor-pointer" style="cursor: pointer;"
                             src="{{ url('/assets/img/clients/auth/NotChecked.png') }}" alt="">
                        <img class="register-checked cursor-pointer" style="cursor: pointer;"
                             src="{{ url('/assets/img/clients/auth/Checked.png') }}" alt="" width="16px">
                        <span class="f-w3"
                        >私はLappiの利用について、親権者の同意を得ています。</span
                        >
                    </div>
                    <span class="message-error error-checked">
                    </span>
                </div>
                <!-- GENDER -->
                <div class="form-wrap">
                    <label for="" class="register-less-20__label f-w6">{{ __('labels.auth.register.gender') }}</label>
                    <span class="register-less-20__required f-w3">※必須</span>
                    {{-- <div class="register-less-20__gender d-flex align-items-center">
                        @php
                            $sex = old('sex') ?? (isset($user) ? $user->sex : "");
                        @endphp
                        <p class="register-less-20__gender__item">
                            <input type="radio" value="1" id="test1" name="sex" checked
                                   @if((int)$sex == \App\Enums\DBConstant::SEX_MALE) checked @endif>
                            <label class="f-w3" for="test1">男性</label>
                        </p>
                        <p class="register-less-20__gender__item">
                            <input type="radio" value="2" id="test2" name="sex"
                                   @if((int)$sex == \App\Enums\DBConstant::SEX_FEMALE) checked @endif>
                            <label class="f-w3" for="test2">女性</label>
                        </p>
                        <p class="register-less-20__gender__item">
                            <input type="radio" value="9" id="test3" name="sex"
                                   @if((int)$sex === \App\Enums\DBConstant::SEX_NOT_APPLICABLE) checked @endif>
                            <label class="f-w3" for="test3">その他</label>
                        </p>
                        <p class="register-less-20__gender__item">
                            <input type="radio" value="0" id="test6" name="sex"
                                   @if((int)$sex === \App\Enums\DBConstant::SEX_OTHER && $sex !== "") checked @endif>
                            <label class="f-w3" for="test6">無回答</label>
                        </p>
                    </div> --}}
                    <div class="d-flex">
                        @php
                            $sex = old('sex') ?? (isset($user) ? $user->sex : "");
                        @endphp
                        <label class="wrap-radio">
                            <input @if((int)$sex == \App\Enums\DBConstant::SEX_MALE) checked @endif checked type="radio"
                                   name="sex" id="test1" value="1">
                            <span class="label-title">@lang('labels.profile-email.male')</span>
                            <span class="checkmark"></span>
                        </label>
                        <label class="wrap-radio ml-sex">
                            <input @if((int)$sex == \App\Enums\DBConstant::SEX_FEMALE) checked @endif type="radio"
                                   name="sex" id="test2" value="2">
                            <span class="label-title">@lang('labels.profile-email.female')</span>
                            <span class="checkmark"></span>
                        </label>
                        <label class="wrap-radio ml-sex">
                            <input @if((int)$sex === \App\Enums\DBConstant::SEX_NOT_APPLICABLE) checked
                                   @endif type="radio" name="sex" id="test3" value="9">
                            <span class="label-title">@lang('labels.profile-email.other')</span>
                            <span class="checkmark"></span>
                        </label>
                        <label class="wrap-radio ml-sex">
                            <input @if((int)$sex === \App\Enums\DBConstant::SEX_OTHER && $sex !== "") checked
                                   @endif type="radio" name="sex" id="test4" value="0">
                            <span class="label-title">@lang('labels.profile-email.no_answer')</span>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <span class="message-error"></span>
                </div>
                <!-- PURPOSE OF USE -->
                <div class="form-wrap">
                    <label for=""
                           class="register-less-20__label f-w6 mt-15">{{ __('labels.auth.register.purpose_of_use') }}</label>
                    <span class="register-less-20__required f-w3">※必須</span>
                    {{-- <div class="register-less-20__gender d-flex align-items-center">
                        @php
                            $userType = old('user_type') ?? (isset($user) ? $user->user_type : "");
                        @endphp
                        <p class="register-less-20__gender__item">
                            <input type="radio" value="1" id="test4" name="user_type" checked
                                   @if ($userType == \App\Enums\DBConstant::USER_TYPE_STUDENT) checked @endif>
                            <label class="f-w3" for="test4">購入者</label>
                        </p>
                        <p class="register-less-20__gender__item ml-74">
                            <input type="radio" value="2" id="test5" name="user_type"
                                   @if ($userType == \App\Enums\DBConstant::USER_TYPE_TEACHER) checked @endif>
                            <label class="f-w3" for="test5">出品者＋購入者</label>
                        </p>
                    </div> --}}
                    <div class="d-flex">
                        @php
                            $userType = old('user_type') ?? (isset($user) ? $user->user_type : "");
                        @endphp
                        <label class="wrap-radio">
                            <input @if ($userType == \App\Enums\DBConstant::USER_TYPE_STUDENT) checked @endif checked
                                   type="radio" name="user_type" id="test4" value="1">
                            <span class="label-title">購入者</span>
                            <span class="checkmark"></span>
                        </label>
                        <label class="wrap-radio ml-user-type">
                            <input @if ($userType == \App\Enums\DBConstant::USER_TYPE_TEACHER) checked
                                   @endif type="radio" name="user_type" id="test5" value="2">
                            <span class="label-title">出品者＋購入者</span>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <span class="message-error"></span>
                </div>
                <!-- IMAGE -->
                <div class="form-wrap">
                    <label for="" class="register-less-20__label f-w6">{{ __('labels.auth.register.avatar') }}</label>
                    <div class="register-less-20__avatar">
                        <div class="d-flex align-items-center">
                            <div class="upload-btn-wrapper">
                                <label for='input-file' class="f-w3">
                                    ファイルを選択
                                </label>
                                <input id='input-file' type='file' accept=".jpg,.png,.gif"
                                       name="image"/>
                            </div>
                            <span class="f-w3 ml-11 input-file__note">最大５MBまで（GIF、JPG、PNG）</span>
                        </div>
                        <span class="register-less-20__avatar__note">マイページから変更可能</span>
                    </div>
                    <span class="message-error">
                    @error('image')
                        {{ $message }}
                        @enderror
                </span>
                </div>
                <p class="f-w3 register-less-20__note text-center"><a class="terms_of_service"
                                                                      href="{{ route('client.terms-of-service') }}">利用規約</a>に同意の上ご登録下さい。
                </p>
                <div class="register-area">
                    <div id="register-area_list">
                        <div class="register-area_all">
                            <div class="register-area_list__header">利用規約</div>
                            <div class="register-area_list__title">
                                <div class="register-area_list__main">第１条（目的及び適用）</div>
                                <div class="register-area-list__title__left">
                                    1.
                                    この利用規約（以下、「本規約」といいます）は、○○（以下「当社」といいます）がこのサイト上で提供するサービス（以下、「本サービス」といいます）の利用条件を定めるものです。本サービスご利用される出品者及び利用者（以下、総称して「ユーザー」といいます）は、本規約の内容に従って、本サービスを利用頂くものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.
                                    本規約は、当社及びすべてのユーザー間の本サービスの利用に関わる一切の関係に適用されるものとします。また、当社が本サイトに掲載の上、提供する内容は本規約の一部として構成されます。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第２条（本規約への同意）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    ユーザーは、本規約の内容を理解し、これに同意の上、本サイトを利用するものとします。なお、本サイトを利用した場合、ユーザーは、本規約の内容を理解し、これに同意の上、本サイトを利用したとみなすものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第３条（登録）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.本サービスの利用を希望する者（以下、「登録希望者」といいます）は、本規約の全条項を遵守することに同意し、かつ当社の定める一定の情報（以下、「登録情報」といいます）を当社の定める方法により当社に提供することにより、本サービスの利用の登録を申請することができます。なお、出品者は、本サービスを利用するにあたり当社が別途定める出品者ガイドラインの各規定を遵守することにも同意をしなければいけないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.登録の申請は、必ず本サービスを利用する本人が行わなければならず、当社が事前に承諾した場合を除き、代理人による登録申請は認められません。また、登録希望者は、登録の申請にあたり、真実、正確かつ最新の情報を当社に提供しなければなりません。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.当社は、第１項に基づき登録を申請した者が以下の各号のいずれかの事由に該当する場合は、当該登録を拒否又は取消しをすることができ、当社はこれについて一切の責任を負わないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    (1)提供された登録情報の全部または一部につき虚偽、誤記、記載漏れがあった場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (2)過去に本規約に違反したことのある者から登録申請を受けた場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (3)未成年者である場合に、法定代理人の包括的な同意を得ていない場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (4)反社会的勢力等（暴力団、暴力団員、右翼団体、反社会的勢力、その他これらに準ずる者を意味する。以下同様とします。）である、又は資金提供そのほかを通じて反社会的勢力等の維持、運営若しくは経営に協力若しくは関与する等反社会的勢力等と何らかの交流若しくは関与を行っていると当社が判断した場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (5)その他当社が登録を適当ではないと判断した場合
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第４条（アカウントの管理）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.ユーザーは、利用に際して登録した情報（以下、「登録情報」といいます。電話番号やパスワード等を含みます）について、自己の責任の下、任意に登録、管理するものとします。ユーザーは、これを第三者に利用させ、または貸与、譲渡、名義変更、売買などをしてはならないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.当社は、登録情報によって本サービスの利用があった場合、利用登録をおこなった本人が利用したものと扱うことができ、当該利用によって生じた結果ならびにそれに伴う一切の責任については、利用登録を行ったユーザー本人に帰属するものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.ユーザーは、登録情報の不正使用によって当社または第三者に損害が生じた場合、当社および第三者に対して、当該損害を賠償するものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    4.登録情報の管理は、ユーザーが自己の責任の下で行うものとし、登録情報が不正確ま
                                    たは虚偽であったためにユーザーが被った一切の不利益および損害に関して、当社は責任を負わないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    5.登録情報が盗用されまたは第三者に利用されていることが判明した場合、ユーザーは直ちにその旨を当社に通知するとともに、当社からの指示に従うものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第５条（購入手続及びサービス提供契約の成立）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.購入者は、当社サービスにおいてサービスの購入を希望する場合、当社所定のフォームより購入手続きを行うものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.サービス提供契約は、購入者が前項の購入手続きを完了した時点で、出品者と当該購入者との間で成立します。なお、当社はサービス提供契約の当事者となるものではなく、サービス提供契約につき、出品者又は購入者のいずれの立場に関す責任も負いません。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第６条（外部サービスとの連携）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.ユーザーは、外部サービスとの連携機能を利用してログインする際に、当社がデータにアクセスすることについての許可を求められることがあり、かかる内容を確認の上、許可した場合に限り、当該連携機能を利用することができるものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.外部サービスのユーザーIDの登録・利用を含むすべての外部サービスの利用については、ユーザーは、外部サービスの運営者が規定する各規約の定めに従うものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.外部サービスを利用する場合、ユーザーは、自己の責任において当該サービスを利用するものとし、当社は、当該サービスを利用したことにより生じた損害、当該サービスの運営者・利用者等との間に生じたトラブルその他の当該サービスに関連する一切の事項について何らの責任も負わないものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第７条（コイン）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.利用者は、本サイトに別途掲示する金額をお支払いいただくことで、コインを購入することができます。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.利用者は、本サービス内のライブ配信時において、投げ銭又は挙手の質問をする目的にのみコインを使用することができます。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.利用者は、当社が特に定めた場合を除き、コイン及びコンテンツの使用権を他の利用者その他第三者に使用させ、又は貸与、譲渡、売買、質入等をすることができないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    4.利用者は、当社が特に認めた場合を除き、コインの払い戻し、又はコインと当社の指定するコンテンツ以外のコンテンツとの交換を求めることはできないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    5.コインの具体的な使用期限については個々のコイン発行の際に当社が決定するものとします。なお、有償で発行するコインの使用期限についてはいかなる場合でも１８０日を超えることはないものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第８条（収益分配）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.当社は、出品者より出金の申請があった場合、当社所定の手数料及び出金手数料を控除した残額を出品者に支払うものとします。なお、収益の支払い方法等は当社が自由に定めることができ、かつ、当社は適宜自由に変更することができるものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.当社は、出品者が実施するライブ配信の内容または当該ライブ配信を視聴する利用者の行動等に基づき、当社の定める方法により出品者の当該ライブ配信を評価し、その評価に基づき当社が定める金員（以下、「分配金」といいます）を、当社が本サービスにおいて得た収益から収益分配として支払うものとします。なお、配信者が実施するライブ配信の評価方法、分配金の支払方法等は当社が自由に定めることができ、かつ当社が自由に変更できるものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第９条（利用料・手数料など）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.出品者が当社に対して支払う手数料は、別途当社と出品者との間で合意した金額とします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.出品者は、当社に対し、利用者より支払われる料金を代理受領する権限を付与するものとし、利用者から直接料金を受領してはならないものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１０条（ポイント）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    (1)ユーザーは、本サービスにおけるレビューを投稿することにより、別途当社が定めるポイントを獲得することができるものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    (2)ユーザーは、本サービスの決済としてポイントを使用することができます。
                                </div>
                                <div class="register-area-list__title__left">
                                    (3)ポイントの具体的な使用期限については個々のコイン発行の際に当社が決定するものとします。なお、ポイントの使用期限についてはいかなる場合でも１８０日を超えることはないものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１１条（知的財産権）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    本サービスに関する一切の情報についての著作権及びその他の知的財産権（ただし、ユーザーが本サイト等を通じて、第三者の権利を侵害することなく送信したデータを除きます）はすべて当社又は当社にその利用を許諾した権利者に帰属します。ユーザーは、複製、譲渡、貸与、翻訳、改変、転載、公衆への送信（公衆への送信を可能とすることを含みます）、転送、配布、出版、営業のための使用等をしてはならないものとします。
                                </div>

                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１２条（禁止事項）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    ユーザーは、本サービスの利用にあたり、以下の行為を行わないものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    (1)本サービスの円滑な提供を妨げる行為又は妨げる恐れのある行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (2)当社又は第三者の知的財産権若しくは他の権利・利益を侵害する行為又は侵害する恐れのある行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (3)法令若しくは公序良俗に違反する行為又は違反する恐れのある行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (4)犯罪行為に関連する行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (5)面識のない異性との出会いや交際及びその媒介を目的とする行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (6)本サービスによって得られた情報を商業的に利用する行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (7)当社のサービスの運営を妨害する恐れのある行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (8)不正な目的をもって本サービスを利用する行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (9)当社又は第三者の名誉・信用を毀損する行為又は毀損する恐れのある行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (10)当社又は第三者を誹謗、中傷する行為又は誹謗、中傷、攻撃、脅迫、扇動、罵倒する恐れのある行為
                                </div>
                                <div class="register-area-list__title__left">
                                    (11)その他、当社が不適切と判断する行為
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１３条（情報の保存）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    当社は、ユーザーが送受信したメッセージその他の情報を運営上一定期間保存していた場合であっても、かかる情報を保存する義務を負うものではなく、当社はいつでもこれらの情報を削除できるものとします。なお、当社は本条に基づき当社が行った措置に基づきユーザーに生じた損害について一切の責任を負いません。
                                </div>

                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１４条（本サービスの提供の停止等）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.当社は、以下のいずれかの事由があると判断した場合、ユーザーに事前に通知することなく、本サービスの全部または一部の提供を停止又は中断することがあります。
                                </div>
                                <div class="register-area-list__title__left">
                                    (1).本サービスに係るコンピュータシステムの保守点検又は更新を行う場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (2).コンピューター又は通信回線等が事故により停止した場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (3).地震、落雷、火災、風水害、停電、天災地変などの不可抗力により本サービスの提供が困難となった場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (4).その他、当社が本サービスの提供が困難と判断した場合
                                </div>
                                <div class="register-area-list__title__left">
                                    2.当社は、本サービスの提供の停止又は中断により、ユーザー又は第三者が被ったいかなる不利益または損害について、理由を問わず一切の責任を負わないものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１５条（利用制限および登録抹消）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.当社は、以下の場合には、事前の通知なく、当該ユーザーに対して、本サービスの全部もしくは一部の利用を制限し、またはユーザーとしての登録を抹消することができるものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    (1)本規約のいずれかの条項、又は関連法令に違反した場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (2)登録事項等に虚偽の事実があることが判明した場合
                                </div>
                                <div class="register-area-list__title__left">
                                    (3)その他、当社が本サービスの利用を適当でないと判断した場合
                                </div>
                                <div class="register-area-list__title__left">
                                    2.当社は、本条に基づき当社が行った行為によりユーザーに生じた損害について、一切の責任を負いません。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１６条（本規約の変更)</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.当社は以下の場合に、当社の裁量により、本規約を変更することができます。
                                </div>
                                <div class="register-area-list__title__left">
                                    (1)本規約の変更が、ユーザーの一般の利益に適合するとき
                                </div>
                                <div class="register-area-list__title__left">
                                    (2)本規約の変更が、契約した目的に反せず、かつ、変更の必要性、変更後の内容の相当性、変更の内容その他の変更に係る事情に照らして合理的なものであるとき
                                </div>
                                <div class="register-area-list__title__left">
                                    2.当社は前項による本規約の変更にあたり、事前に利用規約を変更する旨及び変更後の利用規約の内容とその効力発生日を本サービス上にて掲示し、またはユーザーに電子メールで通知するものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.変更後の利用規約の効力発生日以降にユーザーが本サービスを利用したときは、ユーザーは、利用規約の変更に同意したものとみなします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１７条（規約違反があった場合の取り扱い）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.当社は、ユーザーが本サービスの不正利用など利用規約等の何らの条項に違反した場合、本サービスの使用差止め、サービスの利用停止（アカウント停止）、強制退会、損害賠償請求（合理的な弁護士費用を含む）等の措置を取ることができます。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.ユーザーによる不正使用を含む利用規約等の違反に関連し、生起する第三者との法的請求や責任については、当社は一切責任を負わず、利用規約等に違反したユーザーは、自己の責任においてこれを処理し、当社に一切の迷惑や損害を与えないことを保証します。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.ユーザーが利用規約等に違反した場合で当社が必要と判断したとき、当社は、該当するユーザーの連絡先その他、当社が当該ユーザーに関して有する情報を、当該違反に関連する第三者に開示できるものとします。
                                </div>
                                <div class="register-area-list__title__left">
                                    4.利用規約の違反等の報告が当社にあった場合、当社は、当該違反の是正について合理的な範囲での最善の措置を講ずるよう努め、当社の裁量で当社が行う対応を決定することができるものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１８条（保証の否認及び免責）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.当社は、本サービスに事実上又は法律上の瑕疵（安全性、信頼性、正確性、完全性、有効性、特定の目的への適合性、セキュリティなどに関する欠陥、エラーやバグ、権利侵害などを含みます）がないことを明示的にも黙示的にも保証しておりません。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.当社は、本サービスに起因してユーザーに生じたあらゆる損害について一切の責任を負いません。ただし、本サービスに関する当社とユーザーとの間の契約（本規約を含みます）が消費者契約法に定める消費者契約となる場合、この免責規定は適用されません。
                                </div>
                                <div class="register-area-list__title__left">
                                    3.前項ただし書に定める場合であっても、当社は、当社の過失（重過失を除きます）による債務不履行または不法行為によりユーザーに生じた損害のうち特別な事情から生じた損害（当社またはユーザーが損害発生につき予見し、または予見しえた場合を含みます）について一切の責任を負いません。
                                </div>
                                <div class="register-area-list__title__left">
                                    4.当社は、本サービスに関して、ユーザーと他のユーザー又は第三者との間において生じた取引、連絡又は紛争等について一切の責任を負いません。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第１９条（秘密保持）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.本規約において「秘密保持」とは、利用契約又は本サービスに関連して、ユーザーが当社より書面、口頭若しくは記録媒体等により提供若しくは開示されたか、又は知りえた、当社の技術、営業、業務、財務、組織、その他の事項に関する全ての情報を意味します。ただし、
                                </div>
                                <div class="register-area-list__title__left">
                                    (1)当社から提供若しくは開示がなされたとき又は知得したときに、既に一般に公知となっていた、又は既に知得していたもの
                                </div>
                                <div class="register-area-list__title__left">
                                    (2)当社から提供若しくは開示又は知得した後、自己の責めに帰せざる事由により刊行物その他により公知となったもの、
                                </div>
                                <div class="register-area-list__title__left">
                                    (3)提供又は開示の権限のある第三者から秘密保持義務を負わされることなく適法に取得したもの、
                                </div>
                                <div class="register-area-list__title__left">
                                    (4)秘密情報によることなく単独で開発したもの、
                                </div>
                                <div class="register-area-list__title__left">
                                    (5)当社から秘密保持の必要なき旨書面で確認されたものについては、秘密情報から除外するものとします。
                                </div>
                            </div>
                        </div>

                        <div class="register-area_all">
                            <div class="register-area_list__main">第２０条（分離可能性）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    本規約のいずれかの条項又はその一部が、消費者契約法その他の法令等により無効又は執行不能と判断された場合であっても、本規約の残りの規定及び一部が無効又は執行不能と判断された規定の残りの部分は、継続して完全に効力を有するものとします。
                                </div>
                            </div>
                        </div>
                        <div class="register-area_all">
                            <div class="register-area_list__main">第２１条（準拠法および管轄裁判所）</div>
                            <div class="register-area_list__title">
                                <div class="register-area-list__title__left">
                                    1.本規約の解釈に当たっては、日本法を準拠法とします。
                                </div>
                                <div class="register-area-list__title__left">
                                    2.本サービスに関して紛争が生じた場合には、当社の所在地を管轄する裁判所を専属的合意管轄とします。
                                </div>
                            </div>
                        </div>
                        <div class="register-area_list__main">
                            ２０２２年３月１日制定
                        </div>

                    </div>
                </div>
                <button type="submit" class="f-w6 register-less-20__agree">利用規約に同意して登録</button>
            </form>
        </div>
    </div>
@endsection
<script>
    function blurInput(e) {
        let valueTrim = e.value.trim().replace(/\s+/g, '');
        $(e).val(valueTrim);
        e.setAttribute("value", valueTrim);
    }
</script>
@section('script')
    <script>
        let uploadButton = document.getElementById("input-file");
        let inputFileNote = document.querySelector(".input-file__note");
        uploadButton.onchange = () => {
            const [file] = uploadButton.files
            if (file) {
                inputFileNote.innerHTML = file.name;
            }
        }
        console.log(12222)
        $('.terms_of_service').click(function (e) {
            e.preventDefault();
            $('.register-area').toggleClass('terms_of_service-area')
        })
    </script>
    <script src="{{ mix('js/clients/modules/register.js') }}"></script>
@endsection

