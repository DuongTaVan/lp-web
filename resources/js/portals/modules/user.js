jQuery(document).ready(function($) {
  eventEnter();
  // save data when data change
  updateUserData();

  //change to sale support user
  changeToSaleUser();

  // delete user
  deleteUserById();

  //grant point
  grantPoint();
  var myVar;
  $(".close-alert__btn").click(function() {
    $(".alert-success").removeClass("show");
    clearTimeout(myVar);
  });

  $(".sale-support__btn-cancel").click(function() {
    $("#modal-sale-support").modal("hide");
  });

  $(".delete-user__btn-cancel").click(function() {
    $("#modal-delete-user").modal("hide");
  });

  $("#modal-delete-user").click(function () {
    $("#modal-delete-user").modal("show");
  })

  $(".form__info-password__input").keydown(function (event) {
    if (event.keyCode === 13) {
      $("#change-password-form").submit();
    }
  })

  $(function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const message = urlParams.get("message");

    if (urlParams.has("message") === true) {
      $('.message').html(message);
      $("#alert-save-info").addClass("show");
      setTimeout(() => {
        $("#alert-save-info").removeClass("show");
      }, 2900);
      window.history.replaceState(null, null, window.location.pathname);
    }
  });
});

function deleteUserById() {
  $(".delete-user__btn-success").click(function() {
    $("#loading-overlay").addClass("show");
    let userId = document.querySelector(".modal_user_id").value;
    let urlResource = "/users/" + userId;
    $.ajax({
      url: urlResource,
      method: "DELETE",
      success: function(response) {
        window.location.href = "/users?message=" + response.data;
      },
      error: function(error) {},
    });
  });
}

function changeToSaleUser() {
  $(".sale-support__btn-success").click(function() {
    let user_id = $(".modal_user_id").val();
    let urlResource = "/user-change-to-sale";
    $.ajax({
      url: urlResource,
      method: "POST",
      data: { user_id: user_id },
      async: false,
      success: function(response) {
        $(".message").html(response.message);
        $("#alert-sale-support").addClass("show");
        setTimeout(function() {
          $("#alert-sale-support").removeClass("show");
        }, 2900);
        $("#modal-sale-support").modal("hide");
        toastr.info("変更しました。").css({"width": "486px", "height": "78px"});
      },
      error: function(error) {},
    });
  });
}

function updateUserData() {
  $(".card-footer__btn").click(function() {
    let prego_rank = $(".prego_rank select").val();
    let prego_interviewed = $("#interviewed").val();
    let memo = $(".memo").val();
    let user_id = $(".userId").val();
    let urlResource = "/user-update";
    let dataResource = {
      prego_rank: prego_rank,
      prego_interviewed: prego_interviewed,
      memo: memo,
      user_id: user_id,
    };
    $.ajax({
      url: urlResource,
      type: "POST",
      global: false,
      data: dataResource,
      async: false,
      success: (response) => {
        $(".memo").attr("memo", response.data.memo);
        $(".message").html(response.message);
        $("#alert-save-info").addClass("show");
        setTimeout(() => {
          $("#alert-save-info").removeClass("show");
        }, 2900);
        toastr.info("保存しました").css({"width": "486px", "height": "78px"});
      },
      error: function() {},
    });
  });
}

function grantPoint() {
  $(".give-point__btn").click(function () {
    var formInput = $("#form-input");
    formInput.validate({
      rules: {
        deposit_points: {
          required: true,
          number: true,
        },
      },
      messages: {
        deposit_points: {
          required: "デポジットポイント は、必ず指定してください。",
          number: "有効な数字を入力してください。",
        },
      },
      submitHandler: function(form) {
        let urlResource = "/user-grant-point";
        let dataResource = formInput.serializeArray();
        let user_id = document.querySelector(".modal_user_id").value;
        dataResource.push({ name: "user_id", value: user_id });

        $.ajax({
          url: urlResource,
          type: "POST",
          data: dataResource,
          async: false,
          success: function(response) {
            $("#modal-give-point").modal("hide");
            $("#alert-give-point").addClass("show");
            setTimeout(() => {
              $("#alert-give-point").removeClass("show");
            }, 2900);
            toastr.info("ポイントを付与しました。").css({"width": "486px", "height": "78px"});
          },
          error: function(error) {},
        });
      },
    });
  });
}

function eventEnter() {
  $(document).keydown(function(event) {
    if (event.keyCode == 13 && !$(event.target).is("textarea")) {
      event.preventDefault();
      return false;
    }
  });
}
