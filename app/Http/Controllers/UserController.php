<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return redirect('/dashboard');
        }else{
            return redirect('login-auth')->send();
        }
    }    
    
    public function saveUser(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['name'];
        $admin->admin_email = $data['email'];
        $admin->admin_phone = $data['phone'];
        $admin->admin_password = md5($data['password']) ;
        $admin->roles()->attach(Roles::where('role_name','user')->first());
        $admin->save();
        session(['message'=>'Add user success']);
        return view('admin.user.create');
    }    

    public function insertUserPage(){
        $this->AuthLogin();
        return view('admin.user.create');
    }    

    public function manageUser(){
        $this->AuthLogin();
        $list_admin = Admin::with('roles')->orderBy('admin_id','ASC')->paginate(5);
        return view('admin.user.list')->with(compact('list_admin'));
    }    
    
    public function assignRoles(Request $request){
        $this->AuthLogin();
        if(Auth::id() == $request->admin_id){
            return redirect()->back()->with('message','you are not allowed to delete yourself');
        }
        $user = Admin::where('admin_email',$request->admin_email)->first();
        $user->roles()->detach();

        if($request['author_role']){
            $user->roles()->attach(Roles::where('role_name','author')->first());
        }
        if($request['admin_role']){
            $user->roles()->attach(Roles::where('role_name','admin')->first());
        }
        if($request['user_role']){
            $user->roles()->attach(Roles::where('role_name','user')->first());
        }
        return redirect()->back()->with('message','Assign role success');
    }
    
    public function deleteUser($admin_id){
        $this->AuthLogin(); 
        if(Auth::id() == $admin_id){
            return redirect()->back()->with('message','you are not allowed to delete yourself');
        }
        $admin = Admin::find($admin_id);
        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Delete Success');
    }

    public function impersonate($admin_id){
        $user = Admin::where('admin_id',$admin_id)->first();
        if($user){
            session(['impersonate' => $user->admin_id ]);
        }
        return redirect('/manage-user')->with('Impersonate success');
    }

    public function destroyImpersonate(){
        session()->forget('impersonate');
        return redirect('/manage-user');
    }
}