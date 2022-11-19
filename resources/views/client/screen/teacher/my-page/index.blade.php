@extends('client.base.base')
@section('header')
    <meta property="og:type" content="website">
    <meta property="twitter:title" name="twitter:title" content="{{ $data['users']->full_name ?? null }}"/>
    <meta property="twitter:image" name="twitter:image"
          content="{{ $data['users']['profile_image'] ?? 'assets/img/portal/default-image.svg' }}"/>
    <meta property="og:title" name="og:title" content="{{ $data['users']->full_name ?? null }}"/>
    <meta property="og:image" name="og:image"
          content="{{ $data['users']['profile_image'] ?? 'assets/img/portal/default-image.svg' }}"/>
    @if (app('request')->input('tab') === 'review' && $data['reviews']->first() && $data['reviews']->first()->comment)
        <meta property="twitter:description" name="twitter:description"
              content="{{ $data['reviews']->first()->comment }}"/>
        <meta property="og:description" name="og:description" content="{{ $data['reviews']->first()->comment }}"/>
    @elseif (app('request')->input('tab') === 'service' && $data['courses'] && $data['courses']->first()->body)
        <meta property="twitter:description" name="twitter:description"
              content="{{ $data['courses']->first()->body }}"/>
        <meta property="og:description" name="og:description" content="{{ $data['courses']->first()->body }}"/>
    @else
        <meta property="twitter:description" name="twitter:description" content="{{ $data['users']->catchphrase }}"/>
        <meta property="og:description" name="og:description" content="{{ $data['users']->catchphrase }}"/>
    @endif
    <meta name="description" content="{{ $data['users']->biography ?? null }}">
    <title>{{ $data['users']->full_name ?? null }}</title>
