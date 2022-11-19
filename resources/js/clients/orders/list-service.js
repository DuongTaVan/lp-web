$(document).ready(function () {
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

    $(".btn-delete").on("click", function () {
        $("[name='id']").val($(this).attr("data-id"));
        $("[name='_token']").val($('meta[name="csrf-token"]').attr('content'));
    })

    $(".cancel-batch").on("click", function () {
        $("#course-schedule-id").val($(this).attr("data-id"));
        $('meta[name="csrf-token"]').attr('content');
        $(".num-of-applicant-modal").html($(this).attr("data-num"));
        $("#message").val("");
    })

    $(".cancel-batch-app").on("click", function () {
        $("#course-schedule-id").val($(this).attr("data-id"));
        $('meta[name="csrf-token"]').attr('content');
        $(".num-of-applicant-modal").html($(this).attr("data-num"));
        $("#message").val("");
    })

    $(".content-service-send-mail .button-ok").on("click", function () {
        let courseScheduleId = $("#course-schedule-id").val();
        if ($(window).width() <= 414) {
            $('.cancel-batch-app').each(function () {
                if (+$(this).data("id") === +courseScheduleId) {
                    let that = $(this);
                    let parent = $(this).parent();
                    if ($("#message").val() === '') {
                        $('.error-message').html('メッセージは、必ず指定してください。')
                    } else {
                        $.ajax({
                            beforeSend: function beforeSend() {
                                $('#loading-overlay').show();
                            },
                            url: "/teacher/my-page/service-list/cancel",
                            method: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                message: $("#message").val(),
                                course_schedule_id: courseScheduleId
                            }
                        })
                            .done(function () {
                                $('#email').modal('toggle');
                                if (result.pending) {
                                    $('.text-send-email').html('処理をしています。');
                                    parent.html('処理中');
                                } else {
                                    $('.text-send-email').html('メッセージを送信しました。');
                                    that.parents(".teacher-sidebar-right__table__data").remove();
                                }
                                $('#loading-overlay').hide();
                            })
                            .catch(function () {
                                $('#loading-overlay').hide();
                                toastr.error('システムエラーが発生しました。');
                            });
                    }

                }
            });
        } else {
            $('.cancel-batch').each(function () {
                if (+$(this).data("id") === +courseScheduleId) {
                    let that = $(this);
                    let parent = $(this).parent();
                    if ($("#message").val() === '') {
                        $('.error-message').html('メッセージは、必ず指定してください。')
                    } else {
                        $.ajax({
                            beforeSend: function beforeSend() {
                                $('#loading-overlay').show();
                            },
                            url: "/teacher/my-page/service-list/cancel",
                            method: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                message: $("#message").val(),
                                course_schedule_id: courseScheduleId
                            }
                        })
                            .done(function(result) {
                                $('#email').modal('toggle');
                                if (result.pending) {
                                    $('.text-send-email').html('処理をしています。');
                                    parent.html('処理中');
                                } else {
                                    $('.text-send-email').html('メッセージを送信しました。');
                                    that.parents(".teacher-sidebar-right__table__data").remove();
                                }
                                $('#mailDone').modal('toggle');
                                $('#loading-overlay').hide();
                            })
                            .catch(function () {
                                $('#loading-overlay').hide();
                                toastr.error('システムエラーが発生しました。');
                            });
                    }
                }
            });
        }
    })
})
