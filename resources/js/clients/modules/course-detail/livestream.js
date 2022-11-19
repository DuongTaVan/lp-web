let activeElm = $('.rectangle.active');

// $('body').on('click', '.rectangle.active', function () {
//     $(this).removeClass('active');
//     $('.rectangle.choose-option').addClass('show');
// });
//
// $('body').on('click', '.rectangle.show', function () {
//     $('.rectangle.choose-option').removeClass('show');
//     $(this).addClass('active');
//     activeElm = $('.rectangle.active');
//     setPrice();
//     const url = $(this).data('url');
//     if (url && window.location.href !== url) {
//         window.location.href = url;
//     }
// });
//
// setPrice();

// select option time course-schedule
$(document).ready(function () {
    // const course_schedule_id = $('.select-course').find('input').val();
    // localStorage.setItem('course_schedule_id', course_schedule_id);
    $('.rectangle').click(function () {
        $('.choose-option-preview').removeClass('select-course');
        $(this).addClass('select-course');
        const elementId = $(this).attr('id');
        const elementHtml = $(`#${elementId}`).clone(true);
        $(this).remove();
        $('.option-list').prepend(elementHtml);
        setPrice(
            $(this).find('#rectangle__price').html(),
            $(this).find('#deadline').html(),
            $(this).find('#number_of_participants').html());
    });
    // $(".choose-option").click(function () {
    //     $('.rectangle').toggleClass('choose-option')
    //     $('.icon-arrow').toggleClass('rotate')
    // });
})

function setPrice() {
    $('.text-bold').html(activeElm.data('price'));
    $('.deadline__result').html(activeElm.data('deadline'));
    $('.number_of_participants__result').html(activeElm.data('number_of_participants'));
}

// check mobile
let isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function setValueScheduleSP(price, date, time, type, deadline) {
    $('.text-bold').html(price);
    $('.rectangle-sp__date').html(date);
    $('.rectangle-sp__time').html(time);
    $('.rectangle-sp__text').html(type);
    $('.deadline__result').html(deadline);
}

if (isMobile.any()) {
    $('.schedule-list').click(function () {
        $('#modal-choose-schedule').modal('hide');
        setValueScheduleSP(
            $(this).find('#schedule-list__price').html(),
            $(this).find('.schedule-list__date').html(),
            $(this).find('.schedule-list__time').html(),
            $(this).find('.schedule-list__text').html(),
            $(this).find('#deadline').html(),
        )
    });
}

setValueScheduleSP(
    $('.rectangle-sp:first-child').find('#schedule-list__price').html(),
    $('.rectangle-sp:first-child').find('.schedule-list__date').html(),
    $('.rectangle-sp:first-child').find('.schedule-list__time').html(),
    $('.rectangle-sp:first-child').find('.schedule-list__text').html(),
    $('.rectangle-sp:first-child').find('#deadline').html(),
)

// hover schedule-option
$('body').on('mouseover', '#option-schedule', function () {
    $('.table-option').show();
    $('.Admission-fee').mouseleave(function () {
        $('.table-option').hide();
    })
});

$('.rank-icon').hover(function () {
    $('.rank-popup').show();
    $('.rank-icon').mouseleave(function () {
        $('.rank-popup').hide();
    })
});

$('#charged-option-app').click(() => {

    $('.Admission-fee-app').hide();
    $('.other-option').show();
});

$('.close-other-option').click(() => {
    $('.Admission-fee-app').show();
    $('.other-option').hide();
});

// ajax pagination
let currenPage = 1;
let lastPage = parseInt($('.lastPage').val());
if (currenPage === lastPage) {
    $('.see-more').hide();
}
$('.see-more').click(function () {
    let course_schedule_id = $('#course_schedule_id').val();
    let page = parseInt($('#currentPage').val()) + 1;
    $.ajax({
        url: window.location.origin + `/course-schedules/${course_schedule_id}/detail/fetch_data?perPage=3&page=${page}`,
        type: "GET"
    }).then(function (res) {
        $('#currentPage').val(res.data.current_page);
        $('.menu-evaluation').append(res.html);
        if (page === res.data.last_page) {
            $('.see-more').hide();
        }
    })
});

// put option extra localstorage
$('body').on('click', '#purchase_procedure', function (e) {
    if ($(this).data('toggle') === 'modal' || $(this).hasClass('bg-disabled')) {
        e.preventDefault();
    }
    let optional_extra_id = [];
    if ($(`.option-extra`).is(':checked')) {
        $.each($(".option-extra:checked"), function () {
            optional_extra_id.push($(this).attr("data-value"))
        });
        localStorage.setItem('optional_extra_id', optional_extra_id);
    }
    if ($("input").is(':checked')) {
        $.each($("input:checked"), function () {
            optional_extra_id.push($(this).attr("data-value"))
        });
        localStorage.setItem('optional_extra_id', optional_extra_id);
    }
});

// read more text body course
// get name browser
function get_browser() {
    var ua = navigator.userAgent, tem,
        M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if (/trident/i.test(M[1])) {
        tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
        return {name: 'IE', version: (tem[1] || '')};
    }
    if (M[1] === 'Chrome') {
        tem = ua.match(/\bOPR|Edge\/(\d+)/)
        if (tem != null) {
            return {name: 'Opera', version: tem[1]};
        }
    }
    M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
    if ((tem = ua.match(/version\/(\d+)/i)) != null) {
        M.splice(1, 1, tem[1]);
    }
    return {
        name: M[0],
        version: M[1]
    };
}

// end name browser
var browser = get_browser()
if (browser.name === 'Safari') {
    if ($('.rectangle-div__about-content').height() > 155) {
        $('.text-content').addClass('text-more');
        $('.read-more__open').show();
    }
} else {
    if ($('.rectangle-div__about-content').height() > 180) {
        $('.text-content').addClass('text-more');
        $('.read-more__open').show();
    }
}

$('.read-more__open').click(function () {
    $('.text-content').toggleClass('text-more');
    $('.read-more__close').show();
    $('.read-more__open').hide();
})

$('.read-more__close').click(function () {
    $('.read-more__close').hide();
    $('.read-more__open').show();
    $('.text-content').toggleClass('text-more');
    let targetEle = document.getElementById('rectangle-div');
    let pos = targetEle.style.position;
    let top = targetEle.style.top;
    targetEle.style.position = "relative";
    targetEle.style.top = "-180px";
    targetEle.scrollIntoView({behavior: "smooth", block: "start"});
    targetEle.style.top = top;
    targetEle.style.position = pos;
})

// read more catchphrase teacher
// if ($('.check-height').height() <= 126) {
//     $('.see-all').hide();
// }

$('.see-all').click(function () {
    $('.seller-profile__footer__catchphrase').toggleClass('text-more');
    // $('span').toggleClass('show-more');
    $('.arrow-down').toggleClass('arrow-up');
    $('.see-all').hide();
    $('.compact-text').show();
});

$('.compact-text').click(function () {
    $('.compact-text').hide();
    $('.see-all').show();
    $('.seller-profile__footer__catchphrase').toggleClass('text-more');
    $('.arrow-down').toggleClass('arrow-up');
    let targetEle = document.getElementById('course-detail');
    let pos = targetEle.style.position;
    let top = targetEle.style.top;
    targetEle.style.position = "relative";
    targetEle.style.top = "-170px";
    targetEle.scrollIntoView({behavior: "smooth", block: "start"});
    targetEle.style.top = top;
    targetEle.style.position = pos;
})
