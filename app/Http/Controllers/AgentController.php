<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Countries\Package\Countries;

use Stevebauman\Location\Facades\Location;


class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function agentList(Request $request){

        $data = array();

        $agents =  Agent::orderBy('sort_order');
  
    
      
        if($request->get('filter_name')){
            $agents->where('name', 'LIKE','%' . $request->get('filter_name') . '%');
        }
        if($request->get('filter_telephone')){
            $agents->where('telephone', 'LIKE','%' . $request->get('filter_telephone') . '%');
        }
        if($request->get('filter_email')){
            $agents->where('email', $request->get('filter_email'));
        }
        if($request->get('filter_status') || $request->get('filter_status') == "0"){
            $agents->where('status', $request->get('filter_status'));
        }


        $data['agents'] = $agents->paginate(30);

        return view("agent.agentlist",$data);
    }

    public function agentForm(Request $request){

        $data = array();
 
        $ip = file_get_contents('https://api.ipify.org');
        $location = Location::get($ip);
        
        $data['country_code'] = $location->countryCode;
        $countries = new Countries();
        //dd($countries->all()->toArray());
        $data['countries'] = $countries->all()->toArray();

        if($request->path() == 'agents/add'){
            $data['action'] = route('addAgent');
        }else if($request->path() == 'agents/edit'){
            $data['action'] = route('editAgent',['id'=>$request->get('id')]);
        }

        switch ($request->method()) {
            case 'POST':

                $validation_data =  array();

                // validation data if add or edit and not empty
                if($request->path() == 'agents/add' || ($request->path() == 'agents/edit' && !empty($request->input('password')))){
                    $validation_data['password'] = 'required|min:8';
                    
                }

                if($request->path() == 'agents/add'){ // validation if add
                    $validation_data['name'] = 'required|unique:agent|min:3';
                    $validation_data['email'] = 'required|unique:agent|email';
                    $validation_data['telephone'] = 'required|unique:agent';
                }else{ // validation if edit
                    $validation_data['name'] = 'required|min:3';
                    $validation_data['email'] = 'required|email';
                    $validation_data['telephone'] = 'required';
                }

                $validated = $request->validate($validation_data);

                // inser/edit data
                $agent_data = [
                    'name'          =>  $request->input('name'),
                    'telephone'     =>  $request->input('telephone'),
                    'email'         =>  $request->input('email'),
                    'website'       =>  $request->input('website'),
                    'country'       =>  $request->input('country'),
                    'address'       =>  $request->input('address'),
                    'status'        =>  $request->input('status'),
                    'sort_order'    =>  $request->input('sort_order'),
                    'updated_at'    =>   now()
                ];

                if(!empty($request->input('password'))){
                    $agent_data['password']  = Hash::make($request->input('password'));
                }
                
               
                try { 
                    if($request->path() == 'agents/add'){
                        Agent::insert($agent_data);
                    }else if($request->path() == 'agents/edit'){
                        Agent::where('id', $request->get('id'))
                        ->update($agent_data);
                    }
                    
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }

                if($request->path() == 'agents/add'){
                    return redirect('/agents')->with('status', '<strong>Success:</strong> New agent added!');
                }else{
                    return redirect('/agents')->with('status', '<strong>Success:</strong> Agent Info Updated!');
                }
                break;
    
            case 'GET':
                if ($request->has('id')) {
                    $agent = Agent::where('id',$request->id)->first();
                    unset($agent->password);
                    $data['agent'] = $agent;
                }
                // do anything in 'get request';
                break;
    
            default:
                // invalid request
                break;
        }

        return view('agent.agentfrom',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                Agent::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }
        return redirect('agents')->with('status', '<strong>Success:</strong> ' . $i . ' Agents Removed!');

    }

    public function search(Request $request){
        $agents = Agent::where('name','LIKE','%' . $request->get('query') . '%')->where('status',1)->get();
        return $agents;
    }
   
}
