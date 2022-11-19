
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
let bodyEditor, flowEditor, cautionEditor, subtitleEditor;
if ($("#body").length) {
  ClassicEditor.create(document.querySelector('#body'), configCkeditor)
    .then(editor => {
      bodyEditor = editor;
    });
  ClassicEditor.create(document.querySelector('#flow'), configCkeditor)
    .then(editor => {
      flowEditor = editor;
    });
  ClassicEditor.create(document.querySelector('#cautions'), configCkeditor)
    .then(editor => {
      cautionEditor = editor;
    });
  ClassicEditor.create(document.querySelector('#subtitle'), configCkeditor)
    .then(editor => {
      subtitleEditor = editor;
    });
}
$(document).ready(function () {
  $('#preview-course').on('click', function () {
    // validate
    let startDate = document.getElementsByName("start_day[]");
    let startTime = document.getElementsByName("start_time[]");
    for (let i = 0; i < startDate.length; i++) {
      if (startDate[i].value.length === 0 || startTime[i].value.length === 0) {
        $(".error-start-datetime").html('開催日時は、必ず指定してください。');
        $([document.documentElement, document.body]).animate({
          scrollTop: $(".error-start-datetime").offset().top
        }, 1000);
        return;
      }
    }

    if ($("input[name=minutes_required]").val().length === 0) {
      $(".error-minutes_required").html('ご利用時間は、必ず指定してください。');
      $([document.documentElement, document.body]).animate({
        scrollTop: $(".error-minutes_required").offset().top
      }, 1000);
      return;
    }

    // get data
    const data = $('#form-course').serializeArray();
    let formData = new FormData();
    let route = `/teacher/course_schedules/${ $('#course_schedule_id').val() }/preview`;
    data.map(value => {
      if (value.name === 'body') {
        formData.append('body', bodyEditor.getData().trim());
      } else if (value.name === 'flow') {
        formData.append('flow', flowEditor.getData().trim());
      } else if (value.name === 'cautions') {
        formData.append('cautions', cautionEditor.getData().trim());
      } else if (value.name === 'subtitle') {
        formData.append('subtitle', subtitleEditor.getData().trim());
      } else {
        formData.append(value.name, String(value.value).trim());
      }
    });
    const previewImg = $('input[name="preview[]"]');
    for (let i = 0; i < previewImg.length; i++) {
      if (previewImg[i].files[0]) {
        formData.append('preview[]', previewImg[i].files[0]);
      }
    }

    // remove error text
    $('[class*="error-"]').html("");
    $("#loading-overlay").show();

    // get preview data
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: "POST",
      url: route,
      data: formData,
      contentType: false,
      processData: false,
      success: function success(response) {
        if (response.success) {
          $('#loading-overlay').hide();
          $('.create-course-block').hide();
          $('#preview-container').append(response.html);
          $('body').animate({scrollTop: '0px'}, 0);
        }
      },
      error: function error(error) {
        $('#loading-overlay').hide();
        if (error.responseJSON && error.responseJSON.data.errors) {
          error.responseJSON.data.errors.map(res => {
            if (res.key) {
              const splitError = res.key.split('.');
              if (splitError.length === 1) {
                $('.error-' + res.key).html(res.error);
              } else {
                $('.error-' + splitError[0]).html(res.error);
              }
            }
          });
        }
      }
    });
  });

  // back button
  $(document).on('click', '#btn-back', function () {
    $('#preview-container').html('');
    $('.create-course-block').show();
  });

  // draft btn
  $(document).on('click', '#btn-draft', function () {
    $("#loading-overlay").show();
    $('#save-draft').trigger('click');
  });

  // public course
  $(document).on('click', '.btn-public-course', function () {
    $("#loading-overlay").show();
    $('#btn-submit').trigger('click');
  });
});
