<style>
    .btn-disabled {
        pointer-events: unset !important;
    }

    #header .header__left__search__icon-search {
        top: 8.5px !important;
    }

    #search-form::placeholder {
        font-style: normal !important;
        font-weight: 300 !important;
        font-size: 12px !important;
        line-height: 18px !important;
        color: rgba(78, 87, 104, 0.38) !important;
    }

    .identification-images {
        display: flex;
        justify-content: space-between;
    }

    .identification-images {
        display: flex;
        justify-content: space-between;
    }

    .identification-images.one-image {
        justify-content: center !important;
    }

    .setting-info-wrapper .setting-info-content .content-item .image-container {
        width: 100%;
        max-width: 263px !important;;
    }

    .setting-info-wrapper .setting-info-content .content-item .image-container .img-responsive {
        width: 263px !important;
        height: 220px;
        border-radius: 5px;
    }

    .setting-info-wrapper .setting-info-content .content-item .image-container .img-responsive1 {
        width: 263px !important;
        height: 220px;
        border-radius: 5px;
    }

    .setting-info-wrapper .setting-info-content .content-item .image-container .image-button1 {
        width: 64px;
        height: 64px;
        background-color: #FFFFFF;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        border-radius: 8px;
        cursor: pointer;
    }

    .setting-info-wrapper .setting-info-content .content-item .image-container .file1 {
        display: none;
    }

    .setting-info-wrapper .setting-info-content .content-item .image-container .remove-item1 {
        position: absolute;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        -ms-flex-align: center;
        align-items: center;
        width: 18px;
        height: 18px;
        background-color: #4E5768;
        border-radius: 50%;
        top: 5px;
        right: 5px;
        cursor: pointer;
    }

    .hidden {
        display: none !important;
    }

    .setting-info-wrapper .setting-info-content .content-item .note-verify__list {
        margin-bottom: 12px !important;
    }

    @media only screen and (max-width: 767px) {
        .identification-images {
            display: block;
        }

        .setting-info-wrapper .setting-info-content .content-item .image-container .img-responsive {
            width: 479px !important;
            height: 220px;
            border-radius: 5px;
        }

        .setting-info-wrapper .setting-info-content .content-item .image-container .img-responsive1 {
            max-width: 100%;
            width: 479px !important;
            height: 220px;
            border-radius: 5px;
        }

        .setting-info-wrapper .setting-info-content .content-item .image-container {
            width: 100%;
            max-width: 479px !important;
        }

        .setting-info-wrapper .setting-info-content .content-item .image-container1 {
            width: 100%;
            max-width: 479px !important;
        }

        .setting-info-wrapper .setting-info-content .content-item .image-container-two {
            margin-top: 10px;
        }
    }

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

    .mw-82 {
        max-width: 82px;
    }

    .teacher-register-wrapper .teacher-register-nda .content .confirm-nda {
        display: unset !important;
    }

    .teacher-register-wrapper .teacher-register-nda .content .confirm-nda:first-child {
        display: unset !important;
        margin-right: 10px;
        color: #2A3242;
        border: 1px solid #4E576833;
        background-color: #FFFFFF;
        width: 150px;
        height: 41px;
    }

    .confirm-all-nda {
        text-align: center;
    }

    @media only screen and (max-width: 414px) {
        .teacher-register-wrapper .teacher-register-nda .content .confirm-nda:first-child {
            width: unset;
            height: unset;
        }
    }
