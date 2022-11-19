let body = $('body');
let url = new URL(window.location.href);
let searchParams = url.searchParams;
const tbl = $(".sidebar-left__calendar-today__core__day__number1");
const toolBar = $('.sidebar-left__calendar-today__core__header__date');
const toolBarNext = $('#calendar-next');
const toolBarPre = $('#calendar-previous');

$(".card__content__info__tt__date .hours_down").click(function () {
    let windowsize = $(window).width();
    if (windowsize <= 440) {
        body.css('overflow-y', 'hidden');
        body.css('overflow-x', 'hidden');
    }
})
$(".card__content__info__tt__date .card__content__info__tt__date__click--custom ").click(function () {
    body.css('overflow-y', 'auto');
    body.css('overflow-x', 'auto');
})

// Type = 1 (morning); type = 2 (afternoon); type = 3 (night)
calendarOption(2, 'calendar__afternoon', 'calendar__morning', 'calendar__dinner');

calendarOption(3, 'calendar__dinner', 'calendar__morning', 'calendar__afternoon');

calendarOption(1, 'calendar__morning', 'calendar__afternoon', 'calendar__dinner');

toolBarNext.click(function () {
    tbl.empty();
    next();
});

toolBarPre.click(function () {
    tbl.empty();
    previous();
});

// Calendar
let urlCheck = new URL(location.href);
let startDateCurrent = urlCheck.searchParams.get("start_date");
var today = new Date();
today.setHours(today.getHours() + 2);
if (startDateCurrent == null) {
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
} else {
    var currentMonth = new Date(startDateCurrent.replace(/-/g, "/")).getMonth();
    var currentYear = new Date(startDateCurrent.replace(/-/g, "/")).getFullYear();
}
// Get parameter in url .
let getUrlParameter = function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

// // Get start date in param.
// let startDateParam = getUrlParameter('start_date');
// // Check isset param start date time in url .
// if (startDateParam != false) {
//     // Split start date time to array .
//     let dataMonthParam = startDateParam.split("-");
//     currentMonth = parseInt(dataMonthParam[1]) - 1;
// }


// Append
toolBar.html(currentMonth + 1 + ' 月 / ' + currentYear + ' 年');

// Get current date
let getDate = today.getDate();

today.getMinutes();

today.getHours();

today.getSeconds();
// Get month current.
let monthCurrentDay = today.getMonth();
// Get year current.
let yearCurrentDay = today.getFullYear();

let monthConvert = monthCurrentDay + 1;
let yearConvert = yearCurrentDay;
if (monthConvert < 10) {
    monthConvert = '0' + monthConvert;
}

const route = 'home/get-course-schedules-in-day';
const keyword = searchParams.get('keyword') ?? null;
const sort = searchParams.get('sort') ?? null;
const type = searchParams.get('time_frame') ?? null;
const categoryId = searchParams.get('category_id') ?? null;
const categoryType = searchParams.get('category_type') ?? null;
let startDate = searchParams.get('start_date') ?? null;
const endDate = searchParams.get('end_date') ?? null;

getCalendarInDays(type);

/**
 * Show calendar.
 *
 * @param month
 * @param year
 * @param listDay
 */
