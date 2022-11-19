$(".btn-letter").on("click", function () {
    let data = {
        title: $(this).attr('data-title'),
        body: $(this).attr('data-body'),
        notificationId: $(this).attr('data-notice-id'),
        isRead: parseInt($(this).attr('data-is-read')),
    }
    updateStatusReadNotification(data);
    $("#popupNotice").on('show.bs.modal', function () {
        appendDataModal(data, $(this));
    });
});

function appendDataModal(data, $this) {
    $this.find("#notice-id").val(data.notificationId);
    $this.find(".title_notice").html(data.title);
    $this.find(".content_notice").html(data.body);
}

function updateStatusReadNotification(data) {
    if (data.isRead === 0) {
        $.ajax({
            url: "notification/updateIsRead",
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                isRead: data.isRead,
                id: data.notificationId
            },
            success: function (response) {
                if (response) {
                    $(`#unread-notify-${data.notificationId}`).hide();
                }
            },
            error: (error) => {
                console.log(error);
            }
        })
    }
}
