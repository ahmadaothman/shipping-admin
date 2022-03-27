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
        $this->middleware('check_driver');
    }

   
    public function index()
    {
        $shipment_status = DB::select("SELECT ssg.name as status_group_name,ssg.color as color,ssg.id as id,COUNT(s.id) as count_shipments FROM shipment s
        LEFT JOIN shipment_status ss ON ss.id=s.status_id
        LEFT JOIN shipment_status_group ssg ON ssg.id=ss.shipment_status_group_id
        WHERE s.status_id!=19
        GROUP BY ssg.name,ssg.color,ssg.id");

        $awaiting_to_paid_status = Shipment::where('status_id',19)->count();


        $data = array();


        $data['awaiting_to_paind'] = array(
            'id'=>19,
            'status_group_name'=>'Awaiting to paid',
            'color'=>'',
            'count_shipments'=>$awaiting_to_paid_status
        );

        $data['statuses'] = $shipment_status;

        

        return view('home',$data);
    }

    public function getShipmentsByMonthsChart(Request $request){
        $dates = explode(" - ", $request->get('filter_date')); 

        $sql = "select count(*) as shipments_count, 
        year(`created_at`) as year, 
        month(`created_at`) as month
 from shipment WHERE created_at>='" . $dates[0] . "' AND created_at<='" . $dates[1] . "'
 group by year(`created_at`), month(`created_at`);";
        
        $results = DB::select($sql);

        $data = array();
        $data['name'] = 'Shipments';
        $data['colorByPoint'] = true;

        $arr = array();
        foreach($results as $result){
            $arr[] = array(
                'name'      =>  date('F', mktime(0, 0, 0, $result->month, 10)),
                'y'         =>  $result->shipments_count,
                'drilldown' =>  date('F', mktime(0, 0, 0, $result->month, 10))
            );
        }

        $data['data'] = $arr;
        return $data;
    }

    public function getShipmentsByRegionsChart(Request $request){
        $dates = explode(" - ", $request->get('filter_date')); 

        $sql = "select count(*) as shipments_count,customer_region as region
 from shipment WHERE created_at>='" . $dates[0] . "' AND created_at<='" . $dates[1] . "'
 group by customer_region;";
        
        $results = DB::select($sql);

        $data = array();
        $data['name'] = 'Shipments';
        $data['colorByPoint'] = true;

        $arr = array();
        foreach($results as $result){
            $arr[] = array(
                'name'      =>  $result->region,
                'y'         =>  $result->shipments_count,
                'drilldown' =>  $result->region
            );
        }

        $data['data'] = $arr;
        return $data;
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
