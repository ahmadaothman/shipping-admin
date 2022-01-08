<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\ShipmentHistory;

class TrackingController extends Controller
{
    public function index(Request $request){
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Headers: Authorization,content-type');
                header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
            }
            exit;
        }
        header('Access-Control-Allow-Origin: *');
        
        header('Access-Control-Allow-Headers: content-type,authorization');
        header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
        
        $shipment = Shipment::where('tracking_number',$request->get('tracking_number'))->first();
        $shipment_history = ShipmentHistory::where('shipment_id',$shipment->id)->get();
        
        $data = array();
        $data['shipment'] = $shipment;
        $data['history'] = $shipment_history;

        return $data;
    }
}
