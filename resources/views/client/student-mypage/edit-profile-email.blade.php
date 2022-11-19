@extends('client.base.base')
@section('css')
    <style>
        .main-right__title {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="main dashboard-wrapper my-page-student d-flex">
        @include('client.student-mypage.sidebar-left')
        <div class="content-right content-right__wrap">
            <div class="main-right main_content">
                @include('client.common.dashboard-role')
                <div class="main-right__title">
                    <div class="main-right__title__breadcrumb f-w6">
                        <span class="d-flex align-items-center f-w6">
                            @lang('labels.sidebar-left.account_settings') <img
                                    src="{{asset('assets/img/common/arrow-breadcrumb.svg')}}"
                                    style="margin: 0 7px 0 11px" alt="Image"> @lang('labels.profile-email.user_information')
                        </span>
                    </div>
                </div>
                <form action="{{ route('client.student.my-page.edit-profile-and-email-post') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @isset($user)
                        <div class="content-profile">
                            <div class="main-profile-email page-profile-email">
                                <div class="page-profile-email">
                                    <label class="page-profile-email__label f-w6"
                                           for="">@lang('labels.profile-email.mail_address')</label>
                                    <span class="page-profile-email__required">@lang('labels.profile-email.require')</span>
                                    <div class="page-profile-email__input">
                                        <input type="text" name="email"
                                               value="{{ old('email', $user->email ?? null) }}">
                                    </div>
                                    <div class="page-profile-email__helpText">
                                        @lang('labels.profile-email.help_text')
                                    </div>
                                    @error('email')
                                    <span class="message-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <label for=""
                                       class="page-profile-email__label f-w6">{{ __('labels.auth.register.birthday') }}</label>
                                <span class="page-profile-email__required">※生年月日の変更はできません。</span>
                                <div class="page-profile-email-date">
                                    <div class="birthday-wrap d-flex justify-content-between align-items-center">
                                        <div class="birthday-item d-flex justify-content-center align-items-center">
                                            <div class="birthday-item__content">{{ formatTime($user->date_of_birth ?? null, 'Y') }}</div>
                                            <span class="birthday-item__label">年</span>
                                        </div>
                                        <div class="birthday-item d-flex justify-content-center align-items-center">
                                            <div class="birthday-item__content">{{ formatTime($user->date_of_birth ?? null, 'm') }}</div>
                                            <span class="birthday-item__label">月</span>
                                        </div>
                                        <div class="birthday-item d-flex justify-content-center align-items-center">
                                            <div class="birthday-item__content">{{ formatTime($user->date_of_birth ?? null, 'd') }}</div>
                                            <span class="birthday-item__label">日</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="page-profile-email">
                                    <label class="page-profile-email__label f-w6"
                                           for="">@lang('labels.profile-email.sex')</label>
                                    <span class="page-profile-email__required">@lang('labels.profile-email.require')</span>
                                    <div class="page-profile-email__radio">
                                        <label class="button-radio">@lang('labels.profile-email.male')
                                            <input type="radio" value="1"
                                                   {{ old('sex', $user->sex) == 1 ? 'checked' : '' }} name="sex">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="button-radio">@lang('labels.profile-email.female')
                                            <input type="radio" value="2"
                                                   {{ old('sex', $user->sex) == 2 ? 'checked' : '' }} name="sex">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="button-radio">@lang('labels.profile-email.other')
                                            <input type="radio" value="9"
                                                   {{ old('sex', $user->sex) == 9 ? 'checked' : '' }} name="sex">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="button-radio">@lang('labels.profile-email.no_answer')
                                            <input type="radio" value="0"
                                                   {{ old('sex', $user->sex) == 0 ? 'checked' : '' }} name="sex">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="page-profile-email">
                                    <div class="page-profile-email__title">
                                        <p>@lang('labels.profile-email.purpose')</p>
                                        <p>@lang('labels.profile-email.require')</p>
                                    </div>
                                    <div class="page-profile-email__radio">
                                        <label class="button-radio">@lang('labels.profile-email.purpose_1')
                                            <input type="radio" value="1" {{ old('user_type', $user->user_type) == 1 ? 'checked' : '' }} name="user_type">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="button-radio">@lang('labels.profile-email.purpose_2')
                                            <input type="radio" value="2" {{ old('user_type', $user->user_type) == 2 ? 'checked' : '' }} name="user_type">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div> --}}
                                <div class="button-action">
                                    <a href="{{ route('client.student.my-page.account-setting') }}"
                                       class="f-w6 button-action__btn button-action__btn--back">@lang('labels.button.back_step')</a>
                                    <button type="submit"
                                            class="f-w6 button-action__btn button-action__btn--submit button-action__btn--submit--big">@lang('labels.profile-email.button_edit')</button>
                                </div>
                            </div>
                        </div>
                    @endisset
                </form>
                @if (session('success') != null)
                    <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script>
        let radioButton = document.querySelectorAll('.button-radio');
        var radios = document.querySelectorAll('input[type="radio"]:checked');
        if (radios.length > 0) {
            radios[0].parentElement.classList.add('active-radio-edit')
        }
        radioButton.forEach(el => {
            el.addEventListener('click', () => {
                removeClassActive();
                el.classList.add('active-radio-edit')
            })
        })

        function removeClassActive() {
            radioButton.forEach(el => {
                el.classList.remove('active-radio-edit')
            })
        }

        let uploadButton = document.getElementById("upload-button");
        let deleteImg = document.getElementById("delete-img");
        let chosenImage = document.getElementById("chosen-image");
        let chooseImg = document.getElementsByClassName("custom-file-upload");
        let checkImg = document.getElementById("check-img-default");

        // uploadButton.onchange = () => {
        //     let reader = new FileReader();
        //     reader.readAsDataURL(uploadButton.files[0]);
        //     reader.onload = () => {
        //         chosenImage.setAttribute("src",reader.result);
        //     }
        //     chosenImage.style.display = "inherit";
        //     chooseImg[0].style.display = "none";
        // }

        // deleteImg.onclick = () => {
        //     chosenImage.style.display = "none";
        //     chooseImg[0].style.display = "inherit";
        // }
        uploadButton.onchange = () => {
            let reader = new FileReader();
            reader.readAsDataURL(uploadButton.files[0]);
            reader.onload = () => {
                chosenImage.setAttribute("src", reader.result);
            }
            chosenImage.style.display = "inherit";
            checkImg.value = 1;
        }

        deleteImg.onclick = () => {
            chosenImage.style.display = "none";
            chosenImage.removeAttribute("src");
            checkImg.value = 0;
            document.getElementById("upload-button").value = "";
        }
    </script>
    <script src="{{ mix('js/clients/modules/register.js') }}"></script>
@endsection
