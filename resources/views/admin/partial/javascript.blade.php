
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
    // upload ckeditor
    CKEDITOR.replace('description-product',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });
    CKEDITOR.replace('content-product',{
        filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}",
        filebrowserBrowseUrl: "{{url('file-browser?_token='.csrf_token())}}",
        filebrowserUploadMethod:'form'
    });

    CKEDITOR.replace('description-post');
    CKEDITOR.replace('content-post');

    CKEDITOR.replace('information-contact');    
</script>
<!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
<script type="text/javascript">
        //order category
    $("#category_order").sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {
            var page_id_array = new Array();
            var _token = $('input[name="_token"]').val();

            $("#category_order tr").each(function () {
                page_id_array.push($(this).attr("id"));
            });

            $.ajax({
                url: "/lavarel%208/shop-vincent/arrange-category",
                method: "post",
                data: {
                    page_id_array,
                    _token,
                },
                success: function (data) {
                    alert(data);
                },
            });
        },
    })
</script>