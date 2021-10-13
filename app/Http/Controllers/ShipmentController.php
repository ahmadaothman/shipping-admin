<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PragmaRX\Countries\Package\Countries;
use Stevebauman\Location\Facades\Location;

use App\Models\Currency;
use App\Models\ServiceType;
use App\Models\Agent;
use App\Models\PaymentMethod;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use App\Models\ShipmentStatusGroup;
use App\Models\City;


use App\Imports\ShipmentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listShipment(Request $request){
        $data = array();
        $data['agents'] =  Agent::get();
        $data['status'] =  ShipmentStatus::get();
        $data['status_groups'] = ShipmentStatusGroup::get();

        $shipments = Shipment::orderBy('id');

        
        if($request->get('filter_reference') != null){
            $shipments->where('reference','LIKE','%'.$request->get('filter_reference') .'%');
        }

        if($request->get('filter_traking_number') != null){
            $shipments->where('tracking_number','LIKE','%'.$request->get('filter_traking_number') .'%');
        }

        if($request->get('filter_date') != null){
            $datas = explode(" - ", $request->get('filter_date')); 

            $shipments->whereBetween('created_at',array($datas[0],$datas[1]));
        }

        if($request->get('filter_agent') != null){
            $shipments->whereIn('agent_id',array(explode(",",$request->get('filter_agent'))));
        }

        if($request->get('filter_status_group') != null){
            $statuses = ShipmentStatus::whereIn('shipment_status_group_id',array(explode(",",$request->get('filter_status_group'))))->pluck('id')->toArray();
            $shipments->whereIn('status_id',$statuses);
        }

        if($request->get('filter_status') != null){
            $shipments->whereIn('status_id',array(explode(",",$request->get('filter_status'))));
        }

        if($request->get('filter_name') != null){
            $shipments->where('customer_name','LIKE','%'.$request->get('filter_name') .'%');
        }

        if($request->get('filter_telephone') != null){
            $shipments->where('customer_telephone','LIKE','%'.$request->get('filter_telephone') .'%');
        }


    

        $data['shipments'] = $shipments->paginate(50);
        
        return view('shipment.shipmentlist',$data);
    }

    public function shipmentForm(Request $request){
        $data = array();
 
        try{
           /* $ip = file_get_contents('https://api.ipify.org');
            $location = Location::get($ip);*/
            
            $data['country_code'] = 'LB';
        }catch(Exception $e){
      
            $data['country_code'] = '';
        }

        $countries = new Countries();

        $data['currencies'] = Currency::get();
        $data['service_types'] = ServiceType::get();
        $data['payment_methods'] = PaymentMethod::get();
     // dd(Countries::where('cca2', 'LB')->first()->hydrateStates()->states);

        $data['countries'] = $countries->all()->toArray();

        if($request->path() == 'shipments/add'){
            $data['action'] = route('addShipment');
        }else if($request->path() == 'shipments/edit'){
            $data['action'] = route('editShipment',['id'=>$request->get('id')]);
        }

        switch ($request->method()) {
            case 'POST':

                $validation_data =  array();

                
                if($request->path() == 'shipments/add'){
                    $traking_number =  random_int(1111111111,9999999999) . (Shipment::max('id')+1);
                    $status_id = 1;
                }else if($request->path() == 'shipments/edit'){
                    $traking_number = $request->input('tracking_number');
                    $status_id = $request->input('status_id');
                }
               
                // inser/edit data
                $shipment_data = [
                    'tracking_number'           =>  $traking_number,
                    'reference'                 =>  $request->input('reference'),
                    'agent_id'                  =>  $request->input('agent_id'),
                    'status_id'                 =>  $status_id ,
                    'currency_id'               =>  $request->input('currency_id'),
                    'service_type_id'           =>  $request->input('service_type_id'),
                    'pickup_type'               =>  $request->input('pickup_type'),
                    'preferred_date'            =>  $request->input('preferred_date'),
                    'preferred_time_from'       =>  date("G:i", strtotime($request->input('preferred_time_from'))),
                    'preferred_time_to'         =>  date("G:i", strtotime($request->input('preferred_time_to'))),
                    'customer_name'             =>  $request->input('customer_name'),
                    'customer_email'            =>  $request->input('customer_email'),
                    'customer_telephone'        =>  $request->input('customer_telephone'),
                    'customer_gender'           =>  $request->input('customer_gender'),
                    'customer_country'          =>  $request->input('customer_country'),
                    'customer_state'            =>  $request->input('customer_state'),
                    'customer_region'           =>  $request->input('customer_region'),
                    'customer_city'             =>  $request->input('customer_city'),
                    'customer_building'         =>  $request->input('customer_building'),
                    'customer_floor'            =>  $request->input('customer_floor'),
                    'customer_directions'       =>  $request->input('customer_directions'),
                    'zip_code'                  =>  $request->input('zip_code'),
                    'latitude'                  =>  $request->input('latitude'),
                    'longitude'                 =>  $request->input('longitude'),
                    'amount'                    =>  $request->input('amount') ? $request->input('amount') : 0,
                    'payment_method_id'         =>  $request->input('payment_method_id'),
                    'customer_comment'          =>  $request->input('customer_comment'),
                    'agent_comment'             =>  $request->input('agent_comment'),
                    'weight'                    =>  $request->input('weight'),   

                ];
                
               
                try { 
                    if($request->path() == 'shipments/add'){
                        $id = Shipment::insertGetId($shipment_data);
                        DB::table('shipment_history')->insert([
                            'user_id'       =>  auth()->id(),
                            'shipment_id'   =>  $id,
                            'status_id'     =>  1,
                            'comment'       =>  'Pending'
                        ]);
                    }else if($request->path() == 'shipments/edit'){
                        //dd($shipment_data);
                        Shipment::where('id', $request->get('id'))
                        ->update($shipment_data);
                    
                    }
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }
               
                if($request->path() == 'shipments/add'){
                    return redirect('shipments')->with('status', '<strong>Success:</strong> New Shipment added!');
                }else{
                    return redirect('shipments')->with('status', '<strong>Success:</strong> Shipment info updated!');
                }

                break;
    
            case 'GET':
                if ($request->has('id')) {
                    $shipment = Shipment::where('id',$request->id)->first();

                    $data['shipment'] = $shipment;
                }
                break;
    
            default:
                // invalid request
                break;
        }

        return view('shipment.shipmentform',$data);
    }

    public function a4print(Request $request){
        $data = array();
        $data['shipment'] = Shipment::where('id',$request->get('id'))->first();

        return view('shipment.a4print',$data);
    }

    public function states(Request $request)
    {
        $states = Countries::where('cca2', $request->get('country'))->first()->hydrateStates()->states;

      //  dd($states);

        return response()->json($states);
    }

    public function checkAgentReferenceStatus(Request $request){
        $shipment = Shipment::where('agent_id',$request->get('agent_id'))->where('reference',$request->get('reference'))->first();

        return $shipment;
    }

    public function searchAgent(Request $request){
        $agents = Agent::where('name','like','%' . $request->get('query') . '%')->get();
        return response()->json($agents);
    }

    public function importExcel(Request $request){
       
        $shipment_import = new ShipmentImport();
        
        $file = $request->file('excelfile')->store('agents_excel_files');
        Excel::import($shipment_import,$file);

        $errors = array();

        $rows = $shipment_import->data->toArray();

        foreach($rows as $index => $row){

           if($index != 0){
            // reference
            $reference_errors = array();

            if(empty($row[0])){ 
                $reference_errors[] = 'Reference is required!';
                $errors[] = 'Reference is required!';
            }

            if($reference_errors){
                $rows[$index][0] = array(
                    'value'     =>  $rows[$index][0],
                    'errors'    =>  $reference_errors
                );
            }

            // currency
            $curreny_errors = array();
            if(empty($row[1])){ 
                $curreny_errors[] = 'Currency id is required!';
                $errors[] = 'Currency id is required!';
            }

            // validate exists currency id
            $currency = DB::select('select * from currency where id = ?', [$row[1]]);
            if(!$currency){
                $curreny_errors[] = 'Currency id does not exists!';
                $errors[] = 'Currency id does not exists!';
            }

            if($curreny_errors){
                $rows[$index][1] = array(
                    'value'     =>  $rows[$index][1],
                    'errors'    =>  $curreny_errors
                );
            }

            // service type
            $service_type_errors = array();
            if(empty($row[2])){ 
                $service_type_errors[] = 'service type id is required!';
                $errors[] = 'service type id is required!';
            }

            // validate exists service type id
            $service_type = DB::select('select * from service_type where id = ?', [$row[2]]);
            if(!$service_type){
                $service_type_errors[] = 'Service Type id does not exists!';
                $errors[] = 'Service Type id does not exists!';
            }

            if($service_type_errors){
                $rows[$index][2] = array(
                    'value'     =>  $rows[$index][2],
                    'errors'    =>  $service_type_errors
                );
            }

            // name
            $name_errors = array();

            if(strlen($row[3]) < 4){ 
                $name_errors[] = 'Name most be 4 characters at least!';
                $errors[] = 'Name most be 4 characters at least!';
            }

            if($name_errors){
                $rows[$index][3] = array(
                    'value'     =>  $rows[$index][3],
                    'errors'    =>  $name_errors
                );
            }

            // email
            $email_errors = array();

            
            if(!empty($row[4])){ 
                $validator = Validator::make(['email' => $row[4]],[
                    'email' => 'required|email'
                ]);

                if(!$validator->passes()){
                    $email_errors[] = 'Invalid Email!';
                    $errors[] = 'Invalid Email!';
                }
            }

            if($email_errors){
                $rows[$index][4] = array(
                    'value'     =>  $rows[$index][4],
                    'errors'    =>  $email_errors
                );
            }

            // telephone
            $telephone_errors = array();

            
            if(strlen($row[5]) < 7){ 
            $telephone_errors[] = 'Telephone most be equals or grater ther 7 numbers!';
            $errors[] = 'Telephone most be equals or grater ther 7 numbers!';
            }
 
            if($telephone_errors){
                $rows[$index][5] = array(
                    'value'     =>  $rows[$index][5],
                    'errors'    =>  $telephone_errors
                );
            }

            // country
            $country_errors = array();

        
            if(empty($row[7]) ){ 
            $country_errors[] = 'Country Code is required for example (LB)!';
            $errors[] = 'Country Code is required for example (LB)!';
            }

            if($country_errors){
                $rows[$index][7] = array(
                    'value'     =>  $rows[$index][7],
                    'errors'    =>  $country_errors
                );
            }

            // directions
            $directions_errors = array();

    
            if(strlen($row[13]) < 10){ 
            $directions_errors[] = 'Directions most be 10 characters as least!';
            $errors[] = 'Directions most be 10 characters as least!';
            }

            if($directions_errors){
                $rows[$index][13] = array(
                    'value'     =>  $rows[$index][13],
                    'errors'    =>  $directions_errors
                );
            }

            // zipcode
            $zipcode_errors = array();


            if(empty($row[14])){ 
                $zipcode_errors[] = 'Zip code cannot be empty!';
                $errors[] = 'Zip code cannot be empty!';
            }

            if($zipcode_errors){
                $rows[$index][14] = array(
                    'value'     =>  $rows[$index][14],
                    'errors'    =>  $zipcode_errors
                );
            }
            // amount
            if(empty($row[17])){ 
                $rows[$index][17] = 0;
            }

            // payment method
            $payment_method_errors = array();
            if(empty($row[18])){ 
                $payment_method_errors[] = 'Payment method id is required!';
                $errors[] = 'payment method id is required!';
            }

            // validate exists payment method id
            $payment_method = DB::select('select * from payment_method where id = ?', [$row[18]]);
            if(!$payment_method){
                $payment_method_errors[] = 'Payment method id does not exists!';
                $errors[] = 'payment method id does not exists!';
            }

            if($payment_method_errors){
                $rows[$index][18] = array(
                    'value'     =>  $rows[$index][18],
                    'errors'    =>  $payment_method_errors
                );
            }
             // Weight
             if(empty($row[21])){ 
                $rows[$index][21] = 1;
            }
            

            
           }



        }

        //dd($rows);
        $data['file_errors'] = $errors;
        $data['rows'] = $rows;
        $data['file_name'] = $file;

        return view('shipment.import',$data);
    }

    public function confirmExcel(Request $request){
        $file = $request->input('file_name');
    }

    public function getCitiesByRegion(Request $request){
        $cities = City::where('region','LIKE','%'.$request->get('region').'%')->get();
        return $cities;
    }

}
