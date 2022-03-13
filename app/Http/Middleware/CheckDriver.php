<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckDriver
{

    public function handle(Request $request, Closure $next)
    {
        $type_id = auth()->user()->user_type_id;
       
        if($type_id == 7){
            return redirect()->route('driver');

        }else{
            return $next($request);
        }
        
    }

    protected function redirectTo($request){
        
    }
}
