import "./commons/header"
import "./commons/alert";
import "./orders/edit-order";
import "../portals/modules/home-swiper";
import "./commons/view-order";
import "./dashboard/dashboard";
import "./student-livestream/swiper-slider-gift";
import "./commons/dropdown_video_call";
import "./commons/sidebar-left"
import "./commons/button-social"

$("form").submit(function () {
    if ($(this).valid() && !$(this).hasClass('form-disable-multiple-click')) {
        $(this).find(":submit").addClass('btn-disabled');
        setTimeout(() => {
            $(this).find(":submit").removeClass('btn-disabled');
        }, 2000);
    }
});

$("form.form-disable-multiple-click").submit(function () {
    $(this).find("button[type=submit]").addClass('btn-disabled');
})