</style>
@extends('client.base.base')
@section('content')
    @php
        $userId = $user->user_id ?? null;
    @endphp
    <div class="teacher-register-wrapper">
        <div class="step-wrapper d-flex justify-content-center align-items-center">
            <div class="step step-1 active">
                <div>
                    1
                </div>
                <div class="ml-11">
                    {{ __('labels.teacher_register.personal_information') }}
                </div>
            </div>
            <img src="{{ url('/assets/img/clients/teacher/step-not-active.svg') }}" class="line-step line-step-2"
                 alt="line-step-not-active">
            <div class="step step-2 not-active">
                <div>
                    2
                </div>
                <div class="ml-15">
                    {{ __('labels.teacher_register.identification') }}
                </div>
            </div>
            <img src="{{ url('/assets/img/clients/teacher/step-not-active.svg') }}" class="line-step line-step-4"
                 alt="line-step-not-active">
            <div class="step step-4 not-active">
                <div>
                    3
                </div>
                <div class="ml-17">
                    {{ __('labels.teacher_register.method_of_payment') }}
                </div>
            </div>
            <img src="{{ url('/assets/img/clients/teacher/step-not-active.svg') }}" class="line-step line-step-5"
                 alt="line-step-not-active" style="display: none">
            <div class="step step-5 not-active" style="display: none">
                <div>
                    4
                </div>
                <div class="ml-17">
                    {{ __('labels.teacher_register.method_of_payment') }}
                </div>
            </div>
        </div>
        <div class="step-mobile">
            @include('client.payment.process-payment-circle', ['step' => 'STEP 1', 'deg' => 120, 'title' => '個人情報', 'size' => 56])
        </div>
        <div class="setting-info-wrapper">
            <div class="setting-info-content d-flex">
                <form data-route="{{ route('client.teacher.register.update') }}" id="teacher-register" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="1">
                    <div id="step_1">
                        <div class="title_center text-center f-w6">
                            {{ trans('labels.teacher_register.new_seller_registration') }}
                        </div>
                        <div class="input-full-name-1">
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.full_name') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <div class="content-item__input d-flex">
                                    <div class="surname">
                                        <input type="text" value="{{ old("last_name_kanji", $user->last_name_kanji) }}"
                                               name="last_name_kanji" placeholder="姓"
                                               class="form-control input--mobile input-surname content-item__input-focus">
                                        <small class="last_name_kanji-error error text-danger"></small>
                                    </div>
                                    <div class="given-name">
                                        <input type="text"
                                               value="{{ old("first_name_kanji", $user->first_name_kanji) }}"
                                               name="first_name_kanji" placeholder="名"
                                               class="form-control input--mobile input-given-name content-item__input-focus">
                                        <small class="first_name_kanji-error text-danger"></small>
                                    </div>
                                </div>
                                <div class="note-address">※本名またはビジネスネームで登録して下さい。</div>
                            </div>
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.furigana') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <div class="content-item__input d-flex">
                                    <div class="surname">
                                        <input type="text" value="{{ old("last_name_kana", $user->last_name_kana) }}"
                                               name="last_name_kana" placeholder="例）サトウ"
                                               class="form-control input--mobile input-given-name content-item__input-focus content-item__input-focus">
                                        <small class="last_name_kana-error text-danger"></small>
                                    </div>
                                    <div class="given-name">
                                        <input type="text" value="{{ old("first_name_kana", $user->first_name_kana) }}"
                                               name="first_name_kana" placeholder="ハナコ"
                                               class="form-control input--mobile input-surname content-item__input-focus content-item__input-focus">
                                        <small class="first_name_kana-error text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.public_display') }}
                            </label>
                            <span class="content-item__required">※選択必須</span>
                            <div class="d-flex">
                                <label class="wrap-radio">
                                    <input @if(old("name_use", $user->name_use) == 2) checked @endif type="radio"
                                           name="name_use" id="publishByName" value="2">
                                    <span class="label-title">お名前で公開</span>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="wrap-radio ml-40">
                                    <input @if(old("name_use", $user->name_use) == 1) checked @endif type="radio"
                                           name="name_use" id="publishByNickname" value="1">
                                    <span class="label-title">ニックネームで公開</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="note-address">購入者アカウントはニックネームでしか公開されません。
                            </div>
                            <small class="name_use-error text-danger"></small>
                        </div>
                        {{-- IMAGE --}}
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.seller_profile_image') }}
                            </label>
                            <span class="content-item__required">※必須</span>
                            <div class="d-flex align-items-center">
                                <label for="files"
                                       class="content-item__select-file"><span>{{ trans('labels.teacher_register.select_files') }}</span></label>
                                <input id="files" name="profile_image" style="display:none;" type="file"
                                       accept="image/png, image/gif, image/jpeg">
                                @php
                                    $dbImage = '';
                                @endphp
                                @if(session()->has('profile_image_' . auth('client')->id()))
                                    @php
                                        $sessionImage = session()->get('profile_image_' . auth('client')->id());
                                    @endphp
                                    <input type="hidden" name="profile_image_old"
                                           value="{{ json_encode($sessionImage) }}">
                                    <span
                                            class="content-item__note-img">{{ $sessionImage['originalName'] ?? '' }}</span>
                                @elseif ($dbImage)
                                    <input type="hidden" name="profile_image_old"
                                           value="{{ $user->getOriginal('profile_image') }}">
                                    <span class="content-item__note-img">{{ $dbImage }}</span>
                                @else
                                    <span class="content-item__note-img">最大５MBまで（GIF、JPG、PNG）</span>
                                @endif
                            </div>
                            <div class="note-address ml-7">マイページから変更可能</div>
                            <small class="profile_image-error text-danger"></small>
                        </div>
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.catch_copy') }}
                            </label>
                            <span class="content-item__required">※必須</span>
                            <input value="{{ old('catchphrase') ?? $user->catchphrase }}" type="text" name="catchphrase"
                                   class="form-control input--mobile  content-item__input-focus content-item__input-focus"
                                   autocomplete="off">
                            <div class="note-address">マイページから変更可能</div>
                            <small class="catchphrase-error text-danger"></small>
                        </div>
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.self_introduction') }}
                            </label>
                            <span class="content-item__required">※必須</span>
                            <textarea id="introduction" name="biography" maxlength="10000" rows="10" cols="60"
                                      class="form-control content-item__input-focus content-item__input-focus--big">{{ old('biography') ?? $user->biography }}</textarea>
                            <div class="note-address">マイページから変更可能</div>
                            <small class="biography-error text-danger"></small>
                        </div>
                    </div>

                    <div id="step_2" class="teacher-register-info-wrapper">
                        <div class="teacher-register-edit-content">
                            <div class="center">
                                <div class="title_center text-center f-w6">
                                    {{ trans('labels.teacher_register.title_identification') }}
                                </div>
                                <div class="teacher-register-content">
                                    <div class="title-identify">
                                        {{ trans('labels.teacher_register.identifications.usage_details') }}
                                        <span
                                                class="element-require">{{ trans('labels.teacher_register.identifications.required') }}</span>
                                        <span class="element-require" style="margin-left: 0">１つだけ選択してください</span>
                                    </div>
                                    <div class="teacher-register-name">
                                        <div id="select-teacher-category" class="select-identify">
                                            <div class="select-identify-custom">
                                                @php
                                                    $category = '教えて！ライブ配信';
                                                    $categoryValue = 1;
                                                @endphp
                                                {{--                                                    }--}}
                                                <input type="text" class="select-identify-custom__value f-w3 mt-0"
                                                       readonly=""
                                                       value="{{ $category }}">
                                                <input type="hidden" name="teacher_category" id="usage_details"
                                                       class="hidden_input f-w3"
                                                       readonly=""
                                                       value="{{ $categoryValue }}">
                                                <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                                     class="arrow-down" alt="">
                                                <div class="select-identify-custom__options">
                                                    <div class="select-identify-custom__item f-w3"
                                                         data-category="1">教えて！ライブ配信
                                                    </div>
                                                    <div class="select-identify-custom__item f-w3"
                                                         data-category="2">オンライン悩み相談
                                                    </div>
                                                    <div class="select-identify-custom__item f-w3"
                                                         data-category="3">オンライン占い
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="element-helper-indentify" style="color: #2a3242">※アカウント承認後の変更はできません。
                                        </div>
                                    </div>

                                    <div id="teacher_category_consultation" class="d-none">
                                        <div class="title-identify">
                                            {{ trans('labels.teacher_register.identifications.online_trouble_consultation') }}
                                            <span class="text-note-title">（サービス内容はメンタル面に限ります。）</span>
                                        </div>
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center">
                                                <div
                                                        class="title-identify title-identify--w3">{{ trans('labels.teacher_register.identifications.qualification') }}</div>
                                                <span
                                                        class="element-require">{{ trans('labels.teacher_register.identifications.must_be_selected') }}</span>
                                            </div>
                                            <div class="d-flex ml-60">
                                                <label class="wrap-radio">
                                                    <input type="radio" checked
                                                           name="qualifications" id="publishByName" value="1">
                                                    <span class="label-title">あり</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="wrap-radio ml-35">
                                                    <input
                                                            type="radio"
                                                            name="qualifications" id="publishByNickname" value="0">
                                                    <span class="label-title">なし</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <small
                                                    class="qualifications-error element-helper-indentify error-qualification">
                                                {{ $errors->first('qualifications') }}
                                            </small>
                                            <small
                                                    class="d-none element-helper-indentify error-qualification">資格保有は、必ず指定してください。</small>
                                        </div>
                                        <div class="element-helper-indentify mt-1px"
                                             style="color: unset">{{ __('labels.teacher_register.identifications.helper_confirm') }}</div>
                                        <div id="block_choose-image">
                                            <div class="d-flex verification-image-consultation">
                                                <div class="sub-title">
                                                    {{ trans('labels.teacher_register.identifications.identity_verification_image') }}
                                                </div>
                                                <div class="choose-img">
                                                    <button class="btn fs-14 next" id="business-submit" type="button">
                                                        {{ trans('labels.button.upload') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="teacher-register-name teacher-register-name-custom">
                                                <div data-name="business_card"
                                                     class="position-relative image-container">
                                                    <input type="file" class="file" name="business_file"
                                                           data-name="business_card"
                                                           accept="image/png, image/gif, image/jpeg">
                                                    <img
                                                            src="{{ asset('./assets/img/teacher-page/rectangle.png') }}"
                                                            id="business_card"
                                                            class="img-responsive"
                                                            alt="Image">
                                                    <div
                                                            class="position-absolute image-button"
                                                            data-name="business_card"></div>
                                                    <span class="remove-item f-w3 hidden" data-name="business_card">
                                                <img src="/assets/img/clients/teacher/remove-img.svg" alt="">
                                            </span>
                                                    <div class="element-helper-indentify d-none error-business_card">
                                                        写真をお選びください
                                                    </div>
                                                </div>
                                                <small
                                                        class="business_file-error element-helper-indentify error-qualification">
                                                    {{ $errors->first('file') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $disabledFortune = (old('teacher_category') && old('teacher_category') !== 'teacher_category_fortunetelling') ||
                                            (!old('teacher_category') && $user->teacher_category_fortunetelling !== 1);
                                    @endphp
                                    <div id="teacher_category_fortunetelling"
                                         class="@if($disabledFortune) d-none @endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step_3">
                        <input type="hidden" name="isFortune" value="{{ $isFortune ?? null }}">
                        <div class="title_center text-center f-w6">
                            {{ trans('labels.teacher_register.title_identification2') }}
                        </div>
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.identifications.identity_verification') }}
                            </label>
                            <div class="content-item__required content-item__required--note mobile-maxw-273">
                                当サイトでは、購入者の皆様が安心してご利用いただく為に本人確認が必須となります。
                            </div>
                            <div class="content-item__required content-item__required--note f-w6">※選択必須</div>
                            <div class="d-flex flex-column align-items-start mt-4px">
                                <label class="wrap-radio">
                                    <input type="radio" name="isChangeName" id="noChangeName" checked value="0">
                                    <span class="label-title label-title--line-height25">(新規登録のお名前と同じ)</span>
                                    <span class="checkmark checkmark--line-height25"></span>
                                </label>
                                <label class="wrap-radio">
                                    <input type="radio" name="isChangeName" id="changeName" value="1">
                                    <span class="label-title label-title--line-height25">(下記の氏名で登録する)</span>
                                    <span class="checkmark checkmark--line-height25"></span>
                                </label>
                            </div>
                        </div>
                        <div class="input-full-name">
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.full_name') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <div class="content-item__input d-flex">
                                    <div class="surname">
                                        <input type="text" value="{{ old("last_name_kanji", $user->last_name_kanji) }}"
                                               name="last_name_kanji" placeholder="姓" readonly="readonly"
                                               class="form-control input--mobile input-surname content-item__input-focus">
                                        <small class="last_name_kanji-error text-danger"></small>
                                    </div>
                                    <div class="given-name">
                                        <input type="text"
                                               value="{{ old("first_name_kanji", $user->first_name_kanji) }}"
                                               name="first_name_kanji" placeholder="名" readonly="readonly"
                                               class="form-control input--mobile input-given-name content-item__input-focus">
                                        <small class="first_name_kanji-error text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.furigana') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <div class="content-item__input d-flex">
                                    <div class="surname">
                                        <input type="text" value="{{ old("last_name_kana", $user->last_name_kana) }}"
                                               name="last_name_kana" placeholder="例）サトウ" readonly="readonly"
                                               class="form-control input--mobile input-given-name content-item__input-focus content-item__input-focus">
                                        <small class="last_name_kana-error text-danger"></small>
                                    </div>
                                    <div class="given-name">
                                        <input type="text" value="{{ old("first_name_kana", $user->first_name_kana) }}"
                                               name="first_name_kana" placeholder="ハナコ" readonly="readonly"
                                               class="form-control input--mobile input-surname content-item__input-focus content-item__input-focus">
                                        <small class="first_name_kana-error text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                住所
                            </label>
                            <span class="content-item__required">※必須</span>
                            <div class="content-item__input d-flex">
                                <div class="given-name ml-0">
                                    <input type="text" value="{{ old("address", $user->address) }}"
                                           name="address" placeholder=""
                                           class="form-control input--mobile content-item__input-focus content-item__input-focus">
                                    <small class="address-error text-danger"></small>
                                </div>
                            </div>
                            <small class="note-address">※都道府県、番地、マンション名、号室まで正確にご入力ください</small>
                        </div>
                        <div class="content-item">
                            <label for="" class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.identifications.identity_image_application') }}
                            </label>
                            <span class="content-item__required">※必須</span>
                            <div class="d-flex mw-479">
                                <div id="select-verification_type" class="select-identify">
                                    <div class="select-identify-custom">
                                        @php
                                            $verificationType = \App\Enums\Constant::IDENTITY_VERIFICATION_IMG_APP_TYPES[0];
                                            $verifyType = 0;
                                        @endphp
                                        <input type="text" class="select-identify-custom__value f-w3 mt-0 pr-30"
                                               readonly=""
                                               value="{{ $verificationType }}">
                                        <input type="hidden" name="identity_verification_type" id="usage_details"
                                               class="hidden_input f-w3"
                                               readonly=""
                                               value="{{ $verifyType }}">
                                        <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                             class="arrow-down"
                                             alt="">
                                        <div class="select-identify-custom__options">
                                            @foreach(\App\Enums\Constant::IDENTITY_VERIFICATION_IMG_APP_TYPES as $key => $value)
                                                <div class="select-identify-custom__item f-w3"
                                                     data-category="{{ $key }}">
                                                    <span>{{ $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-image">
                                    <button id="submit-identify" type="button">
                                        {{ trans('labels.button.upload') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="content-item content-item__mb">
                            <label for="" class="content-item__title">
                                {{ trans('labels.teacher_register.identity_verification_image') }}
                            </label>
                            <div class="identification-images">
                                <div class="position-relative image-container">
                                    <input type="file" class="file" id="file" name="image_identify"
                                           data-name="image_identify"
                                           data-check="{{ $user['imagePathType1'] ? 1 : 0 }}"
                                           accept="image/png, image/gif, image/jpeg">
                                    <img
                                            src="{{ asset('/assets/img/teacher-page/rectangle.png') }}"
                                            id="image_identify"
                                            class="img-responsive"
                                            alt="Image">
                                    <div
                                            class="position-absolute image-button"
                                            data-name="image_identify"><span class="image-button__title">表面</span>
                                    </div>
                                    <span class="remove-item f-w3 hidden" data-name="image_identify">
                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="2">
                                        <input type="hidden" class="is-clear-img">
                                    </span>
                                </div>
                                <div class="position-relative image-container image-container-two">
                                    <input type="file" class="file1" name="image_identify1" data-name="image_identify1"
                                           data-check="{{ $user['imagePathTypeDisplayOne'] ? 1 : 0 }}"
                                           accept="image/png, image/gif, image/jpeg">
                                    <img
                                            src="{{ asset('/assets/img/teacher-page/rectangle.png') }}"
                                            id="image_identify1"
                                            class="img-responsive1"
                                            alt="Image">
                                    <div
                                            class="position-absolute image-button1"
                                            data-name="image_identify1"><span class="image-button__title">裏面</span>
                                    </div>
                                    <span class="remove-item1 f-w3 hidden" data-name="image_identify1">
                                        <img src="/assets/img/clients/teacher/remove-img.svg" alt="2">
                                    </span>
                                    <input type="hidden" class="is-clear-img">
                                </div>
                            </div>
                            <div class="element-helper-indentify d-none error-image_identify">写真をお選びください</div>
                            <div
                                    class="note-address">{{ __('labels.teacher_register.identifications.helper_identity_verification') }}</div>
                            <div class="note-address">本人確認画像は必ず一枚目が表で、二枚目が裏でご登録ください。</div>
                            <small class="file-error text-danger"></small>
                        </div>
                        <div class="content-item">
                            <div class="note-verify">
                                <div class="note-verify__title">
                                    ご利用いただける本人確認書類
                                </div>
                                <div class="note-verify__required note-verify__required-small">
                                    ※日本国内発行の本人確認書に限ります。
                                </div>
                                <div class="note-verify__required note-verify__required--note"
                                     style="padding-left: 13px; line-height: unset">いずれかの1点をご提出お願いします。
                                </div>
                                <ul class="note-verify__list">
                                    <li>運転免許証（表面・裏面）</li>
                                    <li>パスポート（顔写真入りページ・住所記載ページ）</li>
                                    <li>マイナンバーカード（表面のみ）</li>
                                    <li>在留カード（表面・裏面）</li>
                                </ul>
                                <div class="note-verify__title">
                                    非承認となるケース
                                </div>
                                <ul class="note-verify__list custom-margin">
                                    <li>画像が加工されていたり、一部隠されている場合</li>
                                    <li>マイナンバーカードや通知カード、海外発行書類、有効期限切れ書類など<br>
                                        当社で認めていない本人確認書類の場合
                                    </li>
                                    <li>出品者情報の氏名と本人確認書類の氏名に相違がある場合（ひらがなと漢字の違いなど）</li>
                                    <li>出品者情報の住所欄に、番地や建物名、部屋番号などが抜けている場合</li>
                                    <li>裏面に変更の記載がある書類で、裏面の画像がない場合</li>
                                    <li>画像の文字が識別できなかったり、データ形式がJPG、PNG以外の場合</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="step_4" class="teacher-register-nda teacher-register-nda--verify">
                        <div class="content">
                            <div class="content__title f-w6 text-center">機密保持契約書 (NDA)</div>
                            <div class="content__note f-w6 text-center">
                                オンライン占いを選択の場合は機密保持契約(NDA)の締結が必要です。
                            </div>
                            <div class="content__horizontal"></div>
                            <p class="content__text text-left">
                                （以下「甲」という）と株式会社Lappi（以下「乙」という）とは、両当事者が開示する情報の取り扱いについて、下記のとおりに契約を締結します。</p>
                            <div class="content__note content__note--small f-w3 text-center">
                                ※出品者が知り得た秘密情報を第三者に漏らさない事を決める契約です。
                            </div>
                            <div style="margin-top: -10px">@include('client.screen.teacher.my-page.content_nda')</div>
                            <label class="content__label content__label--black mt-0 f-w3">{{ now()->format('Y') }}
                                年{{ now()->format('m') }}月{{ now()->format('d') }}日</label>
                            <div class="content__user">
                                <div class="content__user-one">
                                    <p class="nda-address">甲：</p>
                                    <span class="nda-full-name"></span>
                                </div>
                                <div class="content__user-two">
                                    <p>乙：株式会社Lappi</p>
                                    <span>大阪府大阪市北区豊崎３丁目１５番５号</span>
                                    <span>代表取締役社長　高橋真二</span>
                                </div>
                            </div>
                            <p class="content__text content__text--confirm text-center">
                                契約内容を確認し合意の上で、「機密保持契約（NDA）を締結する」ボタンを押して下さい</p>
                        </div>
                    </div>

                    <div id="step_5" class="teacher-register-info-wrapper">
                        <div class="teacher-register-edit-content">
                            <div class="center">
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
                                                    <input
                                                            value="{{ old("bank_name", $user->bankAccount->bank_name ?? null) }}"
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
                                                            <div
                                                                    class="select__item f-w3 select-parent-item category-select bank-select">
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
                                                           class="form-control branch_name-input"
                                                           placeholder="支店名 or 支店番号"
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
                                                        <input checked type="radio" name="account_type"
                                                               id="account_type_1"
                                                               value="1">
                                                        <span
                                                                class="label-title">{{ trans('labels.teacher_register.account_type.savings') }}</span>
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
                                                    <div class="note-input ml-3 ml-3-custom">
                                                        ７桁未満の場合は頭に「０」を付けて入力してください。
                                                    </div>
                                                </div>
                                                <small class="account_number-error text-danger"></small>
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
                                                <small class="account_name-error text-danger ml-2"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="confirm d-flex justify-content-center">
                        <a class="btn fs-14 back confirm__button" data-back="{{ route('client.become-lappi') }}">
                            {{ trans('labels.button.back_step') }}
                        </a>
                        <button class="btn fs-14 confirm__button next" type="submit">
                            {{ trans('labels.button.next_step') }}
                        </button>
                    </div>
                    <div class="step_4">
                        <p style="color: #EE3D48; font-weight: bold; margin-top: 20px"
                           class="content__text text-center">
                            ※出品者マイページ「アカウント設定」より契約書の閲覧、ダウンロードができます。</p>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="option-after-bank" tabindex="-1"
                 aria-labelledby="option-after-bank"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content option-after-bank">
                        <div
                                class="text-center option-after-bank__header d-flex align-items-center justify-content-center">
                            <h5 class="f-w6" id="option-after-bank__Label">新規出品者登録が完了しました。</h5>
                        </div>
                        <div class="modal-body text-center option-after-bank__body">
                            <div class="option-after-bank__body__option">
                                <a id="redirect_home" href="{{ route('client.home')}}"
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
    </div>
@endsection
@section('script')
    <script>
        let uploadButton = document.getElementById("files");
        let inputFileNote = document.querySelector(".content-item__note-img");
        let userId = @json($userId);
        let user = @json($user);
        let identityVerificationStatus = @json($user['identity_verification_status']);

        // select category required
        $('#select-teacher-category').on('click', '.select-identify-custom', function (e) {
            let parentSelect = e.currentTarget;
            let valueSelected = e.currentTarget.querySelector(".select-identify-custom__value");
            let valueOptions = e.currentTarget.querySelectorAll(".select-identify-custom__item");
            for (let i = 0; i < valueOptions.length; i++) {
                valueOptions[i].classList.remove('item-active');
                if (valueSelected.value.replace(/^\s+/, '').replace(/\s+$/, '') == valueOptions[i].textContent.replace(/^\s+/, '').replace(/\s+$/, '')) {
                    valueOptions[i].classList.add('item-active');
                }
            }
            parentSelect.classList.toggle("active");
        })

        $('#select-teacher-category').on('click', '.select-identify-custom__item', function (e) {
            for (let i = 0; i < document.getElementsByName("file").length; i++) {
                document.getElementsByName("file")[i].value = '';
            }
            let data = e.currentTarget.getAttribute("data-id");
            $(this).parent().parent().children()[1].setAttribute("value", data);
            e.currentTarget.parentElement.parentElement.querySelector(".select-identify-custom__value").value = e.currentTarget.textContent;
            if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input")) {
                e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value = $(this).data('category');
                if (+e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value === 2) {
                    if (user.image_path_type2 && user.image_path_type2.image_url) {
                        $('#business_card').attr("src", user.image_path_type2.image_url);
                        $('.image-button[data-name=business_card]').addClass('hidden');
                        $('.remove-item[data-name=business_card]').removeClass('hidden');
                        $('input[name=qualifications]').filter('[value=' + user.qualifications + ']').prop('checked', true);
                    }
                    $('input[name=qualifications]').removeAttr('disabled');
                    $('#business-submit').removeAttr('disabled');
                    $('.image-container[data-name=business_card]').removeClass('disabled');
                    $('#teacher_category_consultation').removeClass('d-none');
                } else {
                    $('input[name=qualifications]').attr('disabled', true);
                    $('input[name=qualifications]').prop('checked', false);
                    $('#business-submit').attr('disabled', true);
                    $('.image-container[data-name=business_card]').addClass('disabled');
                    $('.image-container[data-name=business_card]').find('.remove-item').addClass('hidden');
                    $('#business_card').attr("src", '/assets/img/teacher-page/rectangle.png');
                    $('.image-button[data-name=business_card]').removeClass('hidden');
                    $('#teacher_category_consultation').addClass('d-none');
                }
                if (+e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value === 3) {
                    $('#nda-submit').removeAttr('disabled');
                    $('#teacher_category_fortunetelling').removeClass('d-none');
                } else {
                    $('#nda-submit').attr('disabled', true);
                    $('#teacher_category_fortunetelling').addClass('d-none');
                }
            }
        })

        $('#select-verification_type').on('click', '.select-identify-custom', function (e) {
            let parentSelect = e.currentTarget;
            let valueSelected = e.currentTarget.querySelector(".select-identify-custom__value");
            let valueOptions = e.currentTarget.querySelectorAll(".select-identify-custom__item");
            let listOptions = e.currentTarget.querySelector(".select-identify-custom__options");
            for (let i = 0; i < valueOptions.length; i++) {
                valueOptions[i].classList.remove('item-active');
                if (valueSelected.value.replace(/^\s+/, '').replace(/\s+$/, '') == valueOptions[i].textContent.replace(/^\s+/, '').replace(/\s+$/, '')) {
                    valueOptions[i].classList.add('item-active');
                    listOptions.scrollTop = valueOptions[i].offsetTop - 40;
                }
            }
            parentSelect.classList.toggle("active");
        })

        $('#select-verification_type').on('click', '.select-identify-custom__item', function (e) {
            let data = e.currentTarget.getAttribute("data-id");
            let cat = e.currentTarget.getAttribute("data-category");
            $(this).parent().parent().children()[1].setAttribute("value", data);
            if (e.currentTarget.textContent) {
                const newVal = e.currentTarget.textContent.trim();
                $(".select-identify-custom__value").val(newVal);
            }
            if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input")) {
                e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value = +cat;
            }
            if (+cat === 2) {
                $('.image-container-two').hide();
                $('.identification-images').addClass('one-image');
            } else {
                $('.image-container-two').show();
                $('.identification-images').removeClass('one-image');
            }
        })

        document.body.addEventListener('mouseup', function (e) {
            if (e.target.closest('.select-identify-custom') === null) {
                let selectBox = document.querySelectorAll('.select-identify-custom')
                for (let i = 0; i < selectBox.length; i++) {
                    selectBox[i].classList.remove('active');
                }
            }
        });

        uploadButton.onchange = () => {
            const [file] = uploadButton.files
            if (file) {
                inputFileNote.innerHTML = file.name;
            }
        }

        $(document).ready(function () {
            $('#step_1').show();
            $('#step_2').hide();
            $('#step_3').hide();
            $('#step_4').hide();
            $('#step_5').hide();
            $('.step_4').hide();
        });

        $("#teacher-register").submit(function (e) {
            e.preventDefault();
            const route = $(this).data('route');
            const formData = new FormData(this);
            submitRegisterTeacherStep(formData, route);
        });

        $('.confirm__button.back').on('click', function () {
            const step = +$('input[name=step]').val() ?? 1;
            backToStep(step - 1);
        });

        function backToStep(step) {
            $('body').scrollTop(0);
            if ($('input[name=teacher_category]').val() != 3 && step === 4) {
                $('#step_' + (step + 1)).hide();
                --step;
            }
            step = +step;
            if (!step) {
                window.location.href = $('.back.confirm__button').data('back');
                return;
            }
            if (step < 4) {
                $('button.confirm__button.next').html('次へ');
                $('.setting-info-content').css('max-width', 602);
                $('button.confirm__button.next').width('150');
                $('.step_4').hide();
            }
            if (step === 4) {
                if (+$('input[name=teacher_category]').val() === 3) {
                    $('.nda-address').html('甲：' + $('input[name=address]').val());
                    $('.nda-full-name').html($('input[name=last_name_kanji]').val() + ' ' + $('input[name=first_name_kanji]').val());
                    $('.setting-info-content').css('max-width', 900);
                    $('button.confirm__button.next').html('機密保持契約（NDA）を締結する');
                    $('button.confirm__button.next').width('unset');
                    $('.step_4').show();
                } else {
                    nextToStep(5);
                }
            }
            $('#step_' + (step + 1)).hide();
            $('#step_' + step).show();
            $('input[name=step]').val(step);
            $('.step-' + (step + 1)).addClass('not-active').removeClass('active');
        }

        function nextToStep(step) {
            $('body').scrollTop(0);
            step = +step;
            if (step > 5) {
                return;
            }
            $('#step_' + (step - 1)).hide();
            $('#step_' + step).show();
            $('input[name=step]').val(step);
            $('.step-' + step).removeClass('not-active').addClass('active');
            const lineStep = $('.line-step-' + step);
            if (lineStep.length) {
                lineStep.attr('src', lineStep.attr('src').replace('step-not-active', 'step-active'));
            }
            if (step === 3) {
                $('.input-full-name-1 input').attr('disabled', true);
                // set value step 2-2
                $('.input-full-name input[name=last_name_kanji]').val($('.input-full-name-1 input[name=last_name_kanji]').val());
                $('.input-full-name input[name=first_name_kanji]').val($('.input-full-name-1 input[name=first_name_kanji]').val());
                $('.input-full-name input[name=last_name_kana]').val($('.input-full-name-1 input[name=last_name_kana]').val());
                $('.input-full-name input[name=first_name_kana]').val($('.input-full-name-1 input[name=first_name_kana]').val());
            } else {
                $('.input-full-name-1 input').attr('disabled', false);
            }
            if (+$('input[name=teacher_category]').val() === 3) {
                $('.line-step-5').show();
                $('.step-5').show();
                $('.line-step').addClass('mw-82');
                $('.step-4 .ml-17').html('機密保持契約');
            } else {
                $('.line-step-5').hide();
                $('.step-5').hide();
                $('.line-step').removeClass('mw-82');
                $('.step-4 .ml-17').html('振込口座情報');
            }
            if (step === 4) {
                if (+$('input[name=teacher_category]').val() === 3) {
                    $('.nda-address').html('甲：' + $('input[name=address]').val());
                    $('.nda-full-name').html($('input[name=last_name_kanji]').val() + ' ' + $('input[name=first_name_kanji]').val());
                    $('.setting-info-content').css('max-width', 900);
                    $('button.confirm__button.next').html('機密保持契約（NDA）を締結する');
                    $('button.confirm__button.next').width('unset');
                    $('.step_4').show();
                } else {
                    nextToStep(5);
                }
            } else {
                $('.step_4').hide();
                $('.setting-info-content').css('max-width', 602);
                $('button.confirm__button.next').html('次へ');
                $('button.confirm__button.next').width(150);
            }
            if (step === 5) {
                $('button.confirm__button.next').html('登録する');
            }
        }

        $('.input-full-name-1 input[name=last_name_kanji]').on('change', function () {
            $('.input-full-name input[name=last_name_kanji]').val($(this).val());
        })
        $('.input-full-name-1 input[name=first_name_kanji]').on('change', function () {
            $('.input-full-name input[name=first_name_kanji]').val($(this).val());
        })
        $('.input-full-name-1 input[name=last_name_kana]').on('change', function () {
            $('.input-full-name input[name=last_name_kana]').val($(this).val());
        })
        $('.input-full-name-1 input[name=first_name_kana]').on('change', function () {
            $('.input-full-name input[name=first_name_kana]').val($(this).val());
        })

        function submitRegisterTeacherStep(formData, route) {
            $.ajax({
                beforeSend: function beforeSend() {
                    $('#loading-overlay').show();
                    $('[class*=-error]').html('');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: route,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function success(response) {
                    $('#loading-overlay').hide();
                    if (response.success) {
                        nextToStep(+formData.get('step') + 1);
                        if (response.updated) {
                            $('#option-after-bank').modal({backdrop: 'static', keyboard: false});
                            $('#option-after-bank').click(function () {
                                window.location.href = $('#redirect_home').attr('href');
                            })
                        }
                    } else {
                        console.log(response)
                        if (response.message) {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function error(response) {
                    console.log(response)
                    $('#loading-overlay').hide();
                    $('body').scrollTop(0);
                    $.each(response.responseJSON.data.errors, function (field_name, error) {
                        $('.' + error['key'] + '-error').html(error['error']);
                    });
                    if (response.message) {
                        toastr.error(response.message);
                    }
                    $('#identification_submit').prop('disabled', false);
                }
            });
        }
    </script>
    <script src="{{ mix('js/auto-bank.js') }}"></script>
    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>
@endsection

