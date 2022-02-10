@extends('admin_layout')
@section('admin_content')
<h1>Chào mừng bạn đén với Admin</h1>
 <?php
    $message = Session::get('message');
    if($message){
    echo '<h3 class="text-alert text-alert-warning">' .$message. '</h3>';
        Session::put('message' , null);    
    }
?>
@endsection