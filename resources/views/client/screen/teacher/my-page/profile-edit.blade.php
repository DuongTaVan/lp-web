@extends('client.base.base')
@section('content')
    <div class="main main-mypage-teacher">
        @include('client.screen.teacher.my-page.sidebar-left')
        <div class="content-right">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="sidebar-right sidebar-right-mobile">
                <div class="sidebar-right__title">
                    <div class="sidebar-right__title__text">
                        {{ trans('labels.profile-edit-teacher.change_profile') }} 
                    </div>
                </div>
                <div class="teacher-register-wrapper teacher-edit-nickname input-focus">
                    <form action="{{ route('client.teacher.post-mypage-teacher-profile-edit-nickname') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="teacher-profile-edit">
                            {{-- image --}}
                            <div class="wrap-content">
                                <label for="" class="wrap-content__label f-w6">{{ trans('labels.profile-edit-teacher.image_profile_teacher') }}</label>
                                <div class="image_profile_teacher">
                                    <div class="d-flex align-items-center">
                                        <div class="upload-btn-wrapper">
                                            <label for='input-file' class="f-w3">
                                                ファイルを選択
                                            </label>
                                            <input id='input-file' type='file' accept="image/png, image/gif, image/jpg"
                                                   name="profile_image"/>
                                        </div>
                                        <span class="f-w3 ml-11 input-file__note">最大５MBまで（GIF、JPG、PNG）</span>
                                    </div>
                                    <span class="image_profile_teacher__note">マイページから変更可能</span>
                                </div>
                                @if($errors->has('profile_image'))
                                    <small class="wrap-content__error">
                                        {{ $errors->first('profile_image') }}
                                    </small>
                                @endif
                            </div>
                            <div class="wrap-content">
                                <label for="" class="wrap-content__label f-w6">{{ trans('labels.profile-edit-teacher.catch_copy') }}</label>
                                <span class="wrap-content__required">※必須</span>
                                <input type="text" class="wrap-content__input wrap-content__input--big input-focus" name="catchphrase" value="{{ old('catchphrase', $user->catchphrase ?? null) }}">
                                @if($errors->has('catchphrase'))
                                    <small class="wrap-content__error">
                                        {{ $errors->first('catchphrase') }}
                                    </small>
                                @endif
                            </div>
                            <div class="wrap-content">
                                <label for="" class="wrap-content__label f-w6 mb-0">{{ trans('labels.profile-edit-teacher.self_introduction') }}</label>
                                <span class="wrap-content__required">※必須</span>
                                <textarea name="biography" id="input" maxlength="10000" class="form-control introduction input-focus" rows="5">{{ old('biography', $user->biography ?? null) }}</textarea>
                                @if($errors->has('biography'))
                                    <small class="wrap-content__error">
                                        {{ $errors->first('biography') }}
                                    </small>
                                @endif
                            </div>
                            <div class="confirm">
                                <a href="{{ route('client.teacher.my-page.dashboard') }}" class="btn fs-14 back button">
                                    {{ trans('labels.button.back_step') }}
                                </a>
                                <button class="btn fs-14 next" type="submit">
                                    {{ trans('labels.info-edit-teacher.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let uploadButton = document.getElementById("upload-button");
        let deleteImg = document.getElementById("delete-img");
        let chosenImage = document.getElementById("chosen-image");
        let chooseImg = document.getElementsByClassName("custom-file-upload");
        let checkImg = document.getElementById("check-img-default");

        let uploadButtonTeacher = document.getElementById("input-file");
        let inputFileNote = document.querySelector(".input-file__note");
        uploadButtonTeacher.onchange = () => {
            const [file] = uploadButtonTeacher.files
            if (file) {
                inputFileNote.innerHTML = file.name;
            }
        }

        uploadButton.onchange = () => {
            let reader = new FileReader();
            reader.readAsDataURL(uploadButton.files[0]);
            reader.onload = () => {
                chosenImage.setAttribute("src",reader.result);
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
@endsection
