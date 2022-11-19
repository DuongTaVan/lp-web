@extends('client.base.base')
@section('css')
    <link href="{{ mix('css/clients/home-private.css') }}" rel="stylesheet">
    <link href="{{ mix('css/clients/modules/livestream.css')}}" rel="stylesheet">
    <style>
        #purchase_procedure{
            background: #9B9F9E !important;
        }
    </style>
@endsection
@section('content')
    <div id="course-detail" class="course-outline">
        <div class="content">
            <input id="course_schedule_id" value="1" type="hidden">
            <input id="currentPage" value="1" type="hidden">
            <div class="d-flex flex-wrap">
                <div class="col-12 col-xl-9 content-description">
                    <p class="description-title text-left f-w6">{{ $course->title }}</p>
                    <div class="sub-description-title text-left">{!! $course->subtitle !!}</div>
                    <div class="rating position-relative d-flex  align-items-start">
                        <div class="d-flex info-teacher mr-3">
                            <img class=""
                                 src="{{ $user->profile_image }}"
                                 alt="" style="border-radius: 50%" width="30" height="30">
                            <div class="title_name">{{ $user->full_name }}</div>
                        </div>
                        <div class="d-flex rating-position">
                            <ul class="content-rating d-flex">
                                @include('client.common.rating-star',['rating'=> ratingProcess($avgRating)])
                            </ul>
                            <div class="rating__star rating__star-number">
                                <span class="average">{{ ratingProcess($avgRating) }}</span>
                                <span class="votes">({{ $sumRating }})</span>
                            </div>
                        </div>
                    </div>
                    <div class="explain-content">
                        <div>
                            <img class="family"
                                 src='{{ $course->imagePaths ? $course->imagePaths['0']->image_url : asset('assets/img/portal/default-image.svg') }}'
                                 alt="" width="900" height="497">
                        </div>
                        <div class="three-image d-flex w-100">
                            @if(count($course->imagePaths) >= 2)
                                @for($i = 1; $i<count($course->imagePaths); $i++)
                                    <img src='{{ $course->imagePaths[$i]->image_url }}' alt="">
                                @endfor
                            @endif
                        </div>
                        <div class="rectangle-div rectangle-div__about-content">
                            <p class="text-left f-w6">@lang('labels.course-detail.content_course')</p>
                            <span class="text-content body">{!! $course->body !!}</span>
                            <p class="read-more__open text-center"
                               style="display: none">@lang('labels.course-detail.read_more_course')</p>
                            <p class="read-more__close text-center"
                               style="display: none">@lang('labels.course-detail.read_more_course_close')</p>
                        </div>
                        <div class="rectangle-div rectangle-div__flow-day">
                            <p class="text-left f-w6">@lang('labels.course-detail.follow_day_course')</p>
                            <span>{!! $course->flow !!}</span>
                        </div>
                        <div class="live-stream d-flex align-items-center">
                            <img src="{{asset('assets/img/clients/course-detail/play.svg')}}" alt="">
                            <p class="f-w6">@lang('labels.course-detail.tutorial_livestream_course')</p>
                        </div>
                        <div class="rectangle-div rectangle-div__using">
                            <p class="text-left f-w6">@lang('labels.course-detail.using_course')</p>
                            <span>{!! $course->cautions !!}</span>
                        </div>
                        @if(isset($course->courses) && $course->courses->count() > 0)
                            <section class="sub-course">
                                <label for="" class="label-option f-w6">※オプション設定</label>
                                <div class="rectangle-div rectangle-div__option">
                                    <p class="option-label f-w6">延長リクエスト</p>

                                    <div class="option-content">
                                        <div class="date-time">
                                            <div class="usage-time">
                                                <span class="usage-time__label f-w6">時間</span>
                                                @foreach($course->courses as $c)
                                                    <span class="price__value">¥{{number_format($c->price)}}</span>
                                                    @if($course->courses->count() > 1)
                                                        <span>|</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="line-horizontal"></div>

                                        </div>

                                        <div class="price">
                                            <span class="price__label f-w6">金額</span>
                                            @foreach($course->courses as $c)
                                                <span class="usage-time__value">{{$c->minutes_required}}分</span>
                                                @if($course->courses->count() > 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                            </section>
                        @endif
                        <div class="explain-content__option-btn">
                            <div class="explain-content__option-btn position-relative">
                                {{-- <a href="{{ route('client.teacher.courses.update.course.view', ['id' => $course->course_id]) }}"
                                   class="explain-content__option-btn__edit">編集する</a> --}}
                                @if(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'client.teacher.courses.update.course_schedule.view')
                                    <style>
                                        .back {
                                            text-decoration: none;
                                            width: 150px;
                                            height: 41px;
                                            line-height: 41px;
                                            font-size: 14px;
                                            font-weight: 700;
                                            color: #2A3242;
                                            border: 1px solid #4E576833;
                                            background-color: #FFFFFF;
                                            border-radius: 5px;
                                        }
                                    </style>

                                    <div class="back-container">
                                        <a href="{{url()->previous()}}" type="button"
                                           class="back">戻る</a>
                                    </div>
                                @endif
                                @if(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() != 'client.teacher.courses.update.course_schedule.view')
                                    <a href="{{ route('client.teacher.courses.update.course.view', ['id' => $course->course_id]) }}"
                                       class="explain-content__option-btn__edit">編集する</a>
                                @else
                                    <style>
                                        .back {
                                            text-decoration: none;
                                            width: 150px;
                                            height: 41px;
                                            line-height: 41px;
                                            font-size: 14px;
                                            font-weight: 700;
                                            color: #2A3242;
                                            border: 1px solid #4E576833;
                                            background-color: #FFFFFF;
                                            border-radius: 5px;
                                        }
                                    </style>

                                    <div class="back-container">
                                        <a href="{{url()->previous()}}" type="button"
                                           class="back">戻る</a>
                                    </div>
                                @endif
                                @if(auth('client')->user()->user_status === \App\Enums\Constant::USER_STATUS_REST)
                                    <a href="{{ route('client.teacher.courses.public', ['courseId' => $course->course_id, 'status' => \App\Enums\DBConstant::COURSE_STATUS_OPEN]) }}"
                                       class="explain-content__option-btn__publish">公開する</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-xl-3 content-table">
                    <div class="Admission-fee">
                        <span class="mr-5">@lang('labels.course-detail.admission_fee_course')</span>
                        <span class="text-bold"></span>
                        <small>(@lang('labels.course-detail.tax_included_course'))</small>
                        <div class="option-list text-left">
                            @foreach($course->courseSchedules as $key => $item)
                                <div id="option{{ $key }}"
                                     class="rectangle d-flex flex-column justify-content-center align-items-center position-relative choose-option-preview choose-option @if($key == 0) select-course @endif">
                                    <span class="rectangle__date">{{date('m', strtotime($item['start_datetime']))}}月{{date('d', strtotime($item['start_datetime']))}}日({{\App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['start_datetime']))]}})</span>
                                    <span class="rectangle__time">{{ $item->hour_minute }}</span>
                                    <img class="icon-arrow position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/arrow-down.png')}}">
                                    <span class="rectangle__text">{{ \App\Enums\Constant::COURSE_DETAIL_DIST_METHOD[$course->dist_method] }}</span>
                                    <span id="rectangle__price" style="display: none"
                                          data-id="{{ $key }}">{{ number_format($item['price']) }}</span>
                                    <span id="deadline" style="display: none" data-id="{{ $key }}"> {{ (date('m', strtotime($item['purchase_deadline']))) }}月{{ (date('d', strtotime($item['purchase_deadline']))) }}日({{ \App\Enums\Constant::DAY_JAPANESE[date('l', strtotime($item['purchase_deadline']))] }})</span>
                                    <span id="number_of_participants" style="display: none"
                                          data-id="{{ $key }}">{{ number_format($item['fixed_num']) }}</span>
                                    <input type="hidden" value="{{ $item['course_schedule_id'] }}">
                                </div>
                            @endforeach
                            <div class="deadline d-flex">
                                <span class="deadline__title">@lang('labels.course-detail.deadline_course')</span>
                                <span class="deadline__result">@lang('labels.course-detail.money_course')(金)</span>
                            </div>
                            <button id="purchase_procedure">@lang('labels.course-detail.purchase_procedure_course') </button>
                            @if(count($course->optionalExtras))
                                <section id="charged-option">
                                    <div id="option-schedule"
                                         class="charged-option d-flex justify-content-center align-items-center">
                                        <img src="{{asset('assets/img/clients/course-detail/circle-plus.svg')}}"
                                             alt="">
                                        <span class="charged-option-text">@lang('labels.course-detail.charged_option_course')</span>
                                        <img class="arrow-down"
                                             src="{{asset('assets/img/clients/course-detail/arrow-right-grey.svg')}}"
                                             alt="">
                                    </div>
                                    <div class="table-option disable-option">
                                        @foreach($course->optionalExtras as $key => $item)
                                            <div class="table-option-item d-flex align-items-center justify-content-between">
                                                <label class="checkbox">
                                                    <input type="checkbox"
                                                           data-value="{{($item['optional_extra_id'])}}"
                                                           value="{{$item['title']}}"> {{ $item['title'] }}
                                                    <span class="checkmark"></span>
                                                </label>
                                                <div>
                                                    <img src="{{asset('assets/img/clients/course-detail/add.svg')}}"
                                                         alt="">
                                                    <span>¥{{number_format($item['price'])}}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                            <span class="Admission-fee__warning text-center">※キャンセルは開催日前日２1：５９まで</span>
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
                            @if($course->is_mask_required === 0)
                                <div class="formality fs-12 fw-600">
                                    @lang('labels.course-detail.formality')
                                    <span>(OK)</span>
                                </div>
                            @else
                                <div class="formality fs-12 fw-600">
                                    @lang('labels.course-detail.formality')
                                    <span class="fs-12 fw-600">(NG)</span>
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
                        @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS)
                            <div class="d-flex flex-wrap justify-content-center">
                                <div class="identification d-flex justify-content-center align-items-center position-relative">
                                    <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                    <img class="icon-identification position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/identification.svg')}}" alt="">
                                    <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                    @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                        <img class=" icon-tick position-absolute"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="identification d-flex justify-content-center align-items-center position-relative">
                                    <div class="identification-tooltip">@lang('labels.course-detail.identity_verification')</div>
                                    <img class="icon-identification position-absolute"
                                         src="{{asset('assets/img/clients/course-detail/identification.svg')}}"
                                         alt="">
                                    <button class="btn-identification ">@lang('labels.course-detail.identity')</button>
                                    @if($user->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                        <img class=" icon-tick position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                             alt="">
                                    @endif
                                </div>
                                <div class="nondisclosure-agreement d-flex justify-content-center align-items-center  position-relative">
                                    <div class="nondisclosure-agreement-tooltip">@lang('labels.course-detail.confidentiality_agreement')</div>
                                    @if($user->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS || $user->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING)
                                        <img class="position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/nondisclosure-agreement.svg')}}"
                                             alt="">
                                        @if($user->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                            <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                            <img class=" icon-tick position-absolute"
                                                 src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                 alt="">
                                        @else
                                            <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.confidentiality')</button>
                                        @endif
                                    @else
                                        <img class="position-absolute icon-nondisclosure-agreement"
                                             src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                             alt="">
                                        <button class="btn-nondisclosure-agreement">@lang('labels.course-detail.qualification')</button>
                                        @if($user->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                            <img class=" icon-tick position-absolute"
                                                 src="{{asset('assets/img/clients/course-detail/tick.svg')}}"
                                                 alt="">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="d-flex flex-wrap mb-1">
                            <div class="question d-flex justify-content-center align-items-center position-relative disable-cursor">
                                <button class="btn-question">
                                    <img class="icon-question"
                                         src="{{asset('assets/img/clients/course-detail/question.svg')}}" alt="">
                                    <span>@lang('labels.course-detail.question_course')</span></button>
                            </div>
                            <div class="follow-us d-flex justify-content-center align-items-center position-relative disable-cursor">
                                <button type="button" class="btn-follow-us ">
                                    <img class="icon-follower"
                                         src="{{asset('assets/img/clients/course-detail/follower.svg')}}" alt="">
                                    <span>@lang('labels.course-detail.follow_course')</span>
                                </button>

                            </div>
                        </div>
                        <div class="seller-profile__footer position-relative">
                            @if (isset($user->catchphrase))
                                <p class="seller-profile__footer__catchphrase check-height">{{ $user->catchphrase }}</p>
                                <div class="position-absolute see-all">
                                    <span class="fs-12">@lang('labels.course-detail.see_all_course')</span>
                                    <img class="arrow-down"
                                         src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}" alt="">
                                </div>
                                <div class="position-absolute compact-text">
                                    <span class="fs-12">@lang('labels.course-detail.read_more_course_close')</span>
                                    <img class="arrow-down"
                                         src="{{ asset('assets/img/clients/course-detail/arrow-right.svg') }}" alt="">
                                </div>
                            @else
                                <span class="d-flex justify-content-center">@lang('labels.course-detail.message.no_information_course')</span>
                            @endif
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-between">
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
                <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text text-center">フォローリストに登録します</p>
                                <div class="popup-content-button d-flex justify-content-center">
                                    <button class="cancel text-center"
                                            data-dismiss="modal">キャンセル
                                    </button>
                                    <form method="POST"
                                          action="">
                                        <input type="hidden" name="_token"
                                               value="t7YLCKGUbiqBpCDkw6Iuwi33oRR8qRMMTEDllENV">
                                        <button type="submit"
                                                class="flowUs text-center">フォローする
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=60fe75f919c512001348300e&product=inline-share-buttons'
            async='async'></script>
    <script src="{{ mix('js/clients/modules/livestream.js') }}"></script>
@endsection
