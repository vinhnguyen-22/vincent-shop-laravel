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
                            title: "???? th??m s???n ph???m v??o gi??? h??ng",
                            text: "B???n c?? th??? mua h??ng ti???p ho???c t???i gi??? h??ng ????? ti???n h??nh thanh to??n",
                            showCancelButton: true,
                            cancelButtonText: "Xem ti???p",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "??i ?????n gi??? h??ng",
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

    //video
    $(document).on("click", ".view-video", function () {
        var video_id = $(this).data("video_id");
        $.ajax({
            url: "/lavarel%208/shop-vincent/show-modal-view-video",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            data: {
                video_id,
            },
            success: function (data) {
                $(".modal-video-view").html(data);
            },
        });
    });

    //search ajax
    $("#search-box").keyup(function () {
        var keywords = $(this).val();
        if (keywords != "") {
            $.ajax({
                url: "/lavarel%208/shop-vincent/search-ajax",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                method: "POST",
                data: { keywords },
                success: function (data) {
                    $("#keywords-box").fadeIn();
                    $("#keywords-box").html(data);
                },
            });
        } else {
            $("#keywords-box").fadeOut();
        }
    });

    $(document).on("click", ".li-search-ajax", function () {
        $("#search-box").val($(this).text());
        $("#keywords-box").fadeOut();
    });

    // quick view
    $(".quick-view").click(function () {
        var product_id = $(this).data("product_id");
        $.ajax({
            url: "/lavarel%208/shop-vincent/quick-view",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            dataType: "JSON",
            data: {
                product_id,
            },
            success: function (data) {
                $("#product_quickView_title").html(data.product_title);
                $("#product_quickView_price").html(data.product_price);
                $("#product_quickView_id").html(data.product_id);
                $("#product_quickView_image").html(data.product_image);
                $("#product_quickView_gallery").html(data.product_gallery);
                $("#product_quickView_desc").html(data.product_desc);
                $("#product_quickView_content").html(data.product_content);
                $("#product_quickView_inputValue").html(
                    data.product_inputValue
                );
                $("#goToProductPage").attr("href", data.product_slug);
            },
        });
    });

    $(document).on("click", ".add-to-cart-quickView", function () {
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
                            title: "???? th??m s???n ph???m v??o gi??? h??ng",
                            text: "B???n c?? th??? mua h??ng ti???p ho???c t???i gi??? h??ng ????? ti???n h??nh thanh to??n",
                            showCancelButton: true,
                            cancelButtonText: "Xem ti???p",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "??i ?????n gi??? h??ng",
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

    // Comment
    function loadComment() {
        var product_id = $(".comment_product_id").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/lavarel%208/shop-vincent/load-comment",
            method: "POST",
            data: {
                product_id,
                _token: _token,
            },
            success: function (data) {
                $("#comment-show").html(data);
            },
        });
    }
    loadComment();

    $(".send-comment").on("click", function () {
        var product_id = $(this).data("id_product");
        var comment_name = $(".comment_name").val();
        var comment_content = $(".comment_content").val();
        var _token = $('input[name="_token"]').val();

        console.log({ product_id, comment_name, comment_content, _token });
        $.ajax({
            url: "/lavarel%208/shop-vincent/send-comment",
            method: "POST",
            data: {
                product_id,
                comment_name,
                comment_content,
                _token: _token,
            },
            success: function (data) {
                loadComment();
                $(".comment_name").val("");
                $(".comment_content").val("");
            },
        });
    });

    //Rating hover ????nh gi?? sao
    function remove_background(product_id) {
        for (var count = 0; count <= 5; count++) {
            $("#" + product_id + "-" + count).css("color", "#ccc");
        }
    }

    $(document).on("mouseenter", ".rating", function () {
        var index = $(this).data("index");
        var product_id = $(this).data("product_id");

        remove_background(product_id);
        for (var count = 1; count <= index; count++) {
            $("#" + product_id + "-" + count).css("color", "#ffcc00");
        }
    });

    $(document).on("mouseleave", ".rating", function () {
        var index = $(this).data("index");
        var product_id = $(this).data("product_id");
        var rating = $(this).data("rating");

        remove_background(product_id);
        for (var count = 1; count <= rating; count++) {
            $("#" + product_id + "-" + count).css("color", "#ffcc00");
        }
    });

    $(document).on("click", ".rating", function () {
        var index = $(this).data("index");
        var product_id = $(this).data("product_id");
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/lavarel%208/shop-vincent/send-rating",
            method: "POST",
            data: {
                index,
                product_id,
                _token: _token,
            },
            success: function (data) {
                loadRating();
                alert("C??m ??n b???n ???? ????nh gi??");
            },
        });
    });

    function loadRating() {
        var product_id = $(".comment_product_id").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/lavarel%208/shop-vincent/load-rating",
            method: "POST",
            data: {
                product_id,
                _token: _token,
            },
            success: function (data) {
                $(".list-rating").html(data);
            },
        });
    }
    loadRating();

    // tabs product cateogry
    var cate_id = $(".tabs_pro").data("id");
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: "/lavarel%208/shop-vincent/product-tabs",
        method: "POST",
        data: {
            cate_id,
            _token,
        },
        success: function (data) {
            $("#tabs_product").html(data);
        },
    });
    $(".tabs_pro").click(function () {
        var cate_id = $(this).data("id");
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/lavarel%208/shop-vincent/product-tabs",
            method: "POST",
            data: {
                cate_id,
                _token,
            },
            success: function (data) {
                $("#tabs_product").html(data);
            },
        });
    });
    //sort by in category
    $("#sort").on("change", function () {
        var url = $(this).val();
        if (url) {
            window.location = url;
        }
        return false;
    });

    //price range selected

    $(function () {
        var min = parseInt($("#min").val());
        var max = parseInt($("#max").val());
        $("#slider-range").slider({
            range: true,
            values: [min, max],
            min: min,
            max: max,
            steps: 100,
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            },
        });
        $("#amount").val(
            "$" +
                $("#slider-range").slider("values", 0) +
                " - $" +
                $("#slider-range").slider("values", 1)
        );
    });
});
