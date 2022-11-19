require('./main-course');

const toASCII = function (chars) {
    chars = chars !== null ? chars.toString() : '';
    let ascii = '';
    if (chars) {
        for (let i = 0, l = chars.length; i < l; i++) {
            let c = chars[i].charCodeAt(0);
            // make sure we only convert half-full width char
            if (c >= 0xFF00 && c <= 0xFFEF) {
                c = 0xFF & (c + 0x20);
            }

            ascii += String.fromCharCode(c);
        }
    }

    return ascii.replace(/\D/g, '');
}

$(document).ready(function () {
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
    $('.auto-money').on('blur', function (e) {
        if ($(this).val()) {
            const n = toASCII($(this).val());
            const formatMoney = n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $(this).val(formatMoney);
        }
    })
    // $('body').on('input', '.select__value-item__custom', function () {
    //     if ($(this).val()) {
    //         const n = parseInt($(this).val().replace(/\D/g, ''), 10);
    //         const formatMoney = n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //         $(this).val(formatMoney);
    //     }
    // })
    $(".course").on("submit", function (e) {
        let startDate = document.getElementsByName("start_day[]");
        let startTime = document.getElementsByName("start_time[]");
        for (let i = 0; i < startDate.length; i++) {
            if (startDate[i].value.length === 0 || startTime[i].value.length === 0) {
                $(".error-start-datetime").html('開催日時は、必ず指定してください。');

                e.preventDefault();
            }
        }

        if ($("input[name=minutes_required]").val().length === 0) {
            $(".error-minutes_required").html('ご利用時間は、必ず指定してください。');

            e.preventDefault();
        }

    })
});

let TOTAL_EXTENSION = 0;
const QUANTITY_ADD_EXTENSION = $('#max_extension').val() ?? 3;

$(document).ready(() => {
    checkExtension();
    checkAddOption();
});
const checkExtension = () => {
    let countExtension = QUANTITY_ADD_EXTENSION - $('.wrap-item__value__extension-request').length;
    let appendAddExtension = `
    <img src="/assets/img/clients/teacher/add-time.svg" alt="">
    延長リクエストを追加する（あと${countExtension}件)`;
    if (countExtension > 0) {
        $('.add-extension').empty();
        $('.add-extension').append(appendAddExtension);
        $('.add-extension').removeClass('add-time-custom');
    } else if ($('.wrap-item__value__extension-request').length) {
        $('.add-extension').addClass('d-none');
    }
}
const checkAddOption = () => {
  const optionItem = $('#list-option-request').find(".wrap-item__value__option-request").length;
  if (optionItem >= QUANTITY_ADD_OPTION) {
    $('.add-option').hide();
  }
}

