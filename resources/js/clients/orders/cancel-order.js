$(document).ready(function () {
    $('.sidebar-right__table__data__cancel').click(function () {
        let route = $(this).data('url');
        let courseScheduleId = $(this).data('id');
        $('#sidebar-right__modal-content__content__ok').attr('data-id', courseScheduleId);
    });
    $('#sidebar-right__modal-content__content__ok').click(function () {
        let route = $(this).data('url');
        let courseScheduleId = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: route,
            data: { course_schedule_id: courseScheduleId }
        })
            .done(function (msg) {
                if (msg.success == true) {
                    $('#showMessageCancel').modal('show');
                    $('#messageCancel').text(msg.message);
                    $('#closeCancelModel').addClass('cancel-close')
                    $('.sidebar-right__modal-content__content__cancel').trigger('click');
                } else {
                    $('#closeCancelModel').removeClass('cancel-close')
                    $('#showMessageCancel').modal('show');
                    $('#messageCancel').text(msg.message);
                    $('.sidebar-right__modal-content__content__cancel').trigger('click');
                }
            });
    })
});
if ($('#closeCancelModel').hasClass('cancel-close') || $('#showMessageCancel').modal('hide')) {
    $('#closeCancelModel').on('click', () => {
        $('#showMessageCancel').modal('hide')
        location.reload();
    })
}
