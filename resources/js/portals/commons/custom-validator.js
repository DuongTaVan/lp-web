jQuery.extend(jQuery.validator.messages, {
  // required: "This field is required.",
  // remote: "Please fix this field.",
  // email: "Please enter a valid email address.",
  // url: "Please enter a valid URL.",
  // date: "Please enter a valid date.",
  // dateISO: "Please enter a valid date (ISO).",
  // number: "Please enter a valid number.",
  // digits: "Please enter only digits.",
  // creditcard: "Please enter a valid credit card number.",
  // equalTo: "Please enter the same value again.",
  // accept: "Please enter a value with a valid extension.",
  // maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
  // minlength: jQuery.validator.format("Please enter at least {0} characters."),
  // rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
  // range: jQuery.validator.format("Please enter a value between {0} and {1}."),
  // max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
  // min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

// jQuery.validator.addMethod('valid_zip_code', function (value) {
//   var regex = /^[0-9, -]+$/;
//
//   return value.trim().match(regex);
// });
//   $('form').validate({
//     rules: {
//       zip_code: {
//         minlength: 7,
//         maxlength: 8,
//         valid_zip_code: true
//       },
//     },
//     messages: {
//       "zip_code": {
//         valid_zip_code: "xxx"
//       },
//     },
//     submitHandler: function(form) {
//       form.submit();
//     }
//   });

$(document).ready(function(e) {
  // Auto open modal add when has validate error
  autoOpenModalWhenHasError();

  // Remove error when keyup
  removeErrorWhenKeyup();

  // Remove error when click button add
  removeErrorWhenClickButtonAdd();

  // Disable submit form when press enter
  // pressEnterInForm();
});

function autoOpenModalWhenHasError() {
  let errors = $(".error,.errors");
  if (errors.length > 0 && $(".modal-add").length != 0) {
    // check products screen has two modal add (product add, inventory add)
    if (window.location.pathname.search("/products") === 0) {
      let currentModal = localStorage.getItem("product_current_add_modal");
      if (currentModal === "inventory") {
        $(".modal-add#modalAddInventory").modal("show");
      } else if (currentModal === "product") {
        $(".modal-add#modalAddProduct").modal("show");
      }
    } else {
      $(".modal-add").modal("show");
    }
  }
}

function removeErrorWhenKeyup() {
  $(document).on("keyup", "input.error,textarea.error", function() {
    $(this).removeClass("error");
    $(this)
      .next()
      .remove();
  });

  $(document).on("change", "select.error", function() {
    $(this).removeClass("error");
    $(this)
      .next()
      .remove();
  });

  $(document).on("change", ".error.hasDatepicker", function() {
    $(this).removeClass("error");
    $(this)
      .parent()
      .find(".error")
      .remove();
  });
}

function removeErrorWhenClickButtonAdd() {
  $(".add-popup").click(function() {
    $(
      "input.error, textarea.error, select.error, .error.hasDatepicker"
    ).removeClass("error");
    $("label.error, div.errors").remove();
  });
}

// function pressEnterInForm() {
//   $(document).ready(function() {
//     $(window).keydown(function(event){
//       if(event.keyCode == 13) {
//         event.preventDefault();
//         return false;
//       }
//     });
//   });
// }
