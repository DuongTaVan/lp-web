@extends('client.base.base-livestream')
@section('content')
    <div class="livestream-container">
        <div class="container">
            {{--Student Livestream Header--}}
            @include('client.screen.student-livestream.__partials.livestream_header')
            {{--End Student Livestream Header--}}
            {{--Join Course Body--}}
            <div class="livestream-course-body">
                <div class="course-livestream">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="livestream-block-course mb-2">
                                {{--                                <iframe width="100%" height="531"--}}
                                {{--                                        src="https://www.youtube.com/embed/2GVOX6xBKQA?list=PLhaQUW-_5lHbDiKuLBAVWG1BDxejopwCy"--}}
                                {{--                                        title="YouTube video player" frameborder="0"--}}
                                {{--                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"--}}
                                {{--                                        allowfullscreen></iframe>--}}
                                <img src="{{asset('assets/img/student-live-stream/student-live-demo.jpg')}}" alt="">
                                <div class="livestream-control">
                                    <div class="d-flex justify-content-between text-center">
                                        <div class="flex-fill bd-highlight btn-control-custom">
                                            <button class="btn btn-speaker"><img
                                                        src="{{asset('assets/img/icons/speaker.svg')}}"
                                                        alt="speaker">
                                            </button>
                                            <br>
                                            <span>{{__('labels.users.join_course.volume')}}</span>
                                        </div>
                                        <div class="flex-fill bd-highlight btn-control-custom">
                                            <button class="btn btn-control-custom btn-call">
                                                <img src="{{asset('assets/img/icons/Call.svg')}}" alt="call">
                                            </button>
                                            <br>
                                            <span>{{__('labels.users.join_course.end_call')}}</span>
                                        </div>
                                        <div class="flex-fill bd-highlight btn-control-custom"></div>
                                    </div>
                                </div>
                                <div class="live-viewers">
                                    <strong>{{__('labels.users.student_live_stream.live')}}</strong>
                                </div>
                                <div class="date-live">03分 32秒</div>
                                <div class="video-call">
                                    <img src="{{asset('assets/img/student-live-stream/video-call.jpg')}}" alt="">
                                    <div class="dropdown-option-video-call">
                                        <img id="vc-btn"
                                             src="{{asset('assets/img/student-live-stream/icon/dropdown.svg')}}"
                                             alt="svg" class="btn btn-custom drop-btn-video-call">
                                        <div id="dropdown-video-call"
                                             class="dropdown-video-call dropdown-video-call-custom ">
                                            <a href="javascript:;">{{__('labels.users.student_live_stream.video_call.background_change')}}</a>
                                            <a href="javascript:;">{{__('labels.users.student_live_stream.video_call.choose_mask')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Extension Request--}}
                        <div class="col-12 col-md-4 pl-0">
                            <div class="extension-request">
                                <div class="extension-request__title"> {{__('labels.users.student_live_stream.video_call.extension_request')}}</div>
                                <form action="javascript:;">

                                    <div class="extension-request__price">
                                        <div class="extension-request__price__option">
                                            <label class="extension-request__price__option__option-outline">
                                                <span>30分 / ¥4,000</span>
                                                <input type="radio" checked="checked" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="extension-request__price__option">
                                            <label class="extension-request__price__option__option-outline">
                                                <span>60分  / ¥6,000</span>
                                                <input type="radio" name="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    {{--refuse-request-text --}}
                                    {{--  <div class="extension-request__refuse-request-text">只今は受け付けておりません。</div>--}}
                                    <div class="extension-request__submit">
                                        <button type="submit" class="btn extension-request__submit__btn-sent-request">
                                            {{__('labels.users.student_live_stream.video_call.purchase_procedure')}}
                                        </button>
                                    </div>
                                    <div class="extension-request__dropdown-option">
                                        <div class="dropdown">
                                            <span class="dropdown-toggle extension-request__dropdown-option__btn-dropdown-toggle"
                                                  data-toggle="dropdown">
                                                <img src="{{asset('assets/img/student-live-stream/icon/primary_plus.svg')}}"
                                                     alt=""
                                                     class="extension-request__dropdown-option__btn-dropdown-toggle__icon-primary-plus">
                                                <span>{{__('labels.users.student_live_stream.video_call.charged_option')}}</span>
                                                <img src="{{asset('assets/img/student-live-stream/icon/dropdown_arrow.svg')}}"
                                                     alt=""
                                                     class="extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow">
                                            </span>
                                            <ul class="dropdown-menu extension-request__dropdown-option__menu-custom">
                                                <li>
                                                    <input type="checkbox" name="">
                                                    <span class="extension-request__dropdown-option__menu-custom__name">オプション．．．．．．．</span>
                                                    <span class="extension-request__dropdown-option__menu-custom__price"><img
                                                                src="{{asset('assets/img/student-live-stream/icon/add.svg')}}"
                                                                alt="">¥5,000</span>
                                                </li>
                                                <li>
                                                    <input type="checkbox" name="">
                                                    <span class="extension-request__dropdown-option__menu-custom__name">オプション．．．．．．．</span>
                                                    <span class="extension-request__dropdown-option__menu-custom__price"><img
                                                                src="{{asset('assets/img/student-live-stream/icon/add.svg')}}"
                                                                alt="">¥5,000</span>
                                                </li>
                                                <li>
                                                    <input type="checkbox" name="">
                                                    <span class="extension-request__dropdown-option__menu-custom__name">オプション．．．．．．．</span>
                                                    <span class="extension-request__dropdown-option__menu-custom__price"><img
                                                                src="{{asset('assets/img/student-live-stream/icon/add.svg')}}"
                                                                alt="">¥5,000</span>
                                                </li>
                                                <li>
                                                    <input type="checkbox" name="">
                                                    <span class="extension-request__dropdown-option__menu-custom__name">オプション．．．．．．．</span>
                                                    <span class="extension-request__dropdown-option__menu-custom__price"><img
                                                                src="{{asset('assets/img/student-live-stream/icon/add.svg')}}"
                                                                alt="">¥5,000</span>
                                                </li>
                                                <li>
                                                    <input type="checkbox" name="">
                                                    <span class="extension-request__dropdown-option__menu-custom__name">オプション．．．．．．．</span>
                                                    <span class="extension-request__dropdown-option__menu-custom__price"><img
                                                                src="{{asset('assets/img/student-live-stream/icon/add.svg')}}"
                                                                alt="">¥5,000</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{--End Extension Request--}}
                    </div>
                </div>
                {{--End Join Course Body--}}
            </div>
            {{--Modal Report--}}
            @include('client.screen.student-livestream.__partials.modal_report')
            {{--End Modal Report--}}
        </div>
    </div>
@endsection
