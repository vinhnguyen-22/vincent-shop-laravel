<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{ 
    public function uploadFile(){
        $file_name = "anthony";
        $file_path = public_path('uploads/document/1650182545-HuynhCongPhat-ReactJS-Fresher.pdf');
        $file_data = File::get($file_path);
        Storage::cloud()->put($file_name,$file_data);
        return 'Document uploaded successfully.';
    }

    public function uploadImage(){
        $file_name = "bg";
        $file_path = public_path('backend/images/bg.jpg');
        $file_data = File::get($file_path);
        Storage::cloud()->put($file_name,$file_data);
        return 'Images uploaded successfully.';
    }
   
    public function uploadVideo(){
        $file_name = "";
        $file_path = public_path('frontend/images/abc.mp4');
        $file_data = File::get($file_path);
        Storage::cloud()->put($file_name,$file_data);
        return 'Video uploaded successfully.';
    }
   
    public function downloadDocument($path, $name){
        $contents = collect(Storage::cloud()->listContents('/',false))->where('type','=','file')->where('path','=',$path)->first();
        $filename_download = $name;
        $rawData = Storage::cloud()->get($path);
        return response($rawData,200)->header('Content-Type',$contents['mimetype'])->header('Content-Disposition', " attachment; filename=$filename_download ");
        return redirect()->back();
    }

    public function deleteDocument($path){
        $file_info = collect(Storage::cloud()->listContents('/',false))->where('type','file')->where('path',$path)->first();
        if(!$file_info){
            session(['message'=>'Delete document failed']);
            return redirect()->back();
        }
        Storage::cloud()->delete($file_info['path']);
        return redirect()->back();
    }

    public function listDocument(){
        $dir = "/";
        $recursive = false; // có lấy file trong thư mục con không
        $contents = collect(Storage::cloud()->listContents($dir,$recursive));
        return view('admin.document.list')->with(compact('contents'));
    }

    // public function createDocument(){
    //     Storage::cloud()->put('text.txt', 'Hello word');
    //     dd('created');
    // }   
 
    public function createDocument(){
        Storage::disk('google-second')->put('text.txt', 'Hello word');
        dd('created');
    }   

    public function createFolder(){
        Storage::cloud()->makeDirectory('document');
        dd("Created folder");
    }

    public function renameFolder(){
        $folder_info = collect(Storage::cloud()->listContents('/',false))->where('type','dir')->where('name','document')->first();
        Storage::cloud()->move($folder_info['path'],'Storage');
        dd('renamed folder');
    }

    public function deleteFolder(){
        $folder_info = collect(Storage::cloud()->listContents('/',false))->where('type','!=','dir')->where('name','Storage')->first();
        Storage::cloud()->delete($folder_info['path']);
        dd('deleted folder');
    }
}