@extends('client.base.base')
@section('css')
    <style>
        .select-identify-custom input {
            font-size: 12px !important;
            padding: 0 28px 0 15px;
        }

        .select-identify-custom__options .select-identify-custom__item {
            font-size: 12px !important;
            min-height: 35px !important;
            height: unset !important;
        }

        .img-responsive {
            width: 100%;
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

        .position-relative:nth-child(3) {
            margin-top: 10px;
        }

        .setting-info-wrapper .setting-info-content .content-item .image-container .img-responsive1 {
            width: 479px;
            height: 220px;
            border-radius: 5px;
        }

        .hidden {
            display: none !important;
        }

    </style>
@endsection
@section('content')
    <div class="main main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row">
                <div class="col-md-3 col-sm-3 sidebar-left">
                    @include('client.screen.teacher.my-page.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    @include('client.screen.teacher.my-page.teacher-header')
                    <div class="sidebar-right">
                        <div class="sidebar-right__title">
                            <div class="sidebar-right__title__text">
                                {{ trans('labels.info-edit-teacher.account_settings') }}
                                > {{ trans('labels.verification-edit-teacher.page_verification') }}
                            </div>
                        </div>
                        <div class="setting-info-wrapper">
                            <div class="setting-info-content d-flex" style="max-width: 468px;margin-top: 20px">
                                <form action="{{ route('client.teacher.mypage-teacher-verifi-identity-update') }}"
                                      id="verification-edit-submit" method="post" enctype="multipart/form-data"
                                      class="{{ $user['connect_verification_session'] !== \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_FAIL ? 'no-click' : '' }}">
                                    @csrf
                                    <input type="hidden" name="isUpdateIdentity" value="1">
                                    <div class="content-item">
                                        <div class="text-center title-register">本人確認書類の変更</div>
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
                                                    <input type="text" class="select-identify-custom__value f-w3 mt-0"
                                                           readonly=""
                                                           value="{{ $verificationType }}">
                                                    <input type="hidden" name="identity_verification_type"
                                                           id="usage_details" class="hidden_input f-w3"
                                                           readonly=""
                                                           value="{{ $verifyType }}">
                                                    <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                                         class="arrow-down" alt="">
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
                                    <div class="content-item">
                                        <label for="" class="content-item__title">
                                            {{ trans('labels.teacher_register.identity_verification_image') }}
                                        </label>
                                        <div class="position-relative image-container mw-100">
                                            <input id="file" type="file" class="file" name="file" data-name="image_identify"
                                                   accept="image/png, image/gif, image/jpeg"
                                                   data-check="{{ $user['imagePathType1'] ? 1 : 0 }}">
                                            <img
                                                src="{{ asset(isset($user['imagePathType1']) ? $user['imagePathType1']->image_url : './assets/img/teacher-page/rectangle.png')}}"
                                                id="image_identify" class="obj-contain img-responsive mw-100"
                                                alt="Image">
                                            <div
                                                class="position-absolute image-button @if(isset($user['imagePathType1'])) hidden @endif"
                                                data-name="image_identify"><span class="image-button__title">表面</span>
                                            </div>
                                            @if(isset($user['imagePathType1']) && $user['connect_verification_session'] === \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_FAIL)
                                                <span class="remove-item f-w3" data-name="image_identify">
                                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="1">
                                                </span>
                                            @else
                                                <span class="remove-item f-w3 hidden" data-name="image_identify">
                                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="2">
                                                </span>
                                            @endif
                                            <input type="hidden" class="is-clear-img">
                                        </div>
                                        <div class="position-relative image-container mw-100 image-container-two"
                                             style="{{ (int)$verifyType === 2 ? 'display: none' : '' }}">
                                            <input type="file" class="file1" name="file1" data-name="image_identify1"
                                                   accept="image/png, image/gif, image/jpeg"
                                                   data-check="{{ $user['imagePathTypeDisplayOne'] ? 1 : 0 }}">
                                            <img
                                                src="{{ asset(isset($user['imagePathTypeDisplayOne']) ? $user['imagePathTypeDisplayOne']->image_url : './assets/img/teacher-page/rectangle.png')}}"
                                                id="image_identify1" class="obj-contain img-responsive1 mw-100"
                                                alt="Image">
                                            <div
                                                class="position-absolute image-button1 @if(isset($user['imagePathTypeDisplayOne'])) hidden @endif"
                                                data-name="image_identify1"><span class="image-button__title">裏面</span>
                                            </div>
                                            @if(isset($user['imagePathTypeDisplayOne']) && $user['connect_verification_session'] === \App\Enums\DBConstant::CONNECT_VERIFICATION_SESSION_FAIL)
                                                <span class="remove-item1 f-w3" data-name="image_identify1">
                                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="1">
                                                </span>
                                            @else
                                                <span class="remove-item1 f-w3 hidden" data-name="image_identify1">
                                                    <img src="/assets/img/clients/teacher/remove-img.svg" alt="2">
                                                </span>
                                            @endif
                                            <input type="hidden" class="is-clear-img">
                                        </div>

                                        <div class="element-helper-indentify d-none error-image_identify">写真をお選びください
                                        </div>
                                        <div
                                            class="content-item__required content-item__required--note">{{ __('labels.teacher_register.identifications.helper_identity_verification') }}</div>
                                        <div class="content-item__required content-item__required--note">
                                            本人確認画像は必ず一枚目が表で、二枚目が裏でご登録ください。
                                        </div>
                                        <small class="file-error text-danger"></small>
                                        @if ($errors->has("file"))
                                            <small class="error text-danger">{{ $errors->first("file") }}</small>
                                        @endif
                                    </div>
                                    <div class="confirm d-flex justify-content-center">
                                        <a href="{{ route('client.teacher.mypage-teacher-settingAccount') }}"
                                           class="btn fs-14 back confirm__button">
                                            {{ trans('labels.button.back_step') }}
                                        </a>
                                        <button class="btn fs-14 confirm__button next" type="submit">
                                            {{ trans('labels.info-edit-teacher.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // select category required
        $('#select-verification_type').on('click', '.select-identify-custom', function (e) {
            let parentSelect = e.currentTarget;
            let valueSelected = e.currentTarget.querySelector(".select-identify-custom__value");
            let valueOptions = e.currentTarget.querySelectorAll(".select-identify-custom__item");
            let listOptions = e.currentTarget.querySelector(".select-identify-custom__options");
            for (let i = 0; i < valueOptions.length; i++) {
                valueOptions[i].classList.remove('item-active');
                if (valueSelected.value == valueOptions[i].innerText.replace(/^\s+/, '').replace(/\s+$/, '').replace(/(\r\n|\n|\r)/gm, "")) {
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
            if (e.currentTarget.innerText) {
                const newVal = e.currentTarget.innerText.trim().replace(/(\r\n|\n|\r)/gm, "");
                $(".select-identify-custom__value").val(newVal);
            }
            if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input")) {
                e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value = $(this).data('category');
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

    </script>
    <script>
        $(function () {
            let removeImageIdentify = false;
            let removeImageBusiness = false;
            // click button select image
            $('.image-button').on('click', function () {
                let input = $('input[data-name=' + $(this).data('name') + ']');
                if (input.length > 0) {
                    $(input[0]).trigger('click');
                }
            });
            $('.image-button1').on('click', function () {
                let input = $('input[data-name=' + $(this).data('name') + ']');
                if (input.length > 0) {
                    $(input[0]).trigger('click');
                }
            });
            $('#business-submit').on('click', function () {
                let input = $('input[data-name=business_card]');
                if (input.length > 0) {
                    $(input[0]).trigger('click');
                }
            });
            $('#submit-identify').on('click', function () {
                if (parseInt($('#file').attr('data-check')) === 0) {
                    let input = $('input[data-name=image_identify]');
                    if (input.length > 0) {
                        $(input[0]).trigger('click');
                    }
                    return;
                }
                if (parseInt($('.file1').attr('data-check')) === 0) {
                    let input = $('input[data-name=image_identify1]');
                    if (input.length > 0) {
                        $(input[0]).trigger('click');
                    }
                    return;
                }

            });
            // when select image
            $(document).on('change', 'input[class=file]', function (event) {
                let imgId = $(this).data('name');
                $('input[data-name=image_identify]').attr('data-check', 1);
                if (imgId === 'image_identify') {
                    removeImageIdentify = false;
                } else {
                    removeImageBusiness = false;
                }
                $('#' + imgId).attr("src", URL.createObjectURL(event.target.files[0]));
                $('.img-responsive').addClass('img-contain');
                $('.remove-item[data-name=' + imgId + ']').removeClass('hidden');
                $('.image-button[data-name=' + imgId + ']').addClass('hidden');
            });
            let removeImageIdentify1 = false;
            let removeImageBusiness1 = false;
            $(document).on('change', 'input[class=file1]', function (event) {
                let imgId = $(this).data('name');
                $('input[data-name=image_identify1]').attr('data-check', 1);
                if (imgId === 'image_identify1') {
                    removeImageIdentify1 = false;
                } else {
                    removeImageBusiness1 = false;
                }
                $('#' + imgId).attr("src", URL.createObjectURL(event.target.files[0]));
                $('.img-responsive1').addClass('img-contain');
                $('.remove-item1[data-name=' + imgId + ']').removeClass('hidden');
                $('.image-button1[data-name=' + imgId + ']').addClass('hidden');
            });
            // click remove icon
            var countDelete = 0; //count number delete.
            $('.remove-item').on('click', function () {
                countDelete++;
                $('#file').val('');
                $('input[data-name=image_identify]').attr('data-check', 0);
                $('.is-clear-img').val(1);
                let imgId = $(this).data('name');
                if (imgId === 'image_identify') {
                    removeImageIdentify = true;
                } else {
                    removeImageBusiness = true;
                }
                $('input[name=' + imgId + ']').val(null);
                $('#' + imgId).attr("src", '/assets/img/teacher-page/rectangle.png');
                $('.image-button[data-name=' + imgId + ']').removeClass('hidden');
                $('.img-responsive').removeClass('img-contain');
                $(this).addClass('hidden');
            });
            var countDelete1 = 0; //count number delete.

            $('.remove-item1').on('click', function () {
                countDelete1++;
                $('.file1').val('');
                $('input[data-name=image_identify1]').attr('data-check', 0);
                $('.is-clear-img').val(1);
                let imgId = $(this).data('name');
                if (imgId === 'image_identify1') {
                    removeImageIdentify1 = true;
                } else {
                    removeImageBusiness1 = true;
                }
                $('input[name=' + imgId + ']').val(null);
                $('#' + imgId).attr("src", '/assets/img/teacher-page/rectangle.png');
                $('.image-button1[data-name=' + imgId + ']').removeClass('hidden');
                $('.img-responsive1').removeClass('img-contain');
                $(this).addClass('hidden');
            });
        })
    </script>
{{--    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>--}}
@endsection
