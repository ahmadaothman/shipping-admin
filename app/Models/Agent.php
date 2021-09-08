<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Countries;

class Agent extends Model
{
    protected $table = 'agent';

     
    public function getcountryNameAttribute()
    {

        return Countries::where('cca2', $this->country)->first()->name_en;
    }

    public function getcountryFlagImojiAttribute()
    {

 
         return Countries::where('cca2', $this->country)->first()->flag->emoji;
    }
}
