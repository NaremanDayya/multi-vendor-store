//self invokation function //يعني عرفتها واستدعيتها
(function ($) {
    $("item-quantity").on("change", function (e) {
        var itemId = $(this).data("id");

        $.ajax({
            url: "/cart/" + itemId, //data-id
            method: "put",
            data: {
                quantity: $(this).val(),
                _token: csrf_token,
            },
        });
    });
})(jQuery);
