<script src="{{asset('public/frontend/js/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{asset('public/frontend/js/sweetalert.js')}}"></script>
<script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
<script src="{{asset('public/frontend/js/prettify.js')}}"></script>
<script src="{{asset('public/frontend/js/main.js')}}"></script>
<script type="text/javascript">
    //wishlist with localStorage
    function addWishlist(clicked_id) {
        var id = clicked_id;
        var url = document.getElementById("wishlist_producturl" + id).href;
        var name = document.getElementById("wishlist_productname" + id).value;

        var price = document.getElementById(
            "wishlist_productprice" + id
        ).value;
        var image = document.getElementById("wishlist_productimage" + id).src;

        var newItem = {
            url,
            id,
            name,
            price,
            image,
        };
        if (localStorage.getItem("data") == null) {
            localStorage.setItem("data", "[]");
        }
        var oldData = JSON.parse(localStorage.getItem("data"));
        //grep : Tìm các phần tử của một mảng thỏa mãn chức năng lọc. Các mảng ban đầu không bị ảnh hưởng.
        const matches = $.grep(oldData, function (obj) {
            // khi click vào sản phẩm thì sẽ có id và so sánh với id của oldData
            return obj.id == id;
        });

        if (matches.length) {
            alert("Item loved");
        } else {
            oldData.push(newItem);

            $("#row_wishlist").append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="'+newItem.image+'" width="100%"></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+'</p><a href="'+newItem.url+'">Đặt hàng</a></div></div>');
        }
        localStorage.setItem("data", JSON.stringify(oldData));
    }

    function viewWishlist() {
        if (localStorage.getItem("data") != null);
        var data = JSON.parse(localStorage.getItem("data"));
        data.reverse();
        document.getElementById("row_wishlist").style.overflowY = "scroll";
        document.getElementById("row_wishlist").style.height = "500px";
        for (i = 0; i < data.length; i++) {
            var url = data[i].url;
            var name = data[i].name;
            var price = data[i].price;
            var image = data[i].image;
            $("#row_wishlist").append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="'+image+'"width="100%"></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+price+'</p><a href="'+url+'">Đặt hàng</a></div></div>');
        }
    }
    viewWishlist();
</script>
{{-- // SOCIAL PLUGIN FACEBOOK --}}
<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat"
attribution='setup_tool'
page_id="113066507098247"
theme color="#ff7e29"
logged_in_greet ing="Hi bạn! Chào mừng bạn đến Shop"
logged out_greeting="Hi bạn! Chào mừng bạn đến Shop"
>
    
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "131939792730877");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
    FB.init({
        xfbml            : true,
        version          : 'v12.0'
    });
    };

    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=1542262152832776&autoLogAppEvents=1" nonce="xg4YUwcD"></script>