$('.add-extension').on('click', function () {
    let item = $(this).parent().children();
    let itemCanAdd = QUANTITY_ADD_EXTENSION - $('.wrap-item__value__extension-request').length;
    if (itemCanAdd < 1) {
        $('.add-extension').addClass('d-none');

        return;
    }
    itemCanAdd--;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${itemCanAdd}件)`;
    $(this).empty();
    $(this).append(appendAddExtension);
    if (item[1].children.length < QUANTITY_ADD_EXTENSION) {
        $('#list-extension-request').append(`<div class="wrap-item__value__extension-request">
                    <div class="d-flex">
                        <div class="wrap-item__value__select extension-request__select extension-request__select--money" onclick="select(this)">
                            <div class="select">
                                <input type="text" class="select__value-item f-w3" readonly value="" placeholder="時間">
                                <input type="hidden" name="time[]" class="hidden_input f-w3" value="">
                                <img src="/assets/img/clients/auth/arow-down.svg" class="arrow-down" alt="">
                                <div class="select__options">
                                    <div class="select__item f-w3 select-parent-item" onclick="setValueSelect(this)" data-minute="15">15 分</div>
                                    <div class="select__item f-w3 select-parent-item" onclick="setValueSelect(this)" data-minute="20">20 分</div>
                                    <div class="select__item f-w3 select-parent-item" onclick="setValueSelect(this)" data-minute="30">30 分</div>
                                </div>
                            </div>
                        </div>
                        <div class="extension-request__select" onclick="select(this)">
                        <span class="money-icon">¥</span>
                            <input type="text" name="money[]" placeholder="金額" class="select__value-item f-w3 select__value-item__custom" value="" maxlength="15">
                            <input type="hidden" value="" name="course_extension_id[]">
                             <small class="line-bottom">※￥1,000以上からで入力して下さい。</small>
                        </div>
                    </div>
                    <span class="remove f-w3">
                        削除する
                    </span>
             </div>`)
        // TOTAL_EXTENSION++;
    }
    if (itemCanAdd < 1) {
        $('.add-extension').addClass('d-none');
    }
})
$('#list-extension-request').on('click', '.remove', function (e) {
    let itemCanAdd = QUANTITY_ADD_EXTENSION - $('.wrap-item__value__extension-request').length + 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${itemCanAdd}件)`;
    e.stopPropagation();
    $(this).parent().remove();
    TOTAL_EXTENSION--;
    if (TOTAL_EXTENSION < 3) {
        $('.add-extension').empty();
        $('.add-extension').append(appendAddExtension);
        $('.add-extension').removeClass('add-time-custom');
        $('.add-extension').removeClass('d-none');
        $('.add-extension').show();
    }
})

$(function () {
    let item = $('.add-extension').parent().children();
    let itemCanAdd = item[1].children.length;
    if (itemCanAdd === QUANTITY_ADD_EXTENSION) {
        $('.add-extension').addClass('d-none');
    }
})

//option
let TOTAL_OPTION = 0;
const QUANTITY_ADD_OPTION = $('#max_option').val() ?? 5;
$('.add-option').on('click', function () {
    let item = $(this).parent().children();
    let itemCanAdd = QUANTITY_ADD_OPTION - item[0].children.length - 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        オプションを追加する（あと${itemCanAdd}件)`;
    $(this).empty();
    $(this).append(appendAddExtension);
    if (item[0].children.length < QUANTITY_ADD_OPTION) {
        $('#list-option-request').append(`<div class="wrap-item__value__option-request wrap-container">
            <div class="d-flex justify-content-between extra-price">
                <div class="enter-option">
                    <input type="text" class="f-w3 enter-option" placeholder="オプションを入力する" name="extra_title[]" value="">
                    <div class="f-w3 d-flex justify-content-between align-items-center">
                        <span class="wrap-item__value__note">
                            <span class="remove-option f-w3">
                                削除する
                            </span>
                        </span>
                        <span class="wrap-item__value__count">60 </span>
                    </div>
                </div>
                <div class="enter-option--small__custom">
                  <span>¥</span>
                  <input type="text" class="f-w3 enter-option--small" placeholder="" name="extra_price[]" value="" maxlength="15">
                </div>
                
            </div>
        </div>`)
        // TOTAL_OPTION++;
    }
    if (item[0].children.length >= QUANTITY_ADD_OPTION) {
        $('.add-option').hide()
    }
})
$('#list-option-request').on('click', '.remove-option', function (e) {
    let itemCanAdd = QUANTITY_ADD_OPTION - $(this).parents('#list-option-request').children().length + 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        オプションを追加する（あと${itemCanAdd}件)`;
    e.stopPropagation();
    $(this).parents('.wrap-item__value__option-request')[0].remove();
    TOTAL_OPTION--;
    if (TOTAL_OPTION < 3) {
        $('.add-option').empty();
        $('.add-option').append(appendAddExtension);
        $('.add-option').removeClass('add-time-custom');
        $('.add-option').show()
    }
})

$(function () {
    let item = $('.add-extension').parent().children();
    let itemCanAdd = item[1].children.length;
    if (itemCanAdd === QUANTITY_ADD_EXTENSION) {
        $('.add-extension').addClass('d-none');
    }
})
