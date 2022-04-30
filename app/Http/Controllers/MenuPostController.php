<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuPostController extends Controller
{
      public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function addPageMenuPost(){
        $this->AuthLogin();
        return view('admin.menu_post.create');
    } 
    
    public function showAllMenuPost(){
        $this->AuthLogin();
        
        $list_menu_post = MenuPost::paginate(5);        
        return view('admin.menu_post.list',['list_menu_post' => $list_menu_post]);
    }
    
    public function createMenuPost(Request $request){
        $this->AuthLogin();
        
        $data = $request->all();
        $menu_post = new MenuPost();
        $menu_post->menu_post_name = $data['name'];
        $menu_post->menu_post_status = $data['status'];
        $menu_post->menu_post_desc = $data['desc'];
        $menu_post->menu_post_slug = $data['slug'];
        $menu_post->save();
        session(['message'=>'Add menu post success']);
        return redirect('all-menu-post'); 
    }   

    public function inactiveMenuPost ($menu_post_id){
        $this->AuthLogin();
        $menu_post = MenuPost::find($menu_post_id);
        $menu_post->menu_post_status = 0;
        $menu_post->save();
        session(['message'=>'Don\'t show menu_post']);
        return redirect('all-menu-post');
    }
    
    public function activeMenuPost ($menu_post_id){
        $this->AuthLogin();
        $menu_post = MenuPost::find($menu_post_id);
        $menu_post->menu_post_status = 1;
        $menu_post->save();
        session(['message'=>'show menu_post']);
        return redirect('all-menu-post');
    }
    
    public function editMenuPost($menu_post_id){
        $this->AuthLogin();
        $edit_menu_post = MenuPost::find($menu_post_id);
        return view('admin.menu_post.edit')->with(compact('edit_menu_post'));
    }
    
    public function updateMenuPost(Request $request,$menu_post_id){
        $this->AuthLogin();
        
        $data = $request->all();
        $menu_post = MenuPost::find($menu_post_id);
        $menu_post->menu_post_name = $data['name'];
        $menu_post->menu_post_desc = $data['desc'];
        $menu_post->menu_post_slug = $data['slug'];
        $menu_post->save();
        session(['message'=>'Update menu post success']);
        return redirect('all-menu-post'); 
    }  
    
    public function deleteMenuPost($menu_post_id){
        $this->AuthLogin();
        $menu_post = MenuPost::find($menu_post_id);
        $menu_post->delete();

        session(['message' => 'Delete menu post success']);
        return redirect('all-menu-post');
    }
    
    //end function admin

    public function showMenuPostPage(Request $request,$menu_post_slug){  
        $menu_post = MenuPost::where('menu_post_slug',$menu_post_slug)->take(1)->get();
        foreach ($menu_post as $key => $val){
            // SEO
            $meta_desc = $val->menu_post_desc;
            $meta_keywords = $val->menu_post_slug;
            $meta_title = $val->menu_post_name;
            $url_canonical = $request->url();
            // SEO
 
            $menu_id = $val->menu_post_id;
        }
        $posts = Post::with('menuPost')->where('post_status',1)->where('menu_post_id', $menu_id)->paginate(10);

        return view('pages.post.showMenu')->with(compact('posts','meta_desc','meta_keywords','meta_title','url_canonical','menu_post'));       
    }
}