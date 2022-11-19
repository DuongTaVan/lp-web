// import Inputmask from "inputmask";
//
// $(document).ready(function () {
//     const selector = document.getElementById("account-number");
//
//     let im = new Inputmask("9999 9999 9999 9999");
//     im.mask(selector);
//     // $("#account-number").on("input", function (event) {
//     //     if (!(event.keyCode == 8                                // backspace
//     //         || event.keyCode == 46                              // delete
//     //         || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
//     //         || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
//     //         || (event.keyCode >= 96 && event.keyCode <= 105))   // number on keypad
//     //     ) {
//     //         event.preventDefault();
//     //     }
//     //     //
//     //     // let val = $(this).val();
//     //     // let newval = '';
//     //     // val = val.replace(/\s/g, '');
//     //     //
//     //     // // iterate to letter-spacing after every 4 digits
//     //     // for (let i = 0; i < val.length; i++) {
//     //     //     if (i % 4 === 0 && i > 0) newval = newval.concat(' ');
//     //     //     newval = newval.concat(val[i]);
//     //     // }
//     //
//     //     const newVal = formatCardNumber($(this).val());
//     //
//     //     $(this).val(newVal);
//     // })
//     $('.no-ime').noIme();
// });
//
// $.fn.noIme = function() {
//     return this.each(function() {
//         var wrap = $(this);
//         var proxy = wrap.find('.no-ime__proxy');
//         var input = wrap.find('.no-ime__input');
//         proxy.on('input', function() {
//             input.val(this.value);
//         });
//     });
// };
