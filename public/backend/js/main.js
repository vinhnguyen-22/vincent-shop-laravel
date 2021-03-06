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
        //?????i ch??? hoa th??nh ch??? th?????ng
        slug = title.toLowerCase();

        //?????i k?? t??? c?? d???u th??nh kh??ng d???u
        slug = slug.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/gi, "a");
        slug = slug.replace(/??|??|???|???|???|??|???|???|???|???|???/gi, "e");
        slug = slug.replace(/i|??|??|???|??|???/gi, "i");
        slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???/gi, "o");
        slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???/gi, "u");
        slug = slug.replace(/??|???|???|???|???/gi, "y");
        slug = slug.replace(/??/gi, "d");
        //X??a c??c k?? t??? ?????t bi???t
        slug = slug.replace(
            /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
            ""
        );
        //?????i kho???ng tr???ng th??nh k?? t??? g???ch ngang
        slug = slug.replace(/ /gi, "-");
        //?????i nhi???u k?? t??? g???ch ngang li??n ti???p th??nh 1 k?? t??? g???ch ngang
        //Ph??ng tr?????ng h???p ng?????i nh???p v??o qu?? nhi???u k?? t??? tr???ng
        slug = slug.replace(/\-\-\-\-\-/gi, "-");
        slug = slug.replace(/\-\-\-\-/gi, "-");
        slug = slug.replace(/\-\-\-/gi, "-");
        slug = slug.replace(/\-\-/gi, "-");
        //X??a c??c k?? t??? g???ch ngang ??? ?????u v?? cu???i
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

    //gallery
    function fetchGallery() {
        var product_id = $(".pro_id").val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "/lavarel%208/shop-vincent/show-gallery-img",
            method: "POST",
            data: {
                product_id,
                _token: _token,
            },
            success: function (data) {
                $("#load-gallery").html(data);
            },
        });
    }
    fetchGallery();

    $("#gallery_image").change(function () {
        var error = "";
        var files = $("#gallery_image")[0].files;
        if (files.length > 5) {
            error = "<p>B???n ch???n t???i ??a ch??? ???????c 5 ???nh</p>";
        } else if (files.length == 0) {
            error = "<p>B???n kh??ng ???????c b??? tr???ng ???nh</p>";
        } else if (files.size > 2000000) {
            error = "<p>File ??nh kh??ng ???????c l???n h??n 2MB</p>";
        }
        if (error == "") {
        } else {
            $("#gallery_image").val("");
            $("#error_gallery").html(
                "<span class='text-danger'>" + error + "</span>"
            );
            return false;
        }
    });

    $("#file_image").change(function () {
        var error = "";
        var files = $("#file_image")[0].files;
        if (files.length > 5) {
            error = "<p>B???n ch???n t???i ??a ch??? ???????c 5 ???nh</p>";
        } else if (files.length == 0) {
            error = "<p>B???n kh??ng ???????c b??? tr???ng ???nh</p>";
        } else if (files.size > 2000000) {
            error = "<p>File ??nh kh??ng ???????c l???n h??n 2MB</p>";
        }
        if (error == "") {
        } else {
            $("#file_image").val("");
            $("#error_image").html(
                "<span class='text-danger'>" + error + "</span>"
            );
            return false;
        }
    });

    $(document).on("blur", ".edit-gallery-name", function () {
        var gallery_id = $(this).data("gallery_id");
        var gallery_name = $(this).text();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "/lavarel%208/shop-vincent/update-name-gallery",
            method: "POST",
            data: {
                gallery_id,
                gallery_name,
                _token: _token,
            },
            success: function (data) {
                fetchGallery();
            },
        });
    });

    $(document).on("click", ".delete-gallery", function () {
        var gallery_id = $(this).data("gallery_id");
        var _token = $('input[name="_token"]').val();
        $delete = confirm("Are you sure you want to delete this image?");

        if ($delete) {
            $.ajax({
                url: "/lavarel%208/shop-vincent/delete-gallery",
                method: "POST",
                data: {
                    gallery_id,
                    _token: _token,
                },
                success: function (data) {
                    fetchGallery();
                },
            });
        }
    });

    $(document).on("change", ".file_image", function () {
        var gallery_id = $(this).data("gallery_id");
        var image = document.getElementById("file-" + gallery_id).files[0];
        var form_data = new FormData();

        form_data.append("file_image", image);
        form_data.append("gallery_id", gallery_id);
        console.log({ form_data, image, gallery_id });
        $.ajax({
            url: "/lavarel%208/shop-vincent/update-gallery",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function (data) {
                fetchGallery();
                $("#error_image").html(
                    "<span class='text-success'>update success</span>"
                );
            },
        });
    });

    //video

    function fetchVideo() {
        $.ajax({
            url: "/lavarel%208/shop-vincent/show-video",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            data: {},
            success: function (data) {
                $("#load-video").html(data);
            },
        });
    }
    fetchVideo();

    $(".add-video").click(function () {
        var video_title = $(".video_title").val();
        var video_link = $(".video_link").val();
        var video_desc = $(".video_desc").val();
        var video_slug = $(".video_slug").val();

        var video_image = document.getElementById("video_image").files[0];
        var form_data = new FormData();
        form_data.append("video_image", video_image);
        form_data.append("video_title", video_title);
        form_data.append("video_link", video_link);
        form_data.append("video_desc", video_desc);
        form_data.append("video_slug", video_slug);
        $.ajax({
            url: "/lavarel%208/shop-vincent/save-video",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function (data) {
                fetchVideo();
            },
        });
    });

    $(document).on("click", ".watch-video", function () {
        var video_id = $(this).data("video_id");
        $.ajax({
            url: "/lavarel%208/shop-vincent/show-modal-video",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            data: {
                video_id,
            },
            success: function (data) {
                $("#modal-video-body").html(data);
            },
        });
    });

    $(document).on("blur", ".video_edit", function () {
        var video_type = $(this).data("video_type");
        var video_id = $(this).data("video_id");

        switch (video_type) {
            case "video_title":
                var video_edit = $("#" + video_type + "_" + video_id).text();
                break;
            case "video_desc":
                var video_edit = $("#" + video_type + "_" + video_id).text();
                break;
            case "video_link":
                var video_edit = $("#" + video_type + "_" + video_id).text();
                break;
            default:
                var video_edit = $("#" + video_type + "_" + video_id).text();
                break;
        }

        $.ajax({
            url: "/lavarel%208/shop-vincent/update-video",
            method: "POST",
            data: {
                video_id,
                video_type,
                video_edit,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                fetchVideo();
            },
        });
    });

    $(document).on("click", ".delete-video", function () {
        var video_id = $(this).data("video_id");
        var _token = $('input[name="_token"]').val();
        $delete = confirm("Are you sure you want to delete video?");

        if ($delete) {
            $.ajax({
                url: "/lavarel%208/shop-vincent/delete-video",
                method: "POST",
                data: {
                    video_id,
                    _token: _token,
                },
                success: function (data) {
                    fetchVideo();
                },
            });
        }
    });

    $(document).on("change", ".file_video", function () {
        var video_id = $(this).data("video_id");
        var image = document.getElementById("file-video-" + video_id).files[0];
        var form_data = new FormData();
        form_data.append("file_image", image);
        form_data.append("video_id", video_id);
        $.ajax({
            url: "/lavarel%208/shop-vincent/update-img-video",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function (data) {
                fetchVideo();
                $("#error_image").html(
                    "<span class='text-success'>update success</span>"
                );
            },
        });
    });

    //dataTables
    $("#productTable").DataTable();
    $("#categoryProductTable").DataTable({});
    $("#commentTable").DataTable();

    //comments
    $(document).on("click", ".btn-reply-comment", function () {
        var comment_id = $(this).data("comment_id");
        var comment_content = $(".reply-comment-" + comment_id).val();
        var comment_product_id = $(this).attr("id");
        $.ajax({
            url: "/lavarel%208/shop-vincent/reply-comment",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            data: {
                comment_id,
                comment_content,
                comment_product_id,
            },
            success: function (data) {
                $(".reply-comment-" + comment_id).val("");
                location.reload();
            },
        });
    });

    //statistic
    $("#from-date").datepicker({
        prevText: "Th??ng tr?????c",
        nextText: "Th??ng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: [
            "Th??? 2",
            "Th??? 3",
            "Th??? 4",
            "Th??? 5",
            "Th??? 6",
            "Th??? 7",
            "Ch??? nh???t",
        ],
        duration: "slow",
    });
    $("#to-date").datepicker({
        prevText: "Th??ng tr?????c",
        nextText: "Th??ng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: [
            "Th??? 2",
            "Th??? 3",
            "Th??? 4",
            "Th??? 5",
            "Th??? 6",
            "Th??? 7",
            "Ch??? nh???t",
        ],
        duration: "slow",
    });
    var chart = new Morris.Bar({
        element: "revenue-charts",
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        barColors: ["#EC407A", "#00897B", "coral", "#C0CA33", "#9CC4E4"],

        pointFillColors: ["#ffffff"],
        pointStrokeColors: ["black"],
        fillOpacity: 0.6,
        hideHover: "auto",
        parseTime: false,

        // The name of the data record attribute that contains x-values.
        xkey: "period",
        // A list of names of data record attributes that contain y-values.
        ykeys: ["order", "sales", "profit", "quantity"],
        behaveLikeLine: true,
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ["order", "sales", "profit", "quantity"],
    });
    function chart30daysorder() {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "/lavarel%208/shop-vincent/days-order",
            method: "POST",
            dataType: "JSON",
            data: { _token },
            success: function (data) {
                chart.setData(data);
            },
        });
    }

    chart30daysorder();

    $(".filter_by").change(function () {
        var time = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "/lavarel%208/shop-vincent/filter-by-time",
            method: "POST",
            dataType: "JSON",
            data: { time, _token },
            success: function (data) {
                chart.setData(data);
            },
        });
    });

    $("#btn-filter").click(function () {
        var _token = $('input[name="_token"]').val();
        var from_date = $("#from-date").val();
        var to_date = $("#to-date").val();
        console.log(from_date, to_date);
        $.ajax({
            url: "/lavarel%208/shop-vincent/filter-by-date",
            method: "POST",
            dataType: "JSON",
            data: { from_date, to_date, _token },
            success: function (data) {
                chart.setData(data);
            },
        });
    });

    //statistic quantity item

    function donutQuantityItems() {
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "/lavarel%208/shop-vincent/statistic-item",
            method: "POST",
            dataType: "JSON",
            data: { _token },
            success: function (data) {
                var donut = Morris.Donut({
                    element: "donut-quantity-item",
                    resize: true,
                    colors: [
                        "#EC407A",
                        "#00897B",
                        "coral",
                        "cornflowerblue",
                        "#9CC4E4",
                    ],

                    data: [
                        { label: "Product", value: data["product"] },
                        { label: "Post", value: data["post"] },
                        { label: "Order sales", value: data["order"] },
                        { label: "Video", value: data["video"] },
                        { label: "Customer", value: data["customer"] },
                    ],
                });
            },
        });
    }

    donutQuantityItems();
});
