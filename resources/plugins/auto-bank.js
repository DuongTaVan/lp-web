let apiBank = null;
let apiBranch = null;
// const charsets = {
//     latin: {halfRE: /[!-~]/g, fullRE: /[！-～]/g, delta: 0xFEE0},
//     hangul1: {halfRE: /[ﾡ-ﾾ]/g, fullRE: /[ᆨ-ᇂ]/g, delta: -0xEDF9},
//     hangul2: {halfRE: /[ￂ-ￜ]/g, fullRE: /[ᅡ-ᅵ]/g, delta: -0xEE61},
//     kana: {
//         delta: 0,
//         half: "｡｢｣､･ｦｧｨｩｪｫｬｭｮｯｰｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ",
//         full: "。「」、・ヲァィゥェォャュョッーアイウエオカキクケコサシ" +
//             "スセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワンﾞﾟ"
//     },
//     extras: {
//         delta: 0,
//         half: "¢£¬¯¦¥₩\u0020|←↑→↓■°",
//         full: "￠￡￢￣￤￥￦\u3000￨￩￪￫￬￭￮"
//     }
// };
// const toFull = set => c => set.delta ?
//     String.fromCharCode(c.charCodeAt(0) + set.delta) :
//     [...set.full][[...set.half].indexOf(c)];
// const toHalf = set => c => set.delta ?
//     String.fromCharCode(c.charCodeAt(0) - set.delta) :
//     [...set.half][[...set.full].indexOf(c)];
// const re = (set, way) => set[way + "RE"] || new RegExp("[" + set[way] + "]", "g");
// const sets = Object.keys(charsets).map(i => charsets[i]);
// const toFullWidth = str0 =>
//     sets.reduce((str, set) => str.replace(re(set, "half"), toFull(set)), str0);
// const toHalfWidth = str0 =>
//     sets.reduce((str, set) => str.replace(re(set, "full"), toHalf(set)), str0);

function replaceKanaHalfToFull(str) {
    const kanaMap = {
        'ｶﾞ': 'ガ', 'ｷﾞ': 'ギ', 'ｸﾞ': 'グ', 'ｹﾞ': 'ゲ', 'ｺﾞ': 'ゴ',
        'ｻﾞ': 'ザ', 'ｼﾞ': 'ジ', 'ｽﾞ': 'ズ', 'ｾﾞ': 'ゼ', 'ｿﾞ': 'ゾ',
        'ﾀﾞ': 'ダ', 'ﾁﾞ': 'ヂ', 'ﾂﾞ': 'ヅ', 'ﾃﾞ': 'デ', 'ﾄﾞ': 'ド',
        'ﾊﾞ': 'バ', 'ﾋﾞ': 'ビ', 'ﾌﾞ': 'ブ', 'ﾍﾞ': 'ベ', 'ﾎﾞ': 'ボ',
        'ﾊﾟ': 'パ', 'ﾋﾟ': 'ピ', 'ﾌﾟ': 'プ', 'ﾍﾟ': 'ペ', 'ﾎﾟ': 'ポ',
        'ｳﾞ': 'ヴ', 'ﾜﾞ': 'ヷ', 'ｦﾞ': 'ヺ',
        'ｱ': 'ア', 'ｲ': 'イ', 'ｳ': 'ウ', 'ｴ': 'エ', 'ｵ': 'オ',
        'ｶ': 'カ', 'ｷ': 'キ', 'ｸ': 'ク', 'ｹ': 'ケ', 'ｺ': 'コ',
        'ｻ': 'サ', 'ｼ': 'シ', 'ｽ': 'ス', 'ｾ': 'セ', 'ｿ': 'ソ',
        'ﾀ': 'タ', 'ﾁ': 'チ', 'ﾂ': 'ツ', 'ﾃ': 'テ', 'ﾄ': 'ト',
        'ﾅ': 'ナ', 'ﾆ': 'ニ', 'ﾇ': 'ヌ', 'ﾈ': 'ネ', 'ﾉ': 'ノ',
        'ﾊ': 'ハ', 'ﾋ': 'ヒ', 'ﾌ': 'フ', 'ﾍ': 'ヘ', 'ﾎ': 'ホ',
        'ﾏ': 'マ', 'ﾐ': 'ミ', 'ﾑ': 'ム', 'ﾒ': 'メ', 'ﾓ': 'モ',
        'ﾔ': 'ヤ', 'ﾕ': 'ユ', 'ﾖ': 'ヨ',
        'ﾗ': 'ラ', 'ﾘ': 'リ', 'ﾙ': 'ル', 'ﾚ': 'レ', 'ﾛ': 'ロ',
        'ﾜ': 'ワ', 'ｦ': 'ヲ', 'ﾝ': 'ン',
        'ｧ': 'ア', 'ｨ': 'イ', 'ｩ': 'ウ', 'ｪ': 'エ', 'ｫ': 'オ',
        'ｯ': 'ッ', 'ｬ': 'ャ', 'ｭ': 'ュ', 'ｮ': 'ョ',
        '｡': '。', '､': '、', 'ｰ': 'ー', '｢': '「', '｣': '」', '･': '・',
        'ァ': 'ア', 'ィ': 'イ', 'ゥ': 'ウ', 'ェ': 'エ', 'ォ': 'オ', 'ャ': 'ヤ',
        'ュ': 'ユ', 'ョ': 'ヨ', 'ッ': 'ツ'
    };
    let reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g');

    // kana
    str = str.replace(reg, function (s) {
        return kanaMap[s];
    }).replace(/ﾞ/g, '゛').replace(/ﾟ/g, '゜');
    // alpha
    str = str.replace(/[!-~]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) + 0xFEE0);
    });
    str = str.replace(/\s\s+/g, '　');
    str = str.replace(/\s+/g, '　');

    return str;
}

