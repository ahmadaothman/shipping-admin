<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

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
    }

   
    public function index()
    {
        return view('home');
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
