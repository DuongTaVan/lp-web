<div id="review" class="tab-pane review-tab fade">
    <div class="review-custom">
        @if(!empty($data['reviews']) && $data['reviews'] != [])
            <div id="list-review"
                 data-url="{{route('client.teacher.review-detail', $data['userId'])}}">
                @forelse($data['reviews'] as $review)
                    <div class="d-flex review-outline">
                        <div class="review-image-outline">
                            <div class="review-user-image">
                                <div>
                                    @if($review->is_public === 0)
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
                                    <h6>{{ $review->sex_text === '無回答' ? '' : $review->sex_text }} {{$current_age - $current_age%10}}
                                        代</h6>
                                </div>
                                <div class="rectangle"></div>
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
                                <div class="voting-star-evaluate my-2 d-flex justify-content-center align-items-center">
                                    @include('client.common.show-star',['rating' => ratingProcess($review['rating'])])
                                    <span class="font-weight-bold">
                                            {{ $review['rating']>=5 ? 5 : bcdiv($review['rating'],1,1)}}
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
                @empty
                    <div class="d-flex justify-content-center" style="background: #fafafa">
                        <div class="nodata_icon" style="background: #fafafa">
                            <img src="{{asset('assets/img/common/nodata_techer-page.svg')}}" alt="">
                        </div>
                        <p class="text-center course-no-data" style="background: #fafafa; margin-left: 16.42px"
                           style="padding-bottom: 0">@lang('labels.search.no_data')</p>
                    </div>
                @endforelse
            </div>
            <div class="load-more-link row text-center" id="loadMore" data-page="1" style="width: 100%">
                <div class="col-md-12 div-load">
                    @if(!empty($data['reviews']))
                        @if($data['reviews']->currentPage() < $data['reviews']->lastPage())
                            <a href="#" class="see-more"
                               data-lastPage= {{$data['reviews']->lastPage()}}>{{__('labels.users.teacher_screen.see_more')}}</a>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
