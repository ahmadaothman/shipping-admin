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
use App\Models\User;
use App\Models\Setting;

use App\Imports\ShipmentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade;

use Illuminate\Support\Facades\Mail;

class ShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_driver');
    }

    public function listShipment(Request $request){

        $data = array();
        if($request->method() == "POST"){
           if($request->input('selected') != null){
            foreach($request->input('selected') as $id){
                Shipment::where('id',$id)->update([
                    'status_id'     =>  $request->input('shipment_status'),
                    'driver_id'        =>  $request->input('drivers'),
                    'updated_at'     =>  date("Y-m-d H:i:s")
                ]);
                $shipment_status = ShipmentStatus::where('id',$request->input('shipment_status'))->first();

                DB::table('shipment_history')->insert(
                    [
                        'user_id'       => Auth::id(),
                        'shipment_id'   => $id,
                        'status_id'     => $request->input('shipment_status'),
                        'comment'       => $shipment_status->name
                    ]
                );
            }
           }
        }

        $data['agents'] =  Agent::get();
        $data['status'] =  ShipmentStatus::get();
        $data['status_groups'] = ShipmentStatusGroup::get();
        $data['shipment_status'] = DB::table('shipment_status')
        ->whereIn('id',[1,5,6,8,9,10,11,12,16,17,25,26,27])
        ->get();

        $data['message_text'] = Setting::where('setting','message_text')->first()->value;
        $data['email_text'] = Setting::where('setting','email_text')->first()->value;


        $data['drivers'] = User::where('user_type_id',7)->where('status',1)->get();

        $countries = new Countries();

        $data['countries'] = $countries->all()->toArray();

        $shipments = Shipment::orderBy('id','DESC');

        
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
            $shipments->whereIn('agent_id',explode(",",$request->get('filter_agent')));
        }

        if($request->get('filter_status_group') != null){
            $statuses = ShipmentStatus::whereIn('shipment_status_group_id',explode(",",$request->get('filter_status_group')))->pluck('id')->toArray();
            $shipments->whereIn('status_id',$statuses);
            $shipments->where('status_id','!=',19);
        }

        if($request->get('filter_status') != null){
            $shipments->whereIn('status_id',explode(",",$request->get('filter_status')));
        }

        if($request->get('filter_name') != null){
            $shipments->where('customer_name','LIKE','%'.$request->get('filter_name') .'%');
        }

        if($request->get('filter_telephone') != null){
            $shipments->where('customer_telephone','LIKE','%'.$request->get('filter_telephone') .'%');
        }


        if($request->get('filter_country') != null){
            $shipments->where('customer_country','LIKE','%'.$request->get('filter_country') .'%');
        }

        if($request->get('filter_state') != null){
            $shipments->where('customer_state','LIKE','%'.$request->get('filter_state') .'%');
        }

        if($request->get('filter_region') != null){
            $shipments->whereIn('customer_region',explode(",",$request->get('filter_region')));
        }

        if($request->get('filter_city') != null){
            $shipments->whereIn('customer_city',explode(",",$request->get('filter_city')));
        }
    
        if($request->get('filter_pickup_type') != null){
            $shipments->where('pickup_type','LIKE','%'.$request->get('filter_pickup_type') .'%');
        }

        if($request->get('filter_driver') != null){
            $shipments->where('driver_id','LIKE','%'.$request->get('filter_driver') .'%');
        }
    

      

        $data['shipments'] = $shipments->paginate(15);
        if($request->get('manifest') != null){
            $arr = array();

            $arr['shipments'] = $data['shipments'];

            return view('shipment.manifest',$data);
        }
        
        return view('shipment.shipmentlist',$data);
    }

    public function shipmentForm(Request $request){
        $data = array();
 
        $data['user'] = User::where('id',Auth::id())->first();
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
            $data['action'] = route('addShipment',$request->all());
            $data['id'] = "";
        }else if($request->path() == 'shipments/edit'){
            $data['action'] = route('editShipment', array_merge($request->all(),['id'=>$request->get('id')]) );
            $data['id'] = $request->get('id');
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
                    'reference'                 =>  $request->input('reference') ? $request->input('reference')  : $traking_number,
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
                    'shipping_cos_col'           =>  $request->input('shipping_cos_col'),
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
                    return redirect(route('shipments',$request->all()))->with('status', '<strong>Success:</strong> New Shipment added!');
                }else{
                    return redirect(route('shipments',$request->all()))->with('status', '<strong>Success:</strong> Shipment info updated!');
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

    public function cancel(Request $request){
       // dd($request->input('shipment_id'));
        Shipment::where('id',$request->input('shipment_id'))->update(['status_id'=>16]);

        DB::table('shipment_history')->insert([
            'user_id'       =>  Auth::id(),
            'shipment_id'   =>  $request->input('shipment_id'),
            'status_id'     =>  16,
            'comment'       =>  'Shipment Cancelled' 
        ]);

    }

    public function removeShipment(Request $request){

       // Shipment::where('id',$request->input('shipment_id'))->delete();
        return redirect(route('shipments',$request->all()))->with('status', '<strong>Success:</strong> Shipment removed!');

    }

    public function labelPrint(Request $request){
      
        $data = array();
        $data['shipment'] = Shipment::where('id',$request->get('id'))->first();

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate("https://kg-sl.com/tracking.html?tracking_number=".$data['shipment']->tracking_number));

        
        $data['qrcode'] = $qrcode;

        $customPaper = array(0,0,164.4,113.4);

        $dompdf = new Dompdf();
      
        $dompdf->loadHtml(view('shipment.labelPrint',$data));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($customPaper);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('filename.pdf', array("Attachment" => false));
        

        return view('shipment.labelPrint',$data);
    }

    public function emailShipments(Request $request){

        if($request->method() == "POST"){
            if($request->input('selected')){
                foreach($request->input('selected') as $id){

                    $shipment = Shipment::where('id',$id)->first();
                    $agent = Agent::where('id',$shipment->agent_id)->first();

                    $email = $agent->email;
                    
                    $email_content = $request->input('content');

                    $data = array();

                    $data['content'] = $email_content;
                    $data['email'] = $email;
                    Mail::send('email.template', $data, function (\Illuminate\Mail\Message $message) use ($data)
                    {
                        /* "Required" (It's self explaining ;)) */
                        $message->to($data['email'], 'Customer');
                        
                        $message->subject('Shipment');
                    } );
                }
            }
        }


        return view('email.template',$data);
    }

    public function smsShipments(Request $request){
        $sms_content = $request->input('content');
      
        if($request->method() == "POST"){
            if($request->input('selected')){
                $numbers_array = array();
                foreach($request->input('selected') as $id){

                    $shipment = Shipment::where('id',$id)->first();
                    

                    $data = array();

                    $data['content'] = $sms_content;
                    $data['telephone'] = $shipment->customer_telephone;
                  
                    $numbers_array[] = $shipment->customer_telephone;
                 
                }
                $this->send_sms($numbers_array,$sms_content,$this->contains_arabic($sms_content));
            }
        }
    }

    public	function valide_code($numb){
            
        // 961 
        $v_3 = substr($numb, 0, 3); 
        $v_3i = substr($numb, 3);
        
        // +961 , 0961 , 9610
        $v_4 = substr($numb, 0, 4); 
        $v_4i = substr($numb, 4);
        
        //00961, +9610, 09610  
        $v_5 = substr($numb, 0, 5);
        $v_5i = substr($numb, 5);
        
        //009610 
        $v_6 = substr($numb, 0, 6);
        $v_6i = substr($numb, 6);
        
        
        if(	$v_6 == "009610" ) {
            return $this->valide_city($v_6i);
        }
        
        if(	$v_5 == "00961" or $v_5 == "+9610" or $v_5 == "09610" ) {
            return $this->valide_city($v_5i);
            
        }		
            
        if(	$v_4 == "+961" or $v_4 == "0961" or $v_4 == "9610"  ) {
            return $this->valide_city($v_4i);
        }
        
        if(	$v_3 == "961" ) {
            return $this->valide_city($v_3i);		
        }

        return false; 
            
    }

    public	function valide_city($numb){
			
		// iza el ra2m aw fadlet el 961 8 a7rof f7as iza 03 aw la2 
		if(  strlen($numb) == 8  ){
			$v_2 = substr($numb, 0, 2);
			
			if( $v_2 == "03" ){
				return substr($numb, 1);
			}
			
			if( $v_2 == "70" or $v_2 == "71"  or $v_2 == "76" or $v_2 == "78" or $v_2 == "80" or $v_2 == "81" or $v_2 == "79"  ){
				return $numb;
			}
		}
		// iza el 03 maktoub deghri aw maktoub sa7 ba3d el 961 deghri 3
		else if(  strlen($numb) == 7  ){
			$v_1 = substr($numb,0,1);
			
			if( $v_1 == "3" ){
				return $numb;
			}	
		}
		
	}

    public	function validateSMS($numb){
		$numb = str_replace("/","",$numb);
		$numb = str_replace(" ","",$numb);
		$numb = preg_replace("[^0-9+]", "", $numb );
		 
		
		if ( strlen($numb) > 8 ){
			$pointer = $this->valide_code($numb);
			if( $pointer != false and $pointer != ""){
				return "961".$this->valide_code($numb);
			} 	
		}	
		
		if ( strlen($numb) <= 8 ){
			$pointer = $this->valide_city($numb);
			if( $pointer !="" ){
				return "961".$pointer;		
			}
		}
		
	}

    public function send_sms ($numbers_array, $msg,$unicode = false){
		
		$receivers = array();
		
		foreach($numbers_array as $number){
			$number = $this->validateSMS($number);
			if($number != ""){
				array_push($receivers,$number);
			}
		}	
		
		if(count($receivers) > 0){
			
			$receivers = implode(",", $receivers);
			
			$link = "http://sms.smartdevision.com/vendorsms/pushsms.aspx?";
			$link .= "user=kgsl";
			$link .= "&password=kgsl@1234";
			$link .= "&msisdn=".$receivers;
			$link .= "&sid=KGSL";
			$link .= "&msg=".urlencode($msg);
			$link .= "&fl=0";

            if($unicode){
                $link .= '&dc=8';
            }
			
			
			
			$curl = curl_init();
					
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => $link,
			    CURLOPT_USERAGENT => 'ishtari',
			    CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_TIMEOUT_MS => 100,
				CURLOPT_HEADER	=> 0,
				CURLOPT_RETURNTRANSFER	=> false,
				CURLOPT_FORBID_REUSE	=> true,
				CURLOPT_CONNECTTIMEOUT	=> 1,
				CURLOPT_DNS_CACHE_TIMEOUT => 10,
				CURLOPT_FRESH_CONNECT	=> true
			));
			
			$resp = curl_exec($curl);
			
			
			
			curl_close($curl);	
		}
	}

    function contains_arabic($string)
    {
        return (preg_match('/\p{Arabic}/u', $string) > 0);
    }
}
