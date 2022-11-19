// const timeInterVal = 10000; // ms
// const elementEmail = $('.sidebar__count.email');
// const getEmailUnread = function () {
//     $.ajax({
//         url: "/api/read_email",
//         type: "GET",
//         success: function success(response) {
//             if (response) {
//                 if (+response) {
//                     elementEmail.removeClass('dp-none');
//                 } else if (!elementEmail.hasClass('dp-none')) {
//                     elementEmail.addClass('dp-none');
//                 }
//                 $('.sidebar__count.email').html(response)
//             }
//         },
//         error: function error(_error) {
//             console.log(_error);
//         }
//     });
// };
// $(document).ready(function () {
//     getEmailUnread();
// })
//
// setInterval(function () {
//     getEmailUnread();
// }, timeInterVal);
