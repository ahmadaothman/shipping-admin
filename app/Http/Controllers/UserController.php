<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userList(Request $request){

       if(!$request->get('user_type_id') ){
            return redirect('/');
        }

        $data = array();

        $user_type = Usertype::where('id',$request->get('user_type_id'))->first();

        $data['user_type'] = $user_type['name'];
        $data['branches'] = Branch::get();

        $users =  User::orderBy('id');
        
        $users->where('user_type_id',$request->get('user_type_id'));
    
      
        if($request->get('filter_name')){
            $users->where('name', 'LIKE','%' . $request->get('filter_name') . '%');
        }

        if($request->get('filter_telephone')){
            $users->where('telephone', 'LIKE','%' . $request->get('filter_telephone') . '%');
        }

        if($request->get('filter_email')){
            $users->where('email', $request->get('filter_email'));
        }

        if($request->get('filter_branch') || $request->get('filter_branch') == "0"){
            $users->where('branch_id', $request->get('filter_branch'));
        }

        if($request->get('filter_status') || $request->get('filter_status') == "0"){
            $users->where('status', $request->get('filter_status'));
        }


        $data['users'] = $users->paginate(50);

        return view("user.userlist",$data);
    }

    public function userForm(Request $request){
       if(!$request->get('user_type_id') ){
            return redirect('/');
        }

        $data = array();


        $data['branches'] = Branch::get();

        if($request->path() == 'users/add'){
            $data['action'] = route('addUser',['user_type_id'=>$request->get('user_type_id')]);
        }else if($request->path() == 'users/edit'){
            $data['action'] = route('editUser',['id'=>$request->get('id'),'user_type_id'=>$request->get('user_type_id')]);
        }

        switch ($request->method()) {
            case 'POST':

                $validation_data =  array();

                // validation data if add or edit and not empty
                if($request->path() == 'users/add' || ($request->path() == 'users/edit' && !empty($request->input('password')))){
                    $validation_data['password'] = 'required|min:8';
                    
                }

                if($request->path() == 'users/add'){ // validation if add
                    $validation_data['name'] = 'required|unique:users|min:3';
                    $validation_data['email'] = 'required|unique:users|email';
                    $validation_data['telephone'] = 'required|unique:users|min:6';
                }else{ // validation if edit
                    $validation_data['name'] = 'required|min:3';
                    $validation_data['email'] = 'required|email';
                    $validation_data['telephone'] = 'required|min:6';
                }

                $validated = $request->validate($validation_data);

                // inser/edit data
                $user_data = [
                    'name'          =>  $request->input('name'),
                    'telephone'     =>  $request->input('telephone'),
                    'email'         =>  $request->input('email'),
                    'branch_id'     =>  $request->input('branch'),
                    'user_type_id'  =>  $request->get('user_type_id'),
                    'status'        =>  $request->input('status'),
                    'updated_at'    =>   now()
                ];

                if(!empty($request->input('password'))){
                    $user_data['password']  = Hash::make($request->input('password'));
                }
                
               
                try { 
                    if($request->path() == 'users/add'){
                        User::insert($user_data);
                    }else if($request->path() == 'users/edit'){
                        User::where('id', $request->get('id'))
                        ->update($user_data);
                    }
                    
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }

                if($request->path() == 'users/add'){
                    return redirect(route('users',['user_type_id'=>$request->get('user_type_id')]))->with('status', '<strong>Success:</strong> New user added!');
                }else{
                    return redirect(route('users',['user_type_id'=>$request->get('user_type_id')]))->with('status', '<strong>Success:</strong> User Info Updated!');
                }
                break;
    
            case 'GET':
                if ($request->has('id')) {
                    $user = User::where('id',$request->id)->first();
                    unset($user->password);
                    $data['user'] = $user;
                }
                // do anything in 'get request';
                break;
    
            default:
                // invalid request
                break;
        }

        return view('user.userfrom',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                User::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }
        return redirect('users')->with('status', '<strong>Success:</strong> ' . $i . 'Users Removed!');

    }

}
