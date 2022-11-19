// /* When the user clicks on the button,
//      toggle between hiding and showing the dropdown content */
// window.onload = (event) => {
//     if (document.getElementById('vc-btn')) {
//         document.getElementById('vc-btn').addEventListener('click', () => {
//             document.getElementById("dropdown-video-call").classList.toggle("show");
//             // Close the dropdown if the user clicks outside of it
//             window.onclick = function (event) {
//                 if (!event.target.matches('.drop-btn-video-call')) {
//                     var dropdowns = document.getElementsByClassName("dropdown-video-call");
//                     var i;
//                     for (i = 0; i < dropdowns.length; i++) {
//                         var openDropdown = dropdowns[i];
//                         if (openDropdown.classList.contains('show')) {
//                             openDropdown.classList.remove('show');
//                         }
//                     }
//                 }
//             }
//         })
//     }
// }
