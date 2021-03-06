<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
ini_set('memory_limit','2048M');

class ShipmentStatus extends Model
{
    protected $table = 'shipment_status';

    public function getStatusGroupAttribute(){
        return DB::table('shipment_status_group')->where('id',$this->shipment_status_group_id)->first();
    }
}
