jQuery(document).ready(function ($) {
  $('#createDiscount').modal('show');

  $('#createDiscount').on('shown.bs.modal', function() {
    $("input").each(function(){
      if($(this).val() === ''){
        this.focus();
        return false;
      }
    });
  });
});