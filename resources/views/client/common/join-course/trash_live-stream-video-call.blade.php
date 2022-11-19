<div class="livestream-block">
    <img src="{{asset('assets/img/join-course/demo_livestream.jpg')}}" alt="">
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
                <button class="btn btn-control-custom">
                    <img src="{{asset('assets/img/icons/Call.svg')}}" alt="call">
                </button>
                <br>
                <span>{{__('labels.users.join_course.end_call')}}</span>
            </div>
            <div class="flex-fill bd-highlight btn-control-custom">
                <img id="vc-btn"
                     src="{{asset('assets/img/icons/svg.svg')}}" alt="svg"
                     class="btn btn-custom drop-btn-video-call">
                <div id="dropdown-video-call" class="dropdown-video-call">
                    <a href="javascript:;">{{__('labels.users.student_live_stream.video_call.background_change')}}</a>
                    <a href="javascript:;">{{__('labels.users.student_live_stream.video_call.choose_mask')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div id="maskVideo" class="mask-video">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="mask-outline">
                <div class="mask-content">
                    <h1 class="mask-name">フクロウ</h1>
                </div>
                <img src="{{asset('assets/img/common/face-mask/bunny.png')}}" alt="">
            </div>
            <div class="mask-outline">
                <div class="mask-content">
                    <h1 class="mask-name">うさぎ</h1>
                </div>
                <img src="{{asset('assets/img/common/face-mask/our.png')}}" alt="">
            </div>
            <div class="mask-outline">
                <div class="mask-content">
                    <h1 class="mask-name">サル</h1>
                </div>
                <img src="{{asset('assets/img/common/face-mask/monkey.png')}}" alt="">
            </div>
            <div class="mask-outline">
                <div class="mask-content">
                    <h1 class="mask-name">マスクなし</h1>
                </div>
                <div class="no-mask">
                    <img src="{{asset('assets/img/common/background/default-bg.svg')}}" alt="">
                </div>
            </div>
        </div>

    </div>
</div>
