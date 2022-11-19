<div class="modal-content sub-course-free-header">
    <div class="header-popup">
        <div class="title f-w6"></div>
        <div class="exit close" data-dismiss="modal" aria-label="Close">
            <img src="{{asset('/assets/img/icons/exit.svg')}}" alt="">
        </div>
    </div>
    <input type="hidden" name="mainCourseScheduleId" value="{{$courseScheduleId}}">
    <div class="modal-subcourse-free">
        <div class="modal-subcourse-free__header">
            <h1 class="title f-w6"> 受講者限定サービス！</h1>
            <div class="note f-w6">もっと詳しくお聞きしたい方は個別講座をご利用くださいね！</div>
            <div class="note f-w6">個別講座(1対1)</div>
        </div>
        <div class="modal-subcourse-free__content">
            <div class="course-info">
                <div class="course-info__item">
                    <div class="title f-w6">講座のタイトル</div>
                    <div class="content-sub-course">{{$allSubCourse[0]['title_course']}}</div>
                </div>
                <div class="course-info__item">
                    <div class="title f-w6">ご利用時間</div>
                    <div class="content-sub-course time-course">{{$allSubCourse[0]['minutes_required']}}分
                    </div>
                </div>
                <div class="course-info__item">
                    <div class="title f-w6">料金(税込)</div>
                    <div class="content-sub-course price-course">
                        ￥{{number_format($allSubCourse[0]['price'])}}</div>
                </div>
            </div>
            @php
                $countCourseScheduleDisplay = 0;
            @endphp
            @foreach($allSubCourse as $index => $cs)
                <div class="sub-course-option">
                    <label class="sub-course-option__option-outline">
                        <input class="course_schedule_id" type="radio" name="course_schedule_id"
                               value="{{$cs->course_schedule_id}}" {{ !$countCourseScheduleDisplay ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                    <div class="text">{{now()->parse($cs['start_datetime'])->format('Y-m-d') }} {{now()->parse($cs['start_datetime'])->format('H') }}
                        時{{now()->parse($cs['start_datetime'])->format('i') }}
                        分~{{now()->parse($cs['end_datetime'])->format('H') }}
                        時{{now()->parse($cs['end_datetime'])->format('i') }}分
                    </div>
                    <input class="time" type="hidden"
                           value="{{ $cs->minutes_required }}">
                    <input class="price" type="hidden"
                           value="{{number_format($cs->price)}}">
                </div>
                @php
                    $countCourseScheduleDisplay++;
                @endphp
            @endforeach
        </div>
    </div>

    <button class="buy-sub-course-free f-w6 @if(!$countCourseScheduleDisplay) bg-disabled @endif"
            aria-label="Close"
            data-url="{{route('client.orders.payment.sub-order')}}">
        購入する
    </button>
</div>
