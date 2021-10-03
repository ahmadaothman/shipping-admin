<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use PragmaRX\Countries\Package\Countries;
use Stevebauman\Location\Facades\Location;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request){

        $data = array();

        $regions =  Region::orderBy('id');
  
        
        $regions->skip(0)->take(2);
        
        $data['regions'] = $regions->paginate(50);
        return view("region.regionList",$data);
    }

    public function form(Request $request){
        $data = array();
 
        // $ip = file_get_contents('https://api.ipify.org');
        // $location = Location::get($ip);
         
         //$data['country_code'] = $location->countryCode;
         $data['country_code'] = 'LB';
         $countries = new Countries();
         //dd($countries->all()->toArray());
         $data['countries'] = $countries->all()->toArray();
 
         if($request->path() == 'regions/add'){
             $data['action'] = route('addRegion');
         }else if($request->path() == 'regions/edit'){
             $data['action'] = route('editRegion',['id'=>$request->get('id')]);
         }
 
         switch ($request->method()) {
             case 'POST':
 
                 $validation_data =  array();
 
               
                 if($request->path() == 'regions/add'){ // validation if add
                     $validation_data['name'] = 'required|unique:region|min:3';
                 }else{ // validation if edit
                     $validation_data['name'] = 'required|min:3';
                 }

                 $validated = $request->validate($validation_data);
 
                 // inser/edit data
                 $region_data = [
                     'name'             =>  $request->input('name'),
                     'state'            =>  $request->input('state'),
                     'shipping_cost'    =>  $request->input('shipping_cost'),
                 ];
                 
                
                 try { 
                     if($request->path() == 'regions/add'){
                         Region::insert($region_data);
                     }else if($request->path() == 'regions/edit'){
                        Region::where('id', $request->get('id'))
                         ->update($region_data);
                     }
                     
                 }catch(\Illuminate\Database\QueryException $ex){
                     dd($ex->getMessage()); 
                 }
                
                 if($request->path() == 'regions/add'){
                     return redirect('regions')->with('status', '<strong>Success:</strong> New region added!');
                 }else{
                     return redirect('regions')->with('status', '<strong>Success:</strong> Region info updated!');
                 }
 
                break;
     
             case 'GET':
                 if ($request->has('id')) {
                     $region = Region::where('id',$request->id)->first();
 
                     $data['region'] = $region;
                 }
                 // do anything in 'get request';
                 break;
     
             default:
                 // invalid request
                 break;
         }
 
         return view('region.regionForm',$data);
    }


    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                Region::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }
        return redirect('regions')->with('status', '<strong>Success:</strong> ' . $i . ' Branches Removed!');

    }
}
