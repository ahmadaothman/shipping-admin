<?php

namespace App\Imports;

use App\Models\Shipment;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;

class ShipmentImport implements ToCollection
{
   
    public $data;
    public function collection(Collection $rows)
    {
        
       $this->data =  $rows;
    }

  
}
