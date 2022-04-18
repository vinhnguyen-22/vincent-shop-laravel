@extends('admin.admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Slider
            </header>
            <?php
                $message = Session::get('message');
                if($message){
                echo '<div class="text-alert text-alert-success">' .$message. '</div>';
                    Session::put('message' , null);    
                }
            ?>
            <div class="panel-body">
                <div class="position-center row">
                    <form role="form" action="{{url('/update-info/'.$edit_info->info_id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-lg-12">
                            <label for="information">Information</label>
                            <textarea id="information-contact" class="form-control" name="information" required>{{$edit_info->info_contact}}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="map">Map</label>
                            <textarea id="map-contact" class="form-control" name="map" required>{{$edit_info->info_map}}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="fanpage">Fanpage</label>
                            <textarea id="fanpage-contact" class="form-control" name="fanpage" required>{{$edit_info->info_fanpage}}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="logo">Logo website</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Enter image product">
                        </div>
                        
                        <div class="col-lg-12">
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    CKEDITOR.replace('information-contact');    
</script>
@endsection