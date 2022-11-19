var showDropDown = 0;
$(document).ready(function () {
  $(".link").click(function () {
    $(this).addClass("active").siblings().removeClass("active")
  });
});

$(document).ready(function () {
  $(".header__bar").click(function () {
    $('.wrapper_main').toggleClass("show_sidebar");
    $('.wrapper__sidebar').toggleClass("active");
    $('.sidebar__label').toggleClass("active");
    $('.sidebar__logo').toggleClass("active");
    $('.sidebar__count').toggleClass("active");
    $('.sidebar__count-small').toggleClass("active");
  });
});

$(document).ready(function () {
  $(".header__setting").click(function () {
    $(".header__drop").toggleClass("active")
    showDropDown = 1;
  });
});

$(document).ready(function () {
  window.onclick = function(event) {
    if(!event.target.matches(".header__setting")) {
      var d = document.getElementsByClassName("header__drop");
      for(var i = 0; i< d.length; i++) {
        var x = d[i];
        if(x.classList.contains("active") && showDropDown == 0) {
          x.classList.remove("active");
        }
      }
    }
    showDropDown = 0;
  }
});