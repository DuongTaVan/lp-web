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
            <img src="{{ url('/assets/img/clients/teacher/step-not-active.svg') }}" class="line-step"
                 alt="line-step-not-active">
            <div class="step not-active">
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
            @include('client.payment.process-payment-circle', ['step' => 'STEP 1', 'deg' => 120, 'title' => '個人情報', 'size' => 56])
        </div>
        <div class="setting-info-wrapper">
            <div class="setting-info-content d-flex">
                <form action="{{ route('client.teacher.register.setting-account.update', $userId) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$userId}}" name="userId">
                    <div class="title_center text-center f-w6">
                        {{ trans('labels.teacher_register.new_seller_registration') }}
                    </div>
                    <div class="content-item">
                        <label class="content-item__title f-w6">
                            {{ trans('labels.teacher_register.name') }}
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
                            </div>
                            <div class="given-name">
                                <input type="text" value="{{ old("first_name_kanji", $user->first_name_kanji) }}"
                                       name="first_name_kanji" placeholder="名"
                                       class="form-control input--mobile input-given-name content-item__input-focus">
                                @if ($errors->has("first_name_kanji"))
                                    <small class="error text-danger">{{ $errors->first("first_name_kanji") }}</small>
                                @endif
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
                                @if ($errors->has("last_name_kana"))
                                    <small class="error text-danger">{{ $errors->first("last_name_kana") }}</small>
                                @endif
                            </div>
                            <div class="given-name">
                                <input type="text" value="{{ old("first_name_kana", $user->first_name_kana) }}"
                                       name="first_name_kana" placeholder="ハナコ"
                                       class="form-control input--mobile input-surname content-item__input-focus content-item__input-focus">
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
                        @if ($errors->has("name_use"))
                            <small class="error text-danger">{{ $errors->first("name_use") }}</small>
                        @endif
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
                                <input type="hidden" name="profile_image_old" value="{{ json_encode($sessionImage) }}">
                                <span class="content-item__note-img">{{ $sessionImage['originalName'] ?? '' }}</span>
                            @elseif ($dbImage)
                                <input type="hidden" name="profile_image_old" value="{{ $user->getOriginal('profile_image') }}">
                                <span class="content-item__note-img">{{ $dbImage }}</span>
                            @else
                                <span class="content-item__note-img">最大５MBまで（GIF、JPG、PNG）</span>
                            @endif
                        </div>
                        <div class="note-address ml-7">マイページから変更可能</div>
                        @if ($errors->has("profile_image"))
                            <small class="error text-danger">{{ $errors->first("profile_image") }}</small>
                        @endif
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
                        @if ($errors->has("catchphrase"))
                            <small class="error text-danger">{{ $errors->first("catchphrase") }}</small>
                        @endif
                    </div>
                    <div class="content-item">
                        <label class="content-item__title f-w6">
                            {{ trans('labels.teacher_register.self_introduction') }}
                        </label>
                        <span class="content-item__required">※必須</span>
                        <textarea id="introduction" name="biography" maxlength="10000" rows="10" cols="60"
                                  class="form-control content-item__input-focus content-item__input-focus--big">{{ old('biography') ?? $user->biography }}</textarea>
                        <div class="note-address">マイページから変更可能</div>
                        @if ($errors->has("biography"))
                            <small class="error text-danger">{{ $errors->first("biography") }}</small>
                        @endif
                    </div>

                    <div class="confirm d-flex justify-content-center">
                        <a href="{{ route('client.register-form-user', $userId) }}"
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
        let uploadButton = document.getElementById("files");
        let inputFileNote = document.querySelector(".content-item__note-img");
        uploadButton.onchange = () => {
            const [file] = uploadButton.files
            if (file) {
                inputFileNote.innerHTML = file.name;
            }
        }
    </script>
@endsection

