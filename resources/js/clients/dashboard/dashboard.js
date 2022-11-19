$(document).ready(function () {
    $(".messages-course-purchase .message-menu .item").on("click", function (e) {
        if ($(this).hasClass('item-link')) return;
        $(".messages-course-purchase .message-menu").find(".active").removeClass("active");
        $(this).addClass("active");
    });

    $('.block  .block-content  a').html(function (i, v) {
        return v.replace(/(\d)/g, '<span class="number">$1</span>');
    });
})
