/* lappi slider v2,, @license Anhnt_FABBI */
jQuery.fn.lappiSlider = function(options = {
    btnNext: false,
    btnPrev: false,
    loop: false
}) {
    const element = jQuery(this);
    const elementNext = options.btnNext ? jQuery(`.${options.btnNext}`) : null;
    const elementPrev = options.btnPrev ? jQuery(`.${options.btnPrev}`) : null;
    const realWidthItem = element.find('.lappi-slider .card').outerWidth(true);
    const maxWidth = element.find('.lappi-slider').width() - element.width();
    const maxItem = element.find('.lappi-slider .card').length;
    let currentPosition = 0;
    disableButton();

    if (elementPrev) {
        elementPrev.click(function() {
            if (!options.loop) {
                if (currentPosition <= 0) return;
            }

            if (currentPosition > 0) {
                currentPosition -= realWidthItem;
            } else {
                currentPosition = maxWidth;
            }
            element.animate({scrollLeft: currentPosition}, 100);
            disableButton();
        })
    }
    if (elementNext) {
        elementNext.click(function () {
            if (!options.loop) {
                if (currentPosition >= maxWidth) return;
            }

            if (currentPosition < maxWidth) {
                currentPosition += realWidthItem;
            } else {
                currentPosition = 0;
            }
            element.animate({scrollLeft: currentPosition}, 100);
            disableButton();
        })
    }

    function disableButton() {
        if (elementPrev && !options.loop) {
            if (currentPosition <= 0) {
                elementPrev.addClass('disabled');
            } else {
                elementPrev.removeClass('disabled');
            }
        }
        if (elementNext && !options.loop) {
            if (currentPosition >= maxWidth) {
                elementNext.addClass('disabled');
            } else {
                elementNext.removeClass('disabled');
            }
        }
    }
};
