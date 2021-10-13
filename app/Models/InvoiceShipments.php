<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shipment;

class InvoiceShipments extends Model
{
    protected $table = 'invoice_shipments';

    public function getShipmentAttribute(){
        return Shipment::where('id',$this->shipment_id)->first();
    }
}
