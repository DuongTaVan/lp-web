@extends('client.base.base')
@section('css')
    <style>
        .teacher-register-name-hidden{
            display: none !important;
        }
    </style>
@endsection
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
        <div class="teacher-register-info-wrapper">
            <div class="teacher-register-edit-content">
                @if ($errors->has('teacher_category_skills'))
                    <div id="show-toast-error" data-msg="{{__('errors.MSG_5042')}}"></div>
                @elseif($errors->has('teacher_category_fortunetelling'))
                    <div id="show-toast-error" data-msg="{{__('errors.MSG_5043')}}"></div>
                @elseif($errors->has('teacher_category_consultation'))
                    class="title-identify"
                    <div id="show-toast-error" data-msg="{{__('errors.MSG_5044')}}"></div>
                @endif
                <form action="{{ route('client.teacher.register.setting-account.verify-nda-business-card', $userId) }}"
                      method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    <input type="hidden" name="userId" value="{{ $userId }}">
                    <div class="center">
                        <div class="right-teacher-register-content">
                            <div class="title_center">
                                {{ trans('labels.teacher_register.title_identification') }}
                            </div>
                            <div class="teacher-register-content">
                                <div class="title-identify">
                                    {{ trans('labels.teacher_register.identifications.usage_details') }}
                                    <span class="element-require">{{ trans('labels.teacher_register.identifications.required') }}</span>
                                    <span class="element-require" style="margin-left: 0">１つだけ選択してください</span>
                                </div>
                                <div class="teacher-register-name">
                                    <div id="select-teacher-category" class="select-identify">
                                        <div class="select-identify-custom">
                                            @php
                                                if (old('teacher_category') === 'teacher_category_consultation' || (!old('teacher_category') && $user->teacher_category_consultation === 1)) {
                                                   $category = 'オンライン悩み相談';
                                                   $categoryValue = 'teacher_category_consultation';
                                                } elseif (old('teacher_category') === 'teacher_category_fortunetelling' || (!old('teacher_category') && $user->teacher_category_fortunetelling === 1)) {
                                                    $category = 'オンライン占い';
                                                    $categoryValue = 'teacher_category_fortunetelling';
                                                } else {
                                                    $category = '教えて！ライブ配信';
                                                    $categoryValue = 'teacher_category_skills';
                                                }
                                            @endphp
                                            <input type="text" class="select-identify-custom__value f-w3 mt-0"
                                                   readonly=""
                                                   value="{{ $category }}">
                                            <input type="hidden" name="teacher_category" id="usage_details"
                                                   class="hidden_input f-w3"
                                                   readonly="" value="{{ old('teacher_category', $categoryValue) }}">
                                            <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                                 class="arrow-down" alt="">
                                            <div class="select-identify-custom__options">
                                                <div class="select-identify-custom__item f-w3"
                                                     data-category="teacher_category_skills">教えて！ライブ配信
                                                </div>
                                                <div class="select-identify-custom__item f-w3"
                                                     data-category="teacher_category_consultation">オンライン悩み相談
                                                </div>
                                                <div class="select-identify-custom__item f-w3"
                                                     data-category="teacher_category_fortunetelling">オンライン占い
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <select name="teacher_category" id="usage_details" class="form-control select-identify" required="required">
                                        <option class="select-identify__option" value="teacher_category_skills" @if(old('teacher_category') == 'teacher_category_skills' || (!old('teacher_category') && $user->teacher_category_skills == 1)) selected @endif>教えて！ライブ配信 </option>
                                        <option class="select-identify__option" value="teacher_category_consultation" @if(old('teacher_category') == 'teacher_category_consultation' || (!old('teacher_category') && $user->teacher_category_consultation == 1)) selected @endif>オンライン悩み相談</option>
                                        <option class="select-identify__option" value="teacher_category_fortunetelling" @if(old('teacher_category') == 'teacher_category_fortunetelling' || (!old('teacher_category') && $user->teacher_category_fortunetelling == 1)) selected @endif>オンライン占い</option>
                                    </select> --}}
                                    <div class="element-helper-indentify" style="color: #2a3242">※アカウント承認後の変更はできません。
                                    </div>
                                </div>

                                {{--teacher_category_consultation--}}
                                @php
                                    $ruleDisable = (old('teacher_category') != '' && old('teacher_category') != 'teacher_category_consultation') ||
                                        ($user->teacher_category_consultation != 1 && (!old('teacher_category') || old('teacher_category') != 'teacher_category_consultation'));
                                @endphp
                                <div id="teacher_category_consultation" class="@if($ruleDisable) d-none @endif">
                                    <div class="title-identify">
                                        {{ trans('labels.teacher_register.identifications.online_trouble_consultation') }}
                                        <span class="text-note-title">（サービス内容はメンタル面に限ります。）</span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center">
                                            <div class="title-identify title-identify--w3">{{ trans('labels.teacher_register.identifications.qualification') }}</div>
                                            <span class="element-require">{{ trans('labels.teacher_register.identifications.must_be_selected') }}</span>
                                        </div>
                                        <div class="d-flex ml-60">
                                            <label class="wrap-radio">
                                                <input @if((old('teacher_category') === 'teacher_category_consultation' && old('qualifications') === '1') || ((!old('qualifications') && !$ruleDisable) && $user->qualifications == 1 && $user->teacher_category_consultation == 1)) checked
                                                       @endif
                                                       @if($ruleDisable) disabled @endif type="radio"
                                                       name="qualifications" id="publishByName" value="1">
                                                <span class="label-title">あり</span>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="wrap-radio ml-35">
                                                <input @if((old('teacher_category') === 'teacher_category_consultation' && old('qualifications') === '0') || ((!old('qualifications') && !$ruleDisable) && $user->qualifications == 0 && $user->teacher_category_consultation == 1)) checked
                                                       @endif
                                                       @if($ruleDisable) disabled @endif type="radio"
                                                       name="qualifications" id="publishByNickname" value="0">
                                                <span class="label-title">なし</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        @if($errors->has('qualifications'))
                                            <small class="error element-helper-indentify error-qualification">
                                                {{ $errors->first('qualifications') }}
                                            </small>
                                        @endif
                                        <small class="d-none element-helper-indentify error-qualification">資格保有は、必ず指定してください。</small>
                                    </div>
                                    <div class="element-helper-indentify mt-1px"
                                         style="color: unset">{{ __('labels.teacher_register.identifications.helper_confirm') }}</div>
                                    <div class="d-flex verification-image-consultation @if((old('teacher_category') === 'teacher_category_consultation' && old('qualifications') === '0') || ((!old('qualifications') && !$ruleDisable) && $user->qualifications == 0 && $user->teacher_category_consultation == 1)) teacher-register-name-hidden @endif">
                                        <div class="sub-title">
                                            {{ trans('labels.teacher_register.identifications.identity_verification_image') }}
                                        </div>
                                        <div class="choose-img">
                                            <button class="btn fs-14 next" id="business-submit" type="button">
                                                {{ trans('labels.button.upload') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="teacher-register-name teacher-register-name-custom
                                    @if((old('teacher_category') === 'teacher_category_consultation' && old('qualifications') === '0') || ((!old('qualifications') && !$ruleDisable) && $user->qualifications == 0 && $user->teacher_category_consultation == 1)) teacher-register-name-hidden @endif">
                                        <div data-name="business_card" class="position-relative image-container">
                                            <input type="file" class="file" name="file" data-name="business_card"
                                                   accept="image/png, image/gif, image/jpeg">
                                            <img src="{{ asset((isset($user['imagePathType2']) && $user->teacher_category_consultation == 1) && !$ruleDisable ? $user['imagePathType2']->image_url : './assets/img/teacher-page/rectangle.png')}}"
                                                 id="business_card"
                                                 class="img-responsive {{ isset($user['imagePathType2']) && $user->teacher_category_consultation == 1 && !$ruleDisable ? 'img-contain' : '' }}"
                                                 alt="Image">
                                            <div class="position-absolute image-button @if(isset($user['imagePathType2']) && $user->teacher_category_consultation == 1 && !$ruleDisable) hidden @endif"
                                                 data-name="business_card"></div>
                                            @if(isset($user['imagePathType2']) && $user->teacher_category_consultation == 1 && !$ruleDisable)
                                                <span class="remove-item f-w3" data-name="business_card">
                                                <img src="/assets/img/clients/teacher/remove-img.svg" alt="">
                                            </span>
                                            @else
                                                <span class="remove-item f-w3 hidden" data-name="business_card">
                                                <img src="/assets/img/clients/teacher/remove-img.svg" alt="">
                                            </span>
                                            @endif
                                            <div class="element-helper-indentify d-none error-business_card">
                                                写真をお選びください
                                            </div>
                                        </div>
                                        @if($errors->has('file'))
                                            <small class="error element-helper-indentify error-qualification">
                                                {{ $errors->first('file') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                {{--teacher_category_fortunetelling--}}
                                @php
                                    $disabledFortune = (old('teacher_category') && old('teacher_category') != 'teacher_category_fortunetelling') ||
                                        (!old('teacher_category') && $user->teacher_category_fortunetelling != 1);
                                @endphp
                                <div id="teacher_category_fortunetelling" class="@if($disabledFortune) d-none @endif">
                                    {{-- <div class="title-identify">
                                        {{ trans('labels.teacher_register.identifications.online_fortune_telling') }}
                                    </div>
                                    <div class="d-flex verification-image">
                                        <div class="d-flex flex-column">
                                            <div class="element-helper-indentify element-helper-indentify--mt-0 w-mobile-170">{{ __('labels.teacher_register.identifications.helper_contract') }}</div>
                                            <div class="sub-title">
                                                {{ trans('labels.teacher_register.identifications.nondisclosure_agreement') }}
                                                <span class="element-require">{{ trans('labels.teacher_register.identifications.required') }}</span>
                                            </div>
                                        </div>
                                        <div class="choose-img">
                                            <button class="btn fs-14 next" id="nda-submit" @if((old('teacher_category') && old('teacher_category') != 'teacher_category_fortunetelling') || (!old('teacher_category') && $user->teacher_category_fortunetelling === 1)) disabled @endif type="button">
                                                {{ trans('labels.teacher_register.identifications.conclude') }}
                                            </button>
                                        </div>
                                        <input type="hidden" name="is_nda" class="is_nda">
                                    </div>
                                    @if($errors->has('is_nda'))
                                        <small class="error element-helper-indentify error-qualification error-nda">
                                            {{ $errors->first('is_nda') }}
                                        </small>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="confirm confirm--business">
                                <a href="{{ route('client.teacher.register.setting-account', $userId) }}"
                                   class="btn fs-14 back button">
                                    {{ trans('labels.button.back_step') }}
                                </a>
                                <button class="btn fs-14 next" type="submit">
                                    {{ trans('labels.button.next_step') }}
                                </button>
                            </div>
                        </div>
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
                if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value === 'teacher_category_consultation') {
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
                if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value === 'teacher_category_fortunetelling') {
                    $('#nda-submit').removeAttr('disabled');
                    $('#teacher_category_fortunetelling').removeClass('d-none');
                } else {
                    $('#nda-submit').attr('disabled', true);
                    $('#teacher_category_fortunetelling').addClass('d-none');
                }
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

        $('#publishByNickname').click(function () {
            $('.remove-item').trigger("click");
            $('.teacher-register-name-custom').addClass('teacher-register-name-hidden');
            $('.verification-image-consultation').addClass('teacher-register-name-hidden')
        });
        $('#publishByName').click(function () {
            $('.teacher-register-name').removeClass('teacher-register-name-hidden');
            $('.verification-image-consultation').removeClass('teacher-register-name-hidden')
        })
        $('#form').submit(function (e) {
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
    </script>
    <script src="{{ mix('js/clients/teachers/register/identification.js') }}"></script>
@endsection
