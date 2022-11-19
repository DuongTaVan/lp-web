<div class="join-course-block__header" id="join-course-header">
    <div class="row">
        <div class="col-md-12">
            <div class="bd-highlight join-course-block__header__time-live fs-14">
                開催時間
                {{ isset($courseSchedule['actual_start_date'])?(now()->parse($courseSchedule['actual_start_date'])->format('H:i') .' - ' .now()->parse($courseSchedule['actual_end_date'])->addMinute($minuteExtent)->format('H:i')) :$courseSchedule->hour_minute }}
            </div>
            <div class="d-flex flex-row bd-highlight join-course-block__header__content">
                <div class="avt">
                    <img src="{{ $courseSchedule->course->user->profile_image }}" alt="">
                </div>
                <div class="d-flex flex-column header-info">
                    <div class="bd-highlight title" title="{{ $courseSchedule->title }}">
                        {{ $courseSchedule->title }}
                    </div>
                    <div class="bd-highlight d-flex">
                        <span class="nickname"
                              title="{{ $courseSchedule->course->user->full_name }}">{{ $courseSchedule->course->user->full_name }}</span>
                        <div class="d-flex evaluate" style="align-items: flex-start;">
                            @include('client.common.show-star',['rating'=> ratingProcess($rating['avg_rating'])])
                            <strong>{{ $rating['avg_rating'] >= 5 ? 5 : ratingProcess($rating['avg_rating']) }}</strong>
                            <span>({{number_format($rating['sum_rating'], 0, ',', ',')}})</span>
                        </div>
                        <div class="ml-auto">
                            <div class="tools-option">
                                <a target="_blank"
                                   href="{{ route('client.teacher.detail', ['user_id' => $courseSchedule->course->user->user_id]) }}">
                                    <div class="title-profile">
                                        プロフィール
                                    </div>
                                    <img src="{{asset('assets/img/student-live-stream/icon/profile.svg')}}" alt="">
                                </a>
                                <a @if (Request::is('student/*')) id="openModalFollow" @endif>
                                    <div class="title-profile">
                                        フォローする
                                    </div>
                                    <img src="{{asset('assets/img/student-live-stream/icon/like.svg')}}" alt="">
                                </a>
                                <a @if (Request::is('student/*')) id="openModalReport" @endif>
                                    <div class="title-profile title-report">
                                        通報する
                                    </div>
                                    <img src="{{asset('assets/img/student-live-stream/icon/report.svg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
