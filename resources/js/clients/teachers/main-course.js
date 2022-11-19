let TOTAL_IMAGE = 0;
if (typeof $(".preview-box").data("image") !== "undefined") {
    TOTAL_IMAGE = $(".preview-box").data("image");
}
let TOTAL_TIME = 0;
let TOTAL_TIME_INDIVIDUAL = 0;
const QUANTITY_ADD_TIME = $ ('#max_course').val() ?? 5;
const QUANTITY_ADD_TIME_INDIVIDUAL = $('#max_sub').val() ?? 5;
$(document).ready(() => {
    checkTimeOption();
    checkTimeIndividual();

    let widthScreen = window.innerWidth;
    let sizePreviewImg = (widthScreen - 30) / 4 - 10;
    if (widthScreen < 776) {
        $('.preview').css({
            width: sizePreviewImg,
            height: sizePreviewImg
        });
    }

    $('#maskOptionApp').on('click', () => {
        $('#optionMaskModal').modal('toggle');
        $(window).on('shown.bs.modal', function () {
            $('#optionMaskModal').modal('show');
            $('.create-course-one').css({
                overflow: 'auto',
                height: 'auto'
            });
        });
    })
    $('#optionMaskModal').on('hidden.bs.modal', function () {
        $('.create-course-one').css({
            overflow: 'unset',
            height: 'unset'
        });
    })

    $('.option-text1').on('click', () => {
        $('#optionMaskModal').modal('hide');
        $('.option-mask-input').html($('.option-text1').html());
        $('.hidden_input-is-mask').val(0)
        $('.option-text1').addClass('f-w6');
        $('.option-text2').removeClass('f-w6');
    })
    $('.option-text2').on('click', () => {
        $('#optionMaskModal').modal('hide');
        $('.hidden_input-is-mask').val(1)
        $('.option-mask-input').html(`<div>${$('.option-text2').html()}<div class="lappi-ai-select lappi-ai p-0">${$('.note-ng').html()}</div></div>`)
        $('.option-text2').addClass('f-w6');
        $('.option-text1').removeClass('f-w6');
    })
});
const checkTimeOption = () => {
    let itemTime = $('.wrap-time-select').length;
    const addTime = $('.add-time');

    if (itemTime > TOTAL_TIME) {
        let appendAddTime = `
            <img src="/assets/img/clients/teacher/add-time.svg" alt="">
            開催日時を追加する（あと${QUANTITY_ADD_TIME - itemTime}件)
        `;
        addTime.empty();
        addTime.append(appendAddTime);
        addTime.removeClass('add-time-custom')
    }
    if (itemTime >= QUANTITY_ADD_TIME) {
        addTime.hide();
    }
}
const checkTimeIndividual = () => {
    const itemIndividual = $('.add-time-individual');
    if (!itemIndividual.length) return;
    let item = itemIndividual.parent().children();
    let timeItem = item[0].children.length - 1;
    if (timeItem > TOTAL_TIME_INDIVIDUAL) {
        let appendAddTime = `
            <img src="/assets/img/clients/teacher/add-time.svg" alt="">
            開催日時を追加する（あと${QUANTITY_ADD_TIME_INDIVIDUAL - item[0].children.length}件)
        `;
        itemIndividual.empty();
        itemIndividual.append(appendAddTime);
        itemIndividual.removeClass('add-time-custom')
    }
    if (timeItem + 1 >= QUANTITY_ADD_TIME_INDIVIDUAL) {
        itemIndividual.hide();
    }
}
window.onload = function () {
//add-time
    $(document).on('click', '.add-time', function (e) {
        let item = $("#list-wrap-time").find(".wrap-time");
        let itemCanAdd = QUANTITY_ADD_TIME - item.length - 1;
        let appendAddTime = `
            <img src="/assets/img/clients/teacher/add-time.svg" alt="">
            開催日時を追加する（あと${itemCanAdd}件)
        `;
        $(this).empty();
        $(this).append(appendAddTime);
        $(this).removeClass('add-time-custom')
        if (item.length < QUANTITY_ADD_TIME) {

            $('#list-wrap-time').append(`
                <div class="wrap-time wrap-time-select">
                    <div class="d-flex">
                        <div class="wrap-time__date datetimepicker">
                            <input type="text" class="preview-start-day" name="start_day[]" data-input data-format="Y/m/d" autocomplete="off">
                            <img class="img-date" src="/assets/img/clients/teacher/date-picker.svg" data-toggle alt="">
                        </div>
                        <div class="wrap-time__time datetimepicker">
                            <input type="text" class="start-time-preview" name="start_time[]" data-input data-datepicker="false" data-format="H:i" autocomplete="off">
                            <img class="img-time" src="/assets/img/clients/teacher/time-picker.svg" data-toggle alt="">
                        </div>
                    </div>
                    <span class="remove-item f-w3">削除する</span>
                </div>
            `)

            let datetimepicker = $('.datetimepicker');
            $.each(datetimepicker, function (index, element) {
              element = element.getElementsByTagName('input');
              if (!element.length) return;
              element = element[0];

              $(this).flatpickr(getOptionFromElement(element));
            });
        }
        if (item.length + 1 >= QUANTITY_ADD_TIME) {
            $(this).hide()
        }

    })
    $(document).on('click', '#list-wrap-time .remove-item', function (e) {
        let itemCanAdd = QUANTITY_ADD_TIME - $(this).parents('#list-wrap-time').children().length + 1;
        let appendAddTime = `
            <img src="/assets/img/clients/teacher/add-time.svg" alt="">
            開催日時を追加する（あと${itemCanAdd}件)
        `;
        e.stopPropagation();
        $(this).parent()[0].remove();
        TOTAL_TIME--;
        if (TOTAL_TIME < 3) {
            const addTime = $('.add-time');
            addTime.empty();
            addTime.removeClass('d-none');
            addTime.append(appendAddTime);
            addTime.removeClass('add-time-custom')
            addTime.show();
        }
    })
//add-time-individual
    $(document).on('click', '.add-time-individual', function (e) {
        let item = $(this).parent().children();
        let itemCanAdd = QUANTITY_ADD_TIME_INDIVIDUAL - item[0].children.length - 1;
        let appendAddTime = `
            <img src="/assets/img/clients/teacher/add-time.svg" alt="">
            開催日時を追加する（あと${itemCanAdd}件)
        `;
        $(this).empty();
        $(this).append(appendAddTime);
        $(this).removeClass('add-time-custom')
        if (item[0].children.length < QUANTITY_ADD_TIME_INDIVIDUAL) {

            $('#list-individual-time').append(`
                <div class="wrap-time wrap-time-select">
                    <div class="d-flex">
                        <div class="wrap-time__date datetimepicker">
                            <input type="text" id="start" name="sub_start_day[]" data-input data-format="Y/m/d" autocomplete="off">
                            <img class="img-date" src="/assets/img/clients/teacher/date-picker.svg" data-toggle alt="">
                        </div>
                        <div class="wrap-time__time datetimepicker">
                            <input type="text" id="appt" name="sub_start_time[]" data-input data-datepicker="false" data-format="H:i" autocomplete="off">
                            <img class="img-time" src="/assets/img/clients/teacher/time-picker.svg" data-toggle alt="">
                        </div>
                    </div>
                    <span class="remove-item f-w3">削除する</span>
                </div>
            `);
            let datetimepicker = $('.datetimepicker');
            $.each(datetimepicker, function (index, element) {
              element = element.getElementsByTagName('input');
              if (!element.length) return;
              element = element[0];

              $(this).flatpickr(getOptionFromElement(element));
            });
            // TOTAL_TIME_INDIVIDUAL++;
        }
        if (item[0].children.length >= QUANTITY_ADD_TIME_INDIVIDUAL) {
            $(this).hide();
        }
    })
    $(document).on('click', '#list-individual-time .remove-item', function (e) {
        let itemCanAdd = QUANTITY_ADD_TIME_INDIVIDUAL - $(this).parents('#list-individual-time').children().length + 1;
        let appendAddTime = `
            <img src="/assets/img/clients/teacher/add-time.svg" alt="">
            開催日時を追加する（あと${itemCanAdd}件)
        `;
        e.stopPropagation();
        $(this).parent()[0].remove();
        TOTAL_TIME_INDIVIDUAL--;
        if (TOTAL_TIME_INDIVIDUAL < 3) {
            const addTimeInd = $('.add-time-individual');
            addTimeInd.empty();
            addTimeInd.removeClass('d-none');
            addTimeInd.append(appendAddTime);
            addTimeInd.removeClass('add-time-custom')
            addTimeInd.show()
        }
    })

    // select minute required
    $(document).on('click', '.wrap-item__value .select', function (e) {
        let parentSelect = e.currentTarget;
        // remove all active select
        let allSelect = document.getElementsByClassName('select active');
        if (allSelect[0] && allSelect[0] !== parentSelect) {
            allSelect[0].classList.remove('active');
        }
        let itemSelected = e.currentTarget.querySelector(".hidden_input").getAttribute("data-item");
        let valueSelected = e.currentTarget.querySelector(".select__value-item");
        let valueOptions = e.currentTarget.querySelectorAll(".select__item");
        for (let i = 0; i < valueOptions.length; i++) {
            valueOptions[i].classList.remove('item-active');
            if (valueSelected.value.replace(/^\s+/, '').replace(/\s+$/, '') == valueOptions[i].textContent.replace(/^\s+/, '').replace(/\s+$/, '') || itemSelected == valueOptions[i].getAttribute("data-minute")) {
                valueOptions[i].classList.add('item-active');
            }
        }
        parentSelect.classList.toggle("active");
    })

    $(document).on('click', '.wrap-item__value .select__item', function (e) {
        // let data = e.currentTarget.getAttribute("data-id");
        // // $(this).parent().parent().children()[1].setAttribute("value", data);
        e.currentTarget.parentElement.parentElement.querySelector(".select__value-item").value = e.currentTarget.textContent.replace(/ +/g, " ").trim();
        if (e.currentTarget.parentElement.parentElement.querySelector(".hidden_input")) {
            e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").value = $(this).data('minute');
            e.currentTarget.parentElement.parentElement.querySelector(".hidden_input").setAttribute("data-item", $(this).data('minute'));
        }
        if (e.currentTarget.parentElement.parentElement.querySelector(".is-mask-required")) {
            $(".is-mask-required").html($(this).html());
            if ($($(e.currentTarget).children()[1]).hasClass('lappi-ai')) {
                $(e.currentTarget).addClass('item-active')
                $(".is-mask-required").html(`<div>${$($(e.currentTarget).children()[0]).html()}<div class="lappi-ai-select lappi-ai p-0">${$($(e.currentTarget).children()[1]).html()}</div></div>`);
                e.currentTarget.parentElement.parentElement.querySelector(".select__value-item").value = $($(e.currentTarget).children()[0]).text().replace(/ +/g, " ").trim();
            }
        }
    })

    document.body.addEventListener('mouseup', function (e) {
        if (e.target.closest('.select') === null) {
            let selectBox = document.querySelectorAll('.select')
            for (let i = 0; i < selectBox.length; i++) {
                selectBox[i].classList.remove('active');
            }
        }
    });

    // end select minute

//image
    //reset form data image where reload page
    for (let i = 0; i < document.getElementsByName("preview[]").length; i++) {
        document.getElementsByName("preview[]")[i].value = '';
    }

    $(document).on('click', '#list-img #upload-box', function () {
        $(this).find('input')[0].click()
    })
    const arr = [];

    $(document).on('click', '#list-img .remove-img', function (e) {
        e.stopPropagation();
        const key = $(this).data('key');
        if (key) {
          $('.preview-' + key).find('input').addClass('img-remove-step');
        }
        $(this).parent().remove();
        TOTAL_IMAGE--;
        if (TOTAL_IMAGE === 3) {
            showUploadBox();
        }
        if (update != null) {
            arr.push($(this).data('value'));
            $('input[name="image_id"]').val(JSON.stringify(arr));
        }

    });

    var update = $('.preview-box').data('update');
    if (update != null) {
        let selector = $('#list-img');
        selector.find('.remove-img').show();
        selector.find('.preview-img').css('width', '159px')
        selector.find('.preview-img').css('height', '164px')
        selector.find('.remove-img').css('display', 'flex');
    }

    $(document).on('click', '#back-step-livestream', function () {
      TOTAL_IMAGE = $(".list-img-step-2").find('.preview').length;
    });

    $(document).on('change', '#list-img input[name=preview\\[\\]]', function () {
        const files = this.files[0];
        let x = '159px';
        let y = '164px';
        let sizePreviewImg = (window.innerWidth - 30) / 4 - 10;
        if ($(document).width() <= 414) {
            x = sizePreviewImg;
            y = sizePreviewImg;
        }
      console.log(TOTAL_IMAGE);
        if (files) {
            if (files.size / 1024 > 5120) {
                $(this).val('');
                $(".image-box-error").html('アップロードされたファイルは5MBを超えています。')
                return;
            }

            let matchImage = ["image/png", "image/jpg", "image/jpeg", "image/gif"];
            if (!matchImage.includes(files.type)) {
                $(".image-box-error").html('JPEG, JPG, GIF, PNG形式のファイルを選択してください。')
                return;
            }

            TOTAL_IMAGE++;
            const src = URL.createObjectURL(files);
            const parent = $(this).parent();
            parent.removeAttr('id');
            parent.addClass(`preview preview-${TOTAL_IMAGE - 1}`);
            parent.find('.preview-img').attr('src', src)
            parent.find('.preview-img').css('width', x)
            parent.find('.preview-img').css('height', y)
            parent.find('.remove-img').show()
            parent.find('.remove-img').css('display', 'flex')
            parent.find('.remove-img').attr('data-key', TOTAL_IMAGE - 1);
        }

        if (TOTAL_IMAGE < 4) {
            showUploadBox();
        }
    });

    // if (update != null) {
    TOTAL_IMAGE = $('div.preview').length ?? 0;
    if (TOTAL_IMAGE < 4) {
        showUploadBox();
    }

    // }

    function showUploadBox() {
        // if (update != null) {
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
        // } else {
        //     const uploadBtnElm = $('.clone').html();
        //     $('#list-img').append(uploadBtnElm);
        // }
    }

}

