@extends('client.base.base')
@section('css')
    <style>
        .dashboard-wrapper {
            margin-top: 0px;
        }

        #footer {
            display: none;
        }
    </style>
@endsection
@section("script")
    <script src="{{ mix('js/clients/message.js') }}"></script>
@endsection
@section('content')
    <div class="main-mypage-teacher">
        <div class="container content-mypage">
            <div class="row dashboard-wrapper messages-course-purchase">
                @include('client.screen.teacher.my-page.sidebar-left')
                <div class="message-detail" id="student-message">
                    <messenger
                            @if(isset($teacher))
                            :teacher="{{ json_encode($teacher) }}"
                            :rating="{{ json_encode($rating) }}"
                            @endif
                            @if(isset($courseSchedule))
                            :course-schedule="{{ json_encode($courseSchedule) }}"
                            @endif
                            :type="{{ json_encode($type) }}"
                            :room-id="{{ json_encode($roomId) }}"
                            @if(isset($roomType) && ((int)$roomType === \App\Enums\DBConstant::ROOM_NOT_PURCHASED))
                            back-url="{{ route('client.teacher.my-page.message.not-buyer', $courseScheduleId) }}"
                            @elseif ((int)$roomType === \App\Enums\DBConstant::ROOM_TYPE_PRIVATE)
                            back-url="{{ route('client.teacher.my-page.message.inquiry-list') }}"
                            @else
                            back-url="{{ route('client.teacher.my-page.message.buyer', $courseScheduleId) }}"
                            @endif
                            @if(isset($user))
                            :user="{{ json_encode($user) }}"
                            @endif
                            @if (isset($roomType) && isset($userId))
                            :student-id="{{ @json_encode($userId) }}"
                            :room-type="{{ @json_encode(@$roomType) }}"
                            @endif
                            back-label="メッセージに戻る"
                            is-teacher-page
                    ></messenger>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("script")
    <script>
        document.getElementsByClassName('messages-content')[0].scrollTop = 99999;
        let radioButton = document.querySelectorAll('.button-radio');
        radioButton.forEach(el => {
            el.addEventListener('click', () => {
                removeClassActive();
                el.classList.add('active-radio')
            })
        })

        function removeClassActive() {
            radioButton.forEach(el => {
                el.classList.remove('active-radio')
            })
        }
    </script>
@endsection
