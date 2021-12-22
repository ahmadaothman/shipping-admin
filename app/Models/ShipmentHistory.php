<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShipmentHistory extends Model
{
    protected $table = 'shipment_history';

    protected $appends = array('status');

    public function getStatusAttribute(){
        return  ShipmentStatus::where('id',$this->status_id)->first();
    }

 
}
