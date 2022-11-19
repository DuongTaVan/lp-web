const searchFormElm = $('#search-form');

searchFormElm.keyup(function (event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        // document.querySelector('form');
        common();
    }
});

$('.header__left__search').on('click', '.btn-search', function () {
    common();
});

function common() {
    let keyword = searchFormElm.val().trim();
    let keyPath = `?keyword=${encodeURIComponent(keyword)}`;
    if ((keyword === '' || keyword == null) && hasWhiteSpace(keyword)) {
        window.location = '/' + keyPath;
    } else {
        window.location = '/search' + keyPath;
    }
}

function hasWhiteSpace(s) {
    return s.indexOf(' ') >= 0;
}

// $(function () {
//     const url = window.location.pathname,
//         urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
//     const domain = $(location).attr('pathname');
//
//     $('.header-right__menu__mobile a').each(function () {
//         let tab = $(this).data('value');
//         if (domain === '/') {
//             $(this).children(".header-right__menu__mobile__parent").removeClass('active');
//         } else if (urlRegExp.test(this.href.replace(/\/$/, '')) || urlRegExp.test(tab)) {
//             //$(this).parent().addClass('active');
//             $(this).children(".header-right__menu__mobile__parent").addClass('active');
//         }
//     });
//  });

const $menuContainer = $('.header-right');
const $menuItem = $('.header-right__menu__mobile');

function resizeMenu() {
    window.onload = function () {
        onResize();
    };
    window.addEventListener('resize', onResize);

    function onResize() {
        const $changeRoleBtn = $('.header-right__change-role');
        const $menuUser = $('.header-right__menu__user');
        const changeRoleHeight = $changeRoleBtn.height();
        const menuUserHeight = $menuUser.height();
        if (window.innerWidth <= 414) {
            $menuContainer.css({height: `${window.innerHeight}px`})
            if ($('.header-right__change-role').length) {
                $menuItem.css({height: `${window.innerHeight - changeRoleHeight - menuUserHeight - 90}px `})
            } else {
                $menuItem.css({height: `${window.innerHeight - menuUserHeight - 60}px `})
            }
        } else {
            $menuContainer.css({height: ``})
        }
    }
}

resizeMenu();

$(document).ready(function () {
    $('#logout').click(function () {
        localStorage.removeItem('isTeacher')
    })

    $('body').on('click', '#header__left__logo', function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        window.location.href = url;
    })

    $('body').on('click', '#flex-column-become', function (e) {
        e.preventDefault();
        let urlBecome = $(this).data('url');
        window.location.href = urlBecome;
    })
    $('body').on('click', '#flex-column-user-guide', function (e) {
        e.preventDefault();
        let urlUserGuide = $(this).data('url');
        window.location.href = urlUserGuide;
    })
})

function changeTabImg(e) {
    $('.change-tab-img').removeClass('show active');
    $(`#${e}`).addClass('show active');
}
