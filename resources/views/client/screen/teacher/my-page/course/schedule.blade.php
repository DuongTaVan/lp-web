@extends('client.base.base')
<style>
    .create-course-one .error {
        color: #EE3D48;
    }

    .ck.ck-icon *:not([fill]) {
        color: #2A3242;
    }

    .add-time-custom {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        max-width: 420px;
        width: 100%;
        height: 41px;
        border: 1px dashed #CECECE;
        border-radius: 2px;
        font-size: 14px;
        line-height: 21px;
        color: #2A3242;
        cursor: pointer;
        margin-bottom: 6px;
        margin-top: 10px;
    }

    .add-time-custom img {
        margin: 0 10.47px 0 16px;
    }

</style>
@section('content')
    <input type="hidden" id="max_extension" value="{{ $maxExtension ?? '' }}">
    <!-- CONTENT -->
    <div class="create-course-block">
        <form class="course" method="POST"
              id="form-course"
              action="{{ route('client.teacher.course_schedules.update', [$courseSchedule->course_schedule_id, 'isPublic'=> Request::get('isPublic')]) }}"
              enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="screen" value="{{ (int)$subCourse }}">
            <input type="hidden" id="course_schedule_id" value="{{ $courseSchedule->course_schedule_id }}">
            <div class="course__nav">
                <div class="course__nav__value">
                    <div class="f-w6">サービスを編集する</div>
                </div>
            </div>
            <div class="course__content">
                @if (!$subCourse)
                    {{-- category --}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label align-items-center f-w6">
                            <p class="f-w6">カテゴリー</p>
                        </div>
                        <div class="wrap-item__value">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="wrap-item__value__label">
                                    @if(auth()->guard('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                                        教えて！ライブ配信
                                    @elseif(auth()->guard('client')->user()->teacher_category_consultation ===  \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION)
                                        オンライン悩み相談
                                    @else
                                        オンライン占い
                                    @endif
                                </span>
                                <div class="wrap-item__value__select select-parent">
                                    <span class="wrap-item__value__category">{{ $category->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- face mask--}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label d-flex align-items-center">
                            <p class="f-w6">顔出し</p>
                        </div>
                        <div class="wrap-item__value face-mask">
                            <div class="wrap-border d-flex align-content-center align-items-center">
                                <div
                                        class="wrap-item__value__select select-parent wrap-item__value__select--usage-time select-parent custom-face-mask">
                                    <div class="select">
                                        <input type="hidden" class="select__value-item f-w3" readonly
                                               value="{{ (int)(old('is_mask_required') ?? $course->is_mask_required) === 0 ? '顔出し(OK)' : '顔出し(NG)' }}"/>
                                        <div class="is-mask-required select__value-item" id="maskOption">
                                            {!! (int)(old('is_mask_required') ?? $courseSchedule->is_mask_required) === 0 ? '顔出し(<span>OK</span>)' : '<div><div class="option-mask">顔出し(<span>NG</span>)</div><div class="lappi-ai p-0">※Lappi ARエフェクト使用</div></div>' !!}
                                        </div>
                                        <input type="hidden"
                                               value="{{ (int)(old('is_mask_required') ?? $course->is_mask_required) === 0 ? 0 : 1 }}"
                                               name="is_mask_required"
                                               class="hidden_input hidden_input-is-mask">
                                        <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                             class="arrow-down hide-mobile"
                                             alt=""/>
                                        <div class="select__options">
                                            <div class="select__item f-w3 select-parent-item" data-minute="0">
                                                <div class="option-mask">
                                                    顔出し(<span>OK</span>)
                                                </div>
                                            </div>
                                            <div
                                                    class="select__item f-w3 select-parent-item pr-0 flex-column align-items-baseline item-ng"
                                                    data-minute="1">
                                                <div class="option-mask">顔出し(<span>NG</span>)</div>
                                                <div class="lappi-ai p-0">※Lappi ARエフェクト使用</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error fs-12 error-is_mask_required">
                                        @error('is_mask_required')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <span class="wrap-item__value__required">※選択必須</span>
                            </div>
                        </div>
                    </div>

                    {{-- course schedule --}}
                    <div class="wrap-item box-large d-flex">
                        <div class="wrap-item__label">
                            <p class="f-w6 text-required">開催日時</p>
                        </div>
                        <div class="wrap-item__value wrap-container">
                            <div class="f-w3" id="list-wrap-time">
                                <div class="wrap-time wrap-time-select">
                                    <div class="d-flex">
                                        <div class="wrap-time__date datetimepicker">
                                            <input type="text" name="start_day" data-input
                                                   data-format="Y/m/d"
                                                   value="{{ old('start_day') ?? now()->parse($courseSchedule['start_datetime'])->format('Y/m/d') }}"
                                                   autocomplete="off">
                                            <img class="img-date"
                                                 src="{{ url('/assets/img/clients/teacher/date-picker.svg') }}"
                                                 alt="" data-toggle>
                                        </div>
                                        <div class="wrap-time__time datetimepicker">
                                            <input type="text" name="start_time" data-input
                                                   data-datepicker="false" data-format="H:i"
                                                   value="{{ old('start_time') ?? now()->parse($courseSchedule['start_datetime'])->format('H:i') }}"
                                                   autocomplete="off">
                                            <img class="img-time"
                                                 src="{{ url('/assets/img/clients/teacher/time-picker.svg') }}"
                                                 alt="" data-toggle>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="error fs-12 error-start_day">
                                @if($errors->has('start_day.*'))
                                    @error('start_day.*')
                                    {{ $message }}
                                    @enderror
                                @elseif($errors->has('start_day'))
                                    @error('start_day')
                                    {{ $message }}
                                    @enderror
                                @endif
                            </div>
                            <small>※締切日には開催日が表示されます</small>
                        </div>
                    </div>

                    {{-- minute required course--}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label d-flex">
                            <p class="f-w6 text-required">ご利用時間</p>
                        </div>
                        <div class="wrap-item__value">
                            <div class="wrap-border">
                                @php
                                    $dataMinutes = auth('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS ? \App\Enums\Constant::LIST_MINUTE_REQUIRED : \App\Enums\Constant::LIST_MINUTE_REQUIRED_VIDEO_CALL;
                                @endphp
                                @include('client.screen.teacher.my-page.select_custom_common',
                                [
                                    'value' => $dataMinutes,
                                    'name' => 'minutes_required',
                                    'valueDefault' => old('minutes_required') ?? $courseSchedule->minutes_required ?? null,
                                    'className' => "wrap-item__value__select select-parent wrap-item__value__select--usage-time select-parent"
                                ])
                                <div class="error minutes_required">
                                    @error('minutes_required')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Admission fee --}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label">
                            <p class="f-w6 text-required">入場料</p>
                        </div>
                        <div class="wrap-item__value">
                            ¥<input type="text" class="f-w3 input-small auto-money" placeholder=""
                                    value="{{ old('price') ?? $courseSchedule->price}}"
                                    name="price" inputmode="numeric" maxlength="11">
                            <div class="error fs-12 error-price">
                                @error('price')
                                {{ $message }}
                                @enderror
                            </div>
                            @if(auth('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                                <small>※￥1,000〜¥5,000以内でしか入力ができません。</small>
                            @else
                                <small>※￥1,000以上からで入力して下さい。</small>
                            @endif
                        </div>
                    </div>

                    {{-- title --}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label d-flex flex-column">
                            <p class="f-w6 text-required">タイトル</p>
                            <span class="f-w3">(70文字以内)</span>
                        </div>
                        @if ($courseSchedule->course->dist_method === \App\Enums\DBConstant::DIST_METHOD_LIVE_STREAMING)
                            <div class="wrap-item__value">
                                <div class="step-2-title">{{ $courseSchedule->title }}</div>
                                <input type="hidden" name="title" value="{{ $courseSchedule->title }}">
                            </div>
                        @else
                            <div class="wrap-item__value">
                                <input type="text" class="f-w3 placehoder-color" name="title"
                                       placeholder="（例）現役大手商社マンが教える就活必勝テクニック！"
                                       value="{{ old('title') ?? $courseSchedule->title ?? "" }}">
                                <div class="error error-title">
                                    @error('title')
                                    {{ $message }}
                                    @enderror
                                </div>
                                <div class="f-w3 d-flex justify-content-between align-items-center note-text">
                                    <span class="wrap-item__value__note"></span>
                                    <span class="wrap-item__value__count">70</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- image --}}
                    <div class="wrap-item box-large d-flex">
                        <div class="wrap-item__label d-flex flex-column">
                            <p class="f-w6 text-required">画像</p>
                            <span class="f-w3">(最大４枚)</span>
                        </div>
                        <div class="wrap-item__value">
                            <div class="f-w3 d-flex justify-content-between align-items-center preview-box">
                                <div id="list-img" class="d-flex">
                                    @if (session()->has('preview_file_' . auth('client')->id()))
                                        @foreach(session('preview_file_' . auth('client')->id()) as $item)
                                            <div class="preview">
                                                <input type="hidden" name="previewOld[]"
                                                       value="{{ json_encode($item) }}">
                                                <div class="remove-img" style="display: flex;">
                                                    <img src="{{ url('/assets/img/clients/teacher/remove.svg') }}"
                                                         alt="">
                                                </div>
                                                <span>
                                                <img class="preview-img" src="{{ $item['fullPath'] }}">
                                            </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <p class="note-upload-img f-w6">※画像推奨サイズは１２７０X８５０ <br>　１ファイル最大５MB</p>
                            <div class="error error-preview fs-12 image-box-error">
                                @error('preview')
                                {{ $message }}
                                @enderror
                                @error('preview.*')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Title supplementary explanation --}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label d-flex flex-column">
                            <p class="f-w6 text-required">タイトル補足説明</p>
                            <span class="f-w3">(100文字以内)</span>
                        </div>

                        <div class="wrap-item__value">
                        <textarea name="subtitle" id="subtitle"
                                  placeholder="（例）商社志望の方必見です！現役大手商社マンだから言える内定獲得までの全てを教えます。">{{ old('subtitle') ?? $courseSchedule->subtitle ?? "" }}</textarea>
                            <div class="error error-subtitle fs-12">
                                @error('subtitle')
                                {{ $message }}
                                @enderror
                            </div>
                            <div class="f-w3 d-flex justify-content-between align-items-center">
                                <span class="wrap-item__value__note"></span>
                                <span class="wrap-item__value__count">100</span>
                            </div>
                        </div>
                    </div>

                    {{-- about content --}}
                    <div class="wrap-item box-large d-flex">
                        <div class="wrap-item__label d-flex flex-column">
                            <p class="f-w6 text-required">サービス内容</p>
                            <span class="f-w3">(1000文字以内)</span>
                        </div>
                        <div class="wrap-item__value">
                        <textarea name="body" id="body"
                                  placeholder="※具体的なサービスの詳細を記入してください">{!! old('body') ?? $courseSchedule->body ?? "" !!}</textarea>
                            <div class="error error-body fs-12">
                                @error('body')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- flow of the day --}}
                    <div class="wrap-item box-large d-flex">
                        <div class="wrap-item__label d-flex flex-column">
                            <p class="f-w6 text-required">当日の流れ</p>
                            <span class="f-w3">(1000文字以内)</span>
                        </div>
                        <div class="wrap-item__value">
                        <textarea name="flow" id="flow" placeholder="（例）
                        ・自己紹介
                        ・予定終了時間の確認
                        ・配信画面の説明　（使い方・ご利用方法）
                        ・サービス開始
                        ・お時間が来ましたら自動で配信が終わります"
                        >{!! old('flow') ?? $courseSchedule->flow ?? "" !!}</textarea>
                            <div class="error error-flow fs-12">
                                @error('flow')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- before using --}}
                    <div class="wrap-item box-large d-flex">
                        <div class="wrap-item__label d-flex flex-column">
                            <p class="f-w6 text-required">ご利用に当たって</p>
                            <span class="f-w3">(1000文字以内)</span>
                        </div>
                        <div class="wrap-item__value">
                        <textarea name="cautions" id="cautions" placeholder="（例）
                        【必ずお読みください】
                        ご購入された場合は以下をご同意いただきます。
                        ・配信が自動スタートしますので遅刻をしても終了時間を変更する事はできません
                        ・ユーザー様の都合での配信不備や不具合は当方は対応できません"
                        >{!! old('cautions') ?? $courseSchedule->cautions ?? "" !!}</textarea>
                            <div class="error error-cautions fs-12">
                                @error('cautions')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if ($category->type !== \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                        <p class="extension-request-title f-w6">※オプション設定</p>
                        {{-- extension request --}}
                        <div id="wrap-item box-large d-flex">
                            <div class="wrap-item d-flex box-large">
                                <div class="wrap-item__label">
                                    <p class="f-w6">延長リクエスト</p>
                                    <small class="f-w3">※配信中に画面に表示されます。</small>
                                </div>
                                <div id="wrap-list-extension" class="wrap-item__value">
                                    <span class="wrap-item__value__title f-w3">※既に販売されているサービスに、延長した時間が重複する事は可能です。その場合、重複した時間のサービスはキャンセルされます。</span>
                                    <div id="list-extension-request">
                                        @php
                                            $time = [];
                                            $price = [];
                                            $time = old('time') ?? $time;
                                            $courseScheduleStatus = $courseSchedule->status;
                                            $price = old('money') ?? $price;
                                            if (!count($time) || !count($price)) {
                                                 foreach ($course->extensionsOpen as $item) {
                                                     if ($courseScheduleStatus === \App\Enums\DBConstant::COURSE_STATUS_OPEN) {
                                                        if ((int)$item->status === \App\Enums\DBConstant::COURSE_STATUS_OPEN) {
                                                            $time[] = $item->minutes_required;
                                                            $price[] = $item->price;
                                                        }
                                                     } elseif ((int)$item->status !== \App\Enums\DBConstant::COURSE_STATUS_OPEN) {
                                                         $time[] = $item->minutes_required;
                                                         $price[] = $item->price;
                                                     }
                                                 }
                                            }
                                        @endphp
                                        @if(count($time) && count($price))
                                            @foreach($time as $i => $item)
                                                <div class="wrap-item__value__extension-request">
                                                    <div class="d-flex">
                                                        <div
                                                                class="wrap-item__value__select extension-request__select extension-request__select--money select-parent">
                                                            <div class="select">
                                                                <input type="text" class="select__value-item f-w3"
                                                                       readonly
                                                                       value="{{ $item . ' 分' }}"
                                                                       placeholder="時間">
                                                                <input type="hidden" name="time[]"
                                                                       class="hidden_input f-w3"
                                                                       readonly value="{{ $item }}">
                                                                <img
                                                                        src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                                                        class="arrow-down" alt="">
                                                                <div class="select__options">
                                                                    <div class="select__item f-w3 select-parent-item"
                                                                         data-minute="15">15 分
                                                                    </div>
                                                                    <div class="select__item f-w3 select-parent-item"
                                                                         data-minute="20">20 分
                                                                    </div>
                                                                    <div class="select__item f-w3 select-parent-item"
                                                                         data-minute="30">30 分
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                                class="extension-request__select select-parent">
                                                            <span class="money-icon">¥</span>
                                                            <input
                                                                    type="text"
                                                                    name="money[]"
                                                                    class="select__value-item f-w3 select__value-item__custom auto-money"
                                                                    value="{{ $price[$i] }}" placeholder="金額"
                                                                    maxlength="15"
                                                            >
                                                            <small>※￥1,000以上からで入力して下さい。</small>
                                                        </div>
                                                    </div>
                                                    <span class="remove f-w3">削除する</span>
                                                </div>
                                            @endforeach
                                        @else
                                            @if(\App\Enums\DBConstant::MAX_EXTENSION - count($course->allExtensions) === 0)
                                                <div class="f-w3 add-time-custom" style="display: flex !important;">
                                                    <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}"
                                                         alt="">
                                                    延長リクエストを追加する（あと0件)
                                                </div>
                                            @else
                                                <div class="wrap-item__value__extension-request">
                                                    <div class="d-flex">
                                                        @php
                                                            $dataMinutes = [
                                                                15 => "15 分",
                                                                20 => "20 分",
                                                                30 => "30 分",
                                                            ]
                                                        @endphp
                                                        @include('client.screen.teacher.my-page.select_custom_common',
                                                        [
                                                            'value' => $dataMinutes,
                                                            'name' => 'time[]',
                                                            'valueDefault' => null,
                                                            'placeholder' => '時間',
                                                            'className' => "wrap-item__value__select extension-request__select extension-request__select--money select-parent"
                                                        ])
                                                        <div
                                                                class="extension-request__select select-parent">
                                                            <span class="money-icon">¥</span>
                                                            <input
                                                                    type="text"
                                                                    name="money[]"
                                                                    class="select__value-item f-w3 select__value-item__custom auto-money"
                                                                    value="" placeholder="金額" maxlength="15"
                                                            >
                                                            <small>※￥1,000以上からで入力して下さい。</small>
                                                        </div>
                                                    </div>
                                                    <span class="remove f-w3">削除する</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    @if(old('time'))
                                        @if(count(old('time')) < \App\Enums\DBConstant::MAX_EXTENSION)
                                            <div class="add-extension f-w3">
                                                <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                                延長リクエストを追加する（あと2件)
                                            </div>
                                        @endif
                                    @else
                                        @if(\App\Enums\DBConstant::MAX_EXTENSION - count($course->allExtensions) > 0)
                                            <div class="add-extension f-w3">
                                                <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                                延長リクエストを追加する（あと2件)
                                            </div>
                                        @else
                                            <div class="add-extension f-w3" style="display: none">
                                            </div>
                                        @endif

                                    @endif
                                    <small>※画面には3件まで表示できます。</small>
                                    <div class="error error-money">
                                        @if($errors->has('money.*'))
                                            @error('money.*')
                                            {{ $message }}
                                            @enderror
                                        @elseif($errors->has('time.*'))
                                            @error('time.*')
                                            {{ $message }}
                                            @enderror
                                        @elseif($errors->has('time'))
                                            @error('time')
                                            {{ $message }}
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($category->type === \App\Enums\DBConstant::CATEGORY_TYPE_FORTUNETELLING)
                            {{-- --------ADD OPTION------- --}}
                            <div id="wrap-item box-large d-flex" class="box-large">
                                <div class="wrap-item d-flex">
                                    <div class="wrap-item__label">
                                        <p class="f-w6 text-nowrap">有料オプション</p>
                                        <span class="text-nowrap">(各60文字以内)</span>
                                        <small class="f-w3 text-nowrap">※配信中に画面に表示されます。</small>
                                    </div>
                                    <div id="wrap-list-option" class="wrap-item__value">
                                        <div id="list-option-request">
                                            @if(old('extra_title') && old('extra_price'))
                                                @for($i = 0; $i <count(old('extra_title')); $i ++)
                                                    <div class="wrap-item__value__option-request">
                                                        <div class="d-flex justify-content-between extra-price">
                                                            <div class="enter-option">
                                                                <input type="text" class="f-w3 enter-option"
                                                                       placeholder="オプションを入力する"
                                                                       name="extra_title[]"
                                                                       value="{{ old('extra_title')[$i] }}"
                                                                >
                                                                <div
                                                                        class="f-w3 d-flex justify-content-between align-items-center">
                                                        <span class="wrap-item__value__note">
                                                            <span class="remove-option f-w3">
                                                                削除する
                                                            </span>
                                                        </span>
                                                                    <span class="wrap-item__value__count">60 </span>
                                                                </div>
                                                            </div>

                                                            <div class="enter-option--small__custom">
                                                                <span>¥</span>
                                                                <input type="text" class="f-w3 enter-option--small"
                                                                       value="{{ old('extra_price')[$i] }}"
                                                                       name="extra_price[]" maxlength="15"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @elseif($courseSchedule->optionalExtras->count())
                                                @foreach($courseSchedule->optionalExtras as $optionExtra)
                                                    <div class="wrap-item__value__option-request">
                                                        <div class="d-flex justify-content-between extra-price">
                                                            <div class="enter-option">
                                                                <input type="text" class="f-w3 enter-option"
                                                                       placeholder="オプションを入力する"
                                                                       name="extra_title[]"
                                                                       value="{{ $optionExtra['title'] }}"
                                                                >
                                                                <div
                                                                        class="f-w3 d-flex justify-content-between align-items-center">
                                                        <span class="wrap-item__value__note">
                                                            <span class="remove-option f-w3">
                                                                削除する
                                                            </span>
                                                        </span>
                                                                    <span class="wrap-item__value__count">60 </span>
                                                                </div>
                                                            </div>

                                                            <div class="enter-option--small__custom">
                                                                <span>¥</span>
                                                                <input type="text" class="f-w3 enter-option--small"
                                                                       value="{{ $optionExtra['price'] }}"
                                                                       name="extra_price[]" maxlength="15"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="wrap-item__value__option-request wrap-container">
                                                    <div class="d-flex justify-content-between extra-price">
                                                        <div class="enter-option">
                                                            <input type="text" class="f-w3 enter-option"
                                                                   placeholder="オプションを入力する"
                                                                   name="extra_title[]"
                                                            >
                                                            <div
                                                                    class="f-w3 d-flex justify-content-between align-items-center">
                                                    <span class="wrap-item__value__note">
                                                        <span class="remove-option f-w3">
                                                            削除する
                                                        </span>
                                                    </span>
                                                                <span class="wrap-item__value__count">60 </span>
                                                            </div>
                                                        </div>
                                                        <div class="enter-option--small__custom">
                                                            <span>¥</span>
                                                            <input type="text" class="f-w3 enter-option--small"
                                                                   placeholder=""
                                                                   name="extra_price[]" maxlength="15"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="error error-extra_title">
                                                        @error('extra_title')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                    <div class="error">
                                                        @error('extra_title.*')
                                                        {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="error error-extra_title">
                                            @error('extra_title')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="error error-extra_title">
                                            @error('extra_title.*')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="error error-extra_price">
                                            @error('extra_price.*')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="error error-extra_price">
                                            @error('extra_price')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="add-option f-w3">
                                            <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                            オプションを追加する（あと{{ count($courseSchedule->optionalExtras) ? 5 - count($courseSchedule->optionalExtras) : 4 }}
                                            件)
                                        </div>
                                        <small>※画面には５件まで表示できます。</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @else
                    <div id="setting-request">
                        <div class="optional-setting__wrap">
                            <div class="optional-setting__item d-flex">
                                <div class="optional-setting__item__label">
                                    <p class="f-w6 mb-0">受講者限定サービス！</p>
                                    <span class="f-w3">配信中に画面に表示されます。</span>
                                </div>
                                <div class="optional-setting__item__value optional-setting__item__value--first">
                                    <label class="f-w6">個別講座（ビデオ通話）</label>
                                    <small>※１対１のビデオ通話の講座になります。</small>
                                </div>
                            </div>
                            <div class="optional-setting__item d-flex">
                                <div class="optional-setting__item__label">
                                    <p class="f-w6 mb-0">タイトル <span style="color: #EE3D48;
                                                                font-size: 12px;
                                                                line-height: 25px;
                                                                font-weight: normal;
                                                                margin-left: 5px;
                                                                display: inline-block;">※必須</span></p>
                                    <span style="color: unset">(70文字以内)</span>
                                </div>
                                <div class="optional-setting__item__value optional-setting__item__value--first">
                                    <label class="f-w6">{{ $courseSchedule->title }}</label>
                                </div>
                            </div>
                            <div class="optional-setting__item d-flex">
                                <div class="optional-setting__item__label">
                                    <p class="f-w6">開催日時</p>
                                </div>
                                <div class="wrap-item__value wrap-container">
                                    <div class="f-w3" id="list-wrap-time">
                                        <div class="wrap-time wrap-time-select">
                                            <div class="d-flex">
                                                <div class="wrap-time__date datetimepicker">
                                                    <input type="text" name="start_day" data-input
                                                           data-format="Y/m/d"
                                                           value="{{ old('start_day') ?? now()->parse($courseSchedule['start_datetime'])->format('Y/m/d') }}"
                                                           autocomplete="off">
                                                    <img class="img-date"
                                                         src="{{ url('/assets/img/clients/teacher/date-picker.svg') }}"
                                                         alt="" data-toggle>
                                                </div>
                                                <div class="wrap-time__time datetimepicker">
                                                    <input type="text" name="start_time" data-input
                                                           data-datepicker="false" data-format="H:i"
                                                           value="{{ old('start_time') ?? now()->parse($courseSchedule['start_datetime'])->format('H:i') }}"
                                                           autocomplete="off">
                                                    <img class="img-time"
                                                         src="{{ url('/assets/img/clients/teacher/time-picker.svg') }}"
                                                         alt="" data-toggle>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="error fs-12 error-start_day">
                                        @if($errors->has('start_day.*'))
                                            @error('start_day.*')
                                            {{ $message }}
                                            @enderror
                                        @elseif($errors->has('start_day'))
                                            @error('start_day')
                                            {{ $message }}
                                            @enderror
                                        @endif
                                    </div>
                                    <small>※締切日には開催日が表示されます</small>
                                </div>
                            </div>
                            <div class="optional-setting__item d-flex">
                                <div class="optional-setting__item__label">
                                    <p class="f-w6">ご利用時間</p>
                                </div>
                                <div class="wrap-item__value">
                                    <div class="wrap-border">
                                        @php
                                            $dataMinutes = \App\Enums\Constant::LIST_SUB_MINUTE_REQUIRED;
                                        @endphp
                                        @include('client.screen.teacher.my-page.select_custom_common',
                                        [
                                            'value' => $dataMinutes,
                                            'name' => 'minutes_required',
                                            'valueDefault' => old('minutes_required') ?? $courseSchedule->minutes_required ?? null,
                                            'className' => "wrap-item__value__select select-parent wrap-item__value__select--usage-time select-parent"
                                        ])
                                        <div class="error error-minutes_required">
                                            @error('minutes_required')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="optional-setting__item d-flex">
                                <div class="optional-setting__item__label">
                                    <p class="f-w6">料金</p>
                                </div>
                                <div class="optional-setting__item__value">¥
                                    @if (isset($courseSession['price']))
                                        <input
                                                type="text"
                                                class="f-w3 input-small auto-money"
                                                placeholder=""
                                                value="{{ $courseSession['price'] }}"
                                                maxlength="15"
                                                name="price">
                                    @else
                                        <input
                                                type="text"
                                                class="f-w3 input-small auto-money"
                                                placeholder=""
                                                value="{{ old('price', $courseSchedule->price) }}"
                                                maxlength="15"
                                                name="price">
                                    @endif
                                    <div class="error fs-12 error-price">
                                        @error('price')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                    <small class="line-bottom">※￥1,000以上からで入力して下さい。</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="d-flex wrap-submit justify-content-center action-button">
                    <div class="preview-zone">
                        <i></i>
                    </div>
                    <div class="back-container">
                        @php
                            parse_str(parse_url(url()->previous())['query'] ?? '', $param)
                        @endphp
                        <a href="{{ route('client.teacher.my-page.service-list', ['tab' => ($param['tab'] ?? '') === 'draft' ? 'draft' : '']) }}"
                           type="button" class="back">戻る</a>
                    </div>
                    <div class="save-container">
                        @if (!$subCourse && (int)Request::get('isPublic') != 1)
                            <button type="submit" name="status"
                                    value="{{ \App\Enums\DBConstant::COURSE_STATUS_DRAFT }}"
                                    class="save-draft f-w6">{{ __('labels.button.draft_course') }}</button>
                        @endif
                        <button type="hidden" name="status" style="display: none" id="btn-submit" value="{{ \App\Enums\DBConstant::COURSE_STATUS_OPEN }}"></button>
                        @if(!$subCourse)
                                <button type="button" name="status"
                                        id="preview-course"
                                        value="{{ $subCourse ? \App\Enums\DBConstant::COURSE_STATUS_OPEN : \App\Enums\DBConstant::COURSE_STATUS_PREVIEW }}"
                                        class="confirm f-w6">{{ __(!$subCourse ? 'labels.button.preview_course' : 'labels.button.open_course') }}</button>
                        @else
                                <button type="submit" name="status"
                                        value="{{ \App\Enums\DBConstant::COURSE_STATUS_OPEN }}"
                                        class="confirm f-w6">{{ __(!$subCourse ? 'labels.button.preview_course' : 'labels.button.open_course') }}</button>
                        @endif
                    </div>
                    <div class="next-zone active">
                        <i></i>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal fade" id="optionMaskModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog option-mask-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="button-close-option-mask">
                            <img src="{{asset('assets/img/icons/close-option-mask-modal.svg')}}" alt=""
                                 data-dismiss="modal">
                        </div>
                        <div class="option-mask-content">
                            <a class="option-text1">顔出し(<span>OK</span>) </a>
                            <a class="option-text2 pb-0">顔出し(<span>NG</span>)</a>
                            <span class="note-ng">※Lappi ARエフェクト使用</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="preview-container"></div>
