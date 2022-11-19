@php
    $previousUrl = url()->previous();
    $parts = parse_url($previousUrl);
    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);
        if (count($query) > 0 && !isset($query['backFrom'])) {
            $previousUrl = $previousUrl . '&backFrom=preview';
        }
        if (count($query) === 0) {
            $previousUrl = $previousUrl . '?backFrom=preview';
        }
    } else {
        $previousUrl = $previousUrl . '?backFrom=preview';
    }
@endphp

@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/home-private.css') }}" rel="stylesheet">
    <link href="{{ mix('css/clients/modules/livestream.css')}}" rel="stylesheet">
    <style>
        .explain-content__option-btn__edit {
            color: #2A3242 !important;
            border: 1px solid #4E576833 !important;
            background-color: #FFFFFF !important;
            display: none !important;
        }

        #purchase_procedure {
            background: #9B9F9E !important;
        }


        @media only screen and (min-width: 320px) and (max-width: 768px) {
            #course-detail .content .content-table .seller-profile__header .seller-avt-wrapper {
                width: 50%;
            }

            .explain-content__option-btn__edit {
                display: block !important;
            }

            #course-detail .content .content-table .seller-profile__header .seller-avt-wrapper .seller-avt {
                width: 46.5px;
                height: 46.5px;
            }
        }
    </style>
@endsection
@section('content')
    <div id="course-detail" class="course-outline">
        <div class="content">
            <input id="course_schedule_id" value="1" type="hidden">
            <input id="currentPage" value="1" type="hidden">
            <div class="d-flex flex-wrap">
                <div class="col9 content-description">
                    <p class="description-title text-left f-w6">{{ $courseSchedule->title }}</p>
                    <div class="sub-description-title text-left">{!! $courseSchedule->subtitle !!}</div>
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
                        @if(session()->has('preview_file_' . auth('client')->id()))
                            @php
                                $sessionImage = session()->get('preview_file_' . auth('client')->id());
                                $iMax = count($sessionImage);
                            @endphp
                            <div>
                                <img class="family"
                                     src='{{ $sessionImage[0]['fullPath'] }}'
                                     alt="" width="900" height="497">
                            </div>
                            <div class="three-image d-flex w-100">
                                @if(count(session()->get('preview_file_' . auth('client')->id())) >= 2)
                                    @for($i = 1; $i < $iMax; $i++)
                                        <img src='{{ $sessionImage[$i]['fullPath'] }}' alt="">
                                    @endfor
                                @endif
                            </div>
                        @endif
{{--                        <div class="family">--}}
{{--                            <img--}}
{{--                                src='{{ $course->imagePaths ? $course->imagePaths['0']->image_url : asset('assets/img/portal/default-image.svg') }}'--}}
{{--                                alt="" width="900" height="497">--}}
{{--                        </div>--}}

