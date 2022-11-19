$(document).ready(function () {
    $('input[type=radio][name=course_schedule_id]').on('change', function () {
        let price = $(this).data('price');
        let minute = $(this).data('minute');
        if (minute) {
            $('#minutes_required-html').html(minute + '分');
        }
        if (price) {
            $('#price-html').html('￥' + price);
        }
    });

    if ($("input[name='course_schedule_id']").prop('checked') != true) {
        $('.btn-buy').addClass('disabled-btn')
    }

    $("input[name='course_schedule_id']").click(function () {
        $('.btn-buy').removeClass('disabled-btn')
    })
});
