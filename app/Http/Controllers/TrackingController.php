<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\ShipmentHistory;

class TrackingController extends Controller
{
    public function index(Request $request){
        $data = array();

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
        if($shipment){
            $shipment_history = ShipmentHistory::where('shipment_id',$shipment->id)->get();
        
            $data['success'] = true;
            $data['shipment'] = $shipment;
            $data['amount'] = $shipment->FormatedAmount;
            $data['currency_right'] = $shipment->Currency->right_symbole;
            $data['currency_left'] = $shipment->Currency->left_symbole;
            $data['history'] = $shipment_history;
    
            return $data;
        }else{
            $data['success'] = false;
            $data['message'] = 'Shipment not found!';
            return $data;
        }
     
    }
}