const toASCII = function (chars) {
    chars = chars !== null ? chars.toString() : '';
    let ascii = '';
    if (chars) {
        for (let i = 0, l = chars.length; i < l; i++) {
            let c = chars[i].charCodeAt(0);
            // make sure we only convert half-full width char
            if (c >= 0xFF00 && c <= 0xFFEF) {
                c = 0xFF & (c + 0x20);
            }

            ascii += String.fromCharCode(c);
        }
    }

    return ascii.replace(/\D/g, '');
}

const getListBank = function () {
    let text = $('input[name=bank_name]').val();
    let route = '/bank-autocomplete';
    if (apiBank) {
        apiBank.abort();
    }
    apiBank = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: route,
        data: {text: replaceKanaHalfToFull(text)}
    })
        .done(function (msg) {
            getListBranch();
            apiBank = null;
            $('.list__bank').html(msg.html);
            addSelectItemEventBank();

            if (text === '') {
                $('.list__branch').html('');
            }
        });
}

const getListBranch = function () {
    const route = '/branch-autocomplete';
    const bank = $('input[name=bank_name]').val();
    const text = $('input[name=branch_name]').val();
    const accountType = $('input[name=account_type]');
    if (bank === 'ゆうちょ銀行') {
        accountType.val(2)
        if (accountType.parent().find('.label-title')) {
            accountType.parent().find('.label-title').html('通常貯金');
        }
        if (accountType.parent().find('.account-type')) {
            accountType.parent().find('.account-type').html('通常貯金');
        }
    } else {
        accountType.val(1)
        if (accountType.parent().find('.label-title')) {
            accountType.parent().find('.label-title').html('普通');
        }
        if (accountType.parent().find('.account-type')) {
            accountType.parent().find('.account-type').html('普通');
        }
    }
    if (apiBranch) {
        apiBranch.abort();
    }
    apiBranch = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: route,
        data: {bank: bank, text: replaceKanaHalfToFull(text)}
    })
        .done(function (msg) {
            apiBranch = null;
            addSelectItemEventBranch();
            $('.list__branch').html(msg.html);
        });
}

