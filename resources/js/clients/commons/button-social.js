$(document).ready(function () {

    customBtnShareSocial('btn-facebook-custom', 'st-first');
    customBtnShareSocial('btn-twitter-custom', 'st-btn:nth-child(2)');
    customBtnShareSocial('btn-line-custom', 'st-last');

    /**
     * Custom button share social
     *
     * @param classClick
     * @param classTrigger
     */
    function customBtnShareSocial(classClick, classTrigger) {
        $('.' + classClick).click(function (e) {
            e.preventDefault();
            $('.custom-social-button .' + classTrigger).trigger('click');
        })
    }
})