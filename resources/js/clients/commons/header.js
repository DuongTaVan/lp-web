$(document).ready(function () {
    $(".header__notification").hide();
    $('.click-menu-sp').click(function () {
        if (window.innerWidth < 526) {
            $('.header-right').toggleClass('header-right-mobile');
            $('.visible-mobile').show();
            $('.none-mobile').hide();
            $(".layout__hidden").css('display', 'block');
            $('body').css('overflow-y', 'hidden');
            $('body').css('overflow-x', 'hidden');
            $('.header__left').css('padding-left', '0');
            $('.header__left__logo').css('padding-left', '13px');
        }
    });
    activeSidebarRoleTeacher();
    $('.header-right__close').click(function () {
        activeSidebarRoleTeacher();
        $('.header-right').toggleClass('header-right-mobile');
        $(".layout__hidden").css('display', 'none');
        $('.header__left').css('padding-left', '21px');
        $('.header__left__logo').css('padding-left', '0');
        $('body').css('overflow-y', 'auto');
        $('body').css('overflow-x', 'auto');
    });
    $('#student-tab-btn').click(function () {
        $('.header-right__menu__user__icon .rank-icon').css('display', 'none');
    })
    $('#teacher-tab-btn').click(function () {
        $('.header-right__menu__user__icon .rank-icon').css('display', 'block');
    })

    $('body').on('click', '.hours_down', function (e) {
        e.preventDefault();
        $(this).parents('.card__content__info__tt__date').find('.card__content__info__tt__date__click').toggle();
    })

    $('body').click(function () {
        var narrow = $(".hours_down");
        if (!narrow.is(event.target) &&
            !narrow.has(event.target).length) {
            $('.hours_down').parents('.card__content__info__tt__date').find('.card__content__info__tt__date__click').hide();
        }
    });

    $(".layout__hidden").click(function () {
        $(".header-right__close").trigger("click");
        $(this).css('display', 'none');

    });
    $('.btn-search').click(function () {
        $('.header-right-search-sp').toggleClass('header-right-search-sp-hidden')
    })
    $('.icon-remove-mobile').click(function () {
        $('#search-option-header').val('');
    })

    $('.header-right__menu__notification').click(function (event) {
        let bell = document.querySelector('.header-right__menu__notification__icon');
        let icon = `<div class='header__notification__triangle-up'></div>`
        // if (bell != null && typeof bell.children[0] !== 'undefined') {
        //     if (event.target == bell.children[0]) {
        $(".header__notification__list__text").before(icon)
        $(".header__notification").toggle();
        $(".header__notification__list").toggleClass('show-noti');
        // }
        // }
    })

    $('.mobile-noti').click(function () {
        if (window.innerWidth < 526) {
            $(".header__notification").show()
            $('.header-right').toggleClass('header-right-mobile');
            $(".layout__hidden").css('display', 'none');
            $('.header__left').css('padding-left', '21px');
            $('.header__left__logo').css('padding-left', '0');
            $('body').css('overflow-y', 'auto');
            $('body').css('overflow-x', 'auto');
            $(".header__notification__list").toggleClass('show-noti');
        }
    })

    $('.header__notification').click(function () {
        $(".header__notification").toggle();
        $(".header__notification__list").removeClass('show-noti')
    })

    let isTeacher = localStorage.getItem('isTeacher');
    if (isTeacher === null) {
        isTeacher = 0;
    }
    hiddenRoleTeacher(isTeacher)

    /**
     * Check role user.
     * @param isTeacher
     */
    function hiddenRoleTeacher(isTeacher) {
        // isTeacher = 0 ? student : teacher;
        // if (isTeacher == 0) {
        //     $('.header-right__role-teacher').addClass('student-role-mobile-hidden')
        //     $('.teacher-mobile').addClass('teacher-mobile-hidden')
        //     $('.student-mobile').removeClass('student-mobile-hidden')
        // } else {
        //     $('.header-right__role-teacher').removeClass('student-role-mobile-hidden')
        //     $('.student-mobile').addClass('student-mobile-hidden')
        //     $('.teacher-mobile').removeClass('teacher-mobile-hidden')
        // }
    }

    function activeSidebarRoleTeacher() {
        if (localStorage.getItem('isRoleTeacher') == 2) {
            $('.teacher-tab-btn, .student-tab-btn').removeClass('active show');
            $('.teacher-tab-btn').addClass('active show');
        }
    }

    $('body').on('click', '.tab-head-left', function () {
        // set the item in localStorage
        localStorage.setItem('isTeacher', 0);
    })
    $('body').on('click', '.tab-head-right', function () {
        // set the item in localStorage
        localStorage.setItem('isTeacher', 1);
    })
    $('body').on('click', '.text-left', function () {
        // set the item in localStorage
        localStorage.setItem('isTeacher', 0);
    })
    $('body').on('click', '.text-right', function () {
        // set the item in localStorage
        localStorage.setItem('isTeacher', 1);
    })

    $('#view-more').on('click', 'a', function (e) {
        let route = $(this).data('url');
        sendNoticeIds('#noticePopup li', route);
        window.location.href = route;
    });

    function sendNoticeIds($notice, route) {
        let noticeId = [];
        $($notice).each(function () {
            if (this) {
                noticeId.push($(this).data('id'))
            }
        })
        if (noticeId != []) {
            $.ajax({
                method: "GET",
                url: route + `?noticeId=${noticeId}`,
            }).done(function (data) {
                return data;
            });
        }

    }

    $(window).on('resize', function () {
        if ($(window).width() > 415) {
            $('.layout__hidden').css('display', 'none');
        } else {
            if ($('.header-right').hasClass('header-right-mobile')) {
                $('.layout__hidden').css('display', 'block');
            } else {
                $('.layout__hidden').css('display', 'none');
            }
        }
    });

})
