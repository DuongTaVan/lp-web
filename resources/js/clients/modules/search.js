const allOptions = $('.sort_search').children('li');
const listSortElm = $('.sidebar-right__header__option__list-options');
let windowSize = $(window).width();
const body = $('body');

// let url = new URL(window.location.href);
// let searchParams = url.searchParams;
//
// $('.dropdown-search').on("click", ".dropdown-title", function () {
//     $(this).find("ul").children('li').toggle();
// });
$('.sort-search').on("click", 'li', function () {
    allOptions.removeClass('selected');
    $(this).addClass('selected');
    $('.dropdown-title').html($(this).text());
    let sort = $(this).val();
    listSortElm.toggle();

    const currentUrl = new URL(window.location.href);
    currentUrl.pathname = '/search';
    currentUrl.searchParams.set('sort', sort);
    window.location.href = currentUrl.toString();
});
//
// function formatUrl(searchParams, params = []) {
//     let newSearchParams = "?";
//     searchParams.forEach((item, index) => {
//         if (item && !params.includes(index) && !newSearchParams.includes(index)) {
//             newSearchParams += index + "=" + encodeURIComponent(item) + "&";
//         }
//     });
//     return newSearchParams;
// }

$(".main__hidden").click(function () {
    $("#close_option").trigger("click");
});

$("#close_option").click(function () {
    $('.sidebar-right__header__option__list-options').toggle();
    $(".main__hidden").css('display', 'none');
    body.css('overflow-y', 'auto');
    body.css('overflow-x', 'auto');
});

$("#recommend_order").click(function () {
    listSortElm.toggle();
    windowSize = $(window).width();

    $(window).resize(function () {
        windowSize = $(window).width();
    });

    if (windowSize <= 440) {
        // If the window is greater than 440px wide then hidden OY and OX
        $(".main__hidden").css('display', 'block');
        body.css('overflow-y', 'hidden');
        body.css('overflow-x', 'hidden');
    }
});
