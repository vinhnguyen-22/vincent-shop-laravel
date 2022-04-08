@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Information
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{url('/save-info')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-lg-12">
                            <label for="information">Information</label>
                            <textarea id="information-contact" class="form-control" name="information" required></textarea extarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="map">Map</label>
                            <textarea id="map-contact" class="form-control" name="map" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="fanpage">Fanpage</label>
                            <textarea id="fanpage-contact" class="form-control" name="fanpage" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="logo">Logo website</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Enter image product">
                        </div>

                        <div  class="col-lg-12">
                           <button type="submit" name="add" class="btn btn-info">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection