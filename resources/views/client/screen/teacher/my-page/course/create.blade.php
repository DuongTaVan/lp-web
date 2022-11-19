@extends('client.base.base')
<style>
    .create-course-one .error {
        color: #EE3D48;
    }

    .ck.ck-icon *:not([fill]) {
        color: #2A3242;
    }
</style>
@section('content')
    <div class="create-course-block">
        <form class="course" method="post" action="{{ route('client.teacher.courses.store') }}"
              id="form-course"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="screen" value="{{ $screen }}">
            <input type="hidden" name="parent_course_id" value="{{ $course->course_id ?? null }}">
            <input type="hidden" id="max_course" value="{{ \App\Enums\DBConstant::MAX_COURSE_SCHEDULE }}">
            <div class="course__nav">
                <div class="course__nav__value">
                    <div class="f-w6">新規サービスの作成</div>
                </div>
            </div>
            <div class="course__content">
                @if ($category === \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                    <label class="notice f-w6">{{ trans('labels.create_course.course1.notice_create') }}</label>
                    @include('client.screen.teacher.my-page.create_course.header-create', ['step' => 1])
                    @include('client.payment.process-payment-circle', ['step' => "STEP 1", 'title' => 'サービスを作成し公開を申請する', 'deg' => 120, 'size' => '76'])
                @endif
                {{-- category --}}
                <div class="wrap-item box-min d-flex">
                    <div class="wrap-item__label align-items-center f-w6">
                        <p class="f-w6">カテゴリー</p>
                    </div>
                    <div class="wrap-item__value position-relative">
                        <div class="mobile-device d-flex justify-content-between align-items-center">
                            <span class="wrap-item__value__label f-w6">
                                @if ($category === \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                                    教えて！ライブ配信
                                @elseif ($category === \App\Enums\DBConstant::CATEGORY_TYPE_CONSULTATION)
                                    オンライン悩み相談
                                @else
                                    オンライン占い
                                @endif
                            </span>
                            @if ($qualifications)
                                <div class="wrap-item__value__select select-parent">
                                    <span class="wrap-item__value__category">{{ $qualifications->name }}</span>
                                    <input type="hidden" name="category_id" value="{{ $qualifications->category_id }}">
                                </div>
                            @else
                                <div class="wrap-item__value__select select-parent w-100">
                                    <div class="select">
                                        <input type="text" id="category" name="category" class="select__value-item f-w3"
                                               readonly placeholder="サブカテゴリを選択してください。"
                                               value="{{ old('category') ?? $course->category->name ?? '' }}">
                                        <input type="hidden" name="category_id" class="hidden_input" id="category-id"
                                               value="{{ old('category_id') ?? $course->category->category_id ?? '' }}">
                                        <img src="{{ url('/assets/img/clients/auth/arow-down.svg') }}"
                                             class="arrow-down"
                                             alt="">
                                        <div class="select__options">
                                            @foreach($categories as $item)
                                                <div class="select__item f-w3 select-parent-item category-select"
                                                     data-minute="{{ $item->category_id }}">
                                                    {{ $item->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($category === \App\Enums\DBConstant::CATEGORY_TYPE_CONSULTATION)
                                        <span style="color: #EE3D48; font-weight: bold">※サービス内容はメンタル面に限ります。</span>
                                    @endif
                                </div>
                                <span class="wrap-item__value__required wrap-item__value__required--category">※選択必須</span>
                            @endif
                        </div>
                        <div class="error error-category_id">
                            @error('category_id')
                            {{ $message }}
                            @enderror
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
                                           value=""/>
                                    <div class="is-mask-required select__value-item" id="maskOption">
                                        {!! old('is_mask_required') == 0 ? '顔出し(<span>OK</span>)' : '<div><div class="option-mask">顔出し(<span>NG</span>)</div><div class="lappi-ai p-0">※Lappi ARエフェクト使用</div></div>' !!}
                                    </div>
                                    <input type="hidden"
                                           value="{{ old('is_mask_required') ?? $course->is_mask_required ?? 0 }}"
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
                                <div class="error error-is_mask_required">
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
                    <div class="wrap-item__value">
                        @if($category === \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                            <div class="no-accept">
                                新規サービスを申請し承認後に設定ができます。
                            </div>
                        @else
                            <div class="f-w3" id="list-wrap-time">
                                @php
                                    $date = [];
                                    $time = [];
                                    if (isset($startDay) && isset($startTime)) {
                                        $date = $startDay;
                                        $time = $startTime;
                                    }
                                    $date = old('start_day') ?? $date;
                                    $time = old('start_time') ?? $time;
                                @endphp
                                @if(count($date) !== 0)
                                    @foreach($date as $i => $item)
                                        <div class="wrap-time wrap-time-select">
                                            <div class="d-flex">
                                                <div class="wrap-time__date datetimepicker">
                                                    <input type="text" name="start_day[]" data-input
                                                           data-format="Y/m/d"
                                                           value="{{ $date[$i] }}" autocomplete="off">
                                                    <img class="img-date"
                                                         src="{{ url('/assets/img/clients/teacher/date-picker.svg') }}"
                                                         alt="" data-toggle>
                                                </div>
                                                <div class="wrap-time__time datetimepicker">
                                                    <input type="text" name="start_time[]" data-input
                                                           data-datepicker="false" data-format="H:i"
                                                           value="{{ $time[$i] }}" autocomplete="off">
                                                    <img class="img-time"
                                                         src="{{ url('/assets/img/clients/teacher/time-picker.svg') }}"
                                                         alt="" data-toggle>
                                                </div>
                                            </div>
                                            <span class="remove-item f-w3">
                                                削除する
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="wrap-time wrap-time-select">
                                        <div class="d-flex">
                                            <div class="wrap-time__date datetimepicker">
                                                <input type="text" name="start_day[]" data-input
                                                       data-format="Y/m/d" autocomplete="off">

                                                <img class="img-date"
                                                     src="{{ url('/assets/img/clients/teacher/date-picker.svg') }}"
                                                     alt="" data-toggle>
                                            </div>
                                            <div class="wrap-time__time datetimepicker">
                                                <input type="text" name="start_time[]" data-input
                                                       data-datepicker="false" data-format="H:i" autocomplete="off">
                                                <img class="img-time"
                                                     src="{{ url('/assets/img/clients/teacher/time-picker.svg') }}"
                                                     alt="" data-toggle>
                                            </div>
                                        </div>
                                        <span class="remove-item f-w3">削除する</span>
                                    </div>
                                @endif
                            </div>
                            @if(old('start_day'))
                                <div
                                        class="add-time f-w3 reset-datetimepicker {{ count(old('start_day')) == \App\Enums\DBConstant::MAX_COURSE_SCHEDULE ? 'd-none' : '' }}">
                                    <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                    開催日時を追加する（あと9件)
                                </div>
                            @else
                                <div class="add-time f-w3 reset-datetimepicker">
                                    <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                    開催日時を追加する（あと9件)
                                </div>
                                <small>※締切日には開催日が表示されます</small>
                            @endif
                            <div class="error fs-12 error-start-datetime error-start_day">
                                @if($errors->has('start_day.*') || $errors->has('start_time.*'))
                                    スケジュール、必ず入力してください。
                                @elseif($errors->has('start_day'))
                                    @error('start_day')
                                    {{ $message }}
                                    @enderror
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @if ($category !== \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
                    {{-- minute required course--}}
                    <div class="wrap-item box-min d-flex">
                        <div class="wrap-item__label d-flex">
                            <p class="f-w6 text-required">ご利用時間</p>
                        </div>
                        <div class="wrap-item__value">
                            <div class="wrap-border">
                                @php
                                    $dataMinutes = auth()->guard('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS ? \App\Enums\Constant::LIST_MINUTE_REQUIRED : \App\Enums\Constant::LIST_MINUTE_REQUIRED_VIDEO_CALL;
                                @endphp

                                @include('client.screen.teacher.my-page.select_custom_common',
                                [
                                    'value' => $dataMinutes,
                                    'name' => 'minutes_required',
                                    'valueDefault' => null,
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
                @endif

                {{-- price --}}
                <div class="wrap-item box-min d-flex">
                    <div class="wrap-item__label">
                        <p class="f-w6 text-required">入場料</p>
                    </div>
                    <div class="wrap-item__value">
                        ¥<input type="text" class="f-w3 input-small auto-money" placeholder=""
                                value="{{ old('price') ?? $course->price ?? "" }}"
                                name="price" inputmode="numeric" maxlength="11">
                        @if(auth('client')->user()->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                            <small>※￥1,000〜¥5,000以内でしか入力ができません。</small>
                        @else
                            <small>※￥1,000以上からで入力して下さい。</small>
                        @endif
                        <div class="error error-price">
                            @error('price')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- title --}}
                <div class="wrap-item box-min d-flex">
                    <div class="wrap-item__label d-flex flex-column">
                        <p class="f-w6 text-required">タイトル</p>
                        <span class="f-w3">(70文字以内)</span>
                    </div>
                    <div class="wrap-item__value">
                        <input type="text" class="f-w3 placehoder-color" name="title"
                               placeholder="（例）現役大手商社マンが教える就活必勝テクニック！"
                               value="{{ old('title') ?? $course->title ?? "" }}">
                        <div class="error error-title">
                            @error('title')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="f-w3 d-flex justify-content-between align-items-center note-text">
                            <span class="wrap-item__value__note"></span>
                            <span class="wrap-item__value__count">70 </span>
                        </div>
                    </div>
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
                                            <input type="hidden" name="previewOld[]" value="{{ json_encode($item) }}">
                                            <div class="remove-img" style="display: flex;">
                                                <img src="{{ url('/assets/img/clients/teacher/remove.svg') }}" alt="">
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
                        <div class="error error-preview image-box-error">
                            @error('preview')
                            {{ $message }}
                            @enderror
                            @error('preview.*')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- subtitle --}}
                <div class="wrap-item box-min d-flex">
                    <div class="wrap-item__label d-flex flex-column">
                        <p class="f-w6 text-required">タイトル補足説明</p>
                        <span class="f-w3">(100文字以内)</span>
                    </div>

                    <div class="wrap-item__value">
                        <textarea name="subtitle" id="subtitle"
                                  placeholder="（例）商社志望の方必見です！現役大手商社マンだから言える内定獲得までの全てを教えます。">
                            {{ old('subtitle') ?? $course->subtitle ?? '' }}
                        </textarea>
                        <div class="error error-subtitle">
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

                {{-- body --}}
                <div class="wrap-item box-large d-flex">
                    <div class="wrap-item__label d-flex flex-column">
                        <p class="f-w6 text-required">サービス内容</p>
                        <span class="f-w3">(1000文字以内)</span>
                    </div>
                    <div class="wrap-item__value">
                        <textarea name="body" id="body"
                                  placeholder="※具体的なサービスの詳細を記入してください">{!! old('body') ?? $course->body ?? "" !!}</textarea>
                        <div class="error error-body">
                            @error('body')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- flow --}}
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
                        >{!! old('flow') ?? $course->flow ?? "" !!}</textarea>
                        <div class="error error-flow">
                            @error('flow')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- cautions --}}
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
                        >{!! old('cautions') ?? $course->cautions ?? "" !!}</textarea>
                        <div class="error error-cautions">
                            @error('cautions')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                @if ($category !== \App\Enums\DBConstant::CATEGORY_TYPE_SKILLS)
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
                                    @if(old('money') && old('time'))
                                        @foreach(old('time') as $i => $item)
                                            <div class="wrap-item__value__extension-request">
                                                <div class="d-flex">
                                                    <div
                                                            class="wrap-item__value__select extension-request__select extension-request__select--money select-parent">
                                                        <div class="select">
                                                            <input type="text" class="select__value-item f-w3"
                                                                   readonly
                                                                   value="{{ old('time')[$i] ? old('time')[$i] . ' 分' : '' }}"
                                                                   placeholder="時間">
                                                            <input type="hidden" name="time[]"
                                                                   class="hidden_input f-w3"
                                                                   readonly value="{{ old('time')[$i] }}">
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
                                                                value="{{ old('money')[$i] }}" placeholder="金額"
                                                                maxlength="15"
                                                        >
                                                        <small>※￥1,000以上からで入力して下さい。</small>
                                                    </div>
                                                </div>
                                                <span class="remove f-w3">削除する</span>
                                            </div>
                                        @endforeach
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
                                </div>
                                @if(old('time'))
                                    @if(count(old('time')) < \App\Enums\DBConstant::MAX_EXTENSION)
                                        <div class="add-extension f-w3">
                                            <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                            延長リクエストを追加する（あと2件)
                                        </div>
                                    @endif
                                @else
                                    <div class="add-extension f-w3">
                                        <img src="{{ url('/assets/img/clients/teacher/add-time.svg') }}" alt="">
                                        延長リクエストを追加する（あと2件)
                                    </div>
                                @endif
                                <small>※画面には3件まで表示できます。</small>
                                <div class="error error-money error-time">
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

                    @if ($category === \App\Enums\DBConstant::CATEGORY_TYPE_FORTUNETELLING)
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
                                                <div class="wrap-item__value__option-request wrap-container">
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
                                                <div class="error">
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
                                    <div class="error error-extra_title.">
                                        @error('extra_title.*')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                    <div class="error error-extra_price.">
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
                                        オプションを追加する（あと４件)
                                    </div>
                                    <small>※画面には５件まで表示できます。</small>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="d-flex wrap-submit justify-content-center action-button">
                    <div class="preview-zone">
                        <i></i>
                    </div>
                    <div class="back-container">
                        <a href="{{ route('client.teacher.my-page.service-list', ['tab' => $screen == 'LIVESTREAM-1' ? 'new' : 'clone']) }}"
                           type="button"
                           class="back">戻る</a>
                    </div>
                    <div class="save-container">
                        <button type="submit" name="status" value="9" id="save-draft" class="save-draft f-w6">下書き保存</button>
                        <button type="submit" name="status" style="display: none" value="0" id="btn-submit"></button>
                        <button type="button" name="status"
                                id="preview-course"
                                value="{{ \App\Enums\DBConstant::COURSE_STATUS_PREVIEW }}"
                                class="confirm f-w6">@lang('labels.button.preview_course')
                        </button>
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
    <script src="{{ mix('js/clients/teachers/preview-course.js') }}"></script>
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
