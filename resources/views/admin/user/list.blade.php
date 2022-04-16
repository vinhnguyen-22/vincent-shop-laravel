@extends('admin.admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        List User
        </div>
        <?php
            $message = Session::get('message');
            if($message){
            echo '<div class="text-alert-success text-alert align-self-center">' .$message. '</div>';
                Session::put('message' , null);    
            }
        ?>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                <select class="input-sm form-control w-sm inline v-middle">
                <option value="0">Bulk action</option>
                <option value="1">Delete selected</option>
                <option value="2">Bulk edit</option>
                <option value="3">Export</option>
                </select>
                <button class="btn btn-sm btn-default">Apply</button>                
            </div>
           
            <div class="col-sm-4"></div>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th style="width:20px;">
                    <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                    </label>
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Author</th>
                    <th>Admin</th>
                    <th>User</th>
                    <th style="width:250px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($list_admin as $key => $user)
                <form action="{{url('/assign-roles')}}" method="POST">
                    @csrf
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td> 
                        <td>{{$user->admin_name}}</td>
                        <td>{{$user->admin_email}} 
                            <input type="hidden" name="admin_email" value="{{$user->admin_email }}" />
                            <input type="hidden" name="admin_id" value="{{$user->admin_id }}" /></td>
                        <td>{{$user->admin_phone}}</td>
                        <td><input type="checkbox" name="author_role" {{$user->hasRole('author') ? 'checked' : ''}} id=""></td>
                        <td><input type="checkbox" name="admin_role" {{$user->hasRole('admin') ? 'checked' : ''}} id=""></td>
                        <td><input type="checkbox" name="user_role" {{$user->hasRole('user') ? 'checked' : ''}} id=""></td>
                        <td>
                            <input type="submit" value="Assign roles" class="btn btn-sm btn-primary">
                            <a class="btn btn-sm btn-danger" href="{{url('/delete-user/'.$user->admin_id)}}" onclick="return confirm('Are you sure you want to delete this user?')">
                                Delete
                                <i class="fa fa-trash text-default text"></i>
                            </a>
                            <a class="btn btn-sm btn-default" href="{{url('/impersonate/'.$user->admin_id)}}">
                                Login
                                <i class="fa fa-right-to-bracket text-default text"></i>
                            </a>
                        </td>
                    </tr>
                </form>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            {{ $list_admin->links() }}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection