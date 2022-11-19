require('./main-course');
let TOTAL_OPTION = 0;
let TOTAL_EXTENSION = 0;
const QUANTITY_ADD_OPTION = 5;
$('.add-extension').on('click', function () {
    let item = $(this).parent().children();
    let itemCanAdd = 3 - item[1].children.length - 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${itemCanAdd}件)`;
    $(this).empty();
    $(this).append(appendAddExtension);
    if (item[1].children.length < 3) {
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
                            <div class="wrap-item__value__select extension-request__select" onclick="select(this)">
                                <span class="money-icon">¥</span>
                                <input type="text" name="money[]" class="select__value-item f-w3 select__value-item__custom" value="" placeholder="金額" maxlength="15">
                            </div>
                        </div>
                        <span class="remove f-w3">
                            削除する
                        </span>
                    </div>`)
        // TOTAL_EXTENSION++;
    }
    if (item[1].children.length >= 3) {
        $('.add-extension').hide()
    }
})
$('#list-extension-request').on('click', '.remove', function (e) {
    let itemCanAdd = 3 - $(this).parents('#list-extension-request').children().length + 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${itemCanAdd}件)`;
    e.stopPropagation();
    $(this).parent().remove();
    TOTAL_EXTENSION--;
    if (TOTAL_EXTENSION < 3) {
        $('.add-extension').empty();
        $('.add-extension').append(appendAddExtension);
        $('.add-extension').show()
    }
})

//option
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
    $(this).parents('.wrap-container')[0].remove();
    TOTAL_OPTION--;
    if (TOTAL_OPTION < 3) {
        $('.add-option').empty();
        $('.add-option').append(appendAddExtension);
        $('.add-option').show()
    }
})

$(function () {
    let item = $('.add-extension').parent().children();
    let itemCanAdd = item[1].children.length;
    if (itemCanAdd === QUANTITY_ADD_EXTENSION) {
        $('.add-extension').hide()
    }
})
