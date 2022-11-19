$(document).ready(() => {
    initCalendar();
    $('.reset-datetimepicker').on('click', () => {
        setTimeout(() => {
            initCalendar();
        }, 1);
    });
});

function initCalendar() {
    const countMathRangeDate = checkRangeDate();
    if (countMathRangeDate) {
        initDatetimepickerRange();
    }

    // init
    initDatetimepicker(countMathRangeDate);
}

function checkRangeDate() {
    let datetimepicker = $('.datetimepicker');
    let i = 0;
    let j = 0;
    $.each(datetimepicker, (index, element) => {
        element = element.getElementsByTagName('input');
        if (!element.length) return;
        element = element[0];

        if (element.name.includes('start')) i++;
        if (element.name.includes('end')) j++;
    });

    return i === j && i > 0;
}

function initDatetimepicker(countMathRangeDate) {
    // init datetimepicker
    let datetimepicker = $('.datetimepicker');
    $.each(datetimepicker, function (index, element) {
        element = element.getElementsByTagName('input');
        if (!element.length) return;
        element = element[0];

        if (countMathRangeDate)
            if (element.name.includes('start') || element.name.includes('end'))
                return;
        // $('.datetimepicker[name="' + element.name + '"]').flatpickr(getOptionFromElement(element));
        $(this).flatpickr(getOptionFromElement(element));
    });
}

function initDatetimepickerRange() {
    let startElement = $('.datetimepicker .start-datetime');
    let endElement = $('.datetimepicker .end-datetime');

    let startOption = getOptionFromElement(startElement[0]);
    let endOption = getOptionFromElement(endElement[0]);

    startOption.onChange = (selectedDates, dateStr, instance) => {
        end.set('minDate', dateStr)
    };
    endOption.onChange = function (selectedDates, dateStr, instance) {
        start.set('maxDate', dateStr)
    };
    let start = startElement.parent().flatpickr(startOption);

    let end = endElement.parent().flatpickr(endOption);
}

function getOptionFromElement(element) {
    let value = element.dataset.value ?? '';
    let format = element.dataset.format ?? 'Y/m/d';
    let timepicker = element.dataset.timepicker ?? false;
    let datepicker = element.dataset.datepicker ?? true;
    let minDate = element.dataset.min;
    let maxDate = element.dataset.max;

    let option = {};

    if (value.length !== 0) {
        option.defaultDate = value;
    }

    if (minDate) {
        option.minDate = new Date(minDate);
    }

    if (maxDate) {
        option.maxDate = new Date(maxDate);
    }

    if (timepicker !== false && timepicker !== 'false') {
        option.enableTime = true;
    }

    if (datepicker !== true && datepicker !== 'true') {
        option.noCalendar = true;
        option.enableTime = true;
    }

    option.dateFormat = format;
    option.allowInput = true;
    option.enableSeconds = false;
    option.time_24hr = true;
    option.minuteIncrement = 1;
    option.locale = 'ja';
    option.wrap = true;
    option.disableMobile = true;

    return option;
}

function checkRangeDateInvalid($start, $end) {
    if (!$start || !$end) return false;
    const start = new Date($start).getTime();
    const end = new Date($end).getTime();
    return start >= end;
}
