<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Expenses;
use App\Models\InvoiceShipments;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_driver');
    }

    public function revenue(Request $request){
        $data = array();
        $sql = "SELECT SUM(ins.shipping_cost) AS shipping_cost,SUM(ins.weight_fees) AS weight_fees,SUM(ins.service_fees) AS service_fees
        FROM invoice_shipments AS ins LEFT JOIN invoice AS i ON i.id=ins.invoice_id WHERE 1";

        if($request->get('filter_date')){
            $datas = explode(" - ", $request->get('filter_date')); 
            $sql .= " AND ins.created_at >='" . $datas[0] . "' AND ins.created_at <='" . $datas[1] . "'";
        }

        if($request->get('filter_invoice_status')){
            $sql .= " AND i.status_id IN (" . $request->get('filter_invoice_status') . ")";
        }else{
            $sql .= " AND i.status_id = 2";
        }

        $invoices_totals = DB::select($sql);
        $invoices_totals = $invoices_totals[0];

        $data['shipping_cost'] =  number_format($invoices_totals->shipping_cost);
        $data['weight_fees'] = number_format($invoices_totals->weight_fees);
        $data['service_fees'] = number_format($invoices_totals->service_fees);

        $sql = "SELECT SUM(i.extra_fees) as extra_fees FROM invoice i WHERE 1";

        if($request->get('filter_date')){
            $datas = explode(" - ", $request->get('filter_date')); 
            $sql .= " AND i.created_at >='" . $datas[0] . "' AND i.created_at <='" . $datas[1] . "'";
        }

        if($request->get('filter_invoice_status')){
            $sql .= " AND i.status_id IN (" . $request->get('filter_invoice_status') . ")";
        }else{
            $sql .= " AND i.status_id = 2";
        }

        $invoice =  DB::select($sql);
        $invoice = $invoice[0];

        $data['extra_fees'] = number_format($invoice->extra_fees);

        $data['income'] = $invoices_totals->shipping_cost + $invoices_totals->weight_fees + $invoices_totals->service_fees + $invoice->extra_fees;
        $data['expenses'] = 0;

        $sql = "SELECT SUM(amount) as sum_amount FROM expenses WHERE currency='lbp' AND `type`!=3";

        if($request->get('filter_date')){
            $datas = explode(" - ", $request->get('filter_date')); 
            $sql .= " AND created_at >='" . $datas[0] . "' AND created_at <='" . $datas[1] . "'";
        }

        $lbp_expenses = DB::select($sql);

        $lbp_expenses = $lbp_expenses[0];
        $data['expenses'] = $data['expenses'] + $lbp_expenses->sum_amount;
        $data['sum_lbp_expenses'] = number_format($lbp_expenses->sum_amount);
        

        $sql = "SELECT SUM(amount) as sum_amount FROM expenses WHERE currency='usd' AND `type`!=3";

        if($request->get('filter_date')){
            $datas = explode(" - ", $request->get('filter_date')); 
            $sql .= " AND created_at >='" . $datas[0] . "' AND created_at <='" . $datas[1] . "'";
        }

        $usd_expenses = DB::select($sql);

        $usd_expenses = $usd_expenses[0];
        $data['sum_usd_expenses'] = number_format($usd_expenses->sum_amount);

        $sql = "SELECT SUM(amount*currency_rate) as sum_amount FROM expenses WHERE currency='usd' AND `type`!=3";

        if($request->get('filter_date')){
            $datas = explode(" - ", $request->get('filter_date')); 
            $sql .= " AND created_at >='" . $datas[0] . "' AND created_at <='" . $datas[1] . "'";
        }

        $usd_to_lbp_expenses = DB::select($sql);

        $usd_to_lbp_expenses = $usd_to_lbp_expenses[0];

        $data['expenses'] = $data['expenses'] + $usd_to_lbp_expenses->sum_amount;

        $data['sum_usd_to_lbp_expenses'] = number_format($usd_to_lbp_expenses->sum_amount);

        return view('report.revenue',$data);


       // dd($data);
    }
}
