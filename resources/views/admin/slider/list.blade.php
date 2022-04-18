@extends('admin.admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        List product
        </div>
        <?php
            $message = Session::get('message');
            if($message){
            echo '<div class="text-alert-success text-alert align-self-center">' .$message. '</div>';
                Session::put('message' , null);    
            }
        ?>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <select class="input-sm form-control w-sm inline v-middle">
                <option value="0">Bulk action</option>
                <option value="1">Delete selected</option>
                <option value="2">Bulk edit</option>
                <option value="3">Export</option>
                </select>
                <button class="btn btn-sm btn-default">Apply</button>                
            </div>
           
            <div class="col-sm-4"></div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($all_slide as $key => $slider)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>
                        <img src="public/uploads/slider/{{$slider ->slider_image}}" height="100" width="200" alt="" />    
                    </td>
                    <td>{{$slider->slider_name}}</td>
                    <td>{{$slider->slider_desc}}</td>
                    <td>
                        @if($slider ->slider_status == 0)
                            <a href="{{url('/inactive-slider/'.$slider->slider_id)}}">
                                <i class="fa fa-eye-style fa-eye-slash text text-danger"></i>
                            </a>
                        @else
                        <a href="{{url('/active-slider/'.$slider->slider_id)}}">
                            <i class="fa fa-eye-style fa-eye text text-success"></i>
                        </a>
                        @endif 
                    </td>
                    <td>
                        <a href="{{url('/edit-slider/'.$slider->slider_id)}}">
                        <i class="fa fa-edit text-success text-active"></i>
                        </a>
                        <a href="{{url('/delete-slider/'.$slider->slider_id)}}" onclick="return confirm('Are you sure you want to delete this slider?')">
                            <i class="fa fa-trash text-danger text"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            {{ $all_slide->links() }}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection