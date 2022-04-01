<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Frontend 

    public function loadComment(Request $request){
        $product_id = $request->product_id;

        $comment = Comment::where('comment_product_id',$product_id)->where('comment_approval',1)->orderBy('comment_date','ASC')->get();
        
        $output = '';
        foreach($comment as $key => $comm){
            if(!$comm->comment_parent){
                $output .= '
                <div class="row style-comment" >
                    <div class="col-md-2">
                        <img src="'.asset('public/frontend/images/cat-icon.jpg').'" class="img img-responsive img-thumbnail" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="">
                            <span style="color:green">@'.$comm->comment_name.'</span>
                            <span>
                                <i class="fa fa-calendar-o"></i>
                                <sub>'.$comm->comment_date.'</sub>
                            </span>
                        </div>
                        <p style="margin-top: 5px;">'.$comm->comment_content.'</p>
                    </div>
                </div>';
                    
                foreach($comment as $key => $reply){
                    if($reply->comment_parent == $comm ->comment_id){   
                        $output .= 
                        ' <div class="row style-comment" style="margin:5px 0px 0px 40px" >
                            <div class="col-md-2">
                                <img src="'.asset('public/frontend/images/cat-nhamnhi.jpg').'" class="img img-responsive img-thumbnail" alt="">
                            </div>
                            <div class="col-md-10">
                                <div class="">
                                    <span style="color:coral">@'.$reply->comment_name.'</span>
                                    <span>
                                        <i class="fa fa-calendar-o"></i>
                                        <sub>'.$reply->comment_date.'</sub>
                                    </span>
                            </div>
                                <p style="margin-top: 5px;">'.$reply->comment_content.'</p>
                            </div>
                        </div>';
                    }     
                }
                $output .= '<hr>';
            }
        }
        echo $output;
    }
    
    public function sendComment(Request $request){
        $data = $request->all();
        $comment = new Comment();
        $comment->comment_name = $data['comment_name'];
        $comment->comment_content = $data['comment_content'];
        $comment->comment_product_id = $data['product_id'];
        $comment->comment_approval = 0;
        $comment->comment_date = Carbon::now()->toDateTimeString();
        $comment->save();
    }
    
    //backend

    public function listComment () {
        $comments = Comment::with('product')->orderBy('comment_approval','ASC')->orderBy('comment_date','DESC')->get();
        return view('admin.comment.list')->with(compact('comments'));
    }
    
    public function inactiveComment ($comment_id){
        $comment = Comment::find($comment_id);
        $comment->comment_approval = 0;
        $comment->save();
        session(['message' => 'Don\'t show comment']);
        return redirect('all-comment');
    }
    
    public function activeComment ($comment_id){
        $comment = Comment::find($comment_id);
        $comment->comment_approval = 1;
        $comment->save();
        session(['message' => 'Show comment']);
        return redirect('all-comment');
    }

    public function replyComment(Request $request){
        $data = $request->all();
        $comment = new Comment();
        $comment->comment_name = "Vincent Admin";
        $comment->comment_content = $data['comment_content'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_approval = 0;
        $comment->comment_parent = $data['comment_id'];
        $comment->comment_date = Carbon::now()->toDateTimeString();
        $comment->save();
    }
}