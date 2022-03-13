<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_driver');
    }

    public function index(Request $request){
        $data = array();

        $data['max_weight'] = Setting::where('setting','max_weight')->first()->value;
        $data['extra_weight_fees'] = Setting::where('setting','cost_per_extra_weight')->first()->value;
        $data['pickup_from_customer_cost'] = Setting::where('setting','pickup_from_customer_cost')->first()->value;
        $data['message_text'] = Setting::where('setting','message_text')->first()->value;
        $data['email_text'] = Setting::where('setting','email_text')->first()->value;

        if($request->method() == 'POST'){
            Setting::where('setting','max_weight')->update(['value'=>$request->input('max_weight')]);
            Setting::where('setting','cost_per_extra_weight')->update(['value'=>$request->input('fees_per_extra_weight')]);
            Setting::where('setting','pickup_from_customer_cost')->update(['value'=>$request->input('pickup_from_shipper_cost')]);
            Setting::where('setting','message_text')->update(['value'=>$request->input('message_text')]);
            Setting::where('setting','email_text')->update(['value'=>$request->input('email_text')]);

            $data['max_weight'] = $request->input('max_weight');
            $data['extra_weight_fees'] = $request->input('fees_per_extra_weight');
            $data['pickup_from_customer_cost'] = $request->input('pickup_from_shipper_cost');
            $data['message_text'] = $request->input('message_text');
            $data['email_text'] = $request->input('email_text');
        }
        return view('setting.form',$data);

    }

}
