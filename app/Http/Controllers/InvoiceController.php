<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shipment;
use App\Models\ShipmentStatusGroup;
use App\Models\Agent;
use App\Models\Invoice;
use App\Models\InvoiceShipments;
use App\Models\User;

class InvoiceController extends Controller
{
    private $allowed_users = [1,3,6];
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('check_driver');
    }

    private function user(){
       return DB::table('users')->where('id',Auth::id())->first();
    }

    public function list(Request $request){
        if(!in_array($this->user()->user_type_id,$this->allowed_users)){
         
            return view('no_permission');
        }

      

        $data = array();

        $data['agents'] =  Agent::get();
        $data['status'] = array(
            [
                'id'    =>'1',
                'name'  => 'Unpaid'
            ],
            [
                'id'    =>'2',
                'name'  => 'Paid'
            ]
        );

        $invoices =  Invoice::orderBy('id');

        if($request->get('filter_agent') != null){
            $invoices->whereIn('agent_id',explode(",",$request->get('filter_agent')));
        }

        if($request->get('filter_status') != null){
            $invoices->whereIn('status_id',explode(",",$request->get('filter_status')));
        }

        if($request->get('filter_date') != null){
            $datas = explode(" - ", $request->get('filter_date')); 

            $invoices->whereBetween('created_at',array($datas[0],$datas[1]));
        }
  
        $invoices->skip(0)->take(2);
        
        $data['invoices'] = $invoices->paginate(50);
 

        return view('invoice.list',$data);
    }

    public function generate(Request $request){

        if(!in_array($this->user()->user_type_id,$this->allowed_users)){
         
            return view('no_permission');
        }

        $data = array();
        
        $data['shipments'] = array();

        if($request->get('agent_id')){
            $agent = Agent::where('id',$request->get('agent_id'))->first();
            $data['agent'] = $agent->name;
            $data['agent_id'] = $agent->id;

            $shipments = Shipment::where('agent_id',$request->get('agent_id'))
            ->whereIn('status_id',array(17,18,19))
  
            ->get();

            $data['shipments'] = $shipments;

        }

        if($request->method() == 'POST'){
            if($request->input('selected')){
                $shipping_costs = $request->input('shipments')['shipping_cost'];
                $weight_fees = $request->input('shipments')['weight_fees'];
                $service_fees = $request->input('shipments')['service_fees'];
                $comments = $request->input('shipments')['comment'];

                $total = 0;
                foreach($request->input('selected') as $id){
                    $total = $total + ($shipping_costs[$id] + $weight_fees[$id] + $service_fees[$id]);
                }

                $invoice_id = Invoice::insertGetId([
                    'agent_id'  =>  $request->input('agent_id'),
                    'status_id' =>  1,
                    'comment'   =>  $request->input('comment') ? $request->input('comment') : '',
                    'total'     =>  $total
                ]);

                foreach($request->input('selected') as $id){
                    $shipment = Shipment::where('id',$id)->first();
    
                    InvoiceShipments::insert([
                        'invoice_id'            =>  $invoice_id,
                        'shipment_id'           =>  $id,
                        'total'                 =>  $shipment->amount,
                        'shipping_cost'         =>  $shipping_costs[$id],
                        'weight_fees'           =>  $weight_fees[$id],
                        'service_fees'          =>  $service_fees[$id],
                        'due_amount'            =>  0,
                        'comment'               =>  $comments[$id] ? $comments[$id] : '',
    
                    ]);
    
                    Shipment::where('id',$id)->update(['status_id'=>19]);
                }
             
                return redirect('invoices')->with('status', 'Success: new invoice generated!');
            }else{
                $data['error'] = 'Please select one shipment at least!';
            }

          
        }

        return view('invoice.generate',$data);
    }

    public function form(Request $request){
        $data = array();

        $data['user'] = User::where('id',Auth::id())->first();
     
        $invoice = Invoice::where('id',$request->get('id'))->first();
        $shipments = InvoiceShipments::where('invoice_id',$request->get('id'))->get();
        
        $data['shipments'] = $shipments;
        $data['invoice'] = $invoice;

        if($request->method() == 'POST'){
            if($request->input('selected')){
                $shipping_costs = $request->input('shipments')['shipping_cost'];
                $weight_fees = $request->input('shipments')['weight_fees'];
                $service_fees = $request->input('shipments')['service_fees'];
                $comments = $request->input('shipments')['comment'];

                $total = 0;
                foreach($request->input('selected') as $id){
                    $total = $total + ($shipping_costs[$id] + $weight_fees[$id] + $service_fees[$id]);
                }


                $invoice_id = $request->input('invoice_id');

                Invoice::where('id',$invoice_id)->update(['total'=>$total,'comment'=>$request->input('comment') ? $request->input('comment') : " ","extra_fees"=>$request->input('extra_fees')]);

                InvoiceShipments::where('invoice_id', $invoice_id)->delete();

                foreach($request->input('selected') as $id){
                    $shipment = Shipment::where('id',$id)->first();
    
                    InvoiceShipments::insert([
                        'invoice_id'            =>  $invoice_id,
                        'shipment_id'           =>  $id,
                        'total'                 =>  $shipment->amount,
                        'shipping_cost'         =>  $shipping_costs[$id],
                        'weight_fees'           =>  $weight_fees[$id],
                        'service_fees'          =>  $service_fees[$id],
                        'due_amount'            =>  0,
                        'comment'               =>  $comments[$id] ? $comments[$id] : '',
                    ]);
    
                  //  Shipment::where('id',$id)->update(['status_id'=>19]);
                }
             
                return redirect('invoices')->with('status', 'Success: invoice info updated!');
            }else{
                $data['error'] = 'Please select one shipment at least!';
            }

          
        }

        return view('invoice.form',$data);
    }

    public function print(Request $request){
        $data = array();
        $invoice = Invoice::where('id',$request->get('id'))->first();
        $shipments = InvoiceShipments::where('invoice_id',$request->get('id'))->get();
        $agent = Agent::where('id',$invoice->agent_id)->first();
        $data['agent'] = $agent;
        $data['invoice'] = $invoice;
        $data['shipments'] = $shipments;

        $data['total_lbp'] = 0;
        $data['total_usd'] = 0;
        $data['due_amount'] = 0;

        foreach($shipments as $shipment){
           
            if($shipment->Shipment->currency_id == "1"){
                $data['total_lbp'] = $data['total_lbp'] + $shipment->Shipment->amount;
              
            }else{
                $data['total_usd'] = $data['total_usd'] + $shipment->Shipment->amount;
            }
            $data['due_amount'] = $data['due_amount'] + ((double)$shipment->shipping_cost + (double)$shipment->weight_fees + (double)$shipment->service_fees);
        }
        $data['extra_fees'] = $invoice->extra_fees;
        $data['comment'] = $invoice->comment;

        $data['net_value'] = $data['total_lbp'] - ($data['due_amount']+  $data['extra_fees']);

        $data['total_usd'] =  '$ ' . number_format($data['total_usd'],2);
        $data['total_lbp'] =  number_format($data['total_lbp'],0) . ' L.L';
        $data['due_amount'] = number_format($data['due_amount'],0) . ' L.L';
        $data['net_value'] = number_format($data['net_value'],0) . ' L.L';
        $data['extra_fees'] = !empty($data['extra_fees']) ? number_format($data['extra_fees'],0) . ' L.L' : '';
        return view('invoice.print',$data);
    }

    public function pay(Request $request){
        $data = array();

        $invoice = Invoice::where('id',$request->get('id'))->first();
        $shipments = InvoiceShipments::where('invoice_id',$request->get('id'))->get();

        Invoice::where('id',$request->get('id'))->update(['status_id'=>2]);

        foreach($shipments as $shipment){
            Shipment::where('id',$shipment->Shipment->id)->update(['status_id'=>21]);
            DB::table('shipment_history')->insert([
                'user_id'       =>  Auth::id(),
                'shipment_id'   =>  $shipment->Shipment->id,
                'status_id'     =>  21,
                'comment'       =>  'Paid'
            ]);
        }

    }
    
    public function cancel(Request $request){
        $data = array();

        $invoice = Invoice::where('id',$request->get('id'))->first();
        $shipments = InvoiceShipments::where('invoice_id',$request->get('id'))->get();

        Invoice::where('id',$request->get('id'))->update(['status_id'=>3]);

        foreach($shipments as $shipment){
            Shipment::where('id',$shipment->Shipment->id)->update(['status_id'=>17]);
            DB::table('shipment_history')->insert([
                'user_id'       =>  Auth::id(),
                'shipment_id'   =>  $shipment->Shipment->id,
                'status_id'     =>  17,
                'comment'       =>  'Invoice Cancelled'
            ]);
        }

    }

    public function remove(Request $request){
        $data = array();

        $invoice = Invoice::where('id',$request->get('id'))->first();
        $shipments = InvoiceShipments::where('invoice_id',$request->get('id'))->get();


        foreach($shipments as $shipment){
            Shipment::where('id',$shipment->Shipment->id)->update(['status_id'=>17]);
            DB::table('shipment_history')->insert([
                'user_id'       =>  Auth::id(),
                'shipment_id'   =>  $shipment->Shipment->id,
                'status_id'     =>  17,
                'comment'       =>  'Invoice Cancelled'
            ]);
        }

        Invoice::where('id',$request->get('id'))->delete();
    }

    public function getShipment(Request $request){
        $shipment = Shipment::where('id',$request->get('id'))->orWhere('tracking_number',$request->get('id'))->first();

        $data = array();
        $data['id'] = $shipment->id;
        $data['tracking_number'] = $shipment->tracking_number;
        $data['service_type_name'] = $shipment->ServiceType->name;
        $data['coutry_flag_imoji'] = $shipment->ServiceType->countryFlagImoji;
        $data['customer_state'] = $shipment->customer_state;
        $data['customer_region'] = $shipment->customer_region;
        $data['customer_city'] = $shipment->customer_city;
        $data['customer_name'] = $shipment->customer_name;
        $data['customer_telephone'] = $shipment->customer_telephone;
        $data['currency_left_symbole'] = $shipment->Currency->left_symbole;
        $data['formatted_amount'] = $shipment->FormatedAmount;
        $data['currency_right_symbole'] = $shipment->Currency->right_symbole;

        $data['shipping_cost'] = $shipment->shipping_cos_col ? $shipment->shipping_cos_col : $shipment->ShippingCost;
        $data['weight_fees'] = $shipment->WeightFees;
        $data['service_fees'] = $shipment->ServiceFees;

        return $data;
    }
    

}
