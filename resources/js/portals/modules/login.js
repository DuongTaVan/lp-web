jQuery(document).ready(function ($) {
  $(".password").keydown((e) => {
    if (e.which === 13) {
      $("#form-login").submit();
    }
  })
});
