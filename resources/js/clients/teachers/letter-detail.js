let myEditor;
$(".btn-letter").on("click", function () {
    let data = {
        title: $(this).attr('data-title'),
        body: $(this).attr('data-body'),
        noticeId: $(this).attr('data-notice-id'),
    }
    $("#popupNotice").on('show.bs.modal', function () {
        appendDataModal(data, $(this));
    });
})
$(".btn-new-message").on("click", function () {
    let data = {
        numberSubcriber: $(this).attr('data-num-subscriber'),
    }
    $("#popupNoticeCreate").on('show.bs.modal', function () {
        appendDataModal(data, $(this));
    });
})

function appendDataModal(data, $this) {
    $this.find("#notice-id").val(data.noticeId);
    $this.find(".title_notice").html(data.title);
    $this.find(".content_notice").html(data.body);
    $this.find('#numberSubcriber').html(data.numberSubcriber);
}

//Send Notice Message
$('#submitCreateNotice').on('submit', (e) => {
    e.preventDefault();
    $('#errorTitle').empty();
    $('#errorBody').empty();
    const title = $('#title').val().trim();
    const body = myEditor.getData().trim();
    //TODO validate text form
    title !== '' ? title : $('#errorTitle').html('タイトルを入力してください');
    //validate text body:labels.teacher-my-page.message.validate.title
    body !== '' ? body : $('#errorBody').html('メッセージを記入ください');
    //validate text body:labels.teacher-my-page.message.validate.body
    if (!title || !body) {
        $('.btn-disabled').removeClass('btn-disabled');
    }
    //End TODO validate text form
    if (title && body) {
        $('#loading-overlay').show();
        $.ajax({
            url: "notice/store",
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                title: title,
                body: body,
            },
            success: function (response) {
                $('#loading-overlay').hide();
                if (response.data) {
                    $('#title').val('');
                    $('#content').val('');
                    $('#popupNoticeCreate').modal('hide');
                    $('#messagePopupComplete').modal('show');
                }
            },
            error: (error) => {
                $('#loading-overlay').hide();
                if (error) {
                    $('.btn-disabled').removeClass('btn-disabled');
                    let errors = error.responseJSON.data.errors;
                    $.each(errors, (key, value) => {
                        value.key === 'title' ? $('#errorTitle').html(value.error) : '';
                        value.key === 'body' ? $('#errorBody').html(value.error) : '';
                    });
                }
            }

        })
    }
});
//End Send Notice Message
$("#messagePopupComplete").on('hidden.bs.modal', function () {
    location.reload();
});

let configCkeditor = {
    toolbar: {
        items: [
            'bold',
            'italic',
            'bulletedList',
            'undo',
            'redo',
        ]
    },
    toolbarLocation: 'bottom',
    language: 'ja',
};

if ($("#submitCreateNotice").length) {
    ClassicEditor.create(document.querySelector('#content'), configCkeditor)
        .then(editor => {
            myEditor = editor
        });
}
