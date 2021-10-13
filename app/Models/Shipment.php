<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Countries;
use App\Models\Agent;
use App\Models\Currency;
use App\Models\ShipmentStatus;
use App\Models\ServiceType;
use App\Models\Region;
use App\Models\Setting;

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

        $region = Region::where('name','LIKE','%'.$this->customer_region.'%')->first();

        if($region){
            return $region->shipping_cost;
        }else{
            return 0;
        }
    }

    public function getWeightFeesAttribute(){
        $weight_setting = Setting::where('setting','max_weight')->first();
        if($this->weight > $weight_setting->value){
            $extra_weight_cost_setting = Setting::where('setting','cost_per_extra_weight')->first();
            return ((double)$this->weight - (double)$weight_setting->value)*(double)$extra_weight_cost_setting->value;
        }else{
            return 0;
        }
    }

    public function getServiceFeesAttribute(){
        $pickpu_cost = Setting::where('setting','pickup_from_customer_cost')->first();

        if($this->pickup_type == 'pickup_from_shipper'){
            return $pickpu_cost->value;
        }else{
            return 0;
        }
    }

}
