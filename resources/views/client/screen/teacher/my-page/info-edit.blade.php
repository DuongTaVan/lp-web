@extends('client.base.base')
@section('content')
    <div class="main main-mypage-teacher">
        @include('client.screen.teacher.my-page.sidebar-left')
        <div class="content-right">
            @include('client.screen.teacher.my-page.teacher-header')
            <div class="sidebar-right">
                <div class="sidebar-right__title">
                    <div class="sidebar-right__title__text">
                        {{ trans('labels.info-edit-teacher.account_settings') }}
                        > {{ trans('labels.info-edit-teacher.registration_information') }}
                    </div>
                </div>
                <div class="setting-info-wrapper">
                    <div class="setting-info-content d-flex">
                        <form action="{{ route('client.teacher.mypage-teacher-info-edit-update', $user->user_id) }}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="title_center text-center f-w6">
                                {{ trans('labels.info-edit-teacher.change_info') }}
                            </div>
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.name') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <div class="content-item__input d-flex">
                                    <div class="surname">
                                        <input type="text"
                                               value="{{ old("last_name_kanji", $user->last_name_kanji) }}"
                                               name="last_name_kanji" placeholder="姓"
                                               class="form-control input--mobile input-surname content-item__input-focus">
                                        @if ($errors->has("last_name_kanji"))
                                            <small class="error text-danger">{{ $errors->first("last_name_kanji") }}</small>
                                        @endif
                                    </div>
                                    <div class="given-name">
                                        <input type="text"
                                               value="{{ old("first_name_kanji", $user->first_name_kanji) }}"
                                               name="first_name_kanji" placeholder="名"
                                               class="form-control input--mobile input-given-name content-item__input-focus">
                                        @if ($errors->has("first_name_kanji"))
                                            <small class="error text-danger">{{ $errors->first("first_name_kanji") }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="content-item__required content-item__required--note">
                                    ※本名またはビジネスネームで登録して下さい。
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
                                               value="{{ old("first_name_kana", $user->last_name_kana) }}"
                                               name="last_name_kana" placeholder="例）サトウ"
                                               class="form-control input--mobile input-surname content-item__input-focus content-item__input-focus">
                                        @if ($errors->has("last_name_kana"))
                                            <small class="error text-danger">{{ $errors->first("last_name_kana") }}</small>
                                        @endif
                                    </div>
                                    <div class="given-name">
                                        <input type="text"
                                               value="{{ old("last_name_kana", $user->first_name_kana) }}"
                                               name="first_name_kana" placeholder="ハナコ"
                                               class="form-control input--mobile input-given-name content-item__input-focus content-item__input-focus">
                                        @if ($errors->has("first_name_kana"))
                                            <small class="error text-danger">{{ $errors->first("first_name_kana") }}</small>
                                        @endif
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
                                        <input @if(old("name_use", $user->name_use) == 2) checked
                                               @endif type="radio" name="name_use" id="publishByName" value="2">
                                        <span class="label-title">お名前で公開</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="wrap-radio ml-40">
                                        <input @if(old("name_use", $user->name_use) == 1) checked
                                               @endif type="radio" name="name_use" id="publishByNickname"
                                               value="1">
                                        <span class="label-title">ニックネームで公開</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="content-item__required content-item__required--note">
                                    購入者アカウントはニックネームでしか公開されません。
                                </div>
                                @if ($errors->has("name_use"))
                                    <small class="error text-danger">{{ $errors->first("name_use") }}</small>
                                @endif
                            </div>
                            {{-- email change --}}
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.email_address') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <input type="text" value="{{ old("email", $user->email) }}" name="email"
                                       class="form-control content-item__change-email content-item__input-focus">
                                <span class="content-item__required content-item__required--note"
                                      style="color: #4E5768">＊メールアドレスの変更は、新しいメールアドレスにて本人確認が終了するまで
                                        完了しませんのでご注意下さい。</span>
                                @if ($errors->has("email"))
                                    <small class="error text-danger">{{ $errors->first("email") }}</small>
                                @endif
                            </div>
                            {{-- show birthday --}}
                            <div class="content-item">
                                <label class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.birthday') }}
                                </label>
                                <span class="content-item__required">※生年月日の変更はできません。</span>
                                <div class="content-item__date">
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
                            </div>
                            {{-- change sex --}}
                            <div class="content-item">
                                <label for="" class="content-item__title f-w6">
                                    {{ trans('labels.teacher_register.sex') }}
                                </label>
                                <span class="content-item__required">※必須</span>
                                <div class="d-flex">
                                    <label class="wrap-radio">
                                        <input @if(old("sex", $user->sex) == 1) checked @endif type="radio"
                                               name="sex" id="publishByName" value="1">
                                        <span class="label-title">@lang('labels.profile-email.male')</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="wrap-radio ml-30">
                                        <input @if(old("sex", $user->sex) == 2) checked @endif type="radio"
                                               name="sex" id="publishByName2" value="2">
                                        <span class="label-title">@lang('labels.profile-email.female')</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="wrap-radio ml-30">
                                        <input @if(old("sex", $user->sex) == 9) checked @endif type="radio"
                                               name="sex" id="publishByName3" value="9">
                                        <span class="label-title">@lang('labels.profile-email.other')</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="wrap-radio ml-30">
                                        <input @if(old("sex", $user->sex) == 0) checked @endif type="radio"
                                               name="sex" id="publishByName4" value="0">
                                        <span class="label-title">@lang('labels.profile-email.no_answer')</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="confirm d-flex justify-content-center">
                                <a href="{{ route('client.teacher.mypage-teacher-settingAccount') }}"
                                   class="btn fs-14 back confirm__button">
                                    {{ trans('labels.button.back_step') }}
                                </a>
                                <button class="btn fs-14 confirm__button next" type="submit">
                                    {{ trans('labels.button.submit_step') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let uploadButton = document.getElementById("files");
        let inputFileNote = document.querySelector(".select-help-text");
        uploadButton.onchange = () => {
            const [file] = uploadButton.files
            if (file) {
                inputFileNote.innerHTML = file.name;
            }
        }
    </script>
    <script src="{{ mix('js/clients/modules/register.js') }}"></script>
@endsection
