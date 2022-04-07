<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\MenuPost;
use App\Models\Information;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function showContactPage(Request $request){
        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO

        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $informations = Information::orderBy('info_id','DESC')->get();
        $logo = Information::select('info_img')->first();
        return view('pages.contact.show')->with(compact('catsPost','brands','cats','meta_desc','meta_keywords','meta_title','url_canonical','slider','informations','logo'));
    }


    public function showListInfoPage(){
        $this->AuthLogin();
        $list_info = Information::orderBy('info_id','DESC')->paginate(5);
        return view("admin.contact.list")->with(compact('list_info'));
    }

    public function showAddInfoPage(){
        return view("admin.contact.create");
    }
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function createInfo(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $info = new Information();
        $info->info_contact = $data['information'];
        $info->info_map = $data['map'];
        $info->info_fanpage = $data['fanpage'];
        $get_image = $request->file('image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/info',$new_image);
            $info->info_img = $new_image;            
            $info->save();
        }else{
            session(['message'=>'Please add logo info']);
            return redirect('insert-info');   
        }

        session(['message'=>'Add info success']);
        return redirect('insert-info')->with(['message','Thêm thành công']); 
    }   

    public function editInfo($info_id){
        $edit_info = Information::find($info_id);
        return view('admin.contact.edit')->with(compact('edit_info'));
    }
    
    public function updateInfo(Request $request,$info_id){
        $data = $request->all();
        $info = Information::find($info_id);
        $info->info_contact = $data['information'];
        $info->info_map = $data['map'];
        $info->info_fanpage = $data['fanpage'];
        $get_image = $request->file('image');
        $path = 'public/uploads/info/';

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move($path,$new_image); 
            
            if($info->info_img){
                unlink($path.$info->info_img);
            }
            
            $info->info_img = $new_image;            
            
            $info->save();
            session(['message'=>'Update info success']);
            return redirect('all-info');
        }
        $info->save();
        session(['message'=>'Update info success']);
        return redirect('all-info'); 
    }  
    
    public function deleteInfo($info_id){
        $info = Information::find($info_id);
        if($info->info_img){
            $path ='public/uploads/info/'.$info->info_img;
            unlink($path);
        }
        $info->delete();
        session(['message' => 'Delete info success']);
        return redirect('all-info');
    }
}