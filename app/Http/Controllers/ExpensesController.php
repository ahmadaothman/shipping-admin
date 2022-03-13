<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_driver');
    }

    public function expensesList(Request $request){
        $data = array();

        $expenses =  Expenses::orderBy('id');
  
        $data['expenses_types'] = array();

        $data['expenses_types'][1] = array(
            'id'    =>  1,
            'idd'    =>  1,
            'name'  => 'Internal'
        );

        $data['expenses_types'][2] = array(
            'id'    =>  2,
            'idd'    =>  2,
            'name'  => 'External'
        );

        $data['expenses_types'][3] = array(
            'id'    =>  3,
            'idd'    =>  3,
            'name'  => 'Assets'
        );


        if($request->get('filter_type')){
            $expenses->where('type', 'LIKE','%' . $request->get('filter_type') . '%');
        }

        if($request->get('filter_reference')){
            $expenses->where('reference', 'LIKE','%' . $request->get('filter_reference') . '%');
        }   

        if($request->get('filter_currency')){
            $expenses->where('currency', 'LIKE','%' . $request->get('filter_currency') . '%');
        } 

        if($request->get('filter_date') != null){
            $datas = explode(" - ", $request->get('filter_date')); 
            
           // $expenses->whereBetween('expense_date',[date('Y-m-d', strtotime($datas[0])),date('Y-m-d', strtotime($datas[1]))]);
            $from = date('Y-m-d', strtotime($datas[0]));
            $to = date('Y-m-d', strtotime($datas[1]));
         //   dd($from . ' - ' . $to);
            $expenses->whereRaw("expense_date >= '${from}' AND expense_date<='${to}'");
        }
        
        $expenses->skip(0)->take(2);
        
        $data['expenses'] = $expenses->paginate(30);

   
        return view("expenses.list",$data);
    }

    public function expensesForm(Request $request){
        $data = array();
 
        if($request->path() == 'expenses/add'){
            $data['action'] = route('addExpense');
        }else if($request->path() == 'expenses/edit'){
            $data['action'] = route('editExpense',['id'=>$request->get('id')]);
        }

        $data['expense_types'] = array();

        $data['expenses_types'][] = array(
            'id'    =>  1,
            'name'  => 'Internal'
        );

        $data['expenses_types'][] = array(
            'id'    =>  2,
            'name'  => 'External'
        );

        $data['expenses_types'][] = array(
            'id'    =>  3,
            'name'  => 'Assets'
        );
        
        switch ($request->method()) {
             case 'POST':
 
                $validation_data =  array();

            
                if($request->path() == 'expenses/add'){ // validation if add
                    $validation_data['description'] = 'required|min:3';
                    $validation_data['reference'] = 'required|min:3';
                    $validation_data['amount'] = 'required';
                    $validation_data['expense_date'] = 'required';
                }else{ // validation if edit
                    $validation_data['description'] = 'required|min:3';
                    $validation_data['reference'] = 'required|min:3';
                    $validation_data['amount'] = 'required';
                    $validation_data['expense_date'] = 'required';
                }

                $validated = $request->validate($validation_data);
 
                // inser/edit data
                $expense_data = [
                    'type'             =>  $request->input('type'),
                    'description'      =>  $request->input('description'),
                    'reference'        =>  $request->input('reference'),
                    'amount'           =>  $request->input('amount'),
                    'currency'         =>  $request->input('currency'),
                    'currency_rate'    =>  empty($request->input('currency_rate')) ? 1 : $request->input('currency_rate'),
                    'vat'              =>  $request->input('vat') ? $request->input('vat')  : 1,
                    'note'             =>  $request->input('note') ? $request->input('note') : '',
                    'expense_date'     =>  date("Y-m-d H:i:s", strtotime($request->input('expense_date'))),
                    'user_id'          => auth()->id(),
                ];  
                 
                
                try { 
                    if($request->path() == 'expenses/add'){
                        Expenses::insert($expense_data);
                    }else if($request->path() == 'expenses/edit'){
                    Expenses::where('id', $request->get('id'))
                        ->update($expense_data);
                    }
                    
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }
        
                if($request->path() == 'expenses/add'){
                    return redirect('expenses')->with('status', '<strong>Success:</strong> New expense added!');
                }else{
                    return redirect('expenses')->with('status', '<strong>Success:</strong> Expense info updated!');
                }
 
                break;
     
            case 'GET':
                if ($request->has('id')) {
                    $expense = Expenses::where('id',$request->id)->first();

                    $data['expense'] = $expense;
                }
                // do anything in 'get request';
                break;
    
            default:
                // invalid request
                break;
        }
 
        return view('expenses.form',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                Expenses::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }
        return redirect('expenses')->with('status', '<strong>Success:</strong> ' . $i . ' Expenses Removed!');
    }
}