function showCalendar(month, year, listDay) {
    toolBarNext.attr("data-listday", listDay);
    toolBarPre.attr("data-listday", listDay);

    let urlCheck = new URL(location.href);
    let time_frame = urlCheck.searchParams.get("time_frame");
    if (time_frame == 3) {
        let listDayBeforFormat = listDay;

        function maxminDate(date) {
            var maxmin = [];
            let day = new Date(date.replace(/-/g, "/")).getDate();
            let mon = new Date(date.replace(/-/g, "/")).getMonth() + 1;
            let year = new Date(date.replace(/-/g, "/")).getFullYear();
            let h = new Date(date.replace(/-/g, "/")).getHours();
            let m = new Date(date.replace(/-/g, "/")).getMinutes()
            let s = new Date(date.replace(/-/g, "/")).getSeconds();
            let newA = `${year}-${mon}-${day} 00:00:00`;
            let newB = `${year}-${mon}-${day} 08:00:00`;
            maxmin.push(newA);
            maxmin.push(newB);
            return maxmin;
        }

        function formatDate(date) {
            let day = new Date(date).getDate();
            let mon = new Date(date).getMonth() + 1;
            let year = new Date(date).getFullYear();
            let h = new Date(date).getHours() < 10 ? '0' + new Date(date).getHours() : new Date(date).getHours();
            let m = new Date(date).getMinutes() < 10 ? '0' + new Date(date).getMinutes() : new Date(date).getMinutes();
            let s = new Date(date).getSeconds() < 10 ? '0' + new Date(date).getSeconds() : new Date(date).getSeconds();
            return `${year}-${mon}-${day} ${h}:${m}:${s}`;
        }

        for (let i = 0; i < listDayBeforFormat.length; i++) {
            let newArr = maxminDate(listDayBeforFormat[i]);
            const oldValue = listDayBeforFormat[i];
            if (new Date(listDayBeforFormat[i].replace(/-/g, "/")).getTime() >= new Date(newArr[0].replace(/-/g, "/")).getTime() && new Date(listDayBeforFormat[i].replace(/-/g, "/")).getTime() < new Date(newArr[1].replace(/-/g, "/")).getTime()) {
                listDayBeforFormat[i] = formatDate(new Date(oldValue.replace(/-/g, "/")).setDate(new Date(formatDate(oldValue)).getDate() - 1));
            } else {
                listDayBeforFormat[i] = oldValue;
            }
        }
        listDay = listDayBeforFormat;
    }
    let listDayAfterFormat = [];

    listDay.forEach(element => {
        let day = new Date(element.replace(/-/g, "/")).getDate() < 10 ? '0' + new Date(element.replace(/-/g, "/")).getDate() : new Date(element.replace(/-/g, "/")).getDate();
        let mon = (new Date(element.replace(/-/g, "/")).getMonth() + 1) < 10 ? '0' + (new Date(element.replace(/-/g, "/")).getMonth() + 1) : (new Date(element.replace(/-/g, "/")).getMonth() + 1);
        let year = new Date(element.replace(/-/g, "/")).getFullYear();
        listDayAfterFormat.push(`${year}-${mon}-${day}`);
    });
    listDay = listDayAfterFormat;


    //Get ordinal number of the week.
    let firstDay = (new Date(year, month)).getDay();
    // Creating all cells
    let date = 1;
    // Number of days of the week
    for (let i = 0; i < 6; i++) {
        let row = `<ul class="sidebar-left__calendar-today__core__day__number">`
        let cell = '';
        let temp = 0;
        // Days in the week current
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                cell += '<li></li>';
            } else if (date > daysInMonth(month, year)) {
                // Day in the week < 7
                if (temp < 7) {
                    for (let z = 0; z < 7 - temp; z++) {
                        cell += '<li></li>';
                    }
                }
                break;
            } else {
                const currentDate = year + '-' + (month + 1 < 10 ? ('0' + (month + 1)) : month + 1) + '-' + (date <= 9 ? '0' + date : date);
                const newDate = new Date();
                // newDate.setHours(newDate.getHours() + 2);
                // newDate.setDate(newDate.getDate() - 1);
                const newDateCurrent = new Date(currentDate.replace(/-/g, "/"));
                newDateCurrent.setHours(newDateCurrent.getHours() + 2);
                let h = newDate.getHours();
                let m = newDate.getMinutes();
                let s = newDate.getSeconds();
                newDateCurrent.setHours(h);
                newDateCurrent.setMinutes(m);
                newDateCurrent.setSeconds(s + 1);
                if (newDateCurrent < newDate) {
                    cell += `<li class="day-hidden f-w6">` + date + `</li>`;
                } else if ($.inArray(currentDate, listDay) !== -1) {
                    cell += `<li class="f-w6 day-active">
                            <a href="javascript:void(0)" class="course-date" data-date="` + date + `">` + date + `</a></li>`;
                } else {
                    cell += `<li class="day-hidden f-w6">` + date + `</li>`;
                }

                date++;
            }
            temp++;
        }
        row += cell;
        row += '</ul>';
        tbl.append(row);
    }
    $('.course-date').click(function () {
        let date = $(this).data('date');
        const startDate = `${currentYear}-${(currentMonth + 1 < 10 ? ('0' + (currentMonth + 1)) : currentMonth + 1)}-${(date < 10 ? ('0' + date) : date)}`;
        // get time frame of course schedules.
        let elementActive = document.querySelectorAll('.nopadding > div.active');
        let time_frame = typeof (elementActive[0]) != 'undefined' && elementActive[0] != null ? elementActive[0].getAttribute('data-value') : 0;
        const currentUrl = new URL(window.location.href);
        currentUrl.pathname = '/search';
        currentUrl.searchParams.set('start_date', startDate);
        currentUrl.searchParams.set('page', 1);

        if (time_frame === 0) {
            window.location.href = currentUrl.toString();
            currentUrl.searchParams.set('page', 1);
        } else {
            currentUrl.searchParams.set('time_frame', time_frame);
            window.location.href = currentUrl.toString();
            currentUrl.searchParams.set('page', 1);
        }
        // let url = new URL(location.href);
        // let startDateCurrent = url.searchParams.get("start_date");
        // let monthCurrent = new Date(startDateCurrent).getMonth();
        // monthCurrent = monthCurrent + 1;
        // let yearCurrent = new Date(startDateCurrent).getFullYear();
        // let dataListDay = toolBarNext.attr("data-listday").split(",");
        // showCalendar(monthCurrent, yearCurrent, dataListDay)

    })
}

