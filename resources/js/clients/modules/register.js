$(document).ready(function () {
    const MAX_AGE = 20;
    const IS_CHECKED = 1;
    $('.register-less-20__birthday').on('click', '.select', function (e) {
        let parentSelect = e.currentTarget;
        // remove all active select
        let allSelect = document.getElementsByClassName('select active');
        if (allSelect[0] && allSelect[0] != parentSelect) {
            allSelect[0].classList.remove('active');
        }
        let valueSelected = e.currentTarget.querySelector(".select__value");
        let valueOptions = e.currentTarget.querySelectorAll(".select__item");
        let listOptions = e.currentTarget.querySelector(".select__options");
        for (let i = 0; i < valueOptions.length; i++) {
            valueOptions[i].classList.remove('item-active');
            if (valueSelected.value.replace(/^\s+/, '').replace(/\s+$/, '') == valueOptions[i].textContent.replace(/^\s+/, '').replace(/\s+$/, '')) {
                valueOptions[i].classList.add('item-active');
                listOptions.scrollTop = valueOptions[i].offsetTop - 40;
            }
        }
        parentSelect.classList.toggle("active");
    })

    $('.register-less-20__birthday').on('click', '.select__item', function (e) {
        e.currentTarget.parentElement.parentElement.querySelector(".select__value").value = e.currentTarget.textContent;
        checkValid();
    })

    $('.register-less-20__birthday').on('click', '.select__item__year, .select__item__month', function (e) {
        e.currentTarget.parentElement.parentElement.querySelector(".select__value").value = e.currentTarget.textContent;
        checkValid();
        let day = new Date($(".register-less-20__birthday__year__value").val(), $(".register-less-20__birthday__month__value").val(), 0).getDate();
        let minYear = new Date().getFullYear() - 18;
        let monthNow = new Date().getMonth() + 1;
        let maxDay = new Date().getDate();
        let maxMonth = 12;
        let monthInput = new Date($('.register-less-20__birthday__month__value').val()).getMonth() + 1;
        let yearInput = new Date($('.register-less-20__birthday__year__value').val()).getFullYear();
        if (yearInput === minYear) {
            maxMonth = monthNow;
            let monthInput1 = new Date($('.register-less-20__birthday__month__value').val()).getMonth() + 1;
            if (monthInput1 >= maxMonth) {
                day = maxDay;
            }
        }
        let dataAppendMonth = '';
        let dataAppend = '';
        for (let i = 1; i <= day; i++) {
            dataAppend += `<div class="select__item f-w3">${i < 10 ? '0' + i : i}</div> \n`;
        }
        for (let i = 1; i <= maxMonth; i++) {
            dataAppendMonth += `<div class="select__item select__item__month f-w3">${ i < 10 ? '0' + i : i }</div> \n`
        }
        $('.select__options__day, .select__options__month').empty();
        $('.select__options__day').append(dataAppend);
        $('.select__options__month').append(dataAppendMonth);
        if ($('.register-less-20__birthday__day__value').val() > day) {
            $('.register-less-20__birthday__day__value').val(day);
        }
        if ($('.register-less-20__birthday__month__value').val() > maxMonth) {
            $('.register-less-20__birthday__month__value').val(maxMonth < 10 ? '0' + maxMonth : maxMonth);
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

    // function formatMonth(value) {
    //     let valueFormat = "";
    //     if (value > 12) {
    //         valueFormat = "12";
    //     } else if (Number(value) < 1) {
    //         valueFormat = "01"
    //     } else if (String(value).length === 1) {
    //         valueFormat = `0${value}`;
    //     } else {
    //         valueFormat = value;
    //     }
    //     $(".register-less-20__birthday__month__value").val(valueFormat);
    // }

    // function formatDay(value) {
    //     let valueFormat = "";
    //     if (String(value).length === 1) {
    //         valueFormat = `0${value}`;
    //     } else if (Number(value) < 1) {
    //         valueFormat = "01"
    //     } else {
    //         valueFormat = value;
    //     }
    //     $(".register-less-20__birthday__day__value").val(valueFormat)
    // }

    function showElement() {
        $(".wrap-confirm").removeClass("hidden-element");
        $(".wrap-confirm").addClass("show-element");
    };

    function hiddenElement() {
        $(".wrap-confirm").removeClass("show-element");
        $(".wrap-confirm").addClass("hidden-element");
    };

    let checkAge = false;
    function checkValid() {
        let currentDay = new Date().getDate();
        let currentMonth = new Date().getMonth() + 1;
        let currentYear = new Date().getFullYear();
        if ((parseInt(currentYear) - parseInt($(".select__value").val())) < MAX_AGE) {
            showElement();
            checkAge = true;
        } else if ((parseInt(currentYear) - parseInt($(".select__value").val())) > MAX_AGE) {
            hiddenElement();
            unCheckedBox();
            checkAge = false;
        } else if ((parseInt(currentYear) - parseInt($(".select__value").val())) === MAX_AGE) {
            if (currentMonth < $(".register-less-20__birthday__month__value").val()) {
                showElement();
                checkAge = true;
            } else if (currentMonth > $(".register-less-20__birthday__month__value").val()) {
                hiddenElement();
                unCheckedBox();
                checkAge = false;
            } else {
                if (currentDay < $(".register-less-20__birthday__day__value").val()) {
                    showElement();
                    checkAge = true;
                } else {
                    hiddenElement();
                    unCheckedBox();
                    checkAge = false;
                }
            }
        }
    }

    if ($('#hidden-checkbox').val() == IS_CHECKED) {
        checkedBox();
        checkAge = false;
    } else {
        $('.register-checked').hide();
        checkAge = true;
    }

    $('.register-not-checked').click(() => {
        checkedBox();
    })
    $('.register-checked').click(() => {
        unCheckedBox();
    })

    function checkedBox() {
        $('#hidden-checkbox').val(IS_CHECKED);
        checkAge = false;
        $('.register-checked').show();
        $('.register-not-checked').hide();
        $('.error-checked').html('');
    }

    function unCheckedBox() {
        $('#hidden-checkbox').val(0);
        checkAge = true;
        $('.register-not-checked').show();
        $('.register-checked').hide();
    }

    // function validateDay() {
    //     let daysInMonth = new Date($(".select__value").val(), $(".register-less-20__birthday__month__value").val(), 0).getDate();
    //     let value = $(".register-less-20__birthday__day__value").val();
    //     let numArr = value.match(/\d/g);
    //     if (numArr) {
    //         $(".register-less-20__birthday__day__value").val(Math.max(Math.min(value.match(/\d/g).join(""), daysInMonth), 0));
    //         let dayValue = $(".register-less-20__birthday__day__value").val();
    //         if (String(dayValue).length === 1) {
    //             $(".register-less-20__birthday__day__value").val(`0${dayValue}`)
    //         }
    //     } else {
    //         $(".register-less-20__birthday__day__value").val("");
    //     }
    // }

    // // validate birthday
    // $(".select__value").on("input", function () {
    //     checkValid();
    //     validateDay();
    // });
    // //validate month
    // $(".register-less-20__birthday__month__value").on("input", function () {
    //     checkValid();
    //     validateDay();
    //     let value = $(this).val();
    //     let numArr = value.match(/\d/g);
    //     if (numArr) {
    //         $(this).val(Math.max(Math.min(value.match(/\d/g).join(""), 12), 0));
    //     } else {
    //         $(this).val("");
    //     }
    // });
    // $(".register-less-20__birthday__month__value").blur(function () {
    //     formatMonth($(this).val());
    //     checkValid();
    // });
    // //validate day
    // $(".register-less-20__birthday__day__value").on("input", function () {
    //     checkValid();
    //     validateDay();
    // });
    // $(".register-less-20__birthday__day__value").blur(function () {
    //     formatDay($(this).val());
    // });

    $(".email-auth #resend-email").on("click", function () {
        $.ajax({
            beforeSend: function () {
                $('#loading-overlay').show();
            },
            type: 'GET',
            url: '/resend-email',
            data: {
                email: $("#email").val(),
                user_type: $("#user-type").val(),
                login_type: $("#login-type").val(),
                change_email: $("#change-email").val()
            },
        }).then((response) => {
            if (response.message) {
                $(".email-auth").append(`<div id="show-toast-success" data-msg="メールを送信しました。" ></div>`)
                let toastSuccess = $('#show-toast-success');

                if (toastSuccess.length > 0) {
                    toastr.info(toastSuccess.data('msg')).css({ "width": "486px", "height": "78px" });
                }
                $('#loading-overlay').hide();
            }
            else {
                window.location.replace("/register-success");
                $('#loading-overlay').hide();
            }
        }).catch(() => {
            $(".email-auth").append(`<div id="show-toast-error" data-msg="あなたのメールアドレスが間違っています" ></div>`)
            let toastError = $('#show-toast-error');

            if (toastError.length > 0) {
                toastr.info(toastError.data('msg')).css({ "width": "486px", "height": "78px" });
            }
            $('#loading-overlay').hide();
        })
    })
    checkValid()
    $("#register-form").submit(function (e) {
        if (checkAge && $('#hidden-checkbox').val() != IS_CHECKED) {
            // if (!$("#agree").is(":checked")) {
            //     e.preventDefault();
            // }
            $('.error-checked').html('親権者の同意の選択は必須です。');
            e.preventDefault();
        }
        checkValid()
    })
});
