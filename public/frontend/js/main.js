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
        var cart_product_stock = $(".cart_product_stock_" + id).val();
        var _token = $('input[name="_token"]').val();

        if (parseInt(cart_product_stock) > parseInt(cart_product_qty)) {
            $.ajax({
                url: "/lavarel%208/shop-vincent/add-cart-ajax",
                method: "POST",
                data: {
                    cart_product_id: cart_product_id,
                    cart_product_name: cart_product_name,
                    cart_product_image: cart_product_image,
                    cart_product_price: cart_product_price,
                    cart_product_qty: cart_product_qty,
                    cart_product_stock: cart_product_stock,
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
                            window.location.href =
                                "/lavarel%208/shop-vincent/show-cart-page";
                        }
                    );
                },
            });
        } else {
            alert(
                "Please buy lower than quantity in stock " + cart_product_stock
            );
        }
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

    //SEND ORDER CHECKOUT
    $(".send_order").click(function () {
        var shipping_email = $(".shipping_email").val();
        var shipping_name = $(".shipping_name").val();
        var shipping_address = $(".shipping_address").val();
        var shipping_phone = $(".shipping_phone").val();
        var shipping_notes = $(".shipping_notes").val();
        var shipping_method = $(".payment_select").val();
        var order_total = $(".order_total").val();
        var order_fee = $(".order_fee").val();
        var order_coupon = $(".order_coupon").val();
        var _token = $('input[name="_token"]').val();
        swal(
            {
                title: "Confirm your order",
                text: "Once you place an order, you can only cancel it within an hour",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Continue checkout",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "confirm-order",
                        method: "POST",
                        data: {
                            shipping_email,
                            shipping_name,
                            shipping_address,
                            shipping_phone,
                            shipping_notes,
                            shipping_method,
                            order_coupon,
                            order_fee,
                            order_total,
                            _token: _token,
                        },
                        success: function () {
                            swal(
                                "Good job!",
                                "Your payment has been successful. Thank you for your purchase!",
                                "success"
                            );
                        },
                    });
                    window.setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    swal(
                        "Cancelled",
                        "Your imaginary file is safe :)",
                        "error"
                    );
                }
            }
        );
    });

    //gallery
    $("#lightSlider").lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        slideMargin: 0,
        slideMove: 1,
        thumbItem: 3,
        slideMargin: 10,
        speed: 400, //ms'
        auto: true,
        pause: 5000,
        enableDrag: true,
    });
});
