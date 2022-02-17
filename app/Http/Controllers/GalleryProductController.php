<?php

namespace App\Http\Controllers;

use App\Models\GalleryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function showManageGalleryPage($product_id){
        $product = Product::find($product_id);
        return view('admin.gallery.create')->with(compact('product'));
    }

    public function saveGalleryProduct(Request $request,$product_id){
        $this->AuthLogin();
        $get_images = $request->file('gallery_image');
        if($get_images){
            foreach($get_images as $key => $image){

                $get_name_image = $image->getClientOriginalName();
                $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
                $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
            
                $new_image = time().'-'.$name_image.'.'.$extension;
                $image->move('public/uploads/gallery',$new_image);
        
                $gallery = new GalleryProduct();
                $gallery->gallery_name = $new_image;            
                $gallery->gallery_image = $new_image;            
                $gallery->product_id = $product_id;
                $gallery->save();            
            }
            session(['message'=>'upload img success']);
            return redirect()->back(); 
        }else{
            session(['message'=>'upload img failed']);
            return redirect()->back();  
        }
        
    }

    public function showImgGallery(Request $request){
        $product_id = $request->product_id;
        $this->AuthLogin();
        $gallery = GalleryProduct::where('product_id',$product_id)->orderby('gallery_id','DESC')->get();
        $output = '';
        $output .= '
        <div class="table-responsive">
            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Manage</th>
                    </tr>
                </thread>
                
                <tbody> 
                    <form enctype="multipart/form-data">
                    '.csrf_field().'
                ';
                foreach ($gallery as $key => $img) {
                    $output .='
                   
                    <tr>
                        <td data-gallery_id="'.$img->gallery_id.'" contenteditable class="edit-gallery-name">'.$img->gallery_name.'</td>
                        <td>
                            <img src="'.url('public/uploads/gallery/'.$img->gallery_image).'" height="100" width="100" alt="" />    
                            <input type="file" class="form-control file_image" name="file_image" accept="image/*" id="file-'.$img->gallery_id.'" data-gallery_id="'.$img->gallery_id.'">
                            <span id="error_image"></span>
                        </td>
                        <td>
                            <button type="button" data-gallery_id="'.$img->gallery_id.'" class="btn btn-danger btn-xs delete-gallery">
                                Delete
                            </button>
                        </td> 
                    </tr>
                    ';
                }
                
        $output .= '
                    </form>
                </tbody>
            </table>
        </div>';
        echo $output;
    }

    public function updateNameGallery(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $gallery = GalleryProduct::find($data['gallery_id']);
        $gallery->gallery_name = rtrim($data['gallery_name'],'.');
        $gallery->save();
    }
    
    public function deleteGallery(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $gallery = GalleryProduct::find($data['gallery_id']);

        if($gallery->gallery_image){
            $path ='public/uploads/gallery/'.$gallery->gallery_image;
            unlink($path);
        }
        $gallery->delete();
        session(['message' => 'Delete gallery success']);
        return redirect()->back();
    }
    public function updateGallery(Request $request){
        $this->AuthLogin();
        $get_image = $request->file('file_image');
        $data = $request->all();
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/gallery',$new_image);
            
            $gallery = GalleryProduct::find($data['gallery_id']);
            $path ='public/uploads/gallery/'.$gallery->gallery_image;
            unlink($path);
            $gallery->gallery_image = $new_image;            
            $gallery->save();    
        }
    }
    //END BACKEND FUNCTIONS
}