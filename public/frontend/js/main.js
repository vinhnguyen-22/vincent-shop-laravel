/*price range*/

$("#sl2").slider();

var RGBChange = function () {
    $("#RGB").css(
        "background",
        "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
    );
};

/*scroll to top*/

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: "scrollUp", // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: "top", // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: "linear", // Scroll to top easing (see http://easings.net/)
            animation: "fade", // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647, // Z-Index for the overlay
        });
    });

    $(".add-to-cart").click(function () {
        var id = $(this).data("id_product");
        var cart_product_id = $(".cart_product_id_" + id).val();
        var cart_product_name = $(".cart_product_name_" + id).val();
        var cart_product_image = $(".cart_product_image_" + id).val();
        var cart_product_price = $(".cart_product_price_" + id).val();
        var cart_product_qty = $(".cart_product_qty_" + id).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "add-cart-ajax",
            method: "POST",
            data: {
                cart_product_id: cart_product_id,
                cart_product_name: cart_product_name,
                cart_product_image: cart_product_image,
                cart_product_price: cart_product_price,
                cart_product_qty: cart_product_qty,
                _token: _token,
            },
            success: function () {
                swal(
                    {
                        title: "Đã thêm sản phẩm vào giỏ hàng",
                        text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                        showCancelButton: true,
                        cancelButtonText: "Xem tiếp",
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Đi đến giỏ hàng",
                        closeOnConfirm: false,
                    },
                    function () {
                        window.location.href = "show-cart-page";
                    }
                );
            },
        });
    });

    // CHECK SHIPPING FE
    $(".optionSelect").on("change", function () {
        var action = $(this).attr("id");
        var ma_id = $(this).val();
        var _token = $('input[name="_token"]').val();
        var result = "";

        if (action == "province") {
            result = "district";
        } else {
            result = "ward";
        }

        $.ajax({
            url: "select-delivery-fe",
            method: "POST",
            data: {
                action: action,
                ma_id: ma_id,
                _token: _token,
            },
            success: function (data) {
                $("#" + result).html(data);
            },
        });
    });

    $(".calculate_shipping_fee").click(function () {
        var province = $(".province").val();
        var district = $(".district").val();
        var ward = $(".ward").val();
        var _token = $('input[name="_token"]').val();
        console.log(province);
        if (province == 0 && district == 0 && ward == 0) {
            alert("Please select to calculate shipping fee");
        } else {
            $.ajax({
                url: "calculate-fee",
                method: "POST",
                data: {
                    province: province,
                    district: district,
                    ward: ward,
                    _token: _token,
                },
                success: function (data) {
                    location.reload();
                },
            });
        }
    });
});
