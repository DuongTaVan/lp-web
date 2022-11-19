<div id="top" class="tab-pane active home-tab">
    <h3 class="f-w6">{{ __('labels.users.teacher_screen.top.profile') }}</h3>
    <div class="content-home-top">
        <div class="content-home-top__ct">
            <p class="content-home-top__ct__text text-top">
                {!! $data['users']['biography'] ?? null!!}
            </p>
            @if(isset($data['users']['biography']))
                <p class="read-more text-center">
                    <a href="javascript:void(0)" style="color:#46CB90;"
                       class="button">{{ __('labels.users.teacher_screen.see_more') }}</a>
                    <img class="arrow-down"
                         src="{{asset('assets/img/clients/course-detail/arrow-right.svg')}}" alt="">
                </p>
            @endif
        </div>
    </div>
    <div class="my-3 top-btn">
        <style>
            .disable-question {
                pointer-events: none;
                cursor: default;
            }
        </style>
        @if(auth()->guard('client')->check())
            <a href="{{ route('client.teacher.detail.message', $userId) }}"
               class="btn btn-green-custom mr-2 @if($userId == auth('client')->id()) disable-question @endif">{{__('labels.users.teacher_screen.question')}}</a>
            <button class="btn btn-green-outline-custom"
                    data-toggle="modal"
                    data-target="#modalFollow">{{ __('labels.users.teacher_screen.follow') }}</button>
        @else
            <a href="{{ route('client.register') }}" class="btn btn-green-custom mr-2" data-toggle="modal"
               data-target="#modalLogin">{{ __('labels.users.teacher_screen.question') }}</a>
            <a href="#" class="btn btn-green-outline-custom" data-toggle="modal"
               data-target="#modalLogin">{{ __('labels.users.teacher_screen.follow') }}</a>
        @endif
    </div>
</div>
<script>
    $(document).ready(function () {
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
                        $('#modal-follow').modal('hide');
                        toastr.info(response.message);
                    } else {
                        $('#loading-overlay').hide();
                        $('#modal-follow').modal('hide');
                        toastr.error(response.message);
                    }
                },
                error: function (err) {
                    $('#loading-overlay').hide();
                }
            });
        });
    })
</script>