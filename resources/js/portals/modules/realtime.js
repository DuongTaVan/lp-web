const { io } = require("socket.io-client");
const host = `${process.env.MIX_SOCKET_DOMAIN}:${process.env.MIX_SOCKET_PORT}`;
let socket = io(host, { transports: ["websocket"] });
const elmIdentity = $('.identity-count');
const elmBusiness = $('.business-count');
const elmCourse = $('.course-count');
const elmTransfer = $('.transfer-count');
const apiIdentity = '/portal/identity/detail/';
const apiCountIdentity = '/portal/identity/count';
const apiBusiness = '/portal/business/detail/';
const apiCountBusiness = '/portal/business/count';
const apiTransfer = '/portal/transfer-histories/detail/';
const apiCountTransfer = '/portal/transfer-histories/count';
const apiCourseCount = '/portal/courses/count';
const apiSchedule = function(id) {
    return `/course-schedules/${id}/get-new-buyer`;
};
const apiCourse = '/portal/courses/';
const elementEmail = $('.sidebar__count.email');

socket.on("connect", () => {
    setTimeout(function () {
        socket.emit('verify');
    }, 100);
    console.log(socket.id);
});

socket.on('message', function (data) {
    const newEvent = JSON.parse(data);
    handleScreen(newEvent);
});

socket.on('new-email-unseen', (data) => {
    if (data) {
        const countEmail = data.unseen;
        if (+countEmail) {
            elementEmail.removeClass('dp-none');
        } else if (!elementEmail.hasClass('dp-none')) {
            elementEmail.addClass('dp-none');
        }
        elementEmail.html(countEmail);
    }
});

const handleScreen = function (data) {
    if (window.location.pathname.includes(data.url)) {
        fetchNewData(data);
    }

    if (!data.no_count) {
        fetchCountMenu(data.screen);
    }
}

const fetchCountMenu = function (screen) {
    switch (screen) {
        case 'TRANSFER':
            fetchCountTransfer();
            // elmTransfer.html(+elmTransfer.html() + 1);
            break;
        case 'COURSE':
            fetchCountCourseNotApprove();
            break;
        case 'IDENTITY':
            fetchCountIdentity();
            break;
        case 'BUSINESS':
            fetchCountBusiness();
            break;
        default:
            break;
    }
}

const fetchCountTransfer = function () {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiCountTransfer,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success) {
            if (response.count) {
                elmTransfer.removeClass('dp-none');
                elmTransfer.html(response.count);
            } else {
                elmTransfer.addClass('dp-none');
                elmTransfer.html(0);
            }
            if (window.location.pathname.includes('/portal/transfer-histories')) {
                if (response.errorBalance) {
                    $('.transfer-error').removeClass('d-none');
                } else {
                    $('.transfer-error').addClass('d-none');
                }
            }
        }
    });
}

const fetchCountIdentity = function () {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiCountIdentity,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success) {
            if (response.count) {
                elmIdentity.removeClass('dp-none');
                elmIdentity.html(response.count);
            } else {
                elmIdentity.addClass('dp-none');
                elmIdentity.html(0);
            }
        }
    });
}

const fetchCountBusiness = function () {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiCountBusiness,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success) {
            if (response.count) {
                elmBusiness.removeClass('dp-none');
                elmBusiness.html(response.count);
            } else {
                elmBusiness.addClass('dp-none');
                elmBusiness.html(0);
            }
        }
    });
}

const fetchNewData = function (data) {
    if ($(`.content-table-data tr[id=${data.id}]`)) {
        data.is_update = true;
    }
    switch (data.screen) {
        case 'TRANSFER':
            fetchNewDataTransfer(data.id, data.is_update ?? false);
            break;
        case 'COURSE':
            fetchNewDataCourse(data.id, data.is_update ?? false);
            break;
        case 'IDENTITY':
            fetchNewIdentity(data.id, data.is_update ?? false);
            break;
        case 'BUSINESS':
            fetchNewBusiness(data.id, data.is_update ?? false);
            break;
        case 'SCHEDULE_DETAIL':
            fetchNewSchedule(data.id);
            break;
        default:
            break;
    }
}

const fetchNewDataTransfer = function (id, isUpdate) {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiTransfer + id,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success && response.html) {
            createElement(response.html, id, isUpdate);
            // elmTransfer.html(+elmTransfer.html() + 1);
        }
    });
}

const fetchNewDataCourse = function (id, isUpdate) {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiCourse + id,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success && response.html) {
            createElement(response.html, id, isUpdate);
        }
    });
}

const fetchNewIdentity = function (id, isUpdate) {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiIdentity + id,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success && response.html) {
            createElement(response.html, id, isUpdate);
        }
    });
}

const fetchNewBusiness = function (id, isUpdate) {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiBusiness + id,
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success) {
            if (response.html) {
                createElement(response.html, id, isUpdate);
            } else {
                elmBusiness.html(+elmBusiness.html() - 1);
                $(`.content-table-data tr[id=${id}]`).remove();
                const dataFooter = $('.table__footer__text');
                dataFooter.html(+dataFooter.html().split(' 件中')[0] - 1 + ' 件中' + dataFooter.html().split(' 件中')[1]);
            }
        }
    });
}

const createElement = function (data, id = null, isUpdate = false) {
    if (isUpdate) {
        $(`.content-table-data tr[id=${id}]`).remove();
    } else {
        const dataFooter = $('.table__footer__text');
        dataFooter.html(+dataFooter.html().split(' 件中')[0] + 1 + ' 件中' + dataFooter.html().split(' 件中')[1]);
        $('.content-table-data tr').last().remove();
    }
    $('.pl-5').remove();
    $('.content-table-data').prepend(data);
}

// detail schedule
const fetchNewSchedule = function (id) {
    $.ajax({
        beforeSend: function () {
            $('#loading-overlay').show();
        },
        type: 'GET',
        url: apiSchedule(id),
    }).then((response) => {
        $('#loading-overlay').hide();
        if (response.success) {
            $('.number_of_participants__result').html(response.count + '人')
        }
    });
}

const fetchCountCourseNotApprove = function () {
  $.ajax({
    beforeSend: function () {
      $('#loading-overlay').show();
    },
    type: 'GET',
    url: apiCourseCount,
  }).then((response) => {
    $('#loading-overlay').hide();
    if (response.success) {
      if (response.count) {
        elmCourse.removeClass('dp-none');
        elmCourse.html(response.count);
      } else {
        elmCourse.addClass('dp-none');
        elmCourse.html(0);
      }
    }
  });
}