@endsection
@section('script')
    <script src="{{ mix('js/clients/teachers/create-course-one.js') }}"></script>
    <script src="{{ mix('js/clients/teachers/preview-course-schedule.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('css/clients/modules/teacher/create_course.css')  }}"/>
@endsection

<style>
    .ck-reset {
        display: flex;
        flex-direction: column-reverse;
    }

    .ck-toolbar {
        background: #FFFFFF !important;
        border: 1px solid #ECECEC !important;
        border-bottom-right-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-top: none !important;
    }

    .ck-editor__main {
        height: 137px;
        border-color: #ECECEC;
    }

    .ck-content {
        height: 100%;
        border: 1px solid #ECECEC !important;
        border-top-right-radius: 5px !important;
        border-top-left-radius: 5px !important;
        border-bottom: none !important;
        font-size: 14px;
        color: #2A3242;
    }

    .ck-placeholder {
        white-space: pre-line;
    }

    .ck-editor__top {
    }

    @media (max-width: 767px) {
        .ck-editor__main {
            height: 165px;
            border-color: #ECECEC;
        }

        .ck-placeholder {
            white-space: pre-line;
            font-size: 13px;
        }
    }

    @media (max-width: 320px) {
        .ck-editor__main {
            height: 185px;
            border-color: #ECECEC;
        }
    }
</style>
