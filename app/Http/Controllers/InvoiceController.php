<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shipment;
use App\Models\ShipmentStatusGroup;

class InvoiceController extends Controller
{
    private $allowed_users = [1,3,6];
    public function __construct()
    {
        
        $this->middleware('auth');
       
    }

    private function user(){
       return DB::table('users')->where('id',Auth::id())->first();
    }
    public function list(Request $request){
        if(!in_array($this->user()->user_type_id,$this->allowed_users)){
         
            return view('no_permission');
        }

        $data = array();
        

        return view('invoice.list',$data);
    }

    public function generate(Request $request){
        if(!in_array($this->user()->user_type_id,$this->allowed_users)){
         
            return view('no_permission');
        }

        $data = array();
        
        $data['shipments'] = array();

        if($request->method() == "POST"){
            $data['agent'] = $request->input('agent');
            $data['agent_id'] = $request->input('agent_id');

            $shipments = Shipment::where('agent_id',$request->input('agent_id'))->get();

            $data['shipments'] = $shipments;

        }

        return view('invoice.generate',$data);
    }

    public function form(Request $request){

    }
}
