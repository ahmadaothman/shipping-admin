<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Agent;
use App\Models\InvoiceShipments;

class Invoice extends Model
{
    protected $table = 'invoice';

    public function getAgentAttribute(){
        return Agent::where('id',$this->agent_id)->first();
    }

    public function getTotalShipmentsAttribute(){
        return InvoiceShipments::where('invoice_id',$this->id)->count();
    }
}
