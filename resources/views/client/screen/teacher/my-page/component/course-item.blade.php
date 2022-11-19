@foreach($courses as $course)
    @if(count($course->courseSchedules)>0)
        <div class="d-flex justify-content-center service-detail card__content_detail_info card__content__info__tt__date">
            <div class="col-md-2 service-detail__responsive pr-0">
                <div class="service-image">
                    <a href="{{route('client.course-schedules.detail',$course->courseSchedules[0]->course_schedule_id)}}"
                       class="img-course{{$course->courseSchedules[0]->course_schedule_id}}">
                        <img class="cs-img-{{ $course->course_id }}" src="{{empty($course->imagePathByDisplayOrder)? asset('assets/img/portal/default-image.svg') : asset($course->courseSchedules[0]->image_url)}}"
                             alt="">
                    </a>
                </div>
            </div>
            @php
                $user = auth()->guard('client')->user();
                $bgColor = '販売終了';
                $canRestock = false;
                $userPurchase = count($course->courseSchedules[0]['purchases']) ? $course->courseSchedules[0]['purchases']['user_id'] : null;
                if (empty($course->courseSchedules[0]['is_open']) ||
                    ($course->courseSchedules[0]['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($course->courseSchedules[0]['num_of_applicants'] > 0 && $course->courseSchedules[0]['type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM))
                ) {
                    $canRestock = true;
                }
                if (
                    ($user && $user->user_id === $userPurchase && $course->courseSchedules[0]['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) ||
                        ($course->courseSchedules[0]['num_of_applicants'] > 0 && $course['category_type'] !== \App\Enums\DBConstant::TYPE_CATEGORY_LIVESTREAM && $course->courseSchedules[0]['status'] === \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
                    ) {
                    $bgColor = '販売終了';
                } else if ($course->courseSchedules[0]['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $course->courseSchedules[0]->course->user->user_status === \App\Enums\DBConstant::USER_STATUS_DEACTIVE) {
                    $bgColor = 'サービス休止';
                } else if ($course['is_restock'] === true) {
                    $bgColor = '開催リクエスト受付中';
                } else if ($course['is_restock'] === false && $course->courseSchedules[0]['status'] !== \App\Enums\DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
                    $bgColor = '開催終了';
                }
            @endphp
            <div class="col-md-10 align-items-center">
                <div class="service-title">
                    @if(count($course->courseSchedules)>0)
                        <div class="d-flex justify-content-between">
                            <a class="title-course-schedule title-course-schedule-{{ $course->course_id }} title-course{{$course->courseSchedules[0]->course_schedule_id}}"
                               href="{{route('client.course-schedules.detail',$course->courseSchedules[0]->course_schedule_id)}}">{{$course->courseSchedules[0]->title?? ''}}</a>
                            <span class="bg-text bg-text-{{ $course->course_id }}" style="color: #828282;">{{$bgColor}}</span>
                        </div>
                    @endif
                </div>
                <div class="service-star-evaluate star-evaluate d-flex align-items-center">
                    <span><strong>{{ $course->rating >= 5 ? 5 : ratingProcess($course->rating) }}</strong> </span>
                    @include('client.common.rating-star',['rating' => ratingProcess($course->rating)])
                    <span class="mx-1">( {{number_format($course->num_of_ratings)}} レビュー)</span>
                </div>
                @if(count($course->courseSchedules)>0)
                    <div class="service-public-date">
                        <div class="row">
                            <div class="d-flex align-items-center col-md-4 public_date pr-0">
                                <svg class="datetime" width="12" height="14" viewBox="0 0 18 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.7305 17.8348V3.9633C17.7305 2.87042 16.847 1.98165 15.7605 1.98165H13.7904V0H11.8204V1.98165H5.91018V0H3.94012V1.98165H1.97006C0.883572 1.98165 0 2.87042 0 3.9633V17.8348C0 18.9277 0.883572 19.8165 1.97006 19.8165H15.7605C16.847 19.8165 17.7305 18.9277 17.7305 17.8348ZM5.91018 15.8532H3.94012V13.8715H5.91018V15.8532ZM5.91018 11.8899H3.94012V9.90825H5.91018V11.8899ZM9.8503 15.8532H7.88024V13.8715H9.8503V15.8532ZM9.8503 11.8899H7.88024V9.90825H9.8503V11.8899ZM13.7904 15.8532H11.8204V13.8715H13.7904V15.8532ZM13.7904 11.8899H11.8204V9.90825H13.7904V11.8899ZM15.7605 6.93577H1.97006V4.95412H15.7605V6.93577Z"
                                          fill="#2A3242"/>
                                </svg>
                                <span class="datetime course-date"> {{Carbon\Carbon::parse($course->courseSchedules[0]->start_datetime)->format('m')}}月{{Carbon\Carbon::parse($course->courseSchedules[0]->end_datetime)->format('d')}}日</span>
                                <span class="datetime">
                                    <div class="card__content__info__tt__date__hours f-w3">
                                        <span class="time_hours">
                                            @if(isset($course->courseSchedules[0]->actual_start_date))
                                                {{Carbon\Carbon::parse($course->courseSchedules[0]->actual_start_date)->format('H:i')}}
                                                - {{Carbon\Carbon::parse($course->courseSchedules[0]->actual_end_date)->format('H:i')}}
                                            @else
                                                {{Carbon\Carbon::parse($course->courseSchedules[0]->start_datetime)->format('H:i')}}
                                                - {{Carbon\Carbon::parse($course->courseSchedules[0]->end_datetime)->format('H:i')}}
                                            @endif
                                        </span>
                                        <span class="hours_down">
                                            <img width="10" height="14"
                                                 src="{{asset('assets/img/search/icon/down-hour.svg')}}"
                                                 alt="">
                                        </span>
                                    </div>
                                    <div class="card__content__info__tt__date__click content_date "
                                         data-img="{{$course->courseSchedules[0]->course_schedule_id}}">
                                        @foreach($course->courseSchedulesOpen as $courseSchedule)
                                            <div class="card__content__info__tt__date__click__1 content_date_click"
                                                 data-course-id="{{$course->course_id}}"
                                                 data-id="{{$courseSchedule['course_schedule_id']}}">
                                                    <span class="f-w3">{{Carbon\Carbon::parse($courseSchedule->start_datetime)->format('m')}}月{{Carbon\Carbon::parse($courseSchedule->end_datetime)->format('d')}}日</span>
                                                    <span class="f-w3">
                                                        @if(isset($courseSchedule->actual_start_date))
                                                            {{Carbon\Carbon::parse($courseSchedule->actual_start_date)->format('H:i')}}
                                                            - {{Carbon\Carbon::parse($courseSchedule->actual_end_date)->format('H:i')}}
                                                        @else
                                                            {{Carbon\Carbon::parse($courseSchedule->start_datetime)->format('H:i')}}
                                                            - {{Carbon\Carbon::parse($courseSchedule->end_datetime)->format('H:i')}}
                                                        @endif
                                                    </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </span>
                            </div>
                            <div class="col-md-8 public_money">
                                                 <span class="dollars">
                                                     <img src="{{asset('assets/img/search/icon/dollars.svg')}}"
                                                          alt=""
                                                          style="margin-bottom: 4px; font-size:14px;line-height:21px">
                                                        <span class="money-value-{{ $course->course_id }}">¥{{number_format($course->courseSchedules[0]->price)}}</span>
                                                 </span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="service-paragraph mt-1 service-paragraph-{{ $course->course_id }}">
                    {!! $course->courseSchedules[0]->body !!}
                </div>
            </div>
        </div>
    @endif
@endforeach
