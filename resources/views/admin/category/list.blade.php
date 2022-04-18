@extends('admin.admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        List category
        </div>
        <?php
            $message = Session::get('message');
            if($message){
            echo '<div class="text-alert-success text-alert align-self-center">' .$message. '</div>';
                Session::put('message' , null);    
            }
        ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="categoryProductTable">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Title</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <style type="text/css">
                #category_order .ui-state-highlight {
                    padding:24px;
                    background-color: #ffffcc;
                    border: 1px dotted #ccc;    
                    cursor: move;
                    margin-top: 12px;
                }
            </style>
            <form>
            @csrf
                <tbody id="category_order" >
                    @foreach($list_category as $key => $cat)
                    
                        <tr id="{{$cat->category_id}}">
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$cat ->category_name}}</td>
                            <td>
                                @if($cat->category_parentId == 0)
                                    <span style="color: coral">Root</span>
                                @else
                                    @foreach($list_category as $key => $cat_sub)
                                        @if($cat_sub->category_id == $cat->category_parentId)
                                            <span style="color: darkcyan">{{$cat_sub ->category_name}}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if($cat ->category_status == 0)
                                    <a href="{{url('/inactive-category-product/'.$cat->category_id)}}">
                                        <i class="fa fa-eye-style fa-eye-slash text text-danger"></i>
                                    </a>
                                @else
                                <a href="{{url('/active-category-product/'.$cat->category_id)}}">
                                    <i class="fa fa-eye-style fa-eye text text-success"></i>
                                </a>
                                @endif 
                            </td>
                            <td>
                                <a href="{{url('/edit-category-product/'.$cat->category_id)}}">
                                <i class="fa fa-edit text-success text-active"></i>
                                </a>
                                <a href="{{url('/delete-category-product/'.$cat->category_id)}}" onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fa fa-trash text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </form>
        </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('public/backend/js/jquery-ui.min.js')}}"></script>
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
@endsection