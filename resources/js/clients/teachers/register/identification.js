$(document).ready(function () {
    // get value to check if we got it
    // let isChangeName = localStorage.getItem('isChangeName');
    // if (isChangeName === null) {
    //     // set the item in localStorage
    //     localStorage.setItem('isChangeName', 1);
    // }
    // if (localStorage.getItem('isChangeName') == 1) {
    //     $('#noChangeName').prop('checked', true);
    //     $('.input-surname, .input-given-name').attr('disabled', true);
    //
    // } else if (localStorage.getItem('isChangeName') == 2) {
    //     $('#changeName').prop('checked', true);
    //     $('.change-input').removeClass('d-none');
    //     $('.no-change-input').addClass('d-none');
    //     // $('.reset-value').val('');
    // }
    $('input[name=isChangeName]').on('change', function () {
        const value = +$(this).val();
        if (value) {
            $('.input-full-name').find('input').attr('readonly', false);
        } else {
            $('.input-full-name').find('input').attr('readonly', true);
        }
    })

    let removeImageIdentify = false;
    let removeImageBusiness = false;
    // click button select image
    $('.image-button').on('click', function () {
        let input = $('input[data-name=' + $(this).data('name') + ']');
        if (input.length > 0) {
            $(input[0]).trigger('click');
        }
    });
    $('.image-button1').on('click', function () {
        let input = $('input[data-name=' + $(this).data('name') + ']');
        if (input.length > 0) {
            $(input[0]).trigger('click');
        }
    });
    $('#business-submit').on('click', function () {
        let input = $('input[data-name=business_card]');
        if (input.length > 0) {
            $(input[0]).trigger('click');
        }
    });
    $('#submit-identify').on('click', function () {
        if (parseInt($('#file').attr('data-check')) === 0) {
            let input = $('input[data-name=image_identify]');
            if (input.length > 0) {
                $(input[0]).trigger('click');
            }
            return;
        }
        if (parseInt($('.file1').attr('data-check')) === 0) {
            let input = $('input[data-name=image_identify1]');
            if (input.length > 0) {
                $(input[0]).trigger('click');
            }
            return;
        }

    });
    // when select image
    $(document).on('change', 'input[class=file]', function (event) {
        let imgId = $(this).data('name');
        $('input[name=image_identify]').attr('data-check', 1);
        if (imgId === 'image_identify') {
            removeImageIdentify = false;
        } else {
            removeImageBusiness = false;
        }
        $('#' + imgId).attr("src", URL.createObjectURL(event.target.files[0]));
        $('.img-responsive').addClass('img-contain');
        $('.remove-item[data-name=' + imgId + ']').removeClass('hidden');
        $('.image-button[data-name=' + imgId + ']').addClass('hidden');
    });
    let removeImageIdentify1 = false;
    let removeImageBusiness1 = false;
    $(document).on('change', 'input[class=file1]', function (event) {
        let imgId = $(this).data('name');
        $('input[name=image_identify1]').attr('data-check', 1);
        if (imgId === 'image_identify1') {
            removeImageIdentify1 = false;
        } else {
            removeImageBusiness1 = false;
        }
        $('#' + imgId).attr("src", URL.createObjectURL(event.target.files[0]));
        $('.img-responsive1').addClass('img-contain');
        $('.remove-item1[data-name=' + imgId + ']').removeClass('hidden');
        $('.image-button1[data-name=' + imgId + ']').addClass('hidden');
    });
    // click remove icon
    var countDelete = 0; //count number delete.
    $('.remove-item').on('click', function () {
        countDelete++;
        $('#file').val('');
        $('input[name=image_identify]').attr('data-check', 0);
        $('.is-clear-img').val(1);
        let imgId = $(this).data('name');
        if (imgId === 'image_identify') {
            removeImageIdentify = true;
        } else {
            removeImageBusiness = true;
        }
        $('input[name=' + imgId + ']').val(null);
        $('#' + imgId).attr("src", '/assets/img/teacher-page/rectangle.png');
        $('.image-button[data-name=' + imgId + ']').removeClass('hidden');
        $('.img-responsive').removeClass('img-contain');
        $(this).addClass('hidden');
    });
    var countDelete1 = 0; //count number delete.

    $('.remove-item1').on('click', function () {
        countDelete1++;
        $('.file1').val('');
        $('input[name=image_identify1]').attr('data-check', 0);
        $('.is-clear-img').val(1);
        let imgId = $(this).data('name');
        if (imgId === 'image_identify1') {
            removeImageIdentify1 = true;
        } else {
            removeImageBusiness1 = true;
        }
        $('input[name=' + imgId + ']').val(null);
        $('#' + imgId).attr("src", '/assets/img/teacher-page/rectangle.png');
        $('.image-button1[data-name=' + imgId + ']').removeClass('hidden');
        $('.img-responsive1').removeClass('img-contain');
        $(this).addClass('hidden');
    });
    $('#usage_details').on('change', function () {
        console.log(+$(this).val())
        if (+$(this).val() === 2) {
            if (user.image_path_type2 && user.image_path_type2.image_url) {
                $('#business_card').attr("src", user.image_path_type2.image_url);
                $('.image-button[data-name=business_card]').addClass('hidden');
                $('.remove-item[data-name=business_card]').removeClass('hidden');
                $('input[name=qualifications]').filter('[value=' + user.qualifications + ']').prop('checked', true);
            }
            $('input[name=qualifications]').removeAttr('disabled');
            $('#business-submit').removeAttr('disabled');
            $('.image-container[data-name=business_card]').removeClass('disabled');
            $('#teacher_category_consultation').removeClass('d-none');
        } else {
            $('input[name=qualifications]').attr('disabled', true);
            $('input[name=qualifications]').prop('checked', false);
            $('#business-submit').attr('disabled', true);
            $('.image-container[data-name=business_card]').addClass('disabled');
            $('.image-container[data-name=business_card]').find('.remove-item').addClass('hidden');
            $('#business_card').attr("src", '/assets/img/teacher-page/rectangle.png');
            $('.image-button[data-name=business_card]').removeClass('hidden');
            $('#teacher_category_consultation').addClass('d-none');
        }
        if (+$(this).val() === 3) {
            $('#nda-submit').removeAttr('disabled');
            $('#teacher_category_fortunetelling').removeClass('d-none');
        } else {
            $('#nda-submit').attr('disabled', true);
            $('#teacher_category_fortunetelling').addClass('d-none');
        }
    });
    // qualifications
    $('input[name=qualifications]').on('change', function () {
        // $('.error-qualification').each(function () {
        //     if (!$(this).hasClass('d-none')) {
        //         $(this).addClass('d-none');
        //     }
        // })
        if (+$(this).val() === 1) {
            $('#block_choose-image').show();
        } else {
            $('#block_choose-image').hide();
        }
    });
    // $('#noChangeName').on('change', function () {
    //     $('.no-change-input').removeClass('d-none');
    //     $('.change-input').addClass('d-none');
    //     $('.input-surname, .input-given-name').attr('disabled', true);
    // })
    // $('#changeName').on('change', function () {
    //     $('.change-input').removeClass('d-none');
    //     $('.no-change-input').addClass('d-none');
    //     $('.input-surname, .input-given-name').removeAttr('disabled', true);
    //     $('.input-surname, .input-given-name').css('backgroundColor', '#FFFFFF');
    //     $('.input-surname, .input-given-name').css('color', '#2A3242');
    // })

    $('#href-submit').on('click', function () {
        let redirect = $('#href-submit').data('redirect');
        location.href = redirect;
    });

    $('#nda-submit').on('click', function () {
        $.ajax({
            beforeSend: function () {
                $('#loading-overlay').show();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/teacher/register/${userId}/business-verify`,
            type: "POST",
            contentType: false,
            processData: false
        })
            .done(function (res) {
                $('.is_nda').val(1);
                $('.error-nda').empty();
                $('#nda-submit').prop('disabled', true);
                $('#loading-overlay').hide();
                delete user.image_path_type2;
                toastr.success(res.message);
                let redirect = $('#nda-submit').data('redirect');
                location.href = redirect;
            })
            .catch(function (error) {
                $('#loading-overlay').hide();
                toastr.error(error.message);
            })
    });
    /**
     * Ajax upload identification.
     */
    $("#form-identification-submit").submit(function (e) {
        e.preventDefault();
        // if (!$("#changeName").is(':checked')) {
        //     // set the item in localStorage
        //     localStorage.setItem('isChangeName', 1);
        // } else {
        //     // set the item in localStorage
        //     localStorage.setItem('isChangeName', 2);
        // }
        $('#identification_submit').prop('disabled', true);
        $('.text-danger').html('');
        let route = $('#form-identification-submit').data('route');
        let formData = new FormData(this);

        const file1 = +$('input[name=identity_verification_type]').val() === 2 ? false : ($('.file1').attr('data-check') != 1);

        if ($('#file').attr('data-check') != 1 || file1) {
            $('.file-error').html('本人確認画像は、必ず指定してください。');
            $(window).scrollTop($('.file-error').offset().top - 795);
        } else {
            submitIdentificationTwo(formData, route);
        }
    })

    /**
     * submit identification two .
     *
     * @param formData
     */
    function submitIdentificationTwo(formData, route) {
        $.ajax({
            beforeSend: function () {
                $('#loading-overlay').show();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: route,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#loading-overlay').hide();
                if (response.success === true) {
                    let redirect = $('#form-identification-submit').data('redirect');
                    location.href = redirect;
                } else {
                    toastr.error(response.message);
                    $('#identification_submit').prop('disabled', false);
                }

            },
            error: function (response) {
                $('#loading-overlay').hide();
                $.each(response.responseJSON.data.errors, function (field_name, error) {
                    $('.' + error['key'] + '-error').html(error['error']);
                })
                $('#identification_submit').prop('disabled', false);
                $(window).scrollTop(0);
            }
        })
    }

    $("#verification-edit-submit").submit(function (event) {
        let images = $('#image_identify').attr("src");
        let images1 = $('#image_identify1').attr("src");
        let imageBusiness = $('#business_card').attr("src");
        let qualifications = $('input[name=qualifications]:checked', '#credentials-edit').val();
        if (images === "/assets/img/teacher-page/rectangle.png") {
            $('.file-error').text('本人確認画像は、必ず指定してください。');
            event.preventDefault();
        }
        if (images1 === "/assets/img/teacher-page/rectangle.png") {
            $('.file-error').text('本人確認画像は、必ず指定してください。');
            event.preventDefault();
        }
    });
});

