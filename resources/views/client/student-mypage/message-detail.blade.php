@extends('client.base.base')
@section("script")
    <script src="{{ mix('js/clients/message.js') }}"></script>
    <script>
        document.activeElement.blur();
        // $(document).ready(function () {
        //     // document.activeElement.blur();
        //     console.log(111);
        //     $('p').on('focus', function () {
        //         $(this).blur();
        //     });
        // })
    </script>
@endsection
@section('css')
    <style>
        @media (max-width: 767px) {
            .dashboard-wrapper {
                margin-top: 0;
            }

            .layout-content {
                padding-bottom: 0;
            }

            .dashboard-wrapper .ck.ck-editor__editable_inline {
                border-radius: 5px 5px 0 0 !important;
            }

            .box-input-wrapper {
                margin-left: -10px;
                margin-right: -10px;
            }

            #footer {
                display: none;
            }
        }

        #footer {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-wrapper messages-course-purchase justify-content-center">
        @if (Route::currentRouteName() !== 'client.teacher.detail.message')
            @include('client.student-mypage.sidebar-left')
        @endif
        @if (Route::currentRouteName() !== 'client.teacher.detail.message')
            <div class="message-detail " id="student-message">
                @else
                    <div class="message-detail message-detail-noteacher " id="student-message">
                        @endif
                        @if(isset($user))
                            <messenger-detail
                                    @if(isset($teacher))
                                    :teacher="{{ json_encode($teacher) }}"
                                    :course-schedule="{{ json_encode($courseSchedule) }}"
                                    back-url="{{ Route::currentRouteName() === 'client.teacher.detail.message' ?
                                    route('client.teacher.detail', $teacher->user_id) :
                                    route('client.student.message.list', array_merge(Request::all(), ['option' => 4])) }}"
                                    @elseif (Request::get('redirect') === 'course-detail')
                                    back-url="{{ route('client.course-schedules.detail', $courseSchedule) }}"
                                    @else
                                    back-url="{{ route('client.student.message.list', Request::all()) }}"
                                    @endif
                                    :room-data="{{ json_encode($roomData) }}"
                                    :user="{{ json_encode($user) }}"
                            ></messenger-detail>
                        @endif
                    </div>
            </div>
            <div id="editor"></div>
@endsection
