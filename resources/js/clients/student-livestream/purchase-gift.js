$(document).ready(function () {
    $('#button-confirm').on('click', function () {
        if (!creditCard['exp_year']) {
            $('#gift-confirm').find('.error-card').show();
            return;
        }
        $('#gift-confirm').modal('toggle');
        $('#gift-buy').modal('toggle');
    });

    $('#buy-gift').on('click', function() {
        let giftId = $("#gift").find("#gift-id").val();
        let url = '/student/student-livestream/purchase-gift';
        let data = {
            gift_id: giftId,
            course_schedule_id: courseScheduleId
        }
        if (giftId === 'raise-hand') {
            url = '/question-ticket/purchase';
        }
        $.ajax({
            beforeSend: function () {
                $('#loading-overlay').show();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: url,
            data: data
        })
            .done(function (res) {
                if (res.success) {
                    $('#gift-buy').modal('toggle');
                    $('#gift-success').modal('toggle');
                }
                $('#loading-overlay').hide();
            })
            .catch(function () {
                $('#loading-overlay').hide();
            });
    })
});
