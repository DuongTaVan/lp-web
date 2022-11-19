$(function () {
    $('.checkRadio').change(function () {
        if (this.checked) {
            let $sort = $(this).val();
            let url = '/student/messages/courses-purchasing/sort';
            $.ajax({
                beforeSend: function () {
                    $('.lds-ellipsis').show();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,
                data: {sort: $sort}
            })
                .done(function (result) {
                    setTimeout(function () {
                        $('.lds-ellipsis').hide();
                    }, 300);
                    $('#result').html(result.html);
                    $('#purchased').html(result.htmlTabThree);
                });
        }
    });
})