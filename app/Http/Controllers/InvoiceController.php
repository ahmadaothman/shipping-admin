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

        $invoices =  Invoice::orderBy('id');
  
        
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

            $shipments = Shipment::where('agent_id',$request->get('agent_id'))->get();

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

    }

    public function print(Request $request){
        $data = array();
        $invoice = Invoice::where('id',$request->get('id'))->first();
        $shipments = InvoiceShipments::where('invoice_id',$request->get('id'))->get();
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

        $data['total_usd'] =  '$ ' . number_format($data['total_usd'],2);
        $data['total_lbp'] =  number_format($data['total_lbp'],0) . ' L.L';
        $data['due_amount'] = number_format($data['due_amount'],0) . ' L.L';
        return view('invoice.print',$data);
    }
}
