
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
let bodyEditor3, flowEditor3, cautionEditor3, subtitleEditor3;
function showUploadBox() {
  TOTAL_IMAGE = $('.list-img-step-3').find('.preview').length ?? 0;
  if (TOTAL_IMAGE < 4) {

    let widthScreen = window.innerWidth;
    if (widthScreen < 776) {
      var sizePreviewImg = (widthScreen - 30) / 4 - 10;
    }
    $('#list-img').append(`<div id="upload-box" style="width: ${sizePreviewImg}px; height: ${sizePreviewImg}px;">
                        <input class="d-none preview-image" name="preview[]" accept="image/png, image/gif, image/jpg, image/jpeg"
                               type='file'/>
                        <div class="remove-img">
                            <img src="/assets/img/clients/teacher/remove.svg" alt="">
                        </div>
                        <span>
                        <img class="preview-img" src="/assets/img/clients/teacher/plus.svg" alt=""></span>
                    </div>`);
  }
}


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
let previewContent = "";
let step = 2;
$(document).ready(function () {
  // change start day
  $(document).on('change', '.preview-start-day', function () {
    $(this).attr('value', $(this).val());
  });
  // change start time
  $(document).on('change', '.start-time-preview', function () {
    $(this).attr('value', $(this).val());
  });
  $(document).on('click', '.wrap-item__value .select__item', function () {
    $(this).parent('.select').find('.preview-input-select').attr('value', $(this).html());
  });
  $(document).on('change', '.auto-money', function () {
    $(this).attr('value', $(this).val());
  });

  $(document).on('click', '#back-step-livestream', function () {
    $('.create-course-block-step-3').html('');
    $('.step-2-content').show();
    step = 2;
    // if (previewContent) {
    //   $('.create-course-block').html(previewContent);
    //   // element
    //   $('body').animate({scrollTop: '0px'}, 0);
    //   let datetimepicker = $('.datetimepicker');
    //   $.each(datetimepicker, function (index, element) {
    //     element = element.getElementsByTagName('input');
    //     if (!element.length) return;
    //     element = element[0];
    //
    //     $(this).flatpickr(getOptionFromElement(element));
    //   });
    // }
  });

  $(document).on('click', '#preview-course', function () {
    submitForm();
  });

  function submitForm(isDraft = false) {
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

    if ($("input[name=minutes_required]").val() && $("input[name=minutes_required]").val().length === 0) {
      $(".error-minutes_required").html('ご利用時間は、必ず指定してください。');
      $([document.documentElement, document.body]).animate({
        scrollTop: $(".error-minutes_required").offset().top
      }, 1000);
      return;
    }

    // get data
    let data = null;
    if (step === 3) {
      data = $('#form-course-3').serializeArray();
    } else {
      data = $('#form-course').serializeArray()
    }
    let formData = new FormData();
    let route = `/teacher/courses/${ $('#course_id').val() }/preview-clone-course`;
    data.map(value => {
      if (value.name === 'body') {
        if (step === 3 && bodyEditor3) {
          formData.append('body', bodyEditor3.getData().trim());
        } else {
          formData.append('body', bodyEditor.getData().trim());
        }
      } else if (value.name === 'flow') {
        if (step === 3 && flowEditor) {
          formData.append('flow', flowEditor3.getData().trim());
        } else {
          formData.append('flow', flowEditor.getData().trim());
        }
      } else if (value.name === 'cautions') {
        if (step === 3 && cautionEditor3) {
          formData.append('cautions', cautionEditor3.getData().trim());
        } else {
          formData.append('cautions', cautionEditor.getData().trim());
        }
      } else if (value.name === 'subtitle') {
        if (step === 3 && subtitleEditor3) {
          formData.append('subtitle', subtitleEditor3.getData().trim());
        } else {
          formData.append('subtitle', subtitleEditor.getData().trim());
        }
      } else {
        formData.append(value.name, String(value.value).trim());
      }
    });
    if (step !== 3) {
      $('input').removeClass('img-remove-step');
    }
    const previewImg = $('input[name="preview[]"]');
    for (let i = 0; i < previewImg.length; i++) {
      if (previewImg[i].files[0] && !$(previewImg[i]).hasClass('img-remove-step')) {
        formData.append('preview[]', previewImg[i].files[0]);
      }
    }

    // remove error text
    $('[class*="error-"]').html("");
    $("#loading-overlay").show();

    // get preview data
    $.ajax({
      url: route,
      data: formData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      method: "POST",
      contentType: false,
      processData: false,
      success: function success(response) {
        $('#loading-overlay').hide();
        if (response.success) {
          if (isDraft) {
            $('#save-draft-3').trigger('click');
            return;
          }
          if (response.type === 'livestream-preview') {
            previewContent = $('.create-course-block').html();
            $('.step-2-content').hide();
            $('.create-course-block-step-3').append(response.html);
            showUploadBox();
            step = 3;

            if ($("#body").length) {
              ClassicEditor.create(document.querySelector('#body-3'), configCkeditor)
                .then(editor => {
                  bodyEditor3 = editor;
                });
              ClassicEditor.create(document.querySelector('#flow-3'), configCkeditor)
                .then(editor => {
                  flowEditor3 = editor;
                });
              ClassicEditor.create(document.querySelector('#cautions-3'), configCkeditor)
                .then(editor => {
                  cautionEditor3 = editor;
                });
              ClassicEditor.create(document.querySelector('#subtitle-3'), configCkeditor)
                .then(editor => {
                  subtitleEditor3 = editor;
                });
            }
          } else {
            $('.create-course-block').hide();
            $('#preview-container').append(response.html);
          }
          $('body').animate({scrollTop: '0px'}, 0);
          let datetimepicker = $('.datetimepicker');
          $.each(datetimepicker, function (index, element) {
            element = element.getElementsByTagName('input');
            if (!element.length) return;
            element = element[0];

            $(this).flatpickr(getOptionFromElement(element));
          });
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
  }

  // back button
  $(document).on('click', '#btn-back', function () {
    $('#preview-container').html('');
    if (step === 3) {
      $('.create-course-block-step-3').show();
    } else {
      $('.create-course-block').show();
    }
  });

  function appendImageFormStep3() {
    const previewImg = $('#form-course input[name="preview[]"]');
    for (let i = 0; i < previewImg.length; i++) {
      if (previewImg[i].files[0] && !$(previewImg[i]).hasClass('img-remove-step')) {
        $(previewImg[i]).prop('files', previewImg[i].files);
        $('#form-course-3').append(previewImg[i]);
      }
    }
  }

  $(document).on('click', '#step-3-draft', function () {
    appendImageFormStep3();
    submitForm(true);
    // $('#save-draft-3').trigger('click');
  });

  // draft btn
  $(document).on('click', '#btn-draft', function () {
    $("#loading-overlay").show();
    if (step === 3) {
      appendImageFormStep3();
      $('#save-draft-3').trigger('click');
    } else {
      $('#save-draft').trigger('click');
    }
  });

  // public course
  $(document).on('click', '.btn-public-course', function () {
    $("#loading-overlay").show();
    if (step === 3) {
      appendImageFormStep3();
      $('#btn-submit-3').trigger('click');
    } else {
      $('#btn-submit').trigger('click');
    }
  });
});
