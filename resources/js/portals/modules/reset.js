jQuery(document).ready(function ($) {
    $(".form-send-mail__input").keydown(function () {
        if (event.keyCode == 13 && !$(event.target).is("textarea")) {
            $(".form-send-mail").submit();
            return false;
        }
    });

    $('#send-mail-success').modal('show');

    $('#redirect-login').click(function (e) {
        e.preventDefault();
        window.location = '/portal/login';
    });

    $('#btn-modal-close').click(function (e) {
        $('#exampleModalCenter').hide();
    });

    $("#form-reset").keyup(e => {
        if (e.which === 13) {
            $('#form-reset').submit();
        }
    });
});
