$('body').on('click', '.button-fix-info', function () {
    $('.info-input-select').removeClass('form-option');
    $('.change-account-setting').removeClass('change-account-setting__all')
    $('.change-account-setting').find('input').each(function () {
        $(this).removeAttr('disabled');
        $('.info-input-select-tag').removeAttr('disabled')
    });
    $('.button-submit').removeClass('button-submit-hidden');
    $(this).addClass('button-fix-info-hidden');

})
$('body').on('click', '.button-cancel', function () {
    disableButton();
    removeChange();
})
$('body').on('click', '.button-confirm', function () {
    $('#dropdown').css("display", "none");
    let route = $(this).data('url');
    const branchNameElem = $('#branch_name');
    const accountNumberElem = $('#account_number');
    const bankNameElem = $('#bank_name');
    const accountNameElem = $('#account_name');

    $.ajax({
        beforeSend: function () {
            $('.lds-ellipsis').show();
        },
        method: "POST",
        url: route,
        data: $("#updateBankAccountSubmit").serialize(),
        success: function (response) {
            setTimeout(function () {
                $('.lds-ellipsis').hide();
            }, 300);

            if (response.success) {
                toastr.success("変更しました。");
                let bankNameUp = bankNameElem.val();
                let branchNameUp = branchNameElem.val();
                let accountNumberUp = accountNumberElem.val();
                let accountNameUp = accountNameElem.val();
                $('.account_number-show-error').html('');

                let optionUp = $('.account_type-input').val();
                $('.title-option').attr('data-current', optionUp);
                branchNameElem.attr('data-value', branchNameUp);
                bankNameElem.attr('data-value', bankNameUp);
                accountNumberElem.attr('data-value', accountNumberUp);
                accountNameElem.attr('data-value', accountNameUp);
                $('#dropdown p').filter(function () {
                    $(this).removeClass('selected');
                    return $(this).data('type') === parseInt(optionUp);
                }).addClass('selected');

                disableButton()
            } else {
                if (response.message) {
                    toastr.error(response.message);
                } else {
                    toastr.error('変更に失敗しました');
                }
            }
        },
        error: function (response) {
            setTimeout(function () {
                $('.lds-ellipsis').hide();
            }, 300);
            toastr.error("変更に失敗しました");
            $.each(response.responseJSON.data.errors, function (field_name, error) {
                $('.' + error['key'] + '-show-error').html(error['error']);
            })

        }
    })
})
checkHiddenModal();
$('body').on('click', '#apply-transfer-completed', function () {
    // let date = new Date();
    // let month = date.getMonth() + 1;
    // if (month < 10) {
    //     month = '0' + month;
    // }
    // let year = date.getFullYear();
    let totalPrice = $(this).data('price');
    let route = $(this).data('url');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        method: "POST",
        url: route,
        data: {withdrawal_amount: totalPrice},
        cache: false
    })
        .done(function (response) {
            $('#loading-overlay').hide();
            if (response.success) {
                checkHiddenModal();
                $('#apply-transfer-completed-success').trigger('click');
            }
        });
})
$('body').on('click', '.button-reload', function () {
    location.reload();
})

/**
 * disable button.
 */
function disableButton() {
    $('.change-account-setting').find('input').each(function () {
        $(this).attr('disabled', 'disabled');
        $('.info-input-select-tag').attr('disabled', 'disabled');
    });
    $('.button-fix-info').removeClass('button-fix-info-hidden');
    $('.button-submit').addClass('button-submit-hidden');
    $('.info-input-select').addClass('form-option');
    // $('.account_number-show-error').html('');
    // $('.account_name-show-error').html('');
    $('.branch_name-show-error').html('');
    $('.bank_name-show-error').html('');
    $('.change-account-setting').addClass('change-account-setting__all');
}

/**
 * remove change.
 */
function removeChange() {
    let bankName = $('#bank_name').attr("data-value");
    let branchName = $('#branch_name').attr("data-value");
    let accountNumber = $('#account_number').attr("data-value");
    let accountName = $('#account_name').attr("data-value");
    // let selectOption = $('#input').attr("data-value");
    let currentOption = $('.title-option').attr("data-current"); //Get current option first change .
    $('#bank_name').val(bankName);
    $('#branch_name').val(branchName);
    $('#account_number').val(accountNumber);
    $('#account_name').val(accountName);
    // $("#input option[value='" + selectOption + "']").prop('selected', true);
    $('#dropdown p').filter(function () {
        $(this).removeClass('selected');
        return $(this).data('type') === parseInt(currentOption);
    }).addClass('selected');
    //Set text in tag span when first change.
    if ($('.selected')) {
        pickElement = $('.selected').html();
        pickElementValue = $('.selected').data('type');
        $('.title-option').html(pickElement);
        $('.title-option').attr('data-accountType', pickElementValue);
        $('.account_type-input').val(pickElementValue)
    }
    $('#dropdown').css("display", "none");
}


/**
 * Check disable button apply transfer when price = 0.
 */
function checkHiddenModal() {
    let checkPrice = $('#button-apply-check-price').attr('data-hidden');
    if (checkPrice <= 0) {
        $('#button-apply-check-price').attr("disabled", true);
    }
}
