$(document).ready(function () {
    $('.armorial-icon').hover(function () {
        $('.rank-popup-teacher').show();
        $('.armorial-icon').mouseleave(function () {
            $('.rank-popup-teacher').hide();
        })
    });
});

$(function () {
    $('.service-detail').hide();
    $(".service-detail").slice(0, 4).show();
    $('body').on('click', '#load', function (e) {
        e.preventDefault();
        let page = parseInt($(this).attr('data-pageCourse')) + 1;
        let route = $('#service-detail').data('url');
        ajaxLoadMore('#load', '#service-detail', 'data-pagecourse', page, route, '.see_more_course')
    });


});
/**
 * load more reviews
 */
$(function () {
    let reviewElement = document.getElementById('review');
    let review = document.querySelector('.review-outline');
    if (reviewElement.contains(review)) {
        $('.review-outline').hide();
        $(".review-outline").slice(0, 4).show();
        $('body').on('click', '#loadMore', function (e) {
            e.preventDefault();
            let page = parseInt($(this).attr('data-page')) + 1;
            let route = $('#list-review').data('url');
            ajaxLoadMore('#loadMore', '#list-review', 'data-page', page, route, '.see-more')

        });
    } else {
        $("#loadMore").hide();
    }

    function countLines() {
        // Get element with 'content' as id
        const el = document.querySelector(".content-home-top .text-top");

        // Get total height of the content
        const divHeight = el.offsetHeight;


        // object.style.lineHeight, returns

        const lineHeight = parseInt(el.style.lineHeight);

        const lines = divHeight / lineHeight;
        if (lines <= 5) {
            $('.read-more').hide();
        }
    }

    countLines();
    let textHeight = $('.content-home-top__ct__text').height();
    if (textHeight > 60) {
        $('.read-more').show();
    }
    $(".content-home-top .button").click(function () {

        $('.content-home-top .arrow-down').toggleClass('arrow-down-top');
        $('.content-home-top__ct__text').toggleClass('text-top');
        let text = $(this).html();
        if (text == 'もっと見る') {
            $(this).html('折りたたむ');
        } else {
            $(this).html('もっと見る');
        }
        // $('html,body').animate({
        //     scrollTop: $('.content-home-top .button').offset().top
        // }, 1500);
    });
});

/**
 * Get data append DOM.
 *
 * @param idClick
 * @param idAppend
 * @param dataPage
 * @param numberPage
 * @param url
 */
function ajaxLoadMore(idClick, idAppend, dataPage, numberPage, url, classHidden) {
    let page = numberPage;
    let route = url;
    $.ajax({
        beforeSend: function beforeSend() {
            $('#loading-overlay').show();
        },
        url: route + `?page=${page}`,
        type: "GET"
    }).then(function (res) {
        $('#loading-overlay').hide();
        $(idClick).attr(dataPage, page);
        let lastPage = $(classHidden).data('lastpage');
        if (page == lastPage) {
            $(classHidden).css('display', 'none');
        }

        $(idAppend).last().append(res.html);
        // $('html,body').animate({
        //     scrollTop: $(idClick).offset().top
        // }, 1500);
    })
}

$(function () {
    $('body').on('click', '.content_date_click', function (e) {
        let date = $(this).children()[0];
        let time = $(this).children()[1];
        let $this = $(this);
        if (e.currentTarget.parentElement.parentElement.querySelector(".time_hours")) {
            e.currentTarget.parentElement.parentElement.querySelector(".time_hours").innerHTML = time.textContent.trim();
        }
        if (e.currentTarget.parentElement.parentElement.parentElement.querySelector(".course-date")) {
            e.currentTarget.parentElement.parentElement.parentElement.querySelector(".course-date").innerHTML = date.textContent.trim();
        }
        let id = $(this).data('id');
        let courseId = $(this).data('course-id');
        let img = $(this).parent().data('img');
        let href = '/course-schedules/' + id + '/detail';
        $('.img-course' + img).attr("href", href);
        $('.title-course' + img).attr("href", href);
        let route = '/course-schedules/' + id + '/detail-status';
        $.ajax({
            url: route,
            type: "GET"
        }).then(function (res) {
            $this.closest(".card__content__info__tt__date").find('.bg-text-' + courseId).html(res.status);
            $this.closest(".card__content__info__tt__date").find('.title-course-schedule-' + courseId).html(res.title);
            $this.closest(".card__content__info__tt__date").find('.service-paragraph-' + courseId).html(res.body);
            $('.cs-img-' + courseId).attr('src', res.image_url);
            $('.money-value-' + courseId).html('¥' + res.price);
        })
    });
});


