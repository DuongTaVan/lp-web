@extends('client.base.base-livestream')
@section('lib-js')
    <script src="{{ mix('js/agora/livestream/student.js') }}" defer></script>
    <style>
        .header-popup {
            min-height: 45px;
        }
    </style>
@endsection
@section('content')
    <div class="join-course-block" id="student-livestream">
        <!--SUB-COURSE-FREE-->
        @if($allSubCourse != null && count($allSubCourse) > 0)
            <form action="{{route('client.orders.payment.sub-order')}}" method="POST" target="_blank">
                @csrf
                <div class="modal fade show" id="subCourseFree" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered justify-content-around" role="document">
                        <div class="modal-content sub-course-free-header">
                            <div class="header-popup">
                                <div class="title f-w6"></div>
                                <div class="exit close" data-dismiss="modal" aria-label="Close">
                                    <img :src="'/assets/img/icons/exit.svg'" alt="">
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
                                            <div class="content-sub-course time-course">{{$allSubCourse[0]['minutes_required']}}
                                                分
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
                                    @foreach($allSubCourse as  $cs)
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
                            <button
                                    class="buy-sub-course-free f-w6 @if(!$countCourseScheduleDisplay) bg-disabled @endif"
                                    aria-label="Close"
                                    data-url="{{route('client.orders.payment.sub-order')}}">
                                購入する
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <form>
                <div class="modal fade show" id="subCourseFree" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered justify-content-around" role="document">
                        <div class="modal-content sub-course-free-header">
                            <div class="header-popup">
                                <div class="title f-w6">このサービスの販売は終了しました。</div>
                                <div class="exit close" data-dismiss="modal" aria-label="Close">
                                    <img :src="'/assets/img/icons/exit.svg'" alt="">
                                </div>
                            </div>
                            <div class="modal-subcourse-free">
                                <div class="modal-subcourse-free__header">
                                    <h1 class="title f-w6"> 受講者限定サービス！</h1>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.sub-course-option').click(function () {
                if ($(".course_schedule_id").prop("checked")) {
                    $(".buy-sub-course-free").removeClass('bg-disabled');
                }
            })

            $('.sub-course-option', function () {
                let time = $(this).find('.time').val();
                let price = $(this).find('.price').val();
                $('.time-course').text(time + '分');
                $('.price-course').text('￥' + price);
            })
        });
    </script>
@endsection