$(document).on("click", '.course .preview-zone', function () {
    const backElm = $(".course .back-container")
    const saveElm = $(".course .save-container")
    const previewElm = $(".course .preview-container")

    const nextBtn = $(".course .next-zone");

    const backActive = $(".course .back-container").is(':visible');
    const previewActive = $(".course .preview-container").is(':visible');

    if (backElm.length && saveElm.length && !previewElm.length) {
        if ($(this).hasClass("active")) {
            saveElm.css("display", "");
            backElm.css("display", "none");
            $(this).removeClass("active");
            nextBtn.addClass("active");
        }
    }

    if (backElm.length && saveElm.length && previewElm.length) {
        if ($(this).hasClass("active")) {
            if (previewActive) {
                previewElm.attr('style', 'display: none !important');
                backElm.css("display", "block");
                nextBtn.addClass("active");
            }
            if (backActive) {
                backElm.css("display", "none");
                saveElm.css("display", "");
                $(this).removeClass("active");
                nextBtn.addClass("active");
            }
        }
    }
});

$(document).on("click", '.course .next-zone', function () {
    const backElm = $(".course .back-container")
    const saveElm = $(".course .save-container")
    const previewElm = $(".course .preview-container")

    const previewBtn = $(".course .preview-zone");

    const backActive = $(".course .back-container").is(':visible');
    const saveActive = $(".course .save-container").is(':visible');

    if (backElm.length && saveElm.length && !previewElm.length) {
        if ($(this).hasClass("active")) {
            saveElm.css("display", "none");
            backElm.css("display", "block");
            $(this).removeClass("active");
            previewBtn.addClass("active");
        }
    }

    if (backElm.length && saveElm.length && previewElm.length) {
        if ($(this).hasClass("active")) {
            if (saveActive) {
                saveElm.css("display", "none");
                backElm.css("display", "block");
                previewBtn.addClass("active");
            }
            if (backActive) {
                backElm.css("display", "none");
                previewElm.css({
                    "display": "block",
                    "position": "unset",
                    "width": "calc(100% - 82px)"
                });
                $(this).removeClass("active");
                previewBtn.addClass("active");
            }
        }
    }
});
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import ClassicEditor from './../commons/ckeditor';

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
const pathPreview = [
  '/teacher/courses/create',
  '/teacher/courses/',
  '/teacher/course_schedules/'
];

let check = true;
for (let i = 0; i < pathPreview.length; i++) {
  if (window.location.pathname.startsWith(pathPreview[i])) {
    check = false;
    break;
  }
}

if ($("#body").length && check) {
    ClassicEditor.create(document.querySelector('#body'), configCkeditor);
    ClassicEditor.create(document.querySelector('#flow'), configCkeditor);
    ClassicEditor.create(document.querySelector('#cautions'), configCkeditor);
    ClassicEditor.create(document.querySelector('#subtitle'), configCkeditor);
}
