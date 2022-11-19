$(function () {
    $('.notice-paragraph').hide();
    $(".notice-paragraph").slice(0, 6).show();
    $('body').on('click', '#load', function (e) {
        e.preventDefault();
        let page = parseInt($(this).attr('data-pageCourse')) + 1;
        let route = document.URL;
        // ajaxLoadMore('#load', '#notice-paragraph', 'data-pagecourse', page, route, '.see_more_noti')
        $(".notice-paragraph:hidden").slice(0, 6).slideDown();
        if ($(".notice-paragraph:hidden").length == 0) {
            $("#load").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});


$(document).ready(() => {
    updateNoticeReadBox();
});

/**
 * Update notice read box
 */
function updateNoticeReadBox() {
    let url = '/teacher/notice/update-read-box';
    $.ajax({
        url: url,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
}

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
        url: route + `?page=${page}`,
        type: "GET"
    }).then(function (res) {
        $(idClick).attr(dataPage, page);
        let lastPage = $(classHidden).data('lastpage');
        if (page == lastPage) {
            $(classHidden).css('display', 'none');
        }

        $(idAppend).last().append(res.html);
        $('html,body').animate({
            scrollTop: $(idClick).offset().top
        }, 1500);
    }).catch(function () {

    });
}
