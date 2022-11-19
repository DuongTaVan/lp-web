const IMAGE_PREVIEW = [];
let TOTAL_IMAGE = 0;
let TOTAL_TIME = 0;
let TOTAL_TIME_INDIVIDUAL = 0;
let TOTAL_EXTENSION = 0;
let TOTAL_OPTION = 0;
window.onload = function () {
    //add-time
    $(document).on('click', '.add-time', function (e) {
        let item = $(this).parent().children();
        if (item[0].children.length < 5) {

            $('#list-wrap-time').append(`<div class="wrap-time wrap-time-select">
                        <div class="d-flex">
                            <div class="wrap-time__date datetimepicker">
                                <input type="text" id="start" name="start_day[]" data-input data-format="Y-m-d" autocomplete="off">
                                <img class="img-date" src="/assets/img/clients/teacher/date-picker.svg" alt="" data-toggle>
                            </div>
                            <div class="wrap-time__time datetimepicker">
                                <input type="text" id="appt" name="start_time[]" data-input data-datepicker="false" data-format="H:i" autocomplete="off">
                                <img class="img-time" src="/assets/img/clients/teacher/time-picker.svg" alt="" data-toggle>
                            </div>
                        </div>
                        <span class="remove-item f-w3">
                        <img src="/assets/img/clients/teacher/remove-item.svg" alt="">
                            削除する
                        </span>
                    </div>`)
        }
        if (item[0].children.length >= 5) {
            $(this).hide();
        }
    })
    $(document).on('click', '#list-wrap-time .remove-item', function (e) {
        let item = $(this).parent().children();
        e.stopPropagation();
        $(this).parent()[0].remove();
        if (item[0].children.length < 5) {
            $('.add-time').removeClass('d-none');
            $('.add-time').show()
        }
    })

    $(document).on('click', '#list-wrap-time .img-date, .img-time', function (e) {
        $(this).parent()[0].children[0].classList.toggle("active");
        $(this).parent()[0].children[0].click();
        e.stopPropagation();
    })

    //add-time-individual
    $(document).on('click', '.add-time-individual', function (e) {
        let item = $(this).parent().children();
        if (item[0].children.length < 5) {
            $('#list-individual-time').append(`<div class="wrap-time">
                    <div class="d-flex">
                        <div class="wrap-time__date datetimepicker">
                            <input type="text" id="start" name="sub_start_day[]" data-input data-format="Y-m-d" autocomplete="off">
                            <img class="img-date" src="/assets/img/clients/teacher/date-picker.svg" alt="" data-toggle>
                        </div>
                        <div class="wrap-time__time datetimepicker">
                            <input type="text" id="appt" name="sub_start_time[]" data-input data-datepicker="false" data-format="H:i" autocomplete="off">
                            <img class="img-time" src="/assets/img/clients/teacher/time-picker.svg" alt="" data-toggle>
                        </div>
                    </div>
                    <span class="remove-item f-w3">
                        <img src="/assets/img/clients/teacher/remove-item.svg" alt="">
                        削除する
                    </span>
                </div>`)
        }
        if (item[0].children.length >= 5) {
            $(this).hide();
        }
    })
    $('#list-individual-time').on('click', '.remove-item', function (e) {
        let item = $(this).parent().children();
        e.stopPropagation();
        $(this).parent()[0].remove();
        if (item[0].children.length < 5) {
            $('.add-time-individual').removeClass('d-none');
            $('.add-time-individual').show()
        }
    })

    $('#list-individual-time').on('click', '.img-date, .img-time', function (e) {
        console.log($(this).parent()[0].children[0]);
        $(this).parent()[0].children[0].classList.toggle("active");
        $(this).parent()[0].children[0].click();
        e.stopPropagation();
    })

    $('.add-extension').on('click', function () {
        let item = $(this).parent().children();
        if (TOTAL_EXTENSION < 3) {
            if (item[1].children[0] != undefined) {
                $('#list-extension-request').append(item[1].children[0].outerHTML)
            } else {
                $('#list-extension-request').append(`<div class="wrap-item__value__extension-request">
                        <div class="d-flex">
                            <div class="wrap-item__value__select extension-request__select" onclick="select(this)">
                                <div class="select">
                                    <input type="text" name="money[]" class="select__value-item f-w3" readonly="" value="" maxlength="15">
                                    <img src="/assets/img/clients/auth/arow-down.svg" class="arrow-down" alt="">
                                    <div class="select__options">
                                        <div class="select__item f-w3" onclick="setValueSelect(this)">1</div>
                                        <div class="select__item f-w3" onclick="setValueSelect(this)">2</div>
                                        <div class="select__item f-w3" onclick="setValueSelect(this)">3</div>
                                    </div>
                                </div>
                            </div>
                            <div class="wrap-item__value__select extension-request__select extension-request__select--money" onclick="select(this)">
                                <div class="select">
                                    <input type="text" name="time[]" class="select__value-item f-w3" readonly="" value="">
                                    <img src="/assets/img/clients/auth/arow-down.svg" class="arrow-down" alt="">
                                    <div class="select__options">
                                        <div class="select__item f-w3" onclick="setValueSelect(this)">1</div>
                                        <div class="select__item f-w3" onclick="setValueSelect(this)">2</div>
                                        <div class="select__item f-w3" onclick="setValueSelect(this)">3</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="remove f-w3">
                            <img src="/assets/img/clients/teacher/remove-item.svg" alt="">
                            削除する
                        </span>
                    </div>`)
            }
            TOTAL_EXTENSION++;
        }
        if (TOTAL_EXTENSION >= 3) {
            $('.add-extension').hide()
        }
    })
    $('#list-extension-request').on('click', '.remove', function (e) {
        e.stopPropagation();
        $(this).parent().remove();
        TOTAL_EXTENSION--;
        if (TOTAL_EXTENSION < 3) {
            $('.add-extension').show()
        }
    })

    //image
    $('#list-img').on('click', '#upload-box', function () {
        $(this).find('input')[0].click()
    })

    $('#list-img').on('click', '.remove-img', function (e) {
        e.stopPropagation();
        $(this).parent().remove();
        TOTAL_IMAGE--;
        if (TOTAL_IMAGE === 3) {
            showUploadBox();
        }
    });

    $('#list-img').on('change', 'input[name=preview\\[\\]]', function () {
        const files = this.files[0];

        if (files) {
            TOTAL_IMAGE++;
            const src = URL.createObjectURL(files);
            $(this).parent().removeAttr('id');
            $(this).parent().find('.preview-img').attr('src', src)
            $(this).parent().find('.preview-img').css('width', '159px')
            $(this).parent().find('.preview-img').css('height', '164px')
            $(this).parent().find('.remove-img').show()
            $(this).parent().find('.remove-img').css('display', 'flex')
        }

        if (TOTAL_IMAGE < 4) {
            showUploadBox();
        }
    });

    function showUploadBox() {
        const uploadBtnElm = $('.clone').html();
        $('#list-img').append(uploadBtnElm);
    }

};

