$().ready(function () {
    const validationProduct = {
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
        },
    };

    $("#productForm").validate(validationProduct);
});