@endsection
@section('css')
    <style>
        .base-content {
            padding-bottom: unset !important;
        }

        .full-star-active, .full-star-non-active {
            margin: 0 2px;
        }

        .btn-custom-line {
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5px 0 7px !important;
        }

        .btn-custom-twitter {
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 4.67px 0 4.83px !important;
        }

        .btn-custom-fb {
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 16.01px 0 6.77px !important;
        }
        .achievement {
            position: relative;
            cursor: pointer;
        }
        .tooltip-custom{
            display: block !important;
        }
        .identification-tooltip {
            display: none;
            padding: 5px 10px;
            background: #4e5768;
            color: #fff;
            font-weight: normal;
            font-size: 14px;
            border-radius: 5px;
            position: absolute;
            top: 34px;
            right: 30px;
            z-index: 1;
            width: 160px;
            height: auto;
        }
        .identification-tooltip::after {
            border-bottom: 9px solid #4e5768;
            border-left: 9px solid rgba(0, 0, 0, 0);
            border-right: 9px solid rgba(0, 0, 0, 0);
            content: "";
            display: inline-block;
            left: 45%;
            position: absolute;
            top: -6px;
        }
        .nondisclosure-agreement-tooltip {
            display: none;
            padding: 5px 10px;
            background: #4e5768;
            color: #fff;
            font-weight: normal;
            font-size: 14px;
            border-radius: 5px;
            position: absolute;
            top: 34px;
            left: -63px;
            z-index: 1;
            width: 174px;
            height: auto;
        }
        .nondisclosure-agreement-tooltip::after {
            border-bottom: 9px solid #4e5768;
            border-left: 9px solid rgba(0, 0, 0, 0);
            border-right: 9px solid rgba(0, 0, 0, 0);
            content: "";
            display: inline-block;
            left: 45%;
            position: absolute;
            top: -6px;
        }
        .nondisclosure-agreement-tooltip {
            display: none;
            padding: 5px 10px;
            background: #4e5768;
            color: #fff;
            font-weight: normal;
            font-size: 14px;
            border-radius: 5px;
            position: absolute;
            top: 34px;
            left: -68px;
            z-index: 1;
            width: 174px;
            height: auto;
        }
        .nondisclosure-agreement-tooltip::after {
            border-bottom: 9px solid #4e5768;
            border-left: 9px solid rgba(0, 0, 0, 0);
            border-right: 9px solid rgba(0, 0, 0, 0);
            content: "";
            display: inline-block;
            left: 45%;
            position: absolute;
            top: -6px;
        }

        @media only screen and (max-width: 414px) {
            .layout-content {
                /*padding-top: 23%;*/
            }
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="tabValue" value="{{ app('request')->input('tab') }}">
    <div class="teacher-detail">
        <div class="teacher-info position-relative text-center">
            <div class="text-center position-relative">
                <div class="cover">
                    <img src="{{asset('assets/img/teacher-page/image 10.png')}}" alt="cover">
                    <div class="teacher-outline">
                        <img src="{{$data['users']['profile_image'] ?? 'assets/img/portal/default-image.svg'}}"
                             class="img-fluid avatar" alt="">
                        <div class="armorial">
                            @if(isset($data['users']['rank_id']))
                                @switch($data['users']['rank_id'])
                                    @case(\App\Enums\DBConstant::BRONZE)
                                    <img src="{{asset('assets/img/teacher-page/icon/Bronze.svg')}}"
                                         class="img-fluid armorial-icon" width="58" height="72" alt="">
                                    @break
                                    @case(\App\Enums\DBConstant::SILVER)
                                    <img src="{{asset('assets/img/teacher-page/icon/Silver.svg')}}"
                                         class="img-fluid armorial-icon" width="58" height="72" alt="">
                                    @break
                                    @case(\App\Enums\DBConstant::GOLD)
                                    <img src="{{ asset('assets/img/search/icon/Gold.svg') }}"
                                         class="img-fluid armorial-icon" width="58" height="72" alt="">
                                    @break
                                    @case(\App\Enums\DBConstant::PLATINUM)
                                    <img src="{{asset('assets/img/teacher-page/icon/Platium.svg')}}"
                                         class="img-fluid armorial-icon" width="58" height="72" alt="">
                                    @break
                                    @default
                                @endswitch
                            @endif
                        </div>
                    </div>
                    <div class="rank-popup-teacher">
                        @include('client.common.popup-rank', ['data' => $data['users']])
                    </div>
                </div>
            </div>
            <div class="teacher-name">
                <span title="{{$data['users']['full_name']}}">{{$data['users']['full_name'] ?? ''}}</span>
            </div>
            <div class="teacher_catchphase">
                <span>{{$data['users']['catchphrase'] ?? ''}}</span>
            </div>
            <div class="container teacher-detail-container">
                <div class="row">
                    <div class="col-md-12">
                        @if($data['users']->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS
                            && $data['users']->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                            <div class="d-flex justify-content-center my-2">
                                <div class="bd-highlight achievement">
                                    <div class="identification-tooltip identification-add">@lang('labels.course-detail.identity_verification')</div>
                                    <img class="achievement-icon"
                                         src="{{asset('assets/img/teacher-page/icon/id1.svg')}}"
                                         alt="id1"><span>本人確認</span>
                                        <svg class="achievement-checked" width="13" height="11" viewBox="0 0 13 11"
                                             fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                                  stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-center my-2">
                                @if($data['users']->identity_verification_status === \App\Enums\DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED)
                                    <div class="bd-highlight achievement">
                                        <div class="identification-tooltip identification-add">@lang('labels.course-detail.identity_verification')</div>
                                        <img class="achievement-icon"
                                             src="{{asset('assets/img/teacher-page/icon/id1.svg')}}"
                                             alt="id1"><span class="qualification-text">本人確認</span>

                                        <svg class="achievement-checked" width="13" height="11" viewBox="0 0 13 11"
                                             fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                                  stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </div>
                                @endif
                                @if($data['users']->teacher_category_skills === \App\Enums\DBConstant::TEACHER_CATEGORY_SKILLS || $data['users']->teacher_category_fortunetelling === \App\Enums\DBConstant::TEACHER_CATEGORY_FORTUNETELLING)
                                        <style>
                                            @media only screen and (max-width: 414px) {
                                                .identification-tooltip {
                                                    right: -17px;
                                                }
                                            }
                                        </style>
                                        @if($data['users']->nda_status === \App\Enums\DBConstant::NDA_STATUS_CONTRACT)
                                        <div class="bd-highlight achievement achievement--nda">
                                            <div
                                                    class="nondisclosure-agreement-tooltip identification-add">@lang('labels.course-detail.credentials')</div>
                                            <img style="margin-bottom: 5px;" class="achievement-icon"
                                                 src="{{asset('assets/img/teacher-page/icon/deal1.svg')}}"
                                                 alt="deal1">
                                            <span> 機密保持契約(NDA)</span>

                                            <svg class="achievement-checked achievement-checked--right" width="13"
                                                 height="11" viewBox="0 0 13 11"
                                                 fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                                      stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </div>
                                    @endif
                                @else
                                    @if($data['users']->business_card_verification_status === \App\Enums\DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_APPROVED)
                                            <div class="bd-highlight achievement achievement--nda_fortunetelling ">
                                            <div class="nondisclosure-agreement-tooltip identification-add">資格証明書：確認済み</div>
                                            <img width="20" height="17"
                                                 src="{{asset('assets/img/clients/course-detail/qualification.svg')}}"
                                                 alt="deal1">
                                            <span class="qualification-text"> 資格保有</span>

                                            <svg class="achievement-checked achievement-checked--right" width="13"
                                                 height="11" viewBox="0 0 13 11"
                                                 fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 5.01222L5.01222 9.02444L11.6993 1" stroke="#4BBD8B"
                                                      stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                        <div class="my-2 d-flex justify-content-center evaluate">
                            <div class="bd-highlight star-evaluate">
                                @include('client.common.show-star', ['rating' => $data['reviewTeacher'] ? $data['reviewTeacher'][0]->avg_rating : 0])
                            </div>
                            <span
                                    class="evaluate-text"><strong>@if($data['reviewTeacher']) {{ $data['reviewTeacher'][0]->avg_rating >= 5 ? 5 : ratingProcess($data['reviewTeacher'][0]->avg_rating) }} @else 0 @endif</strong>(レビュー{{number_format($data['reviewTeacher'] ? $data['reviewTeacher'][0]->totalRecord : 0, 0, ',', ',')}} 件)</span>
                        </div>
                        <div class="achievement-number">
                            <div class="d-flex justify-content-end bd-highlight achievement-number-content">
                                <div class="bd-highlight achievement"><span>{{__('labels.users.teacher_screen.holding_result')}}: <strong>{{$data['countCourseScheduleHeld']}}</strong></span>
                                </div>
                                <div class="bd-highlight achievement">
                                    <span>{{__('labels.users.teacher_screen.users_number')}}: <strong>{{$data['countHoldingResult']}}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="teacher-paragraph custom-teacher-detail--pd">
                            <div class="d-flex bd-highlight clearfix">
                                <div class="flex-fill ">
                                    <ul class="nav nav-custom" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab"
                                               href="#top">{{__('labels.users.teacher_screen.top.label')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab"
                                               href="#service">{{__('labels.users.teacher_screen.service.label')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab"
                                               href="#review">{{__('labels.users.teacher_screen.review.label')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="flex-fill bd-highlight social social-custom-pd">
                                    <a href="#"
                                       class="btn btn-facebook-custom btn-custom text-white btn-custom-fb">
                                        <svg width="17.41" height="17" viewBox="0 0 20 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M19.686 9.46336C19.686 4.27258 15.4687 0.0637207 10.2674 0.0637207C5.06618 0.0637207 0.848831 4.27258 0.848831 9.46336C0.848831 14.1548 4.29251 18.0435 8.79578 18.7493V12.1813H6.40371V9.46336H8.79578V7.3925C8.79578 5.03714 10.2023 3.73504 12.3534 3.73504C13.384 3.73504 14.4621 3.91883 14.4621 3.91883V6.23224H13.2738C12.1045 6.23224 11.7387 6.95651 11.7387 7.70093V9.46336H14.3507L13.9335 12.1813H11.7391V18.7501C16.2424 18.0447 19.686 14.156 19.686 9.46336Z"
                                                  fill="white"/>
                                        </svg>
                                       <span> {{__('labels.users.teacher_screen.social.facebook')}}</span>
                                    </a>
                                    <a href="#"
                                       class="btn btn-twitter-custom btn-custom text-white btn-custom-twitter">
                                        <svg width="19.66" height="16.28" viewBox="0 0 22 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                    d="M21.0872 2.79459C20.3368 3.12447 19.5306 3.34735 18.6831 3.4481C19.5575 2.92903 20.2118 2.11208 20.5237 1.14968C19.7021 1.63379 18.8029 1.97454 17.8652 2.15714C17.2346 1.48924 16.3994 1.04656 15.4892 0.897799C14.579 0.749042 13.6448 0.902539 12.8315 1.33446C12.0183 1.76638 11.3715 2.45256 10.9917 3.28646C10.6119 4.12037 10.5202 5.05534 10.7309 5.94622C9.06618 5.8633 7.43759 5.43407 5.95088 4.68638C4.46417 3.93868 3.15255 2.88924 2.10116 1.60616C1.74166 2.22133 1.53495 2.93457 1.53495 3.69417C1.53455 4.37798 1.7043 5.05132 2.02915 5.65444C2.354 6.25757 2.8239 6.77183 3.39715 7.15159C2.73233 7.13061 2.08217 6.95241 1.50079 6.63182V6.68531C1.50073 7.64439 1.83516 8.57395 2.44734 9.31627C3.05952 10.0586 3.91175 10.5679 4.85942 10.7579C4.24268 10.9235 3.59608 10.9479 2.96845 10.8292C3.23583 11.6545 3.75665 12.3761 4.45801 12.8931C5.15936 13.4101 6.00615 13.6966 6.8798 13.7125C5.39672 14.8674 3.56512 15.4939 1.67964 15.4911C1.34565 15.4912 1.01194 15.4719 0.680237 15.4332C2.5941 16.6539 4.82197 17.3017 7.0973 17.2992C14.7996 17.2992 19.0102 10.971 19.0102 5.48261C19.0102 5.3043 19.0057 5.12421 18.9976 4.9459C19.8166 4.35835 20.5236 3.63077 21.0854 2.79727L21.0872 2.79459Z"
                                                    fill="white"/>
                                        </svg>

                                        <span>{{__('labels.users.teacher_screen.social.twitter')}}</span>
                                    </a>
                                    <a href="#"
                                       class="btn btn-line-custom btn-custom text-white btn-custom-line">
                                        <svg width="18" height="17" viewBox="0 0 20 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                    d="M15.5696 8.12921C15.6361 8.12692 15.7024 8.13802 15.7645 8.16183C15.8266 8.18565 15.8832 8.2217 15.9311 8.26784C15.9789 8.31398 16.017 8.36926 16.043 8.43038C16.0689 8.49151 16.0823 8.55723 16.0823 8.62363C16.0823 8.69003 16.0689 8.75576 16.043 8.81688C16.017 8.87801 15.9789 8.93329 15.9311 8.97943C15.8832 9.02556 15.8266 9.06161 15.7645 9.08543C15.7024 9.10925 15.6361 9.12034 15.5696 9.11806H14.1927V9.99938H15.5696C15.6365 9.99612 15.7033 10.0065 15.7661 10.0298C15.8289 10.0531 15.8862 10.0888 15.9347 10.1349C15.9832 10.181 16.0218 10.2365 16.0482 10.2979C16.0746 10.3594 16.0882 10.4255 16.0882 10.4923C16.0882 10.5592 16.0746 10.6253 16.0482 10.6868C16.0218 10.7482 15.9832 10.8036 15.9347 10.8497C15.8862 10.8958 15.8289 10.9316 15.7661 10.9549C15.7033 10.9782 15.6365 10.9886 15.5696 10.9853H13.6994C13.5687 10.9848 13.4435 10.9327 13.3511 10.8403C13.2588 10.7479 13.2069 10.6228 13.2067 10.4923V6.75552C13.2067 6.48348 13.4275 6.26021 13.6994 6.26021H15.5731C15.7003 6.26677 15.82 6.32188 15.9075 6.41413C15.995 6.50638 16.0436 6.6287 16.0432 6.75574C16.0428 6.88278 15.9935 7.00481 15.9054 7.09654C15.8174 7.18827 15.6973 7.24267 15.5702 7.24847H14.1933V8.1298L15.5696 8.12921ZM12.5474 10.4917C12.5463 10.6226 12.4935 10.7477 12.4005 10.8399C12.3074 10.9322 12.1817 10.984 12.0506 10.9841C11.973 10.9849 11.8962 10.9676 11.8264 10.9336C11.7566 10.8997 11.6957 10.85 11.6485 10.7885L9.73243 8.18738V10.4912C9.73243 10.6219 9.68039 10.7473 9.58777 10.8397C9.49515 10.9322 9.36953 10.9841 9.23854 10.9841C9.10755 10.9841 8.98193 10.9322 8.88931 10.8397C8.79669 10.7473 8.74465 10.6219 8.74465 10.4912V6.75434C8.74465 6.54341 8.88299 6.35422 9.08195 6.28665C9.13109 6.26933 9.1829 6.26078 9.23501 6.26139C9.38806 6.26139 9.52934 6.34423 9.62411 6.46057L11.5555 9.06753V6.75434C11.5555 6.48231 11.7763 6.25904 12.0494 6.25904C12.3225 6.25904 12.5462 6.48231 12.5462 6.75434L12.5474 10.4917ZM8.04061 10.4917C8.03999 10.6228 7.98735 10.7483 7.89423 10.8407C7.8011 10.9331 7.67509 10.9849 7.54378 10.9847C7.41345 10.9836 7.28883 10.9312 7.197 10.8389C7.10517 10.7466 7.05357 10.6218 7.05342 10.4917V6.75493C7.05342 6.48289 7.27417 6.25962 7.54731 6.25962C7.81986 6.25962 8.0412 6.48289 8.0412 6.75493L8.04061 10.4917ZM6.10568 10.9847H4.23196C4.1008 10.9844 3.97505 10.9325 3.88203 10.8402C3.789 10.7479 3.73622 10.6227 3.73513 10.4917V6.75493C3.73513 6.48289 3.95882 6.25962 4.23196 6.25962C4.5051 6.25962 4.72585 6.48289 4.72585 6.75493V9.99879H6.10568C6.23666 9.99879 6.36229 10.0507 6.45491 10.1432C6.54753 10.2356 6.59957 10.361 6.59957 10.4917C6.59957 10.6225 6.54753 10.7479 6.45491 10.8403C6.36229 10.9328 6.23666 10.9847 6.10568 10.9847ZM19.2093 8.48056C19.2093 4.27312 14.9809 0.848877 9.79071 0.848877C4.60047 0.848877 0.372101 4.27312 0.372101 8.48056C0.372101 12.2509 3.72336 15.409 8.24841 16.0088C8.5551 16.0729 8.97188 16.211 9.0796 16.4712C9.17438 16.7063 9.14082 17.0705 9.11021 17.3191L8.98129 18.1176C8.94421 18.3532 8.79116 19.0453 9.80307 18.6229C10.8179 18.2004 15.2329 15.4283 17.2102 13.1569C18.5624 11.6792 19.2093 10.161 19.2093 8.48056Z"
                                                    fill="white"/>
                                        </svg>
                                       <span> {{__('labels.users.teacher_screen.social.line')}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-fill bd-highlight social">

                            </div>
                            <div class="custom-social-button">
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content tab-content-custom">
        @include('client.screen.teacher.my-page.component.top',['data' => $data])
        @include('client.screen.teacher.my-page.component.course',['data' => $data])
        @include('client.screen.teacher.my-page.component.review',['data' => $data])
    </div>
    @include('client.screen.teacher.my-page.component.modal-login')
    @include('client.screen.teacher.my-page.component.modal-follow',['data' => $data])
@endsection
@section('script')
    <script>
        @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif
    </script>

    <script type="text/javascript"
            src="{{ asset('js/sharethis.js#property=60fe75f919c512001348300e&product=inline-share-buttons') }}"></script>
    <script type="text/javascript" src="{{ mix('js/clients/teachers/teacher-page.js') }}"></script>
    <script>
        function getUrlShare(tab = 'top') {
            return window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + tab;
        }

        $(document).ready(function () {
            const tab = $('#tabValue').val();
            const tabTop = $("a[data-toggle='tab'][href='#top']");
            const tabService = $("a[data-toggle='tab'][href='#service']");
            const tabReview = $("a[data-toggle='tab'][href='#review']");

            tabTop.on("click", function () {
                $('.sharethis-inline-share-buttons').attr('data-share-url', getUrlShare())
            })

            tabService.on("click", function () {
                $('.sharethis-inline-share-buttons').attr('data-share-url', getUrlShare('service'))
            })

            tabReview.on("click", function () {
                $('.sharethis-inline-share-buttons').attr('data-share-url', getUrlShare('review'))
            })

            if (tab === 'review') {
                document.querySelectorAll("[data-toggle='tab'][href='#review']")[0].click();
            } else if (tab === 'service') {
                document.querySelectorAll("[data-toggle='tab'][href='#service']")[0].click();
            } else {
                document.querySelectorAll("[data-toggle='tab'][href='#top']")[0].click();
            }
            $('.achievement').hover(function (e) {
                e.preventDefault();
                $(this).children('.identification-add').toggleClass('tooltip-custom');
            })
        })
    </script>
@endsection
