@extends('admin.admin_layout')
@section('admin_content')

@section('styles-custom')
<style type="text/css">
ul.drive{
    padding:10px;
}
ul.drive li {
    list-style-type: none;
    margin:2px 0;
    font-weight:300;
}
</style>

@endsection

<div class="table-agile-info">
    <?php
    $message = Session::get('message');
    if($message){
    echo '<div class="text-alert-warning text-alert align-self-center">' .$message. '</div>';
        Session::put('message' , null);    
    }
    ?>
    <div class="row">
        @foreach($contents as $key => $value)
            <div class="col-md-4">
                <ul class="drive">
                    <li>Name: {{$value['name']}}</1i>
                    <li>Path: {{$value['path']}}</li>
                    <li>Extension: {{$value['extension']}}</li>
                    <li>Basename:{{$value['basename']}}</li>
                    <li>Mimetype:{{isset($value['mimetype']) ? $value['mimetype']:"none"}}</li>
                    <li>Type: {{$value['type']}}</li>
                    <li>Size: {{$value['size']}}</1i>
                    <li>Download file: <a href="https://drive.google.com/file/d/{{$value['path']}}" target="_blank">Tải</a></li>
                    <li>Download file: <a href="{{url('download-document',['path'=> $value['path'], 'name' => $value['name']])}}" target="_blank">Tải</a></li>
                    <li>Delete: <a href="{{url('delete-document',['path'=> $value['path']])}}" target="_blank">Delete</></li>
                    <li><iframe src="https://drive.google.com/file/d/{{$value['basename']}}/preview" style="width:200px; height:200px;border:0;"></iframe></li>
                </ul>
            </div>
        @endforeach
    </div>
</div>
@endsection