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
        @include('client.common.join-course.course-header')
        @include('client.screen.student-livestream.__partials.modal_report', ['fullname_teacher' => $courseSchedule->course->user->full_name])
        @include('client.screen.teacher.my-page.message.__partials.message_popup_complete')
        @include('client.screen.student-livestream.__partials.modal_follow')
        <student-join-course :course="{{ $courseSchedule }}"
                             :auth_user="{{ $loginUser }}"
                             :sub_course="{{ $subCourse ?? 0 }}"
                             :all_sub_course="{{ $allSubCourse ?? 0 }}"
                             :background="{{ $background }}"
                             agora_id="{{ config('app.agora_app_id') }}"
                             :gifts="{{ $gifts }}"
                             credit_card="{{ json_encode($creditCard) }}"
                             :extend_course="{{ $extendCourse ?? 0 }}"
                             :option_extra_course="{{ $optionCourse ?? 0 }}"
        >
        </student-join-course>
        <!--SUB-COURSE-FREE-->
        @if($allSubCourse != null && count($allSubCourse) > 0)
            <form action="{{route('client.orders.payment.sub-order')}}" method="POST" target="_blank">
                @csrf
                <div class="modal fade" id="subCourseFree" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered justify-content-around" role="document">
                        <div id="sub-course_end" class="modal-content sub-course-free-header">

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
            $('body').on('click', '.sub-course-option', function () {
                if ($(".course_schedule_id").prop("checked")) {
                    $(".buy-sub-course-free").removeClass('bg-disabled');
                }
            })

            $('body').on('click', '.sub-course-option', function () {
                let time = $(this).find('.time').val();
                let price = $(this).find('.price').val();
                $('.time-course').text(time + '分');
                $('.price-course').text('￥' + price);
            })

            $('#openModalFollow').click(() => {
                $('#modalFollow').modal('toggle');
            });
            $('#openModalReport').click(() => {
                $('#modalReport').modal('toggle');
            });
            $('#reportTeacherForm').on('submit', function (e) {
                e.preventDefault();

                let formData = $('#reportTeacherForm').serializeArray();

                $('#loading-overlay').show();
                $.ajax({
                    url: "/student/send-mail-report",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#loading-overlay').hide();
                            $('#modalReport').modal('hide');
                            $('#messagePopupComplete').modal('show');
                            $("#reportTeacherForm textarea[name='content']").val('');
                        } else {
                            $('#loading-overlay').hide();
                            toastr.error(response.message);
                        }
                    },
                    error: function (err) {
                        $('#loading-overlay').hide();
                    }
                });
            });

            $('#followTeacherForm').on("submit", (e) => {
                e.preventDefault();

                let formData = $('#followTeacherForm').serializeArray();
                $('#loading-overlay').show();
                $.ajax({
                    url: "/student/follow-teacher",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.status) {
                            $('#loading-overlay').hide();
                            $('#modalFollow').modal('hide');
                            toastr.success(response.message);
                        } else {
                            $('#loading-overlay').hide();
                            $('#modalFollow').modal('hide');
                            toastr.error(response.message);
                        }
                    },
                    error: function (err) {
                        $('#loading-overlay').hide();
                    }
                });
            });

            // $('.close').click(function () {
            //     $('#subCourseFree').modal('hide');
            // })
        });
    </script>
@endsection
