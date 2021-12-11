<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use App\Models\Shipment;
use App\Models\ShipmentStatusGroup;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {
        $shipment_status = DB::select("SELECT ssg.name as status_group_name,ssg.color as color,ssg.id as id,COUNT(s.id) as count_shipments FROM shipment s
        LEFT JOIN shipment_status ss ON ss.id=s.status_id
        LEFT JOIN shipment_status_group ssg ON ssg.id=ss.shipment_status_group_id
        GROUP BY ssg.name,ssg.color,ssg.id");
     
        $data = array();

        $data['statuses'] = $shipment_status;

        return view('home',$data);
    }

    public function statistics(){
        $countries = new Countries();
       // dd($countries->all());
       /* $countries = $countries->where('cca3', 'LBN')
        ->first();

        dd($countries);*/
        return view('statistics');
    }

    
}
