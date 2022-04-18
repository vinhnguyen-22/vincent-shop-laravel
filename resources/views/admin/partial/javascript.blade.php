<script type="text/javascript" src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/main.js')}}"></script>
<script type="text/javascript">
    $(".delete-document").click(function () {
        var _token = $('input[name="_token"]').val();
        var post_id = $(this).data("id");

        $.ajax({
            url: "/lavarel%208/shop-vincent/delete-document",
            method: "POST",
            data: { post_id, _token },
            success: function (data) {
                location.reload();
            },
        });
    });
</script>