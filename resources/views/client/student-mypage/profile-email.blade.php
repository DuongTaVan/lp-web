@extends('client.base.base')
@section('content')
    <div class="main my-page-student">
        <div class="container px-0">
            <div class="row">
                <div class="col-md-3 col-sm-3 mw-300">
                    @include('client.student-mypage.sidebar-left')
                </div>
                <div class="col-md-9 col-sm-9 content-right">
                    <div class="main-right page-profile">
                        <div class="main-right__title">
                            <div class="main-right__title__breadcrumb">
                                <span class="d-flex align-items-center f-w6">@lang('labels.profile-email.profile_header')</span>
                            </div>
                        </div>
                        <div class="teacher-register-wrapper">
                            <form action="{{ route('client.student.my-page.post-profile-and-email') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="teacher-profile-edit">
                                    <div class="wrap-content">
                                        <label for="" class="wrap-content__label f-w6">{{ trans('labels.profile-edit-teacher.nick_name') }}</label>
                                        <span class="wrap-content__required">※必須</span>
                                        <input type="text" class="wrap-content__input input-focus nickname-disable" oninput="checkDisabled()" name="nickname" value="{{ old('nickname', $user->nickname ?? null) }}">
                                        <span class="wrap-content__note">＊3文字以上20文字以内、記号可能 </span>
                                        @if($errors->has('nickname'))
                                            <small class="wrap-content__error">
                                                {{ $errors->first('nickname') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="wrap-content">
                                        <label for="" class="wrap-content__label f-w6">{{ trans('labels.profile-edit-teacher.image_profile') }}</label>
                                        <div class="wrap-content__upload">
                                            <div class="button-upload">
                                                <label class="custom-file-upload">
                                                    <div class="circle">
                                                        <input type="file" name="profile_image" id="upload-button" accept="image/png, image/gif, image/jpg">
                                                        <img src="{{asset('assets/img/student/my-page/icon/plus.svg')}}" alt="">
                                                    </div>
                                                    <img id="chosen-image" class="{{ $user->profile_image == asset('assets/img/clients/header-common/not-login.svg') ? 'd-none' : '' }}" src="{{ $user->profile_image }}">
                                                    <input type="hidden" id="check-img-default" name="checkImg" value="">
                                                </label>
                                            </div>
                                            <span class="custom-button" id="delete-img">
                                                <button type="button">画像削除</button>
                                            </span>
                                        </div>
                                        <span class="wrap-content__note note-center">※ 最大５MBまで（GIF、JPG、PNG） </span>
                                        @if($errors->has('profile_image'))
                                            <small class="wrap-content__error">
                                                {{ $errors->first('profile_image') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="wrap-content">
                                        <label for="" class="wrap-content__label f-w6 mb-0">{{ trans('labels.profile-edit-teacher.text_profile') }}</label>
                                        <span style="margin-top: -2px" class="wrap-content__note">(説明文） </span>
                                        <textarea name="catchphrase" id="input" oninput="checkDisabled()" maxlength="10000" class="form-control catchphrase-disabled input-focus" rows="5">{{ old('catchphrase', $user->catchphrase ?? null) }}</textarea>
                                        @if($errors->has('catchphrase'))
                                            <small class="wrap-content__error">
                                                {{ $errors->first('catchphrase') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="confirm">
                                        <a href="{{ route('client.student.my-page.account-setting') }}" class="btn fs-14 back button">
                                            {{ trans('labels.button.back_step') }}
                                        </a>
                                        <button class="btn fs-14 next" type="submit" disabled>
                                            {{ trans('labels.info-edit-teacher.save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                        @if (session('success') != null)
                            <div id="show-toast-success" data-msg="{{ session('success') }}"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script>
        function checkDisabled() {
            $('.next').prop('disabled', false);
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
                chosenImage.setAttribute("src",reader.result);
            }
            chosenImage.style.display = "inherit";
            chosenImage.classList.remove('d-none');
            checkImg.value = 1;
            checkDisabled();
        }

        deleteImg.onclick = () => {
            chosenImage.style.display = "none";
            chosenImage.removeAttribute("src");
            checkImg.value = 0;
            document.getElementById("upload-button").value = "";
            checkDisabled();
        }
    </script>
@endsection
