@extends('client.base.base-livestream')
@section('title')
    {{__('labels.users.join_course.teacher_title_page.trouble_consultation')}}
@endsection
@section('lib-js')
    <script src="{{ mix('js/agora/livestream/teacher.js') }}" defer></script>
    <style>
        .header-popup {
            min-height: 45px;
        }

        .buy-sub-course-free {
            background: #9B9F9E !important;
            border: none !important;
            cursor: default !important;
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    <div class="join-course-block" id="teacher-livestream">
        @include('client.common.join-course.course-header')
        @include('client.screen.student-livestream.__partials.modal_report')
        <teacher-join-course :course="{{ $courseSchedule }}"
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
        </teacher-join-course>
        <!--SUB-COURSE-FREE-->
        @if($allSubCourse != null && count($allSubCourse) > 0)
            <form action="{{route('client.orders.payment.sub-order')}}" method="POST">
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