$('.wrap-item__value').on('click', '.select', function (e) {
    let parentSelect = e.currentTarget;
    let valueSelected = e.currentTarget.querySelector(".select__value-item");
    let valueOptions = e.currentTarget.querySelectorAll(".select__item");
    for (let i = 0; i < valueOptions.length; i++) {
        valueOptions[i].classList.remove('item-active');
        if (valueSelected.value.replace(/^\s+/, '').replace(/\s+$/, '') == valueOptions[i].textContent.replace(/^\s+/, '').replace(/\s+$/, '')) {
            valueOptions[i].classList.add('item-active');
        }
    }
    parentSelect.classList.toggle("active");
})

$('.wrap-item__value').on('click', '.select__item', function (e) {
    let data = e.currentTarget.getAttribute("data-id");
    $(this).parent().parent().children()[1].setAttribute("value", data);
    e.currentTarget.parentElement.parentElement.querySelector(".select__value-item").value = e.currentTarget.textContent;
})
document.body.addEventListener('mouseup', function (e) {
    if (e.target.closest('.select') === null) {
        let selectBox = document.querySelectorAll('.select')
        for (let i = 0; i < selectBox.length; i++) {
            selectBox[i].classList.remove('active');
        }
    }
});

$(".create-course-one .save-draft").on("click", function () {
    $('.create-course-one .course').append('<input type="hidden" name="save_type" value="9" />');
})
$(".create-course-one .confirm").on("click", function () {
    $('.create-course-one .course').append('<input type="hidden" name="save_type" value="0" />');
})
