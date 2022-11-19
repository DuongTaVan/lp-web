$(document).ready(function () {
    var count = 0;
    var cpRating = 0;
    var i = 1;
    $('.fa-star-half:not(.disabled)').click(function () {
        // let i;
        let currentRating = $(this).attr('data-rate');
        count++;
        if (count === 1) {
            i = currentRating * 2 - 1;
            cpRating = currentRating;
        } else if (count === 2 && cpRating === currentRating) {
            i = currentRating * 2;
            count = 3;
        } else if (cpRating > currentRating) {
            cpRating = currentRating;
            i = currentRating * 2;
            count = 3;
        } else {
            count = 1;
            cpRating = currentRating;
            i = currentRating * 2 - 1;
        }
        $('.fa-star-half').removeClass('active');
        $('.fa-star-half').each(function (key, value) {
            if (key + 1 <= i) {
                $(this).addClass('active')
            }
        })
    })
    $('body').on('click', '.order-view__content__course-submit__btn-post', function (e) {
        e.preventDefault()
        $('.error').html('');
        let route = $('#updateReviewCourse').data('url');
        let rating = i;
        let comment = $('#w3review').val();
        let profile = $('#profile').is(':checked');
        let courseScheduleId = $('#updateReviewCourse').data('id');
        let urlRedirect = $(this).data('url');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: route,
            data: {rating: rating, comment: comment, profile: profile, course_schedule_id: courseScheduleId},
            success: function success(response) {
                if (response.status === true) {
                    // $('#modal-content-custom').html(response.html);
                    toastr.info(response.message).css({"width": "486px", "height": "78px"});
                    window.location.href = urlRedirect;
                    // $('.order-view__content__course-submit__btn-post__success').trigger('click');
                } else {
                    toastr.error(response.message).css({"width": "486px", "height": "78px"});
                }
            },
            error: function error(response) {
                $.each(response.responseJSON.data.errors, function (field_name, error) {
                    $('.error').html(error['error']);
                });
            }
        });
    })
    $('body').on('click', '.popup-course-review__content__close-course-review', function () {
        //redirect to review screen.
        let redirect = $('#closeReview').attr('href');
        location.href = redirect;
    })
})