$('.sidebar-left__clear').click(function () {
    window.location.href = '/';
});

/**
 * Get day in month.
 *
 * @param iMonth
 * @param iYear
 * @returns {number}
 */
function daysInMonth(iMonth, iYear) {
    return 32 - new Date(iYear, iMonth, 32).getDate();
}

/**
 * Next
 *
 */
function next() {
    let dataListDay = toolBarNext.attr("data-listday").split(",");
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    toolBar.html(currentMonth + 1 + ' 月 / ' + currentYear + ' 年');
    console.log(dataListDay);
    showCalendar(currentMonth, currentYear, dataListDay);
}

/**
 * Previous
 *
 */
function previous() {
    let dataListDay = toolBarPre.attr("data-listday").split(",");
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    toolBar.html(currentMonth + 1 + ' 月 / ' + currentYear + ' 年');
    showCalendar(currentMonth, currentYear, dataListDay);
}

/**
 * Get calendar option.
 *
 * @param type
 * @param classClick
 * @param classNameOne
 * @param classNameTwo
 */
function calendarOption(type, classClick, classNameOne, classNameTwo) {
    $('.' + classClick).click(function () {
        $(this).addClass('active');
        $('.' + classNameOne).removeClass('active');
        $('.' + classNameTwo).removeClass('active');
        if (type === 2) {
            $('.calendar__dinner').css('border', '0');
            $('.calendar__morning').css('border', '0');
        }
        if (type === 1) {
            $('.calendar__dinner').css('border-left', '0.697675px solid #E0E0E0');
        }
        if (type === 3) {
            $('.calendar__morning').css('border-right', '0.697675px solid #E0E0E0');
        }
        const currentUrl = new URL(window.location.href);
        currentUrl.pathname = '/search';
        currentUrl.searchParams.delete('start_date');
        currentUrl.searchParams.set('time_frame', type);
        currentUrl.searchParams.set('page', 1);

        window.location.href = currentUrl.toString();
    });
}

/**
 * Get calendar in Day.
 *
 * @param type
 */
function getCalendarInDays(type) {
    $.ajax({
        beforeSend: function () {
            $('.lds-ellipsis').show();
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: route,
        data: {
            'time_frame': type,
            'keyword': keyword,
            'category_id': categoryId,
            'category_type': categoryType,
            'sort': sort,
            'start_date': startDate,
        }
    })
        .done(function (msg) {
            setTimeout(function () {
                $('.lds-ellipsis').hide();
            }, 300);
            tbl.empty();
            showCalendar(currentMonth, currentYear, msg.data);
        });
}

$('#calendar-dropdown').click(() => {
    let iconCalendar = $('.calendar-icon-dropdown');
    let calendar = $('.sidebar-left__calendar-today__core__content');
    iconCalendar.toggleClass('transform-icon');
    iconCalendar.hasClass('transform-icon') ? calendar.slideDown() : calendar.slideUp();
});

$('#category-livestream').click(function () {
    $('#list-search').toggle('slow')
    $('#category-livestream').toggleClass('arrow-down')
});

$('#category-video').click(function () {
    $('#list-search-ul-consult').toggle('slow')
    $('#category-video').toggleClass('arrow-down')
});

$('#category-fortune').click(function () {
    $('#list-search-ul-fortunetelling').toggle('slow')
    $('#category-fortune').toggleClass('arrow-down')
});

let textCustom = $('.custom-text').text();
$('.custom-text').html(textCustom.replace("(留学、移住、転職、企業)", "<br>(留学、移住、転職、企業)"));

$('.card__list-search__ul li').on('click', function () {
    $('.card__list-search__ul li').removeClass('active');
    $(this).addClass('active');
    let categoryId = $(this).val();
    const currentUrl = new URL(window.location.href);
    currentUrl.pathname = '/search';
    currentUrl.searchParams.delete('category_type');
    currentUrl.searchParams.set('category_id', categoryId);
    currentUrl.searchParams.set('page', 1);
    window.location.href = currentUrl.toString();
});
