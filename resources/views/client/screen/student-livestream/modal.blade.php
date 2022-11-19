<div class="modal-content popup-course-review__content">
    <div class="row">
        <div class="col-12 col-md-2 user-image-outline">
            <div class="popup-course-review__content__user-image">
                @if($reviewed->is_public === 1)
                    <img src="{{ $user->profile_image }}" width="42" height="42"
                         alt="">
                @else
                    <img src="{{asset('assets/img/clients/header-common/not-login.svg')}}" width="42" height="42"
                         alt="">
                @endif
                <div class="popup-course-review__content__user-image__title-img">
                    {{ $user->sex_text }}
                    {{ ' ' . $user->current_age - $user->current_age%10 . '代'  }}
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10 pl-0 user-comment-outline">
            <div class="popup-course-review__content__user-comment">
                @if($reviewed->is_public === 1)
                    <strong>{{ $user->full_name}}</strong>
                @else
                    <strong>購入者さん</strong>
                @endif
                <div class="d-flex flex-row popup-course-review__content__user-comment__evaluate">
                    <div class="popup-course-review__content__user-comment__evaluate__voting d-flex">
                        <ul class="content-rating d-flex">
                            @include('client.common.rating-view-active', ['rating' => $reviewed->rating*2])
                        </ul>
                        <div class="fs-14 title rating-title">
                            {{$reviewed->rating}}
                        </div>
                    </div>
                    <div class="ml-auto popup-course-review__content__user-comment__evaluate__date">
                        {{Carbon\Carbon::parse($courseSchedule->start_datetime)->format('Y/m/d')}}
                        開催
                    </div>
                </div>
                <div class="popup-course-review__content__user-comment__comment">
                    {{$reviewed->comment}}
                </div>
            </div>
        </div>
    </div>
    <div class="popup-course-review__content__close-course-review" data-dismiss="modal">
        <a id="closeReview"
           style="color: #fff;background: #46CB90;border: 1px solid #46CB90;"
           href="{{ route('client.student.my-page.review') }}"
           class="btn">{{__('labels.users.button.close')}}</a>
    </div>
</div>