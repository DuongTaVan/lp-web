var swiperGift = new Swiper('.gift-container', {
    slidesPerView: 9,
    navigation: {
        nextEl: '.button-next-gift',
        prevEl: '.button-prev-gift',
    },
});
var swiperQuickChat = new Swiper('.quick-chat-container', {
    slidesPerView: 3,
    navigation: {
        nextEl: '.button-next-quick-chat',
        prevEl: '.button-prev-quick-chat',
    },
});

$(".gift-paragraph").on("click", function () {
    let data = {
        name: $(this).attr("data-name"),
        price: $(this).attr("data-price"),
        point: $(this).attr("data-points-equivalent"),
        img: $(this).find(".img-fluid").attr("src"),
        giftId: $(this).attr("data-gift-id")
    }

    $("#gift").on('show.bs.modal', function () {
        appendModal(data, $(this));
    });
})

$(".student-livestream-container .btn-sent-gift, .livestream-container .btn-sent-gift").on("click", function () {
    let data = {
        name: $(this).attr("data-name"),
        price: $(this).attr("data-price"),
        point: $(this).attr("data-points-equivalent"),
        img: $("#raise-hand").attr("src"),
        giftId: 'raise-hand'
    }

    $("#gift").on('show.bs.modal', function () {
        appendModal(data, $(this));
    });
})

function appendModal (data, $this) {
    $this.find(".popup-gift-name").html(data.name);
    $this.find("#popup-gift-image").attr("src", data.img);
    $this.find("#price").html(data.price);
    $this.find(".point").html(data.point);
    $this.find("#gift-id").val(data.giftId);
    $("#gift-confirm").find('.price').html('¥' + data.price)
    $("#gift-buy").find('.price').html('¥' + data.price)
    $("#gift-success").find('.price').html('¥' + data.price)
}

