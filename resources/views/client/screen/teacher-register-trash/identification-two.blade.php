<style>
    .btn-disabled {
        pointer-events: unset !important;
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
</style>
@extends('client.base.base')
@section('content')
    <div class="teacher-register-wrapper">
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
            {{-- <div class="next-step"></div> --}}
            <img src="{{ url('/assets/img/clients/teacher/step-not-active.svg') }}" class="line-step"
                 alt="line-step-not-active">
            <div class="step not-active">
                <div>
                    3
                </div>
                <div class="ml-17">
                    {{ __('labels.teacher_register.method_of_payment') }}
                </div>
            </div>
        </div>
        <div class="step-mobile">
            @include('client.payment.process-payment-circle', ['step' => 'STEP 2', 'deg' => 240, 'title' => '本人確認', 'size' => 56])
        </div>
        <div class="setting-info-wrapper">
            <div class="setting-info-content">
                @if ($errors->has('teacher_category_skills'))
                    <div id="show-toast-error" data-msg="{{__('errors.MSG_5042')}}"></div>
                @elseif($errors->has('teacher_category_fortunetelling'))
                    <div id="show-toast-error" data-msg="{{__('errors.MSG_5043')}}"></div>
                @elseif($errors->has('teacher_category_consultation'))
                    <div id="show-toast-error" data-msg="{{__('errors.MSG_5044')}}"></div>
                @endif
                <form id="form-identification-submit"
                      data-route="{{ route('client.teacher.register.setting-account.identification-two-update', $userId) }}"
                      data-redirect="{{route($isFortune == false ? 'client.teacher.register.setting-account.payment' : 'client.teacher.register.setting-account.nda-verify', $userId)}}"
                      action=""
                      method="post" enctype="multipart/form-data">
                    @csrf
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
                                <input type="radio" name="isChangeName" id="noChangeName" value="0">
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
                    <div class="no-change-input">
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
                                    @if ($errors->has("last_name_kanji"))
                                        <small class="error text-danger">{{ $errors->first("last_name_kanji") }}</small>
                                    @endif
                                    <small class="last_name_kanji-error text-danger"></small>
                                </div>
                                <div class="given-name">
                                    <input type="text" value="{{ old("first_name_kanji", $user->first_name_kanji) }}"
                                           name="first_name_kanji" placeholder="名"
                                           class="form-control input--mobile input-given-name content-item__input-focus">
                                    @if ($errors->has("first_name_kanji"))
                                        <small
                                            class="error text-danger">{{ $errors->first("first_name_kanji") }}</small>
                                    @endif
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
                                           name="last_name_kana" placeholder="例）サトウ"
                                           class="form-control input--mobile input-given-name content-item__input-focus content-item__input-focus">
                                    @if ($errors->has("last_name_kana"))
                                        <small class="error text-danger">{{ $errors->first("last_name_kana") }}</small>
                                    @endif
                                    <small class="last_name_kana-error text-danger"></small>
                                </div>
                                <div class="given-name">
                                    <input type="text" value="{{ old("first_name_kana", $user->first_name_kana) }}"
                                           name="first_name_kana" placeholder="ハナコ"
                                           class="form-control input--mobile input-surname content-item__input-focus content-item__input-focus">
                                    @if ($errors->has("first_name_kana"))
                                        <small class="error text-danger">{{ $errors->first("first_name_kana") }}</small>
                                    @endif
                                    <small class="first_name_kana-error text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="change-input d-none">
                        <div class="content-item">
                            <label class="content-item__title f-w6">
                                {{ trans('labels.teacher_register.full_name') }}
                            </label>
                            <span class="content-item__required">※必須</span>
                            <div class="content-item__input d-flex">
                                <div class="surname">
                                    <input type="text"
                                           name="last_name_kanji" placeholder="姓"
                                           value="{{ old("last_name_kanji", $user->last_name_kanji) }}"
                                           class="form-control input--mobile input-surname content-item__input-focus reset-value">
                                    @if ($errors->has("last_name_kanji"))
                                        <small class="error text-danger">{{ $errors->first("last_name_kanji") }}</small>
                                    @endif
                                    <small class="last_name_kanji-error text-danger"></small>
                                </div>
                                <div class="given-name">
                                    <input type="text"
                                           name="first_name_kanji" placeholder="名"
                                           value="{{ old("first_name_kanji", $user->first_name_kanji) }}"
                                           class="form-control input--mobile input-given-name content-item__input-focus reset-value">
                                    @if ($errors->has("first_name_kanji"))
                                        <small
                                            class="error text-danger">{{ $errors->first("first_name_kanji") }}</small>
                                    @endif
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
                                    <input type="text"
                                           name="last_name_kana" placeholder="例）サトウ"
                                           value="{{ old("last_name_kana", $user->last_name_kana) }}"
                                           class="form-control input--mobile input-given-name content-item__input-focus content-item__input-focus reset-value">
                                    @if ($errors->has("last_name_kana"))
                                        <small class="error text-danger">{{ $errors->first("last_name_kana") }}</small>
                                    @endif
                                    <small class="last_name_kana-error text-danger"></small>
                                </div>
                                <div class="given-name">
                                    <input type="text"
                                           name="first_name_kana" placeholder="ハナコ"
                                           value="{{ old("first_name_kana", $user->first_name_kana) }}"
                                           class="form-control input--mobile input-surname content-item__input-focus content-item__input-focus reset-value">
                                    @if ($errors->has("first_name_kana"))
                                        <small class="error text-danger">{{ $errors->first("first_name_kana") }}</small>
                                    @endif
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
                                @if ($errors->has("address"))
                                    <small class="error text-danger">{{ $errors->first("address") }}</small>
                                @endif
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
                                        if ($user['identity_verification_type']) {
                                            $verificationType = \App\Enums\Constant::IDENTITY_VERIFICATION_IMG_APP_TYPES[old('identity_verification_type') ? old('identity_verification_type') : $user['identity_verification_type']];
                                            $verificationTypeValue = $user['identity_verification_type'];
                                        } else {
                                            $verificationType = \App\Enums\Constant::IDENTITY_VERIFICATION_IMG_APP_TYPES[old('identity_verification_type') ? old('identity_verification_type') : 0];
                                            $verificationTypeValue = 0;
                                        }
                                        $verifyType = old('identity_verification_type', $verificationTypeValue);
                                    @endphp
                                    <input type="text" class="select-identify-custom__value f-w3 mt-0 pr-30" readonly=""
                                           value="{{ $verificationType }}">
                                    <input type="hidden" name="identity_verification_type" id="usage_details"
                                           class="hidden_input f-w3"
                                           readonly=""
                                           value="{{ $verifyType }}">
                                    <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}" class="arrow-down"
                                         alt="">
                                    <div class="select-identify-custom__options">
                                        @foreach(\App\Enums\Constant::IDENTITY_VERIFICATION_IMG_APP_TYPES as $key => $value)
                                            <div class="select-identify-custom__item f-w3" data-category="{{ $key }}">
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
                        <div class="identification-images {{ (int)$verifyType === 2 ? 'one-image' : '' }}">
                            <div class="position-relative image-container">
                                <input type="file" class="file" name="file" data-name="image_identify"
                                       data-check="{{ $user['imagePathType1'] ? 1 : 0 }}"
                                       accept="image/png, image/gif, image/jpeg">
                                <img
                                    src="{{ asset(isset($user['imagePathType1']) ? $user['imagePathType1']->image_url : './assets/img/teacher-page/rectangle.png')}}"
                                    id="image_identify"
                                    class="img-responsive {{ isset($user['imagePathType1']) ? 'img-contain' : '' }}"
                                    alt="Image">
                                <div
                                    class="position-absolute image-button @if(isset($user['imagePathType1'])) hidden @endif"
                                    data-name="image_identify"><span class="image-button__title">表面</span></div>
                                @if(isset($user['imagePathType1']))
                                    <span class="remove-item f-w3" data-name="image_identify"
                                          data-remove="{{route('client.teacher.register.setting-account.remove-image', $userId)}}">
                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="1">
                                </span>
                                @else
                                    <span class="remove-item f-w3 hidden" data-name="image_identify">
                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="2">
                                </span>
                                @endif
                                <input type="hidden" class="is-clear-img">
                            </div>
                            <div class="position-relative image-container image-container-two"
                                 style="{{ (int)$verifyType === 2 ? 'display: none' : '' }}">
                                <input type="file" class="file1" name="file1" data-name="image_identify1"
                                       data-check="{{ $user['imagePathTypeDisplayOne'] ? 1 : 0 }}"
                                       accept="image/png, image/gif, image/jpeg">
                                <img
                                    src="{{ asset(isset($user['imagePathTypeDisplayOne']) ? $user['imagePathTypeDisplayOne']->image_url : './assets/img/teacher-page/rectangle.png')}}"
                                    id="image_identify1"
                                    class="img-responsive1 {{ isset($user['imagePathTypeDisplayOne']) ? 'img-contain' : '' }}"
                                    alt="Image">
                                <div
                                    class="position-absolute image-button1 @if(isset($user['imagePathTypeDisplayOne'])) hidden @endif"
                                    data-name="image_identify1"><span class="image-button__title">裏面</span></div>
                                @if(isset($user['imagePathTypeDisplayOne']))
                                    <span class="remove-item1 f-w3" data-name="image_identify1"
                                          data-remove="{{route('client.teacher.register.setting-account.remove-image', $userId)}}">
                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="1">
                                </span>
                                @else
                                    <span class="remove-item1 f-w3 hidden" data-name="image_identify1">
                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="2">
                                </span>
                                @endif
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
                            <div class="note-verify__required note-verify__required-small">※日本国内発行の本人確認書に限ります。</div>
                            <div class="note-verify__required note-verify__required--note"
                                 style="padding-left: 13px; line-height: unset">いずれかの1点をご提出お願いします。
                            </div>
                            <ul class="note-verify__list">
                                {{--                                <li>運転免許証/運転経歴証明書（表面・裏面）</li>--}}
                                {{--                                <li>健康保険証（表面・裏面）</li>--}}
                                {{--                                <li>パスポート（顔写真入りページ・住所記載ページ）</li>--}}
                                {{--                                <li>住民票（表面）<small--}}
                                {{--                                            class="note-verify__required note-verify__required--note note-mobile">※個人番号（マイナンバー）の記載された住民票は利用できません。</small>--}}
                                {{--                                </li>--}}
                                {{--                                <li>住民基本台帳（表面・裏面）</li>--}}
                                {{--                                <li>在留カード（表面・裏面）</li>--}}
                                {{--                                <li>国民年金手帳（住所記載ページ）</li>--}}
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

                    <div class="confirm d-flex justify-content-center" style="margin-top: 28px">
                        <a href="{{ route('client.teacher.register.setting-account.identification', $userId) }}"
                           class="btn fs-14 back confirm__button">
                            {{ trans('labels.button.back_step') }}
                        </a>
                        <button class="btn fs-14 confirm__button next" type="submit">
                            {{ trans('labels.button.next_step') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let userId = @json($userId);
        let user = @json($user);
        let identityVerificationStatus = @json($user['identity_verification_status']);

        // select category required
        $(document).ready(function () {
            $('#select-verification_type').on('click', '.select-identify-custom', function (e) {
                console.log(213)
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
        });

        document.body.addEventListener('mouseup', function (e) {
            if (e.target.closest('.select-identify-custom') === null) {
                let selectBox = document.querySelectorAll('.select-identify-custom')
                for (let i = 0; i < selectBox.length; i++) {
                    selectBox[i].classList.remove('active');
                }
            }
        });
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>
@endsection
