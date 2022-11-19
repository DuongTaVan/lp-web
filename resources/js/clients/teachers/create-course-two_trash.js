require('./main-course');

let TOTAL_EXTENSION = 0;
const QUANTITY_ADD_EXTENSION = 3
$(document).ready(() => {
    checkExtension();
});
//check Extension when reload page.
const checkExtension = () => {
    let item = $('.add-extension').parent().children();
    let extensionItem = item[1].children.length - 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${extensionItem}件)`;
    if (extensionItem > TOTAL_EXTENSION) {
        $('.add-extension').empty();
        $('.add-extension').append(appendAddExtension);
    }
    if (extensionItem >= 2) {
        $('.add-extension').hide();
    }
}
$('.add-extension').on('click', function () {
    let item = $(this).parent().children();
    let itemCanAdd = 3 - item[1].children.length - 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${itemCanAdd}件)`;
    $(this).empty();
    $(this).append(appendAddExtension);
    if (item[1].children.length < QUANTITY_ADD_EXTENSION) {
        $('#list-extension-request').append(`<div class="item_wrap"><div class="wrap-item__value__extension-request align-items-baseline m-0">
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
                    <input type="text" name="money[]" class="select__value-item f-w3 select__value-item__custom" placeholder="金額" value="" maxlength="15">
                    <small>※￥1,000以上からで入力して下さい。</small>
                </div>
            </div>
            <span class="remove f-w3">
                削除する
            </span>
        </div>
        `)
        // TOTAL_EXTENSION++;
    }
    if (item[1].children.length >= QUANTITY_ADD_EXTENSION) {
        $('.add-extension').hide()
    }
});

$('#list-extension-request').on('click', '.remove', function (e) {
    let itemCanAdd = QUANTITY_ADD_EXTENSION - $(this).parents('#list-extension-request').children().length + 1;
    let appendAddExtension = `
        <img src="/assets/img/clients/teacher/add-time.svg" alt="">
        延長リクエストを追加する（あと${itemCanAdd}件)`;
    e.stopPropagation();
    $(this).parents('.item_wrap').remove();
    TOTAL_EXTENSION--;
    if (TOTAL_EXTENSION < 2) {
        $('.add-extension').empty();
        $('.add-extension').append(appendAddExtension);
        $('.add-extension').show()
    }
});
