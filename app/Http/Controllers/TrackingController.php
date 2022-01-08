<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\ShipmentHistory;

class TrackingController extends Controller
{
    public function index(Request $request){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        
        $shipment = Shipment::where('tracking_number',$request->get('tracking_number'))->first();
        $shipment_history = ShipmentHistory::where('shipment_id',$shipment->id)->get();
        
        $data = array();
        $data['shipment'] = $shipment;
        $data['history'] = $shipment_history;

        return $data;
    }
}
