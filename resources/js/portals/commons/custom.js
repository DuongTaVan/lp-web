$(document).ready(function (e) {

    // auto trim when input change
    autoTrimInput();
});

function autoTrimInput() {
    $('input.auto-trim').change(function () {
        this.value = $.trim(this.value);
    });
}
