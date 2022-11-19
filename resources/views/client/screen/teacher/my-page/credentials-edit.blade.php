@extends('client.base.base')
@section('css')
    <style>
        .teacher-register-name-hidden {
            display: none !important;
        }

        .img-responsive {
            width: 100%;
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
                                > {{ trans('labels.verification-edit-teacher.page_credentials') }}
                            </div>
                        </div>
                        <div class="teacher-register-wrapper p-mobile-0">
                            <div class="teacher-register-info-wrapper">
                                <div class="teacher-register-edit-content teacher-verification">
                                    <div class="center">
                                        <div class="right-teacher-register-content credentials-edit"
                                             style="border-radius: 5px">
                                            <div class="title_center">
                                                資格証明書（追加・変更)
                                            </div>
                                            <form
                                                    action="{{ route('client.teacher.mypage-teacher-credentials-update') }}"
                                                    method="POST" id="credentials-edit" enctype="multipart/form-data">
                                                @csrf
                                                <div class="teacher-register-content">
                                                    <div id="teacher_category_consultation">
                                                        <div class="title-identify">
                                                            {{ trans('labels.teacher_register.identifications.online_trouble_consultation') }}
                                                        </div>
                                                        <input type="hidden" name="teacher_category"
                                                               value="teacher_category_consultation">
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                        class="title-identify title-identify--w3">{{ trans('labels.teacher_register.identifications.qualification') }}</div>
                                                                <span
                                                                        class="element-require">{{ trans('labels.teacher_register.identifications.must_be_selected') }}</span>
                                                            </div>
                                                            <div class="d-flex ml-60">
                                                                <label class="wrap-radio">
                                                                    <input
                                                                            @if(old('qualifications') ? old('qualifications') == 1 : $user->qualifications == 1) checked
                                                                            @endif
                                                                            type="radio" name="qualifications"
                                                                            id="publishByName" value="1">
                                                                    <span class="label-title">あり</span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <label class="wrap-radio ml-35">
                                                                    <input
                                                                            @if(old('qualifications') ? old('qualifications') == 0 : $user->qualifications == 0) checked
                                                                            @endif
                                                                            type="radio" name="qualifications"
                                                                            id="publishByNickname" value="0">
                                                                    <span class="label-title">なし</span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if($errors->has('qualifications'))
                                                                <small
                                                                        class="error element-helper-indentify error-qualification">
                                                                    {{ $errors->first('qualifications') }}
                                                                </small>
                                                            @endif
                                                            <small
                                                                    class="d-none element-helper-indentify error-qualification">資格保有は、必ず指定してください。</small>
                                                        </div>
                                                        <div
                                                                class="element-helper-indentify mt-1px">{{ __('labels.teacher_register.identifications.helper_confirm') }}</div>
                                                        <div
                                                                class="d-flex align-items-end verification-image-consultation @if(old('qualifications') ? old('qualifications') == 0 : $user->qualifications == 0) teacher-register-name-hidden @endif">
                                                            <div class="sub-title">
                                                                {{ trans('labels.teacher_register.identifications.identity_verification_image') }}
                                                            </div>
                                                            <div class="choose-img choose-img--mypage">
                                                                <button class="btn fs-14 next" id="business-submit"
                                                                        type="button">
                                                                    {{ trans('labels.button.upload') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="teacher-register-name teacher-register-name-custom @if(old('qualifications') ? old('qualifications') == 0 : $user->qualifications == 0) teacher-register-name-hidden @endif">
                                                            <div data-name="business_card"
                                                                 class="position-relative image-container">
                                                                <input type="hidden" class="is-clear-img"
                                                                       name="check_clear_img"
                                                                       value="{{ $errors->has('file') ? 1 : '' }}">
                                                                <input type="file" class="file" name="file"
                                                                       data-name="business_card"
                                                                       accept="image/png, image/gif, image/jpeg">
                                                                <img
                                                                        src="{{ asset((isset($user['imagePathType2'])) ? $user['imagePathType2']->image_url : '/assets/img/teacher-page/rectangle.png')}}"
                                                                        id="business_card"
                                                                        class="obj-contain img-responsive img-responsive--mypage"
                                                                        alt="Image">
                                                                <div
                                                                        class="position-absolute image-button @if(isset($user['imagePathType2'])) hidden @endif"
                                                                        data-name="business_card"></div>
                                                                @if(isset($user['imagePathType2']))
                                                                    <span class="remove-item f-w3"
                                                                          data-name="business_card">
                                                                    <img
                                                                            src="/assets/img/clients/teacher/remove-img.svg"
                                                                            alt="">
                                                                </span>
                                                                @else
                                                                    <span class="remove-item f-w3 hidden"
                                                                          data-name="business_card">
                                                                    <img
                                                                            src="/assets/img/clients/teacher/remove-img.svg"
                                                                            alt="">
                                                                </span>
                                                                @endif
                                                                <div
                                                                        class="element-helper-indentify d-none error-business_card">
                                                                    写真をお選びください
                                                                </div>
                                                            </div>
                                                            <small class="element-helper-indentify error-required-img">
                                                            </small>
                                                            @if($errors->has('file'))
                                                                <small
                                                                        class="error element-helper-indentify error-qualification">
                                                                    {{ $errors->first('file') }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="confirm confirm--business">
                                                    <a href="{{ route('client.teacher.mypage-teacher-settingAccount') }}"
                                                       class="btn fs-14 back button">
                                                        {{ trans('labels.button.back_step') }}
                                                    </a>
                                                    <button class="btn fs-14 next" type="submit">
                                                        {{ trans('labels.button.submit_step') }}
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
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#credentials-edit').submit(function (e) {
            let isValid = false;
            const radio = $('input[name="qualifications"]:checked').val();
            const image = $('input[name="file"]').val();
            const nameImage = $('#business_card').attr('src');
            if (radio === '') {
                isValid = true;
                $('.error-qualification').removeClass('d-none');
            }
            if (image === '' && radio === '1' && nameImage === '/assets/img/teacher-page/rectangle.png') {
                isValid = true;
                $('.error-business_card').removeClass('d-none');
            }
            if (isValid) {
                e.preventDefault();
            }
        })
        $('#publishByNickname').click(function () {
            // $('.remove-item').trigger("click");
            $('.teacher-register-name-custom').addClass('teacher-register-name-hidden');
            $('.verification-image-consultation').addClass('teacher-register-name-hidden')
        });
        $('#publishByName').click(function () {
            $('.teacher-register-name').removeClass('teacher-register-name-hidden');
            $('.verification-image-consultation').removeClass('teacher-register-name-hidden')
        })
    </script>
    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>
@endsection
