<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use App\Models\ShipmentStatus;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        
        $shipments = Shipment::where('driver_id',auth()->user()->id)->whereIn('status_id',[18,9,10,11,12]);
        
        $colors = array();
        $colors['18'] = 'bg-success';
        $colors['10'] = 'bg-warning';
        $colors['11'] = 'bg-warning';
        $colors['12'] = 'bg-warning';

        $data = array();
        $data['shipments'] = $shipments->get();
        $data['colors'] = $colors;
        
        return view('driver.shipments',$data);
    }

    public function changeStatus(Request $request){
    
        $shipment_status = ShipmentStatus::where('id',$request->get('status_id'))->first();

        $shipment_status_name = $shipment_status->name;
        $shipment_status_id = $request->get('status_id');
        $shipment_id =  $request->get('shipment_id');

        DB::table('shipment_history')->insert(
            [
                'user_id'       => Auth::id(),
                'shipment_id'   => $shipment_id,
                'status_id'     => $shipment_status_id,
                'comment'       => $shipment_status_name
            ]
        );

        Shipment::where('id',$shipment_id)->update(['status_id'=>$shipment_status_id]);
    }

}
