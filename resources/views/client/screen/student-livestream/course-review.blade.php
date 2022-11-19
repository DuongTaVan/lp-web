@extends('client.base.base')
@section('css')
    <style>
        .container {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .order-view__content__satisfaction__right__rate__rating__list ul li i {
            color: #cccccc;
        }

        .main {
            margin-top: 20px;
        }

        @media only screen and (max-width: 414px) {
            .container {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="main custom-review">
        <div class="container">
            <div class="order-view__header">
                <div class="order-view__header__text">
                    {{__('labels.order-view.review_post')}}
                </div>
            </div>
            <div class="order-view__content">
                <form method="post" id="updateReviewCourse" data-url="{{ route('client.student.course.post-review') }}"
                      data-id="{{ $courseSchedule->course_schedule_id }}">
                    @csrf
                    <div class="order-view__content__title ">
                        <div class="order-view__content__title__text title-review">
                            {{ $courseSchedule->title }}
                        </div>
                    </div>
                    <div class="order-view__content__satisfaction">
                        <div class="order-view__content__satisfaction__left">
                            <div class="order-view__content__satisfaction__left__name">
                                {{__('labels.order-view.level_of_satisfaction')}}
                            </div>
                            <div class="order-view__content__satisfaction__left__require">
                                {{__('labels.order-view.have_to')}}
                            </div>
                        </div>

                        @if(!empty($reviewed))
                            <div class="order-view__content__satisfaction__right">
                                <div class="order-view__content__satisfaction__right__rate">
                                    <div class="order-view__content__satisfaction__right__rate__rating">
                                        <div class="order-view__content__satisfaction__right__rate__rating__list"
                                             id="rating">
                                            @include('client.common.rating-pick-active', ['rating' => $reviewed->rating*2])
                                        </div>
                                        <div class="order-view__content__satisfaction__right__click click-review">
                                            <div class="order-view__content__satisfaction__right__click__text">
                                                {{__('labels.order-view.click_enter')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-view__content__satisfaction__right__rate__text text-review">
                                        {{__('labels.order-view.please_rate')}}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="order-view__content__satisfaction__right">
                                <div class="order-view__content__satisfaction__right__rate">
                                    <div class="order-view__content__satisfaction__right__rate__rating">
                                        <div class="order-view__content__satisfaction__right__rate__rating__list"
                                             id="rating">
                                            @include('client.common.pick-star')
                                        </div>
                                        <div class="order-view__content__satisfaction__right__click click-review">
                                            <div class="order-view__content__satisfaction__right__click__text">
                                                {{__('labels.order-view.click_enter')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-view__content__satisfaction__right__rate__text text-review">
                                        {{__('labels.order-view.please_rate')}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="order-view__content__review-text">
                        <div class="order-view__content__review-text__left">
                            <div class="order-view__content__review-text__left__name">
                                {{__('labels.order-view.review_text')}}
                            </div>
                            <div class="order-view__content__review-text__left__require">
                                {{__('labels.order-view.have_to')}}
                            </div>
                        </div>
                        <div class="order-view__content__review-text__right">
                            <div class="order-view__content__review-text__right__area">
                                @if(!empty($reviewed))
                                    <textarea disabled id="w3review" name="comment"
                                              placeholder="{{__('labels.order-view.entered_characters')}}"> {!! $reviewed->comment !!}</textarea>
                                    {{--                                    <div class="order-view__content__review-text__right__sum">--}}
                                    {{--                                        {{__('labels.order-view.characters_remaining')}}--}}
                                    {{--                                    </div>--}}
                                @else
                                    <textarea id="w3review" name="comment"
                                              placeholder="{{__('labels.order-view.entered_characters_design')}}">{!! old('comment') !!}</textarea>
                                    {{--                                    <div class="order-view__content__review-text__right__sum">--}}
                                    {{--                                        {{__('labels.order-view.characters_remaining')}}--}}
                                    {{--                                    </div>--}}
                                @endif

                            </div>
                            <div class="error fs-12">
                            </div>
                        </div>
                    </div>
                    <div class="order-view__content__publish-profile">
                        <div class="order-view__content__publish-profile__ct">
                            <div class="order-view__content__publish-profile__ct__accept">
                                <label class="order-view__content__publish-profile__ct__accept__container">
                                    <input id="profile" type="checkbox" name="is_public"
                                           @if(!empty($reviewed)) disabled
                                           {{ $reviewed->is_public == \App\Enums\DBConstant::PUBLIC_INFO ? 'checked' : '' }}@else checked="checked" @endif>
                                    <span class="checkmark"></span>
                                </label>
                                <div class="order-view__content__publish-profile__ct__accept__text">
                                    <label for="profile"> {{__('labels.order-view.entered_characters')}}</label>
                                </div>
                            </div>
                            <div class="order-view__content__publish-profile__ct__desc">
                                {{__('labels.order-view.your_nickname')}}
                            </div>
                        </div>
                    </div>

                    <div class="order-view__content__publish-note">
                        <div class="order-view__content__publish-note__ct">
                            <div class="order-view__content__publish-note__ct__accept">
                                <div class="order-view__content__publish-note__ct__accept__text">
                                    {{__('labels.order-view.notes_posting_reviews')}}
                                </div>
                            </div>
                            <div class="order-view__content__publish-note__ct__desc">
                                {{__('labels.order-view.review_guidelines')}}
                            </div>
                        </div>
                    </div>
                    <div class="order-view__content__course-submit">
                        <a href="@if(app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName() === app('router')->getRoutes()->match(app('request')->create(route('client.student.my-page.review')))->getName()){{ url()->previous()}} @else {{route('client.student.my-page.purchase-service')}} @endif"
                           class="btn order-view__content__course-submit__btn-return">{{__('labels.users.button.return')}}</a>
                        @if(empty($reviewed))
                            <button class="btn order-view__content__course-submit__btn-post" type="button"
                                    data-url="{{route('client.student.my-page.review')}}">
                                {{__('labels.users.button.post_review')}}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
            <button style="display: none" class="btn order-view__content__course-submit__btn-post__success"
                    type="button" data-toggle="modal" data-target="#review-success">
            </button>
            <!-- Course review modal -->
            <div class="modal fade bd-example-modal-lg popup-course-review" id="review-success" tabindex="-1"
                 role="dialog"
                 aria-labelledby="courseReviewModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" id="modal-content-custom">

                </div>
            </div>
            <!--End Course review modal -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#review").on("submit", function () {
            let rate = $("#rating .active").length / 2;
            $('#review').append(`<input type="hidden" name="rating" value="${rate}" />`);
        })

        @if(session('reviewSuccess'))
        $("#review-success").modal('toggle')
        @endif
    </script>
@endsection
