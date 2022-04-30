<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Post;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function addPagePost(){
        $this->AuthLogin();
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
        return view('admin.post.create')->with(compact('menu_post'));
    } 
    
    public function showAllPost(){
        $this->AuthLogin();
        
        $list_post = Post::join('tbl_menu_post','tbl_menu_post.menu_post_id','=','tbl_post.menu_post_id')->paginate(5);
        
        return view('admin.post.list',['list_post' => $list_post]);
    }
    
    public function createPost(Request $request){
        $this->AuthLogin();
        
        $data = $request->all();
        $post = new Post();
        $post->menu_post_id = $data['menuPost'];
        $post->post_title = $data['title'];
        $post->post_status = $data['status'];
        $post->post_desc = $data['desc'];
        $post->post_content = $data['content'];
        $post->post_author = $data['author'];
        $post->post_slug = $data['slug'];
        $post->post_keywords = $data['keywords'];
        $post->created_at = Carbon::now()->toDateTimeString();
        $post->updated_at = Carbon::now()->toDateTimeString();

        $get_image = $request->file('thumbnail');
        $get_document = $request->file('document');

        if($get_document){
            $path = "public/uploads/document";

            $get_name_document = $get_document->getClientOriginalName();
            $name_document =  pathinfo($get_name_document, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_document, PATHINFO_EXTENSION);
           
            $new_document = time().'-'.$name_document.'.'.$extension;
            $get_document->move($path,$new_document);
            $post->post_file = $new_document;            
        }

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/post',$new_image);
            $post->post_thumbnail = $new_image;            
        }else{
            $post->post_thumbnail = '';
        }

        $post->save();
        session(['message'=>'Add post success']);
        return redirect('all-post'); 
    }   

    public function inactivePost ($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        $post->post_status = 0;
        $post->save();
        session(['message'=>'Don\'t show post']);
        return redirect('all-post');
    }
    
    public function activePost ($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        $post->post_status = 1;
        $post->save();
        session(['message'=>'show post']);
        return redirect('all-post');
    }
    
    public function editPost($post_id){
        $this->AuthLogin();
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
        $edit_post = Post::find($post_id);
        return view('admin.post.edit')->with(compact('edit_post','menu_post'));
    }
    
    public function updatePost(Request $request,$post_id){
        $this->AuthLogin();
        
        $data = $request->all();
        $post = Post::find($post_id);
        $post->menu_post_id = $data['menuPost'];
        $post->post_title = $data['title'];
        $post->post_desc = $data['desc'];
        $post->post_content = $data['content'];
        $post->post_author = $data['author'];
        $post->post_slug = $data['slug'];
        $post->post_keywords = $data['keywords'];
        $post->updated_at = Carbon::now()->toDateTimeString();

        $get_image = $request->file('thumbnail');
        $get_document = $request->file('document');

        if($get_document){
            $path = "public/uploads/document";

            if($post->post_file){
                $path_file ='public/uploads/document/'.$post->post_file;
                unlink($path_file);
            }
            $get_name_document = $get_document->getClientOriginalName();
            $name_document =  pathinfo($get_name_document, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_document, PATHINFO_EXTENSION);
           
            $new_document = time().'-'.$name_document.'.'.$extension;
            $get_document->move($path,$new_document);
            $post->post_file = $new_document;    
        }
        
        if($get_image){
            if($post->post_thumbnail){
                $path ='public/uploads/post/'.$post->post_thumbnail;
                unlink($path);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/post',$new_image);
            $post->post_thumbnail = $new_image;            
            
            $post->save();

            session(['message'=>'Update post success']);
            return redirect('all-post');
        }
        
        $post->save();
        session(['message'=>'Update post success']);
        return redirect('all-post'); 
    }  
    
    public function deletePost($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        if($post->post_thumbnail){
            $path ='public/uploads/post/'.$post->post_thumbnail;
            unlink($path);
        }
        if($post->post_file){
            $path_file ='public/uploads/document/'.$post->post_file;
            unlink($path_file);
        }
            
        $post->delete();

        session(['message' => 'Delete post success']);
        return redirect('all-post');
    }

    public function deleteDocument(Request $request){
        $data = $request->all();
        $post = Post::find($data['post_id']);
        
        if($post->post_file){
            $path_file ='public/uploads/document/'.$post->post_file;
            unlink($path_file);
            $post->post_file = NULL;
        }
        
        $post->save();
    }

    //end function admin
    
    public function showPostPage(Request $request,$post_slug){  
        $posts = Post::with('menuPost')->where('post_slug',$post_slug)->take(1)->get();
        foreach ($posts as $key => $val){
            // SEO
            $meta_desc = $val->post_desc;
            $meta_keywords = $val->post_slug;
            $meta_title = $val->post_title;
            $url_canonical = $request->url();
            // SEO
        }

        $post = Post::Where('post_slug', $post_slug)->first();
        $post->post_views += 1;
        $post->save();

        return view('pages.post.show')->with(compact('posts','meta_desc','meta_keywords','meta_title','url_canonical'));       
    }
}