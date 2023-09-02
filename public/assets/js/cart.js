//self invokation function //يعني عرفتها واستدعيتها
(function ($) {
    $(".item-quantity").on("change", function (e) {
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

    $(".remove-item").on("click", function (e) {
        var itemId = $(this).data("id");

        $.ajax({
            url: "/cart/" + itemId, //data-id
            method: "delete",
            data: {
                _token: csrf_token,
            },
            success: response => {
                $(`#$(id)`).remove();
            }
        });
    });

    $(".add-to-cart").on("click", function (e) {
        var itemId = $(this).data("id");

        $.ajax({
            url: "/cart", //data-id
            method: "post",
            data: {
                product_id: $(this).data('id'),
                quantity: $(this).data('quantity'),
                _token: csrf_token,
            },
            success: response => {
                alert('product Added♥');
            }
        });
    });

})(jQuery);