const getNewValue = function (type, text) {
    let newVal;
    switch (type) {
        case 'half-width':
            newVal = toASCII(text);
            break;
        case 'full-width':
            newVal = replaceKanaHalfToFull(text);
            break;
        default:
            newVal = text;
            break;
    }

    return newVal;
}

const addSelectItemEventBank = function () {
    $('body').on('mousedown', '.bank-select', function () {
        const element = $(this).parents('.input-payment').find('input');
        const oldValue = element.val();
        const newValue = $.trim($(this).text());
        if (oldValue !== newValue) {
            element.val(newValue);
            $('input[name=branch_name]').val('');
            getListBranch();
        }
    })
}

const addSelectItemEventBranch = function () {
    $('body').on('mousedown', '.branch-select', function () {
        const element = $(this).parents('.input-payment').find('input');
        element.val($.trim($(this).text()));
    })
}

$(document).ready(function () {
    addSelectItemEventBank();
    $('input[data-convert]').each(function () {
        const element = $(this);
        const typeTo = element.data('convert');
        const search = element.data('search');
        const change = element.data('change');
        const minLength = element.data('min-length');
        if (!typeTo) {
            return;
        }
        element.attr('type', 'search');

        if (change) {
            element.on('keypress', function (e) {
                const keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    const oldVal = element.val();
                    const newVal = getNewValue(typeTo, oldVal);
                    if (oldVal !== newVal) {
                        element.val(newVal);
                    }
                }
            });

            element.on('change blur', function (e) {
                const oldVal = element.val();
                const newVal = getNewValue(typeTo, oldVal);
                if (oldVal !== newVal) {
                    element.val(newVal);
                }
            });
        }

        if (minLength) {
            element.on('blur', function (e) {
                const oldVal = element.val();
                const newVal = (+minLength - oldVal.length) > 0 ? ('0'.repeat(+minLength - oldVal.length) + oldVal) : oldVal;
                if (oldVal !== newVal) {
                    element.val(newVal);
                }
            });
        }

        if (search) {
            const parent = element.parents('.input-payment');

            // add 'focus' when show list
            element.on('focus', function () {
                parent.addClass('active');
            });

            element.on('blur', function () {
                parent.removeClass('active');
            });

            // add 'input' when search
            element.on('input', function () {
                if (search === 'bank') {
                    getListBank();
                }
                if (search === 'branch') {
                    getListBranch();
                }
            });
        }
    })

    // disable submit when press 'enter'
    $('form').on('keyup keypress', function (e) {
        const keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    //Set text append in tag span .
    let pickElement = '';
    //Set value data in tag span .
    let pickElementValue = '';

    if ($('.selected')) {
        pickElement = $('.selected').html();
        pickElementValue = $('.selected').data('type');
        $('.title-option').html(pickElement);
        $('.title-option').attr('data-accountType', pickElementValue);
    }

    $('#dropdown p').click(function () {
        pickElement = $(this).html();
        pickElementValue = $(this).data('type');
        $('.title-option').html(pickElement);
        $('.title-option').attr('data-accountType', pickElementValue);
        $('#dropdown p').filter(function () {
            $(this).removeClass('selected');
        });
        $(this).addClass('selected')
    })

    $('input[name=account_name]').blur(function () {
        $(this).val(removeWhiteSpaceFirstAndLast($(this).val()))
        $('.button-confirm').removeClass('remove-event');
        $('.account_name-show-error').text('');
        if (/\s/g.test($(this).val()) === false && $(this).val().indexOf('）') === -1 && $(this).val().indexOf('（') === -1) {
            $('.account_name-show-error').css('margin-left', '0').text('※姓名の間にスペースを入れてください')
            $('.button-confirm').addClass('remove-event');
        }
        if ($(this).val().indexOf('）') != -1 || $(this).val().indexOf('（') != -1) {
            $(this).val($(this).val().replace(/\s/g, ''))
        }
    });

    function removeWhiteSpaceFirstAndLast(content) {
        return $.trim(content);
    }
});
