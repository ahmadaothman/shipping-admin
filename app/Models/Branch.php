<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Countries;
ini_set('memory_limit','2048M');

class Branch extends Model
{
    protected $table = 'branch';

    protected $fillable = [
        'id', 'name', 'country', 'city', 'address', 'telephone','created_at','updated_at'
    ];

 
    public function getcountryNameAttribute()
    {

        return Countries::where('cca2', $this->country)->first()->name_en;
    }

    public function getcountryFlagImojiAttribute()
    {

 
         return Countries::where('cca2', $this->country)->first()->flag->emoji;
    }

}