{{--                        <div class="three-image d-flex w-100">--}}
{{--                            @if(count($course->imagePaths) >= 2)--}}
{{--                                @for($i = 1; $i<count($course->imagePaths); $i++)--}}
{{--                                    <img src='{{ $course->imagePaths[$i]->image_url }}' alt="">--}}
{{--                                @endfor--}}
{{--                            @endif--}}
{{--                        </div>--}}


                        {{--                  Slider image sp--}}
                        <div class="family-app">
                            <div class="swiper-container mySwiper">
                                <div class="swiper-wrapper">
                                    @for($i = 0; $i<count($course->imagePaths); $i++)
                                        <div class="swiper-slide family-app__slider ">
                                            <img src="{{ $course->imagePaths[$i]->image_url ?? asset('assets/img/portal/default-image.svg') }}"
                                                 alt="">
                                        </div>
                                    @endfor
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
                                    <a class="seller-profile__header position-relative">
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
                                                @if(isset($courseSchedule))
                                                    <div class="d-flex flex-column">
                                                        <p class="seller-profile__header--cat">{{ $user->full_name }}</p>
                                                        @if((int)$courseSchedule->is_mask_required === 0)
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
                                            <div class="identification d-flex justify-content-center align-items-center position-relative">
                                                <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                                <img class="icon-identification icon-identification__mobile position-absolute"
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
                                                <div class="identification d-flex justify-content-center align-items-center position-relative">
                                                    <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                                    <img class="icon-identification icon-identification__mobile position-absolute"
                                                         src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                                         alt="">
                                                    <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                                    <img class=" icon-tick icon-tick__mobile position-absolute icon-nondisclosure-agreement icon-nondisclosure-agreement__mobile"
                                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                         alt="">
                                                </div>
                                            @endif
                                            @if($user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING
                                                && $user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                                <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative nda">
                                                    <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                                    <img class="position-absolute icon-nondisclosure-agreement icon-nondisclosure-agreement__mobile"
                                                         src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                                         alt="">
                                                    <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                                    <img class=" icon-tick icon-tick__mobile position-absolute"
                                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                         alt="">
                                                </div>
                                            @endif
                                            @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION
                                                && $user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                                <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative">
                                                    <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                                    <img class="position-absolute icon-nondisclosure-agreement icon-qualification-mobile"
                                                         src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                                         alt="">
                                                    <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                                    <img class=" icon-tick icon-tick__mobile position-absolute"
                                                         src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                         alt="">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="d-flex flex-wrap">
                                        <div class="question question__mobile d-flex justify-content-center align-items-center position-relative">
                                            <img class="icon-question icon-question__mobile position-absolute"
                                                 src="{{asset('assets/img/clients/course-detail/question.svg')}}"
                                                 alt="">
                                            <a class="btn-question text-center">@lang('labels.course-detail.question_course')</a>
                                        </div>
                                        <div class="follow-us follow-us__mobile d-flex justify-content-center align-items-center position-relative">
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
                            <span class="text-content body">{!! $courseSchedule->body !!}</span>
                            <p class="read-more__open text-center"
                               style="display: none">@lang('labels.course-detail.read_more_course')</p>
                            <p class="read-more__close text-center"
                               style="display: none">@lang('labels.course-detail.read_more_course_close')</p>
                        </div>
                        <div class="rectangle-div rectangle-div__flow-day">
                            <p class="text-left f-w6">@lang('labels.course-detail.follow_day_course')</p>
                            <span>{!! $courseSchedule->flow !!}</span>
                        </div>
                        <div class="live-stream d-flex align-items-center">
                            <img src="{{asset('assets/img/clients/course-detail/play.svg')}}" alt="">
                            <p class="f-w6">@lang('labels.course-detail.tutorial_livestream_course')</p>
                        </div>
                        <div class="rectangle-div rectangle-div__using">
                            <p class="text-left f-w6">@lang('labels.course-detail.using_course')</p>
                            <span>{!! $courseSchedule->cautions !!}</span>
                        </div>
                        @if($user->teacher_category_skills === \App\Enums\Constant::TEACHER_CATEGORY_SKILL)
                            <section class="sub-course">
                                <label for="" class="label-option f-w6">※オプション設定</label>
                                <div class="rectangle-div rectangle-div__option">
                                    <p class="option-label f-w6">個別講座（ビデオ通話）</p>
                                    <div class="option-content">
                                        <div class="date-time" style="display: flex">
                                            <div class="date-time__label f-w6">開催日時</div>
                                            <div>
                                                @if(isset($course->courses))
                                                    @foreach($course->courses as $css)
                                                        <div>
                                                    <span class="date-time__date">
                                                    <img class="icon-option"
                                                         src="{{asset('assets/img/clients/course-detail/date.svg')}}"
                                                         alt="">
                                                    <span>{{Carbon\Carbon::parse($css->start_datetime)->format('m')}}月{{Carbon\Carbon::parse($css->start_datetime)->format('d')}}日</span>
                                                </span>
                                                            <span class="date-time__time">
                                                    <img class="icon-option"
                                                         src="{{asset('assets/img/clients/course-detail/time.svg')}}"
                                                         alt="">
                                                    <span>{{Carbon\Carbon::parse($css->start_datetime)->format('H:i')}} - {{Carbon\Carbon::parse($css->end_datetime)->format('H:i')}}</span>
                                                </span>
                                                        </div>

                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="line-horizontal"></div>
                                        <div class="usage-time">
                                            <span class="usage-time__label f-w6">ご利用時間</span>
                                            <span class="usage-time__value">{{$course->subCourse->courseSchedules[$course->subCourse->courseSchedules->count()-1]->minutes_required}}分</span>
                                        </div>
                                        <div class="line-horizontal"></div>
                                        <div class="price">
                                            <span class="price__label f-w6">料金</span>
                                            <span class="price__value">¥{{number_format($course->subCourse->courseSchedules[$course->subCourse->courseSchedules->count()-1]->price)}}</span>
                                        </div>
                                    </div>

                                </div>

                            </section>
                        @else
                            @if(count($times) > 0)
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
                                            @foreach($times as $key => $time)
                                                <div class="sub-course-time-price">
                                                    <div class="price">
                                                        <span class="usage-time__label f-w6">時間</span>
                                                        <span class="usage-time__value">{{$time}}分</span>
                                                    </div>
                                                    <div class="date-time">
                                                        <div class="usage-time">
                                                            <span class="usage-time__label f-w6">金額</span>
                                                            <span class="price__value">¥{{number_format($moneys[$key])}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                @if(count($times) > 1 && $key+1 < count($times))
                                                    <div class="line-horizontal"></div>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>

                                </section>
                            @endif
                        @endif
                        <div class="explain-content__option-btn position-relative">
                            <a href="{{ $previousUrl }}"
                               class="btn-back position-absolute">戻る</a>
                            @if(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() != 'client.teacher.courses.update.course_schedule.view')
                                <a href="{{ route('client.teacher.courses.edit', ['id' => $course->course_id]) }}"
                                   class="explain-content__option-btn__edit">編集する</a>
                            @else
                                <a href="{{ $previousUrl }}" class="explain-content__option-btn__edit">戻る</a>
                            @endif
                            @if(auth('client')->user()->user_status === \App\Enums\Constant::USER_STATUS_REST)
                                <form method="POST"
                                      action="{{route('client.teacher.courses.update.public-course-schedule-edit.consultation', $courseSchedule->course_schedule_id)}}">
                                    @csrf
                                    <input type="hidden" id="start" name="start_day[]" data-input=""
                                           data-format="Y/m/d"
                                           value="{{($courseSchedule->start_datetime)->format('Y/m/d')}}"
                                           class="flatpickr-input active">
                                    <input type="hidden" id="appt" name="start_time[]" data-input=""
                                           data-datepicker="false" data-format="H:i"
                                           value="{{($courseSchedule->start_date)->format('H:i')}}"
                                           class="flatpickr-input active">
                                    <input type="hidden" value="{{$courseSchedule->minutes_required}}"
                                           name="minutes_required" class="hidden_input">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->price}}" name="price">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->title}}" name="title">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->subtitle}}" name="subtitle">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->body}}" name="body">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->flow}}" name="flow">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->cautions}}" name="cautions">
                                    <input type="hidden" class="f-w3 input-small" placeholder=""
                                           value="{{$courseSchedule->is_mask_required}}" name="is_mask_required">
                                    @if(session()->has('preview_file_' . auth('client')->id()))
                                        @foreach(session()->get('preview_file_' . auth('client')->id()) as $preview)
                                            <input type="hidden" name="previewOld[]" value="{{ json_encode($preview) }}">
                                        @endforeach
                                    @endif
                                    @if(count($times) > 0)
                                        @foreach($times as $time)
                                            <input type="hidden" class="f-w3 input-small" placeholder=""
                                                   value="{{$time}}" name="sub_course_time[]">
                                        @endforeach
                                    @else
                                        <input type="hidden" class="f-w3 input-small" placeholder=""
                                               value="" name="sub_course_time[]">
                                    @endif
                                    @if(count($moneys) > 0)
                                        @foreach($moneys as $money)
                                            <input type="hidden" class="f-w3 input-small" placeholder=""
                                                   value="{{$money}}" name="sub_course_money[]">
                                        @endforeach
                                    @else
                                        <input type="hidden" class="f-w3 input-small" placeholder=""
                                               value="" name="sub_course_money[]">
                                    @endif
                                    <input type="hidden" name="tempCourseSchedule" value="tempCourseSchedule">
                                    <button type="submit" class="explain-content__option-btn__publish">公開する</button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col3 content-table">
                    <div class="Admission-fee">
                        <div class="d-flex align-items-center">
                            <span class="mr-horizontal">@lang('labels.course-detail.course_consultation')</span>

                            <div>
                                <span class="text-bold">{{number_format($courseSchedule['price'])}}</span>
                                <small>(@lang('labels.course-detail.tax_included_course'))</small>
                            </div>
                        </div>
                        <div class="option-list text-left">
                            <div class="rectangle d-flex flex-column justify-content-center align-items-center position-relative choose-option-preview choose-option active">
                                <span class="rectangle__date">{{date('m', strtotime($courseSchedule['start_datetime']))}}月{{date('d', strtotime($courseSchedule['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($courseSchedule['start_datetime']))]}})</span>
                                <span class="rectangle__time">{{ $courseSchedule->hour_minute }}</span>
                                {{--                                <img class="icon-arrow position-absolute"--}}
                                {{--                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">--}}
                                <span class="rectangle__text">{{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$course->dist_method] }}</span>
                                <span id="rectangle__price"
                                      style="display: none">{{ number_format($courseSchedule['price']) }}</span>
                                <span id="deadline" style="display: none"> {{ (date('m', strtotime($courseSchedule['purchase_deadline']))) }}月{{ (date('d', strtotime($courseSchedule['purchase_deadline']))) }}日</span>
                                <span id="number_of_participants"
                                      style="display: none">{{ number_format($courseSchedule['fixed_num']) }}</span>
                                <input type="hidden" value="{{ $courseSchedule['course_schedule_id'] }}">
                            </div>

                            <div class="deadline d-flex">
                                <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                                <span class="deadline__result">@lang('labels.course-detail.money_course')(金)</span>
                            </div>
                            <button id="purchase_procedure">@lang('labels.course-detail.purchase_procedure_course') </button>
                            <span class="Admission-fee__warning text-center">※キャンセルは開催日前日２1:５９まで</span>
                        </div>
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
                            <p class="seller-profile__header--cat">{{ $user->full_name }}</p>
                            @if((int)$courseSchedule->is_mask_required === 0)
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
                                <div class="identification d-flex justify-content-center align-items-center position-relative">
                                    <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
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
                                    <div class="identification d-flex justify-content-center align-items-center position-relative @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION) identification-large @endif">
                                        <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                        <img class="icon-identification position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                             alt="">
                                        <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                        <img class=" icon-tick position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    </div>
                                @endif
                                @if($user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING
                                            && $user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                    <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION) nondisclosure-agreement-small @endif">
                                        <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                        <img class="position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                             alt="">
                                        <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                        <img class=" icon-tick position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    </div>
                                @endif
                                @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION
                                    && $user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                    <div class="nondisclosure-agreement d-flex justify-content-center align-items-center length-div  position-relative @if($user->teacher_category_consultation === \App\Enums\DBConstant::TEACHER_CATEGORY_CONSULTATION ) nondisclosure-agreement-small @endif">
                                        <img class="position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                             alt="">
                                        <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                        <img class=" icon-tick position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="d-flex flex-wrap mx-pc-11">
                            <div class="question d-flex justify-content-center align-items-center position-relative">
                                <img class="icon-question position-absolute"
                                     src="{{asset('assets/img/clients/course-detail/question.svg')}}" alt="">
                                <a href="#"
                                   class="btn-question text-center">@lang('labels.course-detail.question_course')</a>
                            </div>
                            <div class="follow-us d-flex justify-content-center align-items-center position-relative">
                                <button type="button" data-toggle="modal" data-target="#modal-follow"
                                        class="btn-follow-us ">@lang('labels.course-detail.follow_course')
                                </button>
                                <img class="icon-follower position-absolute"
                                     src="{{asset('assets/img/clients/course-detail/follower.svg')}}" alt="">
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
                                <span class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
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
    <div class="Admission-fee-app">
        @if(!empty($course->category->type))
            @switch($course->category->type)
                @case($course->category->type === 1)
                <span class="mr-5">@lang('labels.course-detail.course_livestream')</span>
                @break
                @case($course->category->type === 2)
                <span class="mr-5">@lang('labels.course-detail.course_consultation')</span>
                @break
                @default
                <span class="mr-5">@lang('labels.course-detail.course_fortune')</span>
            @endswitch
        @endif
        <span class="text-bold"></span>{{number_format($courseSchedule['price'])}}
        <small>(@lang('labels.course-detail.tax_included_course'))</small>
        <div class="option-list text-left d-flex">
            <div class="content-left">
                @if(isset($course->courseSchedules) && count($course->courseSchedules) > 0)
                    <div class="d-flex flex-column">
                        @php
                            $order = 0;
                        @endphp

                        <div data-id="{{ $courseSchedule["course_schedule_id"] }}"
                             data-id="{{ $courseSchedule["course_schedule_id"] }}"
                             data-price="{{ number_format($courseSchedule['price']) }}"
                             data-number_of_participants="{{ number_format($courseSchedule['num_of_applicants']) }}人"
                             data-deadline="{{ (date('m', strtotime($courseSchedule['purchase_deadline']))) }}月{{ (date('d', strtotime($courseSchedule['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($courseSchedule['purchase_deadline']))] }})"
                             href="#" data-toggle="modal" data-target="#modal-choose-schedule"
                             class="rectangle-sp d-flex flex-column justify-content-center align-items-center choose-option position-relative active">
                            <span class="rectangle-sp__date">{{date('m', strtotime($courseSchedule['start_datetime']))}}月{{date('d', strtotime($courseSchedule['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($courseSchedule['start_datetime']))]}})</span>
                            <span class="rectangle-sp__time">{{date_format(date_create($courseSchedule['start_datetime']), 'H:i')}} - {{date_format(date_create($courseSchedule['end_datetime']), 'H:i')}}</span>
                            {{--                                <img class="icon-arrow position-absolute"--}}
                            {{--                                     src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">--}}
                            <span
                                    class="rectangle-sp__text">{{\App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$course->dist_method]}}</span>
                            <span id="rectangle-sp__price"
                                  style="display: none">¥{{number_format($courseSchedule['price'])}}</span>
                            <span id="deadline" style="display: none"> {{(date('m', strtotime($courseSchedule['purchase_deadline'])))}}月{{(date('d', strtotime($courseSchedule['purchase_deadline'])))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($courseSchedule['purchase_deadline']))]}})</span>
                            <span id="number_of_participants"
                                  style="display: none">{{number_format($courseSchedule['fixed_num'])}}</span>
                            <input type="hidden" value="{{$courseSchedule['course_schedule_id']}}">
                        </div>

                    </div>
                @endif
                @if(isset($course->courseSchedules) && count($course->courseSchedules) > 0)
                    <div class="deadline d-flex">
                        <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                        <span class="deadline__result">（@lang('labels.course-detail.money_course'))</span>
                    </div>
                @endif
            </div>
            <div class="content-right">
                <div>
                    <button type="submit"
                            id="purchase_procedure">@lang('labels.course-detail.purchase_procedure_course') </button>
                </div>
                <span class="warning text-center">@lang('labels.course-detail.waring_time')</span>
            </div>
        </div>
    </div>
    {{--End Admission-fee-app--}}

    {{--    @include('client.screen.course-detail.choose-schedule-sp', ['data' => $courseSchedule->toArray(), 'consultationPreview'=> true])--}}
@endsection
@section('script')
    <script src="{{ mix('js/clients/modules/livestream.js') }}"></script>
@endsection
