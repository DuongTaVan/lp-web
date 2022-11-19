<link href="{{ mix('css/clients/home-private.css') }}" rel="stylesheet">
<link href="{{ mix('css/clients/modules/teacher/course/preview.css')}}" rel="stylesheet">
<style>
.purchase-deadline {
    margin-left: 84.4px;
    font-weight: 400;
    font-size: 12px;
    color: rgba(42, 50, 66, 0.53);
    line-height: 18px;
}

.rectangle-div div p {
    color: #666 !important;
}

@media only screen and (max-width: 767px) {
    .purchase-deadline {
        margin-left: 68px;
    }
}
</style>

@php
    $is_mask_required = $course['is_mask_required'];
@endphp
<div id="course-detail" class="course-outline">
    <div class="content">
        <input id="course_schedule_id" value="1" type="hidden">
        <input id="currentPage" value="1" type="hidden">
        <div class="row-course">
            <div class="left content-description">
                <p class="description-title text-left f-w6">{{ $course['title'] }}</p>
                <div
                        class="sub-description-title text-left">{!! $course['subtitle'] !!} </div>
                <div class="rating position-relative d-flex  align-items-start">
                    <div class="d-flex rating-position">
                        <ul class="content-rating d-flex">
                            @include('client.common.show-star',['rating'=> ratingProcess($avgRating)])
                        </ul>
                        <div class="rating__star rating__star-number">
                            <span class="average">{{ ratingProcess($avgRating) }}</span>
                            <span class="votes">({{ $sumRating }})</span>
                        </div>
                    </div>
                </div>
                <div class="explain-content">
                    <div class="all-img">
                        <div class="family">
                            <img
                                    src="{{ count($course['imagePaths']) ? $course['imagePaths'][0]['image_url'] : asset('assets/img/portal/default-image.svg') }}"
                                    alt="">
                        </div>
                        <div
                                class="three-image @if(count($course['imagePaths']) === 4) justify-content-between @endif">
                            @if(count($course['imagePaths']) >= 2)
                                @foreach($course['imagePaths'] as $item)
                                    <div class="three-image__item">
                                        <img src="{{ $item['image_url'] }}" alt="">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{--Slider image sp--}}
                    <div class="family-app">
                        <div class="swiper-container mySwiper">
                            <div class="swiper-wrapper">
                                @foreach($course['imagePaths'] as $item)
                                    <div class="swiper-slide family-app__slider ">
                                        <img
                                                src="{{ $item['image_url'] ?? asset('assets/img/portal/default-image.svg') }}"
                                                alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <section class="paginate-swiper">
                            <div class="swiper-pagination family-app__paginate"></div>
                        </section>
                    </div>
                    <!--                        End Slider image sp-->
                    {{--                        seller-profile-app--}}
                    <div>
                        <div class="content-table">
                            <div class="seller-profile seller-profile-app">
                                <a
                                        class="seller-profile__header position-relative">
                                    <p class="seller-profile__header--title">@lang('labels.course-detail.seller_profile')</p>
                                    <div class="d-flex justify-content-between align-items-center"
                                         style="margin-bottom: 10px">
                                        <div class="d-flex">
                                            <div class="seller-avt-wrapper">
                                                @if(isset($course))
                                                    <img class="seller-avt"
                                                         src="{{ $user->profile_image }}"
                                                         alt="">
                                                @else
                                                    <img class="seller-avt"
                                                         alt="画像エラー">
                                                    <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}"
                                                         class="rank-icon">
                                                @endif
                                                @switch($user->rank_id)
                                                    @case(\App\Enums\DBConstant::BRONZE)
                                                    <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                    @case(\App\Enums\DBConstant::SILVER)
                                                    <img src="{{ asset('assets/img/search/icon/Silver.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                    @case(\App\Enums\DBConstant::GOLD)
                                                    <img src="{{ asset('assets/img/search/icon/Gold.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                    @case(\App\Enums\DBConstant::PLATINUM)
                                                    <img src="{{ asset('assets/img/search/icon/platium.svg') }}"
                                                         class="rank-icon">
                                                    @break
                                                    @default
                                                @endswitch
                                            </div>
                                            @if(isset($course))
                                                <div class="d-flex flex-column">
                                                    <p class="seller-profile__header--cat">{{ $user->full_name }}</p>
                                                    @if($is_mask_required === 0)
                                                        <div class="formality fs-12 f-w6">
                                                            @lang('labels.course-detail.formality')
                                                            <span>(OK)</span>
                                                        </div>
                                                    @else
                                                        <div class="formality fs-12 fw-600">
                                                            @lang('labels.course-detail.formality')
                                                            <span class="fs-12 fw-600">(NG)</span>
                                                            <span class="lappi-ar fw-300">※Lappi ARエフェクト</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <img src="{{ asset('assets/img/search/icon/view-profile.svg') }}"
                                             class="rank-icon">
                                    </div>
                                    <img class="arrow-right position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}"
                                         alt="">
                                </a>
                                @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS
                                       && $user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <div class="d-flex flex-wrap justify-content-start">
                                        <div
                                                class="identification d-flex justify-content-center align-items-center position-relative">
                                            <div
                                                    class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                            <img
                                                    class="icon-identification icon-identification__mobile position-absolute"
                                                    src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                                    alt="">
                                            <button
                                                    class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                            <img class=" icon-tick icon-tick__mobile position-absolute"
                                                 src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                 alt="">
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between">
                                        @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                            <div
                                                    class="identification d-flex justify-content-center align-items-center position-relative">
                                                <div
                                                        class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                                <img
                                                        class="icon-identification icon-identification__mobile position-absolute"
                                                        src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                                        alt="">
                                                <button
                                                        class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                                <img
                                                        class=" icon-tick icon-tick__mobile position-absolute icon-nondisclosure-agreement icon-nondisclosure-agreement__mobile"
                                                        src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                        alt="">
                                            </div>
                                        @endif
                                        @if($user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING
                                            && $user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                            <div
                                                    class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative nda">
                                                <div
                                                        class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                                <img
                                                        class="position-absolute icon-nondisclosure-agreement icon-nondisclosure-agreement__mobile"
                                                        src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                                        alt="">
                                                <button
                                                        class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                                <img class=" icon-tick icon-tick__mobile position-absolute"
                                                     src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                     alt="">
                                            </div>
                                        @endif
                                        @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION
                                            && $user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                            <div
                                                    class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative">
                                                <div
                                                        class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                                <img
                                                        class="position-absolute icon-nondisclosure-agreement icon-qualification-mobile"
                                                        src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                                        alt="">
                                                <button
                                                        class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                                <img class=" icon-tick icon-tick__mobile position-absolute"
                                                     src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                     alt="">
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="d-flex flex-wrap">
                                    <div
                                            class="question question__mobile d-flex justify-content-center align-items-center position-relative">
                                        <img class="icon-question icon-question__mobile position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/question.svg')}}"
                                             alt="">
                                        <a class="btn-question text-center">@lang('labels.course-detail.question_course')</a>
                                    </div>
                                    <div
                                            class="follow-us follow-us__mobile d-flex justify-content-center align-items-center position-relative">
                                        <button type="button"
                                                class="btn-follow-us ">@lang('labels.course-detail.follow_course')
                                        </button>
                                        <img class="icon-follower icon-follower__mobile position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/follower.svg')}}"
                                             alt="">
                                    </div>
                                </div>
                                <div class="seller-profile__footer position-relative d-none">
                                    @if (isset($user->catchphrase))
                                        <p class="seller-profile__footer__catchphrase">{{ $user->catchphrase }}</p>
                                        <div class="position-absolute see-all">
                                            <span></span>
                                            <img class="arrow-down"
                                                 src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}"
                                                 alt="">
                                        </div>
                                    @else
                                        <span
                                                class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
                                    @endif
                                </div>
                            </div>
                            <div class="seller-social-app">
                                <div class="w-100 d-flex justify-content-between ">
                                    <a
                                            class="facebook d-flex align-items-center justify-content-center">
                                        <img src="{{asset('assets/img/clients/course-detail/fb.svg')}}" alt="">
                                        <span>@lang('labels.course-detail.share_course')</span>
                                    </a>
                                    <a
                                            class="tweeter d-flex align-items-center justify-content-center">
                                        <img src="{{asset('assets/img/clients/course-detail/tw.svg')}}" alt="">
                                        <span>@lang('labels.course-detail.tweet_course')</span>
                                    </a>
                                    <a
                                            class="line d-flex align-items-center justify-content-center">
                                        <img src="{{asset('assets/img/clients/course-detail/line.svg')}}" alt="">
                                        <span>@lang('labels.course-detail.line_course')</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                        end seller-profile-app--}}
                    <div class="rectangle-div rectangle-div__about-content">
                        <p class="text-left f-w6">@lang('labels.course-detail.content_course')</p>
                        <span class="text-content body"><div>{!! $course['body'] !!}</div></span>
                        <p class="read-more__open text-center"
                           style="display: none">@lang('labels.course-detail.read_more_course')</p>
                        <p class="read-more__close text-center"
                           style="display: none">@lang('labels.course-detail.read_more_course_close')</p>
                    </div>
                    <div class="rectangle-div rectangle-div__flow-day">
                        <p class="text-left f-w6">@lang('labels.course-detail.follow_day_course')</p>
                        <span><div>{!! $course['flow'] !!}</div></span>
                    </div>
                    <div class="live-stream d-flex align-items-center">
                        <img src="{{asset('assets/img/clients/course-detail/play.svg')}}" alt="">
                        <p class="f-w6">@lang('labels.course-detail.tutorial_livestream_course')</p>
                    </div>
                    <div class="rectangle-div rectangle-div__using">
                        <p class="text-left f-w6">@lang('labels.course-detail.using_course')</p>
                        <span><div>{!! $course['cautions'] !!}</div></span>
                    </div>
                    @if(isset($course['subCourse']) && $course['subCourse'] != null)
                        @if(isset($course['subCourse']['courseSchedules']) && (count($course['subCourse']['courseSchedules'])  > 0))
                            <section class="sub-course">
                                <label for="" class="label-option f-w6">※オプション設定</label>
                                <div class="rectangle-div rectangle-div__option">
                                    <p class="option-label f-w6">個別講座（ビデオ通話）</p>

                                    <div class="option-content">
                                        <div class="date-time d-flex">
                                            <div class="date-time__label f-w6">開催日時</div>
                                            <div>
                                                @foreach($course['subCourse']['courseSchedules'] as $courseSchedule)
                                                    <div>
                                                <span class="date-time__date">
                                                <img class="icon-option"
                                                     src="{{asset('assets/img/clients/course-detail/date.svg')}}"
                                                     alt="">
                                                <span>{{Carbon\Carbon::parse($courseSchedule['start_datetime'])->format('m')}}月{{Carbon\Carbon::parse($courseSchedule['start_datetime'])->format('d')}}日</span>
                                            </span>
                                                        <span class="date-time__time">
                                                <img class="icon-option"
                                                     src="{{asset('assets/img/clients/course-detail/time.svg')}}"
                                                     alt="">
                                                <span>{{Carbon\Carbon::parse($courseSchedule['start_datetime'])->format('H:i')}} - {{Carbon\Carbon::parse($courseSchedule['end_datetime'])->format('H:i')}}</span>
                                            </span>
                                                    </div>

                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="line-horizontal"></div>
                                        <div class="usage-time">
                                            <span class="price__label f-w6">タイトル</span>
                                            <span class="usage-time__value"
                                                  style="font-size: 16px; line-height: 24px; color: #2A3242; font-weight: 600;">{{ $course['title'] }}</span>
                                        </div>
                                        <div class="line-horizontal"></div>
                                        <div class="usage-time">
                                            <span class="usage-time__label f-w6">ご利用時間</span>
                                            <span class="usage-time__value">{{ $course['subCourse']['minutes_required'] }}分</span>
                                        </div>
                                        <div class="line-horizontal"></div>
                                        <div class="price">
                                            <span class="price__label f-w6">料金</span>
                                            <span
                                                    class="price__value">￥{{ number_format($course['subCourse']['price']) }}</span>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        @endif
                    @endif

                    @if(auth()->guard('client')->user()->teacher_category_skills != \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                        @php
                            $extensions = (isset($course['extensionsOpen']) && count($course['extensionsOpen']) > 0 ? $course['extensionsOpen'] : [])
                        @endphp
                        @if(count($extensions))
                            <section class="sub-course">
                                <label for="" class="label-option f-w6">※オプション設定</label>
                                <div class="rectangle-div rectangle-div__option">
                                    <p class="option-label f-w6">延長リクエスト</p>

                                    <div class="option-content">
                                        <style>
                                            .sub-course-time-price {
                                                display: flex;
                                            }

                                            .date-time {
                                                margin-left: 60px;
                                            }
                                        </style>
                                        @foreach($extensions as $key => $extension)
                                            <div class="sub-course-time-price">
                                                <div class="price">
                                                    <span class="usage-time__label f-w6">時間</span>
                                                    <span class="usage-time__value">{{$extension['minutes_required']}}分</span>
                                                </div>
                                                <div class="date-time">
                                                    <div class="usage-time">
                                                        <span class="usage-time__label f-w6">金額</span>
                                                        <span
                                                                class="price__value">¥{{number_format($extension['price'])}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(count($extensions) > 1 && $key+1 < count($extensions))
                                                <div class="line-horizontal"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif

                    @endif
                    <div class="explain-content__option-btn position-relative">
                        <a href="#" id="btn-back" class="btn-back position-absolute">戻る</a>
                        <a href="#" class="btn-icon-back position-relative">
                            <img src="{{ asset('assets/img/clients/teacher/arrow-left-black.svg') }}" alt="">
                        </a>
                        @if((int)Request::get('isPublic') != 1 && (!isset($isPublic) || !$isPublic))
                            <a href="#"
                               id="btn-draft"
                               class="explain-content__option-btn__save-draft">下書き保存</a>
                        @endif
                        @if($course['approval_status'] === \App\Enums\DBConstant::COURSE_NOT_REVIEW)
                            @if($user->user_status === \App\Enums\Constant::USER_STATUS_REST)
                                @if ($user->identity_verification_status !== \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <a class="btn-public-course explain-content__option-btn__publish {{ $user->identity_verification_status !== \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED ? 'disabled-public' : ''}}">承認申請</a>
                                @else
                                    <a href="#"
                                       class="btn-public-course explain-content__option-btn__publish">承認申請</a>
                                @endif
                            @endif
                        @else
                            @if($user->user_status === \App\Enums\Constant::USER_STATUS_REST)
                                @if ($user->identity_verification_status !== \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <a class="btn-public-course explain-content__option-btn__publish {{ $user->identity_verification_status !== \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED ? 'disabled-public' : ''}}">公開する</a>
                                @else
                                    <a href="#"
                                       class="btn-public-course explain-content__option-btn__publish">公開する</a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

            </div>
            <div class="right content-table">
                <div class="Admission-fee">
                    <div class="d-flex align-items-center">
                        <span class="mr-horizontal">@lang('labels.course-detail.course_livestream')</span>
                        <div>
                            <span
                                    class="price-schedule">￥{{ number_format(isset($course['courseSchedules'][0]->price) ? $course['courseSchedules'][0]->price : $course['price']) }}</span>
                            <small>(@lang('labels.course-detail.tax_included_course'))</small>
                        </div>
                    </div>
                    @if($isSchedule)
                        <div class="option-list text-left">
                            <div
                                    data-price="{{ number_format($course['price']) }}"
                                    data-number_of_participants="{{ number_format($course['num_of_applicants']) }}人"
                                    data-deadline="{{ (date('m', strtotime($course['purchase_deadline']))) }}月{{ (date('d', strtotime($course['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($course['purchase_deadline']))] }})"
                                    class="rectangle__pc d-flex flex-column justify-content-center align-items-center position-relative choose-option-preview choose-option active">
                                <span class="rectangle__date">{{date('m', strtotime($course['start_datetime']))}}月{{date('d', strtotime($course['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($course['start_datetime']))]}})</span>
                                <span class="rectangle__time">{{ $course->hour_minute }}</span>
                                <span
                                        class="rectangle__text">{{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$course->course->dist_method] }}</span>
                            </div>
                            <div class="deadline d-flex">
                                    <span
                                            class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                                <span class="deadline__result">{{ (date('m', strtotime($course['purchase_deadline']))) }}月{{ (date('d', strtotime($course['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($course['purchase_deadline']))] }})</span>
                            </div>
                            <div class="purchase-deadline">※開催１時間前</div>
                            <button id="purchase_procedure"
                                    class="disable-cursor">@lang('labels.course-detail.purchase_procedure_course')</button>
                        </div>
                    @else
                        @if($course['approval_status'] === \App\Enums\DBConstant::COURSE_APPROVED)
                            <div class="option-list text-left">
                                <div class="list-schedule">
                                    @foreach($course['courseSchedules'] as $key => $item)
                                        <div id="option{{ $key }}" data-id=""
                                             data-price="{{ number_format($item['price']) }}"
                                             data-number_of_participants="{{ number_format($item['num_of_applicants']) }}人"
                                             data-deadline="{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})"
                                             class="rectangle__pc @if($key == 0) active @endif">
                                            <span class="rectangle__date">{{date('m', strtotime($item['start_datetime']))}}月{{date('d', strtotime($item['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]}})</span>
                                            <span class="rectangle__time">{{ $item['hour_minute'] ?? "" }}</span>
                                            <img class="icon-arrow position-absolute"
                                                 src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                                            <span
                                                    class="rectangle__text">{{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$course['dist_method']] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="deadline d-flex">
                                    <span
                                            class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                                    <span class="deadline__result">@lang('labels.course-detail.money_course')</span>
                                </div>
                                <div class="purchase-deadline">※開催１時間前</div>
                                <button id="purchase_procedure"
                                        class="disable-cursor">@lang('labels.course-detail.purchase_procedure_course')</button>
                            </div>
                        @else
                            <div class="rectangle-none"></div>
                            <span id="price-course-preview" style="display: none"
                                  data-id="{{ number_format($course['price']) }}"></span>
                            <button id="purchase_procedure"
                                    class="disable-cursor">@lang('labels.course-detail.purchase_procedure_course')</button>
                        @endif
                    @endif
                    @if(count($course['optionalExtras']))
                        <section id="charged-option">
                            <div id="option-schedule"
                                 class="charged-option d-flex justify-content-center align-items-center">
                                <img src="{{asset('assets/img/clients/course-detail/circle-plus.svg')}}"
                                     alt="">
                                <span
                                        class="charged-option-text">@lang('labels.course-detail.charged_option_course')</span>
                                <img class="arrow-down"
                                     src="{{asset('assets/img/clients/course-detail/arrow-right-grey.svg')}}"
                                     alt="">
                            </div>
                            <div class="table-option disable-option">
                                @foreach($course['optionalExtras'] as $key => $item)
                                    <div
                                            class="table-option-item d-flex align-items-center justify-content-between">
                                        <label class="checkbox">
                                            <input type="checkbox"
                                                   data-value=""
                                                   value="{{$item['title']}}"> {{ $item['title'] }}
                                            <span class="checkmark"></span>
                                        </label>
                                        <div style="display: flex">
                                            <img src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                                 alt="">
                                            <span>¥{{number_format($item['price'])}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                    <span class="Admission-fee__warning text-center">※キャンセルは開催日前日２1:５９まで</span>
                </div>
                <div class="seller-profile">
                    <div class="seller-profile__header text-center position-relative">
                        <p class="seller-profile__header--title">@lang('labels.course-detail.seller_profile')</p>
                        <div style=" margin: 0 auto" class="seller-avt-wrapper">
                            <img class="seller-avt"
                                 src="{{ $user->profile_image }}"
                                 alt="">
                            @switch($user->rank_id)
                                @case(\App\Enums\DBConstant::BRONZE)
                                <img src="{{ asset('assets/img/search/icon/Bronze.svg') }}" class="rank-icon">
                                @break
                                @case(\App\Enums\DBConstant::SILVER)
                                <img src="{{ asset('assets/img/search/icon/Silver.svg') }}" class="rank-icon">
                                @break
                                @case(\App\Enums\DBConstant::GOLD)
                                <img src="{{ asset('assets/img/search/icon/Gold.svg') }}" class="rank-icon">

                                @break
                                @case(\App\Enums\DBConstant::PLATINUM)
                                <img src="{{ asset('assets/img/search/icon/platium.svg') }}" class="rank-icon">
                                @break
                                @default
                            @endswitch
                        </div>
                        @if($user->name_use === 1)
                            <p class="seller-profile__header--cat">{{ $user->nickname }}</p>
                        @else
                            <p class="seller-profile__header--cat">{{ $user->last_name_kanji }}{{ $user->first_name_kanji }}</p>
                        @endif
                        @if($is_mask_required === 0)
                            <div class="formality fs-12 fw-600">
                                @lang('labels.course-detail.formality')
                                <span>(OK)</span>
                            </div>
                        @else
                            <div class="formality fs-12 fw-600">
                                @lang('labels.course-detail.formality')
                                <span class="fs-12 fw-600">(NG)</span>
                                <span class="lappi-ar">※Lappi ARエフェクト</span>
                            </div>
                        @endif
                        <div class="position-relative">
                            <a href="javascript:;"
                               class="nav-link p-0">
                                <p class="seller-profile__header--profile-detail">@lang('labels.course-detail.profile_detail')</p>
                            </a>
                            <img class="arrow-right-pr position-absolute"
                                 src="{{ asset('assets/img/clients/course-detail/arrow-right.svg') }}"
                                 alt="">
                        </div>
                    </div>
                    @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS
                        && $user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                        <div class="d-flex flex-wrap justify-content-center">
                            <div
                                    class="identification d-flex justify-content-center align-items-center position-relative">
                                <div
                                        class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                <img class="icon-identification position-absolute"
                                     src="{{asset('assets/img/clients/course-detail/identification.svg')}}" alt="">
                                <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                <img class=" icon-tick position-absolute"
                                     src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                     alt="">
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-wrap justify-content-between pd-pc-12">
                            @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                <div
                                        class="identification d-flex justify-content-center align-items-center position-relative @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION) identification-small @endif">
                                    <div
                                            class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                    <img class="icon-identification position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                         alt="">
                                    <button
                                            class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                    <img class=" icon-tick position-absolute icon-nondisclosure-agreement"
                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                         alt="">
                                </div>
                            @endif
                            @if($user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                <div
                                        class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION) nondisclosure-agreement-small @endif">
                                    <div
                                            class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                    <img class="position-absolute icon-nondisclosure-agreement"
                                         src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                         alt="">
                                    <button
                                            class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                    <img class=" icon-tick position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                         alt="">
                                </div>
                            @endif

                            @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION
                                && $user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                <div
                                        class="nondisclosure-agreement d-flex justify-content-center align-items-center length-div  position-relative @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION) nondisclosure-agreement-small @endif">
                                    <img class="position-absolute icon-nondisclosure-agreement"
                                         src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                         alt="">
                                    <button
                                            class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                    <img class=" icon-tick position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                         alt="">
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="d-flex flex-wrap mb-1 mx-pc-11">
                        <div
                                class="question d-flex justify-content-center align-items-center position-relative disable-cursor">
                            <button class="btn-question">
                                <img class="icon-question "
                                     src="{{asset('assets/img/clients/course-detail/question.svg')}}" alt="">
                                <span>質問する</span></button>
                        </div>
                        <div
                                class="follow-us d-flex justify-content-center align-items-center position-relative disable-cursor">
                            <button type="button" class="btn-follow-us ">
                                <img class="icon-follower"
                                     src="{{asset('assets/img/clients/course-detail/follower.svg')}}" alt="">
                                <span>フォローする</span>
                            </button>

                        </div>
                    </div>
                    <div class="seller-profile__footer position-relative">
                        @if (isset($user->catchphrase))
                            <p class="seller-profile__footer__catchphrase check-height">{{ $user->catchphrase }}</p>
                            <div class="position-absolute see-all">
                                <span class="fs-12 f-w3">@lang('labels.course-detail.see_all_course')</span>
                                <img class="arrow-down"
                                     src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}" alt="">
                            </div>
                            <div class="position-absolute compact-text">
                                <span class="fs-12 f-w3">@lang('labels.course-detail.read_more_course_close')</span>
                                <img class="arrow-down"
                                     src="{{ asset('assets/img/clients/course-detail/arrow-right.svg') }}" alt="">
                            </div>
                        @else
                            <span
                                    class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
                        @endif
                    </div>
                </div>
                <div class="seller-social w-100 d-flex justify-content-between">
                    <div class="facebook d-flex align-items-center justify-content-center disable-cursor">
                        <img src="{{asset('assets/img/clients/course-detail/fb.svg')}}" alt="">
                        <span>@lang('labels.course-detail.share_course')</span>
                    </div>
                    <div class="tweeter d-flex align-items-center justify-content-center disable-cursor">
                        <img src="{{asset('assets/img/clients/course-detail/tw.svg')}}" alt="">
                        <span>@lang('labels.course-detail.tweet_course')</span>
                    </div>
                    <div class="line d-flex align-items-center justify-content-center disable-cursor">
                        <img src="{{asset('assets/img/clients/course-detail/line.svg')}}" alt="">
                        <span>@lang('labels.course-detail.line_course')</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--Admission-fee-app--}}
@if($course['approval_status'] === \App\Enums\DBConstant::COURSE_APPROVED || auth()->guard('client')->user()->teacher_category_skills != \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
    @php
        $type = !empty($course->category->type) ? $course->category->type : (!empty($course->course->category->type) ? $course->course->category->type : null);
    @endphp
    <div class="Admission-fee-app">
        @if(!empty($type))
            @switch($type)
                @case($type === 1)
                <span class="mr-5">@lang('labels.course-detail.course_livestream')</span>
                @break
                @case($type === 2)
                <span class="mr-5">@lang('labels.course-detail.course_consultation')</span>
                @break
                @default
                <span class="mr-5">@lang('labels.course-detail.course_fortune')</span>
            @endswitch
        @endif
        <span
                class="price-schedule">￥{{ number_format(isset($course['courseSchedules'][0]['price']) ? $course['courseSchedules'][0]['price'] : $course['price']) }}</span>
        <small>(@lang('labels.course-detail.tax_included_course'))</small>
        <div class="option-list text-left d-flex">
            <div class="content-left">
                @if(isset($course['courseSchedules']) && count($course['courseSchedules']) > 0)
                    <div class="d-flex flex-column">
                        @php
                            $order = 0;
                        @endphp
                        @foreach($course['courseSchedules'] as $key => $item)
                            <div id="option{{$key}}" data-id=""
                                 data-id=""
                                 data-price="{{ number_format($item['price']) }}"
                                 data-number_of_participants="{{ number_format($item['num_of_applicants']) }}人"
                                 data-deadline="{{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})"
                                 href="#" data-toggle="modal" data-target="#modal-choose-schedule"
                                 class="rectangle-sp d-flex flex-column justify-content-center align-items-center choose-option position-relative @if($key == 0) active @endif">
                                <span class="rectangle-sp__date">{{date('m', strtotime($item['start_datetime']))}}月{{date('d', strtotime($item['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]}})</span>
                                <span class="rectangle-sp__time">{{date_format(date_create($item['start_datetime']), 'H:i')}} - {{date_format(date_create($item['end_datetime']), 'H:i')}}</span>
                                <img class="icon-arrow position-absolute"
                                     @if(count($course['courseSchedules']) > 0) style="display: unset!important;"
                                     @endif
                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                                <span
                                        class="rectangle-sp__text">{{\App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$course['dist_method'] ?? 1]}}</span>
                                <span id="rectangle-sp__price" style="display: none"
                                      data-id="{{$key}}">￥{{number_format($item['price'])}}</span>
                                <span id="deadline" style="display: none" data-id="{{$key}}"> {{(date('m', strtotime($item['purchase_deadline'])))}}月{{(date('d', strtotime($item['purchase_deadline'])))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))]}})</span>
                                <span id="number_of_participants" style="display: none"
                                      data-id="{{$key}}">{{number_format($item['fixed_num'] ?? 0)}}</span>
                                <input type="hidden" value="">
                            </div>
                        @endforeach
                    </div>
                @else
                    @if(isset($isSchedule))
                        <div class="d-flex flex-column">
                            @php
                                $order = 0;
                            @endphp
                            <div data-id="{{ $course["course_schedule_id"] }}"
                                 data-id="{{ $course["course_schedule_id"] }}"
                                 data-price="{{ number_format($course['price']) }}"
                                 data-number_of_participants="{{ number_format($course['num_of_applicants']) }}人"
                                 data-deadline="{{ (date('m', strtotime($course['purchase_deadline']))) }}月{{ (date('d', strtotime($course['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($course['purchase_deadline']))] }})"
                                 href="#" data-toggle="modal" data-target="#modal-choose-schedule"
                                 class="rectangle-sp d-flex flex-column justify-content-center align-items-center choose-option position-relative active">
                                <span class="rectangle-sp__date">{{date('m', strtotime($course['start_datetime']))}}月{{date('d', strtotime($course['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($course['start_datetime']))]}})</span>
                                <span class="rectangle-sp__time">{{date_format(date_create($course['start_datetime']), 'H:i')}} - {{date_format(date_create($course['end_datetime']), 'H:i')}}</span>
                                <span id="rectangle-sp__price"
                                      style="display: none">¥{{number_format($course['price'])}}</span>
                                <span id="deadline" style="display: none"> {{(date('m', strtotime($course['purchase_deadline'])))}}月{{(date('d', strtotime($course['purchase_deadline'])))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($course['purchase_deadline']))]}})</span>
                                <span id="number_of_participants"
                                      style="display: none">{{number_format($course['fixed_num'])}}</span>
                                <input type="hidden" value="{{$course['course_schedule_id']}}">
                            </div>

                        </div>
                    @endif

                    <div class="deadline d-flex">
                        <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                        <span class="deadline__result">（@lang('labels.course-detail.money_course'))</span>
                    </div>
                    <div class="purchase-deadline">※開催１時間前</div>

                @endif
                @if(isset($course['courseSchedules']) && count($course['courseSchedules']) > 0)
                    <div class="deadline d-flex">
                        <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                        <span class="deadline__result">（@lang('labels.course-detail.money_course'))</span>
                    </div>
                    <div class="purchase-deadline">※開催１時間前</div>
                @endif
            </div>
            <div class="content-right">
                <div>
                    <button id="purchase_procedure">@lang('labels.course-detail.purchase_procedure_course')</button>
                </div>
                @if(count($course['optionalExtras']))
                    <section id="charged-option-app">
                        <div class="charged-option d-flex justify-content-center align-items-center">
                            <img src="{{asset('assets/img/clients/course-detail/circle-plus.svg')}}"
                                 alt="">
                            <span
                                    class="charged-option-text">@lang('labels.course-detail.charged_option_course')</span>
                            <img class="arrow-down"
                                 src="{{asset('assets/img/clients/course-detail/arrow-right-grey.svg')}}"
                                 alt="">
                        </div>
                    </section>
                @endif
                <span class="warning text-center">@lang('labels.course-detail.waring_time')</span>
            </div>
        </div>
    </div>
@else
    <div class="Admission-fee-app">
        <div class="text-center">
            <span class="price-schedule">￥{{ number_format($course['price']) }}</span>
            <small>(@lang('labels.course-detail.tax_included_course'))</small>
            <div class="rectangle-none-sp"></div>
            <div>
                <button type="submit" id="purchase_procedure">
                    @lang('labels.course-detail.purchase_procedure_course')
                </button>
            </div>
            <span class="warning text-center">@lang('labels.course-detail.waring_time')</span>
        </div>
    </div>
@endif
{{--    choose other option--}}
<div class="other-option">
    <div class="position-relative">
        <div class="line-top"></div>
        <div class="close-other-option">
            <img src="{{asset('assets/img/icons/close.svg')}}" alt="">
        </div>
        <div class="table-option disable-option">
            @if(count($course['optionalExtras']))
                @foreach($course['optionalExtras'] as $key => $item)
                    <div
                            class="table-option-item d-flex align-items-center justify-content-between">
                        <label class="checkbox">
                            <input type="checkbox"
                                   name="optional_extra_id[]"> {{$item['title']}}
                            <span class="checkmark"></span>
                        </label>
                        <div style="white-space: nowrap">
                            <img
                                    src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                    alt="">
                            <span
                                    class="option-price">¥{{number_format($item['price'])}}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('client.screen.course-detail.choose-course-schedule-sp-preview', ['data' => $isSchedule ? [$course] : $course['courseSchedules']])
@include('client.screen.teacher.course-preview.popup-identity-verify')
<script src="{{ mix('js/clients/modules/livestream.js') }}"></script>
<script>
  $(document).ready(function () {
    let price = $('#price-course-preview').attr('data-id')
    $('.text-bold').append().html(price)
    new Swiper('.mySwiper', {
      spaceBetween: 30,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    })

    $('.rectangle__pc').on('click', function () {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $('.rectangle__pc').addClass('show');
      } else if ($(this).hasClass('show')) {
        const id = $(this).attr('id');
        $('.rectangle__pc').removeClass('show');
        $(this).addClass('active');
        if (id === 'option0') {
          return false;
        }
        $('.price-schedule').html('￥' + $(this).data('price'));
        $('.deadline__result').html($(this).data('deadline'));
      }
    });
  })

  $('.three-image img').hover(function () {
    $('.three-image img').prop('disabled', false);
    let src = $(this).attr('src');
    let srcImgFamily = $('.family img').attr('src');
    $(this).prop('disabled', true);
    if (src === srcImgFamily) {
      return false;
    }
    $('.family img').removeClass('family-animation')
    setTimeout(function () {
      $('.family img').attr('src', src);
      $('.family img').addClass('family-animation');
    }, 200);

  }, function () {
  })
</script>
