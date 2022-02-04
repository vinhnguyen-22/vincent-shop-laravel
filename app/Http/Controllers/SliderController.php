<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    //
    public function manageSliderPage(){
        $all_slide = Slider::orderby('slider_id','DESC')->paginate(3);
        return view('admin.slider.list')->with(compact('all_slide'));
    }
    
    public function insertSliderPage(){
        return view('admin.slider.create');
    } 
    public function createSlider(Request $request){
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
        $slider = Slider::find($slider_id);
        $slider->slider_status = 0;
        $slider->save();
        session(['message'=>'Don\'t show slider']);
        return redirect('manage-slider');
    }
    
    public function activeSlider ($slider_id){
        $slider = Slider::find($slider_id);
        $slider->slider_status = 1;
        $slider->save();
        session(['message'=>'show slider']);
        return redirect('manage-slider');
    }
    
    public function editSlider($slider_id){
        $edit_slider = Slider::find($slider_id);
        $manager_slider = view('admin.slider.edit')->with(compact('edit_slider'));
        return view('admin_layout')->with('admin.slider.edit', $manager_slider);
    }
    
    public function updateSlider(Request $request,$slider_id){
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
        $slider = Slider::find($slider_id);
        $slider->delete();
        session(['message' => 'Delete slider success']);
        return redirect('manage-slider');
    }
}