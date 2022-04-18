<div class="col-md-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            @foreach($cats as $key => $cat)
                @if($cat->category_parentId == 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordian" href="#{{$cat->category_slug}}">
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    {{$cat->category_name}}
                                </a>
                            </h4>
                        </div>

                        <div id="{{$cat->category_slug}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    @foreach($cats as $key => $cat_sub)
                                        @if($cat_sub->category_parentId == $cat->category_id)
                                            <li><a href="{{url('category-product/'.$cat_sub->category_slug)}}"> {{$cat_sub->category_name}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div><!--/category-products-->

        <div class="brands_products"><!--brands_products-->
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    @foreach($brands as $key => $brand)
                    <li><a href="{{url('brand-product/'.$brand->brand_slug)}}"> <span class="pull-right">(50)</span>{{$brand->brand_name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div><!--/brands_products-->
        
        <div id="row_wishlist">
            <h2>Wishlist</h2>
        </div>
    </div>
</div>