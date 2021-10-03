<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Region;

use PragmaRX\Countries\Package\Countries;
use Stevebauman\Location\Facades\Location;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request){

        $data = array();

        $cities =  City::orderBy('id');
  
        
        $cities->skip(0)->take(2);
        
        $data['cities'] = $cities->paginate(100);
        return view("city.cityList",$data);
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
 
         if($request->path() == 'cities/add'){
             $data['action'] = route('addCity');
         }else if($request->path() == 'cities/edit'){
             $data['action'] = route('editCity',['id'=>$request->get('id')]);
         }
 
         switch ($request->method()) {
             case 'POST':
 
                 $validation_data =  array();
 
               
                 if($request->path() == 'cities/add'){ // validation if add
                     $validation_data['name'] = 'required|unique:city|min:3';
                 }else{ // validation if edit
                     $validation_data['name'] = 'required|min:3';
                 }

                 $validated = $request->validate($validation_data);
 
                 // inser/edit data
                 $city_data = [
                     'name'             =>  $request->input('name'),
                     'region'            =>  $request->input('region'),
                 ];
                 
                
                 try { 
                     if($request->path() == 'cities/add'){
                         City::insert($city_data);
                     }else if($request->path() == 'cities/edit'){
                        City::where('id', $request->get('id'))
                         ->update($city_data);
                     }
                     
                 }catch(\Illuminate\Database\QueryException $ex){
                     dd($ex->getMessage()); 
                 }
                
                 if($request->path() == 'cities/add'){
                     return redirect('cities')->with('status', '<strong>Success:</strong> New city added!');
                 }else{
                     return redirect('cities')->with('status', '<strong>Success:</strong> City info updated!');
                 }
 
                break;
     
             case 'GET':
                 if ($request->has('id')) {
                    $city = City::where('id',$request->id)->first();
                     
                    $region = Region::where('name','LIKE','%'.$city->region.'%')->first();
                  
                 

                    $data['state'] = isset($region->state) ? $region->state : '';
                    $data['city'] = $city;
                 }
                 // do anything in 'get request';
                 break;
     
             default:
                 // invalid request
                 break;
         }
 
         return view('city.cityForm',$data);
    }


    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                City::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }

        return redirect('cities')->with('status', '<strong>Success:</strong> ' . $i . ' Cities Removed!');

    }

    public function regionBySate(Request $request){
        $regions = Region::where('state',$request->get('state'))->get();
        return $regions;
    }
}
