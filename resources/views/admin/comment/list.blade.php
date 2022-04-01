@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        List comment
        </div>
        <?php
            $message = session()->get('message');
            if($message){
            echo '<div class="text-alert-success text-alert align-self-center">' .$message. '</div>';
                Session::put('message' , null);    
            }
        ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="commentTable">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Approval</th>
                    <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $key => $comment)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>
                    @if($comment ->comment_parent)
                        <span style="color:coral">
                            {{$comment ->comment_name}}
                        </span>
                    @else
                        <span style="color:cornflowerblue">
                            {{$comment ->comment_name}}
                        </span>
                    @endif                                
                    </td>
                    <td>
                    {{$comment ->comment_content}}
                    <ul>
                        @foreach($comments as $key => $reply)
                            @if($reply->comment_parent == $comment ->comment_id)   
                                <li><span>{{$reply->comment_name}}: </span>{{$reply->comment_content}}</li>
                            @endif                                
                        @endforeach
                    </ul>
                    @if($comment ->comment_approval && !$comment ->comment_parent)
                    <br>
                    <label for="">Reply: </label>
                    <br>
                    <textarea class="form-control reply-comment-{{$comment ->comment_id}}" style="resize:none" name="" id="" cols="30" rows="10"></textarea>
                    <input type="button" data-comment_id="{{$comment ->comment_id}}" id="{{$comment ->comment_product_id}}" class="btn btn-primary btn-xs btn-reply-comment"value="Send">
                    @endif
                    </td>
                    <td>{{$comment ->comment_date}}</td>
                    <td>
                        <a href="{{url('/product-detail/'.$comment ->product->product_slug)}}">{{$comment ->product->product_name}}</a>
                        </td>
                    <td>
                        @if($comment ->comment_approval == 0)
                            <button type="button" class="btn btn-primary">
                                <a style="color:white" href="{{URL::to('/inactive-comment/'.$comment->comment_id)}}">
                                    Approve
                                </a>                                
                            </button>
                        @else
                            <button type="button" class="btn btn-danger">
                                <a style="color:white" href="{{URL::to('/active-comment/'.$comment->comment_id)}}">
                                    Deny
                                </a>
                            </button>
                        @endif 
                    </td>
                    <td>
                        <a href="{{URL::to('/delete-comment/'.$comment->comment_id)}}" onclick="return confirm('Are you sure you want to delete this comment?')">
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   
  </div>
</div>
@endsection