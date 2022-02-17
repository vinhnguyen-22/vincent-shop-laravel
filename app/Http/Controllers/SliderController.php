<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }

    public function manageSliderPage(){
        $this->AuthLogin();
        $all_slide = Slider::orderby('slider_id','DESC')->paginate(3);
        return view('admin.slider.list')->with(compact('all_slide'));
    }
    
    public function insertSliderPage(){
        $this->AuthLogin();
        return view('admin.slider.create');
    } 
    public function createSlider(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $slider = new Slider();
        $slider->slider_name = $data['title'];
        $slider->slider_status = $data['status'];
        $slider->slider_desc = $data['desc'];
        $slider->slider_slug = $data['slug'];
        $get_image = $request->file('image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/slider',$new_image);
            $slider->slider_image = $new_image;            
            $slider->save();
        }else{
            session(['message'=>'Please add slider']);
            return redirect('insert-slider');   
        }

        session(['message'=>'Add slider success']);
        return redirect('manage-slider'); 
    }   

    public function inactiveSlider ($slider_id){
        $this->AuthLogin();
        $slider = Slider::find($slider_id);
        $slider->slider_status = 0;
        $slider->save();
        session(['message'=>'Don\'t show slider']);
        return redirect('manage-slider');
    }
    
    public function activeSlider ($slider_id){
        $this->AuthLogin();
        $slider = Slider::find($slider_id);
        $slider->slider_status = 1;
        $slider->save();
        session(['message'=>'show slider']);
        return redirect('manage-slider');
    }
    
    public function editSlider($slider_id){
        $this->AuthLogin();
        $edit_slider = Slider::find($slider_id);
        $manager_slider = view('admin.slider.edit')->with(compact('edit_slider'));
        return view('admin_layout')->with('admin.slider.edit', $manager_slider);
    }
    
    public function updateSlider(Request $request,$slider_id){
        $this->AuthLogin();
        $data = $request->all();
        $slider = Slider::find($slider_id);
        $slider->slider_name = $data['title'];
        $slider->slider_desc = $data['desc'];
        $slider->slider_slug = $data['slug'];

        $get_image = $request->file('image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image =  pathinfo($get_name_image, PATHINFO_FILENAME);
            $extension = pathinfo($get_name_image, PATHINFO_EXTENSION);
           
            $new_image = time().'-'.$name_image.'.'.$extension;
            $get_image->move('public/uploads/slider',$new_image);
            $slider->slider_image = $new_image;            
            
            $slider->save();

            session(['message'=>'Update slider success']);
            return redirect('manage-slider');
        }
        
        $slider->save();
        session(['message'=>'Update slider success']);
        return redirect('manage-slider'); 
    }  
    
    public function deleteSlider($slider_id){
        $this->AuthLogin();
        $slider = Slider::find($slider_id);
        if($slider->slider_image){
            $path ='public/uploads/slider/'.$slider->slider_image;
            unlink($path);
        }
        $slider->delete();
        session(['message' => 'Delete slider success']);
        return redirect('manage-slider');
    }
}