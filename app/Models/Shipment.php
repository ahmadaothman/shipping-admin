<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Countries;
use App\Models\Agent;
use App\Models\Currency;
use App\Models\ShipmentStatus;
use App\Models\ServiceType;

ini_set('memory_limit','1024M');

class Shipment extends Model
{
    protected $table = 'shipment';


    public function getAgentAttribute()
    {

        $agent = Agent::where('id',$this->agent_id)->first();

        return $agent;
    }

    public function getcountryNameAttribute()
    {

        return Countries::where('cca2', $this->customer_country)->first()->name_en;
    }

    public function getcountryFlagImojiAttribute()
    {
         return Countries::where('cca2', $this->customer_country)->first()->flag->emoji;
    }

    public function getCurrencyAttribute()
    {
        $currency = Currency::where('id',$this->currency_id)->first();
 
        return $currency;
    }

    public function getFormatedAmountAttribute(){

        return number_format($this->amount,$this->Currency->decimal_number);
    }

    public function getStatusAttribute(){
        return  ShipmentStatus::where('id',$this->status_id)->first();
    }

    public function getServiceTypeAttribute(){
        return  ServiceType::where('id',$this->service_type_id)->first();
    }

    public function getShippingCostAttribute(){
        return  ServiceType::where('id',$this->service_type_id)->first();
    }

    public function getWeightFeesAttribute(){
        return  ServiceType::where('id',$this->service_type_id)->first();
    }

    public function getServiceFeesAttribute(){
        return  ServiceType::where('id',$this->service_type_id)->first();
    }///
}
