<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\GalleryProduct;
use App\Models\Information;
use App\Models\MenuPost;
use App\Models\Slider;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

     public function showManageVideoPage(){
        $videos = Video::orderby('video_id','DESC')->get();
        return view('admin.video.create')->with(compact('videos'));
    }   

    public function saveVideo(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $video = new Video();

        $sub_link= substr($data['video_link'],17);
        $video->video_title = $data['video_title'];
        $video->video_link = $sub_link;
        $video->video_desc = $data['video_desc'];
        $video->video_slug = $data['video_slug'];
        $get_image = $request->file('video_image');
        
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/video',$new_image);
            $video->video_image = $new_image;            
        }else{
            $video->video_image = "";            
        }
        $video->save();

        session(['message'=>'insert video success']);
        return redirect()->back(); 
    }

    public function showModalVideo(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $video = Video::find($data['video_id']);
        $output = '';
        $output .= '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video->video_link.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        echo $output;
    }
   
    
    public function showVideo(){
        $this->AuthLogin();
        $videos = Video::orderby('video_id','DESC')->get();
        $output = '';
        $output .= '
        <div class="table-responsive">
            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Desc</th>
                        <th>Link</th>
                        <th>Manage</th>
                    </tr>
                </thread>
                
                <tbody> 
                ';
                foreach ($videos as $key => $video) {
                    $output .='
                    <tr>
                        <td>
                            <img src="'.url('public/uploads/video/'.$video->video_image).'" height="100" width="100" alt="" />    
                            <input type="file" class="form-control file_video" name="file_image" accept="image/*" id="file-video-'.$video->video_id.'" data-video_id="'.$video->video_id.'">
                            <span id="error_image"></span>
                        </td>
                        <td data-video_type="video_title" data-video_id="'.$video->video_id.'" id="video_title_'.$video->video_id.'" contenteditable class="video_edit" >'.$video->video_title.'</td>
                        <td data-video_type="video_slug" data-video_id="'.$video->video_id.'" id="video_slug_'.$video->video_id.'" class="video_edit" >'.$video->video_slug.'</td>
                        <td data-video_type="video_desc" data-video_id="'.$video->video_id.'" id="video_desc_'.$video->video_id.'" contenteditable class="video_edit" >'.$video->video_desc.'</td>
                        <td data-video_type="video_link" data-video_id="'.$video->video_id.'" id="video_link_'.$video->video_id.'" contenteditable class="video_edit" >'.$video->video_link.'</td>
                        <td>
                            <button type="button" data-video_id="'.$video->video_id.'" class="btn btn-danger btn-sm delete-video">
                                Delete
                            </button>

                            <button type="button" data-video_id="'.$video->video_id.'" class="btn btn-primary btn-sm watch-video" data-toggle="modal" data-target="#videoModal">
                                Watch
                            </button>
                        </td> 
                    </tr>
                    ';
                }          
        $output .= '
                </tbody>
            </table>
        </div>';
        echo $output;
    }

    public function updateVideo(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $video = Video::find($data['video_id']);

        switch ($data['video_type']) {
            case "video_title":
                $video->video_title = $data['video_edit'];
                break;
            case "video_desc":
                $video->video_desc = $data['video_edit'];
                break;
            case "video_link":
                $sub_link= substr($data['video_edit'],17);
                $video->video_link = $sub_link;
                break;
            default:
                break;
        }

        $video->save();
    }
    
    public function deleteVideo(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $video = Video::find($data['video_id']);

        if($video->video_image){
            $path ='public/uploads/video/'.$video->video_image;
            unlink($path);
        }
        $video->delete();
        session(['message' => 'Delete video success']);
        return redirect()->back();
    }
    
    public function updateImgVideo(Request $request){
        $this->AuthLogin();
        $get_image = $request->file('file_image');
        $data = $request->all();
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/video/',$new_image);
            
            $video = Video::find($data['video_id']);
            $path ='public/uploads/video/'.$video->video_image;
            if($video->video_image){
                unlink($path);
            }
            $video->video_image = $new_image;            
            $video->save();    
        }
    }
    
    //end function backend
    public function showVideoPage( Request $request){  
        $cats = CategoryProduct::orderBy('category_order','ASC')->orderBy('category_id','DESC')->where('category_status','1')->get();      
        $brands = Brand::orderBy('brand_id','DESC')->where('brand_status','1')->get();
        $slider = Slider::where('slider_status',1)->orderBy('slider_id','DESC')->take('5')->get();
        $catsPost = MenuPost::orderBy('menu_post_id','DESC')->where('menu_post_status','1')->get();
        $logo = Information::select('info_img')->first();

        $meta_desc = '';
        $meta_keywords =''; 
        $meta_title = '';
        $url_canonical = $request->url();
        
        $videos = Video::orderby('video_id','desc')->paginate(6);
        // SEO
        $meta_desc = "Equipment for gamers, Specializes in selling electronic devices to gamers. Get support for building gaming PCs, loading game cards and other utilities.";
        $meta_keywords = "gaming, ps4, ps5, computer";
        $meta_title = "GAMING STORE | Equipment for gamers";
        $url_canonical = $request->url();
        // SEO


        return view('pages.video.show')->with(compact('logo','videos','catsPost','cats','brands','slider','meta_desc','meta_keywords','meta_title','url_canonical'));
    }

     
    public function showModalViewVideo(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $video = Video::find($data['video_id']);
        $output = '';
        $output .= '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$video->video_link.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        echo $output;
    }
    
}