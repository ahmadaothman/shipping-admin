<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Countries\Package\Countries;
use Stevebauman\Location\Facades\Location;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function branchList(Request $request){

        $data = array();

        $branches =  Branch::orderBy('id');
  
    
      
        if($request->get('filter_name')){
            $branches->where('name', 'LIKE','%' . $request->get('filter_name') . '%');
        }

        if($request->get('filter_country')){
            $branches->where('country', 'LIKE','%' . $request->get('filter_country') . '%');
        }

        if($request->get('filter_city')){
            $branches->where('city', 'LIKE','%' . $request->get('filter_city') . '%');
        }

        if($request->get('filter_address')){
            $branches->where('address', 'LIKE','%' . $request->get('filter_address') . '%');
        }

        if($request->get('filter_telephone')){
            $branches->where('telephone', 'LIKE','%' . $request->get('filter_telephone') . '%');
        }
        
        $branches->skip(0)->take(2);
        
        $data['branches'] = $branches->paginate(30);

        $countries = new Countries();
        //dd($countries->all()->toArray());
        $data['countries'] = $countries->all()->toArray();

        return view("branch.branchlist",$data);
    }

    public function branchForm(Request $request){

        $data = array();
 
       // $ip = file_get_contents('https://api.ipify.org');
       // $location = Location::get($ip);
        
        //$data['country_code'] = $location->countryCode;
        $data['country_code'] = 'LB';
        $countries = new Countries();
        //dd($countries->all()->toArray());
        $data['countries'] = $countries->all()->toArray();

        if($request->path() == 'branches/add'){
            $data['action'] = route('addBranch');
        }else if($request->path() == 'branches/edit'){
            $data['action'] = route('editBranch',['id'=>$request->get('id')]);
        }

        switch ($request->method()) {
            case 'POST':

                $validation_data =  array();

              
                if($request->path() == 'branches/add'){ // validation if add
                    $validation_data['name'] = 'required|unique:branch|min:3';
                    $validation_data['telephone'] = 'required|unique:branch|min:6';
                }else{ // validation if edit
                    $validation_data['name'] = 'required|min:3';
                    $validation_data['telephone'] = 'required|min:6';
                }

                $validation_data['country'] = 'required';
                $validation_data['city'] = 'required';
             

                $validated = $request->validate($validation_data);

                // inser/edit data
                $branch_data = [
                    'name'          =>  $request->input('name'),
                    'country'       =>  $request->input('country'),
                    'city'          =>  $request->input('city'),
                    'address'       =>  $request->input('address'),
                    'telephone'     =>  $request->input('telephone'),
                    'updated_at'    =>   now()
                ];
                
               
                try { 
                    if($request->path() == 'branches/add'){
                        Branch::insert($branch_data);
                    }else if($request->path() == 'branches/edit'){
                        Branch::where('id', $request->get('id'))
                        ->update($branch_data);
                    }
                    
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }
               
                if($request->path() == 'branches/add'){
                    return redirect('branches')->with('status', '<strong>Success:</strong> New branch added!');
                }else{
                    return redirect('branches')->with('status', '<strong>Success:</strong> Branch info updated!');
                }

                break;
    
            case 'GET':
                if ($request->has('id')) {
                    $branch = Branch::where('id',$request->id)->first();

                    $data['branch'] = $branch;
                }
                // do anything in 'get request';
                break;
    
            default:
                // invalid request
                break;
        }

        return view('branch.branchform',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                Branch::where('id', $id)->where('id','!=',1)->delete($id);
    
                $i = $i +1;
            }
        }
        return redirect('branches')->with('status', '<strong>Success:</strong> ' . $i . ' Branches Removed!');

    }
}
