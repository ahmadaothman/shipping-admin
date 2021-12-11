<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;

class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function expensesList(Request $request){
        $data = array();

        $expenses =  Expenses::orderBy('id');
  
        /*if($request->get('filter_name')){
            $expenses->where('name', 'LIKE','%' . $request->get('filter_name') . '%');
        }

        if($request->get('filter_country')){
            $expenses->where('country', 'LIKE','%' . $request->get('filter_country') . '%');
        }

        if($request->get('filter_city')){
            $expenses->where('city', 'LIKE','%' . $request->get('filter_city') . '%');
        }

        if($request->get('filter_address')){
            $expenses->where('address', 'LIKE','%' . $request->get('filter_address') . '%');
        }

        if($request->get('filter_telephone')){
            $expenses->where('telephone', 'LIKE','%' . $request->get('filter_telephone') . '%');
        }*/
        
        $expenses->skip(0)->take(2);
        
        $data['expenses'] = $expenses->paginate(30);

   
        return view("expenses.list",$data);
    }

    public function expensesForm(Request $request){

    }

    public function remove(Request $request){

    }
}
