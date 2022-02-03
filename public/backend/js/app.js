$(document).ready(function () {
    const validationOpt = {
        onfocusout: true,
        onkeyup: true,
        onclick: false,
        rules: {
            title: {
                required: true,
                minlength: 3,
            },
            price: {
                required: true,
                digits: true,
            },
            desc: {
                required: true,
                minlength: 8,
            },
            content: {
                required: true,
                minlength: 8,
            },
            slug: {
                required: true,
                minlength: 3,
            },
        },
    };

    $("#productForm").validate(validationOpt);
    $("#categoryForm").validate(validationOpt);

    //AJAX PROVINCE DISTRICT WARD
    $(document).on("blur", ".feeShipEdit", function () {
        var feeId = $(this).data("fee_ship_id");
        var feeValue = $(this).text();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "update-feeship",
            method: "POST",
            data: {
                feeId,
                feeValue,
                _token: _token,
            },
            success: function (data) {
                fetchDelivery();
            },
        });
    });

    function fetchDelivery() {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "select-feeship",
            method: "GET",
            data: {
                _token: _token,
            },
            success: function (data) {
                $("#load-delivery").html(data);
            },
        });
    }
    fetchDelivery();

    $(".add_delivery").click(function () {
        var province = $(".province").val();
        var district = $(".district").val();
        var ward = $(".ward").val();
        var feeShip = $(".shippingfee").val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "save-delivery",
            method: "POST",
            data: {
                province: province,
                district: district,
                ward: ward,
                feeShip: feeShip,
                _token: _token,
            },
            success: function (data) {
                fetchDelivery();
            },
        });
    });

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
            url: "select-delivery",
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

    // CONVERT SLUG
    $(".convert_slug").keyup(function () {
        var value = $(this).val();
        var inputSlug = $(this).data("slug");
        var convertSlug = ChangeToSlug(value);
        $("input[name='" + inputSlug + "']").val(convertSlug);
    });

    function ChangeToSlug(title) {
        //Đổi chữ hoa thành chữ thường
        slug = title.toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
        slug = slug.replace(/đ/gi, "d");
        //Xóa các ký tự đặt biệt
        slug = slug.replace(
            /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
            ""
        );
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, "-");
        slug = slug.replace(/\-\-\-\-/gi, "-");
        slug = slug.replace(/\-\-\-/gi, "-");
        slug = slug.replace(/\-\-/gi, "-");
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = "@" + slug + "@";
        slug = slug.replace(/\@\-|\-\@|\@/gi, "");

        return slug;
    }

    // SELECT ORDER STATUS FROM
    $("#statusOrderSelect").change(function () {
        var orderStatus = $(this).val();
        var orderId = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();

        quantity = [];
        $('input[name="product_sales_quantity"]').each(function () {
            quantity.push($(this).val());
        });

        orderProductId = [];
        $('input[name="order_product_id"]').each(function () {
            orderProductId.push($(this).val());
        });

        j = 0;
        if (orderStatus == 2) {
            for (i = 0; i < orderProductId.length; i++) {
                var orderQty = $(".order_qty_" + orderProductId[i]).val();
                var orderQtyStorage = $(
                    ".order_qty_storage_" + orderProductId[i]
                ).val();

                if (parseInt(orderQty) > parseInt(orderQtyStorage)) {
                    j = j + 1;

                    $(".color_qty_" + orderProductId[i]).css(
                        "background",
                        "rgba(255,0,0,0.3)"
                    );
                    if (j == 1) {
                        alert("Not enough quantity in stock");
                    }
                }
            }
        }
        if (j == 0) {
            $.ajax({
                url: "/lavarel%208/shop-vincent/update-order-qty",
                method: "POST",
                data: {
                    _token: _token,
                    orderStatus,
                    orderId,
                    quantity,
                    orderProductId,
                },
                success: function (data) {
                    alert("Update status success");
                    location.reload();
                },
            });
        }
    });

    $(".update_quantity_order").click(function () {
        var orderProductId = $(this).data("product_id");
        var orderCode = $(".order_code").val();
        var orderQty = $(".order_qty_" + orderProductId).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/lavarel%208/shop-vincent/update-qty",
            method: "POST",
            data: {
                orderProductId,
                orderCode,
                orderQty,
                _token: _token,
            },
            success: function (data) {
                alert("Update quantity success");
                location.reload();
            },
        });
    });
});
