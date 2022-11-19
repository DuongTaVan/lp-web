@foreach($reviews as $review)
    <div class="d-flex review-outline">
        <div class="review-image-outline">
            <div class="review-user-image">
                <div>
                    @if($review->is_public == 0)
                        <img src="{{asset('assets/img/clients/header-common/not-login.svg')}}"
                             alt=""
                             class="rounded-circle img-fluid">
                    @else
                        <img src="{{$review->getOriginal('profile_image') !== null ? $review->profile_thumbnail : '/assets/img/clients/header-common/not-login.svg'}}"
                             alt=""
                             class="rounded-circle img-fluid">
                    @endif
                    @php
                        if(isset($review->date_of_birth))
                        $current_age = Carbon\Carbon::parse($review->date_of_birth)->age;
                        else
                            $current_age = null;
                    @endphp
                    <h6>{{$review->sex_text}} {{$current_age - $current_age%10}}代</h6>

                </div>
            </div>
        </div>
        <div class="review-paragraph-outline pr-0">
            <div class="review-paragraph">
                <div class="review-title">
                    <a href="#">{{$review->coureSchedule->title ?? ''}}</a>
                    @if($review->is_public == 0)
                        @lang('labels.search.name_is_public')
                    @else
                        {{$review->full_name}}
                    @endif
                </div>
                <div class="voting-star-evaluate my-2 d-flex">
                    @include('client.common.show-star',['rating' => $review['rating']])
                    <span class="mt-1 font-weight-bold">@if($review['rating']>5)
                            5
                        @else
                            {{ bcdiv($review['rating'],1,1) }}
                        @endif
                                        </span>
                    <div class="ml-auto time-public">{{Carbon\Carbon::parse($review->start_datetime)->format('Y/m/d')}}
                        開催
                    </div>
                </div>
                <div class="review-comment">
                    {{$review['comment']}}<br>
                </div>
            </div>
        </div>
    </div>
@endforeach
